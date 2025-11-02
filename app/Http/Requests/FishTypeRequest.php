<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Broker;
use Illuminate\Support\Facades\Auth;

class FishTypeRequest extends FormRequest
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
        // Get the fish type ID from route parameter (direct ID)
        $fishTypeId = $this->route('id');

        // Get the broker ID for the current user
        $brokerId = Broker::getBrokerIdByUserId(Auth::id());

        $nameRules = ['required', 'string', 'max:255', 'min:2'];

        // Add unique rule scoped to broker_id with proper ignore for updates
        if ($fishTypeId) {
            $nameRules[] = Rule::unique('fish_types', 'name')
                ->ignore($fishTypeId, 'id')
                ->where('broker_id', $brokerId)
                ->whereNull('deleted_at');
        } else {
            $nameRules[] = Rule::unique('fish_types', 'name')
                ->where('broker_id', $brokerId)
                ->whereNull('deleted_at');
        }

        return [
            'name' => $nameRules,
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom validation messages
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'name.required' => 'The fish type name is required.',
            'name.min' => 'The fish type name must be at least 2 characters.',
            'name.max' => 'The fish type name may not be greater than 255 characters.',
            'name.unique' => 'This fish type name already exists.',
            'description.max' => 'The description may not be greater than 1000 characters.',
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
            'name' => 'fish type name',
            'description' => 'description',
        ];
    }
}
