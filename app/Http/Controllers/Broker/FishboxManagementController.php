<?php

namespace App\Http\Controllers\Broker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FishboxManagementController extends Controller
{
    /**
     * Display the broker inventory page with tab-based routing
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $tab = $request->get('tab', 'fishBoxes'); // Default to fishBoxes tab

        // Delegate to appropriate controller based on tab
        switch ($tab) {
            case 'fishBoxes':
                $fishBoxController = new FishBoxController();
                $data = $fishBoxController->getIndexData($request);
                break;

            case 'fishTypes':
                $fishTypesController = new FishTypesController();
                $data = $fishTypesController->getIndexData($request);
                break;

            default:
                $fishBoxController = new FishBoxController();
                $data = $fishBoxController->getIndexData($request);
                break;
        }

        // Add the current tab to the data
        $data['currentTab'] = $tab;

        return view('broker.inventory.index', $data);
    }
}
