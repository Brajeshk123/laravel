<div class="row">
    <div class="col-md-6 mb-3">
        <label for="name" class="form-label">
            Name <span class="text-danger">*</span>
        </label>
        <input
            type="text"
            name="name"
            id="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $menu->name ?? '') }}">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label for="slug" class="form-label">
            Slug
        </label>
        <input
            type="text"
            name="slug"
            id="slug"
            class="form-control @error('slug') is-invalid @enderror"
            value="{{ old('slug', $menu->slug ?? '') }}"
            placeholder="main-menu">
        @error('slug')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-2 mb-3">
        <label for="status" class="form-label">
            Status
        </label>
        <select name="status" id="status" class="form-select">
            <option value="1" @selected(old('status', $menu->status ?? 1) == 1)>
                Active
            </option>
            <option value="0" @selected(old('status', $menu->status ?? 1) == 0)>
                Inactive
            </option>
        </select>
    </div>
</div>
