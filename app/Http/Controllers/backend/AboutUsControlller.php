<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsControlller extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function abooutUs()
    {
        $abouts = AboutUs::first();
        return view('backend.aboutus.aboutus', compact('abouts'));
    }

     public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'years' => 'required',
        ]);

        $about = $request->id ? AboutUs::find($request->id) : new AboutUs();

        $about->title = $request->title;
        $about->years = $request->years;
        $about->description = $request->description;
        $about->happy_clients = $request->happy_clients;
        $about->projects_completed = $request->projects_completed;
        $about->features = $request->features ?? [];

       if(isset($request->image_one)){
            $imageName = rand().'-about-'.'.'.$request->image_one->extension();
            $request->image_one->move('backend/images/about/', $imageName);

            $about->image_one = $imageName;

        }
       if(isset($request->image_two)){
            $imageName = rand().'-about-'.'.'.$request->image_two->extension();
            $request->image_two->move('backend/images/about/', $imageName);

            $about->image_two = $imageName;

        }

        $about->save();

        return redirect()->back()->with('success', 'Saved successfully!');
    }
}
