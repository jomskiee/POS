<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        // Get the user ID and ensure it's an integer
        $userId = $this->route('id');
        $userId = is_numeric($userId) ? (int) $userId : $userId;

        $emailRules = ['required', 'string', 'email', 'max:255'];

        // Only add unique rule if we have a user ID (update mode)
        if ($userId) {
            // Try different approaches for the unique rule
            $emailRules[] = Rule::unique('users', 'email')->ignore($userId, 'id');
        } else {
            $emailRules[] = 'unique:users,email';
        }

        // Password validation rules
        $passwordRules = [];

        if ($this->isMethod('post')) {
            // Create mode - password is always required
            $passwordRules = ['required', 'string', 'min:8', 'confirmed'];
        } else {
            // Update mode - check if change_password checkbox is checked
            if ($this->has('change_password') && $this->input('change_password')) {
                // If checkbox is checked, password is required
                $passwordRules = ['required', 'string', 'min:8', 'confirmed'];
            } else {
                // If checkbox is not checked, password is nullable
                $passwordRules = ['nullable', 'string', 'min:8'];
            }
        }

        return [
            'name' => ['required', 'string', 'max:255', 'min:2'],
            'email' => $emailRules,
            'password' => $passwordRules,
            'address' => ['nullable', 'string', 'max:500'],
            'role' => $this->isMethod('post')
                ? ['required', 'string', Rule::in(['admin', 'broker'])]
                : ['prohibited'],
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
            'name.required' => 'The name field is required.',
            'name.min' => 'The name must be at least 2 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email address is already taken.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'role.required' => 'Please select a user role.',
            'role.in' => 'The selected role is invalid.',
            'role.prohibited' => 'Role cannot be changed after creation.',
            'address.max' => 'The address may not be greater than 500 characters.',
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
            'name' => 'full name',
            'email' => 'email address',
            'password' => 'password',
            'address' => 'address',
            'role' => 'user role',
        ];
    }
}
