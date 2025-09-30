<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FishManagementController extends Controller
{
    /**
     * Display the movement tracking page
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $movementController = new MovementTrackingController();
        $data = $movementController->getIndexData($request);

        return view('admin.inventory.movement-tracking', $data);
    }
}
