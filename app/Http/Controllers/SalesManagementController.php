<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Broker\SalesController;
use Illuminate\Http\Request;

class SalesManagementController extends Controller
{
    public function index()
    {
        return view('admin.sales.index');
    }

    public function brokerIndex()
    {
        return view('broker.sales.index');
    }

    public function sales(Request $request)
    {
        $salesController = new SalesController();
        $data = $salesController->getIndexData($request);
        return view('broker.sales.sales', $data);
    }
}
