@extends('admin.master_layout')
@section('title')
    <title>{{ __('Banking Partners') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Banking Partners') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a></div>
                    <div class="breadcrumb-item">{{ __('Banking Partners') }}</div>
                </div>
            </div>

            <div class="section-body">
                <a href="{{ route('admin.banking-partner.index') }}" class="btn btn-primary"><i class="fas fa-backward"></i> {{ __('admin.Go Back') }}</a>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.banking-partner.update', $partner->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label>{{ __('Name') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control" value="{{ $partner->name }}" required>
                                        </div>

                                        <div class="form-group col-12">
                                            <label>{{ __('Logo') }}</label>
                                            <div class="mb-2">
                                                <img src="{{ asset($partner->logo) }}" width="140" alt="">
                                            </div>
                                            <input type="file" name="logo" class="form-control-file">
                                        </div>

                                        <div class="form-group col-12">
                                            <label>{{ __('Website Link') }}</label>
                                            <input type="url" name="url" class="form-control" value="{{ $partner->url }}">
                                        </div>

                                        <div class="form-group col-12">
                                            <label>{{ __('admin.Status') }} <span class="text-danger">*</span></label>
                                            <select name="status" class="form-control">
                                                <option value="1" @if ($partner->status == 1) selected @endif>{{ __('admin.Active') }}</option>
                                                <option value="0" @if ($partner->status == 0) selected @endif>{{ __('admin.Inactive') }}</option>
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
