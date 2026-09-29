@php
    $type = $content->content_type;
    $url = $type === 'service'
        ? route('frontend.services.show', $content->slug)
        : route('frontend.blog.show', $content->slug);
    $image = $content->featured_image ?: $content->banner_image;
    $category = $content->categories->first();
@endphp

<article class="content-card">
    <a href="{{ $url }}" class="card-image text-decoration-none" aria-label="{{ $content->title }}">
        @if($image)
            <img src="{{ asset('storage/' . $image) }}" alt="{{ $content->title }}" loading="lazy">
        @else
            <span class="card-image-fallback">{{ mb_substr($content->title, 0, 1) }}</span>
        @endif
    </a>

    <div class="content-card-body">
        <div class="meta-row mb-3">
            @if($category)
                <span class="badge-soft">{{ $category->name }}</span>
            @else
                <span class="badge-soft">{{ ucfirst($type) }}</span>
            @endif

            @if($content->published_at)
                <span>{{ $content->published_at->format('M d, Y') }}</span>
            @endif
        </div>

        <h2 class="h5 section-title mb-2">
            <a href="{{ $url }}" class="text-decoration-none text-reset">{{ $content->title }}</a>
        </h2>

        @if($content->excerpt)
            <p class="text-muted mb-4">{{ $content->excerpt }}</p>
        @endif

        <a href="{{ $url }}" class="btn btn-glass mt-auto align-self-start">
            Read More
        </a>
    </div>
</article>
