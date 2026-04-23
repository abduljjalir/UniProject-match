@extends('admin.layouts.app')

@section('content')

<div class="max-w-2xl mx-auto bg-[#1e293b] p-6 rounded-2xl shadow">

    <h2 class="text-xl font-semibold mb-6 text-white">➕ Add Professor</h2>

    <form method="POST" action="{{ route('professors.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <!-- NAME -->
        <div>
            <label class="text-sm text-gray-400">Name</label>
            <input type="text" name="name"
                class="w-full p-2 mt-1 bg-[#020617] text-white rounded border border-gray-700">
        </div>

        <!-- CODE -->
        <div>
            <label class="text-sm text-gray-400">Professor Code</label>
            <input type="text" name="code"
                class="w-full p-2 mt-1 bg-[#020617] text-white rounded border border-gray-700">
        </div>
        <!-- EMAIL -->
        <div>

            <label class="text-sm text-gray-400">Email</label>
            <input type="email" name="email"
                class="w-full p-2 mt-1 bg-[#020617] text-white rounded border border-gray-700">
        </div>

        <!-- SPECIALITY -->
        <div>
            <label class="text-sm text-gray-400">Speciality</label>
            <select name="speciality_id"
                class="w-full p-2 mt-1 bg-[#020617] text-white rounded border border-gray-700">
                
                <option value="">Select Speciality</option>

                @foreach($specialities as $s)
                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach

            </select>
        </div>

        <!-- IMAGE -->
        <div>
            <label class="text-sm text-gray-400">Profile Image</label>
            <input type="file" name="image" class="w-full mt-1 text-gray-300">
        </div>

        <!-- BUTTON -->
        <button class="w-full bg-purple-600 py-2 rounded text-white">
            Save Professor
        </button>

    </form>

</div>

@endsection