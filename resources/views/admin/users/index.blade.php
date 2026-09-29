
    @extends('admin.layouts.app')

    @section('title','Users')

    @section('page-title','User Management')

    @section('breadcrumb')
        <li class="breadcrumb-item">
            Administration
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            Users
        </li>
    @endsection

    @section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="mb-1">Users</h4>
            <p class="text-muted mb-0">
                Manage admin users and their roles.
            </p>
        </div>

        @can('create users')
            <a
                href="{{ route('admin.users.create') }}"
                class="btn btn-primary">
                <i class="bi bi-person-plus"></i>
                Create User
            </a>
        @endcan

    </div>

    <div class="card">

        <div class="card-header">

            <form method="GET">

                <div class="input-group">

                    <input
                        type="text"
                        class="form-control"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search user...">

                    <button class="btn btn-primary">

                        Search

                    </button>

                </div>

            </form>
        </div>

        <div class="card-body">

            <table class="table table-bordered align-middle">

                <thead>

                <tr>

                    <th width="80">Photo</th>

                    <th>Name</th>

                    <th>Email</th>

                    <th>Phone</th>

                    <th>Role</th>

                    <th>Status</th>

                    <th width="180">Action</th>

                </tr>

                </thead>

                <tbody>

                @forelse($users as $user)

                    <tr>

                        <td>

                            @if($user->profile_image)

                                <img
                                    src="{{ asset('storage/'.$user->profile_image) }}"
                                    width="50"
                                    class="rounded-circle">

                            @else

                                <img
                                    src="https://placehold.co/50x50"
                                    class="rounded-circle">

                            @endif

                        </td>

                        <td>{{ $user->name }}</td>

                        <td>{{ $user->email }}</td>

                        <td>{{ $user->phone }}</td>

                        <td>

                            <span class="badge bg-primary">

                                {{ $user->getRoleNames()->implode(', ') ?: 'No Role' }}

                            </span>

                        </td>

                        <td>

                            @if($user->status)

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

                            @can('edit users')
                            <a
                                href="{{ route('admin.users.edit',$user->id) }}"
                                class="btn btn-warning btn-sm">

                                Edit

                            </a>
                            @endcan

                            @can('delete users')
                            <form
                                action="{{ route('admin.users.destroy',$user->id) }}"
                                method="POST"
                                class="d-inline">

                                @csrf

                                @method('DELETE')

                                <button
                                    onclick="return confirm('Delete User?')"
                                    class="btn btn-danger btn-sm">

                                    Delete

                                </button>

                            </form>
                            @endcan

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7">

                            No Users Found

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

            {{ $users->withQueryString()->links() }}

        </div>

    </div>

    @endsection

    @push('css')
    <link rel="stylesheet"
    href="{{ asset('admin/css/user.css') }}">
    @endpush

    @push('js')
    <script src="{{ asset('admin/js/user.js') }}"></script>
    @endpush
