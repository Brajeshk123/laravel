@extends('admin.layouts.app')

@section('title','Assign Permissions')

@section('page-title','Assign Permissions')

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
        Assign Permissions
    </li>
@endsection

@section('content')

<div class="card">

<div class="card-header d-flex justify-content-between align-items-center">

<div>

<h5 class="mb-1">

Role: {{ $role->name }}

</h5>

<p class="text-muted mb-0">

Select the permissions assigned to this role.

</p>

</div>

<a
href="{{ route('admin.roles.index') }}"
class="btn btn-secondary btn-sm">

Back

</a>

</div>

<div class="card-body">

<form
method="POST"
action="{{ route('admin.roles.permissions.update',$role->id) }}">

@csrf

@forelse($permissions as $module=>$items)

<div class="mb-4">

<h5 class="border-bottom pb-2">

{{ $module }}

</h5>

<div class="row">

@foreach($items as $permission)

<div class="col-md-3">

<div class="form-check">

<input

class="form-check-input"

type="checkbox"

name="permissions[]"

value="{{ $permission->id }}"

{{ $role->permissions->contains($permission->id)

? 'checked'

: '' }}

>

<label class="form-check-label">

{{ $permission->name }}

</label>

</div>

</div>

@endforeach

</div>

</div>

@empty

<p class="text-muted mb-0">

No permissions found.

</p>

@endforelse

<button class="btn btn-primary">

Save Permissions

</button>

<a
href="{{ route('admin.roles.index') }}"
class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

@endsection
