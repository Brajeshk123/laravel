@extends('admin.layouts.app')

@section('title','Create Role')

@section('page-title','Create Role')

@section('breadcrumb')
    <li class="breadcrumb-item">
        Administration
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.roles.index') }}">
            Roles
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
action="{{ route('admin.roles.store') }}">

@csrf

@include('admin.roles.form')

<button class="btn btn-primary mt-3">

Save Role

</button>

<a
href="{{ route('admin.roles.index') }}"
class="btn btn-secondary mt-3">

Cancel

</a>

</form>

</div>

</div>

@endsection
