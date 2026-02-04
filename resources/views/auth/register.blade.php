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

    <!-- Progress Steps -->
    <div class="flex items-center gap-2 mb-6">
        <div class="flex-1 h-1.5 rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden">
            <div id="progress-bar" class="h-full bg-primary transition-all duration-300" style="width: 33%"></div>
        </div>
        <span id="step-indicator" class="text-xs font-semibold text-slate-500 dark:text-slate-400">Step 1 of 3</span>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="rounded-lg bg-green-50 dark:bg-green-900/20 text-green-800 dark:text-green-200 text-sm p-4 mb-4">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" id="register-form" class="space-y-4">
        @csrf

        <!-- Step 1: Account -->
        <div id="step-1" class="wizard-step space-y-4">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Account Information</h3>
            <div class="flex flex-col">
                <label for="first_name" class="text-slate-900 dark:text-white text-base font-medium leading-normal pb-2">{{ __('First Name') }}</label>
                <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus autocomplete="given-name"
                    class="flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-slate-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary h-14 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-[15px] text-base font-normal leading-normal @error('first_name') border-red-500 dark:border-red-500 @enderror"
                    placeholder="{{ __('First name') }}">
                <x-input-error :messages="$errors->get('first_name')" class="mt-2 text-red-600 dark:text-red-400" />
            </div>
            <div class="flex flex-col">
                <label for="last_name" class="text-slate-900 dark:text-white text-base font-medium leading-normal pb-2">{{ __('Last Name') }}</label>
                <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required autocomplete="family-name"
                    class="flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-slate-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary h-14 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-[15px] text-base font-normal leading-normal @error('last_name') border-red-500 dark:border-red-500 @enderror"
                    placeholder="{{ __('Last name') }}">
                <x-input-error :messages="$errors->get('last_name')" class="mt-2 text-red-600 dark:text-red-400" />
            </div>
            <div class="flex flex-col">
                <label for="email" class="text-slate-900 dark:text-white text-base font-medium leading-normal pb-2">{{ __('Email') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                    class="flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-slate-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary h-14 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-[15px] text-base font-normal leading-normal @error('email') border-red-500 dark:border-red-500 @enderror"
                    placeholder="you@example.com">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600 dark:text-red-400" />
            </div>
            <div class="flex flex-col">
                <label for="password" class="text-slate-900 dark:text-white text-base font-medium leading-normal pb-2">{{ __('Password') }}</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-slate-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary h-14 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-[15px] text-base font-normal leading-normal @error('password') border-red-500 dark:border-red-500 @enderror"
                    placeholder="••••••••">
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 dark:text-red-400" />
            </div>
            <div class="flex flex-col">
                <label for="password_confirmation" class="text-slate-900 dark:text-white text-base font-medium leading-normal pb-2">{{ __('Confirm Password') }}</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    class="flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-slate-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary h-14 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-[15px] text-base font-normal leading-normal"
                    placeholder="••••••••">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600 dark:text-red-400" />
            </div>
        </div>

        <!-- Step 2: Personal & Work -->
        <div id="step-2" class="wizard-step hidden space-y-4">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Personal & Work</h3>
            <div class="flex flex-col">
                <label for="marital_status" class="text-slate-900 dark:text-white text-base font-medium leading-normal pb-2">Marital Status</label>
                <select id="marital_status" name="marital_status"
                    class="flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-slate-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary h-14 p-[15px] text-base font-normal leading-normal @error('marital_status') border-red-500 @enderror">
                    <option value="">Select Marital Status</option>
                    @foreach($maritalStatuses ?? [] as $value => $label)
                        <option value="{{ $value }}" {{ old('marital_status') == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('marital_status')" class="mt-2 text-red-600 dark:text-red-400" />
            </div>
            <div class="flex flex-col">
                <label for="occupation_category" class="text-slate-900 dark:text-white text-base font-medium leading-normal pb-2">Occupation Category</label>
                <select id="occupation_category" name="occupation_category"
                    class="flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-slate-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary h-14 p-[15px] text-base font-normal leading-normal @error('occupation_category') border-red-500 @enderror">
                    <option value="">Select Occupation Category</option>
                    @foreach($occupationCategories ?? [] as $value => $label)
                        <option value="{{ $value }}" {{ old('occupation_category') == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('occupation_category')" class="mt-2 text-red-600 dark:text-red-400" />
            </div>
            <div class="flex flex-col">
                <label for="occupation" class="text-slate-900 dark:text-white text-base font-medium leading-normal pb-2">Occupation</label>
                <input id="occupation" type="text" name="occupation" value="{{ old('occupation') }}" autocomplete="organization-title"
                    class="flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-slate-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary h-14 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-[15px] text-base font-normal leading-normal @error('occupation') border-red-500 @enderror"
                    placeholder="e.g. Software Engineer">
                <x-input-error :messages="$errors->get('occupation')" class="mt-2 text-red-600 dark:text-red-400" />
            </div>
        </div>

        <!-- Step 3: Location -->
        <div id="step-3" class="wizard-step hidden space-y-4">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Location & Church</h3>
            <div class="flex flex-col">
                <label for="church" class="text-slate-900 dark:text-white text-base font-medium leading-normal pb-2">Church</label>
                <input id="church" type="text" name="church" value="{{ old('church') }}"
                    class="flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-slate-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary h-14 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-[15px] text-base font-normal leading-normal @error('church') border-red-500 @enderror"
                    placeholder="Church name">
                <x-input-error :messages="$errors->get('church')" class="mt-2 text-red-600 dark:text-red-400" />
            </div>
            <div class="flex flex-col">
                <label for="country" class="text-slate-900 dark:text-white text-base font-medium leading-normal pb-2">Country</label>
                <input id="country" type="text" name="country" value="{{ old('country', 'Nigeria') }}" readonly
                    class="flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-slate-900 dark:text-white border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800/50 h-14 p-[15px] text-base font-normal leading-normal opacity-90">
            </div>
            <div class="flex flex-col">
                <label for="state" class="text-slate-900 dark:text-white text-base font-medium leading-normal pb-2">State</label>
                <select id="state" name="state"
                    class="flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-slate-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary h-14 p-[15px] text-base font-normal leading-normal @error('state') border-red-500 @enderror">
                    <option value="">Select State</option>
                    @foreach($nigerianStates ?? [] as $state)
                        <option value="{{ $state }}" {{ old('state') == $state ? 'selected' : '' }}>{{ $state }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('state')" class="mt-2 text-red-600 dark:text-red-400" />
            </div>
            <div class="flex flex-col">
                <label for="city" class="text-slate-900 dark:text-white text-base font-medium leading-normal pb-2">City</label>
                <input id="city" type="text" name="city" value="{{ old('city') }}"
                    class="flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-slate-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary h-14 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-[15px] text-base font-normal leading-normal @error('city') border-red-500 @enderror"
                    placeholder="City">
                <x-input-error :messages="$errors->get('city')" class="mt-2 text-red-600 dark:text-red-400" />
            </div>
        </div>

        <!-- Wizard Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 pt-4">
            <button type="button" id="btn-prev" class="hidden flex-1 flex items-center justify-center rounded-lg h-12 px-5 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 text-base font-bold hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                ← Back
            </button>
            <button type="button" id="btn-next" class="flex-1 flex items-center justify-center rounded-lg h-12 px-5 bg-primary text-white text-base font-bold hover:bg-primary/90 transition-colors">
                Next →
            </button>
            <button type="submit" id="btn-submit" class="hidden flex-1 flex items-center justify-center rounded-lg h-12 px-5 bg-primary text-white text-base font-bold hover:bg-primary/90 transition-colors">
                {{ __('Register') }}
            </button>
        </div>
    </form>

    <!-- Footer -->
    <p class="text-slate-500 dark:text-slate-400 text-sm font-normal leading-normal text-center mt-6">
        By continuing, you agree to our <a class="underline text-accent hover:text-accent/80" href="#">Terms of Service</a> and <a class="underline text-accent hover:text-accent/80" href="#">Privacy Policy</a>.
    </p>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('register-form');
            const steps = [1, 2, 3];
            let currentStep = 1;
            const progressBar = document.getElementById('progress-bar');
            const stepIndicator = document.getElementById('step-indicator');
            const btnPrev = document.getElementById('btn-prev');
            const btnNext = document.getElementById('btn-next');
            const btnSubmit = document.getElementById('btn-submit');

            const requiredByStep = {
                1: ['first_name', 'last_name', 'email', 'password', 'password_confirmation'],
                2: [],
                3: []
            };

            function updateUI() {
                steps.forEach(s => {
                    const el = document.getElementById('step-' + s);
                    if (el) el.classList.toggle('hidden', s !== currentStep);
                });
                progressBar.style.width = (currentStep / 3 * 100) + '%';
                stepIndicator.textContent = 'Step ' + currentStep + ' of 3';
                btnPrev.classList.toggle('hidden', currentStep === 1);
                btnNext.classList.toggle('hidden', currentStep === 3);
                btnSubmit.classList.toggle('hidden', currentStep !== 3);
            }

            function validateStep(step) {
                const fields = requiredByStep[step] || [];
                let valid = true;
                fields.forEach(name => {
                    const input = form.querySelector('[name="' + name + '"]');
                    if (input && !input.value.trim()) valid = false;
                });
                return valid;
            }

            btnNext.addEventListener('click', function() {
                if (!validateStep(currentStep)) {
                    form.reportValidity();
                    return;
                }
                if (currentStep < 3) {
                    currentStep++;
                    updateUI();
                }
            });

            btnPrev.addEventListener('click', function() {
                if (currentStep > 1) {
                    currentStep--;
                    updateUI();
                }
            });

            updateUI();
        });
    </script>
@endsection
