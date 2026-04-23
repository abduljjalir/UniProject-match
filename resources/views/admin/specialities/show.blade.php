@extends('admin.layouts.app')

@section('content')

<h2 class="text-2xl mb-4">{{ $speciality->name }}</h2>

<!-- STUDENTS -->
<div class="bg-[#1e293b] p-4 rounded mb-4">
    <h3>👨‍🎓 Students</h3>

    @foreach($speciality->students as $student)
        <div class="flex items-center gap-2 mt-2">
            <img src="{{ $student->image 
                ? asset('storage/'.$student->image) 
                : 'https://ui-avatars.com/api/?name='.$student->name }}"
                class="w-8 h-8 rounded-full">

            {{ $student->name }}
        </div>
    @endforeach
</div>

<!-- PROJECTS -->
<div class="bg-[#1e293b] p-4 rounded mb-4">
    <h3>💼 Projects</h3>

    @foreach($speciality->projects as $project)
        <p class="mt-2">{{ $project->title }}</p>
    @endforeach
</div>

<!-- PROFESSORS -->
<div class="bg-[#1e293b] p-4 rounded">
    <h3>👨‍🏫 Professors</h3>

    @foreach($speciality->professors as $prof)
        <p class="mt-2">{{ $prof->name }}</p>
    @endforeach
</div>

@endsection