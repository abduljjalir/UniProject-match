@extends('admin.layouts.app')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- ================= LEFT SIDE ================= -->
    <div class="lg:col-span-2">

        <!-- ALERTS -->
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

        <!-- HIGHLIGHTS -->
        <div class="bg-[#1e293b] p-4 rounded-xl mb-4">
            <h4>🔥 Most Applied Project</h4>
            <p>{{ $topProject->title ?? 'N/A' }}</p>
        </div>

        <div class="bg-[#1e293b] p-4 rounded-xl mb-6">
            <h4>🏆 Top Student</h4>
            <p>{{ $topStudent->name ?? 'N/A' }}</p>
        </div>

        <!-- CHARTS -->
        <div class="grid grid-cols-2 gap-6">

            <div class="bg-[#1e293b] p-4 rounded-xl">
                <canvas id="studentsChart"></canvas>
            </div>

            <div class="bg-[#1e293b] p-4 rounded-xl">
                <canvas id="projectsChart"></canvas>
            </div>

        </div>

        <!-- ================= BELOW CHARTS ================= -->

        <div class="grid grid-cols-2 gap-6 mt-6">

            <!-- RECENT SELECTIONS -->
            <div class="bg-[#1e293b] p-4 rounded-xl">
                <div class="flex justify-between items-center mb-3">
                    <h4>📥 Recent Selections</h4>
                    <a href="/admin/selections" class="text-purple-400 text-sm">View All →</a>
                </div>

                @forelse($recentSelections as $s)
                    <div class="flex items-center gap-3 mb-3">

                        <img src="{{ $s->student->image 
                            ? asset('storage/'.$s->student->image) 
                            : 'https://ui-avatars.com/api/?name='.$s->student->name }}"
                            class="w-8 h-8 rounded-full">

                        <div>
                            <p class="text-sm">{{ $s->student->name }}</p>
                            <small class="text-gray-400">
                                {{ $s->project->title ?? 'N/A' }}
                            </small>
                        </div>

                    </div>
                @empty
                    <p class="text-gray-400 text-sm">No selections yet</p>
                @endforelse
            </div>

            <!-- REMINDERS -->
            <div class="bg-[#1e293b] p-4 rounded-xl">
                <h4 class="mb-3">⏰ Reminders</h4>

                <div class="mb-3">
                    <p>📢 Results Announcement</p>
                    <small class="text-purple-400">{{ $daysToResults }} days left</small>
                </div>

                <div>
                    <p>📊 Allocation Review</p>
                    <small class="text-purple-400">{{ $daysToReview }} days left</small>
                </div>
            </div>

        </div>

        <!-- RECENT ALLOCATIONS -->
        <div class="bg-[#1e293b] p-4 rounded-xl mt-6">

            <div class="flex justify-between items-center mb-3">
                <h4>📊 Recent Allocations</h4>
                <a href="/admin/allocations" class="text-purple-400 text-sm">View All →</a>
            </div>

            @forelse($recentAllocations as $a)
                <div class="flex items-center gap-3 mb-3">

                    <img src="{{ $a->student->image 
                        ? asset('storage/'.$a->student->image) 
                        : 'https://ui-avatars.com/api/?name='.$a->student->name }}"
                        class="w-8 h-8 rounded-full">

                    <div>
                        <p class="text-sm">{{ $a->student->name }}</p>
                        <small class="text-gray-400">
                            {{ $a->project->title ?? 'N/A' }}
                        </small>
                    </div>

                </div>
            @empty
                <p class="text-gray-400 text-sm">No allocations yet</p>
            @endforelse

        </div>

    </div>

    <!-- ================= RIGHT PANEL ================= -->
    <div class="bg-[#020617] p-4 rounded-xl flex flex-col">

        <h3 class="text-lg font-semibold mb-4">📊 Live Panel</h3>

        <!-- SWITCH -->
        <div class="flex gap-2 mb-3">
            <button onclick="showStudents()" class="bg-purple-600 px-3 py-1 rounded">👨‍🎓</button>
            <button onclick="showProfessors()" class="bg-gray-700 px-3 py-1 rounded">👨‍🏫</button>
        </div>

        <!-- SEARCH -->
        <input type="text" id="searchBox"
            placeholder="Search..."
            onkeyup="filterList()"
            class="bg-[#1e293b] p-2 rounded mb-3 w-full">

        <!-- CONTENT -->
        <div id="panelContent" class="flex-1 overflow-y-auto space-y-2"></div>

        <!-- RECENT ACTIVITY -->
        <div class="mt-6">
            <h4 class="mb-2">🔔 Recent Activity</h4>

            @forelse($recentSelections as $s)
                <div class="bg-[#1e293b] p-3 rounded mb-2">
                    <p>👨‍🎓 {{ $s->student->name }}</p>
                    <small class="text-gray-400">
                        {{ $s->project->title ?? 'N/A' }}
                    </small>
                </div>
            @empty
                <p class="text-gray-400 text-sm">No recent activity</p>
            @endforelse
        </div>

    </div>

</div>

<!-- ================= CHART JS ================= -->
<script>
new Chart(document.getElementById('studentsChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($specialityNames ?? []) !!},
        datasets: [{
            label: 'Students per Speciality',
            data: {!! json_encode($studentCounts ?? []) !!}
        }]
    }
});

new Chart(document.getElementById('projectsChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($projectNames ?? []) !!},
        datasets: [{
            label: 'Most Applied Projects',
            data: {!! json_encode($projectCounts ?? []) !!}
        }]
    }
});
</script>

<!-- ================= RIGHT PANEL JS ================= -->
<script>

const students = @json($students ?? []);
const professors = @json($professors ?? []);

let currentData = [];
let currentType = 'students';

function showStudents(){
    currentType = 'students';
    currentData = students;
    renderList();
}

function showProfessors(){
    currentType = 'professors';
    currentData = professors;
    renderList();
}

function renderList(){
    let html = "";

    currentData.forEach(item => {

        if(currentType === 'students'){

            let projects = "";

            if(item.selections){
                item.selections.forEach(sel => {
                    projects += `<li class="text-xs text-purple-400">
                        ${sel.project ? sel.project.title : 'No Project'}
                    </li>`;
                });
            }

            let allocation = item.allocation
                ? `<span class="text-green-400 text-xs">✔ Assigned</span>`
                : `<span class="text-red-400 text-xs">❌ Not Assigned</span>`;

            let image = item.image
                ? `/storage/${item.image}`
                : `https://ui-avatars.com/api/?name=${encodeURIComponent(item.name)}`;

            html += `
            <div onclick="window.location='/admin/students/${item.id}'"
              class="bg-[#1e293b] p-3 rounded cursor-pointer hover:bg-[#334155] flex gap-3 items-center">

                <img src="${image}" class="w-10 h-10 rounded-full object-cover border-2 border-purple-500">

                <div>
                    <p>👨‍🎓 ${item.name}</p>
                    <small>CGPA: ${item.cgpa}</small>
                    <div>${allocation}</div>
                    <ul class="mt-2">${projects}</ul>
                </div>

            </div>`;
        }

        if(currentType === 'professors'){

            let projects = "";

            if(item.projects){
                item.projects.forEach(pr => {
                    projects += `<li class="text-xs text-blue-400">${pr.title}</li>`;
                });
            }
            let image = item.image
    ? (item.image.startsWith('http')
        ? item.image
        : `/storage/${item.image}`)
    : `https://ui-avatars.com/api/?name=${encodeURIComponent(item.name)}`;
      html += `
     <div onclick="window.location='/admin/professors/${item.id}'"
     class="bg-[#1e293b] p-3 rounded cursor-pointer hover:bg-[#334155] flex gap-3 items-center">

       <img src="${image}" 
         class="w-10 h-10 rounded-full object-cover border-2 border-purple-500">

      <div>
        <p>👨‍🏫 ${item.name}</p>

        <ul class="mt-2">
            ${projects}
        </ul>
      </div>

</div>`;


        }

    });

    document.getElementById('panelContent').innerHTML = html;
}

function filterList(){
    let keyword = document.getElementById('searchBox').value.toLowerCase();

    let filtered = currentData.filter(item =>
        item.name.toLowerCase().includes(keyword)
    );

    let temp = currentData;
    currentData = filtered;
    renderList();
    currentData = temp;
}

// default
showStudents();

</script>

@endsection