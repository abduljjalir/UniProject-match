@extends('admin.layouts.app')

@section('content')

<h2 class="text-xl mb-4">👨‍💼 Admin Management</h2>

<a href="/admin/admins/create" class="bg-purple-600 text-white px-4 py-2 rounded">
    + Add Admin
</a>

<table class="w-full mt-6 bg-[#1e293b] rounded">
    <thead>
        <tr class="text-left border-b border-gray-600">
            <th class="p-3">Name</th>
            <th class="p-3">Email</th>
            <th class="p-3">Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($admins as $admin)
        <tr class="border-b border-gray-700">
            <td class="p-3">{{ $admin->name }}</td>
            <td class="p-3">{{ $admin->email }}</td>
            <td class="p-3">
                <form method="POST" action="/admin/admins/{{ $admin->id }}">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-500">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection