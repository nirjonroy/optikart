@extends('frontend.app')

@section('title', __('Checkout'))

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/optikart/css/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/optikart/style.css') }}">
    <style>
        #banner {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 320px;
        }

        .checkout-card {
            border-radius: 24px;
            box-shadow: 0 24px 48px rgba(15, 23, 42, 0.08);
        }

        .checkout-card .table > :not(caption) > * > * {
            background-color: transparent;
        }

        .checkout-card .table thead th {
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.08em;
            border-bottom: none;
        }

        .checkout-card .table tbody tr {
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
        }

        .checkout-card .remove-item {
            width: 38px;
            height: 38px;
            border-radius: 50%;
        }

        .checkout-card .qty-btn {
            width: 42px;
            height: 42px;
            border-radius: 14px;
        }

        .checkout-card .qty-input {
            width: 60px;
            border-radius: 14px;
            text-align: center;
        }

        .summary-list .list-group-item {
            border: none;
        }

        .summary-list .list-group-item + .list-group-item {
            border-top: 1px solid rgba(15, 23, 42, 0.08);
        }

        .checkout-form label {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .checkout-form input,
        .checkout-form textarea,
        .checkout-form select {
            border-radius: 16px;
        }

        .shipping-option,
        .payment-option {
            border: 1px solid rgba(15, 23, 42, 0.1);
            border-radius: 18px;
            padding: 1rem 1.25rem;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .shipping-option:hover,
        .payment-option:hover {
            border-color: #0d6efd;
            box-shadow: 0 12px 30px rgba(13, 110, 253, 0.15);
        }

        .checkout-divider {
            border-top: 1px dashed rgba(15, 23, 42, 0.16);
        }
    </style>
@endpush

@section('content')
    @php
        $cartCollection = collect($cart);
        $subTotal = $cartCollection->reduce(function ($carry, $item) {
            $price = (float) data_get($item, 'price', 0);
            $quantity = (int) data_get($item, 'quantity', 0);
            return $carry + ($price * $quantity);
        }, 0);

        $shippingFlags = $cartCollection->pluck('is_free_shipping')->all();
        $requiresShippingSelection = in_array(null, $shippingFlags, true);
        $defaultShipping = null;
        if ($requiresShippingSelection) {
            $defaultShipping = collect($shippings)->first(function ($shipping) {
                return $shipping->id != 25;
            });
        }
        $initialShippingFee = $defaultShipping ? (float) $defaultShipping->shipping_fee : 0;
        $initialTotalAmount = $subTotal + $initialShippingFee;
    @endphp

    <section id="banner" style="background-image:url('{{ asset('frontend/optikart/images/banner-img2.jpg') }}');">
        <div class="container padding-medium-2">
            <div class="hero-content text-center">
                <h2 class="display-1 text-uppercase text-white mt-5 mb-0">{{ __('Checkout') }}</h2>

                <nav class="breadcrumb d-flex justify-content-center">
                    <a class="breadcrumb-item nav-link text-white-50" href="{{ route('front.home') }}">{{ __('Home') }}</a>
                    <span class="breadcrumb-item active text-white" aria-current="page">{{ __('Checkout') }}</span>
                </nav>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="checkout-card bg-white p-4 h-100">
                        <h2 class="h4 fw-semibold mb-4">{{ __('Order Summary') }}</h2>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">{{ __('Product') }}</th>
                                        <th scope="col">{{ __('Variations') }}</th>
                                        <th scope="col">{{ __('Quantity') }}</th>
                                        <th scope="col">{{ __('Price') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sub_total = 0; @endphp
                                    @forelse ($cart as $key => $item)
                                        @php
                                            $productId = data_get($item, 'product_id', $key);
                                            $product = \App\Models\Product::find($productId);
                                            $productSlug = $product ? $product->slug : null;
                                            $productUrl = $productSlug ? route('front.product.show', $productSlug) : '#';

                                            $price = (float) data_get($item, 'price', 0);
                                            $quantity = (int) data_get($item, 'quantity', 0);
                                            $lineTotal = $price * $quantity;
                                            $sub_total += $lineTotal;

                                            $imagePath = data_get($item, 'image');
                                            $imagePath = $imagePath ? ltrim($imagePath, '/') : '';
                                            $imageUrl = asset('frontend/assets005/images/category1.jpg');
                                            if ($imagePath) {
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
                                        <tr class="cart-line-row" data-unit-price="{{ $price }}">
                                            <td>
                                                <button class="btn btn-outline-danger remove-item" data-id="{{ $key }}">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </td>
                                            <td class="d-flex align-items-center gap-3">
                                                <img src="{{ $imageUrl }}" alt="{{ data_get($item, 'name') }}" class="img-fluid rounded-4" width="80">
                                                <div>
                                                    <a href="{{ $productUrl }}" class="fw-semibold text-dark text-decoration-none d-block">
                                                        {{ \Illuminate\Support\Str::limit(data_get($item, 'name'), 40) }}
                                                    </a>
                                                    <small class="text-muted">{{ data_get($item, 'category_name') }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="small text-muted">
                                                    @if (data_get($item, 'variation_size'))
                                                        <div>{{ __('Size') }}: {{ data_get($item, 'variation_size') }}</div>
                                                    @endif
                                                    @if (data_get($item, 'variation_color'))
                                                        <div>{{ __('Color') }}: {{ data_get($item, 'variation_color') }}</div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <button class="btn btn-outline-secondary qty-btn dec" data-id="{{ $key }}">-</button>
                                                    <input type="number" min="1" class="form-control mx-2 qty-input quantity-value" value="{{ $quantity }}" data-id="{{ $key }}">
                                                    <button class="btn btn-outline-secondary qty-btn inc" data-id="{{ $key }}">+</button>
                                                </div>
                                            </td>
                                            <td>
                                                <strong class="line-total">{{ number_format($lineTotal, 2) }} {{ __('Tk') }}</strong>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <strong>{{ __('Your cart is empty.') }}</strong>
                                            </td>
                                        </tr>
                                    @endforelse
                                    <tr class="fw-semibold">
                                        <td colspan="4" class="text-end text-uppercase">{{ __('Subtotal') }}</td>
                                        <td><span id="subtotal_value">{{ number_format($sub_total, 2) }}</span> {{ __('Tk') }}</td>
                                    </tr>
                                    <tr class="fw-semibold">
                                        <td colspan="4" class="text-end text-uppercase">{{ __('Shipping') }}</td>
                                        <td><span id="shipping_value">{{ number_format($initialShippingFee, 2) }} {{ __('Tk') }}</span></td>
                                    </tr>
                                    <tr class="fw-bold fs-5">
                                        <td colspan="4" class="text-end text-uppercase">{{ __('Total') }}</td>
                                        <td>
                                            <span id="total_amount">{{ number_format($initialTotalAmount, 2) }} {{ __('Tk') }}</span>
                                            <input type="hidden" name="total_amount" id="total_amount_input" value="{{ $initialTotalAmount }}">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="checkout-divider my-4"></div>

                        <div>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="mb-0 text-muted">{{ __('Have a coupon?') }}</p>
                                <button type="button" class="btn btn-sm btn-dark" id="coupon-toggle">{{ __('Apply Coupon') }}</button>
                            </div>
                            <div class="mt-3" id="coupon-form" style="display: none;">
                                <form action="{{ route('front.cart.apply-coupon') }}" method="POST" id="coupon_form">
                                    @csrf
                                    <input type="hidden" name="shipping_id" id="shipping_id" value="{{ $defaultShipping?->id ?? 0 }}">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('Coupon code') }}</label>
                                        <input type="text" class="form-control" name="code" id="code" placeholder="{{ __('Enter your coupon code') }}">
                                    </div>
                                    <button type="submit" class="btn btn-outline-dark w-100">{{ __('Apply Coupon') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="checkout-card bg-white p-4 h-100 checkout-form">
                        <h2 class="h4 fw-semibold mb-4">{{ __('Billing & Shipping Details') }}</h2>
                        <form action="{{ route('front.checkout.store') }}" method="POST" id="checkoutForm">
                            @csrf
                            <input type="hidden" name="ip_address" id="ip_address" value="">

                            <div class="mb-3">
                                <label for="shipping_name" class="form-label">{{ __('Full Name') }} *</label>
                                <input type="text" class="form-control shadow-none" name="shipping_name" id="shipping_name" value="{{ old('shipping_name') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="shipping_email" class="form-label">{{ __('Email Address') }}</label>
                                <input type="email" class="form-control shadow-none" name="shipping_email" id="shipping_email" value="{{ old('shipping_email') }}">
                            </div>

                            <div class="mb-3">
                                <label for="order_phone" class="form-label">{{ __('Phone Number') }} *</label>
                                <input type="tel" class="form-control shadow-none" name="order_phone" id="order_phone" maxlength="11" minlength="11" value="{{ old('order_phone') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="shipping_address" class="form-label">{{ __('Address') }} *</label>
                                <textarea class="form-control shadow-none" name="shipping_address" id="shipping_address" rows="3" required>{{ old('shipping_address') }}</textarea>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="shipping_country" class="form-label">{{ __('Country') }}</label>
                                    <select class="form-select shadow-none" id="shipping_country" name="shipping_country">
                                        <option value="">{{ __('Select a country') }}</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="shipping_city" class="form-label">{{ __('City') }}</label>
                                    <input type="text" class="form-control shadow-none" id="shipping_city" name="shipping_city" value="{{ old('shipping_city') }}">
                                </div>
                            </div>

                            <div class="checkout-divider my-4"></div>

                            <h3 class="h5 fw-semibold mb-3">{{ __('Shipping Method') }}</h3>
                            <div class="vstack gap-3">
                                @php $index = 0; @endphp
                                @if ($requiresShippingSelection)
                                    @foreach ($shippings as $shipping)
                                        @continue($shipping->id == 25)
                                        <label class="shipping-option d-flex justify-content-between align-items-center">
                                            <span>
                                                <input type="radio" value="{{ $shipping->id }}" class="charge_radio delivery_charge_id me-2"
                                                       id="ship_{{ $shipping->id }}"
                                                       data-shippingid="{{ $shipping->id }}"
                                                       name="shipping_method" data-shipping="{{ $shipping->shipping_fee }}"
                                                       {{ optional($defaultShipping)->id === $shipping->id ? 'checked' : '' }}>
                                                <strong>{{ $shipping->shipping_rule }}</strong>
                                            </span>
                                            <span>{{ number_format($shipping->shipping_fee, 2) }} {{ __('Tk') }}</span>
                                        </label>
                                        @php $index++; @endphp
                                    @endforeach
                                @else
                                    <div class="alert alert-success mb-0" role="alert">
                                        {{ __('Free shipping is available for the products in your cart.') }}
                                    </div>
                                    <input type="hidden" name="shipping_method" value="0">
                                @endif
                            </div>

                            <div class="checkout-divider my-4"></div>

                            <h3 class="h5 fw-semibold mb-3">{{ __('Payment Method') }}</h3>
                            <div class="vstack gap-3 mb-4">
                                <label class="payment-option d-flex justify-content-between align-items-center">
                                    <span>
                                        <input type="radio" name="payment_method" value="cash_on_delivery" class="me-2" checked>
                                        {{ __('Cash on Delivery') }}
                                    </span>
                                </label>
                                @if ($ssl_payment)
                                    <label class="payment-option d-flex justify-content-between align-items-center">
                                        <span>
                                            <input type="radio" name="payment_method" value="ssl_commerz" class="me-2">
                                            {{ __('SSLCommerz') }}
                                        </span>
                                    </label>
                                @endif
                                @if ($bkash_payment)
                                    <label class="payment-option d-flex justify-content-between align-items-center">
                                        <span>
                                            <input type="radio" name="payment_method" value="bkash" class="me-2">
                                            {{ __('Bkash') }}
                                        </span>
                                    </label>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="ordered_delivery_date" class="form-label">{{ __('Preferred Delivery Date') }}</label>
                                <input type="date" class="form-control" name="ordered_delivery_date" id="ordered_delivery_date" value="{{ old('ordered_delivery_date') }}">
                            </div>
                            <div class="mb-4">
                                <label for="ordered_delivery_time" class="form-label">{{ __('Preferred Delivery Time') }}</label>
                                <input type="time" class="form-control" name="ordered_delivery_time" id="ordered_delivery_time" value="{{ old('ordered_delivery_time') }}">
                            </div>

                            <button type="submit" class="btn btn-dark w-100 py-3">
                                {{ __('Confirm Order') }} <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="register" style="background-image:url('{{ asset('frontend/optikart/images/background-img.jpg') }}');">
        <div class="container padding-medium">
            <div class="row banner-content align-items-center padding-medium">
                <div class="col-md-6">
                    <h2 class="display-3 text-white mt-3">{{ __('Get') }} <span><em>20% {{ __('OFF') }}</em></span> {{ __('on your first purchase') }}</h2>
                    <p class="text-white mb-4">{{ __('Sign up for our newsletter and never miss exclusive offers.') }}</p>
                </div>
                <div class="col-md-4 offset-md-1">
                    <form id="newsletter-form">
                        <div class="mb-3">
                            <input type="email" class="form-control form-control-lg rounded-3 text-center" placeholder="{{ __('Enter Your Email Address') }}">
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark btn-lg rounded-3">{{ __('Register now') }}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>

    @foreach ($cart as $item)
        <div class="cart-item-data"
             data-product-id="{{ data_get($item, 'product_id') }}"
             data-product-name="{{ data_get($item, 'name') }}"
             data-category-name="{{ data_get($item, 'category_name') }}"
             data-price="{{ data_get($item, 'price') }}"
             data-quantity="{{ data_get($item, 'quantity') }}">
        </div>
    @endforeach
    <input type="hidden" name="total_cart_price" value="{{ $totalPrice }}">
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#coupon-toggle').on('click', function() {
                $('#coupon-form').slideToggle();
            });
        });

        fetch('https://api64.ipify.org?format=json')
            .then(response => response.json())
            .then(data => {
                const ipField = document.getElementById('ip_address');
                if (ipField) {
                    ipField.value = data.ip;
                }
            })
            .catch(error => console.error('Error fetching IP address:', error));

        $(document).ready(function() {
            generateDataLayers();
            $('.charge_radio').on('click', function() {
                getCharge();
            });

            $('.inc').on('click', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const input = $('.quantity-value[data-id="' + id + '"]');
                let value = parseInt(input.val(), 10) || 1;
                input.val(value + 1).trigger('change');
            });

            $('.dec').on('click', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const input = $('.quantity-value[data-id="' + id + '"]');
                let value = parseInt(input.val(), 10) || 1;
                value = Math.max(1, value - 1);
                input.val(value).trigger('change');
            });

            $('.quantity-value').on('change', function() {
                let value = parseInt($(this).val(), 10) || 1;
                value = Math.max(1, value);
                $(this).val(value);
                getCharge();
            });

            getCharge();
        });

        function calculateSubTotal() {
            let subtotal = 0;
            $('.cart-line-row').each(function() {
                const unitPrice = parseFloat($(this).data('unit-price')) || 0;
                const quantity = parseInt($(this).find('.quantity-value').val(), 10) || 0;
                const lineTotal = unitPrice * quantity;
                subtotal += lineTotal;
                $(this).find('.line-total').text(lineTotal.toFixed(2) + ' {{ __('Tk') }}');
            });
            $('#subtotal_value').text(subtotal.toFixed(2));
            return subtotal;
        }

        function getCharge() {
            const subtotal = calculateSubTotal();
            let shippingCost = 0;
            const selectedShipping = $('.charge_radio:checked');
            if (selectedShipping.length) {
                shippingCost = parseFloat(selectedShipping.data('shipping')) || 0;
                $('#shipping_id').val(selectedShipping.data('shippingid'));
            }

            $('#shipping_value').text(shippingCost.toFixed(2) + ' {{ __('Tk') }}');

            let totalAmount = subtotal + shippingCost;

            $('#total_amount').text(totalAmount.toFixed(2) + ' {{ __('Tk') }}');
            $('#total_amount_input').val(totalAmount.toFixed(2));
        }

        function generateDataLayers() {
            var items = [];
            $('.cart-item-data').each(function() {
                var product_id = $(this).data('product-id');
                var product_name = $(this).data('product-name');
                var category_name = $(this).data('category-name');
                var price = $(this).data('price');
                var quantity = $(this).data('quantity');
                items.push({
                    item_id: product_id,
                    item_name: product_name,
                    item_category: category_name,
                    price: price,
                    quantity: quantity
                });
            });
            let total = $('input[name="total_cart_price"]').val();

            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push({
                event: "begin_checkout",
                ecommerce: {
                    currency: "BDT",
                    value: total,
                    items: items
                }
            });
        }
    </script>
@endpush
