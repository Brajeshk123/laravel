@extends('admin.layouts.app')

@section('title', 'Categories')

@section('page-title', 'Category Management')

@section('breadcrumb')
    <li class="breadcrumb-item">
        Content
    </li>
    <li class="breadcrumb-item active" aria-current="page">
        Categories
    </li>
@endsection

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="mb-0">Categories</h2>
            <small class="text-muted">
                Manage all content categories
            </small>
        </div>

        <div class="d-flex gap-2">
        @canany(['delete categories', 'restore categories'])
            <a href="{{ route('admin.categories.trash') }}"
                class="btn btn-outline-danger">

                <i class="bi bi-trash3"></i>
                Trash
                @if($trashCount > 0)
                    <span class="badge bg-danger ms-1">
                        {{ $trashCount }}
                    </span>
                @endif
            </a>
        @endcanany
        
            @can('create categories')
                <a
                    href="{{ route('admin.categories.create') }}"
                    class="btn btn-primary">

                    <i class="bi bi-plus-circle"></i>
                    Add Category

                </a>
            @endcan

        </div>

    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Search --}}
    <div class="card mb-4">
        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-md-4">

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search category..."
                            value="{{ request('search') }}">

                    </div>

                    <div class="col-md-2">

                        <button class="btn btn-dark w-100">
                            <i class="bi bi-search"></i>
                            Search
                        </button>

                    </div>

                </div>

            </form>

        </div>
    </div>

    {{-- Table --}}
    <div class="card">

        <div class="card-body p-0">

            <table class="table table-hover mb-0">

                <thead class="table-light">

                    <tr>

                        <th width="80">#</th>

                        <th>Name</th>

                        <th>Parent</th>

                        <th>Status</th>

                        <th width="100">Sort</th>

                        <th width="180">Actions</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($categories as $category)

                    <tr>

                        <td>{{ $category->id }}</td>

                        <td>
                            <strong>{{ $category->name }}</strong>
                        </td>

                        <td>
                            {{ $category->parent?->name ?? '-' }}
                        </td>

                        <td>

                            @if($category->status)

                                <span class="badge bg-success">
                                    Active
                                </span>

                            @else

                                <span class="badge bg-danger">
                                    Inactive
                                </span>

                            @endif

                        </td>

                        <td>

                            {{ $category->sort_order }}

                        </td>

                        <td>

                            @can('edit categories')
                                <a
                                    href="{{ route('admin.categories.edit', $category) }}"
                                    class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            @endcan

                            @can('delete categories')
                            <form
                                action="{{ route('admin.categories.destroy',$category) }}"
                                method="POST"
                                class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button
                                    onclick="return confirm('Delete this category?')"
                                    class="btn btn-sm btn-danger">

                                    <i class="bi bi-trash"></i>

                                </button>

                            </form>
                        @endcan
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="text-center py-4">

                            No categories found.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="mt-3">

        {{ $categories->links() }}

    </div>

</div>

@endsection
