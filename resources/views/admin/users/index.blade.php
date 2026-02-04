<x-admin-layout>
    <main class="flex-1 flex flex-col min-w-0 bg-background-light dark:bg-[#0b1015]">
        <div class="p-6 pb-0">
            <div class="flex flex-wrap justify-between items-end gap-4 mb-6">
                <div class="flex flex-col gap-1">
                    <h1 class="text-slate-900 dark:text-white text-3xl font-black tracking-tight">Users</h1>
                    <p class="text-slate-500 dark:text-[#93adc8] text-sm">Manage users and their access levels.</p>
                </div>
                <a href="{{ route('admin.users.create') }}" class="flex items-center gap-2 px-4 py-2 bg-primary hover:bg-primary/90 text-white text-sm font-bold rounded-lg transition-all">
                    <span class="material-symbols-outlined text-[20px]">person_add</span>
                    Add User
                </a>
            </div>
            <form method="GET" action="{{ route('admin.users.index') }}" class="py-4">
                <label class="flex items-stretch rounded-xl h-12 w-full max-w-md bg-white dark:bg-[#1c2836] border border-slate-200 dark:border-[#243647] focus-within:ring-2 focus-within:ring-primary/50 transition-all">
                    <div class="text-slate-400 dark:text-[#93adc8] flex items-center justify-center pl-4">
                        <span class="material-symbols-outlined">search</span>
                    </div>
                    <input name="search" class="w-full bg-transparent border-none text-slate-900 dark:text-white placeholder:text-slate-400 dark:placeholder:text-[#93adc8] focus:ring-0 px-4 text-sm font-medium" placeholder="Search by name or email..." value="{{ request('search') }}"/>
                </label>
            </form>
        </div>
        <div class="flex-1 overflow-auto px-6 pb-6">
            <div class="bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#243647] rounded-xl overflow-hidden shadow-sm">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-[#1c2836] border-b border-slate-200 dark:border-[#243647]">
                            <th class="p-4 text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-[#93adc8]">User Identity</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-[#93adc8]">User Type</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-[#93adc8]">Last Modified</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-[#93adc8] text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-[#243647]">
                        @forelse($users as $user)
                            <tr class="hover:bg-slate-50 dark:hover:bg-[#1c2836] transition-colors">
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="size-9 rounded-full bg-slate-200 dark:bg-[#243647] overflow-hidden flex items-center justify-center shrink-0">
                                            <span class="material-symbols-outlined text-slate-500 dark:text-slate-400">person</span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-slate-900 dark:text-white">{{ $user->full_name }}</span>
                                            <span class="text-xs text-slate-500 dark:text-[#93adc8]">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-wrap gap-2">
                                        @php
                                            $typeColors = [
                                                \App\Models\User::TYPE_ADMIN => 'bg-primary/20 text-primary',
                                                \App\Models\User::TYPE_MENTOR => 'bg-purple-500/20 text-purple-400',
                                                \App\Models\User::TYPE_MENTEE => 'bg-slate-200 dark:bg-[#344d65] text-slate-600 dark:text-slate-300',
                                            ];
                                        @endphp
                                        <span class="px-2 py-1 {{ $typeColors[$user->user_type] ?? 'bg-slate-200 text-slate-600' }} text-[10px] font-bold uppercase rounded">{{ ucfirst($user->user_type) }}</span>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <span class="text-sm font-mono text-slate-900 dark:text-white">{{ $user->updated_at?->format('Y-m-d') ?? '-' }}</span>
                                </td>
                                <td class="p-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.users.show', $user) }}" class="inline-flex items-center gap-1 px-2 py-1.5 text-xs font-medium rounded-lg bg-slate-100 dark:bg-[#243647] text-slate-700 dark:text-slate-300 hover:bg-primary/10 hover:text-primary transition-colors" title="View">View</a>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center gap-1 px-2 py-1.5 text-xs font-medium rounded-lg bg-slate-100 dark:bg-[#243647] text-slate-700 dark:text-slate-300 hover:bg-primary/10 hover:text-primary transition-colors" title="Edit">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-slate-500 dark:text-[#93adc8]">
                                    No users found. <a href="{{ route('admin.users.create') }}" class="text-primary hover:underline">Add your first user</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($users->hasPages())
                <div class="mt-4 flex justify-center">
                    {{ $users->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </main>
</x-admin-layout>
