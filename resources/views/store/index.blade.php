<x-store-layout title="Katalog Produk">

    {{-- PAGE HEADER --}}
    <section class="pt-14 pb-0 bg-zinc-950 border-b border-zinc-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3 pt-6 pb-5 sm:pt-8 sm:pb-6">
                <div>
                    <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-rose-400 mb-2">The Collection</p>
                    <h1 class="font-display text-3xl sm:text-4xl uppercase text-white leading-none">Semua Produk</h1>
                </div>
                <p class="font-mono text-xs text-zinc-700">{{ $products->total() }} produk tersedia</p>
            </div>
        </div>
    </section>

    {{-- FILTER BAR --}}
    <div class="bg-zinc-950 border-b border-zinc-900 sticky top-14 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-8 py-3">
            <form method="GET" action="{{ route('store.index') }}"
                  class="flex flex-col sm:flex-row gap-2 sm:gap-3 sm:items-center">

                {{-- Search: full width on mobile --}}
                <input type="text"
                       name="search"
                       value="{{ $search }}"
                       placeholder="Cari produk..."
                       class="w-full sm:w-56 bg-black border border-zinc-800 focus:border-rose-600 text-white text-xs px-4 py-2.5 outline-none transition-colors placeholder:text-zinc-700 font-mono min-h-[44px]">

                {{-- Category: full width on mobile --}}
                <select name="category"
                        class="w-full sm:w-auto bg-black border border-zinc-800 focus:border-rose-600 text-zinc-500 text-xs px-4 py-2.5 outline-none transition-colors font-cinzel uppercase tracking-[0.1em] cursor-pointer min-h-[44px]">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}" @selected($categorySlug === $category->slug)>{{ $category->name }}</option>
                    @endforeach
                </select>

                {{-- Buttons --}}
                <div class="flex gap-2">
                    <button type="submit"
                            class="flex-1 sm:flex-none font-cinzel text-[10px] uppercase tracking-[0.2em] px-5 py-2.5 bg-rose-600 hover:bg-rose-500 text-white transition-colors min-h-[44px]">
                        Filter
                    </button>
                    @if ($search || $categorySlug)
                        <a href="{{ route('store.index') }}"
                           class="flex-1 sm:flex-none text-center font-cinzel text-[10px] uppercase tracking-[0.2em] px-5 py-2.5 border border-zinc-800 hover:border-zinc-600 text-zinc-600 hover:text-white transition-colors min-h-[44px] inline-flex items-center justify-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- PRODUCT GRID --}}
    <section class="bg-zinc-950 py-8 sm:py-10 min-h-[60vh]">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">

            @if ($search || $categorySlug)
                <p class="font-mono text-[10px] text-zinc-700 uppercase tracking-widest mb-5 sm:mb-6">
                    {{ $products->total() }} hasil
                    @if ($search) untuk "{{ $search }}"@endif
                    @if ($categorySlug) · {{ $categorySlug }}@endif
                </p>
            @endif

            @forelse ($products as $product)
                @if ($loop->first)
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-px bg-zinc-900">
                @endif

                <article class="group bg-zinc-950 flex flex-col">
                    {{-- Image --}}
                    <a href="{{ route('store.product', $product) }}" class="block relative overflow-hidden aspect-[3/4]">
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
                            <div class="absolute inset-0 bg-black/50 flex items-end p-2 sm:p-3">
                                <span class="font-mono text-[9px] uppercase tracking-widest px-2 py-1 bg-zinc-900/90 text-zinc-600">Habis</span>
                            </div>
                        @elseif ($product->stock <= 3)
                            <div class="absolute top-2 left-2">
                                <span class="font-mono text-[9px] uppercase tracking-widest px-2 py-1 bg-rose-600 text-white">Sisa {{ $product->stock }}</span>
                            </div>
                        @endif

                        {{-- Quick add — hover on desktop, tap navigates on mobile --}}
                        @auth
                            @if ($product->stock > 0)
                                <div class="absolute inset-x-0 bottom-0 translate-y-full group-hover:translate-y-0 transition-transform duration-200 bg-black/95">
                                    <form method="POST" action="{{ route('cart.store') }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit"
                                                class="w-full font-cinzel text-[9px] uppercase tracking-[0.2em] py-3 text-zinc-400 hover:text-white transition-colors">
                                            + Tambah
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </a>

                    {{-- Info --}}
                    <div class="p-3 border-t border-zinc-900 flex-1 flex flex-col gap-1">
                        @if ($product->category)
                            <p class="font-mono text-[8px] uppercase tracking-[0.25em] text-rose-400/70">{{ $product->category->name }}</p>
                        @endif
                        <h2 class="font-cinzel text-[11px] sm:text-xs uppercase tracking-[0.06em] text-white leading-snug flex-1">
                            <a href="{{ route('store.product', $product) }}" class="hover:text-rose-400 transition-colors">{{ $product->name }}</a>
                        </h2>
                        <p class="font-mono text-xs text-zinc-400 mt-1">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</p>
                    </div>
                </article>

                @if ($loop->last)
                    </div>
                @endif

            @empty
                <div class="text-center py-16 sm:py-20 border border-dashed border-zinc-900">
                    <p class="font-display text-2xl sm:text-3xl uppercase text-zinc-800 mb-3">Tidak Ditemukan</p>
                    <p class="text-sm text-zinc-700 mb-6">
                        @if ($search || $categorySlug)
                            Tidak ada produk yang cocok dengan filter kamu.
                        @else
                            Belum ada produk tersedia saat ini.
                        @endif
                    </p>
                    @if ($search || $categorySlug)
                        <a href="{{ route('store.index') }}"
                           class="inline-flex items-center justify-center font-cinzel text-[10px] uppercase tracking-[0.2em] px-5 py-3 border border-zinc-800 hover:border-rose-600 text-zinc-700 hover:text-rose-400 transition-colors min-h-[44px]">
                            Lihat Semua
                        </a>
                    @endif
                </div>
            @endforelse

            {{-- Pagination --}}
            @if ($products->hasPages())
                <div class="mt-8 sm:mt-10 flex justify-center">
                    {{ $products->links() }}
                </div>
            @endif

        </div>
    </section>

</x-store-layout>
