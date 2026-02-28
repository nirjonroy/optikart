<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Investor;
use File;
use Illuminate\Http\Request;
use Image;

class InvestorController extends Controller
{
    public function index()
    {
        $investors = Investor::latest()->get();
        return view('admin.investor', compact('investors'));
    }

    public function create()
    {
        return view('admin.create_investor');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:png,jpg,jpeg',
            'url' => 'nullable|url',
            'status' => 'required',
        ];

        $customMessages = [
            'name.required' => trans('admin_validation.Title is required'),
            'logo.required' => trans('admin_validation.Image is required'),
            'status.required' => trans('admin_validation.Status is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        $investor = new Investor();

        if ($request->logo) {
            $extention = $request->logo->getClientOriginalExtension();
            $imageName = 'investor' . date('-Y-m-d-h-i-s-') . rand(999, 9999) . '.' . $extention;
            $imagePath = 'uploads/investors/' . $imageName;

            Image::make($request->logo)
                ->save(public_path() . '/' . $imagePath);

            $investor->logo = $imagePath;
        }

        $investor->name = $request->name;
        $investor->url = $request->url;
        $investor->status = $request->status;
        $investor->save();

        $notification = trans('admin_validation.Created Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.investor.index')->with($notification);
    }

    public function edit($id)
    {
        $investor = Investor::find($id);
        return view('admin.edit_investor', compact('investor'));
    }

    public function update(Request $request, $id)
    {
        $investor = Investor::find($id);

        $rules = [
            'name' => 'required|string|max:255',
            'url' => 'nullable|url',
            'status' => 'required',
        ];

        $customMessages = [
            'name.required' => trans('admin_validation.Title is required'),
            'status.required' => trans('admin_validation.Status is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        if ($request->logo) {
            $existingImage = $investor->logo;
            $extention = $request->logo->getClientOriginalExtension();
            $imageName = 'investor' . date('-Y-m-d-h-i-s-') . rand(999, 9999) . '.' . $extention;
            $imagePath = 'uploads/investors/' . $imageName;

            Image::make($request->logo)
                ->save(public_path() . '/' . $imagePath);

            $investor->logo = $imagePath;
            $investor->save();

            if ($existingImage && File::exists(public_path() . '/' . $existingImage)) {
                unlink(public_path() . '/' . $existingImage);
            }
        }

        $investor->name = $request->name;
        $investor->url = $request->url;
        $investor->status = $request->status;
        $investor->save();

        $notification = trans('admin_validation.Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.investor.index')->with($notification);
    }

    public function destroy($id)
    {
        $investor = Investor::find($id);
        $existingImage = $investor->logo;
        $investor->delete();

        if ($existingImage && File::exists(public_path() . '/' . $existingImage)) {
            unlink(public_path() . '/' . $existingImage);
        }

        $notification = trans('admin_validation.Delete Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.investor.index')->with($notification);
    }

    public function changeStatus($id)
    {
        $investor = Investor::find($id);
        if ($investor->status == 1) {
            $investor->status = 0;
            $investor->save();
            $message = trans('admin_validation.Inactive Successfully');
        } else {
            $investor->status = 1;
            $investor->save();
            $message = trans('admin_validation.Active Successfully');
        }

        return response()->json($message);
    }
}
