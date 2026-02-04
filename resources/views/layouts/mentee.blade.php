<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('title', 'Mentee Learning Journey')</title>
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
                        "surface-dark": "#1c2631",
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
        .fill-icon { font-variation-settings: 'FILL' 1; }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen">
<!-- Top Navigation Bar -->
<header class="sticky top-0 z-50 w-full border-b border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-background-dark/80 backdrop-blur-md px-4 md:px-10 py-3">
    <div class="max-w-[1440px] mx-auto flex items-center justify-between whitespace-nowrap">
        <div class="flex items-center gap-8">
            <a href="{{ route('mentee.index') }}" class="flex items-center gap-3 text-primary">
                <img src="{{ asset('images/sotm-logo.png') }}" alt="SOTM" class="h-8 w-auto object-contain" />
                <h2 class="text-slate-900 dark:text-white text-lg font-bold leading-tight tracking-tight">Mentee Portal</h2>
            </a>
            <nav class="hidden lg:flex items-center gap-6">
                <a class="text-sm font-medium transition-colors {{ ($activeNav ?? '') === 'dashboard' ? 'text-primary border-b-2 border-primary py-1 font-bold' : 'text-slate-600 dark:text-slate-400 hover:text-primary dark:hover:text-white' }}" href="{{ route('mentee.index') }}">Dashboard</a>
                <a class="text-sm font-medium transition-colors {{ ($activeNav ?? '') === 'journey' ? 'text-primary border-b-2 border-primary py-1 font-bold' : 'text-slate-600 dark:text-slate-400 hover:text-primary dark:hover:text-white' }}" href="{{ route('mentee.journey') }}">My Journey</a>
                <a class="text-sm font-medium transition-colors {{ ($activeNav ?? '') === 'messages' ? 'text-primary border-b-2 border-primary py-1 font-bold' : 'text-slate-600 dark:text-slate-400 hover:text-primary dark:hover:text-white' }}" href="{{ route('mentee.messages') }}">Messages</a>
                <a class="text-sm font-medium transition-colors {{ ($activeNav ?? '') === 'resources' ? 'text-primary border-b-2 border-primary py-1 font-bold' : 'text-slate-600 dark:text-slate-400 hover:text-primary dark:hover:text-white' }}" href="{{ route('mentee.resources') }}">Resources</a>
            </nav>
        </div>
        <div class="flex flex-1 justify-end gap-6 items-center">
            <label class="hidden md:flex flex-col min-w-40 h-10 max-w-64">
                <div class="flex w-full flex-1 items-stretch rounded-lg h-full bg-slate-100 dark:bg-surface-dark overflow-hidden">
                    <div class="text-slate-400 flex items-center justify-center pl-4">
                        <span class="material-symbols-outlined text-xl">search</span>
                    </div>
                    <input class="form-input w-full border-none bg-transparent focus:ring-0 text-sm placeholder:text-slate-400" placeholder="Search modules..." value=""/>
                </div>
            </label>
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-slate-400 cursor-pointer">notifications</span>
                <details class="relative">
                    <summary class="size-9 rounded-full bg-primary/20 border border-primary/30 flex items-center justify-center overflow-hidden hover:ring-2 hover:ring-primary/50 cursor-pointer list-none [&::-webkit-details-marker]:hidden">
                        <span class="material-symbols-outlined text-primary">person</span>
                    </summary>
                    <div class="absolute right-0 mt-2 w-48 rounded-lg bg-white dark:bg-surface-dark border border-slate-200 dark:border-slate-800 shadow-xl z-50">
                        <div class="p-3 border-b border-slate-200 dark:border-slate-800">
                            <p class="text-slate-900 dark:text-white text-sm font-bold truncate">{{ auth()->user()?->full_name ?? 'Mentee' }}</p>
                            <p class="text-slate-500 dark:text-slate-400 text-xs truncate">{{ auth()->user()?->email ?? '' }}</p>
                        </div>
                        <form action="{{ route('mentee.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 text-left text-sm text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors rounded-b-lg">
                                <span class="material-symbols-outlined text-lg">logout</span> Sign Out
                            </button>
                        </form>
                    </div>
                </details>
            </div>
        </div>
    </div>
</header>

<main class="max-w-[1440px] mx-auto flex flex-col lg:flex-row gap-8 p-4 md:p-10">
    <!-- Left Sidebar: Navigation -->
    <aside class="hidden xl:flex flex-col w-64 gap-6 shrink-0">
        <div class="bg-white dark:bg-surface-dark rounded-xl p-5 border border-slate-200 dark:border-slate-800">
            <div class="mb-6">
                <h1 class="text-slate-900 dark:text-white text-base font-bold">{{ auth()->user()?->cohort()?->name ?? 'My Cohort' }}</h1>
                <p class="text-slate-500 dark:text-slate-400 text-xs">{{ ($c = auth()->user()?->cohort()) ? $c->members->count() . ' members' : 'No cohort assigned' }}</p>
            </div>
            <nav class="flex flex-col gap-1">
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ ($activeSidebar ?? '') === 'home' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}" href="{{ route('mentee.index') }}">
                    <span class="material-symbols-outlined text-xl">home</span>
                    <span class="text-sm font-medium">Home</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ ($activeSidebar ?? '') === 'journey' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}" href="{{ route('mentee.journey') }}">
                    <span class="material-symbols-outlined text-xl fill-icon">route</span>
                    <span class="text-sm font-medium">Journey</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ ($activeSidebar ?? '') === 'cohort' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}" href="{{ route('mentee.cohort') }}">
                    <span class="material-symbols-outlined text-xl">group</span>
                    <span class="text-sm font-medium">Cohort</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ ($activeSidebar ?? '') === 'schedule' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}" href="{{ route('mentee.schedule') }}">
                    <span class="material-symbols-outlined text-xl">calendar_month</span>
                    <span class="text-sm font-medium">Schedule</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ ($activeSidebar ?? '') === 'settings' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}" href="{{ route('mentee.settings') }}">
                    <span class="material-symbols-outlined text-xl">settings</span>
                    <span class="text-sm font-medium">Settings</span>
                </a>
            </nav>
        </div>
        <div class="bg-primary/5 dark:bg-primary/10 rounded-xl p-5 border border-primary/20">
            <p class="text-slate-900 dark:text-white text-sm font-bold mb-3">Cohort Status</p>
            <div class="flex flex-col gap-2">
                <div class="flex justify-between text-xs font-medium">
                    <span class="text-slate-500 dark:text-slate-400">Average Progress</span>
                    <span class="text-primary">65%</span>
                </div>
                <div class="h-1.5 w-full bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                    <div class="h-full bg-primary rounded-full" style="width: 65%"></div>
                </div>
                <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-1 italic">Most members are on Module 2</p>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col gap-8 min-w-0">
        @yield('content')
    </div>

    <!-- Right Sidebar -->
    <aside class="w-full lg:w-80 flex flex-col gap-6 shrink-0">
        @hasSection('sidebar')
            @yield('sidebar')
        @else
            @include('mentee.partials.sidebar-default')
        @endif
    </aside>
</main>
<footer class="border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-background-dark/80 py-4 px-4 md:px-10">
    <p class="text-center text-slate-500 dark:text-[#93adc8] text-xs">© 2026, made with <span class="material-symbols-outlined text-red-500 align-middle text-sm inline-block" style="font-variation-settings: 'FILL' 1">favorite</span> by SOTM</p>
</footer>
</body>
</html>
