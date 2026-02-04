<!DOCTYPE html>

<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'SMSM – Men of Valor - Login')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&amp;display=swap" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#0A2E5C",
                        "background-light": "#f6f6f8",
                        "background-dark": "#111121",
                        "accent": "#D4AF37"
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
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
</head>

<body class="font-display bg-background-light dark:bg-background-dark">
    <div class="relative flex min-h-screen w-full flex-col overflow-x-hidden group/design-root">
        <div class="flex-grow">
            <div class="flex flex-col lg:flex-row min-h-screen">
                <!-- Left Panel: Visual/Branding -->
                <div
                    class="w-full lg:w-1/2 bg-primary flex flex-col items-center justify-center p-8 lg:p-12 text-center text-white relative order-2 lg:order-1">
                    <div class="absolute inset-0 bg-black/20"></div>
                    <div class="z-10 flex flex-col items-center gap-8">
                        <div class="flex items-center gap-4">
                            <span class="material-symbols-outlined text-accent text-5xl">shield</span>
                            <h1 class="text-3xl font-bold">SMSM – Men of Valor</h1>
                        </div>
                        <h2 class="text-4xl lg:text-5xl font-black tracking-tight max-w-lg">Welcome, Man of Valor.</h2>
                        <div class="max-w-md">
                            <p class="text-lg font-normal leading-normal text-white/90 pb-3 pt-1">"Iron sharpens iron,
                                and one man sharpens another."</p>
                            <p class="text-base font-medium text-white/70">– Proverbs 27:17</p>
                        </div>
                    </div>
                </div>
                <!-- Right Panel: Action/Form (content from login.blade.php or other auth views) -->
                <div
                    class="w-full lg:w-1/2 bg-background-light dark:bg-background-dark flex items-center justify-center p-8 lg:p-12 order-1 lg:order-2">
                    <div class="w-full max-w-md space-y-8">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
