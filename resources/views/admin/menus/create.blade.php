@extends('admin.layouts.app')

@section('title', 'Create Menu')

@section('page-title', 'Create Menu')

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
        Create
    </li>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.menus.store') }}">
            @csrf

            @include('admin.menus.form')

            <button class="btn btn-primary">
                Save Menu
            </button>
            <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">
                Cancel
            </a>
        </form>
    </div>
</div>

@endsection
