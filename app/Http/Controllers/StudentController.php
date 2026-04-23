<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Speciality;
use Illuminate\Support\Facades\Storage;

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
    public function show(Student $student)
{
    $student->load([
        'speciality',
        'skills',
        'selections.project.skills',
        'allocation.project.professor'
    ]);

    return view('admin.students.show', compact('student'));
}
public function create()
{
    $specialities = Speciality::all();

    return view('admin.students.create', compact('specialities'));
}
public function edit(Student $student)
{
    $specialities = Speciality::all();

    return view('admin.students.edit', compact('student', 'specialities'));
}
public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'student_id' => 'required|unique:students',
        'cgpa' => 'required',
        'speciality_id' => 'required',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // HANDLE IMAGE UPLOAD
    $imagePath = null;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('students', 'public');
    }

    // CREATE STUDENT
    Student::create([
        'name' => $request->name,
        'student_id' => $request->student_id,
        'cgpa' => $request->cgpa,
        'speciality_id' => $request->speciality_id,
        'image' => $imagePath,
    ]);

    return redirect()->route('students.index')
        ->with('success', 'Student created successfully');
        
}
public function update(Request $request, Student $student)
{
    $request->validate([
        'name' => 'required',
        'student_id' => 'required|unique:students,student_id,' . $student->id,
        'cgpa' => 'required',
        'speciality_id' => 'required',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // DEFAULT IMAGE
    $imagePath = $student->image;

    // HANDLE NEW IMAGE
    if ($request->hasFile('image')) {

        if ($student->image) {
            Storage::disk('public')->delete($student->image);
        }

        $imagePath = $request->file('image')->store('students', 'public');
    }

    // UPDATE ALL DATA AT ONCE
    $student->update([
        'name' => $request->name,
        'student_id' => $request->student_id,
        'cgpa' => $request->cgpa,
        'speciality_id' => $request->speciality_id,
        'image' => $imagePath,
    ]);

    return redirect()->route('students.index')
        ->with('success', 'Student updated successfully');
}
}