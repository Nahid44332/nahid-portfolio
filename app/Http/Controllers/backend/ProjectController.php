<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Project()
    {
        $projects = Project::get();
        return view('backend.project.project', compact('projects'));
    }

    public function ProjectStore(Request $request)
    {
        $projects = new Project();

        $projects->title = $request->title;
        $projects->category = $request->category;
        $projects->link = $request->link;

        if (isset($request->image)) {
            $imageName = rand() . '-Project-' . '.' . $request->image->extension();
            $request->image->move('backend/images/projects/', $imageName);

            $projects->image = $imageName;
        }

        $projects->save();

        return redirect()->back()->with('success','Project Added Successfully');

    }
}
