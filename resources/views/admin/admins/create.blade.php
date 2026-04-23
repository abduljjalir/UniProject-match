@extends('admin.layouts.app')

@section('content')

<h2 class="text-xl mb-4">➕ Add Admin</h2>

<form method="POST" action="/admin/admins" enctype="multipart/form-data">
    @csrf

    <input name="name" placeholder="Name"
        class="block mb-3 p-2 w-full bg-gray-800 text-white rounded">

    <!-- IMAGE -->
    <input type="file" name="image" onchange="previewImage(event)"
        class="block mb-3 p-2 w-full bg-gray-800 text-white rounded">

    <!-- PREVIEW -->
    <img id="preview" class="w-16 h-16 rounded-full mb-3 hidden"/>

    <input name="email" placeholder="Email"
        class="block mb-3 p-2 w-full bg-gray-800 text-white rounded">

    <input type="password" name="password" placeholder="Password"
        class="block mb-3 p-2 w-full bg-gray-800 text-white rounded">

    <button class="bg-purple-600 px-4 py-2 rounded text-white">
        Create Admin
    </button>
</form>

<script>
function previewImage(event){
    let reader = new FileReader();
    reader.onload = function(){
        let img = document.getElementById('preview');
        img.src = reader.result;
        img.classList.remove('hidden');
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>

@endsection