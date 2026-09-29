@extends('admin.layouts.app')

@section('title', 'Contents')

@section('page-title', 'Content Management')

@section('breadcrumb')
    <li class="breadcrumb-item">
        Content
    </li>
    <li class="breadcrumb-item active" aria-current="page">
        Contents
    </li>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Contents</h4>
        <p class="text-muted mb-0">
            Manage services, blogs, and articles.
        </p>
    </div>

    @can('create contents')
        <a href="{{ route('admin.contents.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Create Content
        </a>
    @endcan
</div>

<div class="card">
    <div class="card-header">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Search</label>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control"
                    placeholder="Search title or slug">
            </div>

            <div class="col-md-2">
                <label class="form-label">Type</label>
                <select name="content_type" class="form-select">
                    <option value="">All Types</option>
                    <option value="service" @selected(request('content_type') === 'service')>Service</option>
                    <option value="blog" @selected(request('content_type') === 'blog')>Blog</option>
                    <option value="article" @selected(request('content_type') === 'article')>Article</option>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                    <option value="published" @selected(request('status') === 'published')>Published</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) request('category_id') === (string) $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary">
                    Filter
                </button>
                <a href="{{ route('admin.contents.index') }}" class="btn btn-secondary">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Author</th>
                        <th>Created Date</th>
                        <th width="160">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contents as $content)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $content->title }}</div>
                                <small class="text-muted">{{ $content->slug }}</small>
                            </td>
                            <td>{{ ucfirst($content->content_type) }}</td>
                            <td>
                                {{ $content->categories->pluck('name')->implode(', ') ?: '-' }}
                            </td>
                            <td>
                                <span class="badge {{ $content->status === 'published' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($content->status) }}
                                </span>
                            </td>
                            <td>{{ $content->author->name ?? '-' }}</td>
                            <td>{{ $content->created_at?->format('M d, Y') }}</td>
                            <td>
                                @can('edit contents')
                                    <a
                                        href="{{ route('admin.contents.edit', $content->id) }}"
                                        class="btn btn-warning btn-sm">
                                        Edit
                                    </a>
                                @endcan

                                @can('delete contents')
                                    <form
                                        method="POST"
                                        action="{{ route('admin.contents.destroy', $content->id) }}"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Delete this content?')">
                                            Delete
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                No contents found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $contents->links() }}
    </div>
</div>

@endsection
