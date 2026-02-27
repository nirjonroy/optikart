@extends('admin.master_layout')
@section('title')
<title>{{ __('Gallery') }}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{ __('Gallery') }}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a></div>
              <div class="breadcrumb-item">{{ __('Gallery') }}</div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-primary"><i class="fas fa-backward"></i> {{ __('admin.Go Back') }}</a>
            <div class="row mt-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                <div class="form-group col-12">
                                    <label>{{ __('Image') }} <span class="text-danger">*</span></label>
                                    <input type="file" name="image" class="form-control-file" required>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('Caption') }}</label>
                                    <input type="text" name="caption" class="form-control" value="{{ old('caption') }}">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('admin.Status') }} <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option value="1">{{ __('admin.Active') }}</option>
                                        <option value="0">{{ __('admin.Inactive') }}</option>
                                    </select>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary">{{ __('admin.Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                  </div>
                </div>
          </div>
        </section>
      </div>
@endsection
