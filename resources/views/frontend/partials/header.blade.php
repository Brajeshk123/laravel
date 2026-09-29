@php
    $siteName = $settings['site_name'] ?? config('app.name');
    $logo = $settings['logo'] ?? '';
@endphp

<header class="site-header" data-site-header>
    <nav class="navbar navbar-expand-lg" aria-label="Primary navigation">
        <div class="container">
            <a class="navbar-brand fw-semibold d-flex align-items-center gap-2" href="{{ route('frontend.home') }}">
                @if($logo)
                    <img src="{{ asset('storage/' . $logo) }}" alt="{{ $siteName }}" class="brand-logo">
                    <span>{{ $siteName }}</span>
                @else
                    <span class="brand-mark" aria-hidden="true">{{ mb_substr($siteName, 0, 1) }}</span>
                    <span>{{ $siteName }}</span>
                @endif
            </a>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#frontendNavbar"
                aria-controls="frontendNavbar"
                aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="frontendNavbar">
                @include('frontend.partials.navigation', ['items' => $navigation ?? collect()])

                <form class="d-flex ms-lg-3 mt-3 mt-lg-0 gap-2" method="GET" action="{{ route('frontend.search') }}" role="search">
                    <label class="visually-hidden" for="header-search">Search</label>
                    <input
                        id="header-search"
                        class="form-control form-control-sm header-search"
                        type="search"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Search">
                    <button class="btn btn-sm btn-primary" type="submit">Go</button>
                </form>

                <a href="{{ route('frontend.contact') }}" class="btn btn-sm btn-glass ms-lg-2 mt-3 mt-lg-0">
                    Get Started
                </a>
            </div>
        </div>
    </nav>
</header>
