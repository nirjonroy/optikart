@extends('frontend.app')

@section('title', __('Blog'))

@php
    $resolveValue = function ($value, $fallback = '') {
        if (is_array($value)) {
            $locale = app()->getLocale();

            if (!empty($value[$locale])) {
                return $value[$locale];
            }

            $filtered = array_values(array_filter($value, fn ($item) => !empty($item)));

            return $filtered[0] ?? $fallback;
        }

        return $value ?? $fallback;
    };

    $resolveImage = function ($value) use ($resolveValue) {
        $path = $resolveValue($value);

        if (empty($path)) {
            return asset('frontend/assets005/images/blog1.jpg');
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        return asset($path);
    };

    $bannerImage = asset('frontend/assets005/images/banner-img2.jpg');
@endphp

@section('content')
    <section id="banner" class="py-6 py-md-8" style="background-image:url({{ $bannerImage }}); background-size:cover; background-position:center;">
        <div class="container padding-medium-2 text-center text-white">
            <h2 class="display-1 text-uppercase mt-4 mb-3">{{ __('Blog') }}</h2>
            <p class="lead mb-4">
                {{ __('Lens care tutorials, seasonal style edits, and technology deep-dives from our optical experts.') }}
            </p>
            <nav class="breadcrumb d-flex justify-content-center">
                <a class="breadcrumb-item nav-link text-white" href="{{ route('front.home') }}">{{ __('Home') }}</a>
                <span class="breadcrumb-item active text-white-50" aria-current="page">{{ __('Blog') }}</span>
            </nav>
        </div>
    </section>

    <section class="padding-medium">
        <div class="container-fluid px-3 px-md-5">
            @if (!empty($activeCategory))
                <div class="row mb-4">
                    <div class="col">
                        <div class="alert alert-primary d-flex align-items-center justify-content-between shadow-sm border-0">
                            <div>
                                {{ __('Showing posts in') }}
                                <strong>{{ $resolveValue($activeCategory->name, $activeCategory->slug) }}</strong>
                            </div>
                            <a href="{{ route('front.blog.index') }}" class="text-decoration-none fw-semibold">
                                {{ __('Clear filter') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row g-5">
                <div class="col-lg-8">
                    <div class="row g-4">
                        @forelse ($blogs as $blog)
                            @php
                                $blogTitle = $resolveValue($blog->title, __('Untitled'));
                                $blogImage = $resolveImage($blog->image);
                                $blogExcerpt = $resolveValue($blog->seo_description, __('Explore the latest from Opticart.'));
                            @endphp
                            <div class="col-md-6">
                                <article class="card border-0 shadow-sm h-100">
                                    <a href="{{ route('front.blog.show', $blog->slug) }}" class="ratio ratio-4x3 rounded-top d-block">
                                        <img src="{{ $blogImage }}" alt="{{ $blogTitle }}"
                                            class="w-100 h-100 object-fit-cover rounded-top">
                                    </a>
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center text-muted small mb-3 gap-3">
                                            <span class="text-uppercase">{{ $blog->created_at->format('M d, Y') }}</span>
                                            <span class="d-inline-flex align-items-center gap-1">
                                                <iconify-icon icon="ph:chat-dots-duotone"></iconify-icon>
                                                {{ $blog->comments->count() }}
                                            </span>
                                        </div>
                                        <h3 class="h5 fw-semibold">
                                            <a href="{{ route('front.blog.show', $blog->slug) }}"
                                                class="text-decoration-none text-dark">
                                                {{ $blogTitle }}
                                            </a>
                                        </h3>
                                        <p class="text-muted mb-4">{{ \Illuminate\Support\Str::limit($blogExcerpt, 120) }}</p>
                                        <a href="{{ route('front.blog.show', $blog->slug) }}" class="btn btn-link px-0">
                                            {{ __('Read story') }}
                                            <iconify-icon icon="solar:arrow-right-linear" class="ms-2"></iconify-icon>
                                        </a>
                                    </div>
                                </article>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info mb-0">
                                    {{ __('No blog posts available right now. Please check back soon!') }}
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
                <aside class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h4 class="h5 fw-semibold mb-3">{{ __('Recent stories') }}</h4>
                            <ul class="list-unstyled m-0">
                                @foreach ($recentBlogs as $recent)
                                    @php
                                        $recentTitle = $resolveValue($recent->title, __('Untitled'));
                                        $recentImage = $resolveImage($recent->image);
                                @endphp
                                <li class="d-flex gap-3 align-items-start mb-3">
                                    <a href="{{ route('front.blog.show', $recent->slug) }}"
                                        class="ratio ratio-1x1 rounded-3 overflow-hidden flex-shrink-0 d-block"
                                        style="width: 64px;">
                                        <img src="{{ $recentImage }}" class="w-100 h-100 object-fit-cover"
                                            alt="{{ $recentTitle }}">
                                    </a>
                                    <div>
                                        <a href="{{ route('front.blog.show', $recent->slug) }}"
                                                class="text-decoration-none text-dark fw-semibold d-block">
                                                {{ \Illuminate\Support\Str::limit($recentTitle, 42) }}
                                            </a>
                                            <small class="text-muted">{{ $recent->created_at->diffForHumans() }}</small>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    @if ($popularBlogs->count())
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h4 class="h5 fw-semibold mb-3">{{ __('Popular reads') }}</h4>
                                <div class="d-flex flex-column gap-4">
                                    @foreach ($popularBlogs as $popular)
                                        @php
                                            $blogItem = $popular->blog;
                                        @endphp
                                        @if ($blogItem)
                                            <div class="d-flex gap-3">
                                                <div class="badge bg-primary-subtle text-primary rounded-4 px-3 py-2">
                                                    {{ $blogItem->created_at->format('d M') }}
                                                </div>
                                                <div>
                                                    <a href="{{ route('front.blog.show', $blogItem->slug) }}"
                                                        class="text-decoration-none text-dark fw-semibold d-block mb-1">
                                                        {{ \Illuminate\Support\Str::limit($resolveValue($blogItem->title, __('Untitled')), 48) }}
                                                    </a>
                                                    <small class="text-muted d-block">
                                                        <iconify-icon icon="ph:chat-circle-duotone" class="me-1"></iconify-icon>
                                                        {{ $blogItem->comments->count() }} {{ __('comments') }}
                                                    </small>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </aside>
            </div>
        </div>
    </section>
@endsection
