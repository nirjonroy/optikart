@extends('admin.master_layout')
@section('title')
    <title>{{ __('admin.Appointment Details') }}</title>
@endsection

@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('admin.Appointment Details') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.appointments.index') }}">{{ __('admin.Appointments') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ $appointment->booking_code }}</div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header">
                            <h4 class="h5 mb-0">{{ __('admin.Client information') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <tr>
                                        <th>{{ __('admin.Booking Code') }}</th>
                                        <td>{{ $appointment->booking_code }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('admin.Name') }}</th>
                                        <td>{{ $appointment->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('admin.Email') }}</th>
                                        <td>{{ $appointment->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('admin.Phone') }}</th>
                                        <td>{{ $appointment->phone ?? __('N/A') }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('admin.Service Type') }}</th>
                                        <td>{{ optional($appointment->service)->title ?? __('N/A') }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('admin.Visit Type') }}</th>
                                        <td>{{ \Illuminate\Support\Str::headline($appointment->visit_type) }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('admin.Appointment Time') }}</th>
                                        <td>{{ optional($appointment->appointment_at)?->timezone(config('app.timezone'))->format('d M Y, h:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('admin.Created At') }}</th>
                                        <td>{{ optional($appointment->created_at)?->timezone(config('app.timezone'))->format('d M Y, h:i A') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 mt-4">
                        <div class="card-header">
                            <h4 class="h5 mb-0">{{ __('admin.Notes') }}</h4>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">
                                {{ $appointment->notes ?? __('admin.No notes provided') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-header">
                            <h4 class="h5 mb-0">{{ __('admin.Update Status') }}</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.appointments.status', $appointment) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>{{ __('admin.Status') }}</label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        @foreach ($statusOptions as $key => $label)
                                            <option value="{{ $key }}" @selected($appointment->status === $key)>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="text-end">
                                    <button class="btn btn-primary" type="submit">{{ __('admin.Update') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 mt-4">
                        <div class="card-header">
                            <h4 class="h6 mb-0">{{ __('admin.Delete Appointment') }}</h4>
                        </div>
                        <div class="card-body">
                            <p class="text-muted small">
                                {{ __('admin.Once deleted, the slot becomes available again for customers.') }}
                            </p>
                            <a href="javascript:;" data-toggle="modal" data-target="#deleteModal"
                                class="btn btn-danger btn-block" onclick="deleteData({{ $appointment->id }})">
                                {{ __('admin.Delete') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        function deleteData(id) {
            $("#deleteForm").attr("action", '{{ url('admin/appointments') }}/' + id);
        }
    </script>
@endsection
