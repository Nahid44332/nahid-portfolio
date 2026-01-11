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

        return redirect()->back()->with('success', 'Project Added Successfully');
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $data = [
            'title'    => $request->title,
            'category' => $request->category,
            'link'     => $request->link,
        ];

        if ($request->hasFile('image')) {
            if ($project->image && file_exists(public_path('backend/images/projects/' . $project->image))) {
                unlink(public_path('backend/images/projects/' . $project->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('backend/images/projects'), $imageName);

            $data['image'] = $imageName;
        }

        $project->update($data);

        return redirect()->back()->with('success', 'Project Updated Successfully');
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        if ($project->image && file_exists(public_path('backend/images/projects/' . $project->image))) {
            unlink(public_path('backend/images/projects/' . $project->image));
        }

        $project->delete();

        return redirect()->back()->with('success', 'Project Deleted Successfully');
    }
}
