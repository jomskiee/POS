<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Broker\SalesController;
use App\Models\Sales;
use App\Models\Broker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BrokerDashboardController extends Controller
{
    public function index()
    {
        $salesController = new SalesController();
        $data = $salesController->getDashboardData();

        return view('broker.dashboard', $data);
    }

}
