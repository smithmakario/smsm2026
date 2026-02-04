<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Admin Analytics Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#308ce8",
                        "secondary": "#f4f4f4",
                        "background-light": "#f6f7f8",
                        "background-dark": "#111921",
                        "card-dark": "#111a22",
                        "border-dark": "#243647",
                        "text-muted": "#93adc8"
                    },
                    fontFamily: {
                        "display": ["Lexend"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        body {
            font-family: 'Lexend', sans-serif;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 flex flex-col bg-white dark:bg-[#111a22] border-r border-slate-200 dark:border-[#243647]">
            <div class="p-6 flex flex-col h-full justify-between">
                <div class="flex flex-col gap-8">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/sotm-logo.png') }}" alt="SOTM" class="h-9 w-auto object-contain" />
                        <div class="flex flex-col">
                            <h1 class="text-base font-bold leading-none">Admin Panel</h1>
                            <p class="text-slate-500 dark:text-[#93adc8] text-xs mt-1">LMS Management</p>
                        </div>
                    </div>
                    <nav class="flex flex-col gap-1">
                        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-primary/10 dark:bg-[#243647] text-primary dark:text-white group"
                            href="{{ route('admin.index') }}">
                            <span class="material-symbols-outlined"
                                style="font-variation-settings: 'FILL' 1">dashboard</span>
                            <span class="text-sm font-medium">Dashboard</span>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-[#93adc8] hover:bg-slate-100 dark:hover:bg-[#1a2632] transition-colors"
                            href="{{ route('admin.cohorts.index') }}">
                            <span class="material-symbols-outlined">groups</span>
                            <span class="text-sm font-medium">Cohorts</span>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-[#93adc8] hover:bg-slate-100 dark:hover:bg-[#1a2632] transition-colors"
                            href="{{ route('admin.users.index') }}">
                            <span class="material-symbols-outlined">group</span>
                            <span class="text-sm font-medium">Users</span>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-[#93adc8] hover:bg-slate-100 dark:hover:bg-[#1a2632] transition-colors"
                            href="{{ route('admin.logs') }}">
                            <span class="material-symbols-outlined">history</span>
                            <span class="text-sm font-medium">Audit Logs</span>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-[#93adc8] hover:bg-slate-100 dark:hover:bg-[#1a2632] transition-colors"
                            href="{{ route('admin.settings') }}">
                            <span class="material-symbols-outlined">settings</span>
                            <span class="text-sm font-medium">Settings</span>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-[#93adc8] hover:bg-slate-100 dark:hover:bg-[#1a2632] transition-colors"
                            href="{{ route('admin.users.create') }}">
                            <span class="material-symbols-outlined">person_add</span>
                            <span class="text-sm font-medium">Create User</span>
                        </a>
                    </nav>
                </div>
                <div class="mt-auto pt-6 flex flex-col gap-4 border-t border-slate-200 dark:border-[#243647]">
                    <button
                        class="flex w-full items-center justify-center rounded-lg bg-primary h-10 px-4 text-white text-sm font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                        <span class="truncate">Generate Report</span>
                    </button>
                    <form action="{{ route('admin.logout') }}" method="POST">@csrf
                        <button
                            class="flex w-full items-center justify-center rounded-lg bg-secondary h-10 px-4 text-black text-sm font-bold shadow-lg shadow-secondary/20 hover:bg-secondary/90 transition-all">
                            <span class="truncate">Sign Out</span>
                        </button>
                    </form>
                    <p class="text-center text-slate-500 dark:text-[#93adc8] text-xs pt-2">© 2026, made with <span class="material-symbols-outlined text-red-500 align-middle text-sm" style="font-variation-settings: 'FILL' 1">favorite</span> by SOTM</p>
                </div>
            </div>
        </aside>
        {{ $slot }}
    </div>
</body>

</html>
