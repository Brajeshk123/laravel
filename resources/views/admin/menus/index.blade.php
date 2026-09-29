@extends('admin.layouts.app')

@section('title', 'Menus')

@section('page-title', 'Menu Management')

@section('breadcrumb')
    <li class="breadcrumb-item">
        Website
    </li>
    <li class="breadcrumb-item active" aria-current="page">
        Menus
    </li>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Menus</h4>
        <p class="text-muted mb-0">
            Manage website navigation menus.
        </p>
    </div>

    @can('create menus')
        <a href="{{ route('admin.menus.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Create Menu
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
                    placeholder="Search menus...">

                <button class="btn btn-primary">
                    Search
                </button>

                <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">
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
                        <th>Status</th>
                        <th>Items</th>
                        <th>Created Date</th>
                        <th width="170">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menus as $menu)
                        <tr>
                            <td>{{ $menu->name }}</td>
                            <td>{{ $menu->slug }}</td>
                            <td>
                                <span class="badge {{ $menu->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $menu->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ $menu->items_count }}
                                </span>
                            </td>
                            <td>{{ $menu->created_at?->format('M d, Y') }}</td>
                            <td>
                                @can('edit menus')
                                    <a
                                        href="{{ route('admin.menus.edit', $menu->id) }}"
                                        class="btn btn-warning btn-sm">
                                        Edit
                                    </a>
                                @endcan

                                @can('delete menus')
                                    <form
                                        method="POST"
                                        action="{{ route('admin.menus.destroy', $menu->id) }}"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Delete this menu?')">
                                            Delete
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                No menus found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $menus->links() }}
    </div>
</div>

@endsection
