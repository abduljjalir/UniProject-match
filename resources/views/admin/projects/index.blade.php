@extends('admin.layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-semibold">💼 Projects</h2>

    <a href="{{ route('projects.create') }}"
       class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded-lg text-white text-sm shadow">
        ➕ Add Project
    </a>
</div>

<div class="bg-[#1e293b] rounded-xl shadow overflow-hidden">

    <table class="w-full text-sm text-left text-gray-300">
        <thead class="bg-[#020617] text-gray-400 uppercase text-xs">
            <tr>
                <th class="px-6 py-3">Project</th>
                <th class="px-6 py-3">Professor</th>
                <th class="px-6 py-3">Speciality</th>
                <th class="px-6 py-3">Capacity</th>
                <th class="px-6 py-3 text-center">Actions</th>
            </tr>
        </thead>

        <tbody>

        @forelse($projects as $project)
            <tr class="border-b border-gray-700 hover:bg-[#334155] transition">

                <!-- PROJECT INFO -->
                <td class="px-6 py-4">
                    <p class="font-semibold text-white">{{ $project->title }}</p>
                    <small class="text-gray-400">
                        {{ Str::limit($project->description, 60) }}
                    </small>
                </td>

                <!-- PROFESSOR -->
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center text-xs">
                            👨‍🏫
                        </div>
                        <span>{{ $project->professor->name ?? 'N/A' }}</span>
                    </div>
                </td>

                <!-- SPECIALITY -->
                <td class="px-6 py-4">
                    <span class="bg-blue-600/20 text-blue-400 px-2 py-1 rounded text-xs">
                        {{ $project->speciality->name ?? 'N/A' }}
                    </span>
                </td>

                <!-- CAPACITY -->
                <td class="px-6 py-4">
                    <span class="bg-green-600/20 text-green-400 px-2 py-1 rounded text-xs">
                        {{ $project->max_students }} students
                    </span>
                </td>

                <!-- ACTIONS -->
                <td class="px-6 py-4 text-center space-x-2">

                    <a href="{{ route('projects.show', $project->id) }}"
                       class="bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded text-xs">
                        View
                    </a>

                    <a href="{{ route('projects.edit', $project->id) }}"
                       class="bg-yellow-500 hover:bg-yellow-600 px-3 py-1 rounded text-xs">
                        Edit
                    </a>

                    <form action="{{ route('projects.destroy', $project->id) }}"
                          method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button
                            onclick="return confirm('Delete this project?')"
                            class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-xs">
                            Delete
                        </button>
                    </form>

                </td>

            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center py-6 text-gray-400">
                    No projects found
                </td>
            </tr>
        @endforelse

        </tbody>
    </table>

</div>

@endsection