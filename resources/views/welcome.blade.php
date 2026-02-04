<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platform Multi-Role Login Portal</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
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
                    fontFamily: {
                        "display": ["Inter"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            font-size: 40px;
        }
        .hero-gradient {
            background: radial-gradient(circle at center, rgba(48, 140, 232, 0.15) 0%, rgba(17, 25, 33, 0) 70%);
        }
        .card-glow:hover {
            box-shadow: 0 0 20px rgba(48, 140, 232, 0.2);
            border-color: rgba(48, 140, 232, 0.5);
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-white min-h-screen flex flex-col">
    <!-- Navigation -->
    <header class="w-full border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="bg-primary p-2 rounded-lg">
                    {{-- <span class="material-symbols-outlined text-white !text-2xl">grid_view</span> --}}
                    <img src="{{ asset('images/sotm-logo.png') }}" alt="SMSM" class="h-8 w-auto object-contain" />
                </div>

            </div>
            <nav class="hidden md:flex items-center gap-8">
                <a class="text-sm font-medium hover:text-primary transition-colors" href="#">About</a>
                <a class="text-sm font-medium hover:text-primary transition-colors" href="#">Give to SOTM</a>
                @auth
                    @php
                        $dashboardRoute = auth()->user()->dashboardRoute();
                    @endphp
                    <a href="{{ route($dashboardRoute) }}" class="bg-primary text-white text-sm font-bold py-2.5 px-6 rounded-lg hover:bg-primary/90 transition-all">
                        Dashboard
                    </a>
                @else
                    <a href="#" class="bg-primary text-white text-sm font-bold py-2.5 px-6 rounded-lg hover:bg-primary/90 transition-all">
                        Contact Support
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="flex-grow flex flex-col items-center justify-center px-6 py-12 relative overflow-hidden">
        <!-- Subtle background decoration -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full hero-gradient pointer-events-none"></div>

        <!-- Hero Section -->
        <div class="text-center max-w-3xl mx-auto mb-16 relative z-10">
            <h1 class="text-4xl md:text-6xl font-black tracking-tight mb-6 leading-tight">
                Welcome to <span class="text-primary">Segun Obadje</span> Mentoring School for Men
            </h1>
            <p class="text-lg md:text-xl text-slate-600 dark:text-slate-400 font-normal leading-relaxed">
                Select your role to access your personalized dashboard and tools. Connect, learn, and grow with our community.
            </p>
        </div>

        <!-- Role Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl w-full relative z-10">
            <!-- Admin Card -->
            <div class="bg-white dark:bg-[#1a242f] border border-slate-200 dark:border-slate-800 p-8 rounded-xl transition-all duration-300 card-glow flex flex-col">
                <div class="mb-6 inline-flex items-center justify-center w-16 h-16 rounded-xl bg-primary/10 text-primary">
                    <span class="material-symbols-outlined">shield_with_heart</span>
                </div>
                <h3 class="text-2xl font-bold mb-3">Admin Portal</h3>
                <p class="text-slate-600 dark:text-slate-400 mb-8 flex-grow">
                    Manage users, cohorts, and platform settings. Oversee the entire ecosystem efficiently.
                </p>
                <a href="{{ route('admin.login') }}" class="w-full py-4 bg-primary text-white font-bold rounded-lg hover:bg-primary/90 transition-colors flex items-center justify-center gap-2 group">
                    Login as Admin
                    <span class="material-symbols-outlined !text-xl group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>

            <!-- Mentee Card -->
            <div class="bg-white dark:bg-[#1a242f] border border-slate-200 dark:border-slate-800 p-8 rounded-xl transition-all duration-300 card-glow flex flex-col scale-105 border-primary/30 shadow-xl shadow-primary/5">
                <div class="mb-6 inline-flex items-center justify-center w-16 h-16 rounded-xl bg-primary/10 text-primary">
                    <span class="material-symbols-outlined">school</span>
                </div>
                <h3 class="text-2xl font-bold mb-3">Mentee Portal</h3>
                <p class="text-slate-600 dark:text-slate-400 mb-8 flex-grow">
                    Access your courses, track progress, and connect with mentors to accelerate your career growth.
                </p>
                <a href="{{ route('mentee.login') }}" class="w-full py-4 bg-primary text-white font-bold rounded-lg hover:bg-primary/90 transition-colors flex items-center justify-center gap-2 group">
                    Login as Mentee
                    <span class="material-symbols-outlined !text-xl group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>

            <!-- Mentor Card -->
            <div class="bg-white dark:bg-[#1a242f] border border-slate-200 dark:border-slate-800 p-8 rounded-xl transition-all duration-300 card-glow flex flex-col">
                <div class="mb-6 inline-flex items-center justify-center w-16 h-16 rounded-xl bg-primary/10 text-primary">
                    <span class="material-symbols-outlined">lightbulb</span>
                </div>
                <h3 class="text-2xl font-bold mb-3">Mentor Portal</h3>
                <p class="text-slate-600 dark:text-slate-400 mb-8 flex-grow">
                    Guide your cohorts, review assignments, and manage sessions. Empower the next generation.
                </p>
                <a href="{{ route('mentor.login') }}" class="w-full py-4 bg-primary text-white font-bold rounded-lg hover:bg-primary/90 transition-colors flex items-center justify-center gap-2 group">
                    Login as Mentor
                    <span class="material-symbols-outlined !text-xl group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>
        </div>

        <!-- Additional Actions -->
        <div class="mt-16 text-center z-10">
            <p class="text-slate-500 dark:text-slate-500 text-sm mb-4">New to our platform?</p>
            <a href="{{ route('register') }}" class="inline-block px-8 py-3 rounded-full border border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors text-sm font-semibold">
                Register for an Account
            </a>
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full border-t border-slate-200 dark:border-slate-800 py-12">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="flex items-center gap-2 opacity-60">
                <span class="material-symbols-outlined !text-lg">copyright</span>
                <p class="text-sm font-medium">{{ date('Y') }} Segun Obadje Teaching Ministry (SOTM). All rights reserved.</p>
            </div>
            <div class="flex items-center gap-8">
                <a class="text-slate-500 hover:text-primary transition-colors" href="#">
                    <span class="sr-only">LinkedIn</span>
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"></path></svg>
                </a>
                <a class="text-slate-500 hover:text-primary transition-colors" href="#">
                    <span class="sr-only">Twitter</span>
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"></path></svg>
                </a>
                <a class="text-slate-500 hover:text-primary transition-colors" href="#">
                    <span class="sr-only">GitHub</span>
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"></path></svg>
                </a>
            </div>
            <div class="flex items-center gap-6 text-sm font-medium text-slate-500">
                <a class="hover:text-primary transition-colors" href="#">Terms of Service</a>
                <a class="hover:text-primary transition-colors" href="#">Privacy Policy</a>
            </div>
        </div>
    </footer>
</body>
</html>
