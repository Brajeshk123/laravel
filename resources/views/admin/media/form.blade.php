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
        <label class="form-label">Media Name</label>
        <input
            type="text"
            name="name"
            value="{{ old('name') }}"
            class="form-control @error('name') is-invalid @enderror"
            placeholder="Optional; defaults to file name">

        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Image</label>
        <input
            type="file"
            name="image"
            id="media-image"
            accept="image/jpeg,image/png,image/webp"
            class="form-control @error('image') is-invalid @enderror">

        <div id="media-image-client-error" class="invalid-feedback d-none"></div>

        @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <div class="mt-3">
            <img
                id="media-image-preview"
                src=""
                alt="Image preview"
                class="img-fluid rounded border d-none"
                style="max-width: 300px; max-height: 200px; object-fit: cover;">
        </div>
    </div>
</div>

@once
@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('media-image');
    const preview = document.getElementById('media-image-preview');
    const error = document.getElementById('media-image-client-error');
    const maxSize = 10 * 1024 * 1024;
    let objectUrl = null;

    if (!input || !preview || !error) {
        return;
    }

    function clearPreview() {
        input.value = '';
        preview.src = '';
        preview.classList.add('d-none');

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
            showError('Image must not be larger than 10 MB.');
            return;
        }

        if (objectUrl) {
            URL.revokeObjectURL(objectUrl);
        }

        objectUrl = URL.createObjectURL(file);
        preview.src = objectUrl;
        preview.classList.remove('d-none');
    });
});
</script>
@endpush
@endonce
