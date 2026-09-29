@php
    $url = '#';
    if ($item->type === 'content' && $item->content && $item->content->status === 'published') {
        if ($item->content->content_type === 'service') {
            $url = route('frontend.services.show', $item->content->slug);
        } elseif (in_array($item->content->content_type, ['blog', 'article'], true)) {
            $url = route('frontend.blog.show', $item->content->slug);
        }
    } elseif ($item->type === 'category' && $item->category && $item->category->status) {
        $url = route('frontend.search', ['category' => $item->category->slug]);
    } elseif ($item->type === 'custom_url' && $item->url) {
        $url = $item->url;
    }

    $isActive = $url !== '#' && url()->current() === url($url);
@endphp

<li>
    <a
        class="dropdown-item {{ $isActive ? 'active' : '' }}"
        href="{{ $url }}"
        target="{{ $item->target }}"
        @if($item->target === '_blank') rel="noopener noreferrer" @endif>
        {{ $item->title }}
    </a>
</li>
