<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage settings');
    }

    public function rules(): array
    {
        return [
            'site_name' => ['required', 'string', 'max:255'],
            'site_description' => ['nullable', 'string'],
            'site_url' => ['nullable', 'url'],
            'admin_email' => ['nullable', 'email'],
            'logo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'favicon' => ['nullable', 'file', 'mimes:ico,png,jpg,jpeg,webp,svg', 'max:1024'],

            'default_meta_title' => ['nullable', 'string', 'max:60'],
            'default_meta_description' => ['nullable', 'string', 'max:160'],
            'default_meta_keywords' => ['nullable', 'string', 'max:255'],
            'default_robots' => [
                'nullable',
                Rule::in(['index, follow', 'noindex, follow', 'index, nofollow', 'noindex, nofollow']),
            ],
            'default_og_image' => ['nullable', 'url'],

            'facebook_url' => ['nullable', 'url'],
            'instagram_url' => ['nullable', 'url'],
            'linkedin_url' => ['nullable', 'url'],
            'youtube_url' => ['nullable', 'url'],
            'twitter_url' => ['nullable', 'url'],

            'maintenance_mode' => ['required', 'boolean'],
            'timezone' => ['required', Rule::in(timezone_identifiers_list())],
            'posts_per_page' => ['required', 'integer', 'min:1', 'max:100'],
        ];
    }
}
