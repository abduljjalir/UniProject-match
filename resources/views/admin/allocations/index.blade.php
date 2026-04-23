@extends('admin.layouts.app')

@section('content')

<div class="bg-[#1e293b] p-6 rounded-xl">

    <div class="flex justify-between mb-4">
        <h2 class="text-xl">🎯 Allocations</h2>
        <a href="{{ route('allocations.create') }}"
           class="bg-purple-600 px-4 py-2 rounded">+ Allocate</a>
    </div>

    <div class="space-y-3">

        @foreach($allocations as $a)

        <div class="bg-[#0f172a] p-4 rounded flex justify-between items-center">

            <div class="flex items-center gap-4">

                <img 
                    src="{{ $a->student->image 
                        ? asset('storage/'.$a->student->image) 
                        : 'https://ui-avatars.com/api/?name='.$a->student->name }}"
                    class="w-12 h-12 rounded-full">

                <div>
                    <p>👨‍🎓 {{ $a->student->name }}</p>
                    <small class="text-gray-400">
                        {{ $a->project->title }}
                    </small>
                </div>

            </div>

            <form method="POST" action="{{ route('allocations.destroy', $a->id) }}">
                @csrf
                @method('DELETE')
                <button class="text-red-400 hover:text-red-600">Delete</button>
            </form>

        </div>

        @endforeach

    </div>

</div>

@endsection