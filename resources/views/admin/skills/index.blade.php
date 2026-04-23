@extends('admin.layouts.app')

@section('content')

<div class="max-w-3xl mx-auto bg-[#1e293b] p-6 rounded-xl shadow">

    <h2 class="text-xl font-semibold text-white mb-6">⚙️ Manage Skills</h2>

    <!-- ADD SKILL -->
    <form method="POST" action="{{ route('skills.store') }}" class="flex gap-3 mb-6">
        @csrf

        <input type="text" name="name" placeholder="New skill..."
            class="flex-1 p-2 rounded bg-[#020617] text-white border border-gray-600">

        <button class="bg-purple-600 px-4 py-2 rounded text-white hover:bg-purple-700">
            Add
        </button>
    </form>

    <!-- LIST -->
    <div class="space-y-3">

        @foreach($skills as $skill)
        <div class="flex justify-between items-center bg-[#020617] p-3 rounded">

            <!-- UPDATE -->
            <form method="POST" action="{{ route('skills.update', $skill->id) }}" class="flex gap-2 w-full">
                @csrf
                @method('PUT')

                <input type="text" name="name" value="{{ $skill->name }}"
                    class="flex-1 p-1 bg-transparent text-white border-b border-gray-600 focus:outline-none">

                <button class="text-blue-400">Update</button>
            </form>

            <!-- DELETE -->
            <form method="POST" action="{{ route('skills.destroy', $skill->id) }}">
                @csrf
                @method('DELETE')

                <button class="text-red-400 ml-3">Delete</button>
            </form>

        </div>
        @endforeach

    </div>

</div>

@endsection