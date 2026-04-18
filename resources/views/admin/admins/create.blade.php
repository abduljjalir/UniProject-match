@extends('admin.layouts.app')

@section('content')

<h2 class="text-xl mb-4">➕ Add Admin</h2>

<form method="POST" action="/admin/admins">
    @csrf

    <input name="name" placeholder="Name" class="block mb-3 p-2 w-full bg-gray-800 text-white">
    <input name="email" placeholder="Email" class="block mb-3 p-2 w-full bg-gray-800 text-white">
    <input type="password" name="password" placeholder="Password" class="block mb-3 p-2 w-full bg-gray-800 text-white">

    <button class="bg-purple-600 px-4 py-2 rounded text-white">
        Create Admin
    </button>
</form>

@endsection