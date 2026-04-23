@extends('admin.layouts.app')

@section('content')

<div class="max-w-2xl mx-auto bg-[#1e293b] p-6 rounded-2xl shadow">

    <h2 class="text-xl font-semibold mb-6 text-white">➕ Add Student</h2>

    <form method="POST" action="{{ route('students.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <!-- NAME -->
        <div>
            <label class="text-sm text-gray-400">Full Name</label>
            <input type="text" name="name"
                class="w-full p-2 mt-1 bg-[#020617] text-white rounded border border-gray-700 focus:border-purple-500 outline-none"
                placeholder="Enter student name">
        </div>

        <!-- STUDENT ID -->
        <div>
            <label class="text-sm text-gray-400">Student ID</label>
            <input type="text" name="student_id"
                class="w-full p-2 mt-1 bg-[#020617] text-white rounded border border-gray-700 focus:border-purple-500 outline-none"
                placeholder="e.g. ST2026-001">
        </div>

        <!-- CGPA -->
        <div>
            <label class="text-sm text-gray-400">CGPA</label>
            <input type="number" step="0.01" name="cgpa"
                class="w-full p-2 mt-1 bg-[#020617] text-white rounded border border-gray-700 focus:border-purple-500 outline-none"
                placeholder="e.g. 3.75">
        </div>

        <!-- SPECIALITY -->
        <div>
            <label class="text-sm text-gray-400">Speciality</label>
            <select name="speciality_id"
                class="w-full p-2 mt-1 bg-[#020617] text-white rounded border border-gray-700 focus:border-purple-500 outline-none">
                <option value="">Select Speciality</option>
                @foreach($specialities as $s)
                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-6">
    <label class="text-gray-400">Skills</label>

    @foreach($skills as $skill)
        <div class="flex items-center gap-3 mt-2">

            <!-- checkbox -->
            <input type="checkbox"
                   name="skills[]"
                   value="{{ $skill->id }}"
                   class="skill-checkbox"
                   data-id="{{ $skill->id }}">

            <span class="text-white">{{ $skill->name }}</span>

            <!-- level -->
            <input type="number"
                   name="levels[{{ $skill->id }}]"
                   placeholder="Level"
                   class="w-20 p-1 bg-[#020617] text-white border border-gray-600 rounded hidden level-input"
                   data-id="{{ $skill->id }}">
        </div>
    @endforeach
</div>

        <!-- IMAGE UPLOAD -->
        <div>
            <label class="text-sm text-gray-400">Profile Image</label>
            <input type="file" name="image" id="imageInput"
                class="w-full mt-1 text-gray-300">

            <!-- PREVIEW -->
            <div class="mt-3">
                <img id="preview" src="" class="w-16 h-16 rounded-full object-cover hidden border border-gray-600">
            </div>
        </div>

        <!-- BUTTON -->
        <button type="submit"
            class="w-full bg-purple-600 hover:bg-purple-700 py-2 rounded text-white font-semibold">
            Save Student
        </button>

    </form>

</div>

<!-- IMAGE PREVIEW SCRIPT -->
<script>
document.getElementById('imageInput').addEventListener('change', function(e) {
    const preview = document.getElementById('preview');
    const file = e.target.files[0];

    if(file){
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('hidden');
    }
});
<div class="mb-6">
    <label class="text-gray-400">Skills</label>

    @foreach($skills as $skill)
        <div class="flex items-center gap-3 mt-2">

            <!-- checkbox -->
            <input type="checkbox"
                   name="skills[]"
                   value="{{ $skill->id }}"
                   class="skill-checkbox"
                   data-id="{{ $skill->id }}">

            <span class="text-white">{{ $skill->name }}</span>

            <!-- level -->
            <input type="number"
                   name="levels[{{ $skill->id }}]"
                   placeholder="Level"
                   class="w-20 p-1 bg-[#020617] text-white border border-gray-600 rounded hidden level-input"
                   data-id="{{ $skill->id }}">
        </div>
    @endforeach
</div>
</script>

@endsection