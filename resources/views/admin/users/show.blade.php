<x-admin-layout>
    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="flex items-center justify-between sticky top-0 z-10 bg-white/80 dark:bg-[#111a22]/80 backdrop-blur-md border-b border-slate-200 dark:border-[#243647] px-8 py-3">
            <h2 class="text-lg font-bold tracking-tight">User Details</h2>
            <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-primary/90 text-white text-sm font-bold rounded-lg transition-all">
                <span class="material-symbols-outlined text-[20px]">edit</span>
                Edit User
            </a>
        </header>
        <div class="p-8 max-w-2xl">
            <div class="rounded-xl bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] p-6 shadow-sm space-y-6">
                <div class="flex items-center gap-4">
                    <div class="size-14 rounded-full bg-slate-200 dark:bg-[#243647] flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-slate-500 dark:text-slate-400 text-3xl">person</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $user->full_name }}</h3>
                        <p class="text-slate-500 dark:text-[#93adc8]">{{ $user->email }}</p>
                    </div>
                </div>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-[#93adc8]">First Name</dt>
                        <dd class="mt-1 text-slate-900 dark:text-white">{{ $user->first_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-[#93adc8]">Last Name</dt>
                        <dd class="mt-1 text-slate-900 dark:text-white">{{ $user->last_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-[#93adc8]">Phone</dt>
                        <dd class="mt-1 text-slate-900 dark:text-white">{{ $user->phone ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-[#93adc8]">User Type</dt>
                        <dd class="mt-1">
                            @php
                                $typeColors = [
                                    \App\Models\User::TYPE_ADMIN => 'bg-primary/20 text-primary',
                                    \App\Models\User::TYPE_COORDINATOR => 'bg-purple-500/20 text-purple-400',
                                    \App\Models\User::TYPE_MENTEE => 'bg-slate-200 dark:bg-[#344d65] text-slate-600 dark:text-slate-300',
                                ];
                            @endphp
                            <span class="px-2 py-1 {{ $typeColors[$user->user_type] ?? 'bg-slate-200 text-slate-600' }} text-xs font-bold uppercase rounded">{{ ucfirst($user->user_type) }}</span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-[#93adc8]">Last Updated</dt>
                        <dd class="mt-1 text-slate-900 dark:text-white font-mono text-sm">{{ $user->updated_at?->format('Y-m-d H:i') ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-[#93adc8]">Marital Status</dt>
                        <dd class="mt-1 text-slate-900 dark:text-white">{{ $user->marital_status ? (config('onboarding.marital_statuses')[$user->marital_status] ?? $user->marital_status) : '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-[#93adc8]">Occupation</dt>
                        <dd class="mt-1 text-slate-900 dark:text-white">{{ $user->occupation ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-[#93adc8]">Occupation Category</dt>
                        <dd class="mt-1 text-slate-900 dark:text-white">{{ $user->occupation_category ? (config('onboarding.occupation_categories')[$user->occupation_category] ?? $user->occupation_category) : '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-[#93adc8]">Church</dt>
                        <dd class="mt-1 text-slate-900 dark:text-white">{{ $user->church ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-[#93adc8]">Location</dt>
                        <dd class="mt-1 text-slate-900 dark:text-white">{{ implode(', ', array_filter([$user->city, $user->state, $user->country ?? 'Nigeria'])) ?: '—' }}</dd>
                    </div>
                </dl>
                <div class="pt-4 border-t border-slate-200 dark:border-[#243647]">
                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-slate-600 dark:text-[#93adc8] hover:text-primary text-sm font-medium">
                        <span class="material-symbols-outlined text-lg">arrow_back</span>
                        Back to Users
                    </a>
                </div>
            </div>
        </div>
    </main>
</x-admin-layout>
