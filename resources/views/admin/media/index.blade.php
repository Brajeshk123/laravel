@extends('admin.layouts.app')

@section('title', 'Media Library')

@section('page-title', 'Media Library')

@section('breadcrumb')
    <li class="breadcrumb-item">
        Content
    </li>
    <li class="breadcrumb-item active" aria-current="page">
        Media
    </li>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Media Library</h4>
        <p class="text-muted mb-0">
            Browse and manage uploaded images.
        </p>
    </div>

    @can('create media')
        <a href="{{ route('admin.media.create') }}" class="btn btn-primary">
            <i class="bi bi-cloud-upload"></i>
            Upload Media
        </a>
    @endcan
</div>

<div class="card">
    <div class="card-header">
        <form method="GET">
            <div class="input-group">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control"
                    placeholder="Search file name, title, or type...">

                <button class="btn btn-primary">
                    Search
                </button>

                <a href="{{ route('admin.media.index') }}" class="btn btn-secondary">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="card-body">
        <div class="row g-3">
            @forelse($media as $item)
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="card h-100">
                        <img
                            src="{{ $item->url }}"
                            alt="{{ $item->name }}"
                            class="card-img-top"
                            style="height: 160px; object-fit: cover;">

                        <div class="card-body">
                            <h6 class="card-title text-truncate" title="{{ $item->name }}">
                                {{ $item->name }}
                            </h6>

                            <div class="small text-muted">
                                <div class="text-truncate" title="{{ $item->file_name }}">
                                    {{ basename($item->file_name) }}
                                </div>
                                <div>{{ $item->human_size }}</div>
                                <div>{{ $item->mime_type }}</div>
                                <div>Uploaded {{ $item->created_at?->format('M d, Y') }}</div>
                                <div>By {{ $item->model->name ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="card-footer d-flex gap-2">
                            @can('edit media')
                                <a
                                    href="{{ route('admin.media.edit', $item->id) }}"
                                    class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                            @endcan

                            @can('delete media')
                                <form
                                    method="POST"
                                    action="{{ route('admin.media.destroy', $item->id) }}"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete this media file?')">
                                        Delete
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-muted mb-0">
                        No media found.
                    </p>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $media->links() }}
        </div>
    </div>
</div>

@endsection
