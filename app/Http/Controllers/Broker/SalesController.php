<?php

namespace App\Http\Controllers\Broker;

use App\Constants\FishBoxStatusConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\SalesRequest;
use App\Http\Requests\SalesPaymentRequest;
use App\Models\Sales;
use App\Models\SalesDetails;
use App\Models\SalesPayment;
use App\Models\FishBox;
use App\Constants\SalesStatusConstant;
use App\Models\Broker;
use App\Models\InventoryLog;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SalesController extends Controller
{

    public function getDashboardData(): array
    {
        $userId = Auth::id();
        $brokerId = Broker::getBrokerIdByUserId($userId);

        $salesToday = Sales::getTotalSalesToday($brokerId);
        $salesBalance = Sales::getTotalSalesBalance($brokerId);
        $ordersToday = Sales::getTotalOrdersToday($brokerId);
        $paidAmountToday = Sales::getTotalPaidAmountToday($brokerId);
        $paidAmountYesterday = Sales::getTotalPaidAmountYesterday($brokerId);

        $totalFishBoxes = FishBox::getTotalFishBoxes($brokerId);

        if ($paidAmountYesterday > 0) {
            $growthPercent = (($paidAmountToday - $paidAmountYesterday) / $paidAmountYesterday) * 100;
        } else {
            $growthPercent = 0; // or handle differently if yesterday was 0
        }

        $paidAmountGrowthPercent = round($growthPercent, 2) . '%';

        $recentSales = Sales::getRecentSales(4, $brokerId);
        $dailySalesData = Sales::getDailySalesLast7Days($brokerId);

        return compact('ordersToday', 'salesToday', 'salesBalance', 'recentSales', 'paidAmountGrowthPercent', 'totalFishBoxes', 'dailySalesData');
    }

    /**
     * Get data for sales index
     *
     * @param Request $request
     * @return array
     */
    public function getIndexData(Request $request): array
    {
        $search = $request->get('search');
        $status = $request->get('status');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $userId = Auth::id();
        $brokerId = Broker::getBrokerIdByUserId($userId);

        $sales = Sales::getPaginatedWithFilters($search, $status, $brokerId, $dateFrom, $dateTo);
        $fishBoxes = FishBox::getAvailableForSale();
        $editingSales = null;
        $viewingSales = null;

        $salesStatuses = SalesStatusConstant::getAllStatuses();
        $salesStatusesWithDisplayNames = collect($salesStatuses)->mapWithKeys(function ($status) {
            return [$status => SalesStatusConstant::getDisplayName($status)];
        });
        $salesStatusesWithColorClasses = collect($salesStatuses)->mapWithKeys(function ($status) {
            return [$status => SalesStatusConstant::getStatusColorClasses($status)];
        });


        // Check if we're in edit mode
        if ($request->get('modal') === 'edit' && $request->has('edit')) {
            $editingSales = Sales::with(['salesDetails.fishBox.fishType', 'salesPayments'])->find($request->get('edit'));

            // Check if the sales record exists and belongs to the current broker
            if ($editingSales) {
                $userId = Auth::id();
                $brokerId = Broker::getBrokerIdByUserId($userId);

                if ($editingSales->broker_id !== $brokerId) {
                    $editingSales = null; // Reset to null if not authorized
                }
            }

            // For editing, include the fish boxes that are already selected in the sales details
            if ($editingSales && $editingSales->salesDetails->count() > 0) {
                $selectedBoxIds = $editingSales->salesDetails->pluck('box_id')->toArray();
                $selectedFishBoxes = FishBox::with('fishType')->whereIn('id', $selectedBoxIds)->get();
                $fishBoxes = $fishBoxes->merge($selectedFishBoxes)->unique('id');
            }
        }

        // Check if we're in show mode
        if ($request->get('modal') === 'show' && $request->has('show')) {
            $viewingSales = Sales::with(['salesDetails.fishBox.fishType', 'salesPayments'])->find($request->get('show'));

            // Check if the sales record exists and belongs to the current broker
            if ($viewingSales) {
                $userId = Auth::id();
                $brokerId = Broker::getBrokerIdByUserId($userId);

                if ($viewingSales->broker_id !== $brokerId) {
                    $viewingSales = null; // Reset to null if not authorized
                }
            }
        }

        return compact('sales',
            'fishBoxes', 'editingSales',
            'viewingSales', 'salesStatuses',
            'salesStatusesWithDisplayNames', 'salesStatusesWithColorClasses'
        );
    }

    /**
     * Store a newly created sale.
     *
     * @param SalesRequest $request
     * @return RedirectResponse
     */
    public function store(SalesRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $userId = Auth::id();
        $brokerId = Broker::getBrokerIdByUserId($userId);


        DB::transaction(function () use ($validated, $brokerId, $userId) {
            // Create the sale
            $sale = Sales::create([
                'sales_date' => $validated['sales_date'],
                'broker_id' => $brokerId,
                'total_amount' => $validated['total_amount'],
                'buyer_name' => $validated['buyer_name'],
                'buyer_contact' => $validated['buyer_contact'],
                'remarks' => $validated['remarks'] ?? null,
                'details' => $validated['details'] ?? null,
                'status' => SalesStatusConstant::ACTIVE
            ]);

            // Create sales details
            if (isset($validated['sales_details']) && is_array($validated['sales_details'])) {
                foreach ($validated['sales_details'] as $detail) {
                    SalesDetails::create([
                        'sales_id' => $sale->id,
                        'broker_id' => $brokerId,
                        'box_id' => $detail['box_id'],
                        'item' => $detail['item'],
                        'item_description' => $detail['item_description'] ?? null
                    ]);

                    FishBox::updateBrokerAndStatus($detail['box_id'], $brokerId, FishBoxStatusConstant::SOLD, $userId);
                }
            }
        });

        return redirect()->route('broker.sales.sales')
            ->with('success', 'Sale created successfully!');
    }

    /**
     * Update the specified sale.
     *
     * @param SalesRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(SalesRequest $request, $id): RedirectResponse
    {
        $sale = Sales::findOrFail($id);
        $validated = $request->validated();
        $userId = Auth::id();
        $brokerId = Broker::getBrokerIdByUserId($userId);

        // Check if the sale belongs to the current broker
        if ($sale->broker_id !== $brokerId) {
            return redirect()->route('broker.sales.sales')
                ->with('error', 'You are not authorized to update this sale.');
        }

        DB::transaction(function () use ($sale, $validated, $brokerId) {
            // Update the sale
            $sale->update([
                'sales_date' => $validated['sales_date'],
                'total_amount' => $validated['total_amount'],
                'buyer_name' => $validated['buyer_name'],
                'buyer_contact' => $validated['buyer_contact'],
                'remarks' => $validated['remarks'] ?? null,
                'details' => $validated['details'] ?? null,
            ]);

            // Get old sales details before deleting
            $oldSalesDetails = $sale->salesDetails;
            $userId = Auth::user()->id;

            // Reset fish boxes back to IN_STOCK status for old sales details
            foreach ($oldSalesDetails as $detail) {
                FishBox::updateBrokerAndStatus($detail->box_id, null, FishBoxStatusConstant::IN_STOCK, $userId);
                InventoryLog::deleteLogForFishBox($detail->box_id, $userId, $sale->created_at);
            }

            // Update sales details - delete existing and create new ones
            $sale->salesDetails()->delete();

            if (isset($validated['sales_details']) && is_array($validated['sales_details'])) {
                foreach ($validated['sales_details'] as $detail) {
                    SalesDetails::create([
                        'sales_id' => $sale->id,
                        'broker_id' => $brokerId,
                        'box_id' => $detail['box_id'],
                        'item' => $detail['item'],
                        'item_description' => $detail['item_description'] ?? null
                    ]);

                    FishBox::updateBrokerAndStatus($detail['box_id'], $brokerId, FishBoxStatusConstant::SOLD, $userId);
                }
            }

            // Recalculate paid amount and update status
            $sale->updatePaidAmount();
            $sale->updatePaymentStatus();
        });

        return redirect()->route('broker.sales.sales')
            ->with('success', 'Sale updated successfully!');
    }

    /**
     * Remove the specified sale.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $sale = Sales::findOrFail($id);
        $userId = Auth::id();
        $brokerId = Broker::getBrokerIdByUserId($userId);

        // Check if the sale belongs to the current broker
        if ($sale->broker_id !== $brokerId) {
            return redirect()->route('broker.sales.sales')
                ->with('error', 'You are not authorized to delete this sale.');
        }

        DB::transaction(function () use ($sale, $brokerId) {
            // Get sales details before deleting
            $salesDetails = $sale->salesDetails;
            $userId = Auth::user()->id;

            // Reset fish boxes back to IN_STOCK status
            foreach ($salesDetails as $detail) {
                FishBox::updateBrokerAndStatus($detail->box_id, null, FishBoxStatusConstant::IN_STOCK, $userId);
                InventoryLog::deleteLogForFishBox($detail->box_id, $userId, $sale->created_at);
            }

            $broker = Broker::where('user_id', $userId)->first();
            $broker->minusFromBalance($sale->paid_amount);

            $sale->deleteSales();
        });

        return redirect()->route('broker.sales.sales')
            ->with('success', 'Sale deleted successfully!');
    }

    /**
     * Store a newly created sales payment.
     *
     * @param SalesPaymentRequest $request
     * @return RedirectResponse
     */
    public function storePayment(SalesPaymentRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $userId = Auth::id();
        $brokerId = Broker::getBrokerIdByUserId($userId);

        DB::transaction(function () use ($validated, $brokerId, $userId) {
            // Create the payment
            $payment = SalesPayment::create([
                'sales_id' => $validated['sales_id'],
                'broker_id' => $brokerId,
                'paid_amount' => $validated['paid_amount'],
                'payment_date' => $validated['payment_date'],
                'payment_method' => $validated['payment_method'],
                'status' => 'Active'
            ]);

            // Update the sales paid amount and status
            $sale = Sales::findOrFail($validated['sales_id']);
            $sale->updatePaidAmount();
            $sale->updatePaymentStatus();

            $broker = Broker::where('user_id', $userId)->first();
            $broker->addToBalance($sale->paid_amount);
        });

        return redirect()->route('broker.sales.sales')
            ->with('success', 'Payment recorded successfully!');
    }

    /**
     * Remove the specified sales payment.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroyPayment($id): RedirectResponse
    {
        $payment = SalesPayment::findOrFail($id);
        $userId = Auth::id();
        $brokerId = Broker::getBrokerIdByUserId($userId);

        // Check if the payment belongs to the current broker
        if ($payment->broker_id !== $brokerId) {
            return redirect()->route('broker.sales.sales')
                ->with('error', 'You are not authorized to delete this payment.');
        }

        DB::transaction(function () use ($payment, $userId) {
            $sale = $payment->sales;
            $payment->delete();

            // Update the sales paid amount and status
            $sale->updatePaidAmount();
            $sale->updatePaymentStatus();

            $broker = Broker::where('user_id', $userId)->first();
            $broker->addToBalance($sale->paid_amount);
        });

        return redirect()->route('broker.sales.sales')
            ->with('success', 'Payment deleted successfully!');
    }

    /**
     * Get available fish boxes for sales details
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvailableFishBoxes(Request $request)
    {
        $fishBoxes = FishBox::getAvailableForSale();

        return response()->json($fishBoxes);
    }
}
