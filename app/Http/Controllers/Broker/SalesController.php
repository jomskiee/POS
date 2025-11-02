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
use App\Models\FishType;
use App\Constants\SalesStatusConstant;
use App\Models\Broker;
use App\Models\InventoryLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SalesController extends Controller
{

    public function getDashboardData(): array
    {
        $userId = Auth::id();
        $brokerId = Broker::getBrokerIdByUserId($userId);

        $salesToday = SalesPayment::getTotalSalesToday($brokerId);
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

        // Get top selling items without date filter (use a very wide date range)
        $allTimeStart = '2020-01-01'; // Use a very early date
        $allTimeEnd = Carbon::now()->format('Y-m-d');
        $topItems = Sales::getTopSellingItems($brokerId, $allTimeStart, $allTimeEnd, 5, null);

        // Get weekly sales data for this month only
        $thisMonthStart = Carbon::now()->startOfMonth()->format('Y-m-d');
        $thisMonthEnd = Carbon::now()->format('Y-m-d');
        $weeklySalesData = Sales::getDailySalesForPeriod($brokerId, $thisMonthStart, $thisMonthEnd, null);

        return compact('ordersToday', 'salesToday', 'salesBalance',
            'recentSales', 'paidAmountGrowthPercent', 'totalFishBoxes',
            'dailySalesData', 'topItems', 'weeklySalesData');
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
        $fishBoxes = FishBox::getAvailableForSale($brokerId);
        $allFishTypes = FishType::getFishTypeByBrokerId($brokerId);

        // Filter fish types to only show those with available fish boxes in both create and edit modes
        $availableFishTypeIds = $fishBoxes->pluck('fish_type_id')->unique()->filter()->toArray();
        $fishTypes = $allFishTypes->whereIn('id', $availableFishTypeIds);

        $salesStatuses = SalesStatusConstant::getAllStatuses();
        $salesStatusesWithDisplayNames = collect($salesStatuses)->mapWithKeys(function ($status) {
            return [$status => SalesStatusConstant::getDisplayName($status)];
        });
        $salesStatusesWithColorClasses = collect($salesStatuses)->mapWithKeys(function ($status) {
            return [$status => SalesStatusConstant::getStatusColorClasses($status)];
        });

        // Initialize variables
        $editingSales = null;
        $viewingSales = null;
        $saleForPayment = null;
        $printingSales = null;

        // Handle modal-specific sales retrieval
        $editingSales = $this->getModalSales($request, 'edit', 'edit', ['salesDetails', 'salesPayments']);
        $viewingSales = $this->getModalSales($request, 'show', 'show', ['salesDetails', 'salesPayments']);
        $saleForPayment = $this->getModalSales($request, 'payment', 'sale');
        $printingSales = $this->getModalSales($request, 'print', 'print', ['salesDetails', 'salesPayments', 'broker.user', 'broker']);
        // Handle fish boxes for editing mode - only include truly available fish boxes
        if ($editingSales) {
            $fishBoxes = $this->prepareFishBoxesForEdit($fishBoxes, $editingSales);
            $fishTypes = $this->prepareFishTypeForEdit($fishTypes, $editingSales);
        }

        // Prepare sales details for the form
        $salesDetails = $this->prepareSalesDetailsForForm($request, $editingSales);

        return compact('sales',
            'fishBoxes', 'fishTypes', 'editingSales',
            'viewingSales', 'salesStatuses',
            'salesStatusesWithDisplayNames', 'salesStatusesWithColorClasses',
            'saleForPayment', 'printingSales', 'salesDetails'
        );
    }


    public function getAnalyticsData(Request $request): array
    {
        $userId = Auth::id();
        $brokerId = Broker::getBrokerIdByUserId($userId);

        // Get date filters from request, default to 1st of current month to today
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));
        $status = $request->get('status');

        // Get analytics data
        $analyticsData = Sales::getAnalyticsData($brokerId, $dateFrom, $dateTo, $status);

        // Get paginated sales for the period
        $sales = Sales::getPaginatedWithFilters(
            null,
            $request->get('status'),
            $brokerId,
            $dateFrom,
            $dateTo
        );

        // Get total fish boxes for the broker
        $totalFishBoxes = FishBox::getTotalFishBoxes($brokerId);

        return array_merge($analyticsData, [
            'sales' => $sales,
            'totalFishBoxes' => $totalFishBoxes,
            'status' => $request->get('status')
        ]);
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


        // Prepare sales data
        $salesData = [
            'sales_date' => $validated['sales_date'],
            'total_amount' => $validated['total_amount'],
            'buyer_name' => $validated['buyer_name'],
            'buyer_contact' => $validated['buyer_contact'] ?? null,
            'remarks' => $validated['remarks'] ?? null,
            'details' => $validated['details'] ?? null,
        ];

        $salesDetails = $validated['sales_details'] ?? [];

        // Create sales with details using the model method
        Sales::createSalesWithDetails($salesData, $salesDetails, $brokerId);

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

        // Prepare sales data
        $salesData = [
            'sales_date' => $validated['sales_date'],
            'total_amount' => $validated['total_amount'],
            'buyer_name' => $validated['buyer_name'],
            'buyer_contact' => $validated['buyer_contact'] ?? null,
            'remarks' => $validated['remarks'] ?? null,
            'details' => $validated['details'] ?? null,
        ];

        $salesDetails = $validated['sales_details'] ?? [];

        // Update sales with details using the model method
        Sales::updateSalesWithDetails($sale, $salesData, $salesDetails, $brokerId);

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
                $boxIds = $detail->box_id;

                foreach ($boxIds as $boxId) {

                    FishBox::updateStatus((int) $boxId, FishBoxStatusConstant::IN_STOCK, $userId);
                    InventoryLog::deleteLogForFishBox((int) $boxId, $sale->created_at);
                }
            }

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

        DB::transaction(function () use ($payment) {
            $sale = $payment->sales;

            $payment->delete();

             // Update the sales paid amount and status
             $sale->updatePaidAmount();
             $sale->updatePaymentStatus();
        });

        return redirect()->route('broker.sales.sales')
            ->with('success', 'Payment deleted successfully!');
    }

    /**
     * Get available fish boxes for sales details
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getAvailableFishBoxes(Request $request): JsonResponse
    {
        $userId = Auth::id();
        $brokerId = Broker::getBrokerIdByUserId($userId);
        $fishBoxes = FishBox::getAvailableForSale($brokerId);

        return response()->json($fishBoxes);
    }

    /**
     * Get fish box by QR code for sales
     *
     * @param string $qrCode
     * @return JsonResponse
     */
    public function getFishBoxByQRCode(string $qrCode): JsonResponse
    {
        try {
            // Get broker ID for the current user
            $brokerId = Broker::getBrokerIdByUserId(Auth::id());
            $fishBox = FishBox::getFishBoxByQrCode($qrCode, $brokerId);

            if (!$fishBox) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fish box not found'
                ], 404);
            }

            // Check if fish box is available for sale
            if ($fishBox->status !== FishBoxStatusConstant::IN_STOCK) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fish box is not available for sale'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $fishBox->id,
                    'name' => $fishBox->name,
                    'qr_code' => $fishBox->qr_code,
                    'fish_type_id' => $fishBox->fish_type_id,
                    'fish_type' => $fishBox->fishType->name,
                    'status' => $fishBox->status
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving fish box details'
            ], 500);
        }
    }

    /**
     * Get sales record for modal operations with authorization check
     *
     * @param Request $request
     * @param string $modalType
     * @param string $paramName
     * @param array $withRelations
     * @return Sales|null
     */
    private function getModalSales(Request $request, string $modalType, string $paramName, array $withRelations = []): ?Sales
    {
        if ($request->get('modal') !== $modalType || !$request->has($paramName)) {
            return null;
        }

        $salesId = $request->get($paramName);
        $query = Sales::query();

        if (!empty($withRelations)) {
            $query->with($withRelations);
        }

        $sales = $query->find($salesId);

        if (!$sales) {
            return null;
        }

        return $this->authorizeSalesAccess($sales) ? $sales : null;
    }

    /**
     * Check if the current broker has access to the sales record
     *
     * @param Sales $sales
     * @return bool
     */
    private function authorizeSalesAccess(Sales $sales): bool
    {
        $userId = Auth::id();
        $brokerId = Broker::getBrokerIdByUserId($userId);

        return $sales->broker_id === $brokerId;
    }

    /**
     * Prepare fish boxes for editing mode by including already selected boxes
     *
     * @param \Illuminate\Database\Eloquent\Collection $fishBoxes
     * @param Sales|null $editingSales
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function prepareFishBoxesForEdit($fishBoxes, ?Sales $editingSales)
    {
        if (!$editingSales || $editingSales->salesDetails->count() === 0) {
            return $fishBoxes;
        }

        $selectedBoxIds = $editingSales->salesDetails->pluck('box_id')->flatten()->unique()->toArray();
        $selectedFishBoxes = FishBox::with('fishType')->whereIn('id', $selectedBoxIds)->get();
        return $selectedFishBoxes->merge($fishBoxes)->unique('id');
    }

    /**
     * Prepare fish types for editing mode by including already selected boxes
     *
     * @param \Illuminate\Database\Eloquent\Collection $fishTypes
     * @param Sales|null $editingSales
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function prepareFishTypeForEdit($fishTypes, ?Sales $editingSales)
    {
        $selectedBoxIds = $editingSales->salesDetails->pluck('box_id')->flatten()->unique()->toArray();
        $selectedFishBoxes = FishBox::whereIn('id', $selectedBoxIds)->get();

        // Get fish type IDs from selected fish boxes
        $selectedFishTypeIds = $selectedFishBoxes->pluck('fish_type_id')->filter()->unique()->toArray();

        // Get fish types using the fish_type_id from selected fish boxes
        $selectedFishTypes = FishType::whereIn('id', $selectedFishTypeIds)->get();

        // Merge with existing fish types and remove duplicates
        return $fishTypes->merge($selectedFishTypes)->unique('id');
    }

    /**
     * Prepare sales details for form display
     *
     * @param Request $request
     * @param Sales|null $editingSales
     * @return array
     */
    private function prepareSalesDetailsForForm(Request $request, ?Sales $editingSales): array
    {
        if ($request->get('modal') === 'edit' && $editingSales) {
            // Return all sales details without grouping
            return $editingSales->salesDetails->map(function($detail) {
                // Get fish type ID from the first fish box
                $fishTypeId = '';
                if (is_array($detail->box_id) && !empty($detail->box_id)) {
                    $firstFishBox = FishBox::find($detail->box_id[0]);
                    $fishTypeId = $firstFishBox ? (string)$firstFishBox->fish_type_id : '';
                }

                return [
                    'box_id' => $detail->box_id ?? [], // box_id is now a JSON array
                    'fish_type_id' => $fishTypeId,
                    'item' => $detail->item,
                    'item_description' => $detail->item_description ?? '',
                    'unit_price' => $detail->unit_price ?? '',
                    'quantity' => $detail->quantity ?? 1,
                    'sub_total' => $detail->sub_total ?? '',
                ];
            })->toArray();
        }

        return old('sales_details') ?: [
            [
                'box_id' => [],
                'fish_type_id' => '',
                'item' => '',
                'item_description' => '',
                'unit_price' => '',
                'quantity' => '1',
                'sub_total' => ''
            ]
        ];
    }
}
