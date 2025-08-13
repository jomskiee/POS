<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    /**
     * Display the main reports page (default to daily sales).
     */
    public function index()
    {
        return $this->dailySales();
    }

    /**
     * Display daily sales report.
     */
    public function dailySales()
    {
        return view('admin.reports.index', ['activeSection' => 'daily-sales']);
    }

    /**
     * Display order list history.
     */
    public function orderHistory()
    {
        return view('admin.reports.index', ['activeSection' => 'order-history']);
    }

    /**
     * Display recent supplies list.
     */
    public function suppliesList()
    {
        return view('admin.reports.index', ['activeSection' => 'supplies-list']);
    }
}
