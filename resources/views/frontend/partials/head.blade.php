@php 
    $settings = DB::table('settings')->first();
@endphp
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings->site_name }}</title>
    
    <link rel="icon" type="image/x-icon" href="{{$settings->favicon}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets005/icomoon/icomoon.css')}}">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets005/css/vendor.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets005/style.css')}}">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Marcellus&display=swap" rel="stylesheet">


    
    @stack('css')
    <!-- <link rel="stylesheet" href="{{asset('frontend/assets/css/product.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/media.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/categories.css')}}"> -->
    
    {!!\App\Models\GoogleAnalytic::value('analytic_id')!!}
    {!!\App\Models\FacebookPixel::value('app_id')!!}
    
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PHD2XLF3');</script>
<!-- End Google Tag Manager -->



    


    
</head>






