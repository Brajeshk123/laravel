@extends('admin.layouts.app')

@section('title', 'Edit Media')

@section('page-title', 'Edit Media')

@section('breadcrumb')
    <li class="breadcrumb-item">
        Content
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.media.index') }}">
            Media
        </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
        Edit
    </li>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <div class="mb-3">
            <img
                src="{{ $media->url }}"
                alt="{{ $media->name }}"
                class="img-fluid rounded border"
                style="max-width: 360px; max-height: 240px; object-fit: cover;">
        </div>

        <form method="POST" action="{{ route('admin.media.update', $media->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Media Name</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $media->name) }}"
                    class="form-control @error('name') is-invalid @enderror">

                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button class="btn btn-primary">
                Update
            </button>
            <a href="{{ route('admin.media.index') }}" class="btn btn-secondary">
                Cancel
            </a>
        </form>
    </div>
</div>

@endsection
