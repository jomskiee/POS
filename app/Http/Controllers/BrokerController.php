<?php

namespace App\Http\Controllers;

use App\Models\Broker;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrokerController extends Controller
{
    /**
     * Display a listing of brokers.
     */
    public function index(Request $request)
    {
        $query = Broker::with('user');

        // Filter by balance if requested
        if ($request->has('min_balance')) {
            $query->where('account_balance', '>=', $request->min_balance);
        }

        if ($request->has('max_balance')) {
            $query->where('account_balance', '<=', $request->max_balance);
        }

        // Search by name
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Sort options
        $sortBy = $request->get('sort_by', 'account_balance');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if (in_array($sortBy, ['name', 'account_balance', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $brokers = $query->paginate(15);

        return response()->json([
            'brokers' => $brokers,
            'summary' => [
                'total_brokers' => Broker::count(),
                'total_balance' => Broker::sum('account_balance'),
                'average_balance' => Broker::avg('account_balance'),
                'brokers_with_positive_balance' => Broker::withPositiveBalance()->count(),
            ]
        ]);
    }

    /**
     * Store a newly created broker.
     */
    public function store(UserRequest $request)
    {
        DB::beginTransaction();
        
        try {
            // Create user first
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'broker',
                'address' => $request->address,
            ]);

            // Create broker record
            $broker = Broker::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'account_balance' => $request->get('account_balance', 0.00),
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Broker created successfully',
                'broker' => $broker->load('user')
            ], 201);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Failed to create broker',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified broker.
     */
    public function show(Broker $broker)
    {
        return response()->json([
            'broker' => $broker->load('user'),
            'formatted_balance' => $broker->formatted_balance,
        ]);
    }

    /**
     * Update the specified broker.
     */
    public function update(UserRequest $request, Broker $broker)
    {
        DB::beginTransaction();
        
        try {
            // Update user information
            $broker->user->update([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
            ]);

            // Update password if provided
            if ($request->filled('password')) {
                $broker->user->update([
                    'password' => bcrypt($request->password)
                ]);
            }

            // Update broker information
            $broker->update([
                'name' => $request->name,
                'account_balance' => $request->get('account_balance', $broker->account_balance),
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Broker updated successfully',
                'broker' => $broker->fresh()->load('user')
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Failed to update broker',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified broker.
     */
    public function destroy(Broker $broker)
    {
        DB::beginTransaction();
        
        try {
            $user = $broker->user;
            $broker->delete();
            $user->delete();

            DB::commit();

            return response()->json([
                'message' => 'Broker deleted successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Failed to delete broker',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add to broker's account balance based on sales.
     */
    public function addSales(Request $request, Broker $broker)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
        ]);

        $broker->addToBalance($request->amount);

        return response()->json([
            'message' => 'Sales amount added successfully',
            'broker' => $broker->fresh(),
            'new_balance' => $broker->fresh()->formatted_balance,
        ]);
    }

    /**
     * Get brokers by user.
     */
    public function byUser(User $user)
    {
        $brokers = $user->brokers()->get();

        return response()->json([
            'user' => $user,
            'brokers' => $brokers,
            'total_balance' => $user->getTotalBrokerBalance(),
        ]);
    }

    /**
     * Get broker statistics.
     */
    public function statistics()
    {
        $stats = [
            'total_brokers' => Broker::count(),
            'total_balance' => Broker::sum('account_balance'),
            'average_balance' => Broker::avg('account_balance'),
            'median_balance' => $this->getMedianBalance(),
            'brokers_with_positive_balance' => Broker::withPositiveBalance()->count(),
            'brokers_with_zero_balance' => Broker::where('account_balance', 0)->count(),
            'top_brokers' => Broker::orderBy('account_balance', 'desc')
                                  ->limit(5)
                                  ->with('user')
                                  ->get(),
            'recent_brokers' => Broker::orderBy('created_at', 'desc')
                                     ->limit(5)
                                     ->with('user')
                                     ->get(),
        ];

        return response()->json($stats);
    }

    /**
     * Calculate median balance.
     */
    private function getMedianBalance()
    {
        $balances = Broker::pluck('account_balance')->sort()->values();
        $count = $balances->count();
        
        if ($count === 0) {
            return 0;
        }
        
        if ($count % 2 === 0) {
            return ($balances[$count / 2 - 1] + $balances[$count / 2]) / 2;
        } else {
            return $balances[floor($count / 2)];
        }
    }
}