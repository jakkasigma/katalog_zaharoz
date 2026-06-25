<x-layout :title="$product->name">

    <div class="pt-24 pb-20 bg-black min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 font-mono text-[10px] uppercase tracking-[0.25em] text-zinc-700 mb-10">
                <a href="{{ route('store.index') }}" class="hover:text-rose-400 transition-colors">Katalog</a>
                <span>/</span>
                @if($product->category)
                    <span class="text-zinc-600">{{ $product->category->name }}</span>
                    <span>/</span>
                @endif
                <span class="text-zinc-500">{{ $product->name }}</span>
            </nav>

            {{-- Main Product Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-0 lg:gap-16 items-start">

                {{-- Image --}}
                <div class="relative">
                    @if ($product->image_path)
                        <img src="{{ asset('storage/'.$product->image_path) }}"
                             alt="{{ $product->name }}"
                             class="w-full aspect-[3/4] object-cover border border-zinc-900">
                    @else
                        <div class="w-full aspect-[3/4] bg-zinc-950 border border-zinc-900 flex items-center justify-center">
                            <div class="w-24 h-24 rotate-45 border border-zinc-700"></div>
                        </div>
                    @endif

                    @if($product->stock === 0)
                        <div class="absolute inset-0 bg-black/60 flex items-center justify-center">
                            <span class="font-display text-2xl uppercase text-zinc-500 border border-zinc-700 px-8 py-4">Habis</span>
                        </div>
                    @endif
                </div>

                {{-- Info Panel --}}
                <div class="py-8 lg:py-0 flex flex-col gap-8">

                    {{-- Category + Name --}}
                    <div>
                        @if($product->category)
                            <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-rose-400 mb-3">{{ $product->category->name }}</p>
                        @endif
                        <h1 class="font-display text-5xl sm:text-6xl uppercase text-white leading-none">{{ $product->name }}</h1>
                        @if($product->sku)
                            <p class="font-mono text-xs text-zinc-700 mt-3 uppercase tracking-widest">SKU {{ $product->sku }}</p>
                        @endif
                    </div>

                    {{-- Price + Stock --}}
                    <div class="flex items-center justify-between border-y border-zinc-900 py-6">
                        <div>
                            <p class="font-mono text-[10px] uppercase tracking-[0.3em] text-zinc-600 mb-1">Harga</p>
                            <p class="font-mono text-3xl text-white">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-mono text-[10px] uppercase tracking-[0.3em] text-zinc-600 mb-1">Stok</p>
                            <p class="font-mono text-xl {{ $product->stock > 0 ? ($product->stock <= 3 ? 'text-rose-400' : 'text-zinc-300') : 'text-zinc-700' }}">
                                {{ $product->stock > 0 ? $product->stock . ' item' : 'Habis' }}
                            </p>
                        </div>
                    </div>

                    {{-- Description --}}
                    @if($product->description)
                        <p class="text-sm text-zinc-500 leading-relaxed">{{ $product->description }}</p>
                    @endif

                    {{-- Add to Cart --}}
                    @auth
                        @if (auth()->user()->is_admin)
                            <div class="border border-zinc-800 bg-zinc-950 p-5 text-center">
                                <p class="font-cinzel text-xs uppercase tracking-[0.2em] text-zinc-700">Admin tidak dapat melakukan pembelian</p>
                            </div>
                        @elseif ($product->stock > 0)
                            <form method="POST" action="{{ route('cart.store') }}" class="space-y-4">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="flex items-center gap-4">
                                    <div class="flex items-center border border-zinc-800 bg-zinc-950">
                                        <label for="quantity" class="sr-only">Jumlah</label>
                                        <input id="quantity" type="number" name="quantity"
                                               value="1" min="1" max="{{ $product->stock }}"
                                               class="w-20 bg-transparent text-white text-center py-3 font-mono text-sm outline-none focus:border-rose-600 border-r border-zinc-800">
                                        <span class="px-4 font-mono text-xs text-zinc-700 uppercase tracking-widest">/ {{ $product->stock }}</span>
                                    </div>
                                    <button type="submit"
                                            class="flex-1 font-cinzel text-[11px] uppercase tracking-[0.25em] py-3.5 bg-rose-600 hover:bg-rose-500 text-white transition-colors duration-200 text-center">
                                        Tambah ke Keranjang
                                    </button>
                                </div>
                                @error('quantity')
                                    <p class="text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </form>
                        @else
                            <div class="border border-zinc-800 bg-zinc-950 p-5 text-center">
                                <p class="font-cinzel text-xs uppercase tracking-[0.2em] text-zinc-700">Produk Habis</p>
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                           class="block text-center font-cinzel text-[11px] uppercase tracking-[0.25em] py-4 bg-rose-600 hover:bg-rose-500 text-white transition-colors duration-200">
                            Login untuk Membeli
                        </a>
                    @endauth

                    {{-- Back Link --}}
                    <a href="{{ route('store.index') }}"
                       class="inline-flex items-center gap-2 font-cinzel text-[11px] uppercase tracking-[0.2em] text-zinc-700 hover:text-white transition-colors w-fit">
                        ← Kembali ke Katalog
                    </a>
                </div>
            </div>

            {{-- Related Products --}}
            @if ($relatedProducts->isNotEmpty())
                <div class="mt-24 border-t border-zinc-900 pt-16">
                    <div class="flex items-end justify-between mb-10">
                        <div>
                            <p class="font-mono text-[10px] uppercase tracking-[0.3em] text-rose-400 mb-2">Lainnya</p>
                            <h2 class="font-display text-3xl uppercase text-white">Produk Serupa</h2>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 lg:grid-cols-3 gap-px bg-zinc-900">
                        @foreach ($relatedProducts as $related)
                            <article class="group bg-zinc-950 overflow-hidden">
                                <a href="{{ route('store.product', $related) }}" class="block relative aspect-[3/4] overflow-hidden">
                                    @if ($related->image_path)
                                        <img src="{{ asset('storage/'.$related->image_path) }}"
                                             alt="{{ $related->name }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full bg-zinc-900 flex items-center justify-center">
                                            <div class="w-12 h-12 rotate-45 border border-zinc-800"></div>
                                        </div>
                                    @endif
                                </a>
                                <div class="p-4 border-t border-zinc-900">
                                    <h3 class="font-cinzel text-xs uppercase tracking-[0.1em] text-white mb-1">{{ $related->name }}</h3>
                                    <p class="font-mono text-xs text-zinc-600">Rp {{ number_format((float) $related->price, 0, ',', '.') }}</p>
                                    <a href="{{ route('store.product', $related) }}"
                                       class="mt-3 block font-mono text-[10px] uppercase tracking-widest text-zinc-700 hover:text-rose-400 transition-colors">
                                        Lihat →
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>

</x-layout>
