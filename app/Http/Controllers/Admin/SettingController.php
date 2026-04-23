<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Student;
use App\Models\Professor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.index', [
            'results_date' => setting('results_date'),
            'review_date' => setting('review_date'),
            'students' => Student::all(),
            'professors' => Professor::all(),
        ]);
    }

    public function store(Request $request)
    {
        Setting::updateOrCreate(
            ['key' => 'results_date'],
            ['value' => $request->results_date]
        );

        Setting::updateOrCreate(
            ['key' => 'review_date'],
            ['value' => $request->review_date]
        );

        return back()->with('success', 'Settings updated!');
    }

    // ✅ Reset Student Password
    public function resetStudentPassword($id)
    {
        $student = Student::findOrFail($id);

        $newPassword = Str::random(8);

        $student->update([
            'password' => Hash::make($newPassword)
        ]);

        return back()->with('success', "Student password: $newPassword");
    }

    // ✅ Reset Professor Password
    public function resetProfessorPassword($id)
    {
        $professor = Professor::findOrFail($id);

        $newPassword = Str::random(8);

        $professor->update([
            'password' => Hash::make($newPassword)
        ]);

        return back()->with('success', "Professor password: $newPassword");
    }
}