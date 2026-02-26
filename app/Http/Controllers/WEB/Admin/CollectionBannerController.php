<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\CollectionBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class CollectionBannerController extends Controller
{

    public function create()
    {
        return view('admin.AddCollectionBanner');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg',
        ]);

        $image = $request->file('image');
        $imageName = uniqid() . "_collection_banner" . "." . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/collection-banner/'), $imageName);
        $imagePath = "uploads/collection-banner/" . $imageName;
        $item = CollectionBanner::where('status', 1)->get();

        // if item is less than 3 then only add the collection
        if ($item->count() < 10) {
            CollectionBanner::create([
                'brand' => $request->input('brand'),
                'title' => $request->input('title'),
                'url' => $request->input('url'),
                'image' => $imagePath,
                'discount_text' => $request->input('discount_text'),
            ]);

            return redirect()->route('admin.about-us.index')->with('success', 'Collection Banner Added Successfully!');
        } else {
            return redirect()->route('admin.about-us.index')->with('error', 'You can add only 3 Collection Banner');
        }
    }


    public function edit($id)
    {

        $item = CollectionBanner::find($id);
        return view('admin.EditCollectionBanner', compact('item'));
    }


    public function update(Request $request, $id)
    {
        if ($request->hasFile('image')) {
            // Delete Old Image
            $oldImage = CollectionBanner::where('id', $id)->first()->image;
            unlink(public_path($oldImage));

            // Add New Image
            $image = $request->file('image');
            $imageName = uniqid() . "_collection_banner" . "." . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/collection-banner/'), $imageName);
            $imagePath = "uploads/collection-banner/" . $imageName;

            CollectionBanner::where('id', $id)->update([
                'brand' => $request->input('brand'),
                'title' => $request->input('title'),
                'url' => $request->input('url'),
                'image' => $imagePath,
                'discount_text' => $request->input('discount_text'),
            ]);
            return redirect()->route('admin.about-us.index')->with('updated', 'Collection Banner Updated Successfully!');
        } else {

            CollectionBanner::where('id', $id)->update([
                'brand' => $request->input('brand'),
                'title' => $request->input('title'),
                'url' => $request->input('url'),
                'discount_text' => $request->input('discount_text'),
            ]);
            return redirect()->route('admin.about-us.index')->with('updated', 'Collection Banner Updated Successfully!');
        }
    }

    public function destroy($id)
    {

        $item = CollectionBanner::where('id', $id)->first();
        $oldImage = $item->image;
        unlink(public_path($oldImage));
        $item->delete();
        return redirect()->route('admin.about-us.index')->with('deleted', 'Collection Banner Deleted Successfully!');
    }
}
