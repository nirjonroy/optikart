<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ $ln_pg->title1 }}</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
    $siteInfo = DB::table('informations')->first();
@endphp
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Favicons -->
    {{-- <link href="{{ asset('landing') }}/img/favicon.png" rel="icon">
    <link href="{{ asset('landing') }}/img/apple-touch-icon.png" rel="apple-touch-icon"> --}}

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('landing') }}/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('landing') }}/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('landing') }}/vendor/aos/aos.css" rel="stylesheet">
    <link href="{{ asset('landing') }}/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="{{ asset('landing') }}/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('landing') }}/css/main.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: Arsha
  * Template URL: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">

            <a class="logo d-flex align-items-center me-auto">
                <p style="font-size: 20px; font-weight: bold; color: #fff;">{{ $ln_pg->title1 }}</p>
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="{{ asset('landing') }}/img/logo.png" alt=""> -->
                {{-- <h1 class="sitename">Arsha</h1> --}}
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    {{-- <li><a href="#hero" class="active">Home</a></li>
                    <li><a href="#about">About</a></li> --}}
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <a class="btn-getstarted" href="#contact">Order Now</a>

        </div>
    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero"
            style="background:url({{ asset('landing_pages/' . $ln_pg->landing_bg) }}) no-repeat center center; background-size:cover; "
            class="hero section dark-background">

            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center"
                        data-aos="zoom-out">

                        <div class="col-md-7 price_top_section"
                            style="border: 2px solid #FFA500;
text-align: center;
padding-top: 8px;
color: #ffffff;
border-radius: 5px;
font-size: 20px;
font-family: 'Hind Siliguri', sans-serif !important;
background: #FFA500">
                            <div class="offer_price" style="font-family: 'Hind Siliguri', sans-serif !important;">
                                {{ BanglaText('offer') }} {{ $ln_pg->regular_price_text }} {{ BanglaText('tk') }}
                            </div>

                        </div>
                        <div class="d-flex mt-4">
                            <a href="#contact"
                                class="btn-get-started">Order Now</a>
                            <a href="{{ $ln_pg->video_url }}"
                                class="glightbox btn-watch-video d-flex align-items-center"><i
                                    class="bi bi-play-circle"></i><span>Watch Video</span></a>
                        </div>
                    </div>

                </div>
            </div>

        </section><!-- /Hero Section -->



        <section id="about" class="about section">
            <div class="container">

                <div class="row gy-4">

                    <div class="col-lg-12 content" data-aos="fade-up" data-aos-delay="100">
                        <h3>{{ $ln_pg->left_side_title }}</h3>
                        <p> {!! $ln_pg->left_side_desc !!}</p>

                    </div>
                </div>
            </div>
        </section>

        <!-- Why Us Section -->
        {{-- <section id="why-us" class="section why-us light-background" data-builder="section">

            <div class="container-fluid">

                <div class="row gy-4">

                    <div class="col-lg-7 d-flex flex-column justify-content-center order-2 order-lg-1">

                        <div class="content px-xl-5" data-aos="fade-up" data-aos-delay="100">
                            <h3><span>Eum ipsam laborum deleniti </span><strong>velit pariatur architecto aut
                                    nihil</strong></h3>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Duis aute irure dolor in reprehenderit
                            </p>
                        </div>

                        <div class="faq-container px-xl-5" data-aos="fade-up" data-aos-delay="200">

                            <div class="faq-item faq-active">

                                <h3><span>01</span> Non consectetur a erat nam at lectus urna duis?</h3>
                                <div class="faq-content">
                                    <p>Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus
                                        laoreet non curabitur gravida. Venenatis lectus magna fringilla urna porttitor
                                        rhoncus dolor purus non.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3><span>02</span> Feugiat scelerisque varius morbi enim nunc faucibus a pellentesque?
                                </h3>
                                <div class="faq-content">
                                    <p>Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id
                                        interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus
                                        scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim.
                                        Mauris ultrices eros in cursus turpis massa tincidunt dui.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3><span>03</span> Dolor sit amet consectetur adipiscing elit pellentesque?</h3>
                                <div class="faq-content">
                                    <p>Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci.
                                        Faucibus pulvinar elementum integer enim. Sem nulla pharetra diam sit amet nisl
                                        suscipit. Rutrum tellus pellentesque eu tincidunt. Lectus urna duis convallis
                                        convallis tellus. Urna molestie at elementum eu facilisis sed odio morbi quis
                                    </p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                        </div>

                    </div>

                    <div class="col-lg-5 order-1 order-lg-2 why-us-img">
                        <img src="{{ asset('landing') }}/img/why-us.png" class="img-fluid" alt="" data-aos="zoom-in"
                            data-aos-delay="100">
                    </div>
                </div>

            </div>

        </section><!-- /Why Us Section --> --}}


        <!-- Services Section -->
        {{-- <section id="services" class="services section light-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Services</h2>
                <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">

                    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-activity icon"></i></div>
                            <h4><a href="" class="stretched-link">Lorem Ipsum</a></h4>
                            <p>Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-bounding-box-circles icon"></i></div>
                            <h4><a href="" class="stretched-link">Sed ut perspici</a></h4>
                            <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-calendar4-week icon"></i></div>
                            <h4><a href="" class="stretched-link">Magni Dolores</a></h4>
                            <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="400">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-broadcast icon"></i></div>
                            <h4><a href="" class="stretched-link">Nemo Enim</a></h4>
                            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis</p>
                        </div>
                    </div><!-- End Service Item -->

                </div>

            </div>

        </section><!-- /Services Section --> --}}

        <!-- Call To Action Section -->
        {{-- <section id="call-to-action" class="call-to-action section dark-background">

            <img src="{{ asset('landing') }}/img/cta-bg.jpg" alt="">

            <div class="container">

                <div class="row" data-aos="zoom-in" data-aos-delay="100">
                    <div class="col-xl-9 text-center text-xl-start">
                        <h3>Call To Action</h3>
                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                            pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                            mollit anim id est laborum.</p>
                    </div>
                    <div class="col-xl-3 cta-btn-container text-center">
                        <a class="cta-btn align-middle" href="#">Call To Action</a>
                    </div>
                </div>

            </div>

        </section><!-- /Call To Action Section --> --}}

        <!-- Portfolio Section -->
        {{-- <section id="portfolio" class="portfolio section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Portfolio</h2>
                <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="isotope-layout" data-default-filter="*" data-layout="masonry"
                    data-sort="original-order">

                    <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
                        <li data-filter="*" class="filter-active">All</li>
                        <li data-filter=".filter-app">App</li>
                        <li data-filter=".filter-product">Card</li>
                        <li data-filter=".filter-branding">Web</li>
                    </ul><!-- End Portfolio Filters -->

                    <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">

                        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-app">
                            <img src="{{ asset('landing') }}/img/masonry-portfolio/masonry-portfolio-1.jpg" class="img-fluid"
                                alt="">
                            <div class="portfolio-info">
                                <h4>App 1</h4>
                                <p>Lorem ipsum, dolor sit</p>
                                <a href="{{ asset('landing') }}/img/masonry-portfolio/masonry-portfolio-1.jpg" title="App 1"
                                    data-gallery="portfolio-gallery-app" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="portfolio-details.html" title="More Details" class="details-link"><i
                                        class="bi bi-link-45deg"></i></a>
                            </div>
                        </div><!-- End Portfolio Item -->

                        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
                            <img src="{{ asset('landing') }}/img/masonry-portfolio/masonry-portfolio-2.jpg" class="img-fluid"
                                alt="">
                            <div class="portfolio-info">
                                <h4>Product 1</h4>
                                <p>Lorem ipsum, dolor sit</p>
                                <a href="{{ asset('landing') }}/img/masonry-portfolio/masonry-portfolio-2.jpg" title="Product 1"
                                    data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="portfolio-details.html" title="More Details" class="details-link"><i
                                        class="bi bi-link-45deg"></i></a>
                            </div>
                        </div><!-- End Portfolio Item -->

                        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-branding">
                            <img src="{{ asset('landing') }}/img/masonry-portfolio/masonry-portfolio-3.jpg" class="img-fluid"
                                alt="">
                            <div class="portfolio-info">
                                <h4>Branding 1</h4>
                                <p>Lorem ipsum, dolor sit</p>
                                <a href="{{ asset('landing') }}/img/masonry-portfolio/masonry-portfolio-3.jpg" title="Branding 1"
                                    data-gallery="portfolio-gallery-branding" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="portfolio-details.html" title="More Details" class="details-link"><i
                                        class="bi bi-link-45deg"></i></a>
                            </div>
                        </div><!-- End Portfolio Item -->

                        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-app">
                            <img src="{{ asset('landing') }}/img/masonry-portfolio/masonry-portfolio-4.jpg" class="img-fluid"
                                alt="">
                            <div class="portfolio-info">
                                <h4>App 2</h4>
                                <p>Lorem ipsum, dolor sit</p>
                                <a href="{{ asset('landing') }}/img/masonry-portfolio/masonry-portfolio-4.jpg" title="App 2"
                                    data-gallery="portfolio-gallery-app" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="portfolio-details.html" title="More Details" class="details-link"><i
                                        class="bi bi-link-45deg"></i></a>
                            </div>
                        </div><!-- End Portfolio Item -->

                        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
                            <img src="{{ asset('landing') }}/img/masonry-portfolio/masonry-portfolio-5.jpg" class="img-fluid"
                                alt="">
                            <div class="portfolio-info">
                                <h4>Product 2</h4>
                                <p>Lorem ipsum, dolor sit</p>
                                <a href="{{ asset('landing') }}/img/masonry-portfolio/masonry-portfolio-5.jpg" title="Product 2"
                                    data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="portfolio-details.html" title="More Details" class="details-link"><i
                                        class="bi bi-link-45deg"></i></a>
                            </div>
                        </div><!-- End Portfolio Item -->

                        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-branding">
                            <img src="{{ asset('landing') }}/img/masonry-portfolio/masonry-portfolio-6.jpg" class="img-fluid"
                                alt="">
                            <div class="portfolio-info">
                                <h4>Branding 2</h4>
                                <p>Lorem ipsum, dolor sit</p>
                                <a href="{{ asset('landing') }}/img/masonry-portfolio/masonry-portfolio-6.jpg" title="Branding 2"
                                    data-gallery="portfolio-gallery-branding" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="portfolio-details.html" title="More Details" class="details-link"><i
                                        class="bi bi-link-45deg"></i></a>
                            </div>
                        </div><!-- End Portfolio Item -->

                        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-app">
                            <img src="{{ asset('landing') }}/img/masonry-portfolio/masonry-portfolio-7.jpg" class="img-fluid"
                                alt="">
                            <div class="portfolio-info">
                                <h4>App 3</h4>
                                <p>Lorem ipsum, dolor sit</p>
                                <a href="{{ asset('landing') }}/img/masonry-portfolio/masonry-portfolio-7.jpg" title="App 3"
                                    data-gallery="portfolio-gallery-app" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="portfolio-details.html" title="More Details" class="details-link"><i
                                        class="bi bi-link-45deg"></i></a>
                            </div>
                        </div><!-- End Portfolio Item -->

                        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
                            <img src="{{ asset('landing') }}/img/masonry-portfolio/masonry-portfolio-8.jpg" class="img-fluid"
                                alt="">
                            <div class="portfolio-info">
                                <h4>Product 3</h4>
                                <p>Lorem ipsum, dolor sit</p>
                                <a href="{{ asset('landing') }}/img/masonry-portfolio/masonry-portfolio-8.jpg" title="Product 3"
                                    data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="portfolio-details.html" title="More Details" class="details-link"><i
                                        class="bi bi-link-45deg"></i></a>
                            </div>
                        </div><!-- End Portfolio Item -->

                        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-branding">
                            <img src="{{ asset('landing') }}/img/masonry-portfolio/masonry-portfolio-9.jpg" class="img-fluid"
                                alt="">
                            <div class="portfolio-info">
                                <h4>Branding 3</h4>
                                <p>Lorem ipsum, dolor sit</p>
                                <a href="{{ asset('landing') }}/img/masonry-portfolio/masonry-portfolio-9.jpg" title="Branding 2"
                                    data-gallery="portfolio-gallery-branding" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="portfolio-details.html" title="More Details" class="details-link"><i
                                        class="bi bi-link-45deg"></i></a>
                            </div>
                        </div><!-- End Portfolio Item -->

                    </div><!-- End Portfolio Container -->

                </div>

            </div>

        </section><!-- /Portfolio Section --> --}}



        <!-- Pricing Section -->
        {{-- <section id="pricing" class="pricing section light-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Pricing</h2>
                <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">

                    <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="100">
                        <div class="pricing-item">
                            <h3>Free Plan</h3>
                            <h4><sup>$</sup>0<span> / month</span></h4>
                            <ul>
                                <li><i class="bi bi-check"></i> <span>Quam adipiscing vitae proin</span></li>
                                <li><i class="bi bi-check"></i> <span>Nec feugiat nisl pretium</span></li>
                                <li><i class="bi bi-check"></i> <span>Nulla at volutpat diam uteera</span></li>
                                <li class="na"><i class="bi bi-x"></i> <span>Pharetra massa massa ultricies</span>
                                </li>
                                <li class="na"><i class="bi bi-x"></i> <span>Massa ultricies mi quis
                                        hendrerit</span></li>
                            </ul>
                            <a href="#" class="buy-btn">Buy Now</a>
                        </div>
                    </div><!-- End Pricing Item -->

                    <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="200">
                        <div class="pricing-item featured">
                            <h3>Business Plan</h3>
                            <h4><sup>$</sup>29<span> / month</span></h4>
                            <ul>
                                <li><i class="bi bi-check"></i> <span>Quam adipiscing vitae proin</span></li>
                                <li><i class="bi bi-check"></i> <span>Nec feugiat nisl pretium</span></li>
                                <li><i class="bi bi-check"></i> <span>Nulla at volutpat diam uteera</span></li>
                                <li><i class="bi bi-check"></i> <span>Pharetra massa massa ultricies</span></li>
                                <li><i class="bi bi-check"></i> <span>Massa ultricies mi quis hendrerit</span></li>
                            </ul>
                            <a href="#" class="buy-btn">Buy Now</a>
                        </div>
                    </div><!-- End Pricing Item -->

                    <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="300">
                        <div class="pricing-item">
                            <h3>Developer Plan</h3>
                            <h4><sup>$</sup>49<span> / month</span></h4>
                            <ul>
                                <li><i class="bi bi-check"></i> <span>Quam adipiscing vitae proin</span></li>
                                <li><i class="bi bi-check"></i> <span>Nec feugiat nisl pretium</span></li>
                                <li><i class="bi bi-check"></i> <span>Nulla at volutpat diam uteera</span></li>
                                <li><i class="bi bi-check"></i> <span>Pharetra massa massa ultricies</span></li>
                                <li><i class="bi bi-check"></i> <span>Massa ultricies mi quis hendrerit</span></li>
                            </ul>
                            <a href="#" class="buy-btn">Buy Now</a>
                        </div>
                    </div><!-- End Pricing Item -->

                </div>

            </div>

        </section><!-- /Pricing Section --> --}}


        <!-- Products Section -->
        {{-- <section id="products" class="products section light-background">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Products</h2>
                <p>Check out our latest products</p>
            </div><!-- End Section Title -->

            <div class="container">
                <div class="row gy-4">

                    <div class="col-lg-4 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
                        <div class="product-item position-relative">
                            <div class="icon"><i class="bi bi-box-seam icon"></i></div>
                            <h4><a href="#" class="stretched-link">{{ $ln_pg->product->name }}</a></h4>
                            <p>{{ $ln_pg->product->description }}</p>
                            <p><strong>Price:</strong> ${{ $ln_pg->product->price }}</p>
                        </div>
                    </div><!-- End Product Item -->

                </div>
            </div>
        </section><!-- /Products Section --> --}}




        <!-- Testimonials Section -->
        {{-- <section id="testimonials" class="testimonials section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Testimonials</h2>
                <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="swiper init-swiper">
                    <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              }
            }
          </script>
                    <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="{{ asset('landing') }}/img/testimonials/testimonials-1.jpg" class="testimonial-img"
                                    alt="">
                                <h3>Saul Goodman</h3>
                                <h4>Ceo &amp; Founder</h4>
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i>
                                </div>
                                <p>
                                    <i class="bi bi-quote quote-icon-left"></i>
                                    <span>Proin iaculis purus consequat sem cure digni ssim donec porttitora entum
                                        suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et.
                                        Maecen aliquam, risus at semper.</span>
                                    <i class="bi bi-quote quote-icon-right"></i>
                                </p>
                            </div>
                        </div><!-- End testimonial item -->

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="{{ asset('landing') }}/img/testimonials/testimonials-2.jpg" class="testimonial-img"
                                    alt="">
                                <h3>Sara Wilsson</h3>
                                <h4>Designer</h4>
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i>
                                </div>
                                <p>
                                    <i class="bi bi-quote quote-icon-left"></i>
                                    <span>Export tempor illum tamen malis malis eram quae irure esse labore quem cillum
                                        quid cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat
                                        irure amet legam anim culpa.</span>
                                    <i class="bi bi-quote quote-icon-right"></i>
                                </p>
                            </div>
                        </div><!-- End testimonial item -->

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="{{ asset('landing') }}/img/testimonials/testimonials-3.jpg" class="testimonial-img"
                                    alt="">
                                <h3>Jena Karlis</h3>
                                <h4>Store Owner</h4>
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i>
                                </div>
                                <p>
                                    <i class="bi bi-quote quote-icon-left"></i>
                                    <span>Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla
                                        quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore
                                        quis sint minim.</span>
                                    <i class="bi bi-quote quote-icon-right"></i>
                                </p>
                            </div>
                        </div><!-- End testimonial item -->

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="{{ asset('landing') }}/img/testimonials/testimonials-4.jpg" class="testimonial-img"
                                    alt="">
                                <h3>Matt Brandon</h3>
                                <h4>Freelancer</h4>
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i>
                                </div>
                                <p>
                                    <i class="bi bi-quote quote-icon-left"></i>
                                    <span>Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim
                                        fugiat minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore
                                        quem dolore labore illum veniam.</span>
                                    <i class="bi bi-quote quote-icon-right"></i>
                                </p>
                            </div>
                        </div><!-- End testimonial item -->

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="{{ asset('landing') }}/img/testimonials/testimonials-5.jpg" class="testimonial-img"
                                    alt="">
                                <h3>John Larson</h3>
                                <h4>Entrepreneur</h4>
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i>
                                </div>
                                <p>
                                    <i class="bi bi-quote quote-icon-left"></i>
                                    <span>Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor
                                        noster veniam enim culpa labore duis sunt culpa nulla illum cillum fugiat legam
                                        esse veniam culpa fore nisi cillum quid.</span>
                                    <i class="bi bi-quote quote-icon-right"></i>
                                </p>
                            </div>
                        </div><!-- End testimonial item -->

                    </div>
                    <div class="swiper-pagination"></div>
                </div>

            </div>

        </section><!-- /Testimonials Section --> --}}
        <!-- Small Image Slider -->
        <section id="small-slider" class="small-slider section" style="padding: 20px 0; background: #f7f7f7;">
            <div class="container" data-aos="fade-up">
                <div class="swiper small-slider-swiper">
                    <div class="swiper-wrapper">
                        @foreach ($ln_pg->images as $slider)
                            <div class="swiper-slide text-center">
                                <img src="{{ asset('landing_sliders/' . $slider->image) }}" class="img-fluid"
                                    alt="Slide 1" style="width: 550px; height: 400px;">
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                new Swiper('.small-slider-swiper', {
                    loop: true,
                    speed: 600,
                    autoplay: {
                        delay: 3000,
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                });
            });
        </script>

        <section id="contact" class="contact section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="element_widget" class="element-widget-cover">
                            <div class="element-widget-wrap">
                                <div class="element-widget ord" style="margin-bottom: 25px;">
                                    <h2 class="top-heading-title bg-light-green">
                                        {{ BanglaText('land_instruction') }}
                                    </h2>
                                </div>
                                <div class="form-wrapper">
                                    <form action="{{ route('front.storelandData') }}" method="POST"
                                        id="checkout_land_form">
                                        <div class="row">
                                            <div class="address_section col-md-6" style="width: 50%;float: left;">
                                                <div class="form-address">
                                                    <div class="address-col">
                                                        <h3
                                                            style="font-family: 'Hind Siliguri', sans-serif !important;">
                                                            Billing Address</h3>
                                                        <div class="billing-fields">

                                                            <div class="form-group">
                                                                <label for="">
                                                                    {{ BanglaText('name') }}
                                                                    <span>*</span></label>
                                                                <input type="text" name="shipping_name"
                                                                    class="form-control" required>
                                                                @if (isset($ln_pg->product))
                                                                    <input type="hidden"
                                                                        value="{{ $ln_pg->product->id }}"
                                                                        name="product_id" class="form-control">
                                                                @endif
                                                            </div>

                                                            <div class="form-group mt-3">
                                                                <label for="">
                                                                    {{ BanglaText('mobile') }}
                                                                    <span>*</span></label>
                                                                <input type="text" name="shipping_phone"
                                                                    class="form-control" required>
                                                            </div>

                                                            <div class="form-group mt-3">
                                                                <label for="exampleInputPassword1"
                                                                    style="float: left;">
                                                                    {{ BanglaText('delivery_zone') }}
                                                                </label>
                                                                <select required name="shipping_method"
                                                                    style="min-height: 30px !important;"
                                                                    onchange="getCharge()" id="delivery_charge_id"
                                                                    class="form-control"
                                                                    style="font-size:12px !important;">
                                                                    @if (isset($ln_pg->product))
                                                                        @if ($ln_pg->product->is_free_shipping == '')
                                                                            @foreach ($shippings as $key => $charge)
                                                                                @if ($charge->shipping_rule != 'Free')
                                                                                    <option
                                                                                        value="{{ $charge->id }}"
                                                                                        id="charge"
                                                                                        data-charge="{{ $charge->shipping_fee }}">
                                                                                        {{ $charge->shipping_rule }} -
                                                                                        {{ $charge->shipping_fee }}
                                                                                    </option>
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            @php($free_shipping = App\Models\Shipping::where('shipping_rule', 'Free')->first());
                                                                            <option value="{{ $free_shipping->id }}"
                                                                                selected id="charge"
                                                                                data-charge="{{ $free_shipping->shipping_fee }}">
                                                                                {{ $free_shipping->shipping_rule }} -
                                                                                {{ $free_shipping->shipping_fee }}
                                                                            </option>
                                                                        @endif
                                                                    @endif
                                                                </select>
                                                            </div>

                                                            @if (isset($ln_pg->product))
                                                                <input type="hidden" id="variation_id"
                                                                    name="variation_id"
                                                                    value="{{ $ln_pg->product->id }}">
                                                            @endif
                                                            <input type="hidden" id="total_price_val"
                                                                name="total_amount" value="">
                                                            <input type="hidden" id="shipping_cost"
                                                                name="shipping_cost">
                                                            @if (isset($ln_pg->product))
                                                                <input type="hidden" id="product_type"
                                                                    value="{{ $ln_pg->product->type }}">
                                                            @endif
                                                            @if (isset($ln_pg->product))
                                                                @if ($ln_pg->product->type != 'variable')
                                                                    @if ($ln_pg->product->offer_price != 0)
                                                                        <!--<input type="text" id="price_val" value="0">-->
                                                                        <input type="hidden" id="product_price"
                                                                            name="price"
                                                                            value="{{ $ln_pg->product->offer_price }}">
                                                                    @else
                                                                        <!--<input type="text" id="price_val" value="0">-->
                                                                        <input type="hidden" id="product_price"
                                                                            name="price"
                                                                            value="{{ $ln_pg->product->price }}">
                                                                    @endif
                                                                @else
                                                                    <input type="hidden" id="price_val"
                                                                        name="price">
                                                                    <input type="hidden" id="size"
                                                                        name="variation_size">
                                                                    <input type="hidden" id="color"
                                                                        name="variation_color">
                                                                @endif
                                                            @endif
                                                            <input type="hidden" id="product_quantity"
                                                                name="product_qty">
                                                            @if (isset($ln_pg->product))
                                                                <input type="hidden" id="product_name"
                                                                    value="{{ $ln_pg->product->name }}"
                                                                    name="product_name">
                                                            @endif
                                                            <div class="form-group mt-3">
                                                                <label for="">
                                                                    {{ BanglaText('address') }}
                                                                    <span>*</span></label>
                                                                <input type="text" name="shipping_address"
                                                                    class="form-control" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <style>
                                                .sizes {
                                                    display: flex;
                                                }

                                                .sizes .size {
                                                    padding: 3px;
                                                    margin: 5px;
                                                    border: 1px solid #c2050b;
                                                    width: auto;
                                                    text-align: center;
                                                    cursor: pointer;
                                                }

                                                .sizes .size.active {
                                                    background: #c2050b;
                                                    color: white;
                                                }

                                                .colors {
                                                    /*display: flex;*/
                                                }

                                                .colors .color {
                                                    padding: 5px;
                                                    margin: 5px;
                                                    border: 1px solid #FE9017;
                                                    width: auto;
                                                    text-align: center;
                                                    cursor: pointer;
                                                    display: inline-block;
                                                    height: 35px;
                                                    width: 35px;
                                                }

                                                .colors .color.active {
                                                    background: #0d6efd;
                                                    color: white;
                                                    font-weight: bold;
                                                    padding: 6px;
                                                    border: 4px solid white;
                                                    outline: 2px solid red;
                                                }

                                                .increase-qty {
                                                    width: 32px;
                                                    display: block;
                                                    float: left;
                                                    line-height: 26px;
                                                    cursor: pointer;
                                                    text-align: center;
                                                    font-size: 16px;
                                                    font-weight: 300;
                                                    color: #000;
                                                    height: 32px;
                                                    background: #f6f7fb;
                                                    border-radius: 50%;
                                                    transition: .3s;
                                                    border: 2px solid rgba(0, 0, 0, 0);
                                                    background: #ffffff;
                                                    border: 1px solid #ddd;
                                                    border-radius: 10%;
                                                }

                                                .decrease-qty {
                                                    width: 32px;
                                                    display: block;
                                                    float: left;
                                                    line-height: 26px;
                                                    cursor: pointer;
                                                    text-align: center;
                                                    font-size: 16px;
                                                    font-weight: 300;
                                                    color: #000;
                                                    height: 32px;
                                                    background: #f6f7fb;
                                                    border-radius: 50%;
                                                    transition: .3s;
                                                    border: 2px solid rgba(0, 0, 0, 0);
                                                    background: #ffffff;
                                                    border: 1px solid #ddd;
                                                    border-radius: 10%;
                                                }

                                                .product-name {
                                                    font-family: 'Hind Siliguri', sans-serif !important;
                                                }

                                                .product-total {
                                                    font-family: 'Hind Siliguri', sans-serif !important;
                                                }
                                            </style>
                                            <div class="col-md-6">
                                                <div class="order-col" style="width: 100%;">
                                                    <h3 style="font-family: 'Hind Siliguri', sans-serif !important;">
                                                        Your Order
                                                    </h3>
                                                    <div id="order_review" class="review-order">
                                                        <table class="shop_table review-order-table table table-borderd">
                                                            <thead>
                                                                <tr style="">
                                                                    <th class="product-name">Product</th>
                                                                    <th class="product-total">Subtotal</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr class="cart_item">
                                                                    <td class="product-name">
                                                                        <div class="product-image">
                                                                            <div class="product-thumbnail">
                                                                                @if (isset($ln_pg->product))
                                                                                    <img width="100%"
                                                                                        src="{{ asset($ln_pg->product->thumb_image) }}"
                                                                                        class="" alt="">
                                                                                @endif
                                                                            </div>
                                                                            @if (isset($ln_pg->product))
                                                                                <div class="product-name-td">
                                                                                    {{ $ln_pg->product->name }}</div>
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                    <td class="product-total">
                                                                        <span id="price"
                                                                            class="price-amount amount">
                                                                            @if (isset($ln_pg->product))
                                                                                @if ($ln_pg->product->offer_price != 0)
                                                                                    {{ $ln_pg->product->offer_price }}
                                                                                @else
                                                                                    {{ $ln_pg->product->price }}
                                                                                @endif
                                                                                <span
                                                                                    class="price-currencySymbol">&nbsp;</span>
                                                                        </span>
                                                                        @if ($ln_pg->product->offer_price != 0)
                                                                            <!--<input type="hidden" id="price_val" value="{{ $ln_pg->product->offer_price }}">-->
                                                                        @else
                                                                            <!--<input type="hidden" id="price_val" value="{{ $ln_pg->product->sell_price }}">-->
                                                                        @endif
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                </tr>

                                                                <tr style="display: none">
                                                                    <td>
                                                                        <span>Select Size: </span>
                                                                    </td>
                                                                    <td style="width: 45%;">
                                                                        <div class="sizes" id="sizes">
                                                                            @if (!empty($ln_pg->product))
                                                                                @foreach ($ln_pg->product->variations as $v)
                                                                                    @if ($v->size->id == 3)
                                                                                    @else
                                                                                        <div class="size"
                                                                                            data-value="{{ $v->price }}"
                                                                                            data-size="{{ $v->size->title }}"
                                                                                            data-color="{{ isset($v->color->name) ? $v->color->name : '' }}"
                                                                                            data-dis-value="{{ $v->after_discount_price }}"
                                                                                            value="{{ $v->id }}">
                                                                                            {{ $v->size->title == 'free' ? '' : $v->size->title }}
                                                                                        </div>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr style="display: none">
                                                                    <td>Select Color: </td>
                                                                    <td>
                                                                        <div class="colors" id="colors">
                                                                            @if (isset($ln_pg->product))
                                                                                @foreach ($ln_pg->product->colorVariations as $v)
                                                                                    @if (!empty($v->color->code))
                                                                                        <div class="color"
                                                                                            style="background: {{ $v->color->code }}"
                                                                                            data-proid="{{ $v->product_id }}"
                                                                                            data-colorid="{{ $v->color_id }}"
                                                                                            data-varcolor="{{ $v->color->name }}"
                                                                                            value="{{ $v->id }}"
                                                                                            data-variationColorId="{{ $v->color_id }}">

                                                                                            <!--<img src="{{ asset($v->var_images) }}" width="50px" height="50px" /> -->


                                                                                        </div>
                                                                                    @else
                                                                                        Color Not Available
                                                                                    @endif
                                                                                @endforeach
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                        <span
                                                                            style="font-family: 'Hind Siliguri', sans-serif !important;">Select
                                                                            Quantity: </span>
                                                                    </td>
                                                                    <td style="width: 45%;">
                                                                        <div style="display: flex;"
                                                                            class="pro-qty item-quantity">
                                                                            <span
                                                                                class="decrease-qty quantity-button">-</span>
                                                                            <input type="text"
                                                                                style="width: 25%;text-align: center;"
                                                                                class="inner_qty qty-input quantity-input"
                                                                                value="1" name="product_qty" />
                                                                            <span
                                                                                class="increase-qty quantity-button">+</span>
                                                                        </div>
                                                                        <!--    <div class="sizes" id="sizes">-->
                                                                        <!--    <div class="pro-qty item-quantity">-->
                                                                        <!--    <span class="dec qtybtn">-</span>-->
                                                                        <!--    <input type="number" class="quantity-input" value="1" name="quantity">-->
                                                                        <!--    <span class="inc qtybtn">+</span>-->
                                                                        <!--</div>-->
                                                                        <!--</div>-->
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr class="cart-subtotal">
                                                                    <th
                                                                        style="font-family: 'Hind Siliguri', sans-serif !important;">
                                                                        Subtotal</th>
                                                                    <td><span class="final-price-amount amount">
                                                                            @if (isset($ln_pg->product))
                                                                                @if ($ln_pg->product->offer_price != 0)
                                                                                    {{ $ln_pg->product->offer_price }}
                                                                                @else
                                                                                    {{ $ln_pg->product->price }}
                                                                                @endif
                                                                            @endif
                                                                            <span
                                                                                class="price-currencySymbol">&nbsp;</span>
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                                <tr class="shipping-totals shipping">
                                                                    <th
                                                                        style="font-family: 'Hind Siliguri', sans-serif !important;">
                                                                        Shipping</th>
                                                                    <td>
                                                                        <li style="list-style: none;">
                                                                            <span id="delvry_charge">0</span>
                                                                        </li>
                                                                    </td>
                                                                </tr>
                                                                <tr class="order-total">
                                                                    <th
                                                                        style="font-family: 'Hind Siliguri', sans-serif !important;">
                                                                        Total</th>
                                                                    <td><strong><span id="total"
                                                                                class="Price-amount amount">
                                                                                @if (isset($ln_pg->product))
                                                                                    @if ($ln_pg->product->offer_price != 0)
                                                                                        {{ $ln_pg->product->offer_price }}
                                                                                    @else
                                                                                        {{ $ln_pg->product->price }}
                                                                                    @endif
                                                                                @endif
                                                                                <span
                                                                                    class="Price-currencySymbol">&nbsp;</span>
                                                                            </span></strong>
                                                                    </td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                        <div id="payment" class="checkout-payment">
                                                            <input type="radio" data-order_button_text=""
                                                                class="input-radio" id="payment_method_cod"
                                                                name="payment_method" value="cod" checked>

                                                            <label for="payment_method_cod"
                                                                style="font-family: 'Hind Siliguri', sans-serif !important;">
                                                                Cash on delivery </label>

                                                            <p
                                                                style="color: green;font-family: 'Hind Siliguri', sans-serif !important;">
                                                                {{ BanglaText('order_ensure') }}
                                                            </p>
                                                            <div class="form-row place-order">
                                                                <button type="submit" class="btn btn-primary" name="" id="">
                                                                    {{ BanglaText('order') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer id="footer" class="footer">

        <div class="footer-newsletter">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-6">
                        <h4>Get Latest Updates</h4>
                        <form action="forms/newsletter.php" method="post" class="php-email-form">
                            <div class="newsletter-form"><input placeholder="example@example.com" type="email"
                                    name="phone" required>
                                <input type="submit" value="Submit">
                            </div>
                            {{-- <div class="loading">Loading</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Thank you !</div> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="container copyright text-center">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">Bookish</strong> <span>All Rights Reserved</span>
            </p>
            <div class="credits">
                Developed by <a href="https://rndglobalnest.com/">RND GLOBAL NEST</a>
            </div>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    {{-- <div id="preloader"></div> --}}

    <!-- Vendor JS Files -->
    <script src="{{ asset('landing') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('landing') }}/vendor/php-email-form/validate.js"></script>
    <script src="{{ asset('landing') }}/vendor/aos/aos.js"></script>
    <script src="{{ asset('landing') }}/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="{{ asset('landing') }}/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('landing') }}/vendor/waypoints/noframework.waypoints.js"></script>
    <script src="{{ asset('landing') }}/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="{{ asset('landing') }}/vendor/isotope-layout/isotope.pkgd.min.js"></script>

    <!-- Main JS File -->
    <script src="{{ asset('landing') }}/js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>


    <script>
        $(document).ready(function() {
            getCharge();

            $(".img-gallery").owlCarousel({
                loop: true,
                autoplay: true,
                dots: false,
                margin: 10,
                nav: false,
                responsive: {
                    0: {
                        items: 1,
                    },
                    700: {
                        items: 3,
                    },
                    1200: {
                        items: 3,
                    },
                },
            });

            $(".img-gallery2").owlCarousel({
                loop: true,
                autoplay: true,
                dots: false,
                margin: 10,
                nav: false,
                responsive: {
                    0: {
                        items: 1,
                    },
                    700: {
                        items: 1,
                    },
                    1200: {
                        items: 1,
                    },
                },
            });
        });

        function getCharge() {

            let delivery_charge = $('#delivery_charge_id').find("option:selected");
            var crg_id = delivery_charge.val();
            var testval = delivery_charge.data('charge');

            $('span#delvry_charge').text(testval);
            //   $('span#charge').text(Number(testval).toFixed(2));
            $('#shipping_cost').val(Number(testval).toFixed(2));
            var price = $('span.final-price-amount').text();
            let total = Number(testval) + Number(price);
            $('#total').text(total);
            $('#total_price_val').val(total);
        }

        $("button#order_btn").click(function() {
            $('html,body').animate({
                    scrollTop: $("#element_widget").offset().top
                },
                'slow');
        });

        $("a#order_btn").click(function() {
            $('html,body').animate({
                    scrollTop: $("#element_widget").offset().top
                },
                'slow');
        });


        $(document).on('submit', 'form#checkout_land_form', function(e) {

            e.preventDefault();
            $('span.textdanger').text('');

            let ele = $('form#checkout_land_form');

            var url = ele.attr('action');
            var method = ele.attr('method');
            var formData = ele.serialize();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: method,
                url: url,
                data: formData,
                success: function(res) {
                    if (res.success == true) {
                        toastr.success(res.msg);
                        if (res.url) {
                            document.location.href = res.url;
                        } else {
                            window.location.reload();
                        }

                    } else if (res.success == false) {
                        toastr.error(res.msg);
                    }

                },
                error: function(response) {
                    $.each(response.responseJSON.errors, function(field_name, error) {
                        $(document).find('[name=' + field_name + ']').after(
                            '<span class="textdanger" style="color:red">' + error +
                            '</span>');
                    })
                }
            });
        });

        AOS.init({
            duration: 1200,
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            var firstSizeElement = $('#sizes .size:first');
            var firstColorElement = $('#colors .color:first');
            firstSizeElement.click();
            // firstColorElement.click();
        });

        $('#colors .color').on('click', function() {
            $('#colors .color').removeClass('active');
            $(this).addClass('active');
            let color = $(this).data('varcolor');
            $('input#color').val(color);
        });

        $('#sizes .size').on('click', function() {

            $('#sizes .size').removeClass('active');
            $(this).addClass('active');
            let size = $(this).data('size');
            let color = $(this).data('color');
            let value = $(this).attr('value');
            let delivery_charge = $('#delivery_charge_id').find("option:selected");
            var testval = delivery_charge.data('charge');
            let varcolor = $('input#color').val();

            $.ajax({
                type: 'get',
                url: '{{ route('front.product.get-variation_price') }}',
                data: {
                    value
                },
                success: function(res) {
                    $('span#price').text(res.price);
                    $('span.final-price-amount').text(res.price);
                    $('input#price_val').val(res.price);
                    var total_price = Number(res.price) + Number(testval);
                    $('span#total').text(total_price);
                    $('#total_price_val').val(total_price);
                    $('input#color').val(varcolor);
                }
            });

            $('input#size').val(size);
            $('input#color').val(color);
            let product_price = $(this).data('price');
            $('.price-amount').text(product_price);
            $('#price_val').val(product_price);


            //   var price = $('span.final-price-amount').text();

            //   var total_price = Number(variation_price) + Number(testval);
            var total_price = Number(price) + Number(testval);

            //   $('span#total').text(total_price);
            $('#total_price_val').val(total_price);
            //   $('#product_price').val(variation_price);

            //   $('span.final-price-amount').text(variation_price);
            //   $('#price_val').val(variation_price);
            $("#variation_id").val(value);
        });

        $('.increase-qty').on('click', function() {
            var sub_total_price = 0;
            var product_type = $('input#product_type').val();

            if (product_type == 'variable') {
                var product_price = $('input#price_val').val();
            } else {
                var product_price = $('#product_price').val();
            }

            var qtyInput = $(this).siblings('.inner_qty');
            var newQuantity = parseInt(qtyInput.val()) + 1;

            $('input#product_quantity').val(newQuantity);
            $('#product_name').val();
            var delivery_charge = $('span#delvry_charge').text();

            var sub_total_price = Number(product_price) * Number(newQuantity);

            var total_with_delivery = Number(sub_total_price) + Number(delivery_charge);

            // $('span#price').text(sub_total_price);
            $('span.final-price-amount').text(sub_total_price);
            $('span#total').text(total_with_delivery);
            $('#total_price_val').val(total_with_delivery);
            qtyInput.val(newQuantity);
        });

        $('.decrease-qty').on('click', function() {
            var qtyInput = $(this).siblings('.inner_qty');
            var product_type = $('input#product_type').val();
            $qnty = parseInt(qtyInput.val());
            var newQuantity = parseInt(qtyInput.val()) - 1;
            if (newQuantity > 0) {
                qtyInput.val(newQuantity);
                $('#product_quantity').val(newQuantity);
            }

            if (product_type == 'variable') {
                var product_price = $('input#price_val').val();
            } else {
                var product_price = $('#product_price').val();

            }

            //   var product_price = $('input#price_val').val();



            var delivery_charge = $('span#delvry_charge').text();
            if (newQuantity != '0') {
                var sub_total_price = Number(product_price) * Number(newQuantity);
                var total_with_delivery = Number(sub_total_price) + Number(delivery_charge);
                $('#total_price_val').val(total_with_delivery);
                $('span#total').text(total_with_delivery);
                $('span.final-price-amount').text(sub_total_price);
            }

        });
    </script>

</body>

</html>
