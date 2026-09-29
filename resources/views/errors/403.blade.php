@extends('frontend.layouts.app')

@php
    $seo = $seo ?? [
        'title' => 'Access denied',
        'description' => 'You do not have permission to view this page.',
        'robots' => 'noindex, follow',
        'canonical' => url()->current(),
    ];
@endphp

@section('content')
    @include('frontend.errors.403')
@endsection
