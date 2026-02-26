@extends('frontend.app')

@section('title', __('About'))

@push('css')
    <style>
        .about-hero {
            background: linear-gradient(180deg, #0A1A2F 0%, #4B2E7F 100%);
            position: relative;
            color: #fff;
            padding-top: 11rem;
            padding-bottom: 6rem;
            display: flex;
            align-items: center;
        }

        .about-hero .hero-inner h1 {
            color: #fff;
        }

        .about-stat-card {
            border-radius: 20px;
            backdrop-filter: blur(8px);
            background: rgba(255, 255, 255, 0.85);
        }
    </style>
@endpush

@section('content')
    <section class="about-hero py-7 py-md-9">
        <div class="container-fluid px-3 px-md-5">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center text-white hero-inner">
                    <h1 class="display-4 display-md-3 fw-bold text-uppercase mb-0">
                        {{ __('About Optikart') }}
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <section class="padding-medium">
        <div class="container-fluid px-3 px-md-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="ratio ratio-4x3 rounded-4 overflow-hidden shadow-lg">
                        <img src="{{ optional($about)->video_background ? asset($about->video_background) : asset('frontend/assets005/images/about-banner.jpg') }}" alt="{{ __('About Opticart') }}" class="w-100 h-100 object-fit-cover">
                    </div>
                </div>
                <div class="col-lg-6">
                    <span class="text-uppercase text-primary fw-semibold">{{ __('Our Story') }}</span>
                    <h2 class="display-5 fw-light mt-3 mb-4">
                        {{ optional($about)->title ?? __('Passionately redefining eyewear for everyday life') }}
                    </h2>
                    <div class="content text-muted fs-6">
                        {!! optional($about)->about_us ?? __('From handcrafted frames to cutting-edge lenses, every Opticart collection is designed to accentuate your personality while prioritising visual comfort. We partner with leading optical specialists and trend curators to ensure that every pair that reaches you is both clinically precise and aesthetically inspiring.') !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="padding-medium pt-0">
        <div class="container-fluid px-3 px-md-5">
            <div class="row g-4">
                @foreach ($stats as $label => $value)
                    <div class="col-12 col-md-4">
                        <div class="about-stat-card p-4 shadow-sm h-100">
                            <span class="text-uppercase text-primary fw-semibold">{{ __(ucfirst($label)) }}</span>
                            <h3 class="display-4 fw-bold text-dark mt-2 mb-0">{{ number_format($value) }}+</h3>
                            <p class="text-muted mb-0">
                                @switch($label)
                                    @case('products')
                                        {{ __('Curated eyewear pieces across categories and materials.') }}
                                        @break
                                    @case('categories')
                                        {{ __('Distinct collections covering lifestyle, fashion, and performance needs.') }}
                                        @break
                                    @default
                                        {{ __('Shared stories from customers who trust Opticart vision solutions.') }}
                                @endswitch
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @if ($testimonials->isNotEmpty())
        <section class="padding-medium pt-0">
            <div class="container-fluid px-3 px-md-5">
                <div class="row justify-content-between align-items-end mb-5">
                    <div class="col-lg-6">
                        <span class="text-uppercase text-primary fw-semibold">{{ __('Testimonials') }}</span>
                        <h2 class="display-6 fw-light mt-2">{{ __('Loved by eyewear enthusiasts nationwide') }}</h2>
                    </div>
                </div>
                <div class="row g-4">
                    @foreach ($testimonials as $testimonial)
                        <div class="col-md-6 col-xl-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                                {{ __('Customer') }}
                                            </span>
                                        </div>
                                        <div class="ms-3">
                                            <h6 class="mb-0">{{ $testimonial->name ?? __('Anonymous') }}</h6>
                                            <small class="text-muted">{{ $testimonial->designation ?? __('Opticart Customer') }}</small>
                                        </div>
                                    </div>
                                    <p class="mb-0 text-muted">{!! $testimonial->description ?? __('Their eyewear concierge made choosing lenses effortless and stylish.') !!}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($brandLogos->isNotEmpty())
        <section class="padding-medium pt-0">
            <div class="container-fluid px-3 px-md-5">
                <div class="row justify-content-center text-center mb-4">
                    <div class="col-lg-6">
                        <span class="text-uppercase text-primary fw-semibold">{{ __('Trusted Partners') }}</span>
                        <h2 class="display-6 fw-light mt-2">{{ __('Official collaborations & optical partners') }}</h2>
                    </div>
                </div>
                <div class="row g-4 justify-content-center">
                    @foreach ($brandLogos as $banner)
                        @php
                            $brandLabel = $banner->brand ?? $banner->title ?? __('Collection Banner');
                        @endphp
                        <div class="col-6 col-md-3 col-xl-2">
                            <div class="border rounded-4 p-4 text-center shadow-sm h-100 d-flex align-items-center justify-content-center">
                                @if (!empty($banner->url))
                                    <a href="{{ $banner->url }}" target="_blank" rel="noopener" class="d-block">
                                        <img src="{{ asset($banner->image) }}" alt="{{ $brandLabel }}" class="img-fluid">
                                    </a>
                                @else
                                    <img src="{{ asset($banner->image) }}" alt="{{ $brandLabel }}" class="img-fluid">
                                @endif
                            </div>
                            @if ($banner->brand || $banner->title || $banner->discount_text)
                                <div class="text-center mt-3">
                                    @if ($banner->brand || $banner->title)
                                        <p class="text-muted small mb-1">{{ $banner->brand ?? $banner->title }}</p>
                                    @endif
                                    @if ($banner->discount_text)
                                        <span class="badge bg-primary-subtle text-primary">{{ $banner->discount_text }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
