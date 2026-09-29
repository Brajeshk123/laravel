<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->can('create categories');
    }

    public function rules(): array
    {
        return [
            'parent_id' => ['nullable', 'exists:categories,id'],

            'name' => ['required', 'string', 'max:255'],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:categories,slug',
            ],

            'description' => ['nullable', 'string'],

            'thumbnail' => ['nullable', 'string'],

            'icon' => ['nullable', 'string'],

            'sort_order' => ['nullable', 'integer', 'min:0'],

            'status' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Category name is required.',

            'slug.unique' => 'This category slug already exists. Please choose a different slug.',

            'slug.max' => 'The slug cannot be longer than 255 characters.',

            'parent_id.exists' => 'The selected parent category is invalid.',

            'sort_order.integer' => 'Sort order must be a number.',

            'status.boolean' => 'The status value is invalid.',
        ];
    }
}