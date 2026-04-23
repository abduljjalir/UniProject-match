@extends('admin.layouts.app')

@section('content')

<h2>👨‍🏫 Professors</h2>

<a href="{{ route('professors.create') }}">+ Add Professor</a>

<div class="grid grid-cols-3 gap-4 mt-4">

@foreach($professors as $professor)

<div class="bg-[#1e293b] p-4 rounded">

    <img 
        src="{{ $professor->image 
            ? asset('storage/'.$professor->image) 
            : 'https://ui-avatars.com/api/?name='.$professor->name }}"
        class="w-16 h-16 rounded-full mx-auto mb-2 object-cover"
    >

    <p class="text-center">{{ $professor->name }}</p>

    <div class="flex justify-center gap-2 mt-2">
        <a href="{{ route('professors.show', $professor->id) }}">View</a>
        <a href="{{ route('professors.edit', $professor->id) }}">Edit</a>
    </div>

</div>

@endforeach

</div>

@endsection