<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Professor;
use App\Models\Speciality;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfessorController extends Controller
{
    public function index()
    {
        $professors = Professor::all();
        return view('admin.professors.index', compact('professors'));
    }

    public function create()
    {
        $specialities = Speciality::all();

         return view('admin.professors.create', compact('specialities'));
    }

    public function store(Request $request)
    {
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('professors', 'public');
        }
        $plainPassword = Str::random(8); // Generate a random password

        Professor::create([
            'name' => $request->name,
            'email' => $request->email,
            'image' => $imagePath,
            'speciality_id' => $request->speciality_id,
            'password' => Hash::make($plainPassword), // Generate a random password
        ]);

        return redirect()->route('professors.index')
            ->with('success', 'Professor created successfully. New Password: ' . $plainPassword);
    }

    public function show(Professor $professor)
    {
        $professor->load([
            'projects',
            'allocations.student',
            'allocations.project'
        ]);

        return view('admin.professors.show', compact('professor'));
    }

    public function edit(Professor $professor)
    {
        $specialities = Speciality::all();

        return view('admin.professors.edit', compact('professor', 'specialities'));
    }
    public function update(Request $request, Professor $professor)
{
    $imagePath = $professor->image;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('professors', 'public');
    }

    $email = $request->email;
    $code = strtolower(explode('@', $email)[0]);

    $professor->update([
        'name' => $request->name,
        'email' => $request->email,
        'code' => 'PROF-' . $code,
        'image' => $imagePath,
    ]);

    return redirect()->route('professors.index');
}


}
