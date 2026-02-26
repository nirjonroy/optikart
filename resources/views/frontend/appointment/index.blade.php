@extends('frontend.app')

@section('title', __('Appointment'))

@push('css')
    <style>
        .appointment-hero {
            position: relative;
            background: linear-gradient(180deg, #0A1A2F 0%, #4B2E7F 100%);
            color: #fff;
            padding-top: 11rem;
            padding-bottom: 6rem;
            display: flex;
            align-items: center;
        }

        .appointment-hero .hero-inner {
            position: relative;
            z-index: 1;
        }

        .appointment-card {
            border: 0;
            border-radius: 1.25rem;
            box-shadow: 0 25px 60px rgba(13, 15, 35, 0.08);
        }

        .slot-badge {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .appointment-list {
            max-height: 420px;
            overflow-y: auto;
        }
    </style>
@endpush

@section('content')
    <section class="appointment-hero py-6 py-md-8">
        <div class="container-fluid px-3 px-md-5">
            <div class="row align-items-center gy-4 hero-inner">
                <div class="col-lg-7">
                    @if (optional($page)->badge_text)
                        <span class="badge bg-light text-dark rounded-pill px-4 py-2 mb-3">
                            {{ $page->badge_text }}
                        </span>
                    @endif
                    <h1 class="display-4 fw-semibold mb-3">
                        {{ optional($page)->title ?? __('Book your eye appointment') }}
                    </h1>
                    <p class="fs-5 mb-0 text-white-50">
                        {{ optional($page)->description ?? __('Schedule in-store fittings or a home eye check with our licensed optometrists. We reserve every slot for a single guest so you get the undivided attention you deserve.') }}
                    </p>
                </div>
                <div class="col-lg-5 text-lg-end">
                    <div class="bg-white text-dark rounded-4 p-4 shadow-sm d-inline-block">
                        <p class="mb-1 text-uppercase text-muted small">{{ __('Need help right now?') }}</p>
                        <h5 class="mb-0 fw-semibold">
                            <a href="tel:{{ optional($page)->contact_phone }}" class="text-decoration-none text-dark">
                                {{ optional($page)->contact_phone ?? __('Call our care line') }}
                            </a>
                        </h5>
                        <span class="text-muted small">
                            {{ optional($page)->working_hours ?? __('Everyday 10:00 AM – 9:00 PM') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="padding-medium">
        <div class="container-fluid px-3 px-md-5">
            <div class="row g-4">
                <div class="col-lg-7">
                    @if (session('success'))
                        <div class="alert alert-success rounded-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="card appointment-card">
                        <div class="card-body p-4 p-md-5">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <p class="text-uppercase slot-badge text-muted mb-1">{{ __('Schedule visit') }}</p>
                                    <h3 class="h4 fw-semibold mb-0">{{ __('Personalise your appointment') }}</h3>
                                </div>
                                <iconify-icon icon="mdi:calendar-clock" class="fs-2 text-primary"></iconify-icon>
                            </div>

                            <form action="{{ route('front.appointment.store') }}" method="POST" class="row g-4">
                                @csrf
                                <div class="col-md-6">
                                    <label class="form-label text-uppercase small fw-semibold">{{ __('Full Name') }}</label>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        class="form-control form-control-lg rounded-3 @error('name') is-invalid @enderror"
                                        placeholder="{{ __('Enter your name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-uppercase small fw-semibold">{{ __('Email') }}</label>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="form-control form-control-lg rounded-3 @error('email') is-invalid @enderror"
                                        placeholder="{{ __('you@example.com') }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-uppercase small fw-semibold">{{ __('Phone') }}</label>
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                        class="form-control form-control-lg rounded-3 @error('phone') is-invalid @enderror"
                                        placeholder="{{ __('Optional') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-uppercase small fw-semibold">{{ __('Service Type') }}</label>
                                    <select name="service_id"
                                        class="form-select form-select-lg rounded-3 @error('service_id') is-invalid @enderror">
                                        <option value="">{{ __('Select a service') }}</option>
                                        @forelse ($services as $service)
                                            <option value="{{ $service->id }}" @selected(old('service_id') == $service->id)>
                                                {{ $service->title }}
                                            </option>
                                        @empty
                                            <option value="" disabled>{{ __('No services available right now') }}</option>
                                        @endforelse
                                    </select>
                                    @error('service_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label text-uppercase small fw-semibold d-block">{{ __('Visit Type') }}</label>
                                    <div class="d-flex flex-wrap gap-3">
                                        @foreach ($visitTypes as $key => $label)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="visit_type"
                                                    id="visit-{{ $key }}" value="{{ $key }}"
                                                    @checked(old('visit_type', array_key_first($visitTypes)) === $key)>
                                                <label class="form-check-label" for="visit-{{ $key }}">{{ $label }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('visit_type')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-uppercase small fw-semibold">{{ __('Preferred Slot') }}</label>
                                    <input type="datetime-local" name="appointment_at" id="appointment_at"
                                        min="{{ $minSlot }}" value="{{ old('appointment_at') }}"
                                        class="form-control form-control-lg rounded-3 @error('appointment_at') is-invalid @enderror">
                                    @error('appointment_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div id="slot-warning" class="text-danger small mt-2 d-none">
                                        {{ __('Someone already reserved this slot. Please choose another time.') }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-uppercase small fw-semibold">{{ __('Reason / Notes') }}</label>
                                    <textarea name="notes" rows="3"
                                        class="form-control form-control-lg rounded-3 @error('notes') is-invalid @enderror"
                                        placeholder="{{ __('Tell us why you need the appointment') }}">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill">
                                        {{ __('Book Appointment') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card appointment-card mb-4">
                        <div class="card-body p-4">
                            <h4 class="h5 fw-semibold mb-3">{{ optional($page)->info_title ?? __('Need a hand deciding?') }}</h4>
                            <p class="text-muted mb-4">
                                {{ optional($page)->info_description ?? __('Our stylists help you pick frames that match your lifestyle, prescription and budget. Home visits include portable diagnostic tools for power checks.') }}
                            </p>
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon bg-primary text-white rounded-circle p-3 me-3">
                                    <iconify-icon icon="ph:phone-call" class="fs-4"></iconify-icon>
                                </div>
                                <div>
                                    <p class="text-uppercase small text-muted mb-0">{{ __('Call us') }}</p>
                                    <a href="tel:{{ optional($page)->contact_phone }}" class="fw-semibold text-decoration-none">
                                        {{ optional($page)->contact_phone ?? __('N/A') }}
                                    </a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon bg-secondary text-white rounded-circle p-3 me-3">
                                    <iconify-icon icon="ph:envelope-simple-open" class="fs-4"></iconify-icon>
                                </div>
                                <div>
                                    <p class="text-uppercase small text-muted mb-0">{{ __('Email') }}</p>
                                    <a href="mailto:{{ optional($page)->contact_email }}" class="fw-semibold text-decoration-none">
                                        {{ optional($page)->contact_email ?? __('N/A') }}
                                    </a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="icon bg-dark text-white rounded-circle p-3 me-3">
                                    <iconify-icon icon="ph:map-pin" class="fs-4"></iconify-icon>
                                </div>
                                <div>
                                    <p class="text-uppercase small text-muted mb-0">{{ __('Visit us') }}</p>
                                    <p class="fw-semibold mb-0">
                                        {{ optional($page)->contact_address ?? __('Flagship showroom, Gulshan Avenue, Dhaka') }}
                                    </p>
                                </div>
                            </div>
                            @if (optional($page)->note)
                                <div class="alert alert-info rounded-4 mt-4 mb-0">
                                    {{ $page->note }}
                                </div>
                            @endif
                        </div>
                    </div>

                    @if (!empty($bookedSlots))
                        <div class="card appointment-card">
                            <div class="card-body p-4 appointment-list" data-slot-list>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="h6 fw-semibold mb-0">{{ __('Upcoming booked slots') }}</h4>
                                    <span class="badge bg-secondary-subtle text-dark">{{ count($bookedSlots) }}</span>
                                </div>
                                @foreach ($bookedSlots as $date => $slots)
                                    <div class="mb-3" data-slots="{{ $date }}">
                                        <p class="text-uppercase small text-muted mb-2">
                                            {{ \Carbon\Carbon::parse($date)->format('l, d M Y') }}
                                        </p>
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach ($slots as $slot)
                                                <span class="badge bg-light text-dark border">{{ $slot }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        (function() {
            const takenSlots = @json($bookedSlots);
            const slotInput = document.getElementById('appointment_at');
            const warning = document.getElementById('slot-warning');

            if (!slotInput || !warning) {
                return;
            }

            const toggleWarning = () => {
                warning.classList.add('d-none');
                const value = slotInput.value;
                if (!value) {
                    return;
                }

                const [date, time] = value.split('T');
                if (!date || !time) {
                    return;
                }

                const formatted = time.substring(0, 5);

                if (takenSlots[date] && takenSlots[date].includes(formatted)) {
                    warning.classList.remove('d-none');
                }
            };

            slotInput.addEventListener('change', toggleWarning);
            slotInput.addEventListener('keyup', toggleWarning);

            if (slotInput.value) {
                toggleWarning();
            }
        })();
    </script>
@endpush
