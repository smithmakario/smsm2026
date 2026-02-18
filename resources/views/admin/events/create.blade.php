<x-admin-layout>
    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="flex items-center justify-between sticky top-0 z-10 bg-white/80 dark:bg-[#111a22]/80 backdrop-blur-md border-b border-slate-200 dark:border-[#243647] px-8 py-3">
            <h2 class="text-lg font-bold tracking-tight">Create Event</h2>
            <a href="{{ route('admin.events.index') }}" class="text-sm text-slate-600 dark:text-[#93adc8] hover:text-primary">← Back to Events</a>
        </header>
        <div class="p-8 max-w-2xl">
            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-100 dark:bg-red-500/10 text-red-700 dark:text-red-400 px-4 py-3 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('admin.events.store') }}" class="space-y-6 rounded-xl bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] p-6 shadow-sm">
                @csrf

                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Title *</label>
                    <input id="title" name="title" type="text" value="{{ old('title') }}" required
                        class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Description</label>
                    <textarea id="description" name="description" rows="3" class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="start_at" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Start Date & Time *</label>
                        <input id="start_at" name="start_at" type="datetime-local" value="{{ old('start_at') }}" required
                            class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="end_at" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">End Date & Time</label>
                        <input id="end_at" name="end_at" type="datetime-local" value="{{ old('end_at') }}"
                            class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="type" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Type *</label>
                        <select id="type" name="type" required class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white focus:ring-primary focus:border-primary">
                            <option value="free" {{ old('type', 'free') === 'free' ? 'selected' : '' }}>Free</option>
                            <option value="paid" {{ old('type') === 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                    </div>
                    <div>
                        <label for="format" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Format *</label>
                        <select id="format" name="format" required class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white focus:ring-primary focus:border-primary">
                            <option value="onsite" {{ old('format', 'onsite') === 'onsite' ? 'selected' : '' }}>Onsite</option>
                            <option value="virtual" {{ old('format') === 'virtual' ? 'selected' : '' }}>Virtual</option>
                        </select>
                    </div>
                </div>

                <div id="location-field">
                    <label for="location" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Location</label>
                    <input id="location" name="location" type="text" value="{{ old('location') }}" placeholder="Venue address"
                        class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                </div>

                <div id="meeting-link-field" class="hidden">
                    <label for="meeting_link" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Meeting Link</label>
                    <input id="meeting_link" name="meeting_link" type="url" value="{{ old('meeting_link') }}" placeholder="https://meet.google.com/..."
                        class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                </div>

                <div id="price-field" class="hidden">
                    <label for="price" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Price</label>
                    <input id="price" name="price" type="number" step="0.01" min="0" value="{{ old('price') }}" placeholder="0.00"
                        class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                </div>

                <div>
                    <label for="capacity" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Capacity (optional)</label>
                    <input id="capacity" name="capacity" type="number" min="1" value="{{ old('capacity') }}" placeholder="No limit"
                        class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="rounded-lg bg-primary px-4 py-2 text-white text-sm font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                        Create Event
                    </button>
                    <a href="{{ route('admin.events.index') }}" class="rounded-lg bg-slate-200 dark:bg-[#243647] px-4 py-2 text-slate-700 dark:text-white text-sm font-bold hover:bg-slate-300 dark:hover:bg-[#344d65] transition-all">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </main>
    <script>
        document.getElementById('format').addEventListener('change', function() {
            const format = this.value;
            document.getElementById('location-field').classList.toggle('hidden', format === 'virtual');
            document.getElementById('meeting-link-field').classList.toggle('hidden', format !== 'virtual');
        });
        document.getElementById('type').addEventListener('change', function() {
            document.getElementById('price-field').classList.toggle('hidden', this.value !== 'paid');
        });
        document.getElementById('format').dispatchEvent(new Event('change'));
        document.getElementById('type').dispatchEvent(new Event('change'));
    </script>
</x-admin-layout>
