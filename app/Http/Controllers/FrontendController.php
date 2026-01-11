<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Models\Education;
use App\Models\Experience;
use App\Models\HeroSection;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function index()
    {
        $herosection = HeroSection::first();
        $abouts = AboutUs::first();
        $skills = Skill::all();
        $experiences = Experience::all();
        $educations = Education::all();
        $services = Service::all();
        $projects = Project::get();
        return view('frontend.index', compact('herosection', 'abouts', 'skills', 'experiences', 'educations', 'services', 'projects'));
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
