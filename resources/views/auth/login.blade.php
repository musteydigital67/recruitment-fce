@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="max-w-sm mx-auto bg-white border rounded-lg shadow-sm p-8">
        <h1 class="text-xl font-bold mb-1">Login</h1>
        <p class="text-sm text-slate-500 mb-6">Sign in to apply or check your application status.</p>

        @if ($errors->any())
            <div class="mb-4 rounded-md bg-red-50 border border-red-200 text-red-800 px-4 py-3 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
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

        <p class="text-sm text-slate-500 mt-6 text-center">
            Don't have an account? <a href="{{ route('register') }}" class="text-blue-800 hover:underline">Register</a>
        </p>
    </div>
@endsection
