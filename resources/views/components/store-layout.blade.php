<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Shop' }} — Eye of Zaharoz</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Viaoda+Libre&family=Cinzel:wght@400;600;700&family=Inter:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-950 text-zinc-200 font-sans antialiased min-h-screen flex flex-col">

    {{-- STORE NAVBAR --}}
    <header x-data="{ open: false }"
            class="fixed top-0 left-0 right-0 z-50 border-b border-zinc-900 bg-zinc-950/95 backdrop-blur-sm">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14">

                {{-- Left: Back to Brand + Logo --}}
                <div class="flex items-center gap-5">
                    <a href="{{ route('home') }}"
                       class="flex items-center gap-1.5 font-mono text-[9px] uppercase tracking-[0.25em] text-zinc-700 hover:text-zinc-500 transition-colors group">
                        <svg class="w-3 h-3 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="square" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Brand
                    </a>
                    <div class="w-px h-4 bg-zinc-800"></div>
                    <a href="{{ route('store.index') }}"
                       class="font-display text-sm uppercase tracking-[0.15em] text-white hover:text-rose-400 transition-colors">
                        Eye of Zaharoz
                        <span class="font-mono text-[9px] text-zinc-700 ml-1 uppercase tracking-widest">/ Store</span>
                    </a>
                </div>

                {{-- Center: Nav links (desktop) --}}
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('store.index') }}"
                       class="font-cinzel text-[10px] uppercase tracking-[0.2em] transition-colors
                              {{ request()->routeIs('store.index') ? 'text-white' : 'text-zinc-600 hover:text-white' }}">
                        Katalog
                    </a>
                    @auth
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}"
                               class="font-cinzel text-[10px] uppercase tracking-[0.2em] transition-colors
                                      {{ request()->routeIs('admin.*') ? 'text-rose-400' : 'text-zinc-600 hover:text-white' }}">
                                Admin Panel
                            </a>
                        @endif
                        @unless(auth()->user()->is_admin)
                            <a href="{{ route('cart.index') }}"
                               class="font-cinzel text-[10px] uppercase tracking-[0.2em] transition-colors
                                      {{ request()->routeIs('cart.*') ? 'text-white' : 'text-zinc-600 hover:text-white' }}">
                                Keranjang
                                @php $cartCount = auth()->user()->cart?->items()->sum('quantity') ?? 0; @endphp
                                @if($cartCount > 0)
                                    <span class="ml-1 font-mono text-rose-400">{{ $cartCount }}</span>
                                @endif
                            </a>
                            <a href="{{ route('orders.index') }}"
                               class="font-cinzel text-[10px] uppercase tracking-[0.2em] transition-colors
                                      {{ request()->routeIs('orders.*') ? 'text-white' : 'text-zinc-600 hover:text-white' }}">
                                Pesanan
                            </a>
                        @endunless
                    @endauth
                </div>

                {{-- Right: Account --}}
                <div class="hidden md:flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}"
                           class="font-cinzel text-[10px] uppercase tracking-[0.2em] transition-colors
                                  {{ request()->routeIs('dashboard') || request()->routeIs('profile.*') || request()->routeIs('addresses.*') ? 'text-white' : 'text-zinc-600 hover:text-white' }}">
                            {{ auth()->user()->name }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                    class="font-mono text-[9px] uppercase tracking-[0.2em] text-zinc-700 hover:text-rose-400 transition-colors">
                                Keluar
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                           class="font-cinzel text-[10px] uppercase tracking-[0.2em] text-zinc-600 hover:text-white transition-colors">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}"
                           class="font-cinzel text-[10px] uppercase tracking-[0.15em] px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white transition-colors">
                            Daftar
                        </a>
                    @endauth
                </div>

                {{-- Mobile: hamburger --}}
                <button @click="open = !open"
                        class="md:hidden p-2 text-zinc-600 hover:text-white transition-colors">
                    <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="square" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="square" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Mobile menu --}}
            <div x-show="open"
                 x-transition:enter="transition duration-150 ease-out"
                 x-transition:enter-start="opacity-0 -translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition duration-100 ease-in"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="md:hidden border-t border-zinc-900 py-3 space-y-1">
                <a href="{{ route('store.index') }}" class="block px-2 py-2.5 font-cinzel text-[10px] uppercase tracking-[0.2em] {{ request()->routeIs('store.index') ? 'text-white' : 'text-zinc-600' }}">Katalog</a>
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="block px-2 py-2.5 font-cinzel text-[10px] uppercase tracking-[0.2em] {{ request()->routeIs('admin.*') ? 'text-rose-400' : 'text-zinc-600' }}">Admin Panel</a>
                    @endif
                    @unless(auth()->user()->is_admin)
                        <a href="{{ route('cart.index') }}" class="block px-2 py-2.5 font-cinzel text-[10px] uppercase tracking-[0.2em] {{ request()->routeIs('cart.*') ? 'text-white' : 'text-zinc-600' }}">
                            Keranjang @if(($cartCount ?? 0) > 0)<span class="text-rose-400">{{ $cartCount }}</span>@endif
                        </a>
                        <a href="{{ route('orders.index') }}" class="block px-2 py-2.5 font-cinzel text-[10px] uppercase tracking-[0.2em] {{ request()->routeIs('orders.*') ? 'text-white' : 'text-zinc-600' }}">Pesanan</a>
                    @endunless
                    <a href="{{ route('dashboard') }}" class="block px-2 py-2.5 font-cinzel text-[10px] uppercase tracking-[0.2em] text-zinc-600">Akun</a>
                    <form method="POST" action="{{ route('logout') }}" class="px-2 pt-2 border-t border-zinc-900">
                        @csrf
                        <button type="submit" class="font-mono text-[9px] uppercase tracking-widest text-zinc-700">Keluar</button>
                    </form>
                @else
                    <div class="px-2 pt-3 border-t border-zinc-900 flex gap-3">
                        <a href="{{ route('login') }}" class="font-cinzel text-[10px] uppercase tracking-[0.15em] px-4 py-2 border border-zinc-800 text-zinc-600">Masuk</a>
                        <a href="{{ route('register') }}" class="font-cinzel text-[10px] uppercase tracking-[0.15em] px-4 py-2 bg-rose-600 text-white">Daftar</a>
                    </div>
                @endauth
            </div>
        </nav>
    </header>

    {{-- Flash message --}}
    @if(session('status') || session('error'))
        <div class="fixed top-14 left-0 right-0 z-40">
            @if(session('status'))
                <div class="border-b border-green-900 bg-green-950/90 backdrop-blur-sm px-4 py-2.5 text-center">
                    <p class="font-mono text-[11px] text-green-400 uppercase tracking-[0.15em]">{{ session('status') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="border-b border-red-900 bg-red-950/90 backdrop-blur-sm px-4 py-2.5 text-center">
                    <p class="font-mono text-[11px] text-red-400 uppercase tracking-[0.15em]">{{ session('error') }}</p>
                </div>
            @endif
        </div>
    @endif

    {{-- MAIN CONTENT --}}
    <main class="flex-1">
        {{ $slot }}
    </main>

    {{-- STORE FOOTER --}}
    <footer class="border-t border-zinc-900 bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" class="font-display text-sm uppercase tracking-widest text-zinc-700 hover:text-white transition-colors">
                        Eye of Zaharoz
                    </a>
                    <span class="text-zinc-800">·</span>
                    <a href="{{ route('store.index') }}" class="font-mono text-[10px] uppercase tracking-widest text-zinc-700 hover:text-rose-400 transition-colors">Store</a>
                    <span class="text-zinc-800">·</span>
                    <a href="{{ route('contact') }}" class="font-mono text-[10px] uppercase tracking-widest text-zinc-700 hover:text-rose-400 transition-colors">Kontak</a>
                </div>
                <p class="font-mono text-[10px] text-zinc-800 uppercase tracking-widest">© {{ date('Y') }} All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
