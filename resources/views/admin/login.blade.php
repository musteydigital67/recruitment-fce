<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen">
    <div class="bg-white border rounded-lg shadow-sm p-8 w-full max-w-sm">
        <h1 class="text-xl font-bold mb-1">Admin Login</h1>
        <p class="text-sm text-slate-500 mb-6">Recruitment Portal &mdash; Registrar's Office</p>

        @if ($errors->any())
            <div class="mb-4 rounded-md bg-red-50 border border-red-200 text-red-800 px-4 py-3 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full border rounded-md px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Password</label>
                <input type="password" name="password" required class="w-full border rounded-md px-3 py-2 text-sm">
            </div>
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="remember"> Remember me
            </label>
            <button class="w-full bg-blue-900 text-white rounded-md px-4 py-2 text-sm font-medium hover:bg-blue-800">
                Sign In
            </button>
        </form>
    </div>
</body>
</html>
