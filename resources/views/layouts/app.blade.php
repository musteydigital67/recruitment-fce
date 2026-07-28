<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Recruitment Portal')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800">
    <header class="bg-blue-900 text-white">
        <div class="max-w-5xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('positions.index') }}" class="font-semibold text-lg">
                FCET Potiskum &mdash; Recruitment Portal
            </a>
            <div class="flex items-center gap-4">
                <a href="{{ route('positions.index') }}" class="text-sm text-blue-100 hover:text-white">Vacancies</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm text-blue-100 hover:text-white">My Applications</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-sm text-blue-100 hover:text-white">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-blue-100 hover:text-white">Login</a>
                    <a href="{{ route('register') }}" class="text-sm bg-white text-blue-900 px-3 py-1.5 rounded-md font-medium hover:bg-blue-50">Register</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-8">
        @if (session('status'))
            <div class="mb-6 rounded-md bg-green-50 border border-green-200 text-green-800 px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-md bg-red-50 border border-red-200 text-red-800 px-4 py-3 text-sm">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="border-t mt-16 py-6 text-center text-sm text-slate-500">
        Federal College of Education (Technical), Potiskum, Yobe State
    </footer>
</body>
</html>
