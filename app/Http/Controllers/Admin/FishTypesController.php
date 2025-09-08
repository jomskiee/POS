<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FishTypeRequest;
use App\Models\FishType;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FishTypesController extends Controller
{
    /**
     * @return View
     */
    public function index(Request $request): View
    {
        $fishTypes = FishType::all();
        $editingFishType = null;

        // Only fetch editing fish type if we're in edit mode
        if ($request->get('modal') === 'edit' && $request->has('edit')) {
            $editingFishType = FishType::find($request->get('edit'));
        }

        return view('admin.inventory.index', compact('fishTypes', 'editingFishType'));
    }

    // ============== CRUD Operations ============== //

    /**
     * Store a newly created fish type.
     *
     * @param FishTypeRequest $request
     *
     * @return RedirectResponse
     */
    public function store(FishTypeRequest $request): RedirectResponse
    {
        FishType::create($request->validated());

        return redirect()->route('admin.inventory.index', ['tab' => 'fishTypes'])
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

        return redirect()->route('admin.inventory.index', ['tab' => 'fishTypes'])
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
        $fishType->delete();

        return redirect()->route('admin.inventory.index', ['tab' => 'fishTypes'])
            ->with('success', 'Fish type deleted successfully!');
    }
}
