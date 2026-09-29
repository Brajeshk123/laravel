@extends('admin.layouts.app')

@section('title', 'Upload Media')

@section('page-title', 'Upload Media')

@section('breadcrumb')
    <li class="breadcrumb-item">
        Content
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.media.index') }}">
            Media
        </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
        Upload
    </li>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <form
            method="POST"
            action="{{ route('admin.media.store') }}"
            enctype="multipart/form-data">
            @csrf

            @include('admin.media.form')

            <button class="btn btn-primary">
                Upload
            </button>
            <a href="{{ route('admin.media.index') }}" class="btn btn-secondary">
                Cancel
            </a>
        </form>
    </div>
</div>

@endsection
