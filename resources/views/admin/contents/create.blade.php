@extends('admin.layouts.app')

@section('title', 'Create Content')

@section('page-title', 'Create Content')

@section('breadcrumb')
    <li class="breadcrumb-item">
        Content
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.contents.index') }}">
            Contents
        </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
        Create
    </li>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <form
            method="POST"
            action="{{ route('admin.contents.store') }}"
            enctype="multipart/form-data">
            @csrf

            @include('admin.contents.form')

            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('admin.contents.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

@endsection
