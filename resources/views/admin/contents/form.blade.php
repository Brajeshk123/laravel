@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@once
    @push('css')
        @vite('resources/css/admin-content-editor.css')
    @endpush

    @push('js')
        @vite('resources/js/admin-content-editor.js')
    @endpush
@endonce

<div class="row">
    <div class="col-md-8 mb-3">
        <label class="form-label">Title</label>
        <input
            type="text"
            name="title"
            value="{{ old('title', $content->title ?? '') }}"
            class="form-control @error('title') is-invalid @enderror">
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Slug</label>
        <input
            type="text"
            name="slug"
            value="{{ old('slug', $content->slug ?? '') }}"
            class="form-control @error('slug') is-invalid @enderror"
            placeholder="Auto-generated if blank">
        @error('slug')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Content Type</label>
        <select name="content_type" class="form-select @error('content_type') is-invalid @enderror">
            <option value="">Select Type</option>
            @foreach($contentTypes as $value => $label)
                <option value="{{ $value }}" @selected(old('content_type', $content->content_type ?? '') === $value)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('content_type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select @error('status') is-invalid @enderror">
            @foreach($statuses as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $content->status ?? 'draft') === $value)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Featured Image</label>
        <input
            type="file"
            name="featured_image"
            id="featured_image"
            accept="image/jpeg,image/png,image/webp"
            class="form-control @error('featured_image') is-invalid @enderror">

        <div
            id="featured-image-client-error"
            class="invalid-feedback d-none">
        </div>

        @error('featured_image')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        @if(isset($content) && $content->featured_image)
            <div class="mt-3">
                <p class="form-label mb-1">Current Featured Image</p>
                <img
                    src="{{ asset('storage/'.$content->featured_image) }}"
                    alt="Current featured image"
                    class="img-fluid rounded border"
                    style="max-width: 300px; max-height: 200px; object-fit: cover;">
            </div>
        @endif

        <div class="mt-3">
            <img
                id="featured-image-preview"
                src=""
                alt="Featured image preview"
                class="img-fluid rounded border d-none"
                style="max-width: 300px; max-height: 200px; object-fit: cover;">

            <button
                type="button"
                id="featured-image-clear"
                class="btn btn-sm btn-outline-secondary mt-2 d-none">
                Clear
            </button>
        </div>
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Excerpt</label>
        <textarea
            name="excerpt"
            rows="3"
            class="form-control @error('excerpt') is-invalid @enderror">{{ old('excerpt', $content->excerpt ?? '') }}</textarea>
        @error('excerpt')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label for="content-editor" class="form-label">Content</label>
        <div class="content-editor-wrap">
            <textarea
                id="content-editor"
                name="content"
                rows="18"
                class="form-control content-editor @error('content') is-invalid @enderror"
                aria-describedby="content-editor-help">{{ old('content', $content->content ?? '') }}</textarea>
        </div>
        <div id="content-editor-help" class="content-editor-help">
            Use the classic editor toolbar for headings, links, images by URL, tables, lists, blockquotes, and source editing.
        </div>
        @error('content')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Categories</label>
        @php
            $selectedCategories = collect(old('category_ids', isset($content) ? $content->categories->pluck('id')->all() : []))->map(fn($id) => (string) $id)->all();
        @endphp
        <select name="category_ids[]" class="form-select @error('category_ids') is-invalid @enderror" multiple>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(in_array((string) $category->id, $selectedCategories, true))>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_ids')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Tags</label>
        @php
            $selectedTags = collect(old('tags', isset($content) ? $content->tags->pluck('id')->all() : []))->map(fn($id) => (string) $id)->all();
        @endphp
        <select name="tags[]" class="form-select @error('tags') is-invalid @enderror" multiple>
            @foreach($tags as $tag)
                <option value="{{ $tag->id }}" @selected(in_array((string) $tag->id, $selectedTags, true))>
                    {{ $tag->name }}
                </option>
            @endforeach
        </select>
        @error('tags')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">New Tags</label>
        <input
            type="text"
            name="tag_names"
            value="{{ old('tag_names') }}"
            class="form-control @error('tag_names') is-invalid @enderror"
            placeholder="Comma-separated, e.g. emergency, healthcare">
        @error('tag_names')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        @php
            $seo = $content->seo ?? null;
        @endphp

        <div class="card">
            <div class="card-header">
                <strong>SEO Settings</strong>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Meta Title</label>
                        <input
                            type="text"
                            name="meta_title"
                            id="meta_title"
                            value="{{ old('meta_title', $seo->meta_title ?? $content->meta_title ?? '') }}"
                            class="form-control @error('meta_title') is-invalid @enderror"
                            maxlength="60">
                        <small class="text-muted">
                            <span data-seo-counter="meta_title">0</span> / 60
                        </small>
                        @error('meta_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Meta Keywords</label>
                        <input
                            type="text"
                            name="meta_keywords"
                            value="{{ old('meta_keywords', $seo->meta_keywords ?? $content->meta_keywords ?? '') }}"
                            class="form-control @error('meta_keywords') is-invalid @enderror"
                            placeholder="keyword one, keyword two">
                        @error('meta_keywords')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea
                            name="meta_description"
                            id="meta_description"
                            rows="3"
                            maxlength="160"
                            class="form-control @error('meta_description') is-invalid @enderror">{{ old('meta_description', $seo->meta_description ?? $content->meta_description ?? '') }}</textarea>
                        <small class="text-muted">
                            <span data-seo-counter="meta_description">0</span> / 160
                        </small>
                        @error('meta_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-8 mb-3">
                        <label class="form-label">Canonical URL</label>
                        <input
                            type="url"
                            name="canonical_url"
                            id="canonical_url"
                            value="{{ old('canonical_url', $seo->canonical_url ?? $content->canonical_url ?? '') }}"
                            class="form-control @error('canonical_url') is-invalid @enderror"
                            placeholder="https://example.com/content/page">
                        @error('canonical_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Robots</label>
                        <select name="robots" class="form-select @error('robots') is-invalid @enderror">
                            @foreach(['index, follow', 'noindex, follow', 'index, nofollow', 'noindex, nofollow'] as $robots)
                                <option value="{{ $robots }}" @selected(old('robots', $seo->robots ?? $content->robots ?? 'index, follow') === $robots)>
                                    {{ $robots }}
                                </option>
                            @endforeach
                        </select>
                        @error('robots')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">OG Title</label>
                        <input
                            type="text"
                            name="og_title"
                            id="og_title"
                            value="{{ old('og_title', $seo->og_title ?? $content->og_title ?? '') }}"
                            class="form-control @error('og_title') is-invalid @enderror"
                            maxlength="60">
                        <small class="text-muted">
                            <span data-seo-counter="og_title">0</span> / 60
                        </small>
                        @error('og_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">OG Image</label>
                        <input
                            type="text"
                            name="og_image"
                            value="{{ old('og_image', $seo->og_image ?? $content->og_image ?? '') }}"
                            class="form-control @error('og_image') is-invalid @enderror"
                            placeholder="https://example.com/image.jpg or storage path">
                        @error('og_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">OG Description</label>
                        <textarea
                            name="og_description"
                            id="og_description"
                            rows="3"
                            maxlength="160"
                            class="form-control @error('og_description') is-invalid @enderror">{{ old('og_description', $seo->og_description ?? $content->og_description ?? '') }}</textarea>
                        <small class="text-muted">
                            <span data-seo-counter="og_description">0</span> / 160
                        </small>
                        @error('og_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Twitter Card</label>
                        <select name="twitter_card" class="form-select @error('twitter_card') is-invalid @enderror">
                            @foreach(['summary_large_image' => 'summary_large_image', 'summary' => 'summary'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('twitter_card', $seo->twitter_card ?? $content->twitter_card ?? 'summary_large_image') === $value)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('twitter_card')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-8 mb-3">
                        <label class="form-label">Search Preview</label>
                        <div class="border rounded p-3 bg-light">
                            <div
                                id="seo-preview-title"
                                class="text-primary fs-5">
                                Example Page Title
                            </div>
                            <div
                                id="seo-preview-url"
                                class="text-success small">
                                example.com/content/example
                            </div>
                            <div
                                id="seo-preview-description"
                                class="text-muted">
                                Example meta description...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@once
@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('featured_image');
    const preview = document.getElementById('featured-image-preview');
    const clearButton = document.getElementById('featured-image-clear');
    const error = document.getElementById('featured-image-client-error');
    const maxSize = 10 * 1024 * 1024;
    let objectUrl = null;

    if (!input || !preview || !clearButton || !error) {
        return;
    }

    function clearPreview() {
        input.value = '';
        preview.src = '';
        preview.classList.add('d-none');
        clearButton.classList.add('d-none');

        if (objectUrl) {
            URL.revokeObjectURL(objectUrl);
            objectUrl = null;
        }
    }

    function showError(message) {
        error.textContent = message;
        error.classList.remove('d-none');
        input.classList.add('is-invalid');
    }

    function clearError() {
        error.textContent = '';
        error.classList.add('d-none');
        input.classList.remove('is-invalid');
    }

    input.addEventListener('change', function () {
        clearError();

        const file = this.files[0];

        if (!file) {
            clearPreview();
            return;
        }

        if (!file.type.startsWith('image/')) {
            clearPreview();
            showError('Please select a valid image file.');
            return;
        }

        if (file.size > maxSize) {
            clearPreview();
            showError('Featured image must not be larger than 10 MB.');
            return;
        }

        if (objectUrl) {
            URL.revokeObjectURL(objectUrl);
        }

        objectUrl = URL.createObjectURL(file);
        preview.src = objectUrl;
        preview.classList.remove('d-none');
        clearButton.classList.remove('d-none');
    });

    clearButton.addEventListener('click', function () {
        clearPreview();
        clearError();
    });

    const seoFields = [
        { id: 'meta_title', max: 60 },
        { id: 'meta_description', max: 160 },
        { id: 'og_title', max: 60 },
        { id: 'og_description', max: 160 },
    ];

    function updateCounter(field) {
        const input = document.getElementById(field.id);
        const counter = document.querySelector(`[data-seo-counter="${field.id}"]`);

        if (!input || !counter) {
            return;
        }

        counter.textContent = input.value.length;
    }

    function updateSeoPreview() {
        const titleInput = document.getElementById('meta_title');
        const descriptionInput = document.getElementById('meta_description');
        const canonicalInput = document.getElementById('canonical_url');
        const previewTitle = document.getElementById('seo-preview-title');
        const previewDescription = document.getElementById('seo-preview-description');
        const previewUrl = document.getElementById('seo-preview-url');

        if (!titleInput || !descriptionInput || !previewTitle || !previewDescription || !previewUrl) {
            return;
        }

        previewTitle.textContent = titleInput.value || 'Example Page Title';
        previewDescription.textContent = descriptionInput.value || 'Example meta description...';
        previewUrl.textContent = canonicalInput && canonicalInput.value
            ? canonicalInput.value.replace(/^https?:\/\//, '')
            : 'example.com/content/example';
    }

    seoFields.forEach(function (field) {
        const input = document.getElementById(field.id);

        updateCounter(field);

        if (input) {
            input.addEventListener('input', function () {
                updateCounter(field);
                updateSeoPreview();
            });
        }
    });

    const canonicalInput = document.getElementById('canonical_url');

    if (canonicalInput) {
        canonicalInput.addEventListener('input', updateSeoPreview);
    }

    updateSeoPreview();
});
</script>
@endpush
@endonce
