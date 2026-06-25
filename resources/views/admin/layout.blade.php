<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin - {{ config('app.name', 'Eyes Zaharoz') }}</title>
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
            <div class="mx-auto flex max-w-7xl items-center justify-between gap-3 px-4 py-2">
                <div class="flex items-center gap-3">
                    <a href="{{ route('store.index') }}"
                       class="flex items-center gap-1 font-mono text-[9px] uppercase tracking-[0.25em] text-zinc-500 hover:text-brass transition-colors group">
                        <svg class="w-3 h-3 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="square" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Katalog
                    </a>
                    <div class="w-px h-3 bg-glass"></div>
                    <a href="{{ route('admin.dashboard') }}" class="font-display text-sm font-bold uppercase tracking-[0.18em] text-brass">
                        <span class="text-lens">Admin</span> Panel
                    </a>
                </div>

                <div class="flex items-center justify-end gap-1.5 whitespace-nowrap">
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="px-2 py-1 text-[10px]">Dashboard</x-nav-link>
                    <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')" class="px-2 py-1 text-[10px]">Produk</x-nav-link>
                    <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')" class="px-2 py-1 text-[10px]">Kategori</x-nav-link>

                    @php
                        $newOrdersCount     = \App\Models\Order::where('status', 'processing')->count();
                        $pendingPaymentCount = \App\Models\Payment::where('status', 'waiting_confirmation')->count();
                    @endphp

                    <a href="{{ route('admin.orders.index') }}"
                       class="relative inline-flex items-center gap-1 font-mono text-[10px] uppercase tracking-[0.18em] px-2 py-1 transition-colors
                              {{ request()->routeIs('admin.orders.*') ? 'text-brass border-b border-lens' : 'text-zinc-400 hover:text-brass' }}">
                        Pesanan
                        @if($newOrdersCount > 0)
                            <span class="flex items-center justify-center min-w-[14px] h-[14px] px-0.5 rounded-full bg-lens font-mono text-[8px] text-white leading-none">
                                {{ $newOrdersCount }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('admin.payments.index') }}"
                       class="relative inline-flex items-center gap-1 font-mono text-[10px] uppercase tracking-[0.18em] px-2 py-1 transition-colors
                              {{ request()->routeIs('admin.payments.*') ? 'text-brass border-b border-lens' : 'text-zinc-400 hover:text-brass' }}">
                        Pembayaran
                        @if($pendingPaymentCount > 0)
                            <span class="flex items-center justify-center min-w-[14px] h-[14px] px-0.5 rounded-full bg-rose-600 font-mono text-[8px] text-white leading-none">
                                {{ $pendingPaymentCount }}
                            </span>
                        @endif
                    </a>

                    <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" class="px-2 py-1 text-[10px]">User</x-nav-link>
                    <x-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')" class="px-2 py-1 text-[10px]">Laporan</x-nav-link>
                    <x-nav-link :href="route('admin.company-profile.edit')" :active="request()->routeIs('admin.company-profile.*')" class="px-2 py-1 text-[10px]">Profile</x-nav-link>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <x-button type="submit" class="px-3 py-1 text-[10px] uppercase">Logout</x-button>
                    </form>
                </div>
            </div>
        </nav>

        <main class="relative mx-auto max-w-7xl px-4 py-8">
            @if (session('status'))
                <x-alert variant="success" class="mb-6">
                    {{ session('status') }}
                </x-alert>
            @endif

            @if (session('error'))
                <x-alert variant="error" class="mb-6">
                    {{ session('error') }}
                </x-alert>
            @endif

            @yield('content')
        </main>
    </body>
</html>
