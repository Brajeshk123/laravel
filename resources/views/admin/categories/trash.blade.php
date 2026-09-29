@extends('admin.layouts.app')

@section('title', 'Category Trash')

@section('page-title', 'Category Trash')

@section('breadcrumb')
    <li class="breadcrumb-item">
        Content
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.categories.index') }}">
            Categories
        </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
        Trash
    </li>
@endsection

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="mb-1">Category Trash</h2>

            <p class="text-muted mb-0">
                Deleted categories can be restored or permanently deleted.
            </p>
        </div>

        <a
            href="{{ route('admin.categories.index') }}"
            class="btn btn-secondary">

            <i class="bi bi-arrow-left"></i>
            Back to Categories

        </a>

    </div>


    {{-- Trash Table --}}
    <div class="card">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead class="table-light">

                        <tr>

                            <th width="80">#</th>

                            <th>Name</th>

                            <th>Slug</th>

                            <th>Deleted At</th>

                            <th width="220">Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($categories as $category)

                        <tr>

                            <td>
                                {{ $category->id }}
                            </td>

                            <td>
                                <strong>
                                    {{ $category->name }}
                                </strong>
                            </td>

                            <td>
                                <code>
                                    {{ $category->slug }}
                                </code>
                            </td>

                            <td>
                                {{ $category->deleted_at?->format('d M Y, h:i A') }}
                            </td>

                            <td>

                                {{-- Restore --}}
                                @can('restore categories')

                                    <form
                                        action="{{ route('admin.categories.restore', $category->id) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-success"
                                            onclick="return confirm('Restore this category?')">

                                            <i class="bi bi-arrow-counterclockwise"></i>
                                            Restore

                                        </button>

                                    </form>

                                @endcan


                                {{-- Permanent Delete --}}
                                @can('force delete categories')

                                    <form
                                        action="{{ route('admin.categories.force-delete', $category->id) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('This will permanently delete the category. Continue?')">

                                            <i class="bi bi-trash"></i>
                                            Delete Forever

                                        </button>

                                    </form>

                                @endcan

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="text-center py-5">

                                <i class="bi bi-trash3 fs-1 text-muted"></i>

                                <h5 class="mt-3">
                                    Trash is empty
                                </h5>

                                <p class="text-muted">
                                    There are no deleted categories.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- Pagination --}}

    <div class="mt-3">

        {{ $categories->links() }}

    </div>

</div>

@endsection
