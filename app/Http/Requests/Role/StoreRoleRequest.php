<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('roles', 'name')->where('guard_name', 'web'),
            ],

        ];
    }

    public function messages(): array
    {
        return [

            'name.required' => 'Role name is required.',

            'name.unique' => 'This role name already exists.',

        ];
    }
}
