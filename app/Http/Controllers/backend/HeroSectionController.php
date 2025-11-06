<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\Request;

class HeroSectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function heroSection()
    {
        $herosection = HeroSection::first();
        return view('backend.herosection.index', compact('herosection'));
    }

    public function heroSectionStore(Request $request)
    {
        $herosection = new HeroSection();

        $herosection->name = $request->name;
        $herosection->typed_texts = $request->typed_texts;
        $herosection->video_link = $request->video_link;

        if (isset($request->cv)) {
            $imageName = rand() . '-cv-' . '.' . $request->cv->extension();
            $request->cv->move('backend/file/cv/', $imageName);
            $herosection->cv = $imageName;
        }

        if (isset($request->image)) {
            $imageName = rand() . '-profile-' . '.' . $request->image->extension();
            $request->image->move('backend/images/profile/', $imageName);
            $herosection->image = $imageName;
        }

        $herosection->save();
        toastr()->success('Your Data Submitted');
        return redirect()->back();
    }
}
