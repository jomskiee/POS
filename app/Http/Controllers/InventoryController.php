<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function adminIndex()
    {
        return view('admin.inventory.index');
    }

    public function brokerIndex()
    {
        return view('broker.inventory.index');
    }
}