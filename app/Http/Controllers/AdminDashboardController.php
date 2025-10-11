<?php

namespace App\Http\Controllers;

use App\Models\FishBox;
use App\Models\Broker;
use App\Models\User;
use App\Constants\FishBoxStatusConstant;
use App\Constants\InventoryLogActionConstant;
use App\Models\InventoryLog;
use App\Repositories\SalesRepository;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    protected $salesRepository;

    public function __construct(SalesRepository $salesRepository)
    {
        $this->salesRepository = $salesRepository;
    }

    public function index()
    {
        // Get total brokers count
        $totalBrokers = Broker::count();

        // Count total fish boxes sold from sales_details
        $totalFishBoxesSold = $this->salesRepository->getTotalFishBoxesSoldCount();

        // Count fish boxes from inventory logs
        $totalFishBoxesMissing = InventoryLog::where('action', InventoryLogActionConstant::MISSING)->count();
        $totalFishBoxesReturned = InventoryLog::where('action', InventoryLogActionConstant::RETURNED)->count();

        // Get top brokers with fishbox count
        $topBrokers = $this->salesRepository->getTopBrokersWithFishBoxCount();

        // Get top fish types sold
        $topFishTypes = InventoryLog::getTopFishTypesSold();

        return view('admin.dashboard', compact(
            'totalBrokers',
            'totalFishBoxesSold',
            'totalFishBoxesMissing',
            'totalFishBoxesReturned',
            'topBrokers',
            'topFishTypes'
        ));
    }
}
