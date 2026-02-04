<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mentee Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-100">
    <div class="min-h-screen">
        <nav class="bg-white shadow-sm border-b border-gray-200 px-6 py-4 flex items-center justify-between">
            <h1 class="text-xl font-semibold">Mentee Dashboard</h1>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600">{{ auth()->user()?->full_name ?? 'Mentee' }}</span>
                <form action="{{ route('mentee.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-gray-600 hover:text-gray-900 underline">Sign Out</button>
                </form>
            </div>
        </nav>
        <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-600">Welcome, {{ auth()->user()?->full_name ?? 'Mentee' }}. This is your mentee dashboard.</p>
            </div>
        </main>
    </div>
</body>
</html>
