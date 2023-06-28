<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            'username' => 'required|string|max:20|unique:users,username,' . $this->user->id,
            'email' => 'required|string|email|unique:users,email,' . $this->user->id,
            'phone_number' => 'required|max:15',
            'password' => 'nullable|min:8',
        ];
    }
}
