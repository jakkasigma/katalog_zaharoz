<x-layout title="Katalog Produk">

    {{-- PAGE HEADER --}}
    <section class="pt-16 pb-10 bg-black border-b border-zinc-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-rose-400 mb-3">Katalog</p>
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                <h1 class="font-display text-5xl sm:text-6xl uppercase text-white leading-none">
                    The <span class="text-rose-500">Collection</span>
                </h1>
                @auth
                    @unless(auth()->user()->is_admin)
                        <a href="{{ route('cart.index') }}"
                           class="inline-flex items-center gap-2 font-cinzel text-xs uppercase tracking-[0.2em] px-5 py-3 border border-zinc-700 hover:border-rose-600 text-zinc-400 hover:text-rose-400 transition-colors duration-200 w-fit">
                            Keranjang
                            @php $cartCount = auth()->user()->cart?->items?->sum('quantity') ?? 0; @endphp
                            @if($cartCount > 0)
                                <span class="font-mono text-rose-400">{{ $cartCount }}</span>
                            @endif
                        </a>
                    @endunless
                @else
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-2 font-cinzel text-xs uppercase tracking-[0.2em] px-5 py-3 bg-rose-600 hover:bg-rose-500 text-white transition-colors duration-200 w-fit">
                        Login untuk Beli
                    </a>
                @endauth
            </div>
        </div>
    </section>

    {{-- FILTER BAR --}}
    <section class="bg-zinc-950 border-b border-zinc-900 sticky top-16 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <form method="GET" action="{{ route('store.index') }}"
                  class="flex flex-col sm:flex-row gap-3 items-start sm:items-center">
                <input type="text" name="search" value="{{ $search }}"
                       placeholder="Cari produk..."
                       class="bg-black border border-zinc-800 focus:border-rose-600 text-white text-sm px-4 py-2.5 outline-none transition-colors w-full sm:w-64 placeholder:text-zinc-700 font-mono">
                <select name="category"
                        class="bg-black border border-zinc-800 focus:border-rose-600 text-zinc-400 text-sm px-4 py-2.5 outline-none transition-colors w-full sm:w-auto font-cinzel uppercase tracking-[0.1em]">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}" @selected($categorySlug === $category->slug)>{{ $category->name }}</option>
                    @endforeach
                </select>
                <div class="flex gap-2">
                    <button type="submit"
                            class="font-cinzel text-[11px] uppercase tracking-[0.2em] px-5 py-2.5 bg-rose-600 hover:bg-rose-500 text-white transition-colors">
                        Filter
                    </button>
                    @if($search || $categorySlug)
                        <a href="{{ route('store.index') }}"
                           class="font-cinzel text-[11px] uppercase tracking-[0.2em] px-5 py-2.5 border border-zinc-800 hover:border-zinc-600 text-zinc-600 hover:text-white transition-colors">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </section>

    {{-- PRODUCT GRID --}}
    <section class="bg-black py-12 min-h-[60vh]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($search || $categorySlug)
                <p class="font-mono text-xs text-zinc-600 uppercase tracking-widest mb-8">
                    {{ $products->total() }} hasil
                    @if($search) untuk "{{ $search }}"@endif
                    @if($categorySlug) — {{ $categorySlug }}@endif
                </p>
            @endif

            @forelse ($products as $product)
                @if($loop->first)
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-px bg-zinc-900">
                @endif

                <article class="group bg-zinc-950 relative overflow-hidden flex flex-col">
                    {{-- Image --}}
                    <a href="{{ route('store.product', $product) }}" class="block relative overflow-hidden aspect-[3/4]">
                        @if ($product->image_path)
                            <img src="{{ asset('storage/'.$product->image_path) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-zinc-900 to-zinc-950 flex items-center justify-center group-hover:scale-105 transition-transform duration-500">
                                <div class="w-16 h-16 rotate-45 border border-zinc-700 group-hover:border-rose-600 transition-colors"></div>
                            </div>
                        @endif

                        {{-- Badges --}}
                        <div class="absolute top-3 left-3 flex flex-col gap-1 z-10">
                            @if($product->stock === 0)
                                <span class="font-mono text-[9px] uppercase tracking-widest px-2 py-1 bg-zinc-900/90 text-zinc-500">Habis</span>
                            @elseif($product->stock <= 3)
                                <span class="font-mono text-[9px] uppercase tracking-widest px-2 py-1 bg-rose-600/90 text-white">Sisa {{ $product->stock }}</span>
                            @endif
                        </div>

                        {{-- Quick action overlay --}}
                        @auth
                            @if($product->stock > 0)
                                <div class="absolute inset-x-0 bottom-0 translate-y-full group-hover:translate-y-0 transition-transform duration-300 bg-black/90 p-4">
                                    <form method="POST" action="{{ route('cart.store') }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit"
                                                class="w-full font-cinzel text-[10px] uppercase tracking-[0.2em] py-2.5 text-white hover:text-rose-400 transition-colors text-center">
                                            + Keranjang
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </a>

                    {{-- Info --}}
                    <div class="p-4 border-t border-zinc-900 flex flex-col gap-3 flex-1">
                        <div>
                            @if($product->category)
                                <p class="font-mono text-[9px] uppercase tracking-[0.25em] text-rose-400 mb-1">{{ $product->category->name }}</p>
                            @endif
                            <h2 class="font-cinzel text-sm uppercase tracking-[0.08em] text-white leading-snug">{{ $product->name }}</h2>
                        </div>
                        <div class="flex items-center justify-between mt-auto">
                            <p class="font-mono text-sm text-zinc-300">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</p>
                            <a href="{{ route('store.product', $product) }}"
                               class="font-mono text-[10px] uppercase tracking-widest text-zinc-600 hover:text-white transition-colors">
                                Detail →
                            </a>
                        </div>
                    </div>
                </article>

                @if($loop->last)
                    </div>
                @endif

            @empty
                <div class="text-center py-24 border border-dashed border-zinc-800">
                    <p class="font-display text-3xl uppercase text-zinc-700 mb-3">Tidak Ditemukan</p>
                    <p class="text-sm text-zinc-700">Coba ubah kata kunci atau reset filter.</p>
                    @if($search || $categorySlug)
                        <a href="{{ route('store.index') }}"
                           class="inline-block mt-6 font-cinzel text-xs uppercase tracking-[0.2em] px-6 py-3 border border-zinc-800 hover:border-rose-600 text-zinc-600 hover:text-rose-400 transition-colors">
                            Lihat Semua Produk
                        </a>
                    @endif
                </div>
            @endforelse

            {{-- Pagination --}}
            @if($products->hasPages())
                <div class="mt-12 flex justify-center">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </section>

</x-layout>
