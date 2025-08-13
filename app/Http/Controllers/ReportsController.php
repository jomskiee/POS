<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index()
    {
        // Redirect to daily sales as default
        return redirect()->route('admin.reports.daily-sales');
    }

    public function dailySales()
    {
        return view('admin.reports.daily-sales');
    }

    public function orderHistory()
    {
        return view('admin.reports.order-history');
    }

    public function suppliesList()
    {
        return view('admin.reports.supplies-list');
    }
}
