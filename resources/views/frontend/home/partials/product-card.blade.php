@php
    use Illuminate\Support\Str;

    $productImage = $product->thumb_image ?? '';
    if ($productImage) {
        $productImage = ltrim($productImage, '/');
        if (!Str::startsWith($productImage, ['http://', 'https://'])) {
            if (!Str::contains($productImage, '/')) {
                $productImage = 'uploads/custom-images2/' . $productImage;
            }
            $productImage = asset($productImage);
        }
    } else {
        $productImage = asset('frontend/images/nothing.png');
    }

    $productUrl = route('front.product.show', $product->slug);
    $hasOffer = !empty($product->offer_price) && $product->offer_price > 0;
    $currentPrice = $hasOffer ? $product->offer_price : $product->price;
@endphp

<div class="product-item h-100 d-flex flex-column">
    <div class="image-holder position-relative">
        @if ($hasOffer)
            <span class="position-absolute top-0 start-0 badge bg-danger text-white m-3 text-uppercase">
                {{ __('Sale') }}
            </span>
        @elseif (!empty($isNew))
            <span class="position-absolute top-0 start-0 badge bg-light text-dark m-3 text-uppercase">
                {{ __('New') }}
            </span>
        @endif
        <a href="{{ $productUrl }}" class="d-block">
            <img src="{{ $productImage }}" alt="{{ Str::limit($product->name, 40) }}" class="product-image img-fluid w-100">
        </a>
    </div>
    <div class="product-detail d-flex justify-content-between align-items-center mt-3">
        <h5 class="product-title mb-0">
            <a href="{{ $productUrl }}">{{ Str::limit($product->name, 40) }}</a>
        </h5>
        <div class="text-end">
            <p class="m-0 fs-6 fw-semibold">{{ number_format($currentPrice, 2) }} {{ __('Tk') }}</p>
            @if ($hasOffer)
                <small class="text-muted text-decoration-line-through">{{ number_format($product->price, 2) }} {{ __('Tk') }}</small>
            @endif
        </div>
    </div>
    <div class="mt-3">
        <a href="{{ $productUrl }}" class="btn btn-outline-dark w-100 text-uppercase fs-6">
            {{ __('View Product') }}
        </a>
    </div>
</div>

