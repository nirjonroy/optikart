@extends('admin.master_layout')
@section('title')
    <title>{{ __('admin.Appointment Page') }}</title>
@endsection

@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('admin.Appointment Page') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('admin.Appointment Page') }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('admin.Manage page content') }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.appointment-page.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>{{ __('admin.Hero Title') }}</label>
                                    <input type="text" name="title" value="{{ old('title', optional($page)->title) }}"
                                        class="form-control @error('title') is-invalid @enderror">
                                    @error('title')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>{{ __('admin.Hero Subtitle') }}</label>
                                    <input type="text" name="subtitle" value="{{ old('subtitle', optional($page)->subtitle) }}"
                                        class="form-control @error('subtitle') is-invalid @enderror">
                                    @error('subtitle')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>{{ __('admin.Short Description') }}</label>
                                    <textarea name="description" rows="3"
                                        class="form-control @error('description') is-invalid @enderror">{{ old('description', optional($page)->description) }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>{{ __('admin.Badge Text') }}</label>
                                    <input type="text" name="badge_text"
                                        value="{{ old('badge_text', optional($page)->badge_text) }}" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>{{ __('admin.Working Hours') }}</label>
                                    <input type="text" name="working_hours"
                                        value="{{ old('working_hours', optional($page)->working_hours) }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>{{ __('admin.Contact Phone') }}</label>
                                    <input type="text" name="contact_phone"
                                        value="{{ old('contact_phone', optional($page)->contact_phone) }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>{{ __('admin.Contact Email') }}</label>
                                    <input type="email" name="contact_email"
                                        value="{{ old('contact_email', optional($page)->contact_email) }}"
                                        class="form-control @error('contact_email') is-invalid @enderror">
                                    @error('contact_email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>{{ __('admin.Contact Address') }}</label>
                                    <input type="text" name="contact_address"
                                        value="{{ old('contact_address', optional($page)->contact_address) }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>{{ __('admin.Info Title') }}</label>
                                    <input type="text" name="info_title"
                                        value="{{ old('info_title', optional($page)->info_title) }}" class="form-control">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>{{ __('admin.Info Description') }}</label>
                                    <textarea name="info_description" rows="3"
                                        class="form-control">{{ old('info_description', optional($page)->info_description) }}</textarea>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>{{ __('admin.Quick Note') }}</label>
                                    <textarea name="note" rows="3"
                                        class="form-control">{{ old('note', optional($page)->note) }}</textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>{{ __('admin.Hero Image') }}</label>
                                    <input type="file" name="hero_image"
                                        class="form-control @error('hero_image') is-invalid @enderror">
                                    @error('hero_image')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    @if (optional($page)->hero_image)
                                        <img src="{{ asset($page->hero_image) }}" class="img-fluid rounded shadow-sm"
                                            alt="{{ __('admin.Hero Image') }}">
                                    @endif
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary px-4">{{ __('admin.Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
