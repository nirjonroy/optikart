@php($activeTab = $activeTab ?? 'login')

<section id="banner" style="background-image:url('{{ asset('frontend/optikart/images/banner-img2.jpg') }}');">
    <div class="container padding-medium-2">
        <div class="hero-content text-center">
            <h2 class="display-1 text-uppercase text-white mt-5 mb-0">{{ __('Account') }}</h2>
            <nav class="breadcrumb d-flex justify-content-center">
                <a class="breadcrumb-item nav-link text-white-50" href="{{ route('front.home') }}">{{ __('Home') }}</a>
                <span class="breadcrumb-item active text-white" aria-current="page">
                    {{ $activeTab === 'register' ? __('Register') : __('Login') }}
                </span>
            </nav>
        </div>
    </div>
</section>

<section class="login-tabs">
    <div class="container-fluid px-3 px-md-5 padding-medium">
        <div class="row">
            <div class="tabs-listing">
                <nav>
                    <div class="nav nav-tabs d-flex justify-content-center border-dark-subtle mb-3" id="nav-tab" role="tablist">
                        <button class="nav-link account-tab mx-3 fs-4 border-bottom border-dark-subtle border-0 text-capitalize fw-semibold {{ $activeTab === 'login' ? 'active' : '' }}"
                                id="nav-sign-in-tab"
                                data-bs-toggle="tab" data-bs-target="#nav-sign-in"
                                type="button" role="tab" aria-controls="nav-sign-in"
                                aria-selected="{{ $activeTab === 'login' ? 'true' : 'false' }}">
                            {{ __('Log In') }}
                        </button>
                        <button class="nav-link account-tab mx-3 fs-4 border-bottom border-dark-subtle border-0 text-capitalize fw-semibold {{ $activeTab === 'register' ? 'active' : '' }}"
                                id="nav-register-tab"
                                data-bs-toggle="tab" data-bs-target="#nav-register"
                                type="button" role="tab" aria-controls="nav-register"
                                aria-selected="{{ $activeTab === 'register' ? 'true' : 'false' }}">
                            {{ __('Sign Up') }}
                        </button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade {{ $activeTab === 'login' ? 'show active' : '' }}" id="nav-sign-in" role="tabpanel" aria-labelledby="nav-sign-in-tab" tabindex="0">
                        <div class="col-lg-8 offset-lg-2 mt-5">
                            @if (session('status'))
                                <div class="alert alert-success">{{ session('status') }}</div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            <p class="mb-0">{{ __('Log-In With Email') }}</p>
                            <hr class="my-1">

                            <div id="login-feedback"></div>
                            <form id="account-login-form" class="form-group flex-wrap" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-input col-lg-12 my-4">
                                    <input type="email" name="email" value="{{ old('email') }}" required
                                           class="form-control mb-3 p-4"
                                           placeholder="{{ __('Enter email address') }}">
                                    @error('email')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror

                                    <input type="password" name="password" required
                                           class="form-control mb-3 p-4"
                                           placeholder="{{ __('Enter password') }}">
                                    @error('password')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror

                                    <label class="py-3 d-flex flex-wrap justify-content-between">
                                        <div>
                                            <input type="checkbox" name="remember" class="d-inline">
                                            <span class="label-body">{{ __('Remember Me') }}</span>
                                        </div>
                                        <div class="form-text">
                                            <a href="#" class="text-primary fw-bold">{{ __('Forgot Password?') }}</a>
                                        </div>
                                    </label>

                                    <div class="d-grid my-3">
                                        <button type="submit" class="btn btn-dark btn-lg rounded-1">
                                            <span class="login-btn-text">{{ __('Log In') }}</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade {{ $activeTab === 'register' ? 'show active' : '' }}" id="nav-register" role="tabpanel" aria-labelledby="nav-register-tab" tabindex="0">
                        <div class="col-lg-8 offset-lg-2 mt-5">
                            <form class="form-group flex-wrap" method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="form-input col-lg-12 my-4">
                                    <input type="text" name="name" value="{{ old('name') }}" required class="form-control mb-3 p-4"
                                           placeholder="{{ __('Full Name') }}">
                                    @error('name')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror

                                    <input type="email" name="email" value="{{ old('email') }}" required class="form-control mb-3 p-4"
                                           placeholder="{{ __('Email Address') }}">
                                    @error('email')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror

                                    <input type="text" name="phone" value="{{ old('phone') }}" required class="form-control mb-3 p-4"
                                           placeholder="{{ __('Phone Number') }}">
                                    @error('phone')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror

                                    <input type="password" name="password" required class="form-control mb-3 p-4"
                                           placeholder="{{ __('Password') }}">
                                    @error('password')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror

                                    <input type="password" name="password_confirmation" required class="form-control mb-3 p-4"
                                           placeholder="{{ __('Confirm Password') }}">
                                    @error('password_confirmation')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror

                                    <div class="d-grid my-3">
                                        <button type="submit" class="btn btn-dark btn-lg rounded-1">{{ __('Sign Up') }}</button>
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

<section id="register" style="background-image:url('{{ asset('frontend/optikart/images/background-img.jpg') }}');">
    <div class="container padding-medium">
        <div class="row banner-content align-items-center padding-medium">
            <div class="col-md-6">
                <h2 class="display-3 text-white mt-3">{{ __('Get') }} <span><em>20% {{ __('OFF') }}</em></span> {{ __('on your first purchase') }}</h2>
                <p class="text-white mb-4">{{ __('Sign up for our newsletter and never miss exclusive offers.') }}</p>
            </div>
            <div class="col-md-4 offset-md-1">
                <form id="newsletter-signup">
                    <div class="mb-3">
                        <input type="email" class="form-control form-control-lg rounded-3 text-center"
                               placeholder="{{ __('Enter Your Email Address') }}">
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-dark btn-lg rounded-3">{{ __('Register now') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@once
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loginForm = document.getElementById('account-login-form');
            const loginFeedback = document.getElementById('login-feedback');

            if (!loginForm) {
                return;
            }

            loginForm.addEventListener('submit', async function (event) {
                event.preventDefault();

                if (!loginForm.checkValidity()) {
                    loginForm.reportValidity();
                    return;
                }

                const submitBtn = loginForm.querySelector('button[type="submit"]');
                const btnTextNode = submitBtn.querySelector('.login-btn-text');
                const originalBtnText = btnTextNode ? btnTextNode.textContent : submitBtn.textContent;

                submitBtn.disabled = true;
                if (btnTextNode) {
                    btnTextNode.textContent = '{{ __('Please wait...') }}';
                } else {
                    submitBtn.textContent = '{{ __('Please wait...') }}';
                }

                loginFeedback.innerHTML = '';

                try {
                    const formData = new FormData(loginForm);
                    const response = await fetch(loginForm.action, {
                        method: 'POST',
                        body: formData,
                        credentials: 'same-origin'
                    });

                    const data = await response.json();

                    if (data.status === 'success' && data.url) {
                        loginFeedback.innerHTML = `<div class="alert alert-success">${data.message ?? '{{ __('Login successful! Redirecting...') }}'}</div>`;
                        window.location.href = data.url;
                        return;
                    }

                    const message = data.message ?? '{{ __('Invalid email or password. Please try again.') }}';
                    loginFeedback.innerHTML = `<div class="alert alert-danger">${message}</div>`;
                } catch (error) {
                    loginFeedback.innerHTML = `<div class="alert alert-danger">{{ __('Something went wrong. Please try again later.') }}</div>`;
                } finally {
                    submitBtn.disabled = false;
                    if (btnTextNode) {
                        btnTextNode.textContent = originalBtnText;
                    } else {
                        submitBtn.textContent = originalBtnText;
                    }
                }
            });
        });
    </script>
@endpush
@endonce
