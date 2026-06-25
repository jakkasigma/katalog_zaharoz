<x-layout title="Beranda">

{{-- ══════════════════════════════════════════════════════════
     HERO — fullscreen, mobile-first
══════════════════════════════════════════════════════════ --}}
<section class="relative h-screen min-h-[560px] flex flex-col items-center justify-end pb-16 sm:pb-24 overflow-hidden bg-black">

    {{-- BG image --}}
    <div class="absolute inset-0"
        style="background-image: url('{{ asset('foto/banner.png') }}');
                background-size: cover; 
                background-position: center;">
    </div>


    {{-- Gradient overlay --}}
    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-black/20"></div>

    {{-- Content --}}
    <div class="relative z-10 text-center px-4 sm:px-8 w-full max-w-4xl mx-auto">
        <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-rose-400 mb-4 sm:mb-5">
            New Drop — 2026
        </p>
        <h1 class="font-display text-4xl sm:text-6xl lg:text-7xl uppercase leading-none text-white mb-6 sm:mb-8 tracking-tight">
            Eye of<br><span class="text-rose-500">Zaharoz</span>
        </h1>
        <a href="{{ route('store.index') }}"
           class="inline-block w-full sm:w-auto font-cinzel text-[11px] uppercase tracking-[0.25em] px-10 py-4 bg-white text-black hover:bg-rose-500 hover:text-white transition-colors duration-300 min-h-[44px]">
            Shop Collection
        </a>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1 opacity-40">
        <span class="font-mono text-[9px] uppercase tracking-widest text-white">Scroll</span>
        <div class="w-px h-6 bg-white/50 animate-pulse"></div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     SPLIT PANELS — stack on mobile, side-by-side on md+
══════════════════════════════════════════════════════════ --}}
<section class="grid grid-cols-1 md:grid-cols-2">

    {{-- Left panel --}}
<div class="relative overflow-hidden group min-h-[55vw] sm:min-h-[400px] md:min-h-[60vh]">
    <div class="absolute inset-0 bg-zinc-900 group-hover:scale-105 transition-transform duration-700 ease-out"
         style="background-image: url('{{ asset('foto/kiri.png') }}'); 
                background-size: cover; 
                background-position: center;">
    </div>
        <div class="absolute inset-0 bg-black/50 group-hover:bg-black/40 transition-colors duration-300"></div>
        <div class="relative z-10 flex flex-col justify-end h-full p-6 sm:p-10">
            <p class="font-mono text-[10px] uppercase tracking-[0.3em] text-rose-400 mb-2">Akutakara Series</p>
            <h2 class="font-display text-2xl sm:text-3xl uppercase text-white mb-3">Gothic Reworked</h2>
            <a href="{{ route('store.index') }}" class="inline-flex items-center gap-2 font-cinzel text-[11px] uppercase tracking-[0.2em] text-zinc-300 hover:text-white transition-colors">
                Explore <span>→</span>
            </a>
        </div>
    </div>

    {{-- Right panel --}}
    <div class="relative overflow-hidden group min-h-[55vw] sm:min-h-[400px] md:min-h-[60vh]">
        <div class="absolute inset-0 bg-zinc-800 group-hover:scale-105 transition-transform duration-700 ease-out"
             style="background-image: url('{{ asset('foto/kanan.jpeg') }}');
                    background-size: cover; background-position: center center;">
        </div>
        <div class="absolute inset-0 bg-black/50 group-hover:bg-black/40 transition-colors duration-300"></div>
        <div class="relative z-10 flex flex-col justify-end h-full p-6 sm:p-10">
            <p class="font-mono text-[10px] uppercase tracking-[0.3em] text-rose-400 mb-2">Custom Order</p>
            <h2 class="font-display text-2xl sm:text-3xl uppercase text-white mb-3">Made for You</h2>
            <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 font-cinzel text-[11px] uppercase tracking-[0.2em] text-zinc-300 hover:text-white transition-colors">
                Contact Us <span>→</span>
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     LATEST DROP — real products from DB
══════════════════════════════════════════════════════════ --}}
@php
    $latestProducts = \App\Models\Product::with('category')
        ->where('is_active', true)
        ->latest()
        ->limit(4)
        ->get();
@endphp

<section class="py-16 sm:py-24 bg-black">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-8">

        <div class="flex items-end justify-between mb-8 sm:mb-10">
            <div>
                <p class="font-mono text-[10px] uppercase tracking-[0.3em] text-rose-400 mb-2">Latest</p>
                <h2 class="font-display text-3xl sm:text-4xl uppercase text-white">Latest Drop</h2>
            </div>
            <a href="{{ route('store.index') }}" class="hidden sm:inline-flex items-center gap-2 font-cinzel text-[11px] uppercase tracking-[0.2em] text-zinc-500 hover:text-white transition-colors">
                View All <span>→</span>
            </a>
        </div>

        @if ($latestProducts->isEmpty())
            <div class="text-center py-16 border border-dashed border-zinc-900">
                <p class="font-display text-2xl uppercase text-zinc-800">Belum Ada Produk</p>
            </div>
        @else
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-px bg-zinc-900">
                @foreach ($latestProducts as $product)
                    <article class="group bg-zinc-950 relative overflow-hidden flex flex-col">
                        {{-- Image --}}
                        <a href="{{ route('store.product', $product) }}" class="block relative aspect-[3/4] overflow-hidden">
                            @if ($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover group-hover:scale-[1.03] transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-zinc-900 flex items-center justify-center group-hover:bg-zinc-800 transition-colors duration-300">
                                    <div class="w-10 h-10 rotate-45 border border-zinc-800 group-hover:border-rose-900 transition-colors"></div>
                                </div>
                            @endif

                            {{-- Stock badge --}}
                            @if ($product->stock === 0)
                                <div class="absolute top-2 left-2 sm:top-3 sm:left-3 z-10">
                                    <span class="font-mono text-[9px] uppercase tracking-widest px-2 py-1 bg-zinc-800 text-zinc-500">Habis</span>
                                </div>
                            @elseif ($product->stock <= 3)
                                <div class="absolute top-2 left-2 sm:top-3 sm:left-3 z-10">
                                    <span class="font-mono text-[9px] uppercase tracking-widest px-2 py-1 bg-rose-600 text-white">Sisa {{ $product->stock }}</span>
                                </div>
                            @endif

                            {{-- Hover CTA --}}
                            @if ($product->stock > 0)
                                <div class="absolute inset-x-0 bottom-0 p-3 translate-y-full group-hover:translate-y-0 transition-transform duration-300 bg-black/85">
                                    <a href="{{ route('store.product', $product) }}"
                                       class="block w-full text-center font-cinzel text-[10px] uppercase tracking-[0.2em] py-2.5 text-white hover:text-rose-400 transition-colors">
                                        Lihat Produk →
                                    </a>
                                </div>
                            @endif
                        </a>

                        <div class="p-3 sm:p-4 border-t border-zinc-900 flex flex-col gap-1 flex-1">
                            @if ($product->category)
                                <p class="font-mono text-[8px] uppercase tracking-[0.25em] text-rose-400/70">{{ $product->category->name }}</p>
                            @endif
                            <h3 class="font-cinzel text-[11px] sm:text-xs uppercase tracking-[0.08em] text-white leading-snug flex-1">
                                <a href="{{ route('store.product', $product) }}" class="hover:text-rose-400 transition-colors">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            <p class="font-mono text-xs text-zinc-400 mt-1">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif

        {{-- Mobile "View All" --}}
        <div class="text-center mt-6 sm:hidden">
            <a href="{{ route('store.index') }}" class="inline-block font-cinzel text-[11px] uppercase tracking-[0.2em] text-zinc-500 hover:text-white transition-colors">
                View All →
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     BRAND STATEMENT
══════════════════════════════════════════════════════════ --}}
<section class="py-16 sm:py-24 bg-zinc-950 border-t border-zinc-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-8 text-center">
        <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-rose-400 mb-6 sm:mb-8">Our Philosophy</p>
        <p class="font-display text-3xl sm:text-4xl lg:text-5xl uppercase text-white leading-snug mb-6 sm:mb-8">
            Anti-fast-fashion.<br>Underground.<br>Unapologetic.
        </p>
        <div class="w-16 h-px bg-rose-600 mx-auto mb-6 sm:mb-8"></div>
        <p class="text-sm text-zinc-500 leading-relaxed max-w-xl mx-auto mb-8 sm:mb-10">
            Setiap piece Eye of Zaharoz lahir dari penolakan terhadap keseragaman. Terbatas. Handcrafted. Tidak akan pernah direproduksi massal.
        </p>
        <a href="{{ route('about') }}"
           class="inline-block w-full sm:w-auto font-cinzel text-[11px] uppercase tracking-[0.25em] px-8 py-3.5 border border-zinc-700 hover:border-rose-600 text-zinc-400 hover:text-rose-400 transition-colors duration-200 min-h-[44px]">
            Our Story
        </a>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     AESTHETIC PILLARS
══════════════════════════════════════════════════════════ --}}
<section class="bg-black border-t border-zinc-900">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 divide-x divide-y lg:divide-y-0 divide-zinc-900">
            @php
                $pillars = [
                    ['num' => '01', 'title' => 'Cyber-Goth', 'desc' => 'Teknologi & kegelapan dalam satu wujud.'],
                    ['num' => '02', 'title' => 'Punk-Grunge', 'desc' => 'Melawan arus, sobek, bermakna.'],
                    ['num' => '03', 'title' => 'Cybersigilism', 'desc' => 'Simbol yang hanya dibaca yang mengerti.'],
                    ['num' => '04', 'title' => 'Anti-Fashion', 'desc' => 'Sebelum tren, sesudah tren, di luar tren.'],
                ];
            @endphp
            @foreach ($pillars as $p)
                <div class="py-8 sm:py-10 px-4 sm:px-6 group hover:bg-zinc-950 transition-colors duration-200">
                    <p class="font-mono text-[9px] text-zinc-800 mb-3 sm:mb-4">{{ $p['num'] }}</p>
                    <h3 class="font-cinzel text-[11px] sm:text-xs uppercase tracking-[0.15em] text-zinc-300 mb-2 group-hover:text-rose-400 transition-colors">{{ $p['title'] }}</h3>
                    <p class="text-[11px] text-zinc-700 leading-relaxed">{{ $p['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     CTA — register / contact
══════════════════════════════════════════════════════════ --}}
<section class="py-16 sm:py-24 bg-zinc-950 border-t border-zinc-900 text-center">
    <div class="max-w-lg mx-auto px-4 sm:px-8">
        <h2 class="font-display text-3xl sm:text-4xl uppercase text-white mb-3">Join the Underground</h2>
        <p class="text-xs text-zinc-600 mb-8">Daftar dan dapatkan akses ke drop terbaru & exclusive offer.</p>
        <div class="flex flex-col sm:flex-row gap-0">
            <a href="{{ route('register') }}"
               class="flex-1 font-cinzel text-[11px] uppercase tracking-[0.2em] px-8 py-4 bg-rose-600 hover:bg-rose-500 text-white transition-colors duration-200 text-center min-h-[44px] flex items-center justify-center">
                Create Account
            </a>
            <a href="{{ route('contact') }}"
               class="flex-1 font-cinzel text-[11px] uppercase tracking-[0.2em] px-8 py-4 border border-zinc-800 hover:border-zinc-600 text-zinc-500 hover:text-white transition-colors duration-200 text-center min-h-[44px] flex items-center justify-center">
                Contact Us
            </a>
        </div>
    </div>
</section>

</x-layout>
