@extends('frontend.layouts.app')

@section('content')
    <section class="page-hero">
        <div class="container">
            @include('frontend.partials.breadcrumb', ['items' => ['Contact' => null]])
            <div class="row g-4 align-items-end">
                <div class="col-lg-9" data-reveal>
                    <div class="section-kicker mb-2">Contact</div>
                    <h1 class="hero-title mb-3">Start with a signal, not a generic form.</h1>
                    <p class="hero-lead mb-0">Send your details and we will get back to you soon.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="frontend-section pt-0">
        <div class="container">
            <div class="row g-4 g-lg-5">
                <div class="col-lg-5" data-reveal>
                    <div class="contact-panel h-100">
                        <div class="content-card-body p-lg-5">
                            <div class="section-kicker mb-2">{{ $settings['site_name'] ?? config('app.name') }}</div>
                            <h2 class="section-title h1 mb-4">Tell us what you are building.</h2>
                            @if(! empty($settings['site_description']))
                                <p class="hero-lead">{{ $settings['site_description'] }}</p>
                            @endif

                            @if(! empty($settings['admin_email']))
                                <div class="mt-5">
                                    <div class="fw-bold text-white">Email</div>
                                    <a href="mailto:{{ $settings['admin_email'] }}" class="text-decoration-none">{{ $settings['admin_email'] }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-7" data-reveal>
                    <div class="contact-panel">
                        <div class="content-card-body p-lg-5">
                            @if(session('status'))
                                <div class="alert alert-success" role="status">{{ session('status') }}</div>
                            @endif

                            <form method="POST" action="{{ route('frontend.contact.submit') }}" novalidate>
                                @csrf

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label fw-semibold">Name</label>
                                        <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="email" class="form-label fw-semibold">Email</label>
                                        <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="phone" class="form-label fw-semibold">Phone</label>
                                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="subject" class="form-label fw-semibold">Subject</label>
                                        <input id="subject" type="text" name="subject" value="{{ old('subject') }}" class="form-control @error('subject') is-invalid @enderror" required>
                                        @error('subject')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="message" class="form-label fw-semibold">Message</label>
                                        <textarea id="message" name="message" rows="6" class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
                                        @error('message')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-primary" type="submit">Send Message</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
