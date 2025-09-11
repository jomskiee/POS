<?php

namespace App\Http\Controllers;

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
}
