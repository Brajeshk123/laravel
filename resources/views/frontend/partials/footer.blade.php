@php
    $siteName = $settings['site_name'] ?? config('app.name');
    $socialLinks = [
        'Facebook' => $settings['facebook_url'] ?? '',
        'Instagram' => $settings['instagram_url'] ?? '',
        'LinkedIn' => $settings['linkedin_url'] ?? '',
        'YouTube' => $settings['youtube_url'] ?? '',
        'Twitter' => $settings['twitter_url'] ?? '',
    ];
@endphp

<footer class="site-footer">
    <div class="container">
        <div class="cta-band mb-5" data-reveal>
            <div class="row g-4 align-items-center">
                <div class="col-lg-8">
                    <div class="section-kicker text-white-50 mb-2">Ready when you are</div>
                    <h2 class="section-title h1 mb-0">Let's build something meaningful.</h2>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('frontend.contact') }}" class="btn btn-light">Get Started</a>
                </div>
            </div>
        </div>

        <div class="row g-4 align-items-start">
            <div class="col-lg-5">
                <a class="footer-title h4 text-decoration-none d-inline-flex align-items-center gap-2 mb-3" href="{{ route('frontend.home') }}">
                    {{ $siteName }}
                </a>
                @if(! empty($settings['site_description']))
                    <p class="mb-4 text-white-50">{{ $settings['site_description'] }}</p>
                @endif
            </div>

            <div class="col-sm-6 col-lg-3">
                <h2 class="h6 footer-title mb-3">Explore</h2>
                <ul class="footer-link-list">
                    <li><a href="{{ route('frontend.home') }}">Home</a></li>
                    <li><a href="{{ route('frontend.services.index') }}">Services</a></li>
                    <li><a href="{{ route('frontend.blog.index') }}">Blog</a></li>
                    <li><a href="{{ route('frontend.search') }}">Search</a></li>
                    <li><a href="{{ route('frontend.contact') }}">Contact</a></li>
                </ul>
            </div>

            <div class="col-sm-6 col-lg-4">
                <h2 class="h6 footer-title mb-3">Connect</h2>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($socialLinks as $label => $url)
                        @if($url)
                            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="social-link">
                                {{ $label }}
                            </a>
                        @endif
                    @endforeach
                </div>

                @if(empty(array_filter($socialLinks)))
                    <p class="text-white-50 mb-0">Social links will appear here when configured.</p>
                @endif
            </div>
        </div>

        <div class="border-top border-secondary-subtle mt-4 pt-4 d-flex flex-column flex-md-row justify-content-between gap-2 text-white-50 small">
            <div>&copy; {{ date('Y') }} {{ $siteName }}. All rights reserved.</div>
            <div>Powered by dynamic CMS content.</div>
        </div>
    </div>
</footer>
