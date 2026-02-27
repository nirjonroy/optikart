@extends('frontend.app')
@section('title', __('Gallery'))

@section('content')
    <section class="page-banner">
        <div class="container-fluid px-3 px-md-5">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <span class="text-uppercase text-white-50 fw-semibold">{{ __('Gallery') }}</span>
                    <h1 class="display-5 fw-light text-white mt-2 mb-0">{{ __('Moments from Opticart') }}</h1>
                </div>
            </div>
        </div>
    </section>

    <section id="gallery" class="padding-medium bg-light">
        <div class="container-fluid px-3 px-md-5">
            @if ($galleries->count())
                <div class="row g-4 gallery-grid">
                    @foreach ($galleries as $item)
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="{{ asset($item->image) }}" class="image-link gallery-card d-block">
                                <img src="{{ asset($item->image) }}" alt="{{ $item->caption ?? __('Gallery image') }}" class="img-fluid w-100">
                            </a>
                            @if ($item->caption)
                                <p class="text-center text-muted small mt-2 mb-0">{{ $item->caption }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 d-flex justify-content-center">
                    {{ $galleries->links() }}
                </div>
            @else
                <p class="text-center text-muted mb-0">{{ __('No gallery images yet.') }}</p>
            @endif
        </div>
    </section>
@endsection
