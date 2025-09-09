<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Constants\FishBoxStatusConstant;
use App\Models\FishType;
use App\Models\FishBox;
use App\Models\InventoryLog;
use App\Http\Requests\FishBoxRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class FishBoxController extends Controller
{
    /**
     * Get data for fish boxes tab
     *
     * @param Request $request
     * @return array
     */
    public function getIndexData(Request $request): array
    {
        $fishBoxStatuses = FishBoxStatusConstant::getAllStatuses();
        $fishTypes = FishType::all();

        $search = $request->get('search');
        $status = $request->get('status');
        $fishType = $request->get('fish_type');

        $fishBoxes = FishBox::getPaginatedWithFilters($search, $status, $fishType);

        $editingFishBox = null;

        // Check if we're in edit mode
        if ($request && $request->get('modal') === 'edit' && $request->has('edit')) {
            $editingFishBox = FishBox::find($request->get('edit'));
        }

        return compact('fishBoxStatuses', 'fishTypes', 'fishBoxes', 'editingFishBox');
    }

    /**
     * Store a newly created fish box.
     *
     * @param FishBoxRequest $request
     * @return RedirectResponse
     */
    public function store(FishBoxRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $createdBoxes = FishBox::createFishBoxes($validated['fish_type_id'], $validated['quantity'], Auth::id());

        $message = count($createdBoxes) === 1
            ? 'Fish box created successfully!'
            : count($createdBoxes) . ' fish boxes created successfully!';

        return redirect()->route('admin.inventory.index', ['tab' => 'fishBoxes'])
            ->with('success', $message);
    }

    /**
     * Update the specified fish box.
     *
     * @param FishBoxRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(FishBoxRequest $request, $id): RedirectResponse
    {
        $fishBox = FishBox::findOrFail($id);
        $validated = $request->validated();
        $originalStatus = $fishBox->status;

        $fishBox->update($validated);

        // Create inventory log only if status changed
        if (isset($validated['status']) && $validated['status'] !== $originalStatus) {
            InventoryLog::createLogForFishBox($fishBox->id, $validated['status'], Auth::id());
        }

        return redirect()->route('admin.inventory.index', ['tab' => 'fishBoxes'])
            ->with('success', 'Fish box updated successfully!');
    }

    /**
     * Remove the specified fish box.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $fishBox = FishBox::findOrFail($id);
        $fishBox->delete();

        return redirect()->route('admin.inventory.index', ['tab' => 'fishBoxes'])
            ->with('success', 'Fish box deleted successfully!');
    }
}
