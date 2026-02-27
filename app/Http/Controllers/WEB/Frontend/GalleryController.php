<?php

namespace App\Http\Controllers\WEB\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::where('status', 1)
            ->latest()
            ->paginate(12);

        return view('frontend.gallery.index', compact('galleries'));
    }
}
