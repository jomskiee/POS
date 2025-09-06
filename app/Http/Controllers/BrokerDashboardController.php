<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BrokerDashboardController extends Controller
{
    public function index()
    {
        return view('broker.dashboard');
    }
}
