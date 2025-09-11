<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\FishBoxController;
use App\Http\Controllers\Broker\SalesController;
use Illuminate\Http\Request;

class BrokerDashboardController extends Controller
{
    public function index()
    {
        $salesController = new SalesController();
        $data = $salesController->getDashboardData();
        return view('broker.dashboard', $data);
    }

    public function fishBoxes(Request $request)
    {
        $fishBoxController = new FishBoxController();
        $data = $fishBoxController->getBrokerFishBoxData($request);
        return view('broker.sales.fish-box', $data);
    }
}
