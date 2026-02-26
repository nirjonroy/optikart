@extends('frontend.app')

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

    $blogTitle = $resolveValue($blog->title, __('Blog'));
    $blogDescription = $resolveValue($blog->description, '');
    $blogImage = $resolveImage($blog->image);
    $categoryName = $resolveValue(optional($blog->category)->name, __('Blog'));
    $bannerImage = asset('frontend/assets005/images/banner-img2.jpg');
@endphp

@section('title', $blogTitle)

@section('content')
    <section id="banner" class="py-6 py-md-8" style="background-image:url({{ $bannerImage }}); background-size:cover; background-position:center;">
        <div class="container padding-medium-2 text-center text-white">
            <span class="badge bg-light text-dark text-uppercase px-4 py-2 mb-3">{{ $categoryName }}</span>
            <h1 class="display-1 text-uppercase mb-3">{{ __('Blog Details') }}</h1>
            <nav class="breadcrumb d-flex justify-content-center">
                <a class="breadcrumb-item nav-link text-white" href="{{ route('front.home') }}">{{ __('Home') }}</a>
                <a class="breadcrumb-item nav-link text-white" href="{{ route('front.blog.index') }}">{{ __('Blog') }}</a>
                <span class="breadcrumb-item active text-white-50" aria-current="page">{{ __('Blog Details') }}</span>
            </nav>
        </div>
    </section>

    <section class="padding-medium pb-0">
        <div class="container-fluid px-3 px-md-5">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="d-flex flex-wrap gap-3 text-muted small mb-4">
                        <span class="d-inline-flex align-items-center gap-2">
                            <iconify-icon icon="ph:calendar-duotone"></iconify-icon>
                            {{ $blog->created_at->format('M d, Y') }}
                        </span>
                        <span class="d-inline-flex align-items-center gap-2">
                            <iconify-icon icon="ph:user-circle-duotone"></iconify-icon>
                            Admin
                        </span>
                        <span class="d-inline-flex align-items-center gap-2">
                            <iconify-icon icon="ph:chat-circle-duotone"></iconify-icon>
                            {{ $blog->comments->count() }} Comments
                        </span>
                    </div>
                    <h2 class="h3 fw-semibold mb-4">{{ $blogTitle }}</h2>
                    <div class="ratio ratio-21x9 rounded-4 overflow-hidden shadow mb-5">
                        <img src="{{ $blogImage }}" alt="{{ $blogTitle }}" class="w-100 h-100 object-fit-cover">
                    </div>
                    <div class="content fs-5 text-muted">
                        {!! $blogDescription !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="padding-medium pt-0">
        <div class="container-fluid px-3 px-md-5">
            <div class="row justify-content-center g-5">
                <div class="col-lg-9">
                    <h3 class="h4 fw-semibold mb-4">{{ __('Comments') }}</h3>

                    @if ($blog->comments->count())
                        <div class="d-flex flex-column gap-4 mb-5">
                            @foreach ($blog->comments as $comment)
                                <div class="border rounded-4 p-4 shadow-sm">
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 48px; height: 48px;">
                                            <iconify-icon icon="ph:user-light" class="fs-4"></iconify-icon>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $comment->name }}</h6>
                                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    <p class="mb-0 text-muted">{!! nl2br(e($comment->comment)) !!}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">{{ __('Be the first to share your thoughts on this story.') }}</p>
                    @endif

                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4 p-lg-5">
                            <h4 class="h5 fw-semibold mb-3">{{ __('Leave a comment') }}</h4>
                            <p class="text-muted">{{ __('Your email address will not be published. Required fields are marked *') }}</p>

                            <form id="blogCommentForm" class="row g-3">
                                @csrf
                                <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                <div class="col-md-6">
                                    <label class="form-label text-uppercase small fw-semibold">{{ __('Name') }} *</label>
                                    <input type="text" name="name" class="form-control form-control-lg rounded-3"
                                        placeholder="{{ __('Your full name') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-uppercase small fw-semibold">{{ __('Email') }} *</label>
                                    <input type="email" name="email" class="form-control form-control-lg rounded-3"
                                        placeholder="{{ __('you@example.com') }}" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-uppercase small fw-semibold">{{ __('Comment') }} *</label>
                                    <textarea name="comment" rows="4" class="form-control form-control-lg rounded-3"
                                        placeholder="{{ __('Write your comment here') }}" required></textarea>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill">
                                        {{ __('Submit Comment') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const form = document.getElementById('blogCommentForm');
                if (!form) {
                    return;
                }

                form.addEventListener('submit', async (event) => {
                    event.preventDefault();
                    const submitButton = form.querySelector('button[type="submit"]');
                    submitButton.disabled = true;

                    const formData = new FormData(form);

                    try {
                        const response = await fetch("{{ route('front.blog.comment') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': formData.get('_token'),
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                            body: formData,
                        });

                        const data = await response.json();

                        if (response.ok && data.status === 'success') {
                            toastr.success(data.message);
                            form.reset();
                        } else {
                            toastr.error(data.message ?? "{{ __('Unable to submit comment at the moment.') }}");
                        }
                    } catch (error) {
                        toastr.error("{{ __('Something went wrong. Please try again later.') }}");
                    } finally {
                        submitButton.disabled = false;
                    }
                });
            });
        </script>
    @endpush
@endsection
