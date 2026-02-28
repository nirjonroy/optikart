<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankingPartner;
use File;
use Illuminate\Http\Request;
use Image;

class BankingPartnerController extends Controller
{
    public function index()
    {
        $partners = BankingPartner::latest()->get();
        return view('admin.banking_partner', compact('partners'));
    }

    public function create()
    {
        return view('admin.create_banking_partner');
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

        $partner = new BankingPartner();

        if ($request->logo) {
            $extention = $request->logo->getClientOriginalExtension();
            $imageName = 'banking-partner' . date('-Y-m-d-h-i-s-') . rand(999, 9999) . '.' . $extention;
            $imagePath = 'uploads/banking-partners/' . $imageName;

            Image::make($request->logo)
                ->save(public_path() . '/' . $imagePath);

            $partner->logo = $imagePath;
        }

        $partner->name = $request->name;
        $partner->url = $request->url;
        $partner->status = $request->status;
        $partner->save();

        $notification = trans('admin_validation.Created Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.banking-partner.index')->with($notification);
    }

    public function edit($id)
    {
        $partner = BankingPartner::find($id);
        return view('admin.edit_banking_partner', compact('partner'));
    }

    public function update(Request $request, $id)
    {
        $partner = BankingPartner::find($id);

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
            $existingImage = $partner->logo;
            $extention = $request->logo->getClientOriginalExtension();
            $imageName = 'banking-partner' . date('-Y-m-d-h-i-s-') . rand(999, 9999) . '.' . $extention;
            $imagePath = 'uploads/banking-partners/' . $imageName;

            Image::make($request->logo)
                ->save(public_path() . '/' . $imagePath);

            $partner->logo = $imagePath;
            $partner->save();

            if ($existingImage && File::exists(public_path() . '/' . $existingImage)) {
                unlink(public_path() . '/' . $existingImage);
            }
        }

        $partner->name = $request->name;
        $partner->url = $request->url;
        $partner->status = $request->status;
        $partner->save();

        $notification = trans('admin_validation.Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.banking-partner.index')->with($notification);
    }

    public function destroy($id)
    {
        $partner = BankingPartner::find($id);
        $existingImage = $partner->logo;
        $partner->delete();

        if ($existingImage && File::exists(public_path() . '/' . $existingImage)) {
            unlink(public_path() . '/' . $existingImage);
        }

        $notification = trans('admin_validation.Delete Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.banking-partner.index')->with($notification);
    }

    public function changeStatus($id)
    {
        $partner = BankingPartner::find($id);
        if ($partner->status == 1) {
            $partner->status = 0;
            $partner->save();
            $message = trans('admin_validation.Inactive Successfully');
        } else {
            $partner->status = 1;
            $partner->save();
            $message = trans('admin_validation.Active Successfully');
        }

        return response()->json($message);
    }
}
