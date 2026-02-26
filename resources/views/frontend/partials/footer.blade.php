@php
    $settings = DB::table('settings')->first();
    $footer = DB::table('footers')->first();
    $custom_pages = DB::table('custom_pages')->where('status', 1)->get();
    $socialLinks = DB::table('footer_social_links')->get();

    $getPageUrl = function ($titles) use ($custom_pages) {
        $titles = (array) $titles;
        foreach ($titles as $title) {
            $match = $custom_pages->first(function ($page) use ($title) {
                return strcasecmp($page->page_name, $title) === 0 ||
                    $page->slug === \Illuminate\Support\Str::slug($title);
            });

            if ($match) {
                return route('front.customPages', $match->slug);
            }
        }

        return null;
    };

    $logoPath = $settings->footer_logo ?? $settings->logo ?? null;
    if ($logoPath && !\Illuminate\Support\Str::startsWith($logoPath, ['http://', 'https://'])) {
        $logoPath = asset($logoPath);
    } elseif (!$logoPath) {
        $logoPath = asset('frontend/assets005/images/logo-dark.png');
    }

    $quickLinks = [
        ['label' => __('Home'), 'url' => route('front.home')],
        ['label' => __('About us'), 'url' => $getPageUrl(['About us', 'About']) ?? '#'],
        ['label' => __('Offer'), 'url' => $getPageUrl(['Offer', 'Offers']) ?? '#'],
        ['label' => __('Services'), 'url' => $getPageUrl(['Services']) ?? '#'],
        ['label' => __('Contact Us'), 'url' => $getPageUrl(['Contact', 'Contact Us']) ?? '#'],
    ];

    $aboutLinks = [
        ['label' => __('How It Work'), 'url' => $getPageUrl(['How It Work']) ?? '#'],
        ['label' => __('Our Packages'), 'url' => $getPageUrl(['Our Packages']) ?? '#'],
        ['label' => __('Promotions'), 'url' => $getPageUrl(['Promotions']) ?? '#'],
        ['label' => __('Refer a friend'), 'url' => $getPageUrl(['Refer a friend']) ?? '#'],
    ];

    $servicesLinks = [
        ['label' => __('Payments'), 'url' => $getPageUrl(['Payments']) ?? '#'],
        ['label' => __('Shipping'), 'url' => $getPageUrl(['Shipping']) ?? '#'],
        ['label' => __('Product returns'), 'url' => $getPageUrl(['Product returns', 'Return Policy']) ?? '#'],
        ['label' => __('FAQs'), 'url' => $getPageUrl(['FAQs', 'FAQ']) ?? '#'],
        ['label' => __('Checkout'), 'url' => route('front.checkout.index')],
        ['label' => __('Other Issues'), 'url' => $getPageUrl(['Support', 'Help']) ?? '#'],
    ];

    $helpLinks = [
        ['label' => __('Payments'), 'url' => $getPageUrl(['Payments']) ?? '#'],
        ['label' => __('Shipping'), 'url' => $getPageUrl(['Shipping']) ?? '#'],
        ['label' => __('Product returns'), 'url' => $getPageUrl(['Product returns', 'Return Policy']) ?? '#'],
        ['label' => __('FAQs'), 'url' => $getPageUrl(['FAQs', 'FAQ']) ?? '#'],
        ['label' => __('Checkout'), 'url' => route('front.checkout.index')],
        ['label' => __('Other Issues'), 'url' => $getPageUrl(['Support', 'Help']) ?? '#'],
    ];
@endphp

<footer id="footer">
    <div class="container-fluid px-3 px-md-5  padding-medium">
        <div class="row mt-5">
            <div class="col-md-4">
                <div class="footer-menu">
                    <img src="{{ $logoPath }}" alt="{{ $settings->site_name ?? 'logo' }}" class="img-fluid footer-logo">
                    <p class="mt-4">{{ $footer->footer_description ?? __('Find Your Perfect Pair Today At Eyewear') }}</p>
                    <div class="social-links mt-4">
                        <ul class="d-flex list-unstyled gap-3">
                            @forelse ($socialLinks as $link)
                                <li class="social">
                                    <a href="{{ $link->link ?? '#' }}" target="_blank" rel="noopener">
                                        <i class="social-icon fs-4 me-4 fa-brands {{ $link->icon }}"></i>
                                    </a>
                                </li>
                            @empty
                                <li class="text-muted">{{ __('No social links configured.') }}</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="footer-menu">
                    <h6 class="text-uppercase fw-bold  mb-4">{{ __('Quick Links') }}</h6>
                    <ul class="menu-list list-unstyled">
                        @foreach ($quickLinks as $item)
                            <li class="menu-item">
                                <a href="{{ $item['url'] }}" class="footer-link">{{ $item['label'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-2">
                <div class="footer-menu">
                    <h6 class="text-uppercase fw-bold  mb-4">{{ __('About') }}</h6>
                    <ul class="menu-list list-unstyled">
                        @foreach ($aboutLinks as $item)
                            <li class="menu-item">
                                <a href="{{ $item['url'] }}" class="footer-link">{{ $item['label'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-2">
                <div class="footer-menu">
                    <h6 class="text-uppercase fw-bold  mb-4">{{ __('Services') }}</h6>
                    <ul class="menu-list list-unstyled">
                        @foreach ($servicesLinks as $item)
                            <li class="menu-item">
                                <a href="{{ $item['url'] }}" class="footer-link">{{ $item['label'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-2">
                <div class="footer-menu">
                    <h6 class="text-uppercase fw-bold  mb-4">{{ __('Help Center') }}</h6>
                    <ul class="menu-list list-unstyled">
                        @foreach ($helpLinks as $item)
                            <li class="menu-item">
                                <a href="{{ $item['url'] }}" class="footer-link">{{ $item['label'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
</footer>

<div id="footer-bottom">
    <hr class="m-0">
    <div class="container-fluid  px-3 px-md-5 py-2">
        <div class="row mt-3">
            <div class="col-md-6 copyright">
                <p class="secondary-font"><a href="https://nirjonroy.com/">{{ optional($footer)->copyright ?? __('© :year EYEWEAR. All rights reserved.', ['year' => now()->format('Y')]) }}</a></p>
            </div>
            <!-- <div class="col-md-6 text-md-end">
                <p class="secondary-font">Free HTML Template by <a href="https://templatesjungle.com/" target="_blank" class="text-decoration-underline fw-bold"> TemplatesJungle</a> </p>
            </div> -->
        </div>
    </div>
</div>
 <script src="{{asset('frontend/assets005/js/jquery-1.11.0.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="{{asset('frontend/assets005/js/plugins.js')}}"></script>
    <script src="{{asset('frontend/assets005/js/script.js')}}"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

@include('frontend.partials.js')

{!! \App\Models\SitePixel::value('pixel_id') !!}

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PHD2XLF3" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->


</body>
</html>
