@extends('frontend.layouts.app')

@php
    $seo = $seo ?? [
        'title' => 'Something went wrong',
        'description' => 'The site hit an unexpected error.',
        'robots' => 'noindex, follow',
        'canonical' => url()->current(),
    ];
@endphp

@section('content')
    @include('frontend.errors.500')
@endsection
