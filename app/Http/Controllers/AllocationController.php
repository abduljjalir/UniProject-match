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
        $students = Student::all();

        foreach ($students as $student) {

            $bestProject = null;
            $bestScore = 0;

            $selections = $student->selections()->orderBy('preference_order')->get();

            foreach ($selections as $selection) {

                $project = Project::find($selection->project_id);

                if (!$project) {
                    continue;
                }

                $currentCount = Allocation::where('project_id', $project->id)->count();

                if ($currentCount >= $project->max_students) {
                    continue;
                }

                // CGPA (60%)
                $cgpaScore = ($student->cgpa / 20) * 100;

                // SKILLS (30%)
                $skillScore = 0;
                $maxSkillScore = 0;

                foreach ($project->skills as $skill) {
                    $maxSkillScore += $skill->pivot->weight;

                    if ($student->skills->contains($skill->id)) {
                        $skillScore += $skill->pivot->weight;
                    }
                }

                if ($maxSkillScore > 0) {
                    $skillScore = ($skillScore / $maxSkillScore) * 100;
                }

                // PREFERENCE (10%)
                $preferenceScore = (6 - $selection->preference_order) * 20;

                // FINAL SCORE
                $finalScore =
                    ($cgpaScore * 0.6) +
                    ($skillScore * 0.3) +
                    ($preferenceScore * 0.1);

                if ($finalScore > $bestScore) {
                    $bestScore = $finalScore;
                    $bestProject = $project;
                }
            }

            if ($bestProject) {
                Allocation::create([
                    'student_id' => $student->id,
                    'project_id' => $bestProject->id
                ]);
            }
        }

        return "Allocation Completed";
    }
}