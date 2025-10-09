<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesRequest extends FormRequest
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
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        $rules = [
            'sales_date' => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'buyer_name' => 'required|string|max:255',
            'remarks' => 'nullable|string',
            'details' => 'nullable|array',
            'sales_details' => 'required|array|min:1',
            'sales_details.*.box_id' => 'required|array|min:1',
            'sales_details.*.box_id.*' => 'required|exists:fish_boxes,id',
            'sales_details.*.fish_type_id' => 'required|exists:fish_types,id',
            'sales_details.*.item' => 'required|string|max:255',
            'sales_details.*.item_description' => 'nullable|string',
            'sales_details.*.unit_price' => 'nullable|numeric|min:0',
            'sales_details.*.quantity' => 'nullable|integer|min:1',
            'sales_details.*.sub_total' => 'nullable|numeric|min:0',
        ];


        return $rules;
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'sales_date.required' => 'Please select a sales date.',
            'sales_date.date' => 'Please enter a valid date.',
            'total_amount.required' => 'Please enter the total amount.',
            'total_amount.numeric' => 'Total amount must be a valid number.',
            'total_amount.min' => 'Total amount must be at least 0.',
            'buyer_name.required' => 'Please enter the buyer name.',
            'buyer_name.max' => 'Buyer name cannot exceed 255 characters.',
            'buyer_contact.required' => 'Please enter the buyer contact.',
            'buyer_contact.max' => 'Buyer contact cannot exceed 255 characters.',
            'sales_details.required' => 'Please add at least one sales detail.',
            'sales_details.min' => 'Please add at least one sales detail.',
            'sales_details.*.box_id.required' => 'Please select at least one fish box.',
            'sales_details.*.box_id.array' => 'Fish boxes must be provided as an array.',
            'sales_details.*.box_id.min' => 'Please select at least one fish box.',
            'sales_details.*.box_id.*.required' => 'Please select a fish box.',
            'sales_details.*.box_id.*.exists' => 'The selected fish box is invalid.',
            'sales_details.*.fish_type_id.required' => 'Please select a fish type.',
            'sales_details.*.fish_type_id.exists' => 'The selected fish type is invalid.',
            'sales_details.*.item.required' => 'Please enter the item name.',
            'sales_details.*.item.max' => 'Item name cannot exceed 255 characters.',
            'sales_details.*.unit_price.numeric' => 'Unit price must be a valid number.',
            'sales_details.*.unit_price.min' => 'Unit price must be at least 0.',
            'sales_details.*.quantity.integer' => 'Quantity must be a whole number.',
            'sales_details.*.quantity.min' => 'Quantity must be at least 1.',
            'sales_details.*.sub_total.numeric' => 'Sub total must be a valid number.',
            'sales_details.*.sub_total.min' => 'Sub total must be at least 0.',
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
            'sales_date' => 'sales date',
            'total_amount' => 'total amount',
            'buyer_name' => 'buyer name',
            'buyer_contact' => 'buyer contact',
            'sales_details' => 'sales details',
            'sales_details.*.box_id' => 'fish box',
            'sales_details.*.fish_type_id' => 'fish type',
            'sales_details.*.item' => 'item',
            'sales_details.*.unit_price' => 'unit price',
            'sales_details.*.quantity' => 'quantity',
            'sales_details.*.sub_total' => 'sub total',
        ];
    }
}
