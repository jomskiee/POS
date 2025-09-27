<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Broker\SalesController;
use App\Models\FishBox;
use App\Models\Broker;
use App\Models\FishType;
use App\Constants\FishBoxStatusConstant;
use App\Models\Sales;
use App\Models\InventoryLog;
use App\Repositories\SalesRepository;
use App\Repositories\InventoryRepository;
use App\Models\SalesPayment;
use App\Constants\SalesStatusConstant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class SalesManagementController extends Controller
{
    protected $salesRepository;
    protected $inventoryRepository;

    public function __construct(SalesRepository $salesRepository, InventoryRepository $inventoryRepository)
    {
        $this->salesRepository = $salesRepository;
        $this->inventoryRepository = $inventoryRepository;
    }

    /**
     * @param Request $request
     *
     * @return View
     */
    public function index(Request $request):View
    {
        $tab = $request->get('tab', 'analysis'); // Default to analysis tab

        switch ($tab) {
            case 'analysis':
                $data = $this->getAnalysisData($request);
                break;

            case 'transactions':
                $data = $this->getTransactionsData($request);
                break;

            default:
                $data = $this->getAnalysisData($request);
                break;
        }

        $data['currentTab'] = $tab;

        return view('admin.sales.index', $data);
    }


    /**
     * @param Request $request
     *
     * @return array
     */
    private function getAnalysisData(Request $request): array
    {
        // Get date filters from request, default to 1st of current month to today
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));
        $status = $request->get('status');

        // Get total brokers count
        $totalBrokers = Broker::count();

        // Get total fish boxes sold
        $totalFishBoxesSold = FishBox::sold()->count();

        // Get fish types for filter dropdown
        $fishTypes = FishType::all();

        // Get sales data from repository and model with filters
        $totalRevenue = $this->salesRepository->getTotalRevenueForAdmin($dateFrom, $dateTo, $status);
        $totalOrders = $this->salesRepository->getTotalOrdersForAdmin($dateFrom, $dateTo, $status);
        $recentOrders = $this->salesRepository->getRecentOrdersForAdmin($dateFrom, $dateTo, $status);
        $topBrokers = $this->salesRepository->getTopBrokersForAdmin($dateFrom, $dateTo, $status);
        $topFishTypes = InventoryLog::getTopFishTypesSoldForAdmin($dateFrom, $dateTo, $status);
        $dailySalesData = $this->salesRepository->getDailySalesDataForAdmin($dateFrom, $dateTo, $status);
        $paymentMethods = $this->getPaymentMethods($dateFrom, $dateTo, $status);

        // Add status options for dropdown
        $salesStatuses = SalesStatusConstant::getAllActiveStatuses();
        $statusOptions = collect($salesStatuses)->mapWithKeys(function ($status) {
            return [$status => SalesStatusConstant::getDisplayName($status)];
        });

        // Get sales status breakdown data
        $salesStatusBreakdown = $this->salesRepository->getSalesStatusBreakdown($dateFrom, $dateTo, $status);

        // Get payment conversion analysis data
        $paymentConversionData = $this->salesRepository->getPaymentConversionData($dateFrom, $dateTo);

        // Get inventory analysis data
        $inventoryAnalysisData = $this->inventoryRepository->getInventoryAnalysisData();

        return compact(
            'totalBrokers',
            'totalFishBoxesSold',
            'fishTypes',
            'totalRevenue',
            'totalOrders',
            'recentOrders',
            'topBrokers',
            'topFishTypes',
            'dailySalesData',
            'paymentMethods',
            'dateFrom',
            'dateTo',
            'status',
            'statusOptions',
            'salesStatusBreakdown',
            'paymentConversionData',
            'inventoryAnalysisData'
        );
    }

    public function analytics(Request $request)
    {
        $salesController = new SalesController();
        $data = $salesController->getAnalyticsData($request);
        return view('broker.sales.analytics', $data);
    }

    public function sales(Request $request)
    {
        $salesController = new SalesController();
        $data = $salesController->getIndexData($request);
        return view('broker.sales.sales', $data);
    }

    /**
     * @param mixed $dateFrom
     * @param mixed $dateTo
     * @param mixed $status
     *
     * @return Collection
     */
    private function getPaymentMethods($dateFrom, $dateTo, $status): Collection
    {
        $payments = SalesPayment::getPaymentMethodsBreakdown(null, $dateFrom, $dateTo, $status);

        $colors = ['bg-green-500', 'bg-blue-500', 'bg-purple-500', 'bg-orange-500', 'bg-red-500'];

        return $payments->map(function ($payment, $index) use ($colors) {
            return [
                'name' => $payment['name'],
                'transactions' => $payment['transactions'],
                'amount' => $payment['amount'],
                'percentage' => $payment['percentage'],
                'color' => $colors[$index % count($colors)]
            ];
        });
    }


    /**
     * @param Request $request
     *
     * @return array
     */
    private function getTransactionsData(Request $request): array
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));
        $status = $request->get('status');
        $search = $request->get('search');

        // Use admin-specific method for paginated transactions (includes broker search)
        $transactions = $this->salesRepository->getPaginatedWithFiltersForAdmin($search, $status, null, $dateFrom, $dateTo);
        $transactions->appends($request->query()); // Preserve query parameters

        // Get summary data using repository methods with search functionality
        $totalRevenue = $this->salesRepository->getTotalRevenueForAdminWithSearch($dateFrom, $dateTo, $status, $search);
        $totalTransactions = $this->salesRepository->getTotalOrdersForAdminWithSearch($dateFrom, $dateTo, $status, $search);

        // Get status-specific counts with search functionality
        $pendingCount = $this->salesRepository->getTotalOrdersForAdminWithSearch($dateFrom, $dateTo, 'Active', $search);
        $paidCount = $this->salesRepository->getTotalOrdersForAdminWithSearch($dateFrom, $dateTo, 'Paid', $search);

        // Handle modal data for view and print
        $viewingSales = $this->getModalSales($request, 'show', 'show', ['broker', 'salesDetails.fishBox.fishType', 'salesPayments']);
        $printingSales = $this->getModalSales($request, 'print', 'print', ['broker', 'salesDetails.fishBox.fishType', 'salesPayments', 'broker']);

        // Add status display variables (same as broker)
        $salesStatuses = SalesStatusConstant::getAllActiveStatuses();
        $salesStatusesWithDisplayNames = collect($salesStatuses)->mapWithKeys(function ($status) {
            return [$status => SalesStatusConstant::getDisplayName($status)];
        });
        $salesStatusesWithColorClasses = collect($salesStatuses)->mapWithKeys(function ($status) {
            return [$status => SalesStatusConstant::getStatusColorClasses($status)];
        });

        // Create status options for dropdown
        $statusOptions = collect($salesStatuses)->mapWithKeys(function ($status) {
            return [$status => SalesStatusConstant::getDisplayName($status)];
        });



        return [
            'transactionsData' => [
                'transactions' => $transactions,
                'totalRevenue' => $totalRevenue,
                'totalTransactions' => $totalTransactions,
                'pendingCount' => $pendingCount,
                'paidCount' => $paidCount,
            ],
            'viewingSales' => $viewingSales,
            'printingSales' => $printingSales,
            'salesStatuses' => $salesStatuses,
            'salesStatusesWithDisplayNames' => $salesStatusesWithDisplayNames,
            'salesStatusesWithColorClasses' => $salesStatusesWithColorClasses,
            'statusOptions' => $statusOptions,
        ];
    }

    /**
     * Get sales data for modal display
     *
     * @param Request $request
     * @param string $modalType
     * @param string $paramName
     * @param array $withRelations
     *
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

        return $query->find($salesId);
    }

}
