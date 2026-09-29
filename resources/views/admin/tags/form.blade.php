@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Tag Name</label>
        <input
            type="text"
            name="name"
            value="{{ old('name', $tag->name ?? '') }}"
            class="form-control @error('name') is-invalid @enderror">

        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Slug</label>
        <input
            type="text"
            name="slug"
            value="{{ old('slug', $tag->slug ?? '') }}"
            class="form-control @error('slug') is-invalid @enderror"
            placeholder="Auto-generated if blank">

        @error('slug')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
