<x-admin-layout>
    <main class="flex-1 flex flex-col overflow-y-auto">
        <header
            class="flex items-center justify-between sticky top-0 z-10 bg-white/80 dark:bg-[#111a22]/80 backdrop-blur-md border-b border-slate-200 dark:border-[#243647] px-8 py-3">
            <h2 class="text-lg font-bold tracking-tight">Create User</h2>
        </header>
        <div class="p-8 max-w-2xl">
            @if (session('status'))
                <div
                    class="mb-4 rounded-lg bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('admin.users.store') }}"
                class="space-y-6 rounded-xl bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] p-6 shadow-sm">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="first_name"
                            class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">First Name</label>
                        <input id="first_name" name="first_name" type="text" value="{{ old('first_name') }}" required
                            autofocus
                            class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                        @error('first_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="last_name"
                            class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Last Name</label>
                        <input id="last_name" name="last_name" type="text" value="{{ old('last_name') }}" required
                            class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                        @error('last_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="email"
                        class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone"
                        class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Phone
                        (optional)</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone') }}"
                        class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="user_type"
                        class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">User Type</label>
                    <select id="user_type" name="user_type" required
                        class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                        @foreach ($userTypes as $value => $label)
                            <option value="{{ $value }}" {{ old('user_type') === $value ? 'selected' : '' }}>
                                {{ $label }}</option>
                        @endforeach
                    </select>
                    @error('user_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 border-t border-slate-200 dark:border-[#243647]">
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-4">Personal & Work</h4>
                    <div class="space-y-4">
                        <div>
                            <label for="marital_status"
                                class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Marital
                                Status</label>
                            <select id="marital_status" name="marital_status"
                                class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                                <option value="">Select Marital Status</option>
                                @foreach ($maritalStatuses ?? [] as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('marital_status') == $value ? 'selected' : '' }}>{{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('marital_status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="occupation_category"
                                class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Occupation
                                Category</label>
                            <select id="occupation_category" name="occupation_category"
                                class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                                <option value="">Select Occupation Category</option>
                                @foreach ($occupationCategories ?? [] as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('occupation_category') == $value ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                            @error('occupation_category')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="occupation"
                                class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Occupation</label>
                            <input id="occupation" name="occupation" type="text" value="{{ old('occupation') }}"
                                class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary"
                                placeholder="e.g. Software Engineer">
                            @error('occupation')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-200 dark:border-[#243647]">
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-4">Location & Church</h4>
                    <div class="space-y-4">
                        <div>
                            <label for="church"
                                class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Church</label>
                            <input id="church" name="church" type="text" value="{{ old('church') }}"
                                class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary"
                                placeholder="Church name">
                            @error('church')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="country"
                                class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Country</label>
                            <input id="country" name="country" type="text" value="{{ old('country', 'Nigeria') }}"
                                class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                            @error('country')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="state"
                                    class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">State</label>
                                <select id="state" name="state"
                                    class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                                    <option value="">Select State</option>
                                    @foreach ($nigerianStates ?? [] as $s)
                                        <option value="{{ $s }}"
                                            {{ old('state') == $s ? 'selected' : '' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                                @error('state')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="city"
                                    class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">City</label>
                                <input id="city" name="city" type="text" value="{{ old('city') }}"
                                    class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary"
                                    placeholder="City">
                                @error('city')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-slate-200 dark:border-[#243647]">
                    <div class="hidden">
                        <label for="password"
                            class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Password</label>
                        <input id="password" name="password" type="password"
                            class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="hidden">
                        <label for="password_confirmation"
                            class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Confirm
                            Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                            class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                        class="rounded-lg bg-primary px-4 py-2 text-white text-sm font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                        Create User
                    </button>
                    <a href="{{ route('admin.users.index') }}"
                        class="rounded-lg bg-slate-200 dark:bg-[#243647] px-4 py-2 text-slate-700 dark:text-white text-sm font-bold hover:bg-slate-300 dark:hover:bg-[#344d65] transition-all">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </main>
</x-admin-layout>
