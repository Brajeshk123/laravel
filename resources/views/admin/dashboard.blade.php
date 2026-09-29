@push('css')

<link rel="stylesheet"
      href="{{ asset('admin/css/dashboard.css') }}">

@endpush

@extends('admin.layouts.app')

@section('title','Dashboard')

@section('page-title','Dashboard')

@section('content')

<div class="row">

    <div class="col-md-3">

        <div class="card">

            <div class="card-body">

                <h6>Total Articles</h6>

                <h2>0</h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card">

            <div class="card-body">

                <h6>Categories</h6>

                <h2>0</h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card">

            <div class="card-body">

                <h6>Users</h6>

                <h2>1</h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card">

            <div class="card-body">

                <h6>Media</h6>

                <h2>0</h2>

            </div>

        </div>

    </div>

</div>

<div class="card mt-4">

    <div class="card-body">

        <h5>

            Welcome {{ Auth::user()->name }}

        </h5>

        <p>

            Laravel CMS Dashboard

        </p>

    </div>

</div>
@push('js')

<script src="{{ asset('admin/js/dashboard.js') }}"></script>

@endpush

@endsection