@extends('admin.layouts.app')

@section('content')

<div class="bg-[#1e293b] p-6 rounded-xl">

    <!-- PROFILE HEADER -->
    <div class="flex items-center gap-6 mb-6">

        <img src="{{ $student->image 
            ? asset('storage/'.$student->image) 
            : 'https://ui-avatars.com/api/?name='.$student->name}}"
            class="w-24 h-24 rounded-full object-cover border-4 border-purple-500">

        <div>
            <h2 class="text-2xl font-bold">{{ $student->name }}</h2>

            <p class="text-gray-400">
                ID: {{ $student->student_id ?? 'N/A' }}
            </p>

            <p>
                🎓 {{ $student->speciality->name ?? 'N/A' }}
            </p>

            <p>
                📊 CGPA: {{ $student->cgpa ?? 'N/A' }}
            </p>
        </div>

    </div>

    <!-- ALLOCATION -->
    <div class="bg-[#020617] p-4 rounded mb-6">
        <h3 class="text-lg mb-2">🎯 Allocation</h3>

        @if($student->allocation && $student->allocation->project)
            <p class="text-green-400">
                ✔ {{ $student->allocation->project->title }}
            </p>

            <p>
                👨‍🏫 {{ $student->allocation->project->professor->name ?? 'N/A' }}
            </p>
        @else
            <p class="text-red-400">❌ Not Allocated</p>
        @endif
    </div>

    <!-- SELECTED PROJECTS -->
    <div class="bg-[#020617] p-4 rounded mb-6">
        <h3 class="text-lg mb-2">📌 Selected Projects</h3>

        @forelse($student->selections ?? [] as $sel)

            <div class="mb-3">
                <p class="text-purple-400">
                    {{ $sel->project->title ?? 'No Project' }}
                </p>

                <ul class="ml-4 text-sm text-gray-300">

                    @forelse($sel->project->skills ?? [] as $skill)

                        <li>
                            🔹 {{ $skill->name }}
                            (Weight: {{ $skill->pivot->weight ?? 'N/A' }})
                        </li>

                    @empty
                        <li class="text-gray-500">No skills</li>
                    @endforelse

                </ul>
            </div>

        @empty
            <p class="text-gray-400">No selections</p>
        @endforelse
    </div>

    <!-- STUDENT SKILLS -->
    <div class="bg-[#020617] p-4 rounded">
        <h3 class="text-lg mb-2">🧠 Student Skills</h3>

        @forelse($student->skills ?? [] as $skill)
            <p>
                🔹 {{ $skill->name }}
                (Level: {{ $skill->pivot->level ?? 'N/A' }})
            </p>
        @empty
            <p class="text-gray-400">No skills</p>
        @endforelse
    </div>

</div>

@endsection