@extends('layouts.app')

@section('content')
    <x-card>
        <x-page-header eyebrow="Keranjang" title="Keranjang Belanja">
            <x-slot:actions>
                <x-link-button :href="route('products.index')" variant="secondary">Lanjut Belanja</x-link-button>
            </x-slot:actions>
        </x-page-header>

        @if ($cart->items->isNotEmpty())
            <div class="mt-8 grid gap-6 lg:grid-cols-[1fr_320px]">
                <div class="grid gap-4">
                    @foreach ($cart->items as $item)
                        @php
                            $subtotal = (float) $item->product->price * $item->quantity;
                        @endphp

                        <article class="grid gap-5 border border-glass bg-ink p-5 md:grid-cols-[120px_1fr]">
                            <div class="border border-glass bg-night">
                                @if ($item->product->image_path)
                                    <img src="{{ asset('storage/'.$item->product->image_path) }}" alt="{{ $item->product->name }}" class="aspect-square w-full object-cover">
                                @else
                                    <div class="flex aspect-square w-full items-center justify-center">
                                        <div class="h-12 w-12 rotate-45 border border-lens/60"></div>
                                    </div>
                                @endif
                            </div>

                            <div class="grid gap-4">
                                <div class="flex flex-col justify-between gap-4 md:flex-row">
                                    <div>
                                        <p class="font-mono text-xs uppercase tracking-[0.25em] text-lens">{{ $item->product->category?->name ?? 'Tanpa kategori' }}</p>
                                        <h2 class="mt-2 font-display text-2xl font-bold uppercase text-brass">{{ $item->product->name }}</h2>
                                        <p class="mt-2 font-mono text-sm text-zinc-400">Rp {{ number_format((float) $item->product->price, 0, ',', '.') }} / item</p>
                                    </div>
                                    <p class="font-mono text-xl font-bold text-lens">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                                </div>

                                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                                    <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-end gap-3">
                                        @csrf
                                        @method('PATCH')
                                        <div class="w-28">
                                            <x-label for="quantity-{{ $item->id }}">Qty</x-label>
                                            <x-input id="quantity-{{ $item->id }}" type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" required />
                                        </div>
                                        <x-button type="submit" variant="secondary">Update</x-button>
                                    </form>

                                    <form method="POST" action="{{ route('cart.destroy', $item) }}" onsubmit="return confirm('Hapus produk dari keranjang?')">
                                        @csrf
                                        @method('DELETE')
                                        <x-button type="submit" variant="danger">Hapus</x-button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <aside class="h-fit border border-lens/40 bg-ink p-6">
                    <p class="font-mono text-xs uppercase tracking-[0.3em] text-lens">Ringkasan</p>
                    <div class="mt-5 grid gap-3 border-b border-glass pb-5 text-sm text-zinc-300">
                        <div class="flex justify-between gap-4">
                            <span>Total item</span>
                            <span class="font-mono text-brass">{{ $cart->items->sum('quantity') }}</span>
                        </div>
                        <div class="flex justify-between gap-4">
                            <span>Subtotal</span>
                            <span class="font-mono text-brass">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <div class="mt-5 flex justify-between gap-4">
                        <span class="font-display text-xl font-bold uppercase text-brass">Total</span>
                        <span class="font-mono text-2xl font-bold text-lens">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <p class="mt-5 text-sm leading-6 text-zinc-500">Checkout akan ditangani modul order. Simpan item pilihanmu di sini.</p>
                </aside>
            </div>
        @else
            <div class="mt-8 border border-dashed border-lens/50 bg-ink p-10 text-center">
                <p class="font-display text-2xl font-bold uppercase text-brass">Keranjang masih kosong.</p>
                <p class="mt-2 text-sm text-zinc-400">Tambahkan produk gothic pertama sebelum stok menghilang.</p>
                <x-link-button :href="route('products.index')" class="mt-6">Buka Katalog</x-link-button>
            </div>
        @endif
    </x-card>
@endsection
