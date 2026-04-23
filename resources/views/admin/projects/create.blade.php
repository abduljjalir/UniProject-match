@extends('admin.layouts.app')

@section('content')

<div class="max-w-3xl mx-auto bg-[#1e293b] p-6 rounded-2xl shadow">

    <h2 class="text-xl font-semibold mb-6 text-white">➕ Add Project</h2>

    <form method="POST" action="{{ route('projects.store') }}" class="space-y-5">
        @csrf

        <!-- TITLE -->
        <div>
            <label class="text-sm text-gray-400">Project Title</label>
            <input name="title" required
                class="w-full p-2 mt-1 bg-[#020617] text-white rounded border border-gray-700 focus:border-purple-500 outline-none">
        </div>

        <!-- DESCRIPTION -->
        <div>
            <label class="text-sm text-gray-400">Description</label>
            <textarea name="description" required
                class="w-full p-2 mt-1 bg-[#020617] text-white rounded border border-gray-700 focus:border-purple-500 outline-none"></textarea>
        </div>

        <!-- GRID -->
        <div class="grid grid-cols-2 gap-4">

            <!-- MAX STUDENTS -->
            <div>
                <label class="text-sm text-gray-400">Max Students</label>
                <input type="number" name="max_students" required
                    class="w-full p-2 mt-1 bg-[#020617] text-white rounded border border-gray-700">
            </div>

            <!-- REQUIRED POINTS -->
            <div>
                <label class="text-sm text-gray-400">Required Points</label>
                <input type="number" name="required_points" required
                    class="w-full p-2 mt-1 bg-[#020617] text-white rounded border border-gray-700">
            </div>

        </div>

        <!-- SPECIALITY -->
        <div>
            <label class="text-sm text-gray-400">Speciality</label>
            <select name="speciality_id" id="speciality" required
                class="w-full p-2 mt-1 bg-[#020617] text-white rounded border border-gray-700">
                <option value="">Select Speciality</option>
                @foreach($specialities as $s)
                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- PROFESSOR -->
        <div>
            <label class="text-sm text-gray-400">Professor</label>
            <select name="professor_id" id="professor" required
                class="w-full p-2 mt-1 bg-[#020617] text-white rounded border border-gray-700">
                <option value="">Select Professor</option>
            </select>
        </div>

        <!-- SKILLS -->
        <div>
            <label class="text-sm text-gray-400">Required Skills</label>

            <div class="grid grid-cols-2 gap-3 mt-3">

                @foreach($skills as $skill)
                <div class="flex items-center justify-between bg-[#020617] p-2 rounded">

                    <div class="flex items-center gap-2">
                        <input type="checkbox"
                               name="skills[]"
                               value="{{ $skill->id }}"
                               class="skill-checkbox"
                               data-id="{{ $skill->id }}">

                        <span class="text-white text-sm">{{ $skill->name }}</span>
                    </div>

                    <input type="number"
                           name="weights[{{ $skill->id }}]"
                           min="1"
                           max="100"
                           placeholder="W"
                           class="w-16 p-1 text-sm bg-[#020617] text-white border border-gray-600 rounded hidden weight-input"
                           data-id="{{ $skill->id }}">
                </div>
                @endforeach

            </div>

            <!-- TOTAL WEIGHT -->
            <p class="text-sm text-gray-400 mt-3">
                Total Weight: <span id="totalWeight">0</span>
            </p>
        </div>

        <!-- BUTTON -->
        <button class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded text-white w-full">
            Save Project
        </button>

    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const professors = @json($professors);

    const speciality = document.getElementById('speciality');
    const professorSelect = document.getElementById('professor');

    // FILTER PROFESSORS
    speciality.addEventListener('change', function () {

        let specialityId = this.value;

        professorSelect.innerHTML = '<option value="">Select Professor</option>';

        let filtered = professors.filter(p => p.speciality_id == specialityId);

        if(filtered.length === 0){
            professorSelect.innerHTML += `<option disabled>No professors available</option>`;
        }

        filtered.forEach(p => {
            professorSelect.innerHTML += `<option value="${p.id}">${p.name}</option>`;
        });

    });

    // SKILL WEIGHT TOGGLE
    document.querySelectorAll('.skill-checkbox').forEach(cb => {

        cb.addEventListener('change', function () {

            let id = this.dataset.id;
            let input = document.querySelector(`.weight-input[data-id='${id}']`);

            if (this.checked) {
                input.classList.remove('hidden');
                input.required = true;
            } else {
                input.classList.add('hidden');
                input.required = false;
                input.value = '';
            }

            updateTotal();
        });

    });

    // TOTAL WEIGHT CALCULATION
    document.querySelectorAll('.weight-input').forEach(input => {
        input.addEventListener('input', updateTotal);
    });

    function updateTotal() {
        let total = 0;

        document.querySelectorAll('.weight-input').forEach(input => {
            if (!input.classList.contains('hidden') && input.value) {
                total += parseInt(input.value);
            }
        });

        document.getElementById('totalWeight').innerText = total;
    }

});
</script>

@endsection