@extends('admin.master_layout')
@section('title')
    <title>{{ __('admin.About Us') }}</title>
@endsection
@section('admin-content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Add Collection Banner</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a
                            href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a></div>
                    <div class="breadcrumb-item">Add Collection Banner</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row mt-4">

                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.collection-banner.store') }}" method="POST" enctype="multipart/form-data" >
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="header_title d-inline">Add Collection Banner</h5>
                                            <a href="{{ route("admin.about-us.index") }}" class="btn btn-primary float-right">See All</a>
                                        </div>

                                        <div class="form-group col-12">
                                            <label for="">Brand/Category</label>
                                            <input  type="text" name="brand" class="form-control"
                                                value="">
                                        </div>

                                        <div class="form-group col-12">
                                            <label for="">Title</label>
                                            <input  type="text" name="title" class="form-control"
                                                value="">
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="">Discount Text</label>
                                            <input  type="text" name="discount_text" class="form-control"
                                                value="">
                                        </div>
                                        <div class="form-group col-12">
                                            <label>Image</label>
                                            <input id="" type="file" name="image"
                                                onchange="document.getElementById('blah1').src = window.URL.createObjectURL(this.files[0])" class="form-control">
                                            <div class="my-3">
                                                <img src="{{ asset('assets/images/layout-1/collection-banner/1.jpg') }}"
                                                    style="border-radius: 5px" id="blah1" width="150" height="80"
                                                    alt="">
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="">Url</label>
                                            <input  type="text" name="url" class="form-control"
                                                value="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary float-right">Add</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>

    {{-- <script>
        $(document).on('click', 'a.edit', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            let method = 'GET';
            $.ajax({
                url: url,
                method: method,
                data: {},
                success: function(res) {
                    if (res.success) {
                        $('div#homeBottom').html(res.html).modal('show');
                    }
                }
            });

        });

        $(document).on('submit', 'form#home_bottom_setting', function(e) {
            e.preventDefault();
            let method = $(this).attr('method');
            let url = $(this).attr('action');
            var formData = new FormData($(this)[0]);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: url,
                method: method,
                data: formData,
                async: false,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.success) {
                        toastr.success(res.msg);
                        window.location.reload();
                    }
                }
            });
        });
    </script> --}}
@endsection
