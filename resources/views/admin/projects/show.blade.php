@extends('admin.layouts.app')

@section('content')

<div class="space-y-6">

    <!-- HEADER CARD -->
    <div class="bg-[#1e293b] p-6 rounded-2xl shadow flex justify-between items-center">

        <div>
            <h2 class="text-2xl font-bold text-white">{{ $project->title }}</h2>
            <p class="text-gray-400 mt-2">
                {{ $project->description }}
            </p>

            <div class="flex gap-4 mt-4 text-sm">
                <span class="bg-blue-600/20 text-blue-400 px-3 py-1 rounded">
                    🎓 {{ $project->speciality->name ?? 'N/A' }}
                </span>

                <span class="bg-green-600/20 text-green-400 px-3 py-1 rounded">
                    👥 {{ $project->max_students }} slots
                </span>
            </div>
        </div>

        <!-- PROFESSOR -->
        <div class="flex items-center gap-3">
            <img src="{{ $project->professor->image 
                ? asset('storage/'.$project->professor->image) 
                : 'https://ui-avatars.com/api/?name='.$project->professor->name }}"
                class="w-14 h-14 rounded-full object-cover border-2 border-purple-500">

            <div>
                <p class="text-white font-semibold">
                    {{ $project->professor->name }}
                </p>
                <small class="text-gray-400">Supervisor</small>
            </div>
        </div>

    </div>


    <!-- ALLOCATED STUDENTS -->
    <div class="bg-[#1e293b] p-5 rounded-2xl shadow">

        <h3 class="text-lg font-semibold mb-4">🎯 Allocated Students</h3>

        @forelse($project->allocations as $a)
            <div class="flex items-center gap-3 mb-3 bg-[#020617] p-3 rounded-lg hover:bg-[#334155] transition">

                <img src="{{ $a->student->image 
                    ? asset('storage/'.$a->student->image) 
                    : 'https://ui-avatars.com/api/?name='.$a->student->name }}"
                    class="w-10 h-10 rounded-full object-cover border border-gray-600">

                <div>
                    <p class="text-white">{{ $a->student->name }}</p>
                    <small class="text-gray-400">
                        CGPA: {{ $a->student->cgpa }}
                    </small>
                </div>

            </div>
        @empty
            <p class="text-gray-400">No students allocated</p>
        @endforelse

    </div>


    <!-- SELECTIONS -->
    <div class="bg-[#1e293b] p-5 rounded-2xl shadow">

        <h3 class="text-lg font-semibold mb-4">📌 Student Selections</h3>

        @forelse($project->selections as $s)
            <div class="flex items-center gap-3 mb-3 bg-[#020617] p-3 rounded-lg hover:bg-[#334155] transition">

                <img src="{{ $s->student->image 
                    ? asset('storage/'.$s->student->image) 
                    : 'https://ui-avatars.com/api/?name='.$s->student->name }}"
                    class="w-10 h-10 rounded-full object-cover border border-gray-600">

                <div>
                    <p class="text-white">{{ $s->student->name }}</p>
                </div>

            </div>
        @empty
            <p class="text-gray-400">No selections yet</p>
        @endforelse

    </div>

</div>

@endsection