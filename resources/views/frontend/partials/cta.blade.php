<section class="frontend-section pt-0" data-reveal>
    <div class="container">
        <div class="cta-band">
            <div class="row g-4 align-items-center">
                <div class="col-lg-8">
                    <div class="section-kicker text-white-50 mb-2">{{ $kicker ?? 'Ready to begin?' }}</div>
                    <h2 class="h1 fw-bold mb-3">{{ $title ?? 'Let us build something useful together.' }}</h2>
                    <p class="mb-0">{{ $text ?? 'Tell us what you need and we will help you find the right next step.' }}</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ $url ?? route('frontend.contact') }}" class="btn btn-light">
                        {{ $label ?? 'Contact Us' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
