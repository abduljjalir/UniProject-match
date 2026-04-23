<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Project;
use App\Models\Allocation;

class AllocationController extends Controller
{
  public function runAllocation()
{
    $students = Student::with([
        'skills',
        'selections.project.skills',
        'allocation'
    ])->get();

    foreach ($students as $student) {

        // 🚫 skip already allocated
        if ($student->allocation) continue;

        $bestProject = null;
        $bestScore = 0;

        $selections = $student->selections->sortBy('preference_order');

        foreach ($selections as $selection) {

            $project = $selection->project;

            if (!$project) continue;

            // 🚫 check capacity
            if ($project->allocations()->count() >= $project->max_students) {
                continue;
            }

            // 🎓 CGPA (60%)
            $cgpaScore = ($student->cgpa / 20) * 100;

            // 🧠 SKILLS (30%)
            $skillScore = 0;
            $maxSkillScore = 0;

            foreach ($project->skills as $skill) {

                $maxSkillScore += $skill->pivot->weight;

                foreach ($student->skills as $studSkill) {

                    if ($studSkill->id == $skill->id) {
                        $skillScore += $skill->pivot->weight * ($studSkill->pivot->level ?? 1);
                    }
                }
            }

            if ($maxSkillScore > 0) {
                $skillScore = ($skillScore / $maxSkillScore) * 100;
            }

            // 📊 PREFERENCE (dynamic)
            $preferenceScore = max(0, (10 - $selection->preference_order) * 10);

            // 🧮 FINAL SCORE
            $finalScore =
                ($cgpaScore * 0.6) +
                ($skillScore * 0.3) +
                ($preferenceScore * 0.1);

            if ($finalScore > $bestScore) {
                $bestScore = $finalScore;
                $bestProject = $project;
            }
        }

        // ✅ assign
        if ($bestProject) {
            Allocation::create([
                'student_id' => $student->id,
                'project_id' => $bestProject->id
            ]);
        }
    }

    return back()->with('success', 'Smart allocation completed!');
}   
}