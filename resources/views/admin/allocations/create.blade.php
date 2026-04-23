@extends('admin.layouts.app')

@section('content')

<div class="bg-[#1e293b] p-6 rounded-xl max-w-4xl mx-auto">

    <h2 class="text-xl mb-6 text-white">🎯 Smart Manual Allocation</h2>

    <form method="POST" action="{{ route('allocations.store') }}">
        @csrf

        <!-- STUDENT -->
        <div class="mb-6">
            <label class="text-gray-400">Select Student</label>

            <select id="studentSelect"
                class="w-full p-2 rounded bg-[#0f172a] text-white">

                <option value="">Choose student</option>

                @foreach($students as $student)
                    <option value="{{ $student->id }}">
                        {{ $student->name }}
                    </option>
                @endforeach

            </select>
        </div>

        <!-- PROJECT OPTIONS -->
        <div id="projectArea"></div>

        <input type="hidden" name="student_id" id="student_id">
        <input type="hidden" name="project_id" id="project_id">

        <button class="bg-purple-600 px-4 py-2 rounded text-white mt-4">
            Assign Project
        </button>

    </form>
</div>

<script>

const students = @json($students);

document.getElementById('studentSelect').addEventListener('change', function () {

    let studentId = this.value;
    document.getElementById('student_id').value = studentId;

    let student = students.find(s => s.id == studentId);

    let html = '';

    //  FIX 1: no student selected
    if (!student) {
        document.getElementById('projectArea').innerHTML = '';
        return;
    }

    // FIX 2: no selections = STOP
    if (!student.selections || student.selections.length === 0) {
        document.getElementById('projectArea').innerHTML = `
            <div class="bg-[#0f172a] p-4 rounded text-red-400">
                ⚠️ This student has no project selections.
            </div>
        `;
        return;
    }

    student.selections.forEach(sel => {

        let project = sel.project;

        let cgpaScore = (student.cgpa / 20) * 100;

        let totalWeight = 0;
        let matchedWeight = 0;

        //  FIX 3: safe skill check
        if (project.skills && student.skills) {

            project.skills.forEach(skill => {

                totalWeight += skill.pivot.weight;

                if (student.skills.some(s => s.id == skill.id)) {
                    matchedWeight += skill.pivot.weight;
                }

            });
        }

        let skillScore = totalWeight > 0
            ? (matchedWeight / totalWeight) * 100
            : 0;

        let prefScore = (5- sel.preference_order) * 20;

        let finalScore =
            (cgpaScore * 0.6) +
            (skillScore * 0.3) +
            (prefScore * 0.1);

        html += `
            <div class="bg-[#0f172a] p-4 rounded mb-4 cursor-pointer hover:border hover:border-purple-500"
                 onclick="selectProject(${project.id})">

                <h3 class="text-white font-semibold">${project.title}</h3>

                <p class="text-gray-400">Preference: #${sel.preference_order}</p>
                <p class="text-gray-400">CGPA Score: ${cgpaScore.toFixed(1)}%</p>
                <p class="text-gray-400">Skill Match: ${skillScore.toFixed(1)}%</p>

                <p class="text-purple-400 font-bold">
                    Final Score: ${finalScore.toFixed(2)}
                </p>

            </div>
        `;
    });

    document.getElementById('projectArea').innerHTML = html;
});

function selectProject(projectId) {
    document.getElementById('project_id').value = projectId;
}

</script>

@endsection