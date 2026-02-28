@extends('admin.master_layout')
@section('title')
    <title>{{ __('Investors') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Investors') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a></div>
                    <div class="breadcrumb-item">{{ __('Investors') }}</div>
                </div>
            </div>

            <div class="section-body">
                <a href="{{ route('admin.investor.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{ __('admin.Add New') }}</a>
                <div class="row mt-4">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive table-invoice">
                                    <table class="table table-striped" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Logo') }}</th>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Link') }}</th>
                                                <th>{{ __('admin.Status') }}</th>
                                                <th>{{ __('admin.Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($investors as $investor)
                                                <tr>
                                                    <td>
                                                        <img src="{{ asset($investor->logo) }}" width="120" alt="">
                                                    </td>
                                                    <td>{{ $investor->name }}</td>
                                                    <td>{{ $investor->url ?? '-' }}</td>
                                                    <td>
                                                        @if ($investor->status == 1)
                                                            <a href="javascript:;" onclick="changeInvestorStatus({{ $investor->id }})">
                                                                <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="{{ __('admin.Active') }}" data-off="{{ __('admin.InActive') }}" data-onstyle="success" data-offstyle="danger">
                                                            </a>
                                                        @else
                                                            <a href="javascript:;" onclick="changeInvestorStatus({{ $investor->id }})">
                                                                <input id="status_toggle" type="checkbox" data-toggle="toggle" data-on="{{ __('admin.Active') }}" data-off="{{ __('admin.InActive') }}" data-onstyle="success" data-offstyle="danger">
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.investor.edit', $investor->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                                        <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm" onclick="deleteData({{ $investor->id }})"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>

    <script>
        function deleteData(id) {
            $("#deleteForm").attr("action", '{{ url("admin/investor/") }}' + "/" + id)
        }

        function changeInvestorStatus(id) {
            var isDemo = "{{ env('APP_MODE') }}"
            if (isDemo == 'DEMO') {
                toastr.error('This Is Demo Version. You Can Not Change Anything');
                return;
            }
            $.ajax({
                type: "put",
                data: { _token: '{{ csrf_token() }}' },
                url: "{{ url('/admin/investor-status/') }}" + "/" + id,
                success: function(response) {
                    toastr.success(response)
                },
                error: function(err) {
                    console.log(err);
                }
            })
        }
    </script>
@endsection
