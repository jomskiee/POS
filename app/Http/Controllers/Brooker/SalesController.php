<?php

namespace App\Http\Controllers\Brooker;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalesRequest;
use App\Http\Requests\SalesPaymentRequest;
use App\Models\Sales;
use App\Models\SalesDetails;
use App\Models\SalesPayment;
use App\Models\FishBox;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    /**
     * Get data for sales index
     *
     * @param Request $request
     * @return array
     */
    public function getIndexData(Request $request): array
    {
        $search = $request->get('search');
        $status = $request->get('status');
        $brookerId = Auth::id();

        $sales = Sales::getPaginatedWithFilters($search, $status, $brookerId);

        $editingSales = null;

        // Check if we're in edit mode
        if ($request->get('modal') === 'edit' && $request->has('edit')) {
            $editingSales = Sales::with(['salesDetails', 'salesPayments'])->find($request->get('edit'));
        }

        return compact('sales', 'editingSales');
    }

    /**
     * Store a newly created sale.
     *
     * @param SalesRequest $request
     * @return RedirectResponse
     */
    public function store(SalesRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $brookerId = Auth::id();

        DB::transaction(function () use ($validated, $brookerId) {
            // Create the sale
            $sale = Sales::create([
                'sales_date' => $validated['sales_date'],
                'brooker_id' => $brookerId,
                'total_amount' => $validated['total_amount'],
                'buyer_name' => $validated['buyer_name'],
                'buyer_contact' => $validated['buyer_contact'],
                'remarks' => $validated['remarks'] ?? null,
                'details' => $validated['details'] ?? null,
                'status' => 'Active'
            ]);

            // Create sales details
            if (isset($validated['sales_details']) && is_array($validated['sales_details'])) {
                foreach ($validated['sales_details'] as $detail) {
                    SalesDetails::create([
                        'sales_id' => $sale->id,
                        'brooker_id' => $brookerId,
                        'box_id' => $detail['box_id'],
                        'item' => $detail['item'],
                        'item_description' => $detail['item_description'] ?? null
                    ]);
                }
            }
        });

        return redirect()->route('broker.sales.index')
            ->with('success', 'Sale created successfully!');
    }

    /**
     * Update the specified sale.
     *
     * @param SalesRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(SalesRequest $request, $id): RedirectResponse
    {
        $sale = Sales::findOrFail($id);
        $validated = $request->validated();
        $brookerId = Auth::id();

        // Check if the sale belongs to the current broker
        if ($sale->brooker_id !== $brookerId) {
            return redirect()->route('broker.sales.index')
                ->with('error', 'You are not authorized to update this sale.');
        }

        DB::transaction(function () use ($sale, $validated, $brookerId) {
            // Update the sale
            $sale->update([
                'sales_date' => $validated['sales_date'],
                'total_amount' => $validated['total_amount'],
                'buyer_name' => $validated['buyer_name'],
                'buyer_contact' => $validated['buyer_contact'],
                'remarks' => $validated['remarks'] ?? null,
                'details' => $validated['details'] ?? null,
            ]);

            // Update sales details - delete existing and create new ones
            $sale->salesDetails()->delete();

            if (isset($validated['sales_details']) && is_array($validated['sales_details'])) {
                foreach ($validated['sales_details'] as $detail) {
                    SalesDetails::create([
                        'sales_id' => $sale->id,
                        'brooker_id' => $brookerId,
                        'box_id' => $detail['box_id'],
                        'item' => $detail['item'],
                        'item_description' => $detail['item_description'] ?? null
                    ]);
                }
            }

            // Recalculate paid amount and update status
            $sale->updatePaidAmount();
            $sale->updatePaymentStatus();
        });

        return redirect()->route('broker.sales.index')
            ->with('success', 'Sale updated successfully!');
    }

    /**
     * Remove the specified sale.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $sale = Sales::findOrFail($id);
        $brookerId = Auth::id();

        // Check if the sale belongs to the current broker
        if ($sale->brooker_id !== $brookerId) {
            return redirect()->route('broker.sales.index')
                ->with('error', 'You are not authorized to delete this sale.');
        }

        DB::transaction(function () use ($sale) {
            // Delete related records
            $sale->salesDetails()->delete();
            $sale->salesPayments()->delete();
            $sale->delete();
        });

        return redirect()->route('broker.sales.index')
            ->with('success', 'Sale deleted successfully!');
    }

    /**
     * Store a newly created sales payment.
     *
     * @param SalesPaymentRequest $request
     * @return RedirectResponse
     */
    public function storePayment(SalesPaymentRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $brookerId = Auth::id();

        DB::transaction(function () use ($validated, $brookerId) {
            // Create the payment
            $payment = SalesPayment::create([
                'sales_id' => $validated['sales_id'],
                'brooker_id' => $brookerId,
                'paid_amount' => $validated['paid_amount'],
                'payment_date' => $validated['payment_date'],
                'payment_method' => $validated['payment_method'],
                'status' => 'Active'
            ]);

            // Update the sales paid amount and status
            $sale = Sales::findOrFail($validated['sales_id']);
            $sale->updatePaidAmount();
            $sale->updatePaymentStatus();
        });

        return redirect()->route('broker.sales.index')
            ->with('success', 'Payment recorded successfully!');
    }

    /**
     * Remove the specified sales payment.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroyPayment($id): RedirectResponse
    {
        $payment = SalesPayment::findOrFail($id);
        $brookerId = Auth::id();

        // Check if the payment belongs to the current broker
        if ($payment->brooker_id !== $brookerId) {
            return redirect()->route('broker.sales.index')
                ->with('error', 'You are not authorized to delete this payment.');
        }

        DB::transaction(function () use ($payment) {
            $sale = $payment->sales;
            $payment->delete();

            // Update the sales paid amount and status
            $sale->updatePaidAmount();
            $sale->updatePaymentStatus();
        });

        return redirect()->route('broker.sales.index')
            ->with('success', 'Payment deleted successfully!');
    }

    /**
     * Get available fish boxes for sales details
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvailableFishBoxes(Request $request)
    {
        $fishBoxes = FishBox::getAvailableForSale();

        return response()->json($fishBoxes);
    }
}
