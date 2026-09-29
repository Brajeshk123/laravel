@php
    $children = $item->children?->where('status', true)->values() ?? collect();

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

@if($children->isNotEmpty())
    <li class="nav-item dropdown">
        <a
            class="nav-link dropdown-toggle {{ $isActive ? 'active' : '' }}"
            href="{{ $url }}"
            role="button"
            data-bs-toggle="dropdown"
            aria-expanded="false"
            target="{{ $item->target }}"
            @if($item->target === '_blank') rel="noopener noreferrer" @endif>
            {{ $item->title }}
        </a>
        <ul class="dropdown-menu">
            @foreach($children as $child)
                @include('frontend.partials.navigation-dropdown-item', ['item' => $child])
            @endforeach
        </ul>
    </li>
@else
    <li class="nav-item">
        <a
            class="nav-link {{ $isActive ? 'active' : '' }}"
            href="{{ $url }}"
            target="{{ $item->target }}"
            @if($item->target === '_blank') rel="noopener noreferrer" @endif>
            {{ $item->title }}
        </a>
    </li>
@endif
