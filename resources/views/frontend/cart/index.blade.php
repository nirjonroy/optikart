@extends('frontend.app')

@section('title', __('Your Cart'))

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('frontend/optikart/css/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/optikart/style.css') }}">
    <style>
        .cart-section .table img {
            max-width: 120px;
            border-radius: 18px;
        }

        .cart-section .qty-btn {
            width: 42px;
            height: 42px;
            border-radius: 14px;
        }

        .cart-section .qty-input {
            width: 60px;
            border-radius: 14px;
            text-align: center;
        }

        .cart-summary-card {
            border-radius: 24px;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
        }

        .cart-summary-card .list-group-item {
            border: none;
            padding-left: 0;
            padding-right: 0;
        }

        .cart-summary-card .list-group-item + .list-group-item {
            border-top: 1px solid rgba(15, 23, 42, 0.08);
        }

        .cart-section .remove-item {
            border-radius: 999px;
            width: 42px;
            height: 42px;
        }

        .cart-section .table th {
            border: none;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.08em;
        }

        .cart-section .table tr {
            border-bottom: 1px solid rgba(15, 23, 42, 0.07);
        }

        .cart-section .product-name a {
            color: #111827;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
        }

        .cart-section .product-name a:hover {
            color: #0d6efd;
        }
    </style>
@endpush

@section('content')
    @php
        $cartItems = collect($cart);
        $totalAmount = $cartItems->reduce(function ($carry, $item) {
            $price = (float) data_get($item, 'price', 0);
            $qty = (int) data_get($item, 'quantity', 0);
            return $carry + ($qty * $price);
        }, 0.0);
    @endphp

    <section id="banner" class="py-5" style="background-image:url('{{ asset('frontend/optikart/images/banner-img2.jpg') }}'); background-size:cover;">
        <div class="container padding-medium-2">
            <div class="hero-content text-center">
                <h2 class="display-1 text-uppercase text-white mt-5 mb-0">{{ __('Shopping Cart') }}</h2>
                <nav class="breadcrumb d-flex justify-content-center">
                    <a class="breadcrumb-item nav-link text-white-50" href="{{ route('front.home') }}">{{ __('Home') }}</a>
                    <span class="breadcrumb-item active text-white" aria-current="page">{{ __('Cart') }}</span>
                </nav>
            </div>
        </div>
    </section>

    <section class="cart-section py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="table-responsive bg-white rounded-4 shadow-sm p-4">
                        <table class="table align-middle">
                            <thead>
                                <tr class="text-uppercase text-muted small">
                                    <th scope="col"></th>
                                    <th scope="col">{{ __('Product') }}</th>
                                    <th scope="col">{{ __('Price') }}</th>
                                    <th scope="col">{{ __('Quantity') }}</th>
                                    <th scope="col">{{ __('Subtotal') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cartItems as $key => $item)
                                    @php
                                        $productId = data_get($item, 'product_id', $key);
                                        $product = \App\Models\Product::find($productId);
                                        $productSlug = $product ? $product->slug : null;
                                        $productUrl = $productSlug ? route('front.product.show', $productSlug) : '#';
                                        $price = (float) data_get($item, 'price', 0);
                                        $qty = (int) data_get($item, 'quantity', 0);
                                        $subtotal = $qty * $price;
                                        $imagePath = data_get($item, 'image');

                                        $imageUrl = asset('frontend/assets005/images/category1.jpg');
                                        if ($imagePath) {
                                            $imagePath = ltrim($imagePath, '/');
                                            if (\Illuminate\Support\Str::startsWith($imagePath, ['http://', 'https://'])) {
                                                $imageUrl = $imagePath;
                                            } else {
                                                foreach ([$imagePath, "uploads/custom-images/{$imagePath}", "uploads/custom-images2/{$imagePath}"] as $candidate) {
                                                    if (file_exists(public_path($candidate))) {
                                                        $imageUrl = asset($candidate);
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                    @endphp
                                    <tr>
                                        <td>
                                            <button class="btn btn-outline-danger border-0 remove-item" data-id="{{ $key }}">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </td>
                                        <td class="d-flex align-items-center gap-3">
                                            <img src="{{ $imageUrl }}" class="img-fluid" alt="{{ data_get($item, 'name') }}">
                                            <div class="product-name">
                                                <a href="{{ $productUrl }}">{{ data_get($item, 'name') }}</a>
                                                @if (data_get($item, 'variation'))
                                                    <div class="text-muted small mt-1">{{ data_get($item, 'variation') }}</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <strong>{{ number_format($price, 2) }} {{ __('Tk') }}</strong>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <button class="btn btn-outline-secondary qty-btn dec" data-id="{{ $key }}">-</button>
                                                <input type="number" min="1" class="form-control mx-2 qty-input quantity-value"
                                                       value="{{ $qty }}" data-id="{{ $key }}">
                                                <button class="btn btn-outline-secondary qty-btn inc" data-id="{{ $key }}">+</button>
                                            </div>
                                        </td>
                                        <td>
                                            <strong>{{ number_format($subtotal, 2) }} {{ __('Tk') }}</strong>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <strong>{{ __('Your cart is currently empty.') }}</strong>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cart-summary-card bg-white rounded-4 p-4">
                        <h4 class="fw-semibold mb-4">{{ __('Order Summary') }}</h4>
                        <ul class="list-group mb-4">
                            @foreach ($cartItems as $item)
                                @php
                                    $price = (float) data_get($item, 'price', 0);
                                    $qty = (int) data_get($item, 'quantity', 0);
                                @endphp
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">{{ data_get($item, 'name') }}</h6>
                                        <small class="text-muted">{{ __('Qty:') }} {{ $qty }}</small>
                                    </div>
                                    <span>{{ number_format($price * $qty, 2) }} {{ __('Tk') }}</span>
                                </li>
                            @endforeach
                            <li class="list-group-item d-flex justify-content-between border-top pt-3">
                                <span class="fw-bold text-uppercase">{{ __('Total') }}</span>
                                <span class="fw-bold">{{ number_format($totalAmount, 2) }} {{ __('Tk') }}</span>
                            </li>
                        </ul>
                        <a href="{{ route('front.checkout.index') }}" class="btn btn-dark w-100 py-3">
                            {{ __('Proceed to Checkout') }}
                        </a>
                        <a href="{{ route('front.shop') }}" class="btn btn-outline-dark w-100 py-3 mt-3">
                            {{ __('Continue Shopping') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        (function () {
            const updateTotal = () => {
                let total = 0;
                document.querySelectorAll('.quantity-value').forEach(input => {
                    const qty = parseInt(input.value, 10) || 0;
                    const price = parseFloat(input.closest('tr').querySelector('.subtotal').dataset.price || 0);
                    total += qty * price;
                });
                const totalEl = document.getElementById('total-amount');
                if (totalEl) {
                    totalEl.textContent = total.toFixed(2) + ' {{ __('Tk') }}';
                }
            };

            document.querySelectorAll('.inc, .dec').forEach(btn => {
                btn.addEventListener('click', e => {
                    e.preventDefault();
                    const id = btn.dataset.id;
                    const input = document.querySelector(`.quantity-value[data-id="${id}"]`);
                    if (!input) return;
                    let value = parseInt(input.value, 10) || 1;
                    value += btn.classList.contains('inc') ? 1 : -1;
                    if (value < 1) value = 1;
                    input.value = value;
                    updateTotal();
                });
            });
        })();
    </script>
@endpush
