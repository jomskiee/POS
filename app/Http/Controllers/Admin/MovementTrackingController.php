<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryLog;
use App\Constants\InventoryLogActionConstant;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MovementTrackingController extends Controller
{
    /**
     * Get data for movement tracking tab
     *
     * @param Request $request
     * @return array
     */
    public function getIndexData(Request $request): array
    {
        $actions = InventoryLogActionConstant::getAllActions();

        // Get summary counts for today
        $today = now()->format('Y-m-d');
        $summary = InventoryLog::getSummaryForDate($today);

        $action = $request->get('action');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        // Get paginated inventory logs with filters
        $inventoryLogs = InventoryLog::getPaginatedWithFilters($action, $dateFrom, $dateTo);

        return compact('actions', 'summary', 'inventoryLogs');
    }
}
