@extends('admin.layouts.app')

@section('content')

<h2 class="text-xl mb-4">✏️ Edit Speciality</h2>

<form method="POST" action="{{ route('specialities.update', $speciality->id) }}">
    @csrf
    @method('PUT')

    <input name="name"
           value="{{ $speciality->name }}"
           class="w-full p-2 bg-gray-800 text-white rounded mb-3">

    <button class="bg-yellow-500 px-4 py-2 rounded">
        Update
    </button>

</form>

@endsection