<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->can('edit categories');
    }

    public function rules(): array
    {
        $categoryId = $this->route('category')->id;

        return [
            'parent_id' => [
                'nullable',
                'exists:categories,id',
                'not_in:' . $categoryId,
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:categories,slug,' . $categoryId,
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'thumbnail' => [
                'nullable',
                'string',
            ],

            'icon' => [
                'nullable',
                'string',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' =>
                'Category name is required.',

            'slug.unique' =>
                'This category slug already exists. Please choose a different slug.',

            'parent_id.exists' =>
                'The selected parent category is invalid.',
        ];
    }
}
