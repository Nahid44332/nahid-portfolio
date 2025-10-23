<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function index()
    {
        return view('frontend.index');
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
