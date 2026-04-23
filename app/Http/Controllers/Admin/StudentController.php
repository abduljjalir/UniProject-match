<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Speciality;
use App\Models\Skill;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['speciality', 'allocation'])->get();
        return view('admin.students.index', compact('students'));
    }
     public function create()
{
    $specialities = Speciality::all();
    $skills = Skill::all();

    return view('admin.students.create', compact('specialities', 'skills'));
}
 public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'student_id' => 'required|unique:students',
        'cgpa' => 'required',
        'speciality_id' => 'required',
        'skills' => 'array|exists:skills,id',
        'levels' => 'array',

        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $imagePath = null;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('students', 'public');
    }

    $student = Student::create([
        'name' => $request->name,
        'student_id' => $request->student_id,
        'cgpa' => $request->cgpa,
        'speciality_id' => $request->speciality_id,
        'image' => $imagePath,
    ]);

    // ✅ SAVE SKILLS
    if ($request->skills) {
        foreach ($request->skills as $skillId) {
            $student->skills()->attach($skillId, [
                'level' => $request->levels[$skillId] ?? null
            ]);
        }
    }

    return redirect()->route('students.index')
        ->with('success', 'Student created successfully');
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
    public function edit(Student $student)
{
    $specialities = Speciality::all();
    $skills = Skill::all();

    return view('admin.students.edit', compact('student', 'specialities', 'skills'));
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

    $imagePath = $student->image;

    if ($request->hasFile('image')) {

        // delete old image
        if ($student->image) {
            \Storage::disk('public')->delete($student->image);
        }

        $imagePath = $request->file('image')->store('students', 'public');
    }

    $student->update([
        'name' => $request->name,
        'student_id' => $request->student_id,
        'cgpa' => $request->cgpa,
        'speciality_id' => $request->speciality_id,
        'image' => $imagePath,
    ]);

    // ✅ SYNC SKILLS
    $syncData = [];

    if ($request->skills) {
        foreach ($request->skills as $skillId) {
            $syncData[$skillId] = [
                'level' => $request->levels[$skillId] ?? 1
            ];
        }
    }

    $student->skills()->sync($syncData);

    return redirect()->route('students.index')
        ->with('success', 'Student updated successfully');
}
}

    