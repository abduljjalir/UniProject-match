<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::latest()->get();
        return view('admin.skills.index', compact('skills'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:skills'
        ]);

        Skill::create([
            'name' => $request->name
        ]);

        return back()->with('success', 'Skill added');
    }

    public function update(Request $request, Skill $skill)
    {
        $request->validate([
            'name' => 'required|unique:skills,name,' . $skill->id
        ]);

        $skill->update([
            'name' => $request->name
        ]);

        return back()->with('success', 'Skill updated');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();

        return back()->with('success', 'Skill deleted');
    }
}