<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SkillExperienceController extends Controller
{
    public function index()
    {
        $skills = Skill::orderBy('id', 'desc')->get();
        $experiences = Experience::orderBy('id', 'desc')->get();
        $educations = Education::orderBy('id', 'desc')->get();

        return view('backend.skill_experience.create', compact('skills', 'experiences', 'educations'));
    }

    public function store(Request $request)
    {
        // validation rules for arrays
        $rules = [
            'skills' => 'nullable|array',
            'skills.*.name' => 'required_with:skills|string|max:255',
            'skills.*.percentage' => 'required_with:skills|integer|min:0|max:100',

            'experiences' => 'nullable|array',
            'experiences.*.title' => 'required_with:experiences|string|max:255',
            'experiences.*.company' => 'required_with:experiences|string|max:255',
            'experiences.*.year_from' => 'nullable|string|max:10',
            'experiences.*.year_to' => 'nullable|string|max:10',

            'educations' => 'nullable|array',
            'educations.*.title' => 'required_with:educations|string|max:255',
            'educations.*.institution' => 'required_with:educations|string|max:255',
            'educations.*.year_from' => 'nullable|string|max:10',
            'educations.*.year_to' => 'nullable|string|max:10',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // if AJAX, return json errors
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $created = [
                'skills' => [],
                'experiences' => [],
                'educations' => [],
            ];

            if ($request->filled('skills')) {
                foreach ($request->skills as $s) {
                    $skill = Skill::create([
                        'name' => $s['name'],
                        'percentage' => $s['percentage'],
                    ]);
                    $created['skills'][] = $skill;
                }
            }

            if ($request->filled('experiences')) {
                foreach ($request->experiences as $e) {
                    $exp = Experience::create([
                        'title' => $e['title'],
                        'company' => $e['company'],
                        'year_from' => $e['year_from'] ?? null,
                        'year_to' => $e['year_to'] ?? null,
                    ]);
                    $created['experiences'][] = $exp;
                }
            }

            if ($request->filled('educations')) {
                foreach ($request->educations as $ed) {
                    $edu = Education::create([
                        'title' => $ed['title'],
                        'institution' => $ed['institution'],
                        'year_from' => $ed['year_from'] ?? null,
                        'year_to' => $ed['year_to'] ?? null,
                    ]);
                    $created['educations'][] = $edu;
                }
            }

            DB::commit();

            if ($request->ajax()) {
                return response()->json(['status' => 'success', 'message' => 'Data saved', 'created' => $created]);
            }

            return redirect()->back()->with('success', 'Data saved successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => 'Server error'], 500);
            }
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function delete($type, $id)
    {
        switch ($type) {
            case 'skill':
                $model = Skill::find($id);
                break;
            case 'experience':
                $model = Experience::find($id);
                break;
            case 'education':
                $model = Education::find($id);
                break;
            default:
                return response()->json(['status' => 'error', 'message' => 'Invalid type'], 400);
        }

        if (!$model) return response()->json(['status' => 'error', 'message' => 'Not found'], 404);

        $model->delete();

        return response()->json(['status' => 'success', 'message' => 'Deleted successfully']);
    }
}
