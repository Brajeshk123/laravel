@extends('frontend.layouts.app')

@section('content')
    <section class="page-hero">
        <div class="container">
            @include('frontend.partials.breadcrumb', ['items' => ['Search' => null]])
            <div data-reveal>
                <div class="section-kicker mb-2">Search</div>
                <h1 class="hero-title mb-3">Find what is already live.</h1>
                <p class="hero-lead mb-0">Search public services, blog posts, and articles that are published on the site.</p>
            </div>
        </div>
    </section>

    <section class="frontend-section pt-0">
        <div class="container">
            <form method="GET" action="{{ route('frontend.search') }}" class="contact-panel mb-4" role="search" data-reveal>
                <div class="content-card-body">
                    <div class="row g-3 align-items-end">
                        <div class="col-lg-9">
                            <label for="search-query" class="form-label fw-semibold">Search term</label>
                            <input
                                id="search-query"
                                type="search"
                                name="q"
                                value="{{ $query }}"
                                class="form-control"
                                placeholder="Search published content">
                            @if($category)
                                <input type="hidden" name="category" value="{{ $category }}">
                            @endif
                        </div>
                        <div class="col-lg-3 d-grid">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mb-4" data-reveal>
                <p class="text-muted mb-0">
                    {{ $contents->total() }} {{ \Illuminate\Support\Str::plural('result', $contents->total()) }}
                    @if($query)
                        for "{{ $query }}"
                    @endif
                </p>
                @if($category)
                    <a href="{{ route('frontend.search', ['q' => $query]) }}" class="text-decoration-none">Clear category filter</a>
                @endif
            </div>

            <div class="row g-4">
                @forelse($contents as $content)
                    <div class="col-md-6 col-xl-4" data-reveal>
                        @include('frontend.partials.content-card', ['content' => $content])
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state">No published content matched your search.</div>
                    </div>
                @endforelse
            </div>

            <div class="mt-5">
                {{ $contents->links() }}
            </div>
        </div>
    </section>
@endsection
