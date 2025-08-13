<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductManagementController extends Controller
{
    /**
     * Display the product management page with tabs.
     */
    public function index()
    {
        return view('admin.products.index');
    }
}
