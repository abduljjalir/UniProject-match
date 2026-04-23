@extends('admin.layouts.app')

@section('content')

<div class="bg-[#1e293b] p-6 rounded-xl">

    <!-- PROFILE HEADER -->
    <div class="flex items-center gap-6 mb-6">

        <img 
            src="{{ $professor->image 
                ? asset('storage/'.$professor->image) 
                : 'https://ui-avatars.com/api/?name='.urlencode($professor->name) }}"
            class="w-24 h-24 rounded-full object-cover border-4 border-purple-500"
        >

        <div>
            <h2 class="text-2xl font-bold">{{ $professor->name }}</h2>

            <p class="text-gray-400">
                📧 {{ $professor->email ?? 'No email' }}
            </p>

            <p class="text-gray-400">
                🆔 Code: {{ $professor->code ?? 'N/A' }}
            </p>

            <p class="text-gray-400">
                📚 Speciality: {{ $professor->speciality->name ?? 'N/A' }}
            </p>
        </div>

    </div>

    <!-- PROJECTS -->
    <div class="bg-[#020617] p-4 rounded mb-6">

     <h3 class="text-lg mb-3">📚 Projects</h3>
      

      @forelse($professor->projects as $project)

       <div class="p-3 bg-[#0f172a] mb-2 rounded">
        <p class="text-purple-400 font-bold">
            {{ $project->title }}
        </p>

        <p class="text-sm text-gray-400">
            Max Students: {{ $project->max_students }}
        </p>
       </div>

       @empty
           <!-- #endregion --><p>No projects</p>
      @endforelse
   </div>

    <!-- ALLOCATIONS -->
    <div class="bg-[#020617] p-4 rounded">

        <h3 class="text-lg mb-3">👨‍🎓 Allocated Students</h3>

        @forelse($professor->allocations as $alloc)

            <div class="flex items-center gap-4 p-3 mb-2 bg-[#0f172a] rounded">

                <img 
                    src="{{ $alloc->student->image 
                        ? asset('storage/'.$alloc->student->image) 
                        : 'https://ui-avatars.com/api/?name='.urlencode($alloc->student->name) }}"
                    class="w-10 h-10 rounded-full object-cover border border-purple-500"
                >

                <div class="flex-1">

                    <p class="font-semibold">
                        {{ $alloc->student->name }}
                    </p>

                    <p class="text-sm text-gray-400">
                        🎓 {{ $alloc->project->title ?? 'No Project' }}
                    </p>

                </div>

            </div>

        @empty
            <p class="text-gray-400">No students allocated yet</p>
        @endforelse

    </div>

</div>

@endsection