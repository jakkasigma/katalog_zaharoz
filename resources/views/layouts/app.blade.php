<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Eyes Zaharoz') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500&family=Viaoda+Libre&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="min-h-screen bg-mist font-sans text-brass antialiased">
        <div class="pointer-events-none fixed inset-0 overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(225,29,72,0.22),transparent_32%),linear-gradient(135deg,rgba(255,255,255,0.04)_0_1px,transparent_1px_18px)]"></div>
            <div class="absolute -left-20 top-16 h-64 w-64 rotate-45 border border-lens/30"></div>
            <div class="absolute right-10 top-24 h-40 w-40 rotate-12 border border-white/10"></div>
            <div class="absolute bottom-0 left-1/2 h-80 w-80 bg-lens/10 blur-3xl"></div>
        </div>

        <nav class="relative border-b border-glass bg-ink/90 shadow-2xl backdrop-blur-xl">
            <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4">
                <a href="{{ auth()->check() ? route('dashboard') : url('/') }}" class="font-display text-xl font-bold uppercase tracking-[0.18em] text-brass">
                    Eyes<span class="text-lens"> Of </span>Zaharoz
                </a>

                @auth
                    <div class="flex flex-wrap items-center justify-end gap-3">
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-nav-link>
                        <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.*')">Profil</x-nav-link>
                        <x-nav-link :href="route('addresses.index')" :active="request()->routeIs('addresses.*')">Alamat</x-nav-link>

                        {{-- Notification Bell --}}
                        @php
                            $unreadCount = auth()->user()->unreadNotificationsCount();
                        @endphp
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="relative p-2 text-brass hover:text-lens transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                @if($unreadCount > 0)
                                    <span class="absolute top-0 right-0 flex items-center justify-center w-5 h-5 bg-lens text-white text-xs rounded-full">
                                        {{ $unreadCount }}
                                    </span>
                                @endif
                            </button>

                            {{-- Notification Dropdown --}}
                            <div x-show="open"
                                 @click.away="open = false"
                                 x-transition
                                 class="absolute right-0 mt-2 w-80 bg-ink border border-glass rounded-lg shadow-xl z-50 max-h-96 overflow-y-auto">
                                <div class="p-4 border-b border-glass">
                                    <h3 class="font-semibold text-brass">Notifikasi</h3>
                                </div>
                                <div class="divide-y divide-glass">
                                    @forelse(auth()->user()->notifications()->take(5)->get() as $notification)
                                        <a href="{{ $notification->link ?? '#' }}" class="block p-4 hover:bg-night transition-colors">
                                            <div class="flex items-start gap-3">
                                                <div class="flex-shrink-0 mt-1">
                                                    @if($notification->type === 'success')
                                                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                                    @elseif($notification->type === 'warning')
                                                        <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                                                    @elseif($notification->type === 'error')
                                                        <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                                    @else
                                                        <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-brass truncate">{{ $notification->title }}</p>
                                                    <p class="text-xs text-zinc-500 mt-1">{{ $notification->message }}</p>
                                                    <p class="text-xs text-zinc-600 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    @empty
                                        <div class="p-8 text-center text-zinc-500 text-sm">
                                            Tidak ada notifikasi
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-button type="submit" class="px-4 py-2">Logout</x-button>
                        </form>
                    </div>
                @else
                    @if (Route::has('login'))
                        <div class="flex items-center gap-3">
                            <x-nav-link :href="route('login')" :active="request()->routeIs('login')">Login</x-nav-link>
                            <x-link-button :href="route('register')" class="px-4 py-2">Registrasi</x-link-button>
                        </div>
                    @endif
                @endauth
            </div>
        </nav>

        <main class="relative mx-auto max-w-6xl px-4 py-8">
            @if (session('status'))
                <x-alert variant="success" class="mb-6">
                    {{ session('status') }}
                </x-alert>
            @endif

            {{ $slot ?? '' }}
            @yield('content')
        </main>
    </body>
</html>