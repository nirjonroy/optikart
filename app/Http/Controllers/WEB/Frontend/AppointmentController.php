<?php

namespace App\Http\Controllers\WEB\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\AppointmentConfirmation;
use App\Models\Appointment;
use App\Models\AppointmentPage;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class AppointmentController extends Controller
{
    public function index()
    {
        $page = AppointmentPage::first();
        $services = Service::where('status', 1)
            ->orderBy('title')
            ->get(['id', 'title']);

        $bookedSlots = Appointment::select('appointment_at')
            ->whereBetween('appointment_at', [now()->startOfDay(), now()->copy()->addMonths(3)])
            ->orderBy('appointment_at')
            ->get()
            ->groupBy(fn ($appointment) => $appointment->appointment_at->toDateString())
            ->map(fn ($items) => $items->map(fn ($item) => $item->appointment_at->format('H:i')))
            ->toArray();

        $visitTypes = Appointment::visitTypes();

        return view('frontend.appointment.index', [
            'page' => $page,
            'services' => $services,
            'bookedSlots' => $bookedSlots,
            'visitTypes' => $visitTypes,
            'minSlot' => now()->addMinutes(30)->format('Y-m-d\TH:i'),
        ]);
    }

    public function store(Request $request)
    {
        $visitTypeKeys = array_keys(Appointment::visitTypes());

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'email', 'max:191'],
            'phone' => ['nullable', 'string', 'max:50'],
            'service_id' => [
                'required',
                Rule::exists('services', 'id')->where(fn ($query) => $query->where('status', 1)),
            ],
            'visit_type' => ['required', Rule::in($visitTypeKeys)],
            'appointment_at' => ['required', 'date_format:Y-m-d\TH:i'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $appointmentAt = Carbon::createFromFormat(
            'Y-m-d\TH:i',
            $validated['appointment_at'],
            config('app.timezone')
        )->setSeconds(0);

        if ($appointmentAt->lessThanOrEqualTo(now())) {
            return back()
                ->withErrors(['appointment_at' => __('Please choose a time in the future.')])
                ->withInput();
        }

        $slotExists = Appointment::where('appointment_at', $appointmentAt)->exists();

        if ($slotExists) {
            return back()
                ->withErrors(['appointment_at' => __('This time slot has already been booked. Please choose a different time.')])
                ->withInput();
        }

        $appointment = Appointment::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'service_id' => $validated['service_id'],
            'visit_type' => $validated['visit_type'],
            'appointment_at' => $appointmentAt,
            'notes' => $validated['notes'] ?? null,
        ]);

        $appointment->load('service');

        $mail = Mail::to($appointment->email);
        if (filled(config('mail.from.address'))) {
            $mail->bcc(config('mail.from.address'));
        }
        $mail->send(new AppointmentConfirmation($appointment));

        return redirect()
            ->route('front.appointment')
            ->with('success', __('Your appointment request has been received. Our opticians will confirm the schedule shortly.'));
    }
}
