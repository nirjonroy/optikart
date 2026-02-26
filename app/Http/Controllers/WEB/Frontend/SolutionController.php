<?php

namespace App\Http\Controllers\WEB\Frontend;

use App\Http\Controllers\Controller;

class SolutionController extends Controller
{
    public function index()
    {
        $solutions = [
            [
                'title' => __('Home Try-On Service'),
                'description' => __('Our mobile team delivers a curated selection of frames directly to your home so you can try them on before making a purchase.'),
            ],
            [
                'title' => __('Online Selection & Appointment'),
                'description' => __('Browse our collection online, book an appointment, and let our experts bring vision care to your doorstep.'),
            ],
            [
                'title' => __('Vision Accessibility'),
                'description' => __('We are building digital tools to connect rural and urban communities with quality eyewear without visiting a physical store.'),
            ],
            [
                'title' => __('Corporate Wellness'),
                'description' => __('Host an eyewear wellness day at your workplace and offer employees on-site eye screening and frame fittings.'),
            ],
            [
                'title' => __('Smart Lens Monitoring'),
                'description' => __('Track prescription changes and lens replacements through our reminder tools tailored for families.'),
            ],
            [
                'title' => __('Express Repairs'),
                'description' => __('Need support fast? Book a technician to fix alignment, screws, or nose pads wherever you are.'),
            ],
        ];

        return view('frontend.solutions.index', compact('solutions'));
    }
}
