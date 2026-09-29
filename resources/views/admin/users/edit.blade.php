@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('page-title', 'Edit User')

@section('breadcrumb')
    <li class="breadcrumb-item">
        Administration
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.users.index') }}">
            Users
        </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
        Edit
    </li>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <form
            method="POST"
            action="{{ route('admin.users.update', $user->id) }}"
            enctype="multipart/form-data">

            @csrf

            @method('PUT')

            @include('admin.users.form')

            <div class="mt-4">

                <button type="submit" class="btn btn-primary">
                    Update User
                </button>

                <a
                    href="{{ route('admin.users.index') }}"
                    class="btn btn-secondary">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

@endsection
