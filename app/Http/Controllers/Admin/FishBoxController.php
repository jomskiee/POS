<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Constants\FishBoxStatusConstant;
use App\Models\FishType;
use App\Models\FishBox;
use App\Models\InventoryLog;
use App\Http\Requests\FishBoxRequest;
use App\Models\Broker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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


    public function getBrokerFishBoxData(Request $request): array
    {
        $search = $request->get('search');
        $status = $request->get('status');
        $fishType = $request->get('fish_type');

        $userId = Auth::id();
        $brokerId = Broker::getBrokerIdByUserId($userId);

        // Get filter options
        $fishBoxStatuses = FishBoxStatusConstant::getAllStatuses();
        $fishTypes = FishType::all();

        // If no broker found, return empty pagination
        if (!$brokerId) {
            $fishBoxes = FishBox::where('id', operator: 0)->paginate(12);
            return compact('fishBoxes', 'fishBoxStatuses', 'fishTypes');
        }

        $fishBoxes = FishBox::getPaginatedWithFilters($search, $status, $fishType, 12, $brokerId);

        return compact('fishBoxes', 'fishBoxStatuses', 'fishTypes');
    }

    /**
     * Update fish box status by scanning QR code
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateStatus(Request $request): JsonResponse
    {
        // Validate the request - expect text QR code from camera scanning
        $request->validate([
            'qr_code' => 'required|string|max:255',
        ]);

        $qrCodeValue = $request->input('qr_code');

        try {
            // Get fish box by QR code
            $fishBox = FishBox::getFishBoxByQrCode($qrCodeValue);

            // Check if the fish box is found
            if (!$fishBox) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid QR code. Fish box not found.'
                ], 404);
            }

            // Check if the fish box is already returned
            if($fishBox->status == FishBoxStatusConstant::RETURNED) {
                return response()->json([
                    'success' => false,
                    'message' => 'This fish box is already returned.'
                ], 400);
            }


            $userId = Auth::id();
            $brokerId = null;

            // Check if user is a broker and validate ownership
            if (Auth::user()->role === 'broker') {
                $brokerId = Broker::getBrokerIdByUserId($userId);
                if ($fishBox->current_broker_id !== $brokerId) {
                    return response()->json([
                        'success' => false,
                        'message' => 'This fish box is not assigned to you.'
                    ], 403);
                }
            }

            $newStatus = FishBoxStatusConstant::RETURNED;
            // Update the fish box status based on current status
            FishBox::updateBrokerAndStatus($fishBox->id, $brokerId, $newStatus, Auth::id());


            // Create inventory log for the status change
            InventoryLog::createLogForFishBox($fishBox->id, $newStatus, Auth::id());

            // Return JSON response for AJAX requests
            return response()->json([
                'success' => true,
                'message' => "'{$fishBox->name}' status updated to '{$newStatus}' successfully.",
                'data' => [
                    'fish_box_id' => $fishBox->id,
                    'fish_box_name' => $fishBox->name,
                    'old_status' => $fishBox->status,
                    'new_status' => $newStatus
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('QR Code processing error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error processing QR code. Please try again.'
            ], 500);
        }
    }

    /**
     * Mark fish box as missing
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function markAsMissing($id): RedirectResponse
    {
        try {
            $fishBox = FishBox::findOrFail($id);

            // Check if the fish box belongs to the current broker
            $userId = Auth::id();
            $brokerId = Broker::getBrokerIdByUserId($userId);

            if ($fishBox->current_broker_id !== $brokerId) {
                return back()->withErrors(['error' => 'This fish box is not assigned to you.']);
            }

            // Update the fish box status to Missing
            $fishBox->status = FishBoxStatusConstant::MISSING;
            $fishBox->save();

            // Create inventory log for the status change
            InventoryLog::createLogForFishBox($fishBox->id, FishBoxStatusConstant::MISSING, Auth::id());

            return back()->with('success', "Fish box '{$fishBox->name}' has been marked as missing.");

        } catch (\Exception $e) {
            Log::error('Mark as missing error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error marking fish box as missing. Please try again.']);
        }
    }

    /**
     * Return a specific fish box to "Returned" status
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function returnFishBox($id): RedirectResponse
    {
        try {
            $fishBox = FishBox::findOrFail($id);

            // Check if the fish box is already returned
            if ($fishBox->status === FishBoxStatusConstant::RETURNED) {
                return back()->withErrors(['error' => 'This fish box is already returned.']);
            }

            // Check if the fish box belongs to the current broker
            $userId = Auth::id();
            $brokerId = Broker::getBrokerIdByUserId($userId);

            if ($fishBox->current_broker_id !== $brokerId) {
                return back()->withErrors(['error' => 'This fish box is not assigned to you.']);
            }

            // Update the fish box status to Returned
            $fishBox->status = FishBoxStatusConstant::RETURNED;
            $fishBox->save();

            // Create inventory log for the status change
            InventoryLog::createLogForFishBox($fishBox->id, FishBoxStatusConstant::RETURNED, Auth::id());

            return back()->with('success', "Fish box '{$fishBox->name}' has been returned successfully.");

        } catch (\Exception $e) {
            Log::error('Return fish box error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error returning fish box. Please try again.']);
        }
    }

    /**
     * Return all "Returned" fish boxes to "In Stock" status
     *
     * @return RedirectResponse
     */
    public function returnToStock(): RedirectResponse
    {
        try {
            $count = FishBox::returnAllToStock(Auth::id());

            if ($count > 0) {
                return redirect()->route('admin.inventory.index', ['tab' => 'fishBoxes'])
                    ->with('success', "Successfully returned {$count} fish box(es) to 'In Stock' status.");
            } else {
                return redirect()->route('admin.inventory.index', ['tab' => 'fishBoxes'])
                    ->with('error', 'No fish boxes with "Returned" status found.');
            }

        } catch (\Exception $e) {
            Log::error('Return to stock error: ' . $e->getMessage());
            return redirect()->route('admin.inventory.index', ['tab' => 'fishBoxes'])
                ->with('error', 'Error returning fish boxes to stock. Please try again.');
        }
    }
}
