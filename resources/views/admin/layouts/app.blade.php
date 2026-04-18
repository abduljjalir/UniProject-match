<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>UniMatch Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="bg-[#0f172a] text-white flex">

<!-- LEFT SIDEBAR -->
<div class="w-64 h-screen bg-[#020617] p-5 flex flex-col">
    <h1 class="text-xl font-bold mb-8">🎓 UniMatch</h1>

    <nav class="space-y-3">
        <a href="/admin/dashboard" class="block p-2 bg-purple-600 rounded">🏠 Dashboard</a>
        <a href="/admin/students" class="block p-2 hover:bg-gray-700 rounded">👨‍🎓 Students</a>
        <a href="/admin/professors" class="block p-2 hover:bg-gray-700 rounded">👨‍🏫 Professors</a>
        <a href="/admin/projects" class="block p-2 hover:bg-gray-700 rounded">💼 Projects</a>
        <a href="/admin/specialities" class="block p-2 hover:bg-gray-700 rounded">🔬 Specialities</a>
        

    </nav>
<div class="mt-auto bg-gray-900 p-4 rounded-lg">
@if(isset($allocationPercent))
    <h4>📊 Allocation Summary</h4>

    <div class="text-4xl font-bold mt-2 text-white">
        {{ $allocationPercent }}%
    </div>

    <p class="text-gray-400">Allocated</p>
@endif

</div>   
</div>

<!-- MAIN -->
<div class="flex-1 p-5">

    <!-- TOPBAR -->
    <div class="flex justify-between items-center mb-6">

        <h2 class="text-2xl font-semibold">Dashboard</h2>

        <div class="flex items-center gap-4">
            <a href="/admin/admins/create" 
            class="bg-purple-600 px-3 py-1 rounded text-sm">
            ➕ Admin
          </a>

         <a href="/admin/admins" 
         class="bg-gray-700 px-3 py-1 rounded text-sm">
         ⚙ Admins
         </a>

            <input type="text" placeholder="Search..."
                class="bg-[#1e293b] px-3 py-2 rounded">

            <span id="time"></span>

            <button>🔔</button>

            <div class="flex items-center gap-2">
                <img src="/images/admin.jpg" class="w-8 h-8 rounded-full">
                <span>Admin</span>
            </div>

        </div>

    </div>

    @yield('content')

</div>
<!-- RIGHT PANEL -->
<div class="w-80 bg-[#020617] p-4 flex flex-col">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">📊 Live Panel</h3>
    </div>

    <!-- SWITCH BUTTONS -->
    <div class="flex gap-2 mb-3">
        <button onclick="showStudents()" class="bg-purple-600 px-3 py-1 rounded">👨‍🎓</button>
        <button onclick="showProfessors()" class="bg-gray-700 px-3 py-1 rounded">👨‍🏫</button>
    </div>

    <!-- SEARCH -->
    <input 
        type="text" 
        id="searchBox"
        placeholder="Search..."
        onkeyup="filterList()"
        class="bg-[#1e293b] p-2 rounded mb-3 w-full"
    >

    <!-- CONTENT -->
    <div id="panelContent" class="flex-1 overflow-y-auto pr-2 space-y-2"></div>

    <!-- RECENT ACTIVITY -->
    <div class="mt-6">
        <h4 class="mb-2">🔔 Recent Activity</h4>

        @foreach($recentSelections as $s)
            <div class="bg-[#1e293b] p-3 rounded mb-2">
                <p>👨‍🎓 {{ $s->student->name }}</p>
                <small class="text-gray-400">
                    Applied for {{ $s->project->title }}
                </small>
            </div>
        @endforeach
    </div>

</div>
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
                    projects += `<li class="text-xs text-purple-400">${sel.project ? sel.project.title : 'No Project'}</li>`;
                });
            }
            let allocation = item.allocation 
            ? `<span class="text-green-400 text-xs">✔ Assigned</span>`
            : `<span class="text-red-400 text-xs">❌ Not Assigned</span>`;


            html += `
            <div onclick="alert('Student: ${item.name}')" 
               class="bg-[#1e293b] p-3 mb-2 rounded cursor-pointer hover:bg-[#334155]">
            
                <p>👨‍🎓 ${item.name}</p>
                <small>CGPA: ${item.cgpa}</small>
                <div>${allocation}</div>

                <ul class="mt-2">
                    ${projects}
                </ul>
            </div>`;
        }
if(currentType === 'professors'){

    let projects = "";
    if(item.projects){
        item.projects.forEach(pr => {
            projects += `<li class="text-xs text-blue-400">${pr.title}</li>`;
        });
    }

    html += `
    <div onclick="alert('Professor: ${item.name}')" 
         class="bg-[#1e293b] p-3 mb-2 rounded cursor-pointer hover:bg-[#334155]">

        <p>👨‍🏫 ${item.name}</p>

        <ul class="mt-2">
            ${projects}
        </ul>

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

// default load
showStudents();

</script>
</body>
</html>