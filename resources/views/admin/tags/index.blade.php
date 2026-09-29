@extends('admin.layouts.app')

@section('title', 'Tags')

@section('page-title', 'Tag Management')

@section('breadcrumb')
    <li class="breadcrumb-item">
        Content
    </li>
    <li class="breadcrumb-item active" aria-current="page">
        Tags
    </li>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Tags</h4>
        <p class="text-muted mb-0">
            Manage reusable content tags.
        </p>
    </div>

    @can('create tags')
        <a href="{{ route('admin.tags.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Create Tag
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
                    placeholder="Search tags...">

                <button class="btn btn-primary">
                    Search
                </button>

                <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">
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
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Usage</th>
                        <th>Created Date</th>
                        <th width="170">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tags as $tag)
                        <tr>
                            <td>{{ $tag->name }}</td>
                            <td>{{ $tag->slug }}</td>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ $tag->contents_count }}
                                </span>
                            </td>
                            <td>{{ $tag->created_at?->format('M d, Y') }}</td>
                            <td>
                                @can('edit tags')
                                    <a
                                        href="{{ route('admin.tags.edit', $tag->id) }}"
                                        class="btn btn-warning btn-sm">
                                        Edit
                                    </a>
                                @endcan

                                @can('delete tags')
                                    <form
                                        method="POST"
                                        action="{{ route('admin.tags.destroy', $tag->id) }}"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Delete this tag?')">
                                            Delete
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                No tags found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $tags->links() }}
    </div>
</div>

@endsection
