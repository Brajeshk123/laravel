<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'name' => 'required|string|max:100',

            'email' => 'required|email|unique:users,email',

            'phone' => 'nullable|max:20',

            'password' => 'required|min:8|confirmed',

            'role' => [
                'required',
                'exists:roles,name',
            ],

            'status' => 'required|boolean',

            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'

        ];
    }

    public function messages(): array
    {
        return [

            'name.required' => 'Please enter user name.',

            'email.required' => 'Please enter email.',

            'password.confirmed' => 'Password does not match.',

            'profile_image.image' => 'Only image files are allowed.'

        ];
    }
}
