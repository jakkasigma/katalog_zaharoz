<x-store-layout title="Keranjang Belanja">

    <div class="pt-14 pb-16 bg-black min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-10">
                <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-rose-400 mb-3">Checkout</p>
                <h1 class="font-display text-5xl sm:text-6xl uppercase text-white leading-none">
                    Keranjang <span class="text-zinc-700">Belanja</span>
                </h1>
            </div>

            @if ($cart->items->isNotEmpty())
                <div class="grid grid-cols-1 lg:grid-cols-[1fr_360px] gap-8 items-start">

                    {{-- Items --}}
                    <div class="space-y-px bg-zinc-900">
                        @foreach ($cart->items as $item)
                            @php $itemSubtotal = (float) $item->product->price * $item->quantity; @endphp
                            <article class="bg-zinc-950 grid grid-cols-[100px_1fr] sm:grid-cols-[120px_1fr] gap-6 p-5">

                                {{-- Thumbnail --}}
                                <a href="{{ route('store.product', $item->product) }}" class="block aspect-[3/4] overflow-hidden bg-zinc-900">
                                    @if ($item->product->image_path)
                                        <img src="{{ asset('storage/'.$item->product->image_path) }}"
                                             alt="{{ $item->product->name }}"
                                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <div class="w-10 h-10 rotate-45 border border-zinc-800"></div>
                                        </div>
                                    @endif
                                </a>

                                {{-- Info --}}
                                <div class="flex flex-col justify-between gap-4 py-1">
                                    <div>
                                        @if($item->product->category)
                                            <p class="font-mono text-[9px] uppercase tracking-[0.25em] text-rose-400 mb-1">{{ $item->product->category->name }}</p>
                                        @endif
                                        <h2 class="font-cinzel text-base uppercase tracking-[0.08em] text-white leading-snug">
                                            <a href="{{ route('store.product', $item->product) }}" class="hover:text-rose-400 transition-colors">
                                                {{ $item->product->name }}
                                            </a>
                                        </h2>
                                        <p class="font-mono text-sm text-zinc-600 mt-1">Rp {{ number_format((float) $item->product->price, 0, ',', '.') }} / item</p>
                                    </div>

                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                        {{-- Qty Update --}}
                                        <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity"
                                                   value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                                                   class="w-16 bg-black border border-zinc-800 focus:border-rose-600 text-white text-center py-2 font-mono text-sm outline-none transition-colors">
                                            <button type="submit"
                                                    class="font-cinzel text-[10px] uppercase tracking-[0.15em] px-3 py-2 border border-zinc-800 hover:border-zinc-600 text-zinc-600 hover:text-white transition-colors">
                                                Update
                                            </button>
                                        </form>

                                        {{-- Price + Delete --}}
                                        <div class="flex items-center gap-4">
                                            <p class="font-mono text-base text-white">Rp {{ number_format($itemSubtotal, 0, ',', '.') }}</p>
                                            <form method="POST" action="{{ route('cart.destroy', $item) }}"
                                                  onsubmit="return confirm('Hapus dari keranjang?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="font-mono text-[10px] uppercase tracking-widest text-zinc-800 hover:text-rose-500 transition-colors">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </article>
                        @endforeach
                    </div>

                    {{-- Summary --}}
                    <aside class="bg-zinc-950 border border-zinc-900 p-6 sticky top-24">
                        <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-rose-400 mb-6">Ringkasan</p>

                        <div class="space-y-3 text-sm border-b border-zinc-900 pb-6 mb-6">
                            <div class="flex justify-between gap-4">
                                <span class="text-zinc-600">Total item</span>
                                <span class="font-mono text-zinc-400">{{ $cart->items->sum('quantity') }} pcs</span>
                            </div>
                            <div class="flex justify-between gap-4">
                                <span class="text-zinc-600">Subtotal</span>
                                <span class="font-mono text-zinc-400">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between gap-4">
                                <span class="text-zinc-600">Ongkir</span>
                                <span class="font-mono text-zinc-500 text-xs uppercase tracking-wider">Ditanggung Pembeli</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-baseline mb-8">
                            <span class="font-cinzel text-sm uppercase tracking-[0.1em] text-white">Total</span>
                            <span class="font-mono text-2xl text-white">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>

                        <a href="{{ route('checkout.index') }}"
                           class="block w-full text-center font-cinzel text-[11px] uppercase tracking-[0.25em] py-4 bg-rose-600 hover:bg-rose-500 text-white transition-colors duration-200 mb-3">
                            Lanjut Checkout
                        </a>
                        <a href="{{ route('store.index') }}"
                           class="block w-full text-center font-cinzel text-[11px] uppercase tracking-[0.2em] py-3 border border-zinc-800 hover:border-zinc-600 text-zinc-700 hover:text-white transition-colors duration-200">
                            Lanjut Belanja
                        </a>
                    </aside>

                </div>

            @else
                {{-- Empty State --}}
                <div class="text-center py-24 border border-dashed border-zinc-900">
                    <div class="w-16 h-16 rotate-45 border border-zinc-800 mx-auto mb-8"></div>
                    <p class="font-display text-3xl uppercase text-zinc-700 mb-3">Keranjang Kosong</p>
                    <p class="text-sm text-zinc-700 mb-8">Belum ada produk di keranjang kamu.</p>
                        <a href="{{ route('store.index') }}"
                           class="inline-block font-cinzel text-[11px] uppercase tracking-[0.25em] px-8 py-4 bg-rose-600 hover:bg-rose-500 text-white transition-colors duration-200">
                            Lihat Katalog
                        </a>
                </div>
            @endif

        </div>
    </div>

</x-store-layout>

