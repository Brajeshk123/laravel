@extends('admin.layouts.app')

@section('title', 'Create User')

@section('page-title', 'Create User')

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
        Create
    </li>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('admin.users.store') }}"
            enctype="multipart/form-data">

            @csrf

            @include('admin.users.form')

            <div class="mt-4">

                <button type="submit" class="btn btn-primary">
                    Create User
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
