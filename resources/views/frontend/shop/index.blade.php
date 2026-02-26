@extends('frontend.app')
@section('title', __('Shop'))

@push('css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/optikart/css/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/optikart/style.css') }}">
    <style>
        .optikart-shop-hero {
            background: linear-gradient(135deg, rgba(12, 27, 55, 0.92), rgba(12, 106, 173, 0.8)),
                url('{{ asset('frontend/assets005/images/banner1.jpg') }}') center/cover no-repeat;
            padding: 6.5rem 0 4rem;
            color: #fff;
        }
        .optikart-filter-card {
            border-radius: 20px;
            background: #ffffff;
            box-shadow: 0 18px 35px rgba(15, 23, 42, 0.1);
        }
        .optikart-filter-card .card-header {
            border-bottom: none;
            background: transparent;
            font-weight: 600;
        }
        .optikart-price-input {
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            padding: 0.65rem 1rem;
        }
        .optikart-category-link {
            display: block;
            padding: 0.35rem 0;
            color: #1f2937;
            text-decoration: none;
        }
        .optikart-category-link.active,
        .optikart-category-link:hover {
            color: #0f172a;
            font-weight: 600;
        }
        .optikart-product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
            gap: 1.5rem;
        }
        .optikart-product-grid .product-item {
            height: 100%;
        }
        .optikart-sort-select {
            border-radius: 16px;
            border: 1px solid #d1d5db;
            padding: 0.6rem 1rem;
        }
    </style>
@endpush

@section('content')
    <section class="optikart-shop-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="badge bg-light text-dark text-uppercase mb-3">{{ __('Shop') }}</span>
                    <h1 class="display-4 fw-semibold text-white">{{ __('Discover Your Perfect Pair') }}</h1>
                    <p class="lead text-white-50 mb-0">
                        {{ __('Browse our curated collection of eyewear crafted to match every mood, moment, and outfit.') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    @php $currentSlug = request()->route('slug'); @endphp

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3">
                    <div class="optikart-filter-card card border-0">
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('Filter Products') }}</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ $currentSlug ? route('front.shop', ['slug' => $currentSlug]) : route('front.shop') }}" method="GET">
                                @if (request()->filled('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">{{ __('Price Range') }}</label>
                                    <div class="d-flex gap-2">
                                        <input type="number" min="0" name="min_price" id="min-price-input" value="{{ request('min_price', $minPrice) }}" class="form-control optikart-price-input" placeholder="{{ __('Min') }}">
                                        <input type="number" min="0" name="max_price" id="max-price-input" value="{{ request('max_price', $maxPrice) }}" class="form-control optikart-price-input" placeholder="{{ __('Max') }}">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">{{ __('Availability') }}</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="inStock" name="in_stock" {{ request('in_stock') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inStock">{{ __('In Stock only') }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="outOfStock" name="out_of_stock" {{ request('out_of_stock') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="outOfStock">{{ __('Include Out of Stock') }}</label>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">{{ __('Categories') }}</label>
                                    <div class="list-unstyled">
                                        @foreach (categories() as $category)
                                            <a class="optikart-category-link {{ request('slug') === $category->slug ? 'active' : '' }}" href="{{ route('front.shop', ['slug' => $category->slug]) }}">
                                                {{ $category->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>

                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                                <button type="submit" class="btn btn-dark w-100 text-uppercase">{{ __('Apply Filters') }}</button>
                            </form>
                        </div>
                    </div>

                    <div class="optikart-filter-card card border-0 mt-4">
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('Featured Collections') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column gap-3">
                                @foreach ($feateuredCategories->take(4) as $item)
                                    @php
                                        $category = optional($item->category);
                                        $thumb = $item->image ?? $category->image ?? null;
                                        if ($thumb) {
                                            $thumb = ltrim($thumb, '/');
                                            if (!\Illuminate\Support\Str::startsWith($thumb, ['http://', 'https://'])) {
                                                $thumb = asset($thumb);
                                            }
                                        } else {
                                            $thumb = asset('frontend/assets005/images/category1.jpg');
                                        }
                                    @endphp
                                    <a href="{{ $category && $category->slug ? route('front.shop', ['slug' => $category->slug]) : '#' }}" class="d-flex align-items-center gap-3 text-decoration-none text-dark">
                                        <img src="{{ $thumb }}" alt="{{ $category->name ?? __('Category') }}" class="rounded-circle" width="56" height="56">
                                        <span>{{ $category->name ?? __('Category') }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                        <h4 class="mb-0">{{ __('Showing :count products', ['count' => $filteredProducts->count()]) }}</h4>
                        <form method="GET" action="{{ $currentSlug ? route('front.shop', ['slug' => $currentSlug]) : route('front.shop') }}" class="d-flex align-items-center gap-2">
                            @if (request()->filled('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            <input type="hidden" name="min_price" value="{{ request('min_price', $minPrice) }}">
                            <input type="hidden" name="max_price" value="{{ request('max_price', $maxPrice) }}">
                            <input type="hidden" name="in_stock" value="{{ request('in_stock') }}">
                            <input type="hidden" name="out_of_stock" value="{{ request('out_of_stock') }}">
                            <select name="sort" class="optikart-sort-select" onchange="this.form.submit()">
                                <option value="">{{ __('Sort by') }}</option>
                                <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>{{ __('Latest') }}</option>
                                <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>{{ __('Price: Low to High') }}</option>
                                <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>{{ __('Price: High to Low') }}</option>
                            </select>
                        </form>
                    </div>

                    <div class="optikart-product-grid">
                        @forelse ($filteredProducts as $product)
                            @include('frontend.home.partials.product-card', ['product' => $product])
                        @empty
                            <div class="col-12">
                                <div class="alert alert-secondary text-center" role="alert">
                                    {{ __('No products matched your filters. Try adjusting your selections.') }}
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('.optikart-filter-card form');
            if (form) {
                form.addEventListener('submit', function () {
                    form.querySelectorAll('input[type="number"]').forEach(function (input) {
                        if (!input.value) {
                            input.removeAttribute('name');
                        }
                    });
                });
            }
        });
    </script>
@endpush
