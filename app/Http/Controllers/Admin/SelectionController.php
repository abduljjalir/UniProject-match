<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Selection;
use App\Models\Student;
use App\Models\Project;
use Illuminate\Http\Request;

class SelectionController extends Controller
{
    public function index()
    {
        $selections = Selection::with('student', 'project')->get();
        return view('admin.selections.index', compact('selections'));
    }

    public function create()
    {
        $students = Student::all();
        $projects = Project::all();

        return view('admin.selections.create', compact('students', 'projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'project_id' => 'required|unique:selections,project_id,NULL,id,student_id,' . $request->student_id,
            'preference_order' => 'required|integer|min:1|max:5'
        ]);

        Selection::create($request->all());

        return redirect()->route('selections.index')
            ->with('success', 'Selection added');
    }

    public function edit(Selection $selection)
    {
        $students = Student::all();
        $projects = Project::all();

        return view('admin.selections.edit', compact('selection', 'students', 'projects'));
    }

    public function update(Request $request, Selection $selection)
    {
        $request->validate([
            'student_id' => 'required',
            'project_id' => 'required',
            'preference_order' => 'required|integer|min:1|max:5'
        ]);

        $selection->update($request->all());

        return redirect()->route('selections.index')
            ->with('success', 'Selection updated');
    }

    public function destroy(Selection $selection)
    {
        $selection->delete();

        return redirect()->route('selections.index')
            ->with('success', 'Selection deleted');
    }
}