<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Speciality;
use Illuminate\Http\Request;

class SpecialityController extends Controller
{
    public function index()
    {
        $specialities = Speciality::withCount('students', 'projects')->get();
        return view('admin.specialities.index', compact('specialities'));
    }

    public function create()
    {
        return view('admin.specialities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:specialities'
        ]);

        Speciality::create($request->all());

        return redirect()->route('specialities.index');
    }

    public function edit(Speciality $speciality)
    {
        return view('admin.specialities.edit', compact('speciality'));
    }

    public function update(Request $request, Speciality $speciality)
    {
        $request->validate([
            'name' => 'required|unique:specialities,name,' . $speciality->id
        ]);

        $speciality->update($request->all());

        return redirect()->route('specialities.index');
    }

    public function destroy(Speciality $speciality)
    {
        $speciality->delete();
        return redirect()->route('specialities.index');
    }

    public function show(Speciality $speciality)
    {
        $speciality->load('students', 'projects', 'professors');

        return view('admin.specialities.show', compact('speciality'));
    }
}