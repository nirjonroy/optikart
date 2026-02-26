<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppointmentPage;
use File;
use Illuminate\Http\Request;
use Image;

class AppointmentPageController extends Controller
{
    public function index()
    {
        $page = AppointmentPage::first();

        return view('admin.appointments.page', compact('page'));
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:191',
            'subtitle' => 'nullable|string|max:191',
            'description' => 'nullable|string',
            'badge_text' => 'nullable|string|max:191',
            'info_title' => 'nullable|string|max:191',
            'info_description' => 'nullable|string',
            'contact_phone' => 'nullable|string|max:191',
            'contact_email' => 'nullable|email|max:191',
            'contact_address' => 'nullable|string|max:191',
            'working_hours' => 'nullable|string|max:191',
            'note' => 'nullable|string',
            'hero_image' => 'nullable|image|max:2048',
        ];

        $customMessages = [
            'title.required' => trans('admin_validation.Title is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        $page = AppointmentPage::first() ?? new AppointmentPage();

        if ($request->hasFile('hero_image')) {
            $existing = $page->hero_image;
            $image = $request->file('hero_image');
            $name = 'appointment-hero-' . now()->format('YmdHis') . '-' . rand(100, 999) . '.' . $image->getClientOriginalExtension();
            $path = 'uploads/custom-images/' . $name;

            Image::make($image)
                ->fit(1920, 900, function ($constraint) {
                    $constraint->upsize();
                })
                ->save(public_path($path));

            $page->hero_image = $path;

            if ($existing && File::exists(public_path($existing))) {
                File::delete(public_path($existing));
            }
        }

        $page->title = $request->title;
        $page->subtitle = $request->subtitle;
        $page->description = $request->description;
        $page->badge_text = $request->badge_text;
        $page->info_title = $request->info_title;
        $page->info_description = $request->info_description;
        $page->contact_phone = $request->contact_phone;
        $page->contact_email = $request->contact_email;
        $page->contact_address = $request->contact_address;
        $page->working_hours = $request->working_hours;
        $page->note = $request->note;
        $page->save();

        $notification = trans('admin_validation.Update Successfully');

        return back()->with(['messege' => $notification, 'alert-type' => 'success']);
    }
}
