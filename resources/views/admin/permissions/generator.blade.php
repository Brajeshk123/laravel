@extends('admin.layouts.app')

@section('title','Permission Generator')

@section('page-title','Permission Generator')

@section('content')

<div class="card">

    <div class="card-body">

        <form method="POST"
              action="{{ route('admin.permission-generator.store') }}">

            @csrf

            <div class="mb-3">

                <label>Module Name</label>

                <input
                    type="text"
                    name="module"
                    class="form-control"
                    placeholder="Example: Users">

            </div>

            <button class="btn btn-primary">

                Generate Permissions

            </button>

        </form>

    </div>

</div>

@endsection