<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Speciality;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('speciality')->get();
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $specialities = Speciality::all();
        return view('admin.students.create', compact('specialities'));
    }

    public function store(Request $request)
    {
        Student::create($request->all());
        return redirect()->route('students.index');
    }

    public function edit(Student $student)
    {
        $specialities = Speciality::all();
        return view('admin.students.edit', compact('student', 'specialities'));
    }

    public function update(Request $request, Student $student)
    {
        $student->update($request->all());
        return redirect()->route('students.index');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index');
    }
}