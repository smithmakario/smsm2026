@extends('layouts.auth-split')

@section('title', 'SMSM – Men of Valor - Create Account')

@section('content')
    <!-- Header -->
    <div class="flex flex-col gap-2 text-left">
        <h1 class="text-slate-900 dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">
            Create an Account
        </h1>
        <h2 class="text-slate-600 dark:text-slate-400 text-base font-normal leading-normal">
            {{ __('Already have an account?') }}
            @if (Route::has('login'))
                <a class="underline text-accent hover:text-accent/80" href="{{ route('login') }}">{{ __('Sign in') }}</a>
            @endif
        </h2>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="rounded-lg bg-green-50 dark:bg-green-900/20 text-green-800 dark:text-green-200 text-sm p-4 mb-4">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div class="flex flex-col">
            <label for="name" class="text-slate-900 dark:text-white text-base font-medium leading-normal pb-2">{{ __('Name') }}</label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
                class="flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-slate-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary h-14 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-[15px] text-base font-normal leading-normal @error('name') border-red-500 dark:border-red-500 @enderror"
                placeholder="{{ __('Your name') }}"
            >
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-600 dark:text-red-400" />
        </div>

        <!-- Email -->
        <div class="flex flex-col">
            <label for="email" class="text-slate-900 dark:text-white text-base font-medium leading-normal pb-2">{{ __('Email') }}</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
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
                autocomplete="new-password"
                class="flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-slate-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary h-14 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-[15px] text-base font-normal leading-normal @error('password') border-red-500 dark:border-red-500 @enderror"
                placeholder="••••••••"
            >
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 dark:text-red-400" />
        </div>

        <!-- Confirm Password -->
        <div class="flex flex-col">
            <label for="password_confirmation" class="text-slate-900 dark:text-white text-base font-medium leading-normal pb-2">{{ __('Confirm Password') }}</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                class="flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-slate-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary h-14 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-[15px] text-base font-normal leading-normal"
                placeholder="••••••••"
            >
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600 dark:text-red-400" />
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            @if (Route::has('login'))
                <a class="text-sm text-slate-600 dark:text-slate-400 hover:text-accent dark:hover:text-accent/80 underline" href="{{ route('login') }}">
                    {{ __('Already registered? Sign in') }}
                </a>
            @endif
            <button type="submit" class="flex min-w-[84px] w-full sm:w-auto cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-primary text-white text-base font-bold leading-normal tracking-[0.015em] hover:bg-primary/90 transition-colors">
                <span class="truncate">{{ __('Register') }}</span>
            </button>
        </div>
    </form>

    <!-- Footer -->
    <p class="text-slate-500 dark:text-slate-400 text-sm font-normal leading-normal text-center">
        By continuing, you agree to our <a class="underline text-accent hover:text-accent/80" href="#">Terms of Service</a> and <a class="underline text-accent hover:text-accent/80" href="#">Privacy Policy</a>.
    </p>
@endsection
