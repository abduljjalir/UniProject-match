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
        <a href="/admin/selections" class="block p-2 hover:bg-gray-700 rounded">📥 Selections</a>
        <a href="/admin/allocations" class="block p-2 hover:bg-gray-700 rounded">📊 Allocations</a>
        <a href="/admin/settings" class="block p-2 hover:bg-gray-700 rounded">
       ⚙ Settings
       </a>
    </nav>

    <div class="mt-auto bg-gray-900 p-4 rounded-lg">
        @if(isset($allocationPercent))
            <h4>📊 Allocation Summary</h4>

            <div class="text-4xl font-bold mt-2 text-white">
                {{ $allocationPercent}}%
            </div>

            <p class="text-gray-400">Allocated</p>
        @endif
    </div>
</div>

<!-- MAIN -->
<div class="flex-1 p-5">

    <!-- TOPBAR -->
    @php $admin = auth('admin')->user(); @endphp

    <div class="flex justify-between items-center mb-6">

        <h2 class="text-2xl font-semibold">Dashboard</h2>

        <div class="flex items-center gap-4">

            <a href="/admin/admins/create" class="bg-purple-600 px-3 py-1 rounded text-sm">
                ➕ Admin
            </a>

            <a href="/admin/admins" class="bg-gray-700 px-3 py-1 rounded text-sm">
                ⚙ Admins
            </a>

            <!-- SEARCH -->
            <input type="text" placeholder="Search..."
                class="bg-[#1e293b] px-3 py-2 rounded">

            <!-- LIVE TIME -->
            <span id="time" class="text-sm text-gray-400"></span>

            <!-- NOTIFICATIONS -->
            <div class="relative">
                <button class="text-xl">🔔</button>
                <span class="absolute -top-1 -right-1 bg-red-600 text-xs px-1 rounded-full">
                    {{ count($recentSelections ?? []) }}
                </span>
            </div>

            <!-- ADMIN PROFILE (ONLY ONCE) -->
            <div class="flex items-center gap-2 bg-[#1e293b] px-2 py-1 rounded">

                <img src="{{ $admin && $admin->image
                    ? asset('storage/' . $admin->image)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($admin->name ?? 'Admin') }}"
                    class="w-8 h-8 rounded-full object-cover border border-gray-600">

                <span class="text-sm">{{ $admin->name ?? 'Admin' }}</span>

            </div>

            <!-- LOGOUT -->
            <a href="/admin/logout"
                class="bg-red-600 px-3 py-1 rounded text-sm hover:bg-red-700">
                🚪
            </a>

        </div>

    </div>

    <!-- PAGE CONTENT -->
    @yield('content')

</div>

<!-- LIVE CLOCK SCRIPT -->
<script>
function updateTime() {
    const now = new Date();
    document.getElementById("time").innerText = now.toLocaleTimeString();
}

setInterval(updateTime, 1000);
updateTime();
</script>

</body>
</html>