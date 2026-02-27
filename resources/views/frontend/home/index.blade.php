@extends('frontend.app')
@section('title', 'Home')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('frontend/assets0/css/owl.carousel.min.css') }}">
@endpush

@section('content')
    <section id="hero">
        <div class="swiper slideshow">
            <div class="swiper-wrapper">
                @forelse ($slider as $slide)
                    @php
                        $slideImage = $slide->image ? asset($slide->image) : asset('frontend/assets005/images/banner1.jpg');
                    @endphp
                    <div class="swiper-slide" style="background-image:url({{ $slideImage }});">
                        <div class="container-fluid px-5 padding-large">
                            <div class="row">
                                <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                                    @if (!empty($slide->badge))
                                        <span class="badge bg-light text-dark text-uppercase mb-3">{{ $slide->badge }}</span>
                                    @endif
                                    @php
                                        $slideTitle = $slide->title ?? $slide->title_one ?? __('Frame Your Style');
                                        $slideDescription = $slide->description ?? $slide->title_two ?? __('Elevate your looks with spectacular shades');
                                        $slideButtonText = !empty($slide->btn_text) ? $slide->btn_text : null;
                                        $slideButtonLink = !empty($slide->btn_link) ? $slide->btn_link : route('front.shop');
                                    @endphp
                                    <h2 class="display-1 text-uppercase text-white mt-3">{{ $slideTitle }}</h2>
                                    <p class="text-capitalize text-white fs-5 mb-4">
                                        {{ $slideDescription }}
                                    </p>
                                    @if (!empty($slideButtonText))
                                        <a href="{{ $slideButtonLink }}" class="btn btn-outline-light btn-wrap">
                                            {{ $slideButtonText }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="swiper-slide" style="background-image:url({{ asset('frontend/assets005/images/banner1.jpg') }});">
                        <div class="container-fluid px-5 padding-large">
                            <div class="row">
                                <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                                    <h2 class="display-1 text-uppercase text-white mt-3">{{ __('Frame Your Style') }}</h2>
                                    <p class="text-capitalize text-white fs-5 mb-4">{{ __('Elevate your looks with spectacular shades') }}</p>
                                    <a href="{{ route('front.shop') }}" class="btn btn-outline-light btn-wrap">
                                        {{ __('Start Shopping') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="swiper-pagination swiper-pagination-slideshow "></div>
            <div class="swiper-button-prev slider-nav-btn" aria-label="Previous slide"></div>
            <div class="swiper-button-next slider-nav-btn" aria-label="Next slide"></div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container-fluid px-3 px-md-5">
            <div class="row mb-4">
                <div class="col text-center text-md-start">
                    <h2 class="h3 fw-semibold text-dark mb-0">{{ __('Innovative Solutions') }}</h2>
                </div>
            </div>
            <div class="row g-4">
                @php
                    $solutionCards = [
                        [
                            'title' => __('Home Try-On Service'),
                            'text' => __('Our mobile team delivers a curated selection of frames directly to your home. Try them on at your convenience before making a purchase.'),
                        ],
                        [
                            'title' => __('Online Selection & Appointment'),
                            'text' => __('Browse our collection online, book a home appointment, and let our experts bring vision care to your doorstep.'),
                        ],
                        [
                            'title' => __('Vision Accessibility'),
                            'text' => __('We\'re building digital tools to connect rural and urban communities with quality eyewear without visiting a physical store.'),
                        ],
                    ];
                @endphp

                @foreach ($solutionCards as $card)
                    <div class="col-12 col-md-4">
                        <div class="h-100 p-4 rounded-4 shadow-sm bg-white">
                            <h3 class="h5 fw-semibold text-dark mb-3">{{ $card['title'] }}</h3>
                            <p class="mb-0 text-muted">{{ $card['text'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @php
        $aboutImage = optional($about)->video_background
            ? asset($about->video_background)
            : asset('frontend/assets005/images/about-banner.jpg');
    @endphp

    <section id="about-story" class="padding-medium">
        <div class="container-fluid px-3 px-md-5">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <div class="ratio ratio-4x3 rounded-4 overflow-hidden shadow-sm">
                        <img src="{{ $aboutImage }}" alt="{{ __('About Opticart') }}" class="w-100 h-100 object-fit-cover">
                    </div>
                </div>
                <div class="col-lg-6">
                    <span class="text-uppercase text-primary fw-semibold">{{ __('Our Story') }}</span>
                    <h2 class="display-5 fw-light mt-3">
                        {{ optional($about)->title ?? __('Opticart eyewear story') }}
                    </h2>
                    <div class="text-muted fs-6 mb-4">
                        {!! optional($about)->about_us ??
                            __('From handcrafted frames to cutting-edge lenses, every Opticart collection is designed to accentuate your personality while prioritising visual comfort.') !!}
                    </div>
                    <a href="{{ route('front.about') }}" class="btn btn-dark btn-lg">
                        {{ __('Read full story') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="contact-cta" class="py-5 bg-dark text-white">
        <div class="container-fluid px-3 px-md-5">
            <div class="row align-items-center g-3">
                <div class="col-lg-8">
                    <h3 class="h2 mb-2">{{ __('Need help with prescriptions or fittings?') }}</h3>
                    <p class="mb-0 text-white-50">
                        {{ __('Speak with our optical stylists, request prescription assistance, or book an appointment anytime.') }}
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('front.contact') }}" class="btn btn-light btn-lg">
                        {{ __('Contact us') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    @if ($collectionBanners->isNotEmpty())
        <section id="partners" class="padding-medium bg-light">
            <div class="container-fluid px-3 px-md-5">
                <div class="row justify-content-center text-center mb-4">
                    <div class="col-lg-8">
                        <span class="text-uppercase text-primary fw-semibold">{{ __('Partners') }}</span>
                        <h2 class="display-6 fw-light mt-2">{{ __('Official collaborations & optical partners') }}</h2>
                    </div>
                </div>
                <div class="owl-carousel partners-carousel">
                    @foreach ($collectionBanners as $banner)
                        @php
                            $brandLabel = $banner->brand ?? $banner->title ?? __('Partner');
                        @endphp
                        <div class="partner-slide text-center">
                            <div class="partner-card border rounded-4 p-4 bg-white shadow-sm d-flex align-items-center justify-content-center">
                                @if (!empty($banner->url))
                                    <a href="{{ $banner->url }}" target="_blank" rel="noopener" class="d-block">
                                        <img src="{{ asset($banner->image) }}" alt="{{ $brandLabel }}" class="img-fluid">
                                    </a>
                                @else
                                    <img src="{{ asset($banner->image) }}" alt="{{ $brandLabel }}" class="img-fluid">
                                @endif
                            </div>
                            @if ($brandLabel)
                                <p class="partner-label text-muted small mt-2 mb-0">{{ $brandLabel }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($latestBlogs->isNotEmpty())
        <section id="blog" class="padding-medium pt-0">
            <div class="container-fluid px-3 px-md-5">
                <div class="section-header d-md-flex justify-content-between align-items-center mb-3">
                    <div>
                        <span class="text-uppercase text-primary fw-semibold">{{ __('From the blog') }}</span>
                        <h2 class="display-5 fw-light text-uppercase m-0">{{ __('Recent Blog Posts') }}</h2>
                    </div>
                    <a href="{{ route('front.blog.index') }}" class="btn btn-outline-dark py-3 px-5">
                        {{ __('View all') }}
                    </a>
                </div>
                <div class="row">
                    @foreach ($latestBlogs->take(3) as $blog)
                        @php
                            $blogImage = $blog->image ?? '';
                            if ($blogImage) {
                                $blogImage = ltrim($blogImage, '/');
                                if (!\Illuminate\Support\Str::startsWith($blogImage, ['http://', 'https://'])) {
                                    $blogImage = asset($blogImage);
                                }
                            } else {
                                $blogImage = asset('frontend/assets005/images/blog1.jpg');
                            }
                            $blogDate = \Carbon\Carbon::parse($blog->created_at);
                        @endphp
                        <div class="col-md-4 my-4">
                            <div class="z-1 position-absolute m-2 px-3 pt-1">
                                <h2 class="text-white display-4 m-0">
                                    {{ $blogDate->format('d') }}<span class="fs-4">{{ strtoupper($blogDate->format('M')) }}</span>
                                </h2>
                            </div>
                            <div class="card position-relative">
                                <a href="{{ route('front.blog.show', $blog->slug) }}"><img src="{{ $blogImage }}" class="img-fluid" alt="{{ $blog->title }}"></a>
                                <div class="card-body p-0">
                                    <a href="{{ route('front.blog.show', $blog->slug) }}">
                                        <h3 class="card-title pt-4 pb-3 m-0">{{ \Illuminate\Support\Str::limit($blog->title, 60) }}</h3>
                                    </a>
                                    <div class="card-text">
                                        <p class="blog-paragraph fs-6">
                                            {{ \Illuminate\Support\Str::limit(strip_tags($blog->description ?? $blog->seo_description), 150) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection

@push('js')
    <script src="{{ asset('frontend/assets0/owl.carousel.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


    <script>
        $(document).on('click', 'a.productModal', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            let productId = $(this).data('productid');

            $.ajax({
                url: url,
                method: "GET",
                data: {
                    productId
                },
                success: function(res) {
                    $('div#commonModal').html(res.html).modal('show');
                }
            });
        });
    </script>


    <script>
        $(document).on('click', 'a#product_show', function(e) {
            e.preventDefault();

            let product_id = $(this).data('productid');
            let product_name = $(this).data('productname');
            let category_id = $(this).data('categoryid');
            let sell_price = $(this).closest('.product-item').find('.product_content span.current_price').text()
                .replace(/[^\d.]/g, '');
            let quantity = '1';

            window.dataLayer = window.dataLayer || [];
            dataLayer.push({
                event: "view_item",
                ecommerce: {
                    currency: "BDT",
                    value: sell_price,
                    items: [{
                        item_id: product_id,
                        item_name: product_name,
                        item_category: category_id,
                        price: sell_price,
                        quantity: quantity
                    }]
                }
            });

            let url = $(this).attr('href');
            if (url) {
                document.location.href = url;
            } else {

            }

        });
    </script>

    <script>
        $(document).ready(function() {
            $(document).on('submit', 'form.cart_form_home', function(e) {
                e.preventDefault();

                let url = $(this).attr('action');
                let method = $(this).attr('method');
                let id = $(this).find('input[name="id"]').val();
                let variation_id = $(this).find('input[name="variation_id"]').val();
                let varSize = $(this).find('input[name="variation_size"]').val();
                let variation_size_id = $(this).find('input[name="variation_size_id"]').val();
                let variation_price = $(this).find('input[name="variation_price"]').val();
                let varColor = $(this).find('input[name="variation_color"]').val();
                let variation_color_id = $(this).find('input[name="variation_color_id"]').val();
                let quantity = $(this).find('input[name="quantity"]').val();
                let type = $(this).find('input[name="type"]').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                $.ajax({
                    type: method,
                    url: url,
                    data: {
                        id,
                        variation_id,
                        varSize,
                        variation_size_id,
                        variation_price,
                        varColor,
                        variation_color_id,
                        quantity,
                        type
                    },
                    success: function(res) {
                        toastr.success(res.msg);
                        if (res.status) {
                            window.location.reload();
                        }
                    }
                });

            });

            $(document).on('click', 'button.do_order', function(e) {
                e.preventDefault();

                let url = $('form.cart_form_home').attr('action');
                let method = $('form.cart_form_home').attr('method');

                let id = $(this).closest('.modal').find('input[name="id"]').val();
                let variation_id = $(this).closest('.modal').find('input[name="variation_id"]').val();
                let varSize = $(this).closest('.modal').find('input[name="variation_size"]').val();
                let variation_size_id = $(this).closest('.modal').find('input[name="variation_size_id"]')
                    .val();
                let variation_price = $(this).closest('.modal').find('input[name="variation_price"]').val();
                let varColor = $(this).closest('.modal').find('input[name="variation_color"]').val();
                let variation_color_id = $(this).closest('.modal').find('input[name="variation_color_id"]')
                    .val();
                let quantity = $(this).closest('.modal').find('input[name="quantity"]').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                $.ajax({
                    url: url,
                    type: method,
                    data: {
                        id,
                        variation_id,
                        varSize,
                        variation_size_id,
                        variation_price,
                        varColor,
                        variation_color_id,
                        quantity
                    },
                    success: function(response) {
                        window.location.href = "{{ route('front.checkout.index') }}";
                    },
                    error: function(xhr, status, error) {
                        console.error('Error placing order:', error);
                    }
                });
            });


        });
    </script>

    <script>
        $(document).on('click', '#sizes .size', function() {

            $('#sizes .size').removeClass('active');
            $(this).addClass('active');

            let product_id = $(this).data('proid');
            let variation_id = $(this).attr('value');
            let variation_size = $(this).data('varsize');
            let variation_size_id = $(this).data('varsizeid');
            let variation_price = parseFloat($(this).data('varprice'));

            $(this).closest('.modal').find('#test_for').text('Select Size : ' + variation_size);
            $(this).closest('.modal').find('input[name="id"]').val(product_id);
            $(this).closest('.modal').find('input[name="variation_id"]').val(variation_id);
            $(this).closest('.modal').find('input[name="variation_size"]').val(variation_size);
            $(this).closest('.modal').find('input[name="variation_size_id"]').val(variation_size_id);
            $(this).closest('.modal').find('input[name="variation_price"]').val(variation_price);
        });
        $(document).on('click', '#colors .color', function() {

            $('#colors .color').removeClass('active');
            $(this).addClass('active');

            let product_id = $(this).data('proid');
            let variation_color = $(this).data('varcolor');
            let variation_color_id = $(this).data('colorid');
            let variation_size_id = $(this).closest('.modal').find('input[name="variation_size_id"]').val();

            $(this).closest('.modal').find('input[name="variation_color"]').val(variation_color);
            $(this).closest('.modal').find('input[name="variation_color_id"]').val(variation_color_id);

            $(this).closest('.modal').find('#selected_color').text('Select Color : ' + variation_color);

            $.ajax({
                type: 'get',
                url: '{{ route('front.product.get-variation_color') }}',
                data: {
                    product_id,
                    variation_size_id,
                    variation_color_id
                },
                success: function(res) {
                    //   alert(res.pro_img);

                    // $(this).closest('.modal').find('input[name="pro_img"]').val(res.pro_img);
                    // alert(variation_color);
                }
            });

        });
    </script>

    <script>
        $(document).ready(function() {
            // $('.buy-now').on('click', function (e) {
            //     e.preventDefault();

            //     var productId = $(this).attr('href').split('/').pop();
            //     var proQty = 1;
            //     var addToCartUrl = $(this).data('url');
            //     var csrfToken = $('meta[name="csrf-token"]').attr('content');
            //     var price=$(this).data('price');
            //     var offerprice=$(this).data('offerprice');
            //     var retrieve_discount=price-offerprice;

            //     // Include CSRF token in AJAX request headers
            //     $.ajaxSetup({
            //         headers: {
            //             'X-CSRF-TOKEN': csrfToken
            //         }
            //     });

            //     // Perform AJAX request to add the product to the cart
            //     $.post(addToCartUrl, { id: productId, quantity: proQty, retrieve_discount:retrieve_discount}, function (response) {
            //         // toastr.success(response.msg);
            //         if(response.status)
            //         {
            //             // Redirect to checkout page after adding to cart
            //             window.location.href = "{{ route('front.checkout.index') }}";
            //         } else
            //         {

            //         }

            //     });
            // });
        });
    </script>

    <script>
        $(function() {
            // Add CSS to initially hide the .offerBox
            function setCookie(name, value, minutes) {
                var expires = "";
                if (minutes) {
                    var date = new Date();
                    date.setTime(date.getTime() + (minutes * 60 * 1000));
                    expires = "; expires=" + date.toUTCString();
                }
                document.cookie = name + "=" + (value || "") + expires + "; path=/";
            }

            function getCookie(name) {
                var nameEQ = name + "=";
                var ca = document.cookie.split(';');
                for (var i = 0; i < ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) == ' ') {
                        c = c.substring(1, c.length);
                    }
                    if (c.indexOf(nameEQ) == 0) {
                        return c.substring(nameEQ.length, c.length);
                    }
                }
                return null;
            }

            $(".modal-overlay").click(function() {
                $('.offerBox').hide();
                setCookie('offerBoxHidden', 'true', 5);
            })

            $(".offerBox .content .close").click(function() {
                $('.offerBox').hide();
                setCookie('offerBoxHidden', 'true', 5);
            })

            // Check if the offerBox should be hidden based on the cookie
            var offerBoxHidden = getCookie('offerBoxHidden');

            if (offerBoxHidden === 'true') {
                $('.offerBox').hide();
            }





            $(document).on('click', '.add-to-cart', function(e) {
                let id = $(this).data('id');
                let url = $(this).data('url');
                addToCart(url, id);
            });

            // ... other click event handlers ...

            function addToCart(url, id, variation = "", quantity = 1) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        id,
                        quantity,
                        variation
                    },
                    success: function(res) {
                        if (res.status) {
                            //  toastr.success(res.msg);
                            window.location.reload();

                        } else {
                            toastr.error(res.msg);
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('An error occurred while processing your request.');
                    }
                });
            }

            // ... other functions ...

        });
    </script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                closeOnSelect: true
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.buy-now').on('click', function(e) {
                e.preventDefault();

                var productId = $(this).attr('href').split('/').pop();
                var proQty = 1;
                var addToCartUrl = $(this).data('url');
                var checkoutUrl = "{{ route('front.cart.index') }}";
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var price = Number($(this).data('price'));
                var offerprice = Number($(this).data('offerprice'));
                var retrieve_discount = price - offerprice;

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                $.post(addToCartUrl, {
                    id: productId,
                    quantity: proQty,
                    retrieve_discount: retrieve_discount
                }, function(response) {
                    toastr.success(response.msg);
                    if (response.status) {
                        window.location.href = "{{ route('front.checkout.index') }}";
                    } else {

                    }

                });
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            var $partnersCarousel = $('.partners-carousel');
            if ($partnersCarousel.length) {
                var partnerCount = $partnersCarousel.find('.partner-slide').length;
                $partnersCarousel.owlCarousel({
                    items: 6,
                    loop: partnerCount > 6,
                    margin: 24,
                    autoplay: true,
                    autoplayTimeout: 2500,
                    autoplayHoverPause: true,
                    smartSpeed: 600,
                    dots: false,
                    nav: false,
                    responsive: {
                        0: { items: 2 },
                        576: { items: 3 },
                        768: { items: 4 },
                        992: { items: 5 },
                        1200: { items: 6 }
                    }
                });
            }

            $('.owl-carousel').show();
            $('.product_slider_sell').owlCarousel({
                items: 1,
                loop: true,

                rewind: false,
                responsive: {
                    0: {
                        items: 1,

                    },
                    320: {
                        items: 2,

                    },
                    500: {
                        items: 2,

                    },
                    600: {
                        items: 3
                    },
                    870: {
                        items: 4
                    },
                    1070: {
                        items: 5
                    },
                    1200: {
                        items: 5
                    },
                    1300: {
                        items: 5
                    },
                    1400: {
                        items: 6
                    }
                }
            });



            $('.slider_product').owlCarousel({
                items: 1,
                loop: true,

                rewind: false,
                responsive: {
                    0: {
                        items: 1,

                    },
                    320: {
                        items: 2,

                    },
                    500: {
                        items: 2,

                    },
                    600: {
                        items: 3
                    },
                    870: {
                        items: 4
                    },
                    1070: {
                        items: 5
                    },
                    1200: {
                        items: 5
                    },
                    1300: {
                        items: 5
                    },
                    1400: {
                        items: 6
                    }
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            var popUpForm = document.getElementById("popUpForm");

            var shouldShowPopup = localStorage.getItem("showPopup");
            var lastCloseTime = localStorage.getItem("lastCloseTime");

            if (!shouldShowPopup || (shouldShowPopup && lastCloseTime && Date.now() - lastCloseTime >= 5 * 60 *
                    1000)) {
                popUpForm.style.display = "block";
            }
            // setTimeout(function () {
            //         popUpForm.style.display = "none";
            //     }, 10000);
            document.querySelector('.popupGrid').addEventListener('click', function(event) {
                if (event.target.classList.contains('popupGrid')) {
                    popUpForm.style.display = "none";
                    localStorage.setItem("showPopup", false);
                    localStorage.setItem("lastCloseTime", Date.now());
                }
            });
            document.getElementById("close").addEventListener("click", function() {
                popUpForm.style.display = "none";
                localStorage.setItem("showPopup", false);
                localStorage.setItem("lastCloseTime", Date.now());
            });
        });
    </script>
@endpush
