@extends('admin.layouts.app')

@section('content')

<div class="max-w-3xl mx-auto bg-[#1e293b] p-6 rounded-xl shadow-lg">

    <h2 class="text-2xl font-semibold mb-6 text-white">✏️ Edit Student</h2>

    <form method="POST" action="{{ route('students.update', $student->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- IMAGE -->
        <div class="flex items-center gap-4 mb-6">
            <img 
                src="{{ $student->image 
                    ? asset('storage/'.$student->image) 
                    : 'https://ui-avatars.com/api/?name='.$student->name }}" 
                class="w-20 h-20 rounded-full object-cover border-2 border-purple-500">

            <input type="file" name="image" class="text-white" >
        </div>

        <!-- NAME -->
        <div class="mb-4">
            <label class="block text-sm text-gray-400 mb-1">Name</label>
            <input type="text" name="name"
                value="{{ $student->name }}"
                class="w-full p-2 rounded bg-[#0f172a] text-white border border-gray-600 focus:outline-none focus:border-purple-500">
        </div>

        <!-- STUDENT ID -->
        <div class="mb-4">
            <label class="block text-sm text-gray-400 mb-1">Student ID</label>
            <input type="text" name="student_id"
                value="{{ $student->student_id }}"
                class="w-full p-2 rounded bg-[#0f172a] text-white border border-gray-600">
        </div>

        <!-- CGPA -->
        <div class="mb-4">
            <label class="block text-sm text-gray-400 mb-1">CGPA</label>
            <input type="number" step="0.01" name="cgpa"
                value="{{ $student->cgpa }}"
                class="w-full p-2 rounded bg-[#0f172a] text-white border border-gray-600">
        </div>

        <!-- SPECIALITY -->
        <div class="mb-6">
            <label class="block text-sm text-gray-400 mb-1">Speciality</label>
            <select name="speciality_id"
                class="w-full p-2 rounded bg-[#0f172a] text-white border border-gray-600">

                @foreach($specialities as $s)
                    <option value="{{ $s->id }}" 
                        {{ $student->speciality_id == $s->id ? 'selected' : '' }}>
                        {{ $s->name }}
                    </option>
                @endforeach

            </select>
        </div>
        <!-- SKILLS -->
        <div class=" mb-6">
            <label class="block text-sm text-gray-400 mb-1">Skills</label>

            @foreach($skills as $skill)
                <div class="flex items-center gap-3 mt-2">
                    <input type="checkbox"
                           name="skills[]"
                           value="{{ $skill->id }}"
                           class="skill-checkbox"
                           {{ $student->skills->contains($skill) ? 'checked' : '' }}
                           data-id="{{ $skill->id }}">

                    <span class="text-white">{{ $skill->name }}</span>

                    <input type="number"
                           name="levels[{{ $skill->id }}]"
                           placeholder="Level"
                           class="w-20 p-1 bg-[#020617] text-white border border-gray-600 rounded hidden level-input"
                           data-id="{{ $skill->id }}"
                           value="{{ $student->skills->find($skill->id)->pivot->level ?? '' }}">
                </div>
            @endforeach
        </div>
        <!-- BUTTONS -->
        <div class="flex justify-between">
            <a href="{{ route('students.index') }}" 
               class="bg-gray-600 px-4 py-2 rounded text-white hover:bg-gray-700">
               ← Back
            </a>

            <button type="submit" 
                class="bg-purple-600 px-6 py-2 rounded text-white hover:bg-purple-700">
                Update Student
            </button>
        </div>

    </form>
</div>

@endsection