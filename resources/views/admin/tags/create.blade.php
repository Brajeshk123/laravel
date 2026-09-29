@extends('admin.layouts.app')

@section('title', 'Create Tag')

@section('page-title', 'Create Tag')

@section('breadcrumb')
    <li class="breadcrumb-item">
        Content
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.tags.index') }}">
            Tags
        </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
        Create
    </li>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.tags.store') }}">
            @csrf

            @include('admin.tags.form')

            <button class="btn btn-primary">
                Save Tag
            </button>
            <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">
                Cancel
            </a>
        </form>
    </div>
</div>

@endsection
