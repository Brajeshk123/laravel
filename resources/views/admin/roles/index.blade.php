@extends('admin.layouts.app')

@section('title','Roles')

@section('page-title','Role Management')

@section('breadcrumb')
    <li class="breadcrumb-item">
        Administration
    </li>
    <li class="breadcrumb-item active" aria-current="page">
        Roles
    </li>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h4 class="mb-1">Roles</h4>
        <p class="text-muted mb-0">
            Manage roles and their permissions.
        </p>
    </div>

    @can('create roles')
        <a
            href="{{ route('admin.roles.create') }}"
            class="btn btn-primary">
            <i class="bi bi-shield-plus"></i>
            Create Role
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
                    placeholder="Search Role">

                <button class="btn btn-primary">

                    Search

                </button>

            </div>

        </form>

    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <thead>

            <tr>

                <th>#</th>

                <th>Name</th>

                <th>Permissions</th>

                <th width="240">

                    Action

                </th>

            </tr>

            </thead>

            <tbody>

            @forelse($roles as $role)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $role->name }}</td>

                    <td>
                        <span class="badge bg-secondary">
                            {{ $role->permissions_count }}
                        </span>
                    </td>

                    <td>
                        @can('edit roles')
                        <a href="{{ route('admin.roles.permissions.edit',$role->id) }}"
                        class="btn btn-info btn-sm">

                        Manage Permissions

                        </a>
                        <a href="{{ route('admin.roles.edit',$role->id) }}"
                            class="btn btn-warning btn-sm">

                            Edit

                        </a>
                        @endcan

                        @can('delete roles')
                        @if($role->name !== 'Super Admin')
                        <form
                            method="POST"
                            action="{{ route('admin.roles.destroy',$role->id) }}"
                            class="d-inline">

                            @csrf

                            @method('DELETE')

                            <button
                                onclick="return confirm('Delete this role?')"
                                class="btn btn-danger btn-sm">

                                Delete

                            </button>

                        </form>
                        @endif
                        @endcan

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="4" class="text-center">

                        No Roles Found

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

        {{ $roles->links() }}

    </div>

</div>

@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('admin/css/role.css') }}">
@endpush

@push('js')
<script src="{{ asset('admin/js/role.js') }}"></script>
@endpush
