<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function myProject($id)
    {
        $student = Student::with([
            'allocation.project.professor'
        ])->find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found'
            ], 404);
        }

        if (!$student->allocation) {
            return response()->json([
                'message' => 'No project allocated yet'
            ]);
        }

        return response()->json([
            'student' => $student->name,
            'cgpa' => $student->cgpa,
            'project' => $student->allocation->project->title,
            'description' => $student->allocation->project->description,
            'professor' => $student->allocation->project->professor->name,
            'professor_image' => $student->allocation->project->professor->image
        ]);
    }
}