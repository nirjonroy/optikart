@extends('frontend.app')

@section('title', __('Solutions'))

@push('css')
    <style>
        .solutions-hero {
            position: relative;
            background: linear-gradient(135deg, #0c1630, #1f325d);
            color: #fff;
            overflow: hidden;
            padding-top: 7rem;
        }

        .solutions-hero::after {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top right, rgba(255, 255, 255, 0.15), transparent 50%);
        }

        .solutions-hero .content {
            position: relative;
            z-index: 1;
        }

        .solutions-hero h1,
        .solutions-hero p {
            color: #fffff !important;
        }

        .solution-card {
            border: 0;
            border-radius: 1.5rem;
            padding: 2rem;
            background: #fff;
            box-shadow: 0 25px 60px rgba(12, 22, 48, 0.08);
            height: 100%;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .solution-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 30px 70px rgba(12, 22, 48, 0.12);
        }
    </style>
@endpush

@section('content')
    <section class="solutions-hero py-6 py-md-8">
        <div class="container-fluid px-3 px-md-5 content">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <p class="text-uppercase small text-white-50 mb-3">{{ __('Eyecare innovations') }}</p>
                    <h1 class="display-4 fw-semibold text-white mb-3">
                        {{ __('Solutions that bring optical care closer to everyone') }}
                    </h1>
                    <p class="fs-5 text-white-75 mb-0">
                        {{ __('From home try-on experiences to appointment scheduling tools, we design services that meet customers wherever they are.') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-6">
        <div class="container-fluid px-3 px-md-5">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                <div>
                    <p class="text-uppercase text-muted small mb-1">{{ __('Our capabilities') }}</p>
                    <h2 class="h3 fw-semibold mb-0">{{ __('Innovative Solutions') }}</h2>
                </div>
                <a href="{{ route('front.appointment') }}" class="btn btn-outline-primary rounded-pill px-4">
                    {{ __('Book an appointment') }}
                </a>
            </div>

            <div class="row g-4">
                @foreach ($solutions as $solution)
                    <div class="col-md-6 col-xl-4">
                        <div class="solution-card h-100">
                            <h3 class="h5 fw-semibold mb-3">{{ $solution['title'] }}</h3>
                            <p class="mb-0 text-muted">{{ $solution['description'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
