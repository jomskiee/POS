<?php

namespace App\Http\Controllers\Admin;

use App\Constants\RoleStatusConstant;
use App\Constants\UserStatusConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Admin;
use App\Models\Broker;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $admins = Admin::with('user')->get();
        $brokers = Broker::with('user')->get();

        // Get broker statistics using query scopes
        $deletedBrokers = Broker::onlyTrashed()->count();
        $deactivatedBrokers = Broker::deactivated()->count();
        $activeBrokers = Broker::active()->count();
        $totalBrokers = Broker::count();

        // Get admin statistics using query scopes
        $deactivatedAdmins = Admin::deactivated()->count();
        $activeAdmins = Admin::active()->count();
        $totalAdmins = Admin::count();

        $count = [
            'deletedBrokers' => $deletedBrokers,
            'deactivatedBrokers' => $deactivatedBrokers,
            'activeBrokers' => $activeBrokers,
            'totalBrokers' => $totalBrokers,
            'deactivatedAdmins' => $deactivatedAdmins,
            'activeAdmins' => $activeAdmins,
            'totalAdmins' => $totalAdmins
        ];

        return view('admin.users.index', compact('admins', 'brokers', 'count'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.users._form', [
            'action' => route('admin.users.store'),
            'user' => null,
            'profile' => null,
            'title' => 'Create New User',
            'description' => 'Add a new admin or broker to the system.'
        ]);
    }

    /**
     * @param $id
     *
     * @return View
     */
    public function edit($id): View
    {
        $user = User::findOrFail($id);
        $profile = $user->getProfile();

        return view('admin.users._form', [
            'action' => route('admin.users.update', $id),
            'user' => $user,
            'profile' => $profile,
            'title' => 'Edit User',
            'description' => 'Update user information and profile details.'
        ]);
    }

    // ============== CRUD Operations ============== //

    /**
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function store(UserRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'role' => $request->role,
            ];

            $profileData = [
                'name' => $request->name,
                'address' => $request->address,
            ];

            User::createUserWithRole($userData, $profileData);

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', ucfirst($request->role) . ' created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create user. Please try again.');
        }
    }


    /**
     * @param UserRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(UserRequest $request, $id): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);

            // Update user data
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            // Only update password if provided
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            // Update profile data
            $profileData = [
                'name' => $request->name,
                'address' => $request->address,
            ];

            $user->updateProfile($profileData);

            DB::commit();

            // Redirect to appropriate tab based on user role
            $redirectUrl = route('admin.users.index');
            if ($user->role === RoleStatusConstant::BROKER) {
                $redirectUrl .= '?tab=brokers';
            } else {
                $redirectUrl .= '?tab=admins';
            }

            return redirect($redirectUrl)
                ->with('success', 'User updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update user. Please try again.');
        }
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function activate($id): RedirectResponse
    {
        try {
            $user = User::findOrFail($id);

            $user->updateStatus(UserStatusConstant::ACTIVE);

            return redirect()->back()
                ->with('success', 'User activated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to activate user. Please try again.');
        }
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function deactivate($id): RedirectResponse
    {
        try {
            $user = User::findOrFail($id);

            // Prevent admin from deactivating themselves
            if ($user->id === Auth::id()) {
                return redirect()->back()->with('error', 'You cannot deactivate your own account.');
            }
            $user->updateStatus(UserStatusConstant::DEACTIVATED);

            return redirect()->back()
                ->with('success', 'User deactivated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to deactivate user. Please try again.');
        }
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail($id);
            $user->deleteProfile();
            DB::commit();
            return redirect()->back()
                ->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to deactivate user. Please try again.');
        }
    }
}
