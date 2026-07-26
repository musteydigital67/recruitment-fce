<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800">
    <div class="flex min-h-screen">
        <aside class="w-56 bg-blue-900 text-blue-100 flex-shrink-0">
            <div class="px-4 py-5 font-semibold text-white border-b border-blue-800">Admin Panel</div>
            <nav class="p-4 space-y-1 text-sm">
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded hover:bg-blue-800 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-800 text-white' : '' }}">Dashboard</a>
                <a href="{{ route('admin.positions.index') }}" class="block px-3 py-2 rounded hover:bg-blue-800 {{ request()->routeIs('admin.positions.*') ? 'bg-blue-800 text-white' : '' }}">Positions</a>
                <a href="{{ route('admin.applications.index') }}" class="block px-3 py-2 rounded hover:bg-blue-800 {{ request()->routeIs('admin.applications.*') ? 'bg-blue-800 text-white' : '' }}">Applications</a>
            </nav>
            <form method="POST" action="{{ route('admin.logout') }}" class="p-4">
                @csrf
                <button class="text-sm text-blue-200 hover:text-white">Log out</button>
            </form>
        </aside>

        <main class="flex-1 p-8">
            @if (session('status'))
                <div class="mb-6 rounded-md bg-green-50 border border-green-200 text-green-800 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>
