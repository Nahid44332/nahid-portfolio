<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

      public function manage()
    {
        $services = Service::all();
        return view('backend.service.service', compact('services'));
    }

    // Store or Update Service
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'icon' => 'required',
            'price' => 'required',
        ]);

        Service::updateOrCreate(
            ['id' => $request->id],
            [
                'title' => $request->title,
                'icon' => $request->icon,
                'price' => $request->price,
                'description' => $request->description,
            ]
        );

        return back()->with('success', 'Service saved successfully!');
    }

    // Delete Service
    public function destroy($id)
    {
        Service::findOrFail($id)->delete();
        return back()->with('success', 'Service deleted successfully!');
    }
}
