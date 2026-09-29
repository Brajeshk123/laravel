@extends('frontend.layouts.app')

@section('content')
    <section class="page-hero">
        <div class="container">
            @include('frontend.partials.breadcrumb', ['items' => ['Blog' => null]])
            <div class="row g-4 align-items-end">
                <div class="col-lg-9" data-reveal>
                    <div class="section-kicker mb-2">Editorial</div>
                    <h1 class="hero-title mb-3">Ideas with a little gravity.</h1>
                    <p class="hero-lead mb-0">Published blog and article content, shaped into a modern reading experience.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="frontend-section pt-0">
        <div class="container">
            <form method="GET" action="{{ route('frontend.blog.index') }}" class="contact-panel mb-5" role="search" data-reveal>
                <div class="content-card-body">
                    <div class="row g-3 align-items-end">
                        <div class="col-lg-5">
                            <label for="blog-search" class="form-label fw-semibold">Search articles</label>
                            <input id="blog-search" type="search" name="q" value="{{ $query }}" class="form-control" placeholder="Keyword or topic">
                        </div>
                        <div class="col-lg-4">
                            <label for="blog-category" class="form-label fw-semibold">Category</label>
                            <select id="blog-category" name="category" class="form-select">
                                <option value="">All categories</option>
                                @foreach($categories as $item)
                                    <option value="{{ $item->slug }}" @selected($category === $item->slug)>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 d-grid">
                            <button class="btn btn-primary" type="submit">Filter</button>
                        </div>
                    </div>
                </div>
            </form>

            @if($featuredPost && ! $query && ! $category)
                <div class="featured-layout mb-5">
                    <div data-reveal>
                        @include('frontend.partials.content-card', ['content' => $featuredPost])
                    </div>
                    <div class="align-self-center" data-reveal>
                        <div class="section-kicker mb-2">Featured Article</div>
                        <h2 class="section-title mb-4">{{ $featuredPost->title }}</h2>
                        @if($featuredPost->excerpt)
                            <p class="hero-lead">{{ $featuredPost->excerpt }}</p>
                        @endif
                        <a href="{{ route('frontend.blog.show', $featuredPost->slug) }}" class="btn btn-primary">Read Featured</a>
                    </div>
                </div>
            @endif

            <div class="row g-4">
                @forelse($posts as $post)
                    <div class="col-md-6 col-xl-4" data-reveal>
                        @include('frontend.partials.content-card', ['content' => $post])
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state">No published blog posts found.</div>
                    </div>
                @endforelse
            </div>

            <div class="mt-5">
                {{ $posts->links() }}
            </div>
        </div>
    </section>
@endsection
