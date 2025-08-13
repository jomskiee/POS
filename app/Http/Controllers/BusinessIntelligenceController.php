<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BusinessIntelligenceController extends Controller
{
    public function index()
    {
        return view('admin.business-intelligence.index');
    }
}