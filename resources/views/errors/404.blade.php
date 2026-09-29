@extends('frontend.layouts.app')

@php
    $seo = $seo ?? [
        'title' => 'Page not found',
        'description' => 'The requested page could not be found.',
        'robots' => 'noindex, follow',
        'canonical' => url()->current(),
    ];
@endphp

@section('content')
    @include('frontend.errors.404')
@endsection
