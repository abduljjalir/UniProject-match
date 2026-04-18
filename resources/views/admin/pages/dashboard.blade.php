@extends('admin.layouts.app')

@section('content')
<div class="bg-[#1e293b] p-4 rounded-xl mb-4">
    <h4>⚠️ Alerts</h4>

    @forelse($alerts as $alert)
        <p class="text-red-400">{{ $alert }}</p>
    @empty
        <p class="text-green-400">✅ All students allocated</p>
    @endforelse
</div>

<!-- TOP CARDS -->
<div class="grid grid-cols-3 gap-4 mb-6">

    <div class="bg-[#1e293b] p-5 rounded-xl">
        <h3>👨‍🎓 Students</h3>
        <p class="text-3xl">{{ $studentCount }}</p>
    </div>

    <div class="bg-[#1e293b] p-5 rounded-xl">
        <h3>👨‍🏫 Professors</h3>
        <p class="text-3xl">{{ $professorCount }}</p>
    </div>

    <div class="bg-[#1e293b] p-5 rounded-xl">
        <h3>👨‍🔬 Specialities</h3>
        <p class="text-3xl">{{ $specialityCount }}</p>
    </div>

</div>
<div class="bg-[#1e293b] p-4 rounded mt-4">
    <h4>🔥 Most Applied Project</h4>
    <p>{{ $topProject->title ?? 'N/A' }}</p>
</div>

<div class="bg-[#1e293b] p-4 rounded mt-4">
    <h4>🏆 Top Student</h4>
    <p>{{ $topStudent->name ?? 'N/A' }}</p>
</div></br></br>

<!-- CHARTS -->
<div class="grid grid-cols-2 gap-6">

    <div class="bg-[#1e293b] p-4 rounded-xl">
        <canvas id="studentsChart"></canvas>
    </div>

    <div class="bg-[#1e293b] p-4 rounded-xl">
        <canvas id="projectsChart"></canvas>
    </div>

</div>

<script>
new Chart(document.getElementById('studentsChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($specialityNames) !!},
        datasets: [{
            label: 'Students per Speciality',
            data: {!! json_encode($studentCounts) !!}
        }]
    }
});

new Chart(document.getElementById('projectsChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($projectNames) !!},
        datasets: [{
            label: 'Most Applied Projects',
            data: {!! json_encode($projectCounts) !!}
        }]
    }
});
</script>

@endsection