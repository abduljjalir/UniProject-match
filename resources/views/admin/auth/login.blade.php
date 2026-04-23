<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0f172a] flex items-center justify-center h-screen text-white">

<form method="POST" action="/admin/login" class="bg-[#020617] p-6 rounded w-80">
    @csrf

    <h2 class="text-xl mb-4 text-center">🔐 Admin Login</h2>

    @if(session('error'))
        <p class="text-red-400 mb-3">{{ session('error') }}</p>
    @endif

    <input name="email" placeholder="Email"
        class="block mb-3 p-2 w-full bg-gray-800 rounded">

    <input type="password" name="password" placeholder="Password"
        class="block mb-3 p-2 w-full bg-gray-800 rounded">

    <button class="bg-purple-600 w-full py-2 rounded">
        Login
    </button>
</form>

</body>
</html>