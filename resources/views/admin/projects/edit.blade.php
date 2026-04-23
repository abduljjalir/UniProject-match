@extends('admin.layouts.app')

@section('content')

<div class="max-w-3xl mx-auto bg-[#1e293b] p-6 rounded-2xl shadow">

    <h2 class="text-xl font-semibold mb-6 text-white">✏️ Edit Project</h2>

    <form method="POST" action="{{ route('projects.update', $project->id) }}" class="space-y-5">
        @csrf
        @method('PUT')

        <!-- TITLE -->
        <div>
            <label class="text-sm text-gray-400">Project Title</label>
            <input name="title" required value="{{ $project->title }}"
                class="w-full p-2 mt-1 bg-[#020617] text-white rounded border border-gray-700">
        </div>

        <!-- DESCRIPTION -->
        <div>
            <label class="text-sm text-gray-400">Description</label>
            <textarea name="description" required
                class="w-full p-2 mt-1 bg-[#020617] text-white rounded border border-gray-700">{{ $project->description }}</textarea>
        </div>

        <!-- GRID -->
        <div class="grid grid-cols-2 gap-4">

            <div>
                <label class="text-sm text-gray-400">Max Students</label>
                <input type="number" name="max_students" required value="{{ $project->max_students }}"
                    class="w-full p-2 mt-1 bg-[#020617] text-white rounded border border-gray-700">
            </div>

            <div>
                <label class="text-sm text-gray-400">Required Points</label>
                <input type="number" name="required_points" required value="{{ $project->required_points }}"
                    class="w-full p-2 mt-1 bg-[#020617] text-white rounded border border-gray-700">
            </div>

        </div>

        <!-- SPECIALITY -->
        <div>
            <label class="text-sm text-gray-400">Speciality</label>
            <select name="speciality_id" required
                class="w-full p-2 mt-1 bg-[#020617] text-white rounded border border-gray-700">

                @foreach($specialities as $s)
                    <option value="{{ $s->id }}"
                        {{ $project->speciality_id == $s->id ? 'selected' : '' }}>
                        {{ $s->name }}
                    </option>
                @endforeach

            </select>
        </div>

        <!-- PROFESSOR -->
        <div>
            <label class="text-sm text-gray-400">Professor</label>
            <select name="professor_id" required
                class="w-full p-2 mt-1 bg-[#020617] text-white rounded border border-gray-700">

                @foreach($professors as $p)
                    <option value="{{ $p->id }}"
                        {{ $project->professor_id == $p->id ? 'selected' : '' }}>
                        {{ $p->name }}
                    </option>
                @endforeach

            </select>
        </div>

        <!-- SKILLS -->
        <div>
            <label class="text-sm text-gray-400">Required Skills</label>

            <div class="grid grid-cols-2 gap-3 mt-3">

                @foreach($skills as $skill)

                    @php
                        $existing = $project->skills->firstWhere('id', $skill->id);
                        $checked = $existing ? true : false;
                        $weight = $existing ? $existing->pivot->weight : null;
                    @endphp

                    <div class="flex items-center justify-between bg-[#020617] p-2 rounded">

                        <div class="flex items-center gap-2">
                            <input type="checkbox"
                                   name="skills[]"
                                   value="{{ $skill->id }}"
                                   class="skill-checkbox"
                                   data-id="{{ $skill->id }}"
                                   {{ $checked ? 'checked' : '' }}>

                            <span class="text-white text-sm">{{ $skill->name }}</span>
                        </div>

                        <input type="number"
                               name="weights[{{ $skill->id }}]"
                               min="1"
                               max="100"
                               value="{{ $weight }}"
                               placeholder="W"
                               class="w-16 p-1 text-sm bg-[#020617] text-white border border-gray-600 rounded weight-input"
                               data-id="{{ $skill->id }}"
                               style="{{ $checked ? '' : 'display:none;' }}">
                    </div>

                @endforeach

            </div>
        </div>

        <!-- BUTTON -->
        <button class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded text-white w-full">
            Update Project
        </button>

    </form>

</div>

<script>
document.querySelectorAll('.skill-checkbox').forEach(cb => {

    cb.addEventListener('change', function () {

        let id = this.dataset.id;
        let input = document.querySelector(`.weight-input[data-id='${id}']`);

        if (this.checked) {
            input.style.display = 'block';
        } else {
            input.style.display = 'none';
            input.value = '';
        }
    });

});
</script>

@endsection