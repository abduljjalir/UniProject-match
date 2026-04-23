@extends('admin.layouts.app')

@section('content')

<h2 class="text-xl mb-4">➕ Add Speciality</h2>

<form method="POST" action="{{ route('specialities.store') }}">
    @csrf

    <input name="name"
           placeholder="Speciality Name"
           class="w-full p-2 bg-gray-800 text-white rounded mb-3">

    <button class="bg-purple-600 px-4 py-2 rounded">
        Save
    </button>

</form>

@endsection