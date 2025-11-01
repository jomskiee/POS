<?php

namespace App\Http\Controllers\Broker;

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
        $userId = Auth::id();
        $brokerId = Broker::getBrokerIdByUserId($userId);

        $fishBoxStatuses = FishBoxStatusConstant::getAllStatuses();
        $fishTypes = FishType::getFishTypeByBrokerId($brokerId);

        $search = $request->get('search');
        $status = $request->get('status');
        $fishType = $request->get('fish_type');

        // Filter fish boxes by current broker
        $fishBoxes = FishBox::getPaginatedWithFilters($search, $status, $fishType, 12, $brokerId);

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
        $userId = Auth::id();
        $brokerId = Broker::getBrokerIdByUserId($userId);
        $createdBoxes = FishBox::createFishBoxes($validated['fish_type_id'], $validated['quantity'], $brokerId);

        $message = count($createdBoxes) === 1
            ? 'Fish box created successfully!'
            : count($createdBoxes) . ' fish boxes created successfully!';

        return redirect()->route('broker.inventory.index', ['tab' => 'fishBoxes'])
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
        $brokerId = Broker::getBrokerIdByUserId(Auth::id());
        $fishBox = FishBox::getFishBoxByIdAndBroker($id, $brokerId);
        $validated = $request->validated();
        $originalStatus = $fishBox->status;

        $fishBox->update($validated);

        // Create inventory log only if status changed
        if (isset($validated['status']) && $validated['status'] !== $originalStatus) {
            InventoryLog::createLogForFishBox($fishBox->id, $validated['status'], $fishBox->broker_id);
        }
        return redirect()->route('broker.inventory.index', ['tab' => 'fishBoxes'])
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
        $brokerId = Broker::getBrokerIdByUserId(Auth::id());
        $fishBox = FishBox::getFishBoxByIdAndBroker($id, $brokerId);

        // Check if fish box can be deleted
        if (!$fishBox->canBeDeleted()) {
            return redirect()->route('broker.inventory.index', ['tab' => 'fishBoxes'])
                ->with('error', 'Cannot delete fish box that has been sold or returned.');
        }

        $fishBox->delete();

        return redirect()->route('broker.inventory.index', ['tab' => 'fishBoxes'])
            ->with('success', 'Fish box deleted successfully!');
    }

    /**
     * Return fish box via QR code scanning
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function returnFishBoxViaQr(Request $request): JsonResponse
    {
        // Validate the request - expect text QR code from camera scanning
        $request->validate([
            'qr_code' => 'required|string|max:255',
        ]);

        $qrCodeValue = $request->input('qr_code');

        try {
            $brokerId = Broker::getBrokerIdByUserId(Auth::id());
            // Get fish box by QR code with broker validation
            $fishBox = FishBox::getFishBoxByQrCode($qrCodeValue, $brokerId);

            // Check if the fish box is found
            if (!$fishBox) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid QR code. Fish box not found or not assigned to you.'
                ], 404);
            }

            // Check if the fish box is already returned
            if($fishBox->status == FishBoxStatusConstant::RETURNED) {
                return response()->json([
                    'success' => false,
                    'message' => 'This fish box is already returned.'
                ], 400);
            }

            $newStatus = FishBoxStatusConstant::RETURNED;
            // Update the fish box status based on current status
            FishBox::updateStatus($fishBox->id, $newStatus, Auth::id());

            // Create inventory log for the status change
            InventoryLog::createLogForFishBox($fishBox->id, $newStatus, $fishBox->broker_id);

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
        $brokerId = Broker::getBrokerIdByUserId(Auth::id());
        $fishBox = FishBox::getFishBoxByIdAndBroker($id, $brokerId);

        if (!$fishBox->canBeMarkedAsMissing()) {
            return redirect()->route('broker.inventory.index', ['tab' => 'fishBoxes'])
                ->with('error', 'This fish box cannot be marked as missing.');
        }

        $fishBox->status = FishBoxStatusConstant::MISSING;
        $fishBox->save();

        // Create inventory log for the status change
        InventoryLog::createLogForFishBox($fishBox->id, FishBoxStatusConstant::MISSING, $fishBox->broker_id);

        return redirect()->route('broker.inventory.index', ['tab' => 'fishBoxes'])
            ->with('success', 'Fish box marked as missing successfully!');
    }

    /**
     * Return fish box
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function returnFishBox($id): RedirectResponse
    {
        $brokerId = Broker::getBrokerIdByUserId(Auth::id());
        $fishBox = FishBox::getFishBoxByIdAndBroker($id, $brokerId);

        if ($fishBox->status !== FishBoxStatusConstant::SOLD) {
            return redirect()->route('broker.inventory.index', ['tab' => 'fishBoxes'])
                ->with('error', 'Only sold fish boxes can be returned.');
        }

        FishBox::updateFishBoxesForReturned($fishBox->id, Auth::id());

        return redirect()->route('broker.inventory.index', ['tab' => 'fishBoxes'])
            ->with('success', 'Fish box returned successfully!');
    }

    /**
     * Return all returned fish boxes to stock
     *
     * @return RedirectResponse
     */
    public function returnToStock(): RedirectResponse
    {
        $brokerId = Broker::getBrokerIdByUserId(Auth::id());
        $returnedCount = FishBox::returnAllToStock($brokerId);

        if ($returnedCount === 0) {
            return redirect()->route('broker.inventory.index', ['tab' => 'fishBoxes'])
                ->with('info', 'No returned fish boxes to process.');
        }

        return redirect()->route('broker.inventory.index', ['tab' => 'fishBoxes'])
            ->with('success', "{$returnedCount} fish boxes returned to stock successfully!");
    }
}
