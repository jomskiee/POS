<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function brokerIndex()
    {
        return view('broker.inventory.index');
    }
}