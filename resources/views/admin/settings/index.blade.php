@extends('admin.layouts.app')

@section('content')

<h2 class="text-xl mb-4">⚙ System Settings</h2>

@if(session('success'))
    <div class="bg-green-600 text-white p-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<!-- SKILLS -->
<a href="{{ route('skills.index') }}"
   class="block bg-purple-600 p-4 rounded text-white hover:bg-purple-700 mb-6">
   🧠 Manage Skills
</a>

<!-- SETTINGS FORM -->
<form method="POST" action="/admin/settings" class="mb-8">
    @csrf

    <label class="text-white">Results Release Date</label>
    <input type="date" name="results_date"
        value="{{ $results_date }}"
        class="block mb-4 p-2 bg-gray-800 w-full text-white">

    <label class="text-white">Review Deadline Date</label>
    <input type="date" name="review_date"
        value="{{ $review_date }}"
        class="block mb-4 p-2 bg-gray-800 w-full text-white">

    <button class="bg-purple-600 px-4 py-2 rounded text-white">
        Save Settings
    </button>
</form>

<!-- STUDENTS -->
<div class="bg-[#1e293b] p-4 rounded mb-6">
    <h3 class="text-white mb-4">👨‍🎓 Students</h3>

    @foreach($students as $s)
        <div class="flex justify-between items-center mb-2">
            <span class="text-white">{{ $s->name }}</span>

            <form method="POST" action="{{ route('settings.student.reset', $s->id) }}">
                @csrf
                <button class="bg-red-600 px-2 py-1 rounded text-white hover:bg-red-700">
                    Reset Password
                </button>
            </form>
        </div>
    @endforeach
</div>

<!-- PROFESSORS -->
<div class="bg-[#1e293b] p-4 rounded">
    <h3 class="text-white mb-4">👨‍🏫 Professors</h3>

    @foreach($professors as $p)
        <div class="flex justify-between items-center mb-2">
            <span class="text-white">{{ $p->name }}</span>

            <form method="POST" action="{{ route('settings.professor.reset', $p->id) }}">
                @csrf
                <button class="bg-red-600 px-2 py-1 rounded text-white hover:bg-red-700">
                    Reset Password
                </button>
            </form>
        </div>
    @endforeach
</div>

@endsection