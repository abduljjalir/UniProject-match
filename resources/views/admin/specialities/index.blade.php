@extends('admin.layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-semibold">🔬 Specialities</h2>

    <a href="{{ route('specialities.create') }}"
       class="bg-purple-600 px-4 py-2 rounded text-sm">
        ➕ Add Speciality
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

@forelse($specialities as $s)
    <div class="bg-[#1e293b] p-5 rounded-xl shadow hover:bg-[#334155] transition">

        <h3 class="text-white font-semibold text-lg">{{ $s->name }}</h3>

        <div class="flex justify-between mt-3 text-sm text-gray-400">
            <span>👨‍🎓 {{ $s->students_count }} Students</span>
            <span>💼 {{ $s->projects_count }} Projects</span>
        </div>

        <div class="mt-4 flex gap-2">

            <a href="{{ route('specialities.show', $s->id) }}"
               class="bg-blue-600 px-3 py-1 rounded text-xs">
                View
            </a>

            <a href="{{ route('specialities.edit', $s->id) }}"
               class="bg-yellow-500 px-3 py-1 rounded text-xs">
                Edit
            </a>

            <form action="{{ route('specialities.destroy', $s->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="bg-red-600 px-3 py-1 rounded text-xs">
                    Delete
                </button>
            </form>

        </div>

    </div>
@empty
    <p class="text-gray-400">No specialities found</p>
@endforelse

</div>

@endsection