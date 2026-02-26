@extends('frontend.app')

@section('title', __('Order Confirmation'))

@push('css')
    <link rel="stylesheet" href="{{ asset('frontend/optikart/css/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/optikart/style.css') }}">
    <style>
        #banner {
            background-image: url('{{ asset('frontend/optikart/images/banner-img2.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 320px;
        }

        .thankyou-card {
            border-radius: 28px;
            box-shadow: 0 28px 50px rgba(15, 23, 42, 0.12);
        }

        .order-summary-card {
            border-radius: 24px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        }

        .order-summary-card .table > :not(caption) > * > * {
            background-color: transparent;
        }

        .order-summary-card .table thead th {
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.08em;
            border-bottom: none;
        }

        .order-summary-card .table tbody tr {
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
        }
    </style>
@endpush

@section('content')
    @php
        $order = $order_inv;
        $orderProducts = $order?->orderProducts ?? collect();
        $totalAmount = $orderProducts->reduce(function ($carry, $item) {
            $unit = (float) data_get($item, 'unit_price', 0);
            $qty = (int) data_get($item, 'qty', 0);
            return $carry + ($unit * $qty);
        }, 0.0);
    @endphp

    <section id="banner">
        <div class="container padding-medium-2">
            <div class="hero-content text-center">
                <h2 class="display-1 text-uppercase text-white mt-5 mb-0">{{ __('Thank You') }}</h2>
                <nav class="breadcrumb d-flex justify-content-center">
                    <a class="breadcrumb-item nav-link text-white-50" href="{{ route('front.home') }}">{{ __('Home') }}</a>
                    <span class="breadcrumb-item active text-white" aria-current="page">{{ __('Order Confirmation') }}</span>
                </nav>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="thankyou-card bg-white p-5 text-center mb-5">
                <div class="mb-4">
                    <iconify-icon icon="clarity:success-standard-solid" class="display-3 text-success"></iconify-icon>
                </div>
                <h1 class="display-5 fw-semibold text-dark mb-3">{{ __('Thanks for your order!') }}</h1>
                <p class="text-muted fs-5 mb-4">
                    {{ __('Your order has been received and is being processed. Our team will contact you shortly to confirm shipping details.') }}
                </p>
                @if (!empty($order?->order_id))
                    <div class="alert alert-primary d-inline-block px-4 py-2 mb-4 fw-semibold">
                        {{ __('Invoice Number:') }} #{{ $order->order_id }}
                    </div>
                @endif
                <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
                    <a href="{{ route('front.home') }}" class="btn btn-dark px-5 py-3">{{ __('Back to Home') }}</a>
                    @if (!empty($order?->order_phone))
                        <a href="{{ route('front.order-list', $order->order_phone) }}" class="btn btn-outline-dark px-5 py-3">
                            {{ __('See all orders') }}
                        </a>
                    @endif
                </div>
            </div>

            @if ($order)
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="order-summary-card bg-white p-4 h-100">
                            <h2 class="h4 fw-semibold mb-4">{{ __('Order Summary') }}</h2>
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Product') }}</th>
                                            <th>{{ __('Quantity') }}</th>
                                            <th>{{ __('Unit Price') }}</th>
                                            <th>{{ __('Total') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($orderProducts as $item)
                                            @php
                                                $product = $item->product ?? null;
                                                $productName = $product->name ?? data_get($item, 'product_name', __('Product'));
                                                $qty = (int) data_get($item, 'qty', 0);
                                                $unitPrice = (float) data_get($item, 'unit_price', 0);
                                                $lineTotal = $unitPrice * $qty;
                                                $productSlug = $product?->slug;
                                                $productUrl = $productSlug ? route('front.product.show', $productSlug) : '#';
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        @if ($product?->thumb_image)
                                                            <img src="{{ asset('uploads/custom-images/' . $product->thumb_image) }}" alt="{{ $productName }}" class="img-fluid rounded-3" width="70">
                                                        @endif
                                                        <a href="{{ $productUrl }}" class="fw-semibold text-dark text-decoration-none">
                                                            {{ \Illuminate\Support\Str::limit($productName, 40) }}
                                                        </a>
                                                    </div>
                                                </td>
                                                <td>{{ $qty }}</td>
                                                <td>{{ number_format($unitPrice, 2) }} {{ __('Tk') }}</td>
                                                <td>{{ number_format($lineTotal, 2) }} {{ __('Tk') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">{{ __('No items found for this order.') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <div class="text-end">
                                    <div class="text-muted text-uppercase small">{{ __('Order Total') }}</div>
                                    <div class="display-6 fw-semibold text-dark">{{ number_format($totalAmount, 2) }} {{ __('Tk') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="order-summary-card bg-white p-4 h-100">
                            <h2 class="h5 fw-semibold mb-3">{{ __('Order Details') }}</h2>
                            <ul class="list-unstyled mb-4">
                                <li class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">{{ __('Order ID') }}</span>
                                    <span class="fw-semibold">{{ $order->order_id ?? __('N/A') }}</span>
                                </li>
                                <li class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">{{ __('Order Date') }}</span>
                                    <span class="fw-semibold">{{ optional($order->created_at)->format('d M Y, h:i A') }}</span>
                                </li>
                                <li class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">{{ __('Payment Method') }}</span>
                                    <span class="fw-semibold text-capitalize">{{ str_replace('_', ' ', $order->payment_method ?? __('N/A')) }}</span>
                                </li>
                                <li class="d-flex justify-content-between">
                                    <span class="text-muted">{{ __('Shipping Method') }}</span>
                                    <span class="fw-semibold">{{ $order->shipping_method ?? __('N/A') }}</span>
                                </li>
                            </ul>

                            <h2 class="h5 fw-semibold mb-3">{{ __('Shipping Address') }}</h2>
                            <address class="text-muted mb-0">
                                {{ $order->shipping_name ?? __('Customer') }}<br>
                                {{ $order->shipping_address ?? __('Address not provided') }}<br>
                                {{ $order->shipping_city }} {{ $order->shipping_state }}<br>
                                {{ $order->shipping_country }}<br>
                                {{ __('Phone:') }} {{ $order->order_phone }}
                            </address>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-warning text-center">
                    {{ __('We could not find an order associated with this request.') }}
                </div>
            @endif
        </div>
    </section>
@endsection
