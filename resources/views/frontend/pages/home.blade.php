@extends('frontend.layouts.app')

@php
    $siteName = $settings['site_name'] ?? config('app.name');
    $siteDescription = $settings['site_description'] ?? 'A modern CMS-powered website.';
    $heroContent = $featuredContent->first() ?? $latestPosts->first() ?? $featuredServices->first();
    $heroImage = $heroContent?->banner_image ?: $heroContent?->featured_image;
    $primaryFeature = $featuredContent->first();
    $secondaryFeatures = $featuredContent->skip(1)->take(3);
    $featuredPost = $latestPosts->first();
    $secondaryPosts = $latestPosts->skip(1)->take(2);
@endphp

@section('content')
    <section class="hero-section">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-7" data-reveal>
                    <div class="section-kicker mb-3">Dynamic CMS Experience</div>
                    <h1 class="hero-title mb-4">
                        {{ $siteName }} without the <span class="text-gradient">template feel.</span>
                    </h1>
                    <p class="hero-lead mb-4">{{ $siteDescription }}</p>
                    <div class="d-flex flex-column flex-sm-row gap-3">
                        <a href="{{ route('frontend.services.index') }}" class="btn btn-primary">Explore Services</a>
                        <a href="{{ route('frontend.blog.index') }}" class="btn btn-glass">Read Insights</a>
                    </div>
                </div>

                <div class="col-lg-5" data-reveal>
                    <div class="hero-shell">
                        <div class="hero-visual">
                            @if($heroImage)
                                <img src="{{ asset('storage/' . $heroImage) }}" alt="{{ $heroContent->title }}" loading="eager">
                            @else
                                <div class="hero-composition" aria-hidden="true">
                                    <div class="visual-panel large">
                                        <div>
                                            <div class="section-kicker text-white-50 mb-2">Live Content</div>
                                            <h2 class="h1 fw-bold mb-0">{{ $siteName }}</h2>
                                        </div>
                                    </div>
                                    <div class="visual-panel small">
                                        <span class="mini-line"></span>
                                        <span class="mini-line"></span>
                                        <span class="mini-line"></span>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="metric-strip">
                            <div class="metric">
                                <strong>{{ $featuredServices->count() }}</strong>
                                <span class="text-muted small">Services</span>
                            </div>
                            <div class="metric">
                                <strong>{{ $latestPosts->count() }}</strong>
                                <span class="text-muted small">Articles</span>
                            </div>
                            <div class="metric">
                                <strong>{{ $featuredContent->count() }}</strong>
                                <span class="text-muted small">Featured</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="intro-strip" data-reveal>
        <div class="container">
            <div class="marquee-text">
                <span>Settings driven branding</span>
                <span>Dynamic menu structure</span>
                <span>Published content only</span>
                <span>SEO-aware detail pages</span>
            </div>
        </div>
    </section>

    <section class="frontend-section">
        <div class="container">
            <div class="row g-4 align-items-end mb-5" data-reveal>
                <div class="col-lg-8">
                    <div class="section-kicker mb-2">Services</div>
                    <h2 class="section-title mb-0">Built as bold, numbered experiences.</h2>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('frontend.services.index') }}" class="btn btn-glass">All Services</a>
                </div>
            </div>

            <div class="service-grid">
                @forelse($featuredServices as $service)
                    <a href="{{ route('frontend.services.show', $service->slug) }}" class="service-card text-decoration-none" data-reveal>
                        <div class="service-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                        <h3 class="section-title h2 mb-3">{{ $service->title }}</h3>
                        @if($service->excerpt)
                            <p class="section-copy mb-0">{{ $service->excerpt }}</p>
                        @endif
                        <span class="service-arrow">Explore -></span>
                    </a>
                @empty
                    <div class="empty-state grid-column-1">Published services will appear here.</div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="frontend-section section-soft">
        <div class="container">
            <div class="featured-layout">
                <div data-reveal>
                    <div class="section-kicker mb-2">Featured</div>
                    <h2 class="section-title mb-4">Editorial highlights from your CMS.</h2>

                    @if($primaryFeature)
                        <article class="feature-card">
                            <a href="{{ $primaryFeature->content_type === 'service' ? route('frontend.services.show', $primaryFeature->slug) : route('frontend.blog.show', $primaryFeature->slug) }}" class="card-image text-decoration-none">
                                @if($primaryFeature->featured_image || $primaryFeature->banner_image)
                                    <img src="{{ asset('storage/' . ($primaryFeature->featured_image ?: $primaryFeature->banner_image)) }}" alt="{{ $primaryFeature->title }}" loading="lazy">
                                @else
                                    <span class="card-image-fallback">{{ mb_substr($primaryFeature->title, 0, 1) }}</span>
                                @endif
                            </a>
                            <div class="content-card-body">
                                <div class="meta-row mb-3">
                                    <span class="badge-soft">{{ ucfirst($primaryFeature->content_type) }}</span>
                                    @if($primaryFeature->published_at)
                                        <span>{{ $primaryFeature->published_at->format('M d, Y') }}</span>
                                    @endif
                                </div>
                                <h3 class="section-title h1 mb-3">{{ $primaryFeature->title }}</h3>
                                <p class="section-copy">{{ $primaryFeature->excerpt }}</p>
                                <a href="{{ $primaryFeature->content_type === 'service' ? route('frontend.services.show', $primaryFeature->slug) : route('frontend.blog.show', $primaryFeature->slug) }}" class="btn btn-primary mt-auto align-self-start">Read Feature</a>
                            </div>
                        </article>
                    @else
                        <div class="empty-state">Featured content will appear here when published.</div>
                    @endif
                </div>

                <div class="stack-list align-self-end" data-reveal>
                    @forelse($secondaryFeatures as $content)
                        <a href="{{ $content->content_type === 'service' ? route('frontend.services.show', $content->slug) : route('frontend.blog.show', $content->slug) }}" class="stack-item text-decoration-none">
                            <div class="meta-row mb-2">
                                <span class="badge-soft">{{ ucfirst($content->content_type) }}</span>
                            </div>
                            <h3 class="h5 fw-bold mb-2">{{ $content->title }}</h3>
                            <p class="text-muted mb-0">{{ $content->excerpt }}</p>
                        </a>
                    @empty
                        <div class="stack-item text-muted">More featured entries will stack here.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <section class="frontend-section">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6" data-reveal>
                    <div class="section-kicker mb-2">CMS Value</div>
                    <h2 class="section-title mb-4">Designed for editors, experienced by visitors.</h2>
                </div>
                <div class="col-lg-6" data-reveal>
                    <div class="gradient-border rounded-5 p-4 p-lg-5">
                        <p class="hero-lead mb-4">The public frontend stays connected to Settings, Menus, Content, Categories, Tags, Media, and SEO so the admin panel remains the source of truth.</p>
                        <div class="row g-3">
                            <div class="col-sm-6"><span class="badge-soft">Dynamic Navigation</span></div>
                            <div class="col-sm-6"><span class="badge-soft">Featured Media</span></div>
                            <div class="col-sm-6"><span class="badge-soft">SEO Fallbacks</span></div>
                            <div class="col-sm-6"><span class="badge-soft">Published Only</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="frontend-section section-soft">
        <div class="container">
            <div class="row g-4 align-items-end mb-5" data-reveal>
                <div class="col-lg-8">
                    <div class="section-kicker mb-2">Journal</div>
                    <h2 class="section-title mb-0">Latest thinking, shaped like an editorial desk.</h2>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('frontend.blog.index') }}" class="btn btn-glass">Open Blog</a>
                </div>
            </div>

            <div class="featured-layout">
                @if($featuredPost)
                    <div data-reveal>
                        @include('frontend.partials.content-card', ['content' => $featuredPost])
                    </div>
                @else
                    <div class="empty-state">Latest articles will appear here.</div>
                @endif

                <div class="stack-list" data-reveal>
                    @forelse($secondaryPosts as $post)
                        <a href="{{ route('frontend.blog.show', $post->slug) }}" class="stack-item text-decoration-none">
                            <div class="meta-row mb-2">
                                @if($post->published_at)
                                    <span>{{ $post->published_at->format('M d, Y') }}</span>
                                @endif
                            </div>
                            <h3 class="h5 fw-bold mb-2">{{ $post->title }}</h3>
                            <p class="text-muted mb-0">{{ $post->excerpt }}</p>
                        </a>
                    @empty
                        <div class="stack-item text-muted">More articles will appear here.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    @include('frontend.partials.cta', [
        'kicker' => 'Next step',
        'title' => "Let's build something meaningful.",
        'text' => 'Use the contact page to start a conversation. The form validates safely now and can be connected to mail delivery later.',
        'label' => 'Get Started',
    ])
@endsection
