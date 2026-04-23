<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Professor;
use App\Models\Speciality;
use App\Models\Project;
use App\Models\Allocation;
use App\Models\Selection;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $allocatedStudents = Allocation::count();

        $allocationPercent = $totalStudents > 0
            ? round(($allocatedStudents / $totalStudents) * 100)
            : 0;

        // FIX relationship name if needed
        $unallocated = Student::doesntHave('allocation')->count();

        $alerts = [];

        if ($unallocated > 0) {
            $alerts[] = "$unallocated students not allocated";
        }

        
        $recentSelections = Selection::with('student', 'project')
            ->latest()
            ->take(5)
            ->get();

        
        $recentAllocations = Allocation::with('student', 'project')
            ->latest()
            ->take(5)
            ->get();

       
        $topProject = Project::withCount('selections')
            ->orderByDesc('selections_count')
            ->first();

        $topStudent = Student::orderByDesc('cgpa')->first();

       
        $specialities = Speciality::withCount('students')->get();
        $projects = Project::withCount('selections')->get();

        
        $resultDate = setting('results_date');
        $reviewDate = setting('review_date');

        $resultDate = $resultDate ? Carbon::parse($resultDate) : now()->addDays(3);
        $reviewDate = $reviewDate ? Carbon::parse($reviewDate) : now()->addDays(7);

        $daysToResults = now()->diffInDays($resultDate, false);
        $daysToReview = now()->diffInDays($reviewDate, false);

        return view('admin.pages.dashboard', [

            // COUNTS
            'studentCount' => $totalStudents,
            'professorCount' => Professor::count(),
            'specialityCount' => Speciality::count(),

            // ALLOCATION
            'allocationPercent' => $allocationPercent,
            'alerts' => $alerts,

            // DATA LISTS
            'recentSelections' => $recentSelections,
            'recentAllocations' => $recentAllocations,

            'students' => Student::with('selections.project', 'allocation.project')
                ->latest()
                ->take(10)
                ->get(),

            'professors' => Professor::with('projects')
                ->latest()
                ->take(10)
                ->get(),

            // CHARTS
            'specialityNames' => $specialities->pluck('name'),
            'studentCounts' => $specialities->pluck('students_count'),

            'projectNames' => $projects->pluck('title'),
            'projectCounts' => $projects->pluck('selections_count'),

            // TOP STATS
            'topProject' => $topProject,
            'topStudent' => $topStudent,

            // REMINDERS
            'daysToResults' => $resultDate->diffInDays(now()),
            'daysToReview' => $reviewDate->diffInDays(now()),
        ]);
    }
}