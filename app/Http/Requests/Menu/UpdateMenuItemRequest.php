<?php

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMenuItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('edit menus');
    }

    public function rules(): array
    {
        $menu = $this->route('menu');
        $item = $this->route('item');

        return [
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in(['content', 'category', 'custom_url'])],
            'content_id' => ['nullable', 'required_if:type,content', 'exists:contents,id'],
            'category_id' => ['nullable', 'required_if:type,category', 'exists:categories,id'],
            'url' => ['nullable', 'required_if:type,custom_url', 'string', 'max:2048'],
            'parent_id' => [
                'nullable',
                'integer',
                Rule::exists('menu_items', 'id')->where('menu_id', $menu?->id),
                Rule::notIn([$item?->id ?? $item]),
            ],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'target' => ['required', Rule::in(['_self', '_blank'])],
            'status' => ['required', 'boolean'],
        ];
    }
}
