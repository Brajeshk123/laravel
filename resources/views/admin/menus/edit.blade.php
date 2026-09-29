@extends('admin.layouts.app')

@section('title', 'Edit Menu')

@section('page-title', 'Edit Menu')

@section('breadcrumb')
    <li class="breadcrumb-item">
        Website
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.menus.index') }}">
            Menus
        </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
        Edit
    </li>
@endsection

@section('content')

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

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Edit Menu</h4>
        <p class="text-muted mb-0">
            Update menu details and navigation items.
        </p>
    </div>

    <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i>
        Back
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.menus.update', $menu->id) }}">
            @csrf
            @method('PUT')

            @include('admin.menus.form')

            <button class="btn btn-primary">
                Update Menu
            </button>
        </form>
    </div>
</div>

@can('edit menus')
    <div class="card mb-4">
        <div class="card-header">
            Add Menu Item
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.menus.items.store', $menu->id) }}">
                @csrf
                @include('admin.menus.item-form', [
                    'item' => null,
                    'buttonText' => 'Add Item',
                    'parentItems' => $menu->items,
                ])
            </form>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        Menu Items
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th width="190">Title</th>
                        <th width="150">Type</th>
                        <th>Linked To</th>
                        <th width="150">Parent</th>
                        <th width="110">Sort</th>
                        <th width="130">Target</th>
                        <th width="120">Status</th>
                        <th width="190">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menu->items as $item)
                        @php
                            $formId = 'menu-item-form-' . $item->id;
                        @endphp
                        <tr>
                            <td>
                                <input
                                    type="text"
                                    name="title"
                                    form="{{ $formId }}"
                                    class="form-control form-control-sm"
                                    value="{{ old('title', $item->title) }}">
                            </td>
                            <td>
                                <select
                                    name="type"
                                    form="{{ $formId }}"
                                    class="form-select form-select-sm menu-item-type">
                                    <option value="content" @selected(old('type', $item->type) === 'content')>
                                        Content
                                    </option>
                                    <option value="category" @selected(old('type', $item->type) === 'category')>
                                        Category
                                    </option>
                                    <option value="custom_url" @selected(old('type', $item->type) === 'custom_url')>
                                        Custom URL
                                    </option>
                                </select>
                            </td>
                            <td>
                                @include('admin.menus.item-target-fields', ['item' => $item, 'formId' => $formId])
                            </td>
                            <td>
                                <select
                                    name="parent_id"
                                    form="{{ $formId }}"
                                    class="form-select form-select-sm">
                                    <option value="">No Parent</option>
                                    @foreach($menu->items as $parentItem)
                                        @continue($parentItem->id === $item->id)
                                        <option value="{{ $parentItem->id }}" @selected(old('parent_id', $item->parent_id) == $parentItem->id)>
                                            {{ $parentItem->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input
                                    type="number"
                                    name="sort_order"
                                    form="{{ $formId }}"
                                    min="0"
                                    class="form-control form-control-sm"
                                    value="{{ old('sort_order', $item->sort_order) }}">
                            </td>
                            <td>
                                <select
                                    name="target"
                                    form="{{ $formId }}"
                                    class="form-select form-select-sm">
                                    <option value="_self" @selected(old('target', $item->target) === '_self')>
                                        Same tab
                                    </option>
                                    <option value="_blank" @selected(old('target', $item->target) === '_blank')>
                                        New tab
                                    </option>
                                </select>
                            </td>
                            <td>
                                <select
                                    name="status"
                                    form="{{ $formId }}"
                                    class="form-select form-select-sm">
                                    <option value="1" @selected(old('status', $item->status) == 1)>
                                        Active
                                    </option>
                                    <option value="0" @selected(old('status', $item->status) == 0)>
                                        Inactive
                                    </option>
                                </select>
                            </td>
                            <td>
                                <form
                                    id="{{ $formId }}"
                                    method="POST"
                                    action="{{ route('admin.menus.items.update', [$menu->id, $item->id]) }}"
                                    class="d-inline">
                                    @csrf
                                    @method('PUT')

                                    <button class="btn btn-sm btn-primary">
                                        Update
                                    </button>
                                </form>

                                <form
                                    method="POST"
                                    action="{{ route('admin.menus.items.destroy', [$menu->id, $item->id]) }}"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this menu item?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                No menu items found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.menu-item-type').forEach((select) => {
            const updateFields = () => {
                const scope = select.closest('form') || select.closest('tr');
                scope.querySelectorAll('[data-menu-target]').forEach((field) => {
                    field.classList.toggle('d-none', field.dataset.menuTarget !== select.value);
                });
            };

            select.addEventListener('change', updateFields);
            updateFields();
        });
    </script>
@endpush
