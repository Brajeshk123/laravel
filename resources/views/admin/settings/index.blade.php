@extends('admin.layouts.app')

@section('title', 'Settings')

@section('page-title', 'Settings')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">
        Settings
    </li>
@endsection

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">Settings</h2>
            <small class="text-muted">
                Manage global CMS configuration.
            </small>
        </div>
    </div>

    <form
        method="POST"
        action="{{ route('admin.settings.update') }}"
        enctype="multipart/form-data">
        @csrf

        <div class="card">
            <div class="card-header bg-white">
                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link active"
                            id="general-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#general"
                            type="button"
                            role="tab">
                            General
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link"
                            id="seo-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#seo"
                            type="button"
                            role="tab">
                            SEO
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link"
                            id="social-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#social"
                            type="button"
                            role="tab">
                            Social
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link"
                            id="system-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#system"
                            type="button"
                            role="tab">
                            System
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="site_name" class="form-label">
                                    Site Name <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="site_name"
                                    id="site_name"
                                    class="form-control @error('site_name') is-invalid @enderror"
                                    value="{{ old('site_name', $settings['site_name'] ?? '') }}">
                                @error('site_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="site_url" class="form-label">
                                    Site URL
                                </label>
                                <input
                                    type="url"
                                    name="site_url"
                                    id="site_url"
                                    class="form-control @error('site_url') is-invalid @enderror"
                                    value="{{ old('site_url', $settings['site_url'] ?? '') }}">
                                @error('site_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="admin_email" class="form-label">
                                    Admin Email
                                </label>
                                <input
                                    type="email"
                                    name="admin_email"
                                    id="admin_email"
                                    class="form-control @error('admin_email') is-invalid @enderror"
                                    value="{{ old('admin_email', $settings['admin_email'] ?? '') }}">
                                @error('admin_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="logo" class="form-label">
                                    Logo
                                </label>
                                <input
                                    type="file"
                                    name="logo"
                                    id="logo"
                                    class="form-control @error('logo') is-invalid @enderror"
                                    accept=".jpg,.jpeg,.png,.webp,.svg">
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if(! empty($settings['logo']))
                                    <small class="text-muted d-block mt-1">
                                        Current: {{ $settings['logo'] }}
                                    </small>
                                    <img
                                        src="{{ asset('storage/' . $settings['logo']) }}"
                                        alt="Current logo"
                                        class="img-thumbnail mt-2"
                                        style="max-height: 70px;">
                                @endif
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="favicon" class="form-label">
                                    Favicon
                                </label>
                                <input
                                    type="file"
                                    name="favicon"
                                    id="favicon"
                                    class="form-control @error('favicon') is-invalid @enderror"
                                    accept=".ico,.png,.jpg,.jpeg,.webp,.svg">
                                @error('favicon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if(! empty($settings['favicon']))
                                    <small class="text-muted d-block mt-1">
                                        Current: {{ $settings['favicon'] }}
                                    </small>
                                    <img
                                        src="{{ asset('storage/' . $settings['favicon']) }}"
                                        alt="Current favicon"
                                        class="img-thumbnail mt-2"
                                        style="max-height: 48px;">
                                @endif
                            </div>

                            <div class="col-12 mb-3">
                                <label for="site_description" class="form-label">
                                    Site Description
                                </label>
                                <textarea
                                    name="site_description"
                                    id="site_description"
                                    rows="4"
                                    class="form-control @error('site_description') is-invalid @enderror">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
                                @error('site_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="default_meta_title" class="form-label">
                                    Default Meta Title
                                </label>
                                <input
                                    type="text"
                                    name="default_meta_title"
                                    id="default_meta_title"
                                    maxlength="60"
                                    class="form-control @error('default_meta_title') is-invalid @enderror"
                                    value="{{ old('default_meta_title', $settings['default_meta_title'] ?? '') }}">
                                @error('default_meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="default_meta_keywords" class="form-label">
                                    Default Meta Keywords
                                </label>
                                <input
                                    type="text"
                                    name="default_meta_keywords"
                                    id="default_meta_keywords"
                                    class="form-control @error('default_meta_keywords') is-invalid @enderror"
                                    value="{{ old('default_meta_keywords', $settings['default_meta_keywords'] ?? '') }}">
                                @error('default_meta_keywords')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="default_robots" class="form-label">
                                    Default Robots
                                </label>
                                <select
                                    name="default_robots"
                                    id="default_robots"
                                    class="form-select @error('default_robots') is-invalid @enderror">
                                    @foreach(['index, follow', 'noindex, follow', 'index, nofollow', 'noindex, nofollow'] as $robots)
                                        <option value="{{ $robots }}" @selected(old('default_robots', $settings['default_robots'] ?? 'index, follow') === $robots)>
                                            {{ $robots }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('default_robots')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="default_og_image" class="form-label">
                                    Default OG Image URL
                                </label>
                                <input
                                    type="url"
                                    name="default_og_image"
                                    id="default_og_image"
                                    class="form-control @error('default_og_image') is-invalid @enderror"
                                    value="{{ old('default_og_image', $settings['default_og_image'] ?? '') }}">
                                @error('default_og_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="default_meta_description" class="form-label">
                                    Default Meta Description
                                </label>
                                <textarea
                                    name="default_meta_description"
                                    id="default_meta_description"
                                    maxlength="160"
                                    rows="4"
                                    class="form-control @error('default_meta_description') is-invalid @enderror">{{ old('default_meta_description', $settings['default_meta_description'] ?? '') }}</textarea>
                                @error('default_meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
                        <div class="row">
                            @foreach([
                                'facebook_url' => 'Facebook URL',
                                'instagram_url' => 'Instagram URL',
                                'linkedin_url' => 'LinkedIn URL',
                                'youtube_url' => 'YouTube URL',
                                'twitter_url' => 'Twitter URL',
                            ] as $key => $label)
                                <div class="col-md-6 mb-3">
                                    <label for="{{ $key }}" class="form-label">
                                        {{ $label }}
                                    </label>
                                    <input
                                        type="url"
                                        name="{{ $key }}"
                                        id="{{ $key }}"
                                        class="form-control @error($key) is-invalid @enderror"
                                        value="{{ old($key, $settings[$key] ?? '') }}">
                                    @error($key)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="tab-pane fade" id="system" role="tabpanel" aria-labelledby="system-tab">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="timezone" class="form-label">
                                    Timezone
                                </label>
                                <select
                                    name="timezone"
                                    id="timezone"
                                    class="form-select @error('timezone') is-invalid @enderror">
                                    @foreach($timezones as $timezone)
                                        <option value="{{ $timezone }}" @selected(old('timezone', $settings['timezone'] ?? 'UTC') === $timezone)>
                                            {{ $timezone }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('timezone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="posts_per_page" class="form-label">
                                    Posts Per Page
                                </label>
                                <input
                                    type="number"
                                    name="posts_per_page"
                                    id="posts_per_page"
                                    min="1"
                                    max="100"
                                    class="form-control @error('posts_per_page') is-invalid @enderror"
                                    value="{{ old('posts_per_page', $settings['posts_per_page'] ?? 10) }}">
                                @error('posts_per_page')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label d-block">
                                    Maintenance Mode
                                </label>
                                <input type="hidden" name="maintenance_mode" value="0">
                                <div class="form-check form-switch mt-2">
                                    <input
                                        type="checkbox"
                                        name="maintenance_mode"
                                        id="maintenance_mode"
                                        value="1"
                                        class="form-check-input"
                                        @checked(old('maintenance_mode', $settings['maintenance_mode'] ?? '0') == '1')>
                                    <label class="form-check-label" for="maintenance_mode">
                                        Enabled
                                    </label>
                                </div>
                                @error('maintenance_mode')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-white text-end">
                <button class="btn btn-primary">
                    <i class="bi bi-check-circle"></i>
                    Save Settings
                </button>
            </div>
        </div>
    </form>
</div>

@endsection
