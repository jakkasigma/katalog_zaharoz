<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Eyes of Zaharoz' }} — Gothic Clothing</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Viaoda+Libre&family=Cinzel:wght@400;600;700&family=Inter:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black text-zinc-200 font-sans antialiased min-h-screen flex flex-col">

    {{-- NAVBAR --}}
    <header x-data="{ open: false, scrolled: false }"
            x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 20)"
            :class="scrolled ? 'border-b border-zinc-800 bg-black/95 backdrop-blur-sm' : 'bg-transparent'"
            class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <span class="font-display text-xl font-bold uppercase tracking-widest text-white group-hover:text-rose-400 transition-colors duration-200">
                        Eyes of Zaharoz
                    </span>
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}"
                       class="font-cinzel text-xs uppercase tracking-[0.2em] transition-colors duration-200
                              {{ request()->routeIs('home') ? 'text-rose-400' : 'text-zinc-400 hover:text-white' }}">
                        Beranda
                    </a>
                    <a href="{{ route('about') }}"
                       class="font-cinzel text-xs uppercase tracking-[0.2em] transition-colors duration-200
                              {{ request()->routeIs('about') ? 'text-rose-400' : 'text-zinc-400 hover:text-white' }}">
                        Tentang Kami
                    </a>
                    <a href="{{ route('vision') }}"
                       class="font-cinzel text-xs uppercase tracking-[0.2em] transition-colors duration-200
                              {{ request()->routeIs('vision') ? 'text-rose-400' : 'text-zinc-400 hover:text-white' }}">
                        Visi & Misi
                    </a>
                    <a href="{{ route('contact') }}"
                       class="font-cinzel text-xs uppercase tracking-[0.2em] transition-colors duration-200
                              {{ request()->routeIs('contact') ? 'text-rose-400' : 'text-zinc-400 hover:text-white' }}">
                        Kontak
                    </a>
                </div>

                {{-- CTA + Auth --}}
                <div class="hidden md:flex items-center gap-4">
                    @auth
                        <a href="{{ route('user.dashboard') }}"
                           class="font-cinzel text-xs uppercase tracking-[0.2em] text-zinc-400 hover:text-white transition-colors duration-200">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="font-cinzel text-xs uppercase tracking-[0.2em] text-zinc-400 hover:text-white transition-colors duration-200">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}"
                           class="font-cinzel text-xs uppercase tracking-[0.15em] px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white transition-colors duration-200">
                            Daftar
                        </a>
                    @endauth
                </div>

                {{-- Mobile hamburger --}}
                <button @click="open = !open"
                        class="md:hidden p-2 text-zinc-400 hover:text-white transition-colors"
                        aria-label="Toggle menu">
                    <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Mobile Menu --}}
            <div x-show="open"
                 x-transition:enter="transition duration-200 ease-out"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition duration-150 ease-in"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="md:hidden border-t border-zinc-800 py-4 space-y-1">
                <a href="{{ route('home') }}" class="block px-2 py-3 font-cinzel text-xs uppercase tracking-[0.2em] {{ request()->routeIs('home') ? 'text-rose-400' : 'text-zinc-400' }}">Beranda</a>
                <a href="{{ route('about') }}" class="block px-2 py-3 font-cinzel text-xs uppercase tracking-[0.2em] {{ request()->routeIs('about') ? 'text-rose-400' : 'text-zinc-400' }}">Tentang Kami</a>
                <a href="{{ route('vision') }}" class="block px-2 py-3 font-cinzel text-xs uppercase tracking-[0.2em] {{ request()->routeIs('vision') ? 'text-rose-400' : 'text-zinc-400' }}">Visi & Misi</a>
                <a href="{{ route('contact') }}" class="block px-2 py-3 font-cinzel text-xs uppercase tracking-[0.2em] {{ request()->routeIs('contact') ? 'text-rose-400' : 'text-zinc-400' }}">Kontak</a>
                <div class="pt-3 border-t border-zinc-800 flex gap-4">
                    @auth
                        <a href="{{ route('user.dashboard') }}" class="font-cinzel text-xs uppercase tracking-[0.2em] text-zinc-400">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-cinzel text-xs uppercase tracking-[0.2em] text-zinc-400">Masuk</a>
                        <a href="{{ route('register') }}" class="font-cinzel text-xs uppercase tracking-[0.15em] px-4 py-2 bg-rose-600 text-white">Daftar</a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="flex-1">
    {{ $slot }} {{-- Ini wajib ada agar konten home.blade.php muncul --}}
    </main>

    {{-- FOOTER --}}
    <footer class="border-t border-zinc-800 bg-zinc-950 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

                {{-- Brand --}}
                <div class="space-y-4">
                    <h3 class="font-display text-lg uppercase tracking-widest text-white">Eyes of Zaharoz</h3>
                    <p class="text-sm text-zinc-500 leading-relaxed">
                        Custom gothic clothing & reworked apparel. Anti-fast-fashion. Underground. Unapologetic.
                    </p>
                    <div class="flex gap-4 pt-1">
                        <a href="#" class="font-mono text-xs uppercase tracking-widest text-zinc-600 hover:text-rose-400 transition-colors">IG</a>
                        <a href="#" class="font-mono text-xs uppercase tracking-widest text-zinc-600 hover:text-rose-400 transition-colors">TT</a>
                        <a href="#" class="font-mono text-xs uppercase tracking-widest text-zinc-600 hover:text-rose-400 transition-colors">WA</a>
                    </div>
                </div>

                {{-- Navigation --}}
                <div class="space-y-4">
                    <p class="font-mono text-xs uppercase tracking-[0.3em] text-rose-400">Navigasi</p>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-sm text-zinc-500 hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="{{ route('about') }}" class="text-sm text-zinc-500 hover:text-white transition-colors">Tentang Kami</a></li>
                        <li><a href="{{ route('vision') }}" class="text-sm text-zinc-500 hover:text-white transition-colors">Visi & Misi</a></li>
                        <li><a href="{{ route('contact') }}" class="text-sm text-zinc-500 hover:text-white transition-colors">Kontak</a></li>
                    </ul>
                </div>

                {{-- Contact info --}}
                <div class="space-y-4">
                    <p class="font-mono text-xs uppercase tracking-[0.3em] text-rose-400">Kontak</p>
                    <ul class="space-y-2 text-sm text-zinc-500">
                        <li class="flex items-start gap-2">
                            <span class="font-mono text-xs text-zinc-700 mt-0.5">📍</span>
                            <span>Yogyakarta, Indonesia</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="font-mono text-xs text-zinc-700 mt-0.5">✉</span>
                            <span>eyesofzaharoz@gmail.com</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="font-mono text-xs text-zinc-700 mt-0.5">📞</span>
                            <span>+62 xxx-xxxx-xxxx</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-zinc-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="font-mono text-xs text-zinc-700 uppercase tracking-widest">
                    © {{ date('Y') }} Eyes of Zaharoz. All rights reserved.
                </p>
                <p class="font-mono text-xs text-zinc-800 uppercase tracking-widest">
                    Gothic · Underground · Reworked
                </p>
            </div>
        </div>
    </footer>

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>
</html>