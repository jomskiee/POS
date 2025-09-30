<?php

namespace App\Http\Controllers\Broker;

use App\Http\Controllers\Controller;
use App\Http\Requests\FishTypeRequest;
use App\Models\FishType;
use App\Models\Broker;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class FishTypesController extends Controller
{
    /**
     * Get data for fish types tab
     *
     * @param Request $request
     * @return array
     */
    public function getIndexData(Request $request): array
    {
        $userId = Auth::id();
        $brokerId = Broker::getBrokerIdByUserId($userId);

        $fishTypes = FishType::getPaginatedWithSearch($request->get('search'), $brokerId);
        $editingFishType = null;

        // Only fetch editing fish type if we're in edit mode
        if ($request->get('modal') === 'edit' && $request->has('edit')) {
            $editingFishType = FishType::where('broker_id', $brokerId)->find($request->get('edit'));
        }

        return compact('fishTypes', 'editingFishType');
    }

    /**
     * Store a newly created fish type.
     *
     * @param FishTypeRequest $request
     *
     * @return RedirectResponse
     */
    public function store(FishTypeRequest $request): RedirectResponse
    {
        $userId = Auth::id();
        $brokerId = Broker::getBrokerIdByUserId($userId);

        $data = $request->validated();
        $data['broker_id'] = $brokerId;

        FishType::create($data);

        return redirect()->route('broker.inventory.index', ['tab' => 'fishTypes'])
            ->with('success', 'Fish type created successfully!');
    }

    /**
     * Update the specified fish type.
     *
     * @param FishTypeRequest $request
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function update(FishTypeRequest $request, $id): RedirectResponse
    {
        $fishType = FishType::findOrFail($id);

        $fishType->update($request->validated());

        return redirect()->route('broker.inventory.index', ['tab' => 'fishTypes'])
            ->with('success', 'Fish type updated successfully!');
    }

    /**
     * Remove the specified fish type.
     *
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $fishType = FishType::findOrFail($id);

        // Check if fish type has associated fish boxes
        if ($fishType->fishBoxes()->count() > 0) {
            return redirect()->route('broker.inventory.index', ['tab' => 'fishTypes'])
                ->with('error', 'Cannot delete fish type that has associated fish boxes.');
        }

        $fishType->delete();

        return redirect()->route('broker.inventory.index', ['tab' => 'fishTypes'])
            ->with('success', 'Fish type deleted successfully!');
    }
}
