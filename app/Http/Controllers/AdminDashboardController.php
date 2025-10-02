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

        // Get fish box counts by status
        $totalFishBoxesSold = FishBox::sold()->count();
        $totalFishBoxesMissing = FishBox::missing()->count();
        $totalFishBoxesReturned = FishBox::returned()->count();

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
