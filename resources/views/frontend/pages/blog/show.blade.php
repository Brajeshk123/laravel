@extends('frontend.layouts.app')

@php
    $image = $content->banner_image ?: $content->featured_image;
    $category = $content->categories->first();
    $readingTime = max(1, ceil(str_word_count(strip_tags($content->content ?? '')) / 220));
@endphp

@section('content')
    <article>
        <section class="page-hero">
            <div class="container">
                @include('frontend.partials.breadcrumb', [
                    'items' => [
                        'Blog' => route('frontend.blog.index'),
                        $content->title => null,
                    ],
                ])
                <div class="row justify-content-center">
                    <div class="col-lg-11" data-reveal>
                        <div class="meta-row mb-3">
                            @if($category)
                                <a href="{{ route('frontend.blog.index', ['category' => $category->slug]) }}" class="badge-soft text-decoration-none">
                                    {{ $category->name }}
                                </a>
                            @endif
                            @if($content->published_at)
                                <span>{{ $content->published_at->format('M d, Y') }}</span>
                            @endif
                            <span>{{ $readingTime }} min read</span>
                        </div>
                        <h1 class="hero-title mb-4">{{ $content->title }}</h1>
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
                                <div class="section-kicker mb-2">Article Info</div>
                                <h2 class="h3 section-title mb-4">Reading notes</h2>
                                <div class="meta-row mb-4">
                                    @if($content->published_at)
                                        <span>{{ $content->published_at->format('M d, Y') }}</span>
                                    @endif
                                    <span>{{ $readingTime }} min read</span>
                                </div>

                                @if($content->tags->isNotEmpty())
                                    <h3 class="h6 fw-bold">Tags</h3>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($content->tags as $tag)
                                            <span class="badge text-bg-dark border">{{ $tag->name }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </aside>
                </div>

                <div class="row g-3 mt-5">
                    @if($previousPost)
                        <div class="col-md-6" data-reveal>
                            <a href="{{ route('frontend.blog.show', $previousPost->slug) }}" class="stack-item d-block text-decoration-none h-100">
                                <span class="text-muted small">Previous</span>
                                <strong class="d-block text-white">{{ $previousPost->title }}</strong>
                            </a>
                        </div>
                    @endif
                    @if($nextPost)
                        <div class="col-md-6" data-reveal>
                            <a href="{{ route('frontend.blog.show', $nextPost->slug) }}" class="stack-item d-block text-decoration-none h-100 text-md-end">
                                <span class="text-muted small">Next</span>
                                <strong class="d-block text-white">{{ $nextPost->title }}</strong>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </article>

    @if($relatedPosts->isNotEmpty())
        <section class="frontend-section section-soft">
            <div class="container">
                <div class="section-kicker mb-2" data-reveal>Keep Reading</div>
                <h2 class="section-title mb-5" data-reveal>Related articles</h2>
                <div class="row g-4">
                    @foreach($relatedPosts as $post)
                        <div class="col-md-6 col-lg-4" data-reveal>
                            @include('frontend.partials.content-card', ['content' => $post])
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @include('frontend.partials.cta', [
        'kicker' => 'Talk with us',
        'title' => 'Want to discuss this topic?',
        'text' => 'Send a message from the contact page and bring the conversation with you.',
    ])
@endsection
