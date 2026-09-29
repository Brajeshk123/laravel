<div data-menu-target="content">
    <label class="form-label">
        Content
    </label>
    <select
        name="content_id"
        @isset($formId)
            form="{{ $formId }}"
        @endisset
        class="form-select form-select-sm">
        <option value="">Select Content</option>
        @foreach($contents as $content)
            <option value="{{ $content->id }}" @selected(old('content_id', $item->content_id ?? '') == $content->id)>
                {{ $content->title }}
            </option>
        @endforeach
    </select>
</div>

<div data-menu-target="category">
    <label class="form-label">
        Category
    </label>
    <select
        name="category_id"
        @isset($formId)
            form="{{ $formId }}"
        @endisset
        class="form-select form-select-sm">
        <option value="">Select Category</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" @selected(old('category_id', $item->category_id ?? '') == $category->id)>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</div>

<div data-menu-target="custom_url">
    <label class="form-label">
        URL
    </label>
    <input
        type="text"
        name="url"
        @isset($formId)
            form="{{ $formId }}"
        @endisset
        class="form-control form-control-sm"
        value="{{ old('url', $item->url ?? '') }}"
        placeholder="https://example.com">
</div>
