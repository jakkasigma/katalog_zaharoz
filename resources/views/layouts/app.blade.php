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