<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesPaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sales_id' => 'required|exists:sales,id',
            'paid_amount' => [
                'required',
                'numeric',
                'min:0.01',
                'max:' . $this->getMaxPaymentAmount()
            ],
            'payment_date' => 'required|date',
            'payment_method' => 'required|string|max:255',
        ];
    }

    /**
     * Get the maximum payment amount allowed for this sale.
     *
     * @return float
     */
    private function getMaxPaymentAmount(): float
    {
        $salesId = $this->input('sales_id');
        if (!$salesId) {
            return 0;
        }

        $sale = \App\Models\Sales::find($salesId);
        if (!$sale) {
            return 0;
        }

        return $sale->remaining_amount;
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        $maxAmount = $this->getMaxPaymentAmount();

        return [
            'sales_id.required' => 'Please select a sale.',
            'sales_id.exists' => 'The selected sale is invalid.',
            'paid_amount.required' => 'Please enter the paid amount.',
            'paid_amount.numeric' => 'Paid amount must be a valid number.',
            'paid_amount.min' => 'Paid amount must be at least 0.01.',
            'paid_amount.max' => "Payment amount cannot exceed the remaining balance of ₱" . number_format($maxAmount, 2) . ".",
            'payment_date.required' => 'Please select a payment date.',
            'payment_date.date' => 'Please enter a valid payment date.',
            'payment_method.required' => 'Please enter the payment method.',
            'payment_method.max' => 'Payment method cannot exceed 255 characters.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'sales_id' => 'sale',
            'paid_amount' => 'paid amount',
            'payment_date' => 'payment date',
            'payment_method' => 'payment method',
        ];
    }
}
