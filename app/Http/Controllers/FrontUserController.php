<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontUserController extends Controller
{

    public function profile()
    {
        $user = auth()->user();
        return view('frontend2.pages.profile', compact('user'));
    }

    public function dashboard()
    {
        // Login user information
        $user = auth()->user();
        return view('frontend2.pages.dashboard', compact('user'));
    }
}
