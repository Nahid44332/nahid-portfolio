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

    public function heroSectionUpdate(Request $request)
    {
        $herosection = HeroSection::first();

        $herosection->name = $request->name;
        $herosection->typed_texts = $request->typed_texts;
        $herosection->video_link = $request->video_link;

         if(isset($request->cv)){

            if($herosection->cv && file_exists('backend/file/cv/'.$herosection->cv)){
                unlink('backend/file/cv/'.$herosection->cv);
            }

            $cvName = rand().'-cv'.'.'.$request->cv->extension();
            $request->cv->move('backend/file/cv/', $cvName);

            $herosection->cv = $cvName;
        }
         if(isset($request->image)){

            if($herosection->image && file_exists('backend/images/profile/'.$herosection->image)){
                unlink('backend/images/profile/'.$herosection->image);
            }

            $imageName = rand().'-profile-'.'.'.$request->image->extension();
            $request->image->move('backend/images/profile/', $imageName);

            $herosection->image = $imageName;
        }

        $herosection->save();
        toastr()->success('Personel Info Updated');
        return redirect()->back();
    }
}
