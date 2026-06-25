<x-store-layout :title="$product->name">

    <div class="pt-14 bg-zinc-950 min-h-screen">

        {{-- Breadcrumb --}}
        <div class="border-b border-zinc-900 bg-zinc-950">
            <div class="max-w-7xl mx-auto px-4 sm:px-8 py-3">
                <nav class="flex items-center gap-2 font-mono text-[9px] uppercase tracking-[0.25em] text-zinc-700">
                    <a href="{{ route('store.index') }}" class="hover:text-rose-400 transition-colors shrink-0">Katalog</a>
                    <span>/</span>
                    @if ($product->category)
                        <span class="shrink-0">{{ $product->category->name }}</span>
                        <span>/</span>
                    @endif
                    <span class="text-zinc-500 truncate">{{ $product->name }}</span>
                </nav>
            </div>
        </div>

        {{-- Product --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-8 py-8 sm:py-12 lg:py-16">
            <div class="grid grid-cols-1 lg:grid-cols-[1fr_460px] gap-8 lg:gap-16 items-start">

                {{-- Image — full width on mobile, first in DOM so it renders top --}}
                <div class="relative">
                    @if ($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}"
                             alt="{{ $product->name }}"
                             class="w-full aspect-[4/5] object-cover">
                    @else
                        <div class="w-full aspect-[4/5] bg-zinc-900 flex items-center justify-center">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 rotate-45 border border-zinc-800"></div>
                        </div>
                    @endif

                    @if ($product->stock === 0)
                        <div class="absolute top-3 left-3 sm:top-4 sm:left-4">
                            <span class="font-mono text-[10px] uppercase tracking-widest px-3 py-1.5 bg-zinc-900/90 text-zinc-600 border border-zinc-800">Stok Habis</span>
                        </div>
                    @elseif ($product->stock <= 3)
                        <div class="absolute top-3 left-3 sm:top-4 sm:left-4">
                            <span class="font-mono text-[10px] uppercase tracking-widest px-3 py-1.5 bg-rose-600 text-white">Sisa {{ $product->stock }}</span>
                        </div>
                    @endif
                </div>

                {{-- Detail Panel --}}
                <div class="flex flex-col gap-6 sm:gap-7 lg:sticky lg:top-24">

                    <div>
                        @if ($product->category)
                            <p class="font-mono text-[9px] uppercase tracking-[0.4em] text-rose-400 mb-3">{{ $product->category->name }}</p>
                        @endif
                        <h1 class="font-display text-3xl sm:text-4xl lg:text-5xl uppercase text-white leading-none">{{ $product->name }}</h1>
                        @if ($product->sku)
                            <p class="font-mono text-[10px] text-zinc-700 mt-3 uppercase tracking-widest">SKU: {{ $product->sku }}</p>
                        @endif
                    </div>

                    {{-- Price --}}
                    <div class="border-y border-zinc-900 py-5">
                        <p class="font-mono text-2xl sm:text-3xl text-white">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</p>
                        <p class="font-mono text-[10px] text-zinc-700 mt-1 uppercase tracking-widest">
                            {{ $product->stock > 0 ? 'Tersedia ' . $product->stock . ' item' : 'Habis' }}
                        </p>
                    </div>

                    @if ($product->description)
                        <p class="text-sm text-zinc-500 leading-relaxed">{{ $product->description }}</p>
                    @endif

                    {{-- CTA --}}
                    @auth
                        @if (auth()->user()->is_admin)
                            <div class="border border-zinc-800 py-4 text-center">
                                <p class="font-cinzel text-[10px] uppercase tracking-[0.2em] text-zinc-700">Admin tidak dapat melakukan pembelian</p>
                            </div>
                        @elseif ($product->stock > 0)
                            <form method="POST" action="{{ route('cart.store') }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                {{-- Quantity + Add to Cart: stacked on mobile --}}
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <div class="flex items-center border border-zinc-800 bg-black self-start">
                                        <input type="number"
                                               name="quantity"
                                               value="1"
                                               min="1"
                                               max="{{ $product->stock }}"
                                               class="w-16 bg-transparent text-white text-center py-3.5 font-mono text-sm outline-none [appearance:textfield] min-h-[44px]">
                                        <span class="px-3 font-mono text-[10px] text-zinc-700 border-l border-zinc-800 whitespace-nowrap">/ {{ $product->stock }}</span>
                                    </div>
                                    <button type="submit"
                                            class="w-full sm:flex-1 font-cinzel text-[11px] uppercase tracking-[0.25em] py-3.5 bg-rose-600 hover:bg-rose-500 text-white transition-colors min-h-[44px]">
                                        Tambah ke Keranjang
                                    </button>
                                </div>

                                @error('quantity')
                                    <p class="text-xs text-red-400 mt-2">{{ $message }}</p>
                                @enderror
                            </form>
                        @else
                            <div class="border border-zinc-800 py-4 text-center">
                                <p class="font-cinzel text-[10px] uppercase tracking-[0.2em] text-zinc-700">Produk Habis</p>
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                           class="block text-center font-cinzel text-[11px] uppercase tracking-[0.25em] py-4 bg-rose-600 hover:bg-rose-500 text-white transition-colors min-h-[44px] flex items-center justify-center">
                            Login untuk Membeli
                        </a>
                    @endauth

                    <a href="{{ route('store.index') }}"
                       class="inline-flex items-center gap-2 font-mono text-[10px] uppercase tracking-[0.2em] text-zinc-700 hover:text-white transition-colors w-fit min-h-[44px]">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="square" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Kembali ke Katalog
                    </a>
                </div>
            </div>

            {{-- Related Products --}}
            @if ($relatedProducts->isNotEmpty())
                <div class="mt-16 sm:mt-20 pt-10 sm:pt-12 border-t border-zinc-900">
                    <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-rose-400 mb-2">Lainnya</p>
                    <h2 class="font-display text-3xl sm:text-4xl uppercase text-white mb-6 sm:mb-8">Produk Serupa</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-px bg-zinc-900">
                        @foreach ($relatedProducts as $related)
                            <article class="group bg-zinc-950">
                                <a href="{{ route('store.product', $related) }}" class="block relative aspect-[3/4] overflow-hidden">
                                    @if ($related->image_path)
                                        <img src="{{ asset('storage/' . $related->image_path) }}"
                                             alt="{{ $related->name }}"
                                             class="w-full h-full object-cover group-hover:scale-[1.03] transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full bg-zinc-900 flex items-center justify-center">
                                            <div class="w-8 h-8 sm:w-10 sm:h-10 rotate-45 border border-zinc-800"></div>
                                        </div>
                                    @endif
                                </a>
                                <div class="p-3 sm:p-4 border-t border-zinc-900">
                                    <h3 class="font-cinzel text-[11px] sm:text-xs uppercase tracking-[0.08em] text-white leading-snug">
                                        <a href="{{ route('store.product', $related) }}" class="hover:text-rose-400 transition-colors">{{ $related->name }}</a>
                                    </h3>
                                    <p class="font-mono text-xs text-zinc-600 mt-1">Rp {{ number_format((float) $related->price, 0, ',', '.') }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

</x-store-layout>
