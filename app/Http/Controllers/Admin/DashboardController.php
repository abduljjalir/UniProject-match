<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Professor;
use App\Models\Speciality;
use App\Models\Project;
use App\Models\Allocation;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $allocatedStudents = Allocation::count();

    $allocationPercent = $totalStudents > 0 
        ? round(($allocatedStudents / $totalStudents) * 100)
        : 0;

    $unallocated = Student::doesntHave('allocation')->count();

    $alerts = [];

    if ($unallocated > 0) {
        $alerts[] = "$unallocated students not allocated";
    }

    $recentSelections = \App\Models\Selection::with('student', 'project')
        ->latest()
        ->take(5)
        ->get();
     $topProject = Project::withCount('selections')
    ->orderByDesc('selections_count')
    ->first();

    $topStudent = Student::orderByDesc('cgpa')->first();

    return view('admin.pages.dashboard', [
        'studentCount' => $totalStudents,
        'professorCount' => Professor::count(),
        'specialityCount' => Speciality::count(),

        'allocationPercent' => $allocationPercent,

        'alerts' => $alerts,
        'recentSelections' => $recentSelections,

        'students' => Student::with('selections.project', 'allocation.project')
        ->latest()
        ->take(10)
        ->get(),
        'professors' => Professor::with('projects')
        ->latest()
        ->take(10)
        ->get(),

        'specialityNames' => Speciality::pluck('name'),
        'studentCounts' => Speciality::withCount('students')->pluck('students_count'),

        'projectNames' => Project::pluck('title'),
        'projectCounts' => Project::withCount('selections')->pluck('selections_count'),

        'topProject' => $topProject,
        'topStudent' => $topStudent,
    ]);
    }
}