@extends('admin.layouts.app')

@section('title', 'Permissions')

@section('page-title', 'Permission Management')

@section('breadcrumb')
    <li class="breadcrumb-item">
        Administration
    </li>
    <li class="breadcrumb-item active" aria-current="page">
        Permissions
    </li>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Permissions</h4>
        <p class="text-muted mb-0">
            Review the Spatie permissions available in the system.
        </p>
    </div>
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
                    placeholder="Search permissions...">

                <button class="btn btn-primary">
                    Search
                </button>

                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="card-body">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th width="70">#</th>
                    <th>Permission</th>
                    <th width="140">Guard</th>
                    <th>Roles</th>
                </tr>
            </thead>

            <tbody>
                @forelse($permissions as $permission)
                    <tr>
                        <td>{{ $permissions->firstItem() + $loop->index }}</td>
                        <td>{{ $permission->name }}</td>
                        <td>
                            <span class="badge bg-secondary">
                                {{ $permission->guard_name }}
                            </span>
                        </td>
                        <td>
                            @forelse($permission->roles as $role)
                                <span class="badge bg-primary">
                                    {{ $role->name }}
                                </span>
                            @empty
                                <span class="text-muted">No roles assigned</span>
                            @endforelse
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            No permissions found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $permissions->withQueryString()->links() }}
    </div>
</div>

@endsection
