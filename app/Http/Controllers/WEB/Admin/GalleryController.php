<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use File;
use Illuminate\Http\Request;
use Image;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->get();
        return view('admin.gallery', compact('galleries'));
    }

    public function create()
    {
        return view('admin.create_gallery');
    }

    public function store(Request $request)
    {
        $rules = [
            'image' => 'required',
            'caption' => 'nullable|string|max:255',
            'status' => 'required',
        ];

        $customMessages = [
            'image.required' => trans('admin_validation.Image is required'),
            'status.required' => trans('admin_validation.Status is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        $gallery = new Gallery();

        if ($request->image) {
            $extention = $request->image->getClientOriginalExtension();
            $imageName = 'gallery' . date('-Y-m-d-h-i-s-') . rand(999, 9999) . '.' . $extention;
            $imagePath = 'uploads/custom-images/' . $imageName;

            Image::make($request->image)
                ->save(public_path() . '/' . $imagePath);

            $gallery->image = $imagePath;
        }

        $gallery->caption = $request->caption;
        $gallery->status = $request->status;
        $gallery->save();

        $notification = trans('admin_validation.Created Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.gallery.index')->with($notification);
    }

    public function show($id)
    {
        $gallery = Gallery::find($id);
        return response()->json(['gallery' => $gallery], 200);
    }

    public function edit($id)
    {
        $gallery = Gallery::find($id);
        return view('admin.edit_gallery', compact('gallery'));
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::find($id);

        $rules = [
            'caption' => 'nullable|string|max:255',
            'status' => 'required',
        ];

        $customMessages = [
            'status.required' => trans('admin_validation.Status is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        if ($request->image) {
            $existingImage = $gallery->image;
            $extention = $request->image->getClientOriginalExtension();
            $imageName = 'gallery' . date('-Y-m-d-h-i-s-') . rand(999, 9999) . '.' . $extention;
            $imagePath = 'uploads/custom-images/' . $imageName;

            Image::make($request->image)
                ->save(public_path() . '/' . $imagePath);

            $gallery->image = $imagePath;
            $gallery->save();

            if ($existingImage) {
                if (File::exists(public_path() . '/' . $existingImage)) {
                    unlink(public_path() . '/' . $existingImage);
                }
            }
        }

        $gallery->caption = $request->caption;
        $gallery->status = $request->status;
        $gallery->save();

        $notification = trans('admin_validation.Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.gallery.index')->with($notification);
    }

    public function destroy($id)
    {
        $gallery = Gallery::find($id);
        $existingImage = $gallery->image;
        $gallery->delete();

        if ($existingImage) {
            if (File::exists(public_path() . '/' . $existingImage)) {
                unlink(public_path() . '/' . $existingImage);
            }
        }

        $notification = trans('admin_validation.Delete Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.gallery.index')->with($notification);
    }

    public function changeStatus($id)
    {
        $gallery = Gallery::find($id);
        if ($gallery->status == 1) {
            $gallery->status = 0;
            $gallery->save();
            $message = trans('admin_validation.Inactive Successfully');
        } else {
            $gallery->status = 1;
            $gallery->save();
            $message = trans('admin_validation.Active Successfully');
        }

        return response()->json($message);
    }
}
