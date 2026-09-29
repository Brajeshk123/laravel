<div class="row g-3 align-items-end">
    <div class="col-md-3">
        <label class="form-label">
            Title <span class="text-danger">*</span>
        </label>
        <input
            type="text"
            name="title"
            class="form-control"
            value="{{ old('title', $item->title ?? '') }}">
    </div>

    <div class="col-md-2">
        <label class="form-label">
            Type
        </label>
        <select name="type" class="form-select menu-item-type">
            <option value="content" @selected(old('type', $item->type ?? 'content') === 'content')>
                Content
            </option>
            <option value="category" @selected(old('type', $item->type ?? '') === 'category')>
                Category
            </option>
            <option value="custom_url" @selected(old('type', $item->type ?? '') === 'custom_url')>
                Custom URL
            </option>
        </select>
    </div>

    <div class="col-md-3">
        @include('admin.menus.item-target-fields', ['item' => $item])
    </div>

    <div class="col-md-2">
        <label class="form-label">
            Parent
        </label>
        <select name="parent_id" class="form-select">
            <option value="">No Parent</option>
            @foreach($parentItems as $parentItem)
                <option value="{{ $parentItem->id }}" @selected(old('parent_id', $item->parent_id ?? '') == $parentItem->id)>
                    {{ $parentItem->title }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-1">
        <label class="form-label">
            Sort
        </label>
        <input
            type="number"
            name="sort_order"
            min="0"
            class="form-control"
            value="{{ old('sort_order', $item->sort_order ?? 0) }}">
    </div>

    <div class="col-md-1">
        <label class="form-label">
            Status
        </label>
        <select name="status" class="form-select">
            <option value="1" @selected(old('status', $item->status ?? 1) == 1)>
                Active
            </option>
            <option value="0" @selected(old('status', $item->status ?? 1) == 0)>
                Inactive
            </option>
        </select>
    </div>

    <div class="col-md-2">
        <label class="form-label">
            Target
        </label>
        <select name="target" class="form-select">
            <option value="_self" @selected(old('target', $item->target ?? '_self') === '_self')>
                Same tab
            </option>
            <option value="_blank" @selected(old('target', $item->target ?? '_self') === '_blank')>
                New tab
            </option>
        </select>
    </div>

    <div class="col-md-2">
        <button class="btn btn-primary w-100">
            {{ $buttonText }}
        </button>
    </div>
</div>
