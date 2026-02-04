@extends('layouts.auth-split')

@section('title', 'SMSM – Men of Valor - Forgot Password')

@section('content')
    <!-- Header -->
    <div class="flex flex-col gap-2 text-left">
        <h1 class="text-slate-900 dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">
            Forgot your password?
        </h1>
        <h2 class="text-slate-600 dark:text-slate-400 text-base font-normal leading-normal">
            {{ __('No problem. Just let us know your email address and we will email you a password reset link.') }}
        </h2>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="rounded-lg bg-green-50 dark:bg-green-900/20 text-green-800 dark:text-green-200 text-sm p-4">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
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
                autocomplete="email"
                class="flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-slate-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary h-14 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-[15px] text-base font-normal leading-normal @error('email') border-red-500 dark:border-red-500 @enderror"
                placeholder="you@example.com"
            >
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600 dark:text-red-400" />
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            @if (Route::has('login'))
                <a class="text-sm text-slate-600 dark:text-slate-400 hover:text-accent dark:hover:text-accent/80 underline" href="{{ route('login') }}">
                    {{ __('Back to sign in') }}
                </a>
            @endif
            <button type="submit" class="flex min-w-[84px] w-full sm:w-auto cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-primary text-white text-base font-bold leading-normal tracking-[0.015em] hover:bg-primary/90 transition-colors">
                <span class="truncate">{{ __('Email Password Reset Link') }}</span>
            </button>
        </div>
    </form>

    <!-- Footer -->
    <p class="text-slate-500 dark:text-slate-400 text-sm font-normal leading-normal text-center">
        By continuing, you agree to our <a class="underline text-accent hover:text-accent/80" href="#">Terms of Service</a> and <a class="underline text-accent hover:text-accent/80" href="#">Privacy Policy</a>.
    </p>
@endsection
