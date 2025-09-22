<?php

namespace App\Http\Controllers;

use App\Models\FishBox;
use App\Models\Broker;
use App\Models\User;
use App\Constants\FishBoxStatusConstant;
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

        // Get total fish boxes sold
        $totalFishBoxesSold = FishBox::sold()->count();

        // Get sales data from repository
        $totalSales = $this->salesRepository->getTotalSalesAmount();
        $totalOrders = $this->salesRepository->getTotalOrdersCount();
        $recentOrders = $this->salesRepository->getRecentOrders();
        $topBrokers = $this->salesRepository->getTopBrokersThisMonth();
        $topFishTypes = InventoryLog::getTopFishTypesSold();
        $dailySalesData = $this->salesRepository->getDailySalesData();

        return view('admin.dashboard', compact(
            'totalBrokers',
            'totalFishBoxesSold',
            'totalSales',
            'totalOrders',
            'recentOrders',
            'topBrokers',
            'topFishTypes',
            'dailySalesData'
        ));
    }
}
