@extends('admin.layouts.app')

@section('content')

<h2 class="text-xl mb-4">👨‍🎓 Students</h2>

<a href="{{ route('students.create') }}" 
   class="bg-purple-600 px-4 py-2 rounded text-white">
   ➕ Add Student
</a>

<div class="mt-6 overflow-x-auto">
<table class="w-full text-left border-collapse">

    <thead>
        <tr class="bg-[#1e293b] text-gray-300">
            <th class="p-3">Image</th>
            <th class="p-3">Name</th>
            <th class="p-3">Student ID</th>
            <th class="p-3">CGPA</th>
            <th class="p-3">Speciality</th>
            <th class="p-3">Status</th>
            <th class="p-3">Selected Projects</th>
            <th class="p-3">Actions</th>
        </tr>
    </thead>

    <tbody>

    @foreach($students as $student)
    <tr class="border-b border-gray-700 hover:bg-[#1e293b]">

        <!-- IMAGE -->
        <td class="p-3">
            <img src="{{ $student->image 
                ? asset('storage/'.$student->image) 
                : 'https://ui-avatars.com/api/?name='.$student->name }}"
                class="w-10 h-10 rounded-full object-cover border-2 border-purple-500">
        </td>

        <!-- NAME (CLICKABLE PROFILE) -->
        <td class="p-3">
            <a href="{{ route('students.show', $student->id) }}" 
               class="text-purple-400 hover:underline">
                {{ $student->name }}
            </a>
        </td>

        <td class="p-3">{{ $student->student_id }}</td>
        <td class="p-3">{{ $student->cgpa }}</td>
        <td class="p-3">{{ $student->speciality->name ?? 'N/A' }}</td>

        <!-- STATUS -->
        <td class="p-3">
            @if($student->allocation)
                <span class="text-green-400">✔ Allocated</span>
            @else
                <span class="text-red-400">❌ Pending</span>
            @endif
        </td>

        <!-- PROJECTS -->
        <td class="p-3 text-sm">
            @forelse($student->selections->take(3) as $sel)
                <div class="text-purple-400">
                    {{ $sel->project->title ?? 'N/A' }}
                </div>
            @empty
                <span class="text-gray-400">None</span>
            @endforelse
        </td>

        <!-- ACTIONS -->
        <td class="p-3 space-x-2">

            <a href="{{ route('students.edit', $student->id) }}" 
               class="bg-blue-500 px-2 py-1 rounded text-white text-sm">
               Edit
            </a>

            <form action="{{ route('students.destroy', $student->id) }}" 
                  method="POST" 
                  class="inline">
                @csrf
                @method('DELETE')
                <button class="bg-red-500 px-2 py-1 rounded text-white text-sm">
                    Delete
                </button>
            </form>

        </td>

    </tr>
    @endforeach

    </tbody>
</table>
</div>

@endsection