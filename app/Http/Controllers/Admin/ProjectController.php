<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Professor;
use App\Models\Speciality;
use App\Models\Skill;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('professor', 'speciality')->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $professors = Professor::all();
        $specialities = Speciality::all();
        $skills = Skill::all(); // Assuming you have a Skill model

        return view('admin.projects.create', compact('professors', 'specialities' , 'skills'));
    }

     public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'description' => 'required',
        'max_students' => 'required|integer',
        'required_points' => 'required|integer',
        'professor_id' => 'required',
        'speciality_id' => 'required',
    ]);

    // ✅ Create project
    $project = Project::create([
        'title' => $request->title,
        'description' => $request->description,
        'max_students' => $request->max_students,
        'required_points' => $request->required_points,
        'professor_id' => $request->professor_id,
        'speciality_id' => $request->speciality_id,
    ]);

    // ✅ Attach skills with weights
    if ($request->skills) {

        foreach ($request->skills as $skillId => $value) {

            $weight = $request->weights[$skillId] ?? 0;

            if ($weight > 0) {
                $project->skills()->attach($skillId, [
                    'weight' => $weight
                ]);
            }
        }
    }

    return redirect()->route('projects.index')
        ->with('success', 'Project created successfully');
}

       public function edit(Project $project)
{
    $professors = Professor::all();
    $specialities = Speciality::all();
    $skills = Skill::all();

    $project->load('skills');

    return view('admin.projects.edit', compact('project', 'professors', 'specialities', 'skills'));
}

    public function update(Request $request, Project $project)
{
    $project->update([
        'title' => $request->title,
        'description' => $request->description,
        'max_students' => $request->max_students,
        'required_points' => $request->required_points,
        'professor_id' => $request->professor_id,
        'speciality_id' => $request->speciality_id,
    ]);

    // reset skills
    $project->skills()->detach();

    if ($request->skills) {
        foreach ($request->skills as $skillId => $value) {

            $weight = $request->weights[$skillId] ?? 0;

            if ($weight > 0) {
                $project->skills()->attach($skillId, [
                    'weight' => $weight
                ]);
            }
        }
    }

    return redirect()->route('projects.index')
        ->with('success', 'Project updated successfully');
}

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index');
    }

    public function show(Project $project)
    {
        $project->load('professor', 'speciality', 'selections.student', 'allocations.student');

        return view('admin.projects.show', compact('project'));
    }
}