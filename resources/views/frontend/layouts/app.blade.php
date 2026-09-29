@php
    $siteName = $settings['site_name'] ?? config('app.name');
    $pageTitle = $seo['title'] ?? $siteName;
    $description = $seo['description'] ?? ($settings['site_description'] ?? '');
    $favicon = $settings['favicon'] ?? '';
    $ogImage = $seo['og_image'] ?? '';
    $imageUrl = $ogImage
        ? (str_starts_with($ogImage, 'http') ? $ogImage : asset('storage/' . $ogImage))
        : null;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $pageTitle }}{{ $pageTitle !== $siteName ? ' | ' . $siteName : '' }}</title>

    @if($description)
        <meta name="description" content="{{ $description }}">
    @endif

    @if(! empty($seo['keywords']))
        <meta name="keywords" content="{{ $seo['keywords'] }}">
    @endif

    <meta name="robots" content="{{ $seo['robots'] ?? 'index, follow' }}">
    <link rel="canonical" href="{{ $seo['canonical'] ?? url()->current() }}">

    <meta property="og:title" content="{{ $seo['og_title'] ?? $pageTitle }}">
    @if(! empty($seo['og_description']))
        <meta property="og:description" content="{{ $seo['og_description'] }}">
    @endif
    @if($imageUrl)
        <meta property="og:image" content="{{ $imageUrl }}">
    @endif
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="{{ $seo['twitter_card'] ?? 'summary_large_image' }}">

    @if($favicon)
        <link rel="icon" href="{{ asset('storage/' . $favicon) }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/frontend.css', 'resources/js/frontend.js'])
</head>
<body class="d-flex flex-column min-vh-100">
    @include('frontend.partials.header')

    <main class="flex-grow-1">
        @yield('content')
    </main>

    @include('frontend.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
