@extends('frontend.layouts.app')

@php
    $image = $content->banner_image ?: $content->featured_image;
@endphp

@section('content')
    <article>
        <section class="page-hero">
            <div class="container">
                @include('frontend.partials.breadcrumb', [
                    'items' => [
                        'Services' => route('frontend.services.index'),
                        $content->title => null,
                    ],
                ])
                <div class="row g-4 align-items-end">
                    <div class="col-lg-9" data-reveal>
                        <div class="section-kicker mb-2">Service</div>
                        <h1 class="hero-title mb-3">{{ $content->title }}</h1>
                        @if($content->excerpt)
                            <p class="hero-lead mb-0">{{ $content->excerpt }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <section class="frontend-section pt-0">
            <div class="container">
                @if($image)
                    <div class="content-image" data-reveal>
                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $content->title }}" loading="eager">
                    </div>
                @endif

                <div class="row g-5">
                    <div class="col-lg-8" data-reveal>
                        <div class="article-body">
                            {!! $content->content !!}
                        </div>
                    </div>
                    <aside class="col-lg-4">
                        <div class="article-side content-card" data-reveal>
                            <div class="content-card-body">
                                <div class="section-kicker mb-2">Snapshot</div>
                                <h2 class="h3 section-title mb-4">Service details</h2>
                                <div class="d-flex flex-wrap gap-2 mb-4">
                                    @forelse($content->categories as $category)
                                        <a href="{{ route('frontend.search', ['category' => $category->slug]) }}" class="badge-soft text-decoration-none">
                                            {{ $category->name }}
                                        </a>
                                    @empty
                                        <span class="badge-soft">Service</span>
                                    @endforelse
                                </div>

                                @if($content->tags->isNotEmpty())
                                    <div class="border-top border-secondary-subtle pt-4">
                                        <h3 class="h6 fw-bold">Tags</h3>
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach($content->tags as $tag)
                                                <span class="badge text-bg-dark border">{{ $tag->name }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </section>
    </article>

    @if($relatedServices->isNotEmpty())
        <section class="frontend-section section-soft">
            <div class="container">
                <div class="section-kicker mb-2" data-reveal>More Services</div>
                <h2 class="section-title mb-5" data-reveal>Related directions to explore.</h2>
                <div class="service-grid">
                    @foreach($relatedServices as $service)
                        <a href="{{ route('frontend.services.show', $service->slug) }}" class="service-card text-decoration-none" data-reveal>
                            <div class="service-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                            <h3 class="section-title h2 mb-3">{{ $service->title }}</h3>
                            <p class="section-copy mb-0">{{ $service->excerpt }}</p>
                            <span class="service-arrow">Explore -></span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @include('frontend.partials.cta', [
        'kicker' => 'Need this service?',
        'title' => 'Turn the idea into a clear next step.',
        'text' => 'Share a few details and the conversation can start from context, not guesswork.',
    ])
@endsection
