<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('title', 'Mentor Collaboration Hub')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#308ce8",
                        "background-light": "#f6f7f8",
                        "background-dark": "#111921",
                    },
                    fontFamily: { "display": ["Lexend"] },
                    borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Lexend', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .active-nav { background-color: #243647; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #344d65; border-radius: 10px; }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-white min-h-screen flex flex-col">
<!-- Top Navigation Bar -->
<header class="flex items-center justify-between whitespace-nowrap border-b border-[#344d65] bg-background-light dark:bg-background-dark px-6 py-3 sticky top-0 z-50">
    <div class="flex items-center gap-8">
        <a href="{{ route('mentor.index') }}" class="flex items-center gap-3 text-primary">
            <img src="{{ asset('images/sotm-logo.png') }}" alt="SOTM" class="h-8 w-auto object-contain" />
            <h2 class="text-slate-900 dark:text-white text-lg font-bold leading-tight tracking-tight">MentorHub</h2>
        </a>
        <label class="hidden md:flex flex-col min-w-40 h-10 max-w-md">
            <div class="flex w-full flex-1 items-stretch rounded-lg h-full">
                <div class="text-slate-400 dark:text-[#93adc8] flex border-none bg-slate-100 dark:bg-[#243647] items-center justify-center pl-4 rounded-l-lg">
                    <span class="material-symbols-outlined">search</span>
                </div>
                <input class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-slate-900 dark:text-white focus:outline-0 focus:ring-0 border-none bg-slate-100 dark:bg-[#243647] focus:border-none h-full placeholder:text-slate-400 dark:placeholder:text-[#93adc8] px-4 rounded-l-none border-l-0 pl-2 text-sm font-normal leading-normal" placeholder="Search mentees, assignments..." value=""/>
            </div>
        </label>
    </div>
    <div class="flex flex-1 justify-end gap-4">
        <div class="flex gap-2">
            <a href="{{ route('mentor.index') }}" class="flex items-center justify-center rounded-lg h-10 w-10 bg-slate-100 dark:bg-[#243647] text-slate-600 dark:text-white hover:bg-primary/20 transition-colors">
                <span class="material-symbols-outlined">notifications</span>
            </a>
            <a href="{{ route('mentor.messages') }}" class="flex items-center justify-center rounded-lg h-10 w-10 bg-slate-100 dark:bg-[#243647] text-slate-600 dark:text-white hover:bg-primary/20 transition-colors">
                <span class="material-symbols-outlined">chat_bubble</span>
            </a>
        </div>
        <details class="relative">
            <summary class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 border-2 border-primary cursor-pointer list-none [&::-webkit-details-marker]:hidden flex items-center justify-center overflow-hidden" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAdIaKge4XLQAn8MtATQMMJJJaza0KF9A7VKEdwbawtjNF3qTp1LRFhYeTfBrB2iBCCKJAqFhFKasrcQVctjN6MuSKAUpdPU1NWJ-SzKJwqfyHg8eGdT6KTcFxdrjVQW9KstnSe3hG67f8dWd--eZ-6_2aqFD4oSZKGnq7sTjy3mv3RHd9fAlVrhxCo19oTO2DdZoJ4Y0TFRlT2G99yADBjULbTCd2xzdWud6ZyJWdiJnzy4zKqMMjEGvkRJPwGPuyobMOAwrwcO9I');">
            </summary>
            <div class="absolute right-0 mt-2 w-48 rounded-lg bg-white dark:bg-[#1a2632] border border-slate-200 dark:border-[#344d65] shadow-xl z-50">
                <div class="p-3 border-b border-slate-200 dark:border-[#344d65]">
                    <p class="text-slate-900 dark:text-white text-sm font-bold truncate">{{ auth()->user()?->full_name ?? 'Mentor' }}</p>
                    <p class="text-slate-500 dark:text-[#93adc8] text-xs truncate">{{ auth()->user()?->email ?? '' }}</p>
                </div>
                <form action="{{ route('mentor.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 text-left text-sm text-slate-600 dark:text-[#93adc8] hover:bg-slate-100 dark:hover:bg-[#243647] transition-colors rounded-b-lg">
                        <span class="material-symbols-outlined text-lg">logout</span> Sign Out
                    </button>
                </form>
            </div>
        </details>
    </div>
</header>

<div class="flex flex-1 overflow-hidden">
    <!-- Side Navigation -->
    <aside class="w-64 border-r border-[#344d65] bg-background-light dark:bg-background-dark hidden lg:flex flex-col p-4 gap-6 shrink-0">
        <div class="flex flex-col gap-2">
            <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ ($activeSidebar ?? '') === 'dashboard' ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-[#93adc8] hover:bg-slate-100 dark:hover:bg-[#243647]' }}" href="{{ route('mentor.index') }}">
                <span class="material-symbols-outlined">dashboard</span>
                <p class="text-sm font-medium">Dashboard</p>
            </a>
            <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ ($activeSidebar ?? '') === 'cohorts' ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-[#93adc8] hover:bg-slate-100 dark:hover:bg-[#243647]' }}" href="{{ route('mentor.cohorts') }}">
                <span class="material-symbols-outlined">groups</span>
                <p class="text-sm font-medium">Cohorts</p>
            </a>
            <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ ($activeSidebar ?? '') === 'assignments' ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-[#93adc8] hover:bg-slate-100 dark:hover:bg-[#243647]' }}" href="{{ route('mentor.assignments') }}">
                <span class="material-symbols-outlined">assignment</span>
                <p class="text-sm font-medium">Assignments</p>
            </a>
            <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ ($activeSidebar ?? '') === 'resources' ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-[#93adc8] hover:bg-slate-100 dark:hover:bg-[#243647]' }}" href="{{ route('mentor.resources') }}">
                <span class="material-symbols-outlined">library_books</span>
                <p class="text-sm font-medium">Resources</p>
            </a>
            <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ ($activeSidebar ?? '') === 'analytics' ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-[#93adc8] hover:bg-slate-100 dark:hover:bg-[#243647]' }}" href="{{ route('mentor.analytics') }}">
                <span class="material-symbols-outlined">monitoring</span>
                <p class="text-sm font-medium">Analytics</p>
            </a>
        </div>
        <div class="mt-auto flex flex-col gap-2">
            <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ ($activeSidebar ?? '') === 'settings' ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-[#93adc8] hover:bg-slate-100 dark:hover:bg-[#243647]' }}" href="{{ route('mentor.settings') }}">
                <span class="material-symbols-outlined">settings</span>
                <p class="text-sm font-medium">Settings</p>
            </a>
            <form action="{{ route('mentor.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 text-red-500 hover:bg-red-500/10 rounded-lg transition-colors cursor-pointer text-left">
                    <span class="material-symbols-outlined">logout</span>
                    <p class="text-sm font-medium">Logout</p>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col overflow-y-auto bg-slate-50 dark:bg-background-dark/50 min-w-0">
        @yield('content')
    </main>

    <!-- Right Panel (Calendar & Messages) -->
    @hasSection('sidebar')
        @yield('sidebar')
    @else
        @include('mentor.partials.sidebar-default')
    @endif
</div>
<footer class="border-t border-[#344d65] bg-background-light dark:bg-background-dark py-4 px-6">
    <p class="text-center text-slate-500 dark:text-[#93adc8] text-xs">© 2026, made with <span class="material-symbols-outlined text-red-500 align-middle text-sm inline-block" style="font-variation-settings: 'FILL' 1">favorite</span> by SOTM</p>
</footer>
</body>
</html>
