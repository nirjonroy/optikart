@extends('frontend.app')

@section('title', $product->name ?? __('Product Details'))

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('frontend/optikart/css/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/optikart/style.css') }}">
    <style>
        #banner {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 320px;
        }

        .product-info .price-primary {
            font-size: 38px;
            font-weight: 700;
            color: #0d6efd;
        }

        .product-info .price-compare {
            font-size: 18px;
            color: #6b7280;
        }

        .product-select .select-list .select-item {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        #sizes .size,
        #colors .color {
            border: 1px solid #d1d5db;
            border-radius: 999px;
            padding: 6px 18px;
            margin-right: 8px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: all .2s ease;
            font-weight: 600;
        }

        #sizes .size.active,
        #colors .color.active {
            background: #0d6efd;
            color: #fff;
            border-color: #0d6efd;
        }

        #colors .color {
            min-width: 42px;
            min-height: 42px;
            padding: 0;
            border-radius: 12px;
        }

        #colors .color span {
            display: block;
            width: 100%;
            height: 100%;
            border-radius: 10px;
            font-size: 12px;
            color: #0f172a;
            background: rgba(255, 255, 255, .85);
            line-height: 40px;
        }

        .btn-cart,
        .add-to-cart,
        .buy-now {
            border-radius: 999px !important;
        }

        .btn-cart {
            background: #0d6efd;
            color: #fff;
            transition: all .2s ease;
        }

        .btn-cart:hover {
            background: #0a58ca;
            color: #fff;
        }

        .product-tabs .nav-link {
            border: none;
            border-radius: 999px;
            background: #f3f4f6;
        }

        .product-tabs .nav-link.active {
            background: #0d6efd;
            color: #fff !important;
        }

        .related-products .product-card {
            border-radius: 24px;
            box-shadow: 0 18px 35px rgba(15, 23, 42, 0.08);
            transition: transform .2s ease, box-shadow .2s ease;
            height: 100%;
        }

        .related-products .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 24px 40px rgba(15, 23, 42, 0.12);
        }

        .related-products .product-card img {
            border-radius: 24px 24px 0 0;
            width: 100%;
            height: 210px;
            object-fit: cover;
        }

        .related-products .product-info {
            padding: 1.25rem;
        }

        .related-products .product-price {
            font-weight: 700;
            color: #0d6efd;
        }

        .related-products .product-link {
            color: #111827;
            font-weight: 600;
            text-decoration: none;
        }

        .related-products .product-link:hover {
            color: #0d6efd;
        }

        #register {
            background-size: cover;
            background-position: center;
            color: #fff;
        }

        .product-large-slider .swiper-slide {
            background: #fff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.1);
        }

        .product-thumbnail-slider .thumb-image {
            border-radius: 16px;
            border: 1px solid transparent;
            transition: border-color .2s ease;
        }

        .product-thumbnail-slider .swiper-slide-thumb-active .thumb-image {
            border-color: #0d6efd;
        }

        .product-info .product-metas {
            list-style: none;
            padding: 0;
            margin: 1rem 0;
        }

        .product-info .product-metas li {
            margin-bottom: .5rem;
            color: #4b5563;
        }

        .stock_check {
            font-weight: 600;
        }

        @media (max-width: 767px) {
            .product-info .price-primary {
                font-size: 32px;
            }

            .product-large-slider .swiper-slide img {
                width: 100%;
                height: auto;
            }
        }
    </style>
@endpush

@section('content')
    @php
        $thumbImage = $product->thumb_image ? asset('uploads/custom-images/' . $product->thumb_image) : null;
        $galleryImages = collect();
        if ($thumbImage) {
            $galleryImages->push($thumbImage);
        }
        if ($product->gallery && $product->gallery->count()) {
            foreach ($product->gallery as $image) {
                if (!empty($image->image)) {
                    $galleryImages->push(asset($image->image));
                }
            }
        }
        $galleryImages = $galleryImages->unique()->values();
        $avgRating = $reviews->count() ? round($reviews->avg('rating'), 1) : null;
        $ratingCount = $reviews->count();
        $primaryPrice = $product->offer_price > 0 ? $product->offer_price : $product->price;
        $comparePrice = $product->offer_price > 0 ? $product->price : null;
        $tags = $product->tags ? array_filter(array_map('trim', explode(',', $product->tags))) : [];
        $stockQty = $product->p_stock && $product->p_stock->count() ? $product->p_stock->sum('quantity') : ($product->stock ?? null);
    @endphp

    <section id="banner" style="background-image:url('{{ asset('frontend/optikart/images/banner-img2.jpg') }}');">
        <div class="container padding-medium-2">
            <div class="hero-content text-center">
                <h2 class="display-1 text-uppercase text-white mt-5 mb-3">{{ $product->name }}</h2>

                <nav class="breadcrumb d-flex justify-content-center">
                    <a class="breadcrumb-item nav-link text-white-50" href="{{ route('front.home') }}">{{ __('Home') }}</a>
                    @if (!empty($product->category))
                        <a class="breadcrumb-item nav-link text-white-50"
                            href="{{ route('front.shop', ['slug' => $product->category->slug]) }}">{{ $product->category->name }}</a>
                    @endif
                    <span class="breadcrumb-item active text-white" aria-current="page">{{ $product->name }}</span>
                </nav>
            </div>
        </div>
    </section>

    <section id="selling-product">
        <div class="container-fluid px-3 px-md-5 padding-medium">
            <div class="row g-md-5">
                <div class="col-lg-6">
                    <div class="row" id="product-gallery-wrapper">
                        @if ($galleryImages->count() > 1)
                            <div class="col-md-3 d-none d-md-flex">
                                <div class="swiper product-thumbnail-slider">
                                    <div class="swiper-wrapper" id="product-thumbnail-wrapper">
                                        @foreach ($galleryImages as $image)
                                            <div class="swiper-slide">
                                                <img src="{{ $image }}" alt="{{ $product->name }}"
                                                    class="thumb-image img-fluid">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="{{ $galleryImages->count() > 1 ? 'col-md-9' : 'col-12' }}">
                            <div class="swiper product-large-slider">
                                <div class="swiper-wrapper testslide-image">
                                    @forelse ($galleryImages as $image)
                                        <div class="swiper-slide">
                                            <a href="{{ $image }}" class="popup-link">
                                                <img src="{{ $image }}" alt="{{ $product->name }}"
                                                    class="img-fluid w-100">
                                            </a>
                                        </div>
                                    @empty
                                        <div class="swiper-slide">
                                            <img src="{{ asset('frontend/images/placeholder.jpg') }}" alt="{{ $product->name }}"
                                                class="img-fluid w-100">
                                        </div>
                                    @endforelse
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0">
                    <div class="product-info">
                        <div class="element-header">
                            <h2 itemprop="name" class="display-6 fw-bold">{{ $product->name }}</h2>
                            @if ($avgRating)
                                <div class="rating-container d-flex gap-2 align-items-center mt-2">
                                    <span class="rating secondary-font d-flex align-items-center gap-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i
                                                class="{{ $i <= floor($avgRating) ? 'fa-solid fa-star text-warning' : ($avgRating >= $i - 0.5 ? 'fa-solid fa-star-half-stroke text-warning' : 'fa-regular fa-star text-warning') }}"></i>
                                        @endfor
                                        <span class="ms-2 text-dark fw-semibold">{{ $avgRating }}</span>
                                    </span>
                                    <span class="text-muted">({{ $ratingCount }} {{ \Illuminate\Support\Str::plural('review', $ratingCount) }})</span>
                                </div>
                            @endif
                        </div>
                        <div class="product-price pt-3 pb-3 d-flex align-items-center gap-3">
                            <strong class="price-primary">{{ number_format($primaryPrice, 2) }} {{ __('Tk') }}</strong>
                            @if ($comparePrice)
                                <del class="price-compare">{{ number_format($comparePrice, 2) }} {{ __('Tk') }}</del>
                            @endif
                        </div>
                        @if (!empty($product->short_description))
                            <p>{!! $product->short_description !!}</p>
                        @elseif (!empty($product->long_description))
                            <p>{{ \Illuminate\Support\Str::limit(strip_tags($product->long_description), 260) }}</p>
                        @endif

                        <form class="cart-wrap">
                            @php
                                $colorVariations = $product->colorVariations ?? collect();
                                $sizeVariations = $product->variations ?? collect();

                                $normalizedColorNames = $colorVariations
                                    ->filter(function ($variation) {
                                        return !empty($variation->color) && !empty($variation->color->name);
                                    })
                                    ->map(function ($variation) {
                                        return strtolower(trim($variation->color->name));
                                    })
                                    ->unique()
                                    ->values();

                                $colorIsFreeOnly = $normalizedColorNames->count() === 1 && $normalizedColorNames->first() === 'free';
                                $showColorOptions = !empty($product->prod_color == 'varcolor') && $colorVariations->count() && !$colorIsFreeOnly;
                                $defaultColorVariation = $colorVariations->first();

                                $normalizedSizeTitles = $sizeVariations
                                    ->filter(function ($variation) {
                                        return !empty($variation->size) && !empty($variation->size->title);
                                    })
                                    ->map(function ($variation) {
                                        return strtolower(trim($variation->size->title));
                                    })
                                    ->unique()
                                    ->values();

                                $sizeIsFreeOnly = $normalizedSizeTitles->count() === 1 && $normalizedSizeTitles->first() === 'free';
                                $showSizeOptions = $product->type == 'variable' && $sizeVariations->count() && !$sizeIsFreeOnly;
                                $defaultSizeVariation = $sizeVariations->first();

                                $colorValue = '';
                                $colorValue1 = '';
                                $variationColorId = '';
                                $colorIdValue = '';

                                if (!empty($product->prod_color != 'varcolor')) {
                                    $colorValue = 'default';
                                    $variationColorId = 1;
                                } elseif (!$showColorOptions && $defaultColorVariation) {
                                    $colorValue = $defaultColorVariation->color->name ?? 'free';
                                    $colorValue1 = $defaultColorVariation->id ?? '';
                                    $variationColorId = $defaultColorVariation->color_id ?? 1;
                                    $colorIdValue = $defaultColorVariation->color_id ?? '';
                                }

                                $sizeValue = '';
                                $sizeVariationIdValue = '';
                                $variationSizeIdValue = '';

                                if ($product->type != 'variable') {
                                    $sizeValue = 'free';
                                    $variationSizeIdValue = 1;
                                } elseif (!$showSizeOptions && $defaultSizeVariation) {
                                    $sizeValue = $defaultSizeVariation->size->title ?? 'free';
                                    $sizeVariationIdValue = $defaultSizeVariation->id ?? '';
                                    $variationSizeIdValue = $defaultSizeVariation->size_id ?? '';
                                }
                            @endphp
                            <div class="color-options product-select">
                                @if ($showColorOptions)
                                    <div class="color-toggle pt-2">
                                        <h6 class="item-title fw-bold" id="select_color">{{ __('Color:') }}</h6>
                                        <div class="select-list list-unstyled d-flex flex-wrap" id="colors">
                                            @foreach ($product->colorVariations as $variation)
                                                @if (!empty($variation->color->code))
                                                    <div class="color"
                                                        data-proid="{{ $variation->product_id }}"
                                                        data-colorid="{{ $variation->color_id }}"
                                                        data-varcolor="{{ $variation->color->name }}"
                                                        value="{{ $variation->id }}"
                                                        data-variationcolorid="{{ $variation->color_id }}"
                                                        style="background: {{ $variation->color->code }}">
                                                        <span>{{ $variation->color->name }}</span>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                <input type="hidden" id="color_val" name="color_id" value="{{ $colorIdValue }}">
                                <input type="hidden" id="color_value" name="variationColor_id"
                                    value="{{ $showColorOptions ? '' : $colorValue }}">
                                <input type="hidden" id="variation_color_id" name="variation_color_id"
                                    value="{{ $showColorOptions ? '' : $variationColorId }}">
                                <input type="hidden" id="color_value1" value="{{ $showColorOptions ? '' : $colorValue1 }}">
                            </div>
                            <div class="swatch product-select pt-3">
                                @if ($showSizeOptions)
                                    <h6 class="item-title fw-bold" id="select_size">{{ __('Size:') }}</h6>
                                    <div class="select-list list-unstyled d-flex flex-wrap" id="sizes">
                                        @foreach ($product->variations as $variation)
                                            @if (!empty($variation->size->title))
                                                <div class="size"
                                                    data-proid="{{ $variation->product_id }}"
                                                    data-varprice="{{ $variation->sell_price }}"
                                                    data-varsize="{{ $variation->size->title }}"
                                                    data-varsizeid="{{ $variation->size_id }}"
                                                    value="{{ $variation->id }}">
                                                    {{ ucfirst($variation->size->title) }}
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                @endif
                                <input type="hidden" id="size_value" name="variation_id"
                                    value="{{ $showSizeOptions ? '' : $sizeValue }}">
                                <input type="hidden" id="size_variation_id" name="size_variation_id" value="{{ $showSizeOptions ? '' : $sizeVariationIdValue }}">
                                <input type="hidden" name="pro_price" id="pro_price"
                                    value="{{ $primaryPrice }}">
                                <input type="hidden" name="variation_size_id" id="variation_size_id"
                                    value="{{ $showSizeOptions ? '' : $variationSizeIdValue }}">
                            </div>
                            <div class="product-quantity pt-4">
                                <div class="stock-number text-dark mb-3">
                                    @if ($stockQty)
                                        <em>{{ $stockQty }} {{ __('in stock') }}</em>
                                    @else
                                        <em>{{ __('Available') }}</em>
                                    @endif
                                </div>
                                <div class="stock-button-wrap">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <div class="input-group product-qty align-items-center w-auto me-3">
                                            <span class="input-group-btn">
                                                <button type="button"
                                                    class="quantity-left-minus btn btn-light btn-number decrease-qty"
                                                    data-type="minus">
                                                    <svg width="16" height="16">
                                                        <use xlink:href="#minus"></use>
                                                    </svg>
                                                </button>
                                            </span>
                                            <input type="text" id="quantity" name="quantity"
                                                class="form-control input-number text-center p-2 mx-1 qty"
                                                value="1" min="1">
                                            <span class="input-group-btn">
                                                <button type="button"
                                                    class="quantity-right-plus btn btn-light btn-number increase-qty"
                                                    data-type="plus">
                                                    <svg width="16" height="16">
                                                        <use xlink:href="#plus"></use>
                                                    </svg>
                                                </button>
                                            </span>
                                        </div>
                                        <a href="javascript:void(0)"
                                            class="btn-cart me-3 px-4 pt-3 pb-3 add-to-cart"
                                            data-id="{{ $product->id }}"
                                            data-url="{{ route('front.cart.store') }}">
                                            <h5 class="text-capitalize m-0">{{ __('Add to Cart') }}</h5>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <p class="stock_check mt-3"></p>

                            <div class="row mt-4 g-3">
                                <div class="col-12 col-md-6">
                                    <a href="{{ route('front.check.single', ['product_id' => $product->id]) }}"
                                        class="btn btn-primary w-100 py-3 buy-now"
                                        data-url="{{ route('front.cart.store') }}">
                                        <i class="fas fa-bolt me-2"></i>{{ __('Order Now') }}
                                    </a>
                                </div>
                                <div class="col-12 col-md-6">
                                    @php $footer = DB::table('footers')->first(); @endphp
                                    @if ($footer)
                                        <a href="tel:+88{{ $footer->phone }}"
                                            class="btn btn-outline-primary w-100 py-3">
                                            <i class="fas fa-phone me-2"></i>+88{{ $footer->phone }}
                                        </a>
                                    @endif
                                </div>
                                @if ($footer && $footer->phone2)
                                    <div class="col-12">
                                        <a href="https://wa.me/+88{{ $footer->phone2 }}"
                                            class="btn btn-success w-100 py-3">
                                            <i class="fab fa-whatsapp me-2"></i>+88{{ $footer->phone2 }}
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <input type="hidden" id="retrieve_price" value="{{ $product->price }}">
                            <input type="hidden" id="retrieve_discount"
                                value="{{ $product->offer_price > 0 ? $product->price - $product->offer_price : 0 }}">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="product_name" value="{{ $product->name }}">
                            <input type="hidden" name="category_id" value="{{ $product->category_id }}">
                            <input type="hidden" name="price" id="price_val"
                                value="{{ $primaryPrice }}">
                            <input type="hidden" name="pro_img" id="pro_img"
                                value="{{ $galleryImages->first() }}">
                            <input type="hidden" name="type" id="type" value="{{ $product->type }}">
                        </form>

                        @if (!empty($product->feature))
                            <ul class="product-metas">
                                {!! $product->feature !!}
                            </ul>
                        @endif

                        <div class="meta-product pt-4">
                            @if (!empty($product->sku))
                                <div class="meta-item d-flex align-items-baseline mb-2">
                                    <h6 class="item-title fw-bold text-dark pe-2 mb-0">{{ __('SKU:') }}</h6>
                                    <span>{{ $product->sku }}</span>
                                </div>
                            @endif
                            @if (!empty($product->category))
                                <div class="meta-item d-flex align-items-baseline mb-2">
                                    <h6 class="item-title fw-bold text-dark pe-2 mb-0">{{ __('Category:') }}</h6>
                                    <a href="{{ route('front.shop', ['slug' => $product->category->slug]) }}"
                                        class="text-decoration-none">{{ $product->category->name }}</a>
                                </div>
                            @endif
                            @if (!empty($tags))
                                <div class="meta-item d-flex align-items-baseline">
                                    <h6 class="item-title fw-bold text-dark pe-2 mb-0">{{ __('Tags:') }}</h6>
                                    <ul class="select-list list-unstyled d-flex flex-wrap gap-2 mb-0">
                                        @foreach ($tags as $tag)
                                            <li class="select-item">
                                                <span class="badge bg-light text-dark">{{ $tag }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="product-tabs">
        <div class="container-fluid px-3 px-md-5 padding-medium pt-0">
            <div class="row">
                <div class="offset-md-1 col-md-10 tabs-listing">
                    <nav>
                        <div class="nav nav-tabs d-flex justify-content-center" id="nav-tab" role="tablist">
                            <button class="nav-link active text-black fw-semibold text-uppercase px-5 py-3 mx-3"
                                id="nav-details-tab" data-bs-toggle="tab" data-bs-target="#nav-details" type="button"
                                role="tab" aria-controls="nav-details" aria-selected="true">{{ __('Details') }}</button>
                            <button class="nav-link text-black fw-semibold text-uppercase px-5 py-3 mx-3"
                                id="nav-specification-tab" data-bs-toggle="tab" data-bs-target="#nav-specification"
                                type="button" role="tab" aria-controls="nav-specification" aria-selected="false">
                                {{ __('Specifications') }}</button>
                            <button class="nav-link text-black fw-semibold text-uppercase px-5 py-3 mx-3"
                                id="nav-shipping-tab" data-bs-toggle="tab" data-bs-target="#nav-shipping" type="button"
                                role="tab" aria-controls="nav-shipping" aria-selected="false">{{ __('Shipping & Return') }}</button>
                            <button class="nav-link text-black fw-semibold text-uppercase px-5 py-3 mx-3"
                                id="nav-review-tab" data-bs-toggle="tab" data-bs-target="#nav-review" type="button"
                                role="tab" aria-controls="nav-review" aria-selected="false">{{ __('Reviews') }}</button>
                        </div>
                    </nav>
                    <div class="tab-content py-5" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-details" role="tabpanel"
                            aria-labelledby="nav-details-tab">
                            @if (!empty($product->long_description))
                                {!! $product->long_description !!}
                            @else
                                <p class="text-muted">{{ __('No detailed description available for this product yet.') }}</p>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="nav-specification" role="tabpanel"
                            aria-labelledby="nav-specification-tab">
                            @if ($Specification->count())
                                <div class="row">
                                    @foreach ($Specification as $spec)
                                        <div class="col-md-6 mb-4">
                                            <div class="border rounded-4 p-4 h-100">
                                                <h6 class="fw-bold text-dark mb-2">{{ $spec->key }}</h6>
                                                <p class="mb-0 text-muted">{{ $spec->value }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">{{ __('Specification information will be updated soon.') }}</p>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="nav-shipping" role="tabpanel"
                            aria-labelledby="nav-shipping-tab">
                            <h5>{{ __('Shipping & Return Policy') }}</h5>
                            <p>{{ __('We process and dispatch orders within 24 business hours. Delivery times vary based on your location and preferred shipping method.') }}</p>
                            <ul>
                                <li>{{ __('Free shipping on qualifying orders over 2500 Tk inside Dhaka.') }}</li>
                                <li>{{ __('Trusted delivery partners ensure secure packaging and timely updates.') }}</li>
                                <li>{{ __('Unused items can be returned within 7 days. Contact our support team to start the process.') }}</li>
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab">
                            <div class="review-box d-flex flex-wrap">
                                @forelse ($reviews as $review)
                                    <div class="col-lg-6 d-flex flex-wrap gap-3 mb-4">
                                        <div class="col-md-2">
                                            <div class="image-holder">
                                                <img src="{{ asset($review->user->image ?? 'frontend/images/avatar.png') }}"
                                                    alt="{{ $review->user->name }}" class="img-fluid rounded-circle">
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="review-content">
                                                <div class="rating-container d-flex align-items-center mb-2">
                                                    <span class="rating">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i
                                                                class="{{ $i <= $review->rating ? 'fa-solid fa-star' : 'fa-regular fa-star' }}"></i>
                                                        @endfor
                                                        <span class="ms-2">({{ $review->rating }})</span>
                                                    </span>
                                                </div>

                                                <div class="review-header mb-2">
                                                    <span class="author-name text-black fw-bold">{{ $review->user->name }}</span>
                                                    <span class="review-date ms-2 text-muted">–
                                                        {{ $review->created_at->format('d M Y') }}</span>
                                                </div>
                                                <p>{{ $review->review }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted">{{ __('There are no reviews yet. Be the first to share your feedback!') }}</p>
                                @endforelse
                            </div>

                            <div class="add-review mt-5">
                                <h5>{{ __('Add a review') }}</h5>
                                <p>{{ __('Your email address will not be published. Required fields are marked *') }}</p>
                                @auth
                                    <form class="form-group" action="{{ route('front.product.product-reviews.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <div class="pb-3">
                                            <label class="fw-semibold">{{ __('Your rating *') }}</label>
                                            <select name="rating" class="form-select">
                                                <option value="5">5 - {{ __('Excellent') }}</option>
                                                <option value="4">4 - {{ __('Good') }}</option>
                                                <option value="3">3 - {{ __('Average') }}</option>
                                                <option value="2">2 - {{ __('Poor') }}</option>
                                                <option value="1">1 - {{ __('Terrible') }}</option>
                                            </select>
                                        </div>
                                        <div class="pb-3">
                                            <label class="fw-semibold">{{ __('Your Review *') }}</label>
                                            <textarea class="form-control" name="review" rows="4" placeholder="{{ __('Write your review here*') }}"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary px-5 py-3 mt-2">{{ __('Submit') }}</button>
                                    </form>
                                @else
                                    <p>{{ __('Please') }}
                                        <a href="{{ url('login-user') }}" class="btn btn-outline-primary btn-sm ms-1">{{ __('login') }}</a>
                                        {{ __('to submit a review.') }}
                                    </p>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($relatedProducts->count())
        <section class="related-products py-5">
            <div class="container">
                <h3 class="text-center fw-bold mb-5">{{ __('Related Products') }}</h3>
                <div class="row g-4">
                    @foreach ($relatedProducts as $related)
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="product-card bg-white h-100">
                                <a href="{{ route('front.product.show', $related->slug) }}">
                                    <img src="{{ asset('uploads/custom-images/' . $related->thumb_image) }}"
                                        alt="{{ $related->name }}">
                                </a>
                                <div class="product-info">
                                    <a href="{{ route('front.product.show', $related->slug) }}" class="product-link">
                                        {{ \Illuminate\Support\Str::limit($related->name, 40) }}
                                    </a>
                                    <div class="product-price mt-2">
                                        {{ number_format($related->offer_price > 0 ? $related->offer_price : $related->price, 2) }}
                                        {{ __('Tk') }}
                                    </div>
                                    <a href="{{ route('front.product.show', $related->slug) }}"
                                        class="btn btn-outline-primary w-100 mt-3">
                                        {{ __('View Details') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section id="register" style="background-image:url('{{ asset('frontend/optikart/images/background-img.jpg') }}');">
        <div class="container padding-medium">
            <div class="row banner-content align-items-center padding-medium">
                <div class="col-md-6">
                    <h2 class="display-3 text-white mt-3">{{ __('Get') }} <span><em>20% {{ __('OFF') }}</em></span>
                        {{ __('on your first purchase') }}</h2>
                    <p class="text-white mb-4">{{ __('Sign up for our newsletter and never miss exclusive offers.') }}</p>
                </div>
                <div class="col-md-4 offset-md-1">
                    <form id="newsletter-signup">
                        <div class="mb-3">
                            <input type="email" class="form-control form-control-lg rounded-3 text-center" name="email"
                                id="email" placeholder="{{ __('Enter Your Email Address') }}">
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark btn-lg rounded-3">{{ __('Register now') }}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script src="https://www.jqueryscript.net/demo/magnify-image-hover-touch/dist/jquery.izoomify.js"></script>
    <script>
        const thumbContainer = document.querySelector('.product-thumbnail-slider');
        const thumbnailsSwiper = thumbContainer ? new Swiper('.product-thumbnail-slider', {
            direction: 'vertical',
            slidesPerView: 4,
            spaceBetween: 12,
            watchSlidesProgress: true,
            breakpoints: {
                0: {
                    direction: 'horizontal'
                },
                768: {
                    direction: 'vertical'
                }
            }
        }) : null;

        const productSwiper = new Swiper('.product-large-slider', {
            slidesPerView: 1,
            effect: 'slide',
            spaceBetween: 0,
            navigation: {
                nextEl: '.product-large-slider .swiper-button-next',
                prevEl: '.product-large-slider .swiper-button-prev',
            },
            thumbs: thumbnailsSwiper ? {
                swiper: thumbnailsSwiper,
            } : undefined,
        });

        function refreshGallerySwipers() {
            productSwiper.update();
            productSwiper.slideTo(0);
            if (thumbnailsSwiper) {
                thumbnailsSwiper.update();
                thumbnailsSwiper.slideTo(0);
            }
            $('.popup-link').magnificPopup({
                type: 'image',
                gallery: {
                    enabled: true
                }
            });
        }

        refreshGallerySwipers();
    </script>
    <script>
        $(document).ready(function() {
            $('.buy-now').on('click', function(e) {
                e.preventDefault();

                let variation_id = $('#size_variation_id').val();
                let variation_size = $('#size_value').val();
                let variation_color = $('#color_value').val();
                let variation_price = $('#pro_price').val();
                var productId = $(this).closest('form').find('input[name="product_id"]').val();
                var proQty = $('#quantity').val();
                let variation_size_id = $('input[name="variation_size_id"]').val();
                let variation_color_id = $('input[name="variation_color_id"]').val();
                var retrieve_discount = $('input[id="retrieve_discount"]').val();
                let image = $('input#pro_img').val();
                let pro_type = $('input#type').val();
                var addToCartUrl = $(this).data('url');
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                $.post(addToCartUrl, {
                        id: productId,
                        quantity: proQty,
                        variation_id: variation_id,
                        varSize: variation_size,
                        varColor: variation_color,
                        variation_price: variation_price,
                        variation_size_id: variation_size_id,
                        variation_color_id: variation_color_id,
                        retrieve_discount: retrieve_discount,
                        image: image,
                        pro_type: pro_type
                    },
                    function(response) {
                        if (response.status) {
                            toastr.success(response.msg);
                            window.location.href = "{{ route('front.checkout.index') }}";
                        } else {
                            if (response.errors) {
                                for (var field in response.errors) {
                                    if (response.errors.hasOwnProperty(field)) {
                                        for (var i = 0; i < response.errors[field].length; i++) {
                                            toastr.error(response.errors[field][i]);
                                        }
                                    }
                                }
                            } else {
                                toastr.error(response.msg ||
                                    'An error occurred while processing your request.');
                            }
                        }
                    });
            });

            $('.increase-qty').on('click', function() {
                var qtyInput = $('#quantity');
                var newQuantity = parseInt(qtyInput.val()) + 1;
                qtyInput.val(newQuantity);
            });

            $('.decrease-qty').on('click', function() {
                var qtyInput = $('#quantity');
                var newQuantity = parseInt(qtyInput.val()) - 1;
                if (newQuantity > 0) {
                    qtyInput.val(newQuantity);
                }
            });
        });
    </script>
    <script>
        $(function() {
            $(document).on('click', '.add-to-cart', function(e) {
                e.preventDefault();
                let variation_id = $('#size_variation_id').val();
                let variation_size = $('#size_value').val();
                let variation_size_id = $('input[name="variation_size_id"]').val();
                let variation_color = $('#color_value').val();
                let variation_color_id = $('input[name="variation_color_id"]').val();
                let variation_price = $('#pro_price').val();
                var quantity = $('#quantity').val();
                let image = $('input#pro_img').val();
                let pro_type = $('input#type').val();
                let proName = $('input[name="product_name"]').val();
                let proId = $('input[name="product_id"]').val();
                let catId = $('input[name="category_id"]').val();

                window.dataLayer = window.dataLayer || [];
                dataLayer.push({
                    ecommerce: null
                });
                dataLayer.push({
                    event: "add_to_cart",
                    ecommerce: {
                        currency: "BDT",
                        value: variation_price,
                        items: [{
                            item_id: proId,
                            item_name: proName,
                            item_category: catId,
                            price: variation_price,
                            quantity: quantity
                        }]
                    }
                });

                let id = $(this).data('id');
                let url = $(this).data('url');

                addToCart(url, id, variation_size, variation_color, variation_id, variation_price, quantity,
                    variation_size_id, variation_color_id, image, pro_type, type = "");
            });

            function addToCart(url, id, varSize = "", varColor = "", variation_id = "", variation_price = "",
                quantity, variation_size_id, variation_color_id, image = "", pro_type, type = "") {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        id,
                        varSize,
                        varColor,
                        variation_id,
                        variation_price,
                        quantity,
                        variation_size_id,
                        variation_color_id,
                        image,
                        pro_type
                    },
                    success: function(res) {
                        if (res.status) {
                            toastr.success(res.msg);
                            if (type) {
                                if (res.url !== '') {
                                    document.location.href = res.url;
                                }
                            } else {
                                window.location.reload();
                            }
                        } else {
                            if (res.errors) {
                                for (var field in res.errors) {
                                    if (res.errors.hasOwnProperty(field)) {
                                        for (var i = 0; i < res.errors[field].length; i++) {
                                            toastr.error(res.errors[field][i]);
                                        }
                                    }
                                }
                            } else {
                                toastr.error(res.msg ||
                                    'An error occurred while processing your request.');
                            }
                        }
                    },
                    error: function() {
                        toastr.error('An error occurred while processing your request.');
                    }
                });
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            var firstSizeElement = $('#sizes .size:first');
            var firstColorElement = $('#colors .color:first');
            if (firstSizeElement.length) {
                firstSizeElement.click();
            }
            if (firstColorElement.length) {
                firstColorElement.click();
            }

            $('.popup-link').magnificPopup({
                type: 'image',
                gallery: {
                    enabled: true
                }
            });
        });

        $('#sizes').on('click', '.size', function() {
            $('#sizes .size').removeClass('active');
            $(this).addClass('active');
            let value = $(this).attr('value');
            let varSize = $(this).data('varsize');
            let variation_size_id = $(this).data('varsizeid');
            $('#select_size').text('{{ __('Size:') }} ' + varSize);

            var retrieve_price = $('input[id="retrieve_price"]').val();
            let variationPrice = parseFloat($(this).data('varprice'));

            $.ajax({
                type: 'get',
                url: '{{ route('front.product.get-variation_price') }}',
                data: {
                    varSize,
                    value,
                    variationPrice,
                    variation_size_id
                },
                success: function(res) {
                    $('.price-primary').text(res.price + ' {{ __('Tk') }}');
                    $('#size_value').val();
                    $('#variation_size_id').val();
                    $('#price_val').val(res.price);
                    $('#pro_price').val(res.price);

                    var retrieve_discount = Number(retrieve_price) - Number(res.price);
                    $('input[id="retrieve_discount"]').val(retrieve_discount);
                }
            });

            $("#size_value").val(varSize);
            $("#size_variation_id").val(value);
            $("#variation_size_id").val(variation_size_id);
        });

        $('#colors').on('click', '.color', function() {
            $('#colors .color').removeClass('active');
            $(this).addClass('active');
            let value = $(this).attr('value');
            let varColor = $(this).data('varcolor');
            let product_id = $(this).data('proid');
            let color_id = $(this).data('colorid');
            let variation_color_id = $(this).data('variationcolorid');
            let variation_size_id = $('input[name="variation_size_id"]').val();

            $.ajax({
                type: 'get',
                url: '{{ route('front.product.get-variation_color') }}',
                data: {
                    varColor,
                    value,
                    product_id,
                    color_id,
                    variation_color_id,
                    variation_size_id
                },
                success: function(res) {
                    $('.testslide-image').html(res.var_images);
                    $('input[name="pro_img"]').val(res.pro_img);
                    $('#color_value').val();
                    refreshGallerySwipers();

                    const $thumbWrapper = $('.product-thumbnail-slider .swiper-wrapper .swiper-slide').first().find('img');
                    if ($thumbWrapper.length) {
                        $thumbWrapper.attr('src', res.pro_img);
                    }

                    if (res.stock != '0') {
                        $('p.stock_check').text('');
                    } else {
                        $('p.stock_check').text('{{ __('Stock not available') }}');
                    }
                }
            });

            $("#color_value").val(varColor);
            $("#color_value1").val(value);
            $("#variation_color_id").val(variation_color_id);
            $('#select_color').text('{{ __('Color:') }} ' + varColor);
        });

        $(document).ready(function() {
            $('.testslide-image').izoomify();
        });
    </script>
@endpush
