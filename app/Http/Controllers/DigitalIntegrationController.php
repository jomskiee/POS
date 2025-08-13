<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DigitalIntegrationController extends Controller
{
    public function index()
    {
        return view('admin.digital-integration.index');
    }
}