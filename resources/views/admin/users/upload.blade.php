<x-admin-layout>
    <main class="flex-1 flex flex-col overflow-y-auto">
        <header
            class="flex items-center justify-between sticky top-0 z-10 bg-white/80 dark:bg-[#111a22]/80 backdrop-blur-md border-b border-slate-200 dark:border-[#243647] px-8 py-3">
            <h2 class="text-lg font-bold tracking-tight">Upload Users</h2>
        </header>
        <div class="p-8 max-w-2xl">
            @if (session('status'))
                <div
                    class="mb-4 rounded-lg bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('admin.users.storeUpload') }}" enctype="multipart/form-data"
                class="space-y-6 rounded-xl bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] p-6 shadow-sm">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="upload"
                            class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Upload</label>
                        <input id="file" name="file" type="file" required autofocus
                            class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                        @error('file')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                        class="rounded-lg bg-primary px-4 py-2 text-white text-sm font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                        Upload User
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
