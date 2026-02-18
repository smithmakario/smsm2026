<x-guest-layout>
    <div class="space-y-4">
        <div class="text-center">
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">{{ $event->title }}</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                {{ $event->start_at->format('l, F j, Y \a\t g:i A') }}
                @if($event->end_at)
                    – {{ $event->end_at->format('g:i A') }}
                @endif
            </p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                {{ ucfirst($event->type) }} · {{ ucfirst($event->format) }}
                @if($event->format === 'virtual' && $event->meeting_link)
                    · Online
                @elseif($event->location)
                    · {{ $event->location }}
                @endif
                @if($event->isPaid() && $event->price)
                    · {{ number_format($event->price, 2) }} (payment at door)
                @endif
                @if($event->capacity)
                    · {{ max(0, $event->capacity - $event->registrations_count) }} spots left
                @endif
            </p>
        </div>

        @if (session('status'))
            <div class="rounded-lg bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif
        @if (session('error'))
            <div class="rounded-lg bg-red-100 dark:bg-red-500/10 text-red-700 dark:text-red-400 px-4 py-3 text-sm">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="rounded-lg bg-red-100 dark:bg-red-500/10 text-red-700 dark:text-red-400 px-4 py-3 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(!$event->isAtCapacity())
            <form method="POST" action="{{ route('events.guest.store', $event) }}" class="space-y-4">
                @csrf
                @if(request('ref'))
                    <input type="hidden" name="ref" value="{{ request('ref') }}">
                @endif

                <div>
                    <label for="guest_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name *</label>
                    <input id="guest_name" name="guest_name" type="text" value="{{ old('guest_name') }}" required
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                </div>

                <div>
                    <label for="guest_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email *</label>
                    <input id="guest_email" name="guest_email" type="email" value="{{ old('guest_email') }}" required
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                </div>

                @if($event->isPaid() && $event->price)
                    <p class="text-xs text-gray-500 dark:text-gray-400">Payment will be collected at the door.</p>
                @endif

                <button type="submit" class="w-full flex justify-center rounded-lg bg-primary px-4 py-2.5 text-white text-sm font-bold shadow hover:bg-primary/90 focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-all">
                    Register for this event
                </button>
            </form>
        @else
            <p class="text-sm text-gray-600 dark:text-gray-400 text-center">This event is at capacity. No further registrations can be accepted.</p>
        @endif

        <p class="text-center">
            <a href="/" class="text-sm text-gray-500 dark:text-gray-400 hover:text-primary hover:underline">Back to home</a>
        </p>
    </div>
</x-guest-layout>
