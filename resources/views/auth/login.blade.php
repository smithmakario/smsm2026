@extends('layouts.auth-split')

@section('title', 'SMSM – Men of Valor - Login')

@section('content')
    <!-- Session Status -->
    @if (session('status'))
        <div class="rounded-lg bg-green-50 dark:bg-green-900/20 text-green-800 dark:text-green-200 text-sm p-4 mb-4">
            {{ session('status') }}
        </div>
    @endif

    <!-- Header -->
    <div class="flex flex-col gap-2 text-left">
        <h1 class="text-slate-900 dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">
            Sign In
        </h1>
        <h2 class="text-slate-600 dark:text-slate-400 text-base font-normal leading-normal">Enter your details below to get started.</h2>
    </div>

    <!-- Social Login -->
    <div class="space-y-4">
        <a href="#" class="flex w-full min-w-[84px] cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-lg h-12 px-5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white text-base font-bold leading-normal tracking-[0.015em] hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
            <svg class="w-5 h-5" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><path d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z" fill="#FFC107"></path><path d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z" fill="#FF3D00"></path><path d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z" fill="#4CAF50"></path><path d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571l6.19,5.238C42.012,36.494,44,30.638,44,24C44,22.659,43.862,21.35,43.611,20.083z" fill="#1976D2"></path></svg>
            <span class="truncate">Continue with Google</span>
        </a>
    </div>

    <!-- Divider -->
    <div class="flex items-center">
        <hr class="w-full border-slate-200 dark:border-slate-700">
        <p class="px-4 text-sm font-medium text-slate-500 dark:text-slate-400">OR</p>
        <hr class="w-full border-slate-200 dark:border-slate-700">
    </div>

    <!-- Email/Password Login Form -->
    <form method="POST" action="{{ route($loginRoute ?? 'login') }}" class="space-y-4">
        @csrf

        <!-- Email -->
        <div class="flex flex-col">
            <label for="email" class="text-slate-900 dark:text-white text-base font-medium leading-normal pb-2">{{ __('Email') }}</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
                class="flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-slate-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary h-14 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-[15px] text-base font-normal leading-normal @error('email') border-red-500 dark:border-red-500 @enderror"
                placeholder="you@example.com"
            >
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600 dark:text-red-400" />
        </div>

        <!-- Password -->
        <div class="flex flex-col">
            <label for="password" class="text-slate-900 dark:text-white text-base font-medium leading-normal pb-2">{{ __('Password') }}</label>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                class="flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-slate-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary h-14 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-[15px] text-base font-normal leading-normal @error('password') border-red-500 dark:border-red-500 @enderror"
                placeholder="••••••••"
            >
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 dark:text-red-400" />
        </div>

        <!-- Remember Me -->


        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-300 dark:border-slate-600 text-primary shadow-sm focus:ring-primary/50">
                <label for="remember_me" class="ms-2 text-sm text-slate-600 dark:text-slate-400">{{ __('Remember me') }}</label>
            </div>
            @if (Route::has('password.request'))
                <a class="text-sm text-slate-600 dark:text-slate-400 hover:text-accent dark:hover:text-accent/80 underline" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <div class="flex items-center justify-between gap-4">
            @if (Route::has('register'))
            <a class="underline text-accent hover:text-accent/80" href="{{ route('register') }}">Create an Account</a>
            @endif
            <button type="submit" class="flex w-fit cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-primary text-white text-base font-bold leading-normal tracking-[0.015em] hover:bg-primary/90 transition-colors">
                <span class="truncate">{{ __('Log in') }}</span>
            </button>
        </div>
    </form>

    <!-- Footer Text -->
    <p class="text-slate-500 dark:text-slate-400 text-sm font-normal leading-normal text-center">By continuing, you agree to our <a class="underline text-accent hover:text-accent/80" href="#">Terms of Service</a> and <a class="underline text-accent hover:text-accent/80" href="#">Privacy Policy</a>.</p>
@endsection
