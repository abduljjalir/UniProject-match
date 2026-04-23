@extends('admin.layouts.app')

@section('content')

<h2 class="text-xl mb-4">⚙ System Settings</h2>

@if(session('success'))
    <p class="text-green-400">{{ session('success') }}</p>
@endif
<a href="{{ route('skills.index') }}"
   class="block bg-purple-600 p-4 rounded text-white hover:bg-purple-700">
   🧠 Manage Skills
</a>

<form method="POST" action="/admin/settings">
    @csrf

    <label>Results Release Date</label>
    <input type="date" name="results_date"
        value="{{ $results_date }}"
        class="block mb-4 p-2 bg-gray-800 w-full">

    <label>Review Deadline Date</label>
    <input type="date" name="review_date"
        value="{{ $review_date }}"
        class="block mb-4 p-2 bg-gray-800 w-full">

    <button class="bg-purple-600 px-4 py-2 rounded">
        Save Settings
    </button>

</form>

@endsection