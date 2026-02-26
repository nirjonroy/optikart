@extends('admin.master_layout')
@section('title')
    <title>{{ __('admin.Appointments') }}</title>
@endsection

@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('admin.Appointments') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('admin.Appointments') }}</div>
                </div>
            </div>

            <div class="row">
                @foreach ($statusOptions as $key => $label)
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <p class="text-uppercase small text-muted mb-1">{{ $label }}</p>
                                <h3 class="mb-0">
                                    {{ $statusCounters[$key] ?? 0 }}
                                </h3>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <form action="{{ route('admin.appointments.index') }}" method="GET" class="row g-3 w-100">
                            <div class="col-md-3">
                                <select name="status" class="form-control">
                                    <option value="">{{ __('admin.Status') }}</option>
                                    @foreach ($statusOptions as $key => $label)
                                        <option value="{{ $key }}" @selected(request('status') === $key)>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" type="submit">{{ __('admin.Filter') }}</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-invoice">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin.SN') }}</th>
                                        <th>{{ __('admin.Booking Code') }}</th>
                                        <th>{{ __('admin.Client') }}</th>
                                        <th>{{ __('admin.Service Type') }}</th>
                                        <th>{{ __('admin.Visit Type') }}</th>
                                        <th>{{ __('admin.Appointment Time') }}</th>
                                        <th>{{ __('admin.Status') }}</th>
                                        <th>{{ __('admin.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($appointments as $index => $appointment)
                                        <tr>
                                            <td>{{ $appointments->firstItem() + $index }}</td>
                                            <td class="fw-semibold">{{ $appointment->booking_code }}</td>
                                            <td>
                                                <div>{{ $appointment->name }}</div>
                                                <small class="text-muted">{{ $appointment->email }}</small>
                                            </td>
                                            <td>{{ optional($appointment->service)->title ?? __('N/A') }}</td>
                                            <td>{{ \Illuminate\Support\Str::headline($appointment->visit_type) }}</td>
                                            <td>{{ optional($appointment->appointment_at)?->timezone(config('app.timezone'))->format('d M Y, h:i A') }}</td>
                                            <td>
                                                <span class="badge @class([
                                                    'bg-warning' => $appointment->status === \App\Models\Appointment::STATUS_PENDING,
                                                    'bg-info' => $appointment->status === \App\Models\Appointment::STATUS_CONFIRMED,
                                                    'bg-success' => $appointment->status === \App\Models\Appointment::STATUS_COMPLETED,
                                                    'bg-danger' => $appointment->status === \App\Models\Appointment::STATUS_CANCELLED,
                                                ])">
                                                    {{ $statusOptions[$appointment->status] ?? $appointment->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.appointments.show', $appointment) }}"
                                                    class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                                                <a href="javascript:;" data-toggle="modal" data-target="#deleteModal"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="deleteData({{ $appointment->id }})"><i
                                                        class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-5">
                                                {{ __('admin.No data found') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $appointments->links() }}
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
