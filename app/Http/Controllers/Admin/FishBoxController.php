<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Constants\FishBoxStatusConstant;
use App\Models\FishType;
use App\Models\FishBox;
use App\Models\InventoryLog;
use App\Http\Requests\FishBoxRequest;
use App\Models\Broker;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Zxing\QrReader;

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

        // If no broker found, return empty pagination
        if (!$brokerId) {
            $fishBoxes = FishBox::where('id', operator: 0)->paginate(12);
            return compact('fishBoxes');
        }

        $fishBoxes = FishBox::getPaginatedWithFilters($search, $status, $fishType, 12, $brokerId);

        Log::info($fishBoxes);

        return compact('fishBoxes');
    }

    /**
     * Update fish box status by scanning/uploading QR code
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateStatus(Request $request): RedirectResponse
    {
        // Validate the request - handle both text input and file upload
        if ($request->hasFile('qr_code')) {
            // File upload validation
            $request->validate([
                'qr_code' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            try {
                // Store the uploaded QR code image
                $path = $request->file('qr_code')->store('qr_codes', 'public');
                $imagePath = storage_path('app/public/' . $path);

                // Read QR code from the uploaded image
                $qrCodeReader = new QrReader($imagePath);
                $qrCodeValue = $qrCodeReader->text();

                if (empty($qrCodeValue)) {
                    // Clean up the uploaded file
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($path);
                    return back()->withErrors(['qr_code' => 'No QR code found in the uploaded image. Please try a different image.']);
                }

                // Clean up the uploaded file after processing
                \Illuminate\Support\Facades\Storage::disk('public')->delete($path);

            } catch (\Exception $e) {
                Log::error('QR Code image processing error: ' . $e->getMessage());
                return back()->withErrors(['qr_code' => 'Error processing QR code image. Please try again.']);
            }
        } else {
            return back()->withErrors(['qr_code' => 'Please upload a QR code image or use the camera scanner.']);
        }

        try {

            $fishBox = FishBox::where('qr_code', $qrCodeValue)->first();

            if (!$fishBox) {
                return back()->withErrors(['qr_code' => 'Invalid QR code. Fish box not found.']);
            }

            // Check if the fish box belongs to the current broker
            $userId = Auth::id();
            $brokerId = \App\Models\Broker::getBrokerIdByUserId($userId);

            if ($fishBox->current_broker_id !== $brokerId) {
                return back()->withErrors(['qr_code' => 'This fish box is not assigned to you.']);
            }

            // Update the fish box status based on current status
            $newStatus = FishBoxStatusConstant::RETURNED;
            $fishBox->status = $newStatus;
            $fishBox->save();

            // Create inventory log for the status change
            InventoryLog::createLogForFishBox($fishBox->id, $newStatus, Auth::id());

            return back()->with('success', "Fish box '{$fishBox->name}' status updated to '{$newStatus}' successfully.");

        } catch (\Exception $e) {
            Log::error('QR Code processing error: ' . $e->getMessage());
            return back()->withErrors(['qr_code' => 'Error processing QR code. Please try again.']);
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
            $brokerId = \App\Models\Broker::getBrokerIdByUserId($userId);

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
}
