<?php

namespace App\Http\Controllers\WEB\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\CollectionBanner;
use App\Models\Category;
use App\Models\Product;
use App\Models\Testimonial;

class AboutController extends Controller
{
    public function index()
    {
        $about = AboutUs::first();
        $testimonials = Testimonial::latest()->take(6)->get();
        $brandLogos = CollectionBanner::where('status', true)
            ->latest()
            ->take(8)
            ->get();

        $stats = [
            'products' => Product::count(),
            'categories' => Category::count(),
            'testimonials' => Testimonial::count(),
        ];

        return view('frontend.about.index', compact('about', 'testimonials', 'brandLogos', 'stats'));
    }
}
