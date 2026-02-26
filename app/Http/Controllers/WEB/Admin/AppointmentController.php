<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $statusOptions = Appointment::statuses();

        $status = $request->input('status');

        $appointments = Appointment::with('service')
            ->when(
                $status,
                fn ($query) => $query->where('status', $status)
            )
            ->orderByDesc('appointment_at')
            ->paginate(20)
            ->withQueryString();

        $statusCounters = Appointment::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return view('admin.appointments.index', compact(
            'appointments',
            'statusOptions',
            'statusCounters'
        ));
    }

    public function show(Appointment $appointment)
    {
        $appointment->load('service');
        $statusOptions = Appointment::statuses();

        return view('admin.appointments.show', compact('appointment', 'statusOptions'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => ['required', Rule::in(array_keys(Appointment::statuses()))],
        ]);

        $appointment->update([
            'status' => $request->input('status'),
        ]);

        $notification = trans('admin_validation.Update Successfully');

        return back()->with(['messege' => $notification, 'alert-type' => 'success']);
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        $notification = trans('admin_validation.Delete Successfully');

        return redirect()
            ->route('admin.appointments.index')
            ->with(['messege' => $notification, 'alert-type' => 'success']);
    }
}
