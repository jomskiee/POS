<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\FishBoxStatusConstant;

class FishBoxRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        $rules = [
            'fish_type_id' => 'required|exists:fish_types,id',
        ];

        if ($isUpdate) {
            // For updates, include status validation but no quantity
            $rules['status'] = 'required|in:' . implode(',', FishBoxStatusConstant::getAllStatuses());
        } else {
            // For creation, include quantity validation but no status
            $rules['quantity'] = 'required|integer|min:1|max:999999';
        }

        return $rules;
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'fish_type_id.required' => 'Please select a fish type.',
            'fish_type_id.exists' => 'The selected fish type is invalid.',
            'quantity.required' => 'Please enter the quantity.',
            'quantity.integer' => 'Quantity must be a valid number.',
            'quantity.min' => 'Quantity must be at least 1.',
            'quantity.max' => 'Quantity cannot exceed 999,999.',
            'status.required' => 'Please select a status.',
            'status.in' => 'The selected status is invalid.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes()
    {
        return [
            'fish_type_id' => 'fish type',
            'quantity' => 'quantity',
            'status' => 'status',
        ];
    }
}
