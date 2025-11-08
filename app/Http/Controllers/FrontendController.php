<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function index()
    {
        $herosection = HeroSection::first();
        $abouts = AboutUs::first();
        return view('frontend.index', compact('herosection', 'abouts'));
    }

    public function adminLogin()
    {
        return view('backend.auth.admin-login');
    }

    public function adminLogout()
    {
        Auth::logout();

        return redirect('/admin/login');
    }
}
