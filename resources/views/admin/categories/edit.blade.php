@extends('admin.layouts.app')

@section('title', 'Edit Category')

@section('page-title', 'Edit Category')

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
        Edit
    </li>
@endsection

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="mb-1">Edit Category</h2>

            <p class="text-muted mb-0">
                Update category information.
            </p>
        </div>

        <a
            href="{{ route('admin.categories.index') }}"
            class="btn btn-secondary">

            <i class="bi bi-arrow-left"></i>
            Back

        </a>

    </div>


    {{-- Validation Errors --}}

    @if ($errors->any())

        <div class="alert alert-danger">

            <strong>Please fix the following errors:</strong>

            <ul class="mb-0 mt-2">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="card">

        <div class="card-body">

            <form
                action="{{ route('admin.categories.update', $category) }}"
                method="POST">

                @csrf

                @method('PUT')


                <div class="row">


                    {{-- Name --}}

                    <div class="col-md-6 mb-3">

                        <label
                            for="name"
                            class="form-label">

                            Category Name
                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $category->name) }}">

                        @error('name')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- Slug --}}

                    <div class="col-md-6 mb-3">

                        <label
                            for="slug"
                            class="form-label">

                            Slug

                        </label>

                        <input
                            type="text"
                            name="slug"
                            id="slug"
                            class="form-control @error('slug') is-invalid @enderror"
                            value="{{ old('slug', $category->slug) }}">

                        @error('slug')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- Parent --}}

                    <div class="col-md-6 mb-3">

                        <label
                            for="parent_id"
                            class="form-label">

                            Parent Category

                        </label>

                        <select
                            name="parent_id"
                            id="parent_id"
                            class="form-select @error('parent_id') is-invalid @enderror">

                            <option value="">
                                — No Parent —
                            </option>

                            @foreach($parents as $parent)

                                <option
                                    value="{{ $parent->id }}"
                                    @selected(
                                        old(
                                            'parent_id',
                                            $category->parent_id
                                        ) == $parent->id
                                    )>

                                    {{ $parent->name }}

                                </option>

                            @endforeach

                        </select>

                        @error('parent_id')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- Sort Order --}}

                    <div class="col-md-3 mb-3">

                        <label
                            for="sort_order"
                            class="form-label">

                            Sort Order

                        </label>

                        <input
                            type="number"
                            name="sort_order"
                            id="sort_order"
                            min="0"
                            class="form-control"
                            value="{{ old('sort_order', $category->sort_order) }}">

                    </div>


                    {{-- Status --}}

                    <div class="col-md-3 mb-3">

                        <label
                            for="status"
                            class="form-label">

                            Status

                        </label>

                        <select
                            name="status"
                            id="status"
                            class="form-select">

                            <option
                                value="1"
                                @selected(old('status', $category->status) == 1)>

                                Active

                            </option>

                            <option
                                value="0"
                                @selected(old('status', $category->status) == 0)>

                                Inactive

                            </option>

                        </select>

                    </div>


                    {{-- Icon --}}

                    <div class="col-md-6 mb-3">

                        <label
                            for="icon"
                            class="form-label">

                            Icon

                        </label>

                        <input
                            type="text"
                            name="icon"
                            id="icon"
                            class="form-control"
                            value="{{ old('icon', $category->icon) }}"
                            placeholder="bi bi-folder">

                    </div>


                    {{-- Thumbnail --}}

                    <div class="col-md-6 mb-3">

                        <label
                            for="thumbnail"
                            class="form-label">

                            Thumbnail

                        </label>

                        <input
                            type="text"
                            name="thumbnail"
                            id="thumbnail"
                            class="form-control"
                            value="{{ old('thumbnail', $category->thumbnail) }}">

                    </div>


                    {{-- Description --}}

                    <div class="col-12 mb-3">

                        <label
                            for="description"
                            class="form-label">

                            Description

                        </label>

                        <textarea
                            name="description"
                            id="description"
                            rows="5"
                            class="form-control">{{ old('description', $category->description) }}</textarea>

                    </div>

                </div>


                <hr>


                <div class="d-flex justify-content-end gap-2">

                    <a
                        href="{{ route('admin.categories.index') }}"
                        class="btn btn-light">

                        Cancel

                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="bi bi-check-circle"></i>

                        Update Category

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
