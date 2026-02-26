@extends('frontend.app')

@section('title', __('Create Account'))

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/optikart/css/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/optikart/style.css') }}">
@endpush

@section('content')
    @include('frontend.cart.partials.auth-content', ['activeTab' => 'register'])
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const registerTab = document.querySelector('#nav-register-tab');
            if (registerTab) {
                const tabInstance = new bootstrap.Tab(registerTab);
                tabInstance.show();
            }
        });
    </script>
@endpush
