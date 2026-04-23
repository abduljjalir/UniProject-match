<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Allocation;
use App\Models\Student;
use App\Models\Project;
use Illuminate\Http\Request;

class AllocationController extends Controller
{
    public function index()
    {
        $allocations = Allocation::with('student', 'project.professor')->latest()->get();

        return view('admin.allocations.index', compact('allocations'));
    }
   public function create(Request $request)
{
    $students = Student::with([
        'skills',
        'selections.project.skills'
    ])
    ->doesntHave('allocation')
    ->get();

    if (!$request->student_id) {
        return view('admin.allocations.create', compact('students'));
    }

    $selectedStudent = Student::with([
        'skills',
        'selections.project.skills'
    ])->findOrFail($request->student_id);

    $rankedProjects = [];

    foreach ($selectedStudent->selections as $selection) {

        $project = $selection->project;

        $currentCount = Allocation::where('project_id', $project->id)->count();
        if ($currentCount >= $project->max_students) continue;

        $cgpaScore = ($selectedStudent->cgpa / 20) * 100;

        $skillScore = 0;
        $maxSkillWeight = 0;

        foreach ($project->skills as $skill) {
            $maxSkillWeight += $skill->pivot->weight;

            if ($selectedStudent->skills->contains($skill->id)) {
                $skillScore += $skill->pivot->weight;
            }
        }

        $skillPercent = $maxSkillWeight > 0
            ? ($skillScore / $maxSkillWeight) * 100
            : 0;

        $preferenceScore = (5- $selection->preference_order) * 20;

        $finalScore =
            ($cgpaScore * 0.6) +
            ($skillPercent * 0.3) +
            ($preferenceScore * 0.1);

        $rankedProjects[] = [
            'project' => $project,
            'score' => $finalScore,
            'cgpa' => $cgpaScore,
            'skills' => $skillPercent,
            'preference' => $selection->preference_order
        ];
    }

    usort($rankedProjects, function ($a, $b) {
        return $b['score'] <=> $a['score'];
    });

    return view('admin.allocations.create', compact(
        'students',
        'selectedStudent',
        'rankedProjects'
    ));
}
    public function store(Request $request)
{
    $request->validate([
        'student_id' => 'required',
        'project_id' => 'required',
    ]);

    $student = Student::with('selections')->findOrFail($request->student_id);

    // ❌ BLOCK if no selections
    if ($student->selections->isEmpty()) {
        return back()->with('error', 'Student has no project selected!');
    }

    // ❌ ensure project is from selection list
    $allowedProjectIds = $student->selections->pluck('project_id')->toArray();

    if (!in_array($request->project_id, $allowedProjectIds)) {
        return back()->with('error', 'Invalid project selection!');
    }

    if (Allocation::where('student_id', $student->id)->exists()) {
        return back()->with('error', 'Student already allocated!');
    }

    $project = Project::findOrFail($request->project_id);

    if ($project->allocations()->count() >= $project->max_students) {
        return back()->with('error', 'Project is full!');
    }

    Allocation::create([
        'student_id' => $student->id,
        'project_id' => $project->id,
        'professor_id' => $project->professor_id,
    ]);

    return redirect()->route('allocations.index')
        ->with('success', 'Allocated successfully');
}
    public function destroy($id)
    {
        Allocation::findOrFail($id)->delete();

        return back()->with('success', 'Allocation removed');
    }
}