@extends('admin.layouts.app')

@section('content')

<div class="max-w-3xl mx-auto bg-[#1e293b] p-6 rounded-2xl shadow-lg">

    <h2 class="text-2xl font-semibold mb-6 text-white">✏️ Edit Professor</h2>

    <form method="POST" action="{{ route('professors.update', $professor->id) }}" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        <!-- PROFILE IMAGE -->
        <div class="flex items-center gap-4">
            <img 
                src="{{ $professor->image 
                    ? asset('storage/'.$professor->image) 
                    : 'https://ui-avatars.com/api/?name='.$professor->name }}" 
                class="w-20 h-20 rounded-full object-cover border-2 border-purple-500">

            <input type="file" name="image" class="text-white">
        </div>

        <!-- NAME -->
        <div>
            <label class="text-sm text-gray-400">Full Name</label>
            <input type="text" name="name" value="{{ $professor->name }}"
                class="w-full mt-1 p-2 rounded bg-[#0f172a] text-white border border-gray-600 focus:border-purple-500 focus:outline-none">
        </div>

        <!-- EMAIL -->
        <div>
            <label class="text-sm text-gray-400">Email</label>
            <input type="email" name="email" value="{{ $professor->email }}"
                class="w-full mt-1 p-2 rounded bg-[#0f172a] text-white border border-gray-600 focus:border-purple-500 focus:outline-none">
        </div>

        <!-- CGPA -->
        <div>
            <label class="text-sm text-gray-400">CGPA</label>
            <input type="number" step="0.01" name="cgpa" value="{{ $professor->cgpa }}"
                class="w-full mt-1 p-2 rounded bg-[#0f172a] text-white border border-gray-600 focus:border-purple-500 focus:outline-none">
        </div>

        <!-- SPECIALITY -->
        <div>
            <label class="text-sm text-gray-400">Speciality</label>
            <select name="speciality_id"
                class="w-full mt-1 p-2 rounded bg-[#0f172a] text-white border border-gray-600 focus:border-purple-500 focus:outline-none">

                @foreach($specialities as $s)
                    <option value="{{ $s->id }}" 
                        {{ $professor->speciality_id == $s->id ? 'selected' : '' }}>
                        {{ $s->name }}
                    </option>
                @endforeach

            </select>
        </div>

        <!-- BUTTONS -->
        <div class="flex justify-between pt-4">
            <a href="{{ route('professors.index') }}"
               class="bg-gray-600 px-4 py-2 rounded text-white hover:bg-gray-700">
               ← Back
            </a>

            <button type="submit"
                class="bg-purple-600 px-6 py-2 rounded text-white hover:bg-purple-700">
                Update Professor
            </button>
        </div>

    </form>

</div>

@endsection
