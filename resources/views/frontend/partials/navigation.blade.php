<ul class="navbar-nav ms-auto align-items-lg-center">
    @forelse($items as $item)
        @include('frontend.partials.navigation-item', ['item' => $item])
    @empty
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('frontend.services.*') ? 'active' : '' }}" href="{{ route('frontend.services.index') }}">
                Services
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('frontend.blog.*') ? 'active' : '' }}" href="{{ route('frontend.blog.index') }}">
                Blog
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('frontend.contact') ? 'active' : '' }}" href="{{ route('frontend.contact') }}">
                Contact
            </a>
        </li>
    @endforelse
</ul>
