@extends('frontend.app')

@section('title', __('Contact'))

@push('css')
    <style>
        .contact-hero {
            position: relative;
            background: linear-gradient(180deg, #0A1A2F 0%, #4B2E7F 100%);
            color: #fff;
            padding-top: 11rem;
            padding-bottom: 6rem;
            display: flex;
            align-items: center;
        }

        .contact-hero .hero-inner {
            position: relative;
            z-index: 1;
        }

        .contact-map {
            min-height: 420px;
        }

        .contact-map iframe {
            width: 100%;
            height: 100%;
            min-height: 420px;
            border: 0;
            display: block;
        }

        .text-white-soft {
            color: rgba(255, 255, 255, 0.75);
        }
    </style>
@endpush

@section('content')
    <section class="contact-hero py-6 py-md-8">
        <div class="container-fluid px-3 px-md-5">
            <div class="row align-items-center gy-4 hero-inner">
                <div class="col-md-7">
                    <h1 class="display-4 fw-light text-uppercase mb-3">{{ __('Get in touch') }}</h1>
                    <p class="text-white-soft fs-5 mb-0">
                        {{ optional($contact)->description ?? __('Speak with our optical stylists, request prescription assistance, or track an order—Opticart support is here for you every day.') }}
                    </p>
                </div>
                <div class="col-md-5 text-md-end">
                    <span class="badge bg-light text-dark rounded-pill px-4 py-3">{{ __('Contact Opticart') }}</span>
                </div>
            </div>
        </div>
    </section>

    <section class="padding-medium">
        <div class="container-fluid px-3 px-md-5">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <h3 class="h4 fw-semibold mb-3">{{ optional($contact)->title ?? __('Customer care desk') }}</h3>
                            <p class="text-muted">{{ optional($contact)->description ?? __('We respond to every enquiry within one business day.') }}</p>
                            <div class="mt-4">
                                <div class="d-flex align-items-start gap-3 mb-3">
                                    <iconify-icon icon="ph:phone-duotone" class="fs-3 text-primary"></iconify-icon>
                                    <div>
                                        <span class="text-uppercase text-muted small">{{ __('Call us') }}</span>
                                        <p class="mb-0 fw-semibold">
                                            <a href="tel:{{ optional($contact)->phone }}" class="text-decoration-none text-dark">
                                                {{ optional($contact)->phone ?? __('N/A') }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start gap-3 mb-3">
                                    <iconify-icon icon="ph:envelope-duotone" class="fs-3 text-primary"></iconify-icon>
                                    <div>
                                        <span class="text-uppercase text-muted small">{{ __('Email') }}</span>
                                        <p class="mb-0 fw-semibold">
                                            <a href="mailto:{{ optional($contact)->email }}" class="text-decoration-none text-dark">
                                                {{ optional($contact)->email ?? __('N/A') }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start gap-3">
                                    <iconify-icon icon="ph:map-pin-duotone" class="fs-3 text-primary"></iconify-icon>
                                    <div>
                                        <span class="text-uppercase text-muted small">{{ __('Visit') }}</span>
                                        <p class="mb-0 fw-semibold">{{ optional($contact)->address ?? __('Visit our flagship showroom for an in-person experience.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4 p-lg-5">
                            <h3 class="h4 fw-semibold mb-4">{{ __('Send us a message') }}</h3>

                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form action="{{ route('front.contact.submit') }}" method="POST" class="row g-3">
                                @csrf
                                <div class="col-md-6">
                                    <label class="form-label text-uppercase small fw-semibold">{{ __('Name') }}</label>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        class="form-control form-control-lg rounded-3 @error('name') is-invalid @enderror"
                                        placeholder="{{ __('Your full name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-uppercase small fw-semibold">{{ __('Email') }}</label>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="form-control form-control-lg rounded-3 @error('email') is-invalid @enderror"
                                        placeholder="{{ __('you@example.com') }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-uppercase small fw-semibold">{{ __('Phone') }}</label>
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                        class="form-control form-control-lg rounded-3 @error('phone') is-invalid @enderror"
                                        placeholder="{{ __('Optional') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-uppercase small fw-semibold">{{ __('Subject') }}</label>
                                    <input type="text" name="subject" value="{{ old('subject') }}"
                                        class="form-control form-control-lg rounded-3 @error('subject') is-invalid @enderror"
                                        placeholder="{{ __('How can we help?') }}">
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-uppercase small fw-semibold">{{ __('Message') }}</label>
                                    <textarea name="message" rows="5"
                                        class="form-control form-control-lg rounded-3 @error('message') is-invalid @enderror"
                                        placeholder="{{ __('Tell us more about your request') }}">{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill">
                                        {{ __('Send Message') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @php
        $mapValue = trim(optional($contact)->map ?? '');
    @endphp
    @if ($mapValue !== '')
        @php
            $mapMarkup = \Illuminate\Support\Str::contains($mapValue, '<iframe')
                ? $mapValue
                : '<iframe src="' .
                    $mapValue .
                    '" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
        @endphp
        <section class="pb-6">
            <div class="container-fluid px-3 px-md-5">
                <div class="contact-map rounded-4 overflow-hidden shadow-sm">
                    {!! $mapMarkup !!}
                </div>
            </div>
        </section>
    @endif
@endsection
