<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use App\Models\Allocation;

class RunAutoAllocation extends Command
{
    protected $signature = 'allocations:run';

    protected $description = 'Automatically allocate students to best projects';

    public function handle()
    {
        $students = Student::with([
            'skills',
            'selections.project.skills',
            'allocation'
        ])->get();

        foreach ($students as $student) {

            // skip already allocated
            if ($student->allocation) continue;

            $bestProject = null;
            $bestScore = 0;

            foreach ($student->selections as $selection) {

                $project = $selection->project;

                // capacity check
                $currentCount = Allocation::where('project_id', $project->id)->count();

                if ($currentCount >= $project->max_students) continue;

                // CGPA score
                $cgpaScore = ($student->cgpa / 20) * 100;

                // Skill matching
                $skillScore = 0;
                $maxWeight = 0;

                $studentSkills = $student->skills->pluck('id');

                foreach ($project->skills as $skill) {
                    $maxWeight += $skill->pivot->weight;

                    if ($studentSkills->contains($skill->id)) {
                        $skillScore += $skill->pivot->weight;
                    }
                }

                $skillPercent = $maxWeight > 0
                    ? ($skillScore / $maxWeight) * 100
                    : 0;

                // Preference score
                $preferenceScore = (6 - $selection->preference_order) * 20;

                // Final score
                $finalScore =
                    ($cgpaScore * 0.6) +
                    ($skillPercent * 0.3) +
                    ($preferenceScore * 0.1);

                if ($finalScore > $bestScore) {
                    $bestScore = $finalScore;
                    $bestProject = $project;
                }
            }

            if ($bestProject) {
                Allocation::create([
                    'student_id' => $student->id,
                    'project_id' => $bestProject->id,
                ]);
            }
        }

        $this->info('Auto allocation completed successfully');
    }
}