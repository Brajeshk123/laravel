@extends('frontend.layouts.app')

@section('content')
    <section class="page-hero">
        <div class="container">
            @include('frontend.partials.breadcrumb', ['items' => ['Services' => null]])
            <div class="row align-items-end g-4">
                <div class="col-lg-9" data-reveal>
                    <div class="section-kicker mb-2">Services</div>
                    <h1 class="hero-title mb-3">Sharp service pages, pulled from live CMS content.</h1>
                    <p class="hero-lead mb-0">Every card below is a published service managed from the admin panel.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="frontend-section pt-0">
        <div class="container">
            <div class="service-grid">
                @forelse($services as $service)
                    <a href="{{ route('frontend.services.show', $service->slug) }}" class="service-card text-decoration-none" data-reveal>
                        <div class="service-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                        <div class="mt-auto">
                            <div class="meta-row mb-3">
                                @foreach($service->categories->take(2) as $category)
                                    <span class="badge-soft">{{ $category->name }}</span>
                                @endforeach
                            </div>
                            <h2 class="section-title h2 mb-3">{{ $service->title }}</h2>
                            @if($service->excerpt)
                                <p class="section-copy mb-0">{{ $service->excerpt }}</p>
                            @endif
                        </div>
                        <span class="service-arrow">Explore -></span>
                    </a>
                @empty
                    <div class="empty-state">No published services found.</div>
                @endforelse
            </div>

            <div class="mt-5">
                {{ $services->links() }}
            </div>
        </div>
    </section>
@endsection
