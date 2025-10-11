<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Broker\SalesController;
use App\Models\FishBox;
use App\Models\Broker;
use App\Models\FishType;
use App\Constants\FishBoxStatusConstant;
use App\Models\InventoryLog;
use App\Repositories\SalesRepository;
use App\Repositories\InventoryRepository;
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

            case 'fishbox-tracking':
                $data = $this->getFishboxTrackingData($request);
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
        $brokerSearch = $request->get('broker_search');

        // Get all brokers with their sales within the date range
        $brokersWithSales = $this->salesRepository->getBrokersWithSalesDetails($dateFrom, $dateTo, $brokerSearch);

        // Calculate total fishboxes sold based on filters
        $totalFishBoxesSold = $this->salesRepository->getTotalFishBoxesSold($dateFrom, $dateTo, $brokerSearch);

        return compact(
            'brokersWithSales',
            'totalFishBoxesSold',
            'dateFrom',
            'dateTo',
            'brokerSearch'
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
     * Get fishbox tracking data for admin
     *
     * @param Request $request
     * @return array
     */
    private function getFishboxTrackingData(Request $request): array
    {
        // Get available actions for filter
        $actions = FishBoxStatusConstant::getStatusOnlyForAdmin();

        // Get summary counts for today (only Returned and Missing)
        $today = now()->format('Y-m-d');
        $fullSummary = InventoryLog::getSummaryForDate($today);
        $summary = [
            'returned' => $fullSummary['returned'],
            'missing' => $fullSummary['missing']
        ];

        // Get filter parameters
        $action = $request->get('action');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        // Get paginated inventory logs with filters
        $inventoryLogs = InventoryLog::getPaginatedWithFilters($action, $dateFrom, $dateTo);

        return [
            'summary' => $summary,
            'actions' => $actions,
            'inventoryLogs' => $inventoryLogs,
        ];
    }

}
