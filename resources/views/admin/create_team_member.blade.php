@extends('admin.master_layout')
@section('title')
    <title>{{ __('Team Members') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Team Members') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a></div>
                    <div class="breadcrumb-item">{{ __('Team Members') }}</div>
                </div>
            </div>

            <div class="section-body">
                <a href="{{ route('admin.team-member.index') }}" class="btn btn-primary"><i class="fas fa-backward"></i> {{ __('admin.Go Back') }}</a>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.team-member.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label>{{ __('Name') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                                        </div>

                                        <div class="form-group col-12">
                                            <label>{{ __('Role') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="role" class="form-control" value="{{ old('role') }}" required>
                                        </div>

                                        <div class="form-group col-12">
                                            <label>{{ __('Photo') }} <span class="text-danger">*</span></label>
                                            <input type="file" name="photo" class="form-control-file" required>
                                        </div>

                                        <div class="form-group col-12">
                                            <label>{{ __('Profile Link') }}</label>
                                            <input type="url" name="url" class="form-control" value="{{ old('url') }}">
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
