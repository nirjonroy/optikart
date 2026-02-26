@extends('admin.master_layout')
@section('title')
    <title>{{ __('admin.About Us') }}</title>
@endsection
@section('admin-content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Collection Banner</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a
                            href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a></div>
                    <div class="breadcrumb-item">Eid Collection Banner</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row mt-4">

                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.collection-banner.update', $item->id) }}" method="POST" enctype="multipart/form-data" >
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="header_title d-inline">Edit Collection Banner</h5>
                                            <a href="{{ route("admin.about-us.index") }}" class="btn btn-primary float-right">See All</a>

                                        </div>

                                        <div class="form-group col-12">
                                            <label for="">Brand/Category</label>
                                            <input  type="text" name="brand" class="form-control"
                                                value="{{ $item->brand }}">
                                        </div>

                                        <div class="form-group col-12">
                                            <label for="">Title</label>
                                            <input  type="text" name="title" class="form-control"
                                                value="{{ $item->title }}">
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="">Discount Text</label>
                                            <input  type="text" name="discount_text" class="form-control"
                                                value="{{ $item->discount_text }}">
                                        </div>
                                        <div class="form-group col-12">
                                            <label>Image</label>
                                            <input id="" type="file" name="image"
                                                onchange="document.getElementById('blah1').src = window.URL.createObjectURL(this.files[0])" class="form-control">
                                            <div class="my-3">
                                                <img src="{{ asset($item->image) }}"
                                                    style="border-radius: 5px" id="blah1" width="150" height="80"
                                                    alt="">
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="">Url</label>
                                            <input  type="text" name="url" class="form-control"
                                                value="{{ $item->url }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary float-right">Update</button>
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
