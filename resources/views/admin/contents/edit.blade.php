@extends('admin.layouts.app')

@section('title', 'Edit Content')

@section('page-title', 'Edit Content')

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
        Edit Content
    </li>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <form
            method="POST"
            action="{{ route('admin.contents.update', $content->id) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('admin.contents.form')

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.contents.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

@endsection
