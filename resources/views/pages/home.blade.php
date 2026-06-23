<x-layout title="Beranda">
{{-- ══════════════════════════════════════════════════════════
     HERO — fullscreen, inspired by Hishiro's image-first hero
══════════════════════════════════════════════════════════ --}}
<section class="relative h-screen min-h-[600px] flex flex-col items-center justify-end pb-20 overflow-hidden bg-black">
 
    {{-- BG image placeholder — ganti dengan foto produk/editorial nyata --}}
    <div class="absolute inset-0 bg-gradient-to-b from-zinc-900/30 via-black/20 to-black"
         style="background-image: url('https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1600&q=80');
                background-size: cover; background-position: center;">
    </div>
 
    {{-- Dark gradient bottom --}}
    <div class="absolute inset-x-0 bottom-0 h-2/3 bg-gradient-to-t from-black via-black/70 to-transparent"></div>
 
    {{-- Content --}}
    <div class="relative z-10 text-center px-5">
        <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-rose-400 mb-5">
            New Drop — 2025
        </p>
        <h1 class="font-display text-6xl sm:text-8xl lg:text-[9rem] uppercase leading-none text-white mb-8 tracking-tight">
            Eyes of<br><span class="text-rose-500">Zaharoz</span>
        </h1>
        <a href="#" {{-- link ke koleksi nanti --}}
           class="inline-block font-cinzel text-[11px] uppercase tracking-[0.25em] px-10 py-4 bg-white text-black hover:bg-rose-500 hover:text-white transition-colors duration-300">
            Shop Collection
        </a>
    </div>
 
    {{-- Scroll indicator --}}
    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1 opacity-40">
        <span class="font-mono text-[9px] uppercase tracking-widest text-white">Scroll</span>
        <div class="w-px h-8 bg-white/50 animate-pulse"></div>
    </div>
</section>
 
{{-- ══════════════════════════════════════════════════════════
     SECOND HERO — split image like Hishiro's two-slide layout
══════════════════════════════════════════════════════════ --}}
<section class="grid grid-cols-1 md:grid-cols-2 min-h-[70vh]">
 
    {{-- Left panel --}}
    <div class="relative overflow-hidden group min-h-[50vh] md:min-h-0">
        <div class="absolute inset-0 bg-zinc-900 group-hover:scale-105 transition-transform duration-700 ease-out"
             style="background-image: url('https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=800&q=80');
                    background-size: cover; background-position: center;">
        </div>
        <div class="absolute inset-0 bg-black/50 group-hover:bg-black/40 transition-colors duration-300"></div>
        <div class="relative z-10 flex flex-col justify-end h-full p-8 sm:p-12">
            <p class="font-mono text-[10px] uppercase tracking-[0.3em] text-rose-400 mb-2">Akutakara Series</p>
            <h2 class="font-display text-3xl sm:text-4xl uppercase text-white mb-4">Gothic Reworked</h2>
            <a href="#" class="inline-flex items-center gap-2 font-cinzel text-[11px] uppercase tracking-[0.2em] text-zinc-300 hover:text-white transition-colors">
                Explore <span>→</span>
            </a>
        </div>
    </div>
 
    {{-- Right panel --}}
    <div class="relative overflow-hidden group min-h-[50vh] md:min-h-0">
        <div class="absolute inset-0 bg-zinc-800 group-hover:scale-105 transition-transform duration-700 ease-out"
             style="background-image: url('https://images.unsplash.com/photo-1509631179647-0177331693ae?w=800&q=80');
                    background-size: cover; background-position: center top;">
        </div>
        <div class="absolute inset-0 bg-black/50 group-hover:bg-black/40 transition-colors duration-300"></div>
        <div class="relative z-10 flex flex-col justify-end h-full p-8 sm:p-12">
            <p class="font-mono text-[10px] uppercase tracking-[0.3em] text-rose-400 mb-2">Custom Order</p>
            <h2 class="font-display text-3xl sm:text-4xl uppercase text-white mb-4">Made for You</h2>
            <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 font-cinzel text-[11px] uppercase tracking-[0.2em] text-zinc-300 hover:text-white transition-colors">
                Contact Us <span>→</span>
            </a>
        </div>
    </div>
</section>
 
{{-- ══════════════════════════════════════════════════════════
     LATEST DROP — product grid teaser (akan diisi Anggota 3)
══════════════════════════════════════════════════════════ --}}
<section class="py-20 bg-black">
    <div class="max-w-screen-xl mx-auto px-5 sm:px-8">
 
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="font-mono text-[10px] uppercase tracking-[0.3em] text-rose-400 mb-2">Latest</p>
                <h2 class="font-display text-3xl sm:text-4xl uppercase text-white">Latest Drop</h2>
            </div>
            <a href="#" class="hidden sm:inline-flex items-center gap-2 font-cinzel text-[11px] uppercase tracking-[0.2em] text-zinc-500 hover:text-white transition-colors">
                View All <span>→</span>
            </a>
        </div>
 
        {{-- Product grid placeholder — Anggota 3 akan ganti dengan @foreach produk --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-px bg-zinc-900">
            @php
                $placeholders = [
                    ['name' => 'Void Jacket', 'price' => 'Rp 949.000', 'tag' => 'New'],
                    ['name' => 'Cipher Cargo', 'price' => 'Rp 749.000', 'tag' => 'Limited'],
                    ['name' => 'Ruin Hoodie', 'price' => 'Rp 579.000', 'tag' => null],
                    ['name' => 'Ash Sleeve', 'price' => 'Rp 379.000', 'tag' => 'Sold Out'],
                ];
            @endphp
            @foreach ($placeholders as $item)
                <div class="group bg-zinc-950 relative overflow-hidden">
                    {{-- Image placeholder --}}
                    <div class="aspect-[3/4] bg-zinc-900 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-zinc-800 to-zinc-950 group-hover:scale-105 transition-transform duration-500"></div>
                        {{-- Tag --}}
                        @if ($item['tag'])
                            <div class="absolute top-3 left-3 z-10">
                                <span class="font-mono text-[9px] uppercase tracking-widest px-2 py-1
                                    {{ $item['tag'] === 'Sold Out' ? 'bg-zinc-800 text-zinc-500' : 'bg-rose-600 text-white' }}">
                                    {{ $item['tag'] }}
                                </span>
                            </div>
                        @endif
                        {{-- Hover CTA --}}
                        <div class="absolute inset-x-0 bottom-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300 bg-black/80">
                            <button class="w-full font-cinzel text-[10px] uppercase tracking-[0.2em] py-2.5
                                {{ $item['tag'] === 'Sold Out' ? 'text-zinc-600 cursor-not-allowed' : 'text-white hover:text-rose-400 transition-colors' }}">
                                {{ $item['tag'] === 'Sold Out' ? 'Habis' : 'Tambah ke Keranjang' }}
                            </button>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-cinzel text-xs uppercase tracking-[0.12em] text-white mb-1">{{ $item['name'] }}</h3>
                        <p class="font-mono text-xs text-zinc-500">{{ $item['price'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
 
        <div class="text-center mt-8 sm:hidden">
            <a href="#" class="font-cinzel text-[11px] uppercase tracking-[0.2em] text-zinc-500 hover:text-white transition-colors">
                View All →
            </a>
        </div>
    </div>
</section>
 
{{-- ══════════════════════════════════════════════════════════
     BRAND STATEMENT — editorial text section
══════════════════════════════════════════════════════════ --}}
<section class="py-24 bg-zinc-950 border-t border-zinc-900">
    <div class="max-w-4xl mx-auto px-5 sm:px-8 text-center">
        <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-rose-400 mb-8">Our Philosophy</p>
        <p class="font-display text-3xl sm:text-4xl lg:text-5xl uppercase text-white leading-snug mb-8">
            Anti-fast-fashion.<br>Underground.<br>Unapologetic.
        </p>
        <div class="w-16 h-px bg-rose-600 mx-auto mb-8"></div>
        <p class="text-sm text-zinc-500 leading-relaxed max-w-xl mx-auto mb-10">
            Setiap piece Eyes of Zaharoz lahir dari penolakan terhadap keseragaman. Terbatas. Handcrafted. Tidak akan pernah direproduksi massal.
        </p>
        <a href="{{ route('about') }}"
           class="inline-block font-cinzel text-[11px] uppercase tracking-[0.25em] px-8 py-3.5 border border-zinc-700 hover:border-rose-600 text-zinc-400 hover:text-rose-400 transition-colors duration-200">
            Our Story
        </a>
    </div>
</section>
 
{{-- ══════════════════════════════════════════════════════════
     AESTHETIC PILLARS — 4 column minimal
══════════════════════════════════════════════════════════ --}}
<section class="bg-black border-t border-zinc-900">
    <div class="max-w-screen-xl mx-auto px-5 sm:px-8">
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
                <div class="py-10 px-6 group hover:bg-zinc-950 transition-colors duration-200">
                    <p class="font-mono text-[9px] text-zinc-800 mb-4">{{ $p['num'] }}</p>
                    <h3 class="font-cinzel text-xs uppercase tracking-[0.15em] text-zinc-300 mb-2 group-hover:text-rose-400 transition-colors">{{ $p['title'] }}</h3>
                    <p class="text-[11px] text-zinc-700 leading-relaxed">{{ $p['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
 
{{-- ══════════════════════════════════════════════════════════
     CTA — newsletter / register
══════════════════════════════════════════════════════════ --}}
<section class="py-24 bg-zinc-950 border-t border-zinc-900 text-center">
    <div class="max-w-lg mx-auto px-5 sm:px-8">
        <h2 class="font-display text-3xl sm:text-4xl uppercase text-white mb-3">Join the Underground</h2>
        <p class="text-xs text-zinc-600 mb-8">Daftar dan dapatkan akses ke drop terbaru & exclusive offer.</p>
        <div class="flex flex-col sm:flex-row gap-0">
            <a href="{{ route('register') }}"
               class="flex-1 font-cinzel text-[11px] uppercase tracking-[0.2em] px-8 py-4 bg-rose-600 hover:bg-rose-500 text-white transition-colors duration-200 text-center">
                Create Account
            </a>
            <a href="{{ route('contact') }}"
               class="flex-1 font-cinzel text-[11px] uppercase tracking-[0.2em] px-8 py-4 border border-zinc-800 hover:border-zinc-600 text-zinc-500 hover:text-white transition-colors duration-200 text-center">
                Contact Us
            </a>
        </div>
    </div>
</section>

</x-layout>