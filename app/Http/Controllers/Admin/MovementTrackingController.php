<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MovementTrackingController extends Controller
{
    /**
     * Get data for movement tracking tab
     *
     * @return array
     */
    public function getIndexData(): array
    {
        // Add movement tracking specific data here
        // For now, return empty array since movement tracking doesn't need specific data
        return [];
    }
}
