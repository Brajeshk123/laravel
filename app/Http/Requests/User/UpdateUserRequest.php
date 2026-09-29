<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'name' => 'required|string|max:100',

            'email' => [

                'required',

                'email',

                Rule::unique('users')->ignore($this->route('user'))

            ],

            'phone' => 'nullable|max:20',

            'password' => 'nullable|min:8|confirmed',

            'role' => [
                'required',
                'exists:roles,name',
            ],

            'status' => 'required|boolean',

            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'

        ];
    }
}
