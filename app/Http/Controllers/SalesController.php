<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        return view('admin.sales.index');
    }

    public function brokerIndex()
    {
        return view('broker.sales.index');
    }
}