@extends('layouts.app')

@section('content')
    <div class="grid gap-6">
        <x-card>
            <x-page-header eyebrow="Detail Produk" :title="$product->name">
                <x-slot:actions>
                    <x-link-button :href="route('products.index')" variant="secondary">Kembali</x-link-button>
                </x-slot:actions>
            </x-page-header>

            <div class="mt-8 grid gap-8 lg:grid-cols-2">
                <div class="border border-glass bg-ink">
                    @if ($product->image_path)
                        <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" class="aspect-[4/5] w-full object-cover">
                    @else
                        <div class="flex aspect-[4/5] w-full items-center justify-center bg-[radial-gradient(circle_at_center,_rgba(225,29,72,0.25),_transparent_55%)]">
                            <div class="h-28 w-28 rotate-45 border border-lens/70"></div>
                        </div>
                    @endif
                </div>

                <div class="flex flex-col gap-6">
                    <div>
                        <p class="font-mono text-xs uppercase tracking-[0.3em] text-lens">{{ $product->category?->name ?? 'Tanpa kategori' }}</p>
                        <h1 class="mt-3 font-display text-4xl font-bold uppercase text-brass">{{ $product->name }}</h1>
                        @if ($product->sku)
                            <p class="mt-2 font-mono text-xs uppercase tracking-[0.2em] text-zinc-500">SKU {{ $product->sku }}</p>
                        @endif
                    </div>

                    <p class="text-base leading-8 text-zinc-300">{{ $product->description }}</p>

                    <div class="grid gap-4 border border-glass bg-ink p-5 sm:grid-cols-2">
                        <div>
                            <p class="font-mono text-xs uppercase tracking-[0.22em] text-zinc-500">Harga</p>
                            <p class="mt-2 font-mono text-2xl font-bold text-lens">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="font-mono text-xs uppercase tracking-[0.22em] text-zinc-500">Stok</p>
                            <p class="mt-2 font-mono text-2xl font-bold {{ $product->stock > 0 ? 'text-brass' : 'text-red-400' }}">{{ $product->stock }}</p>
                        </div>
                    </div>

                    @auth
                        @if ($product->stock > 0)
                            <form method="POST" action="{{ route('cart.store') }}" class="grid gap-4 border border-glass bg-ink p-5 sm:grid-cols-[150px_1fr] sm:items-end">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div>
                                    <x-label for="quantity">Qty</x-label>
                                    <x-input id="quantity" type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" required />
                                    @error('quantity')
                                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <x-button type="submit" class="w-full">Tambah ke Keranjang</x-button>
                            </form>
                        @else
                            <div class="border border-red-600/50 bg-red-950/30 p-5 text-red-200">Produk ini sedang habis.</div>
                        @endif
                    @else
                        <x-link-button :href="route('login')" class="w-full">Login untuk membeli</x-link-button>
                    @endauth
                </div>
            </div>
        </x-card>

        @if ($relatedProducts->isNotEmpty())
            <x-card>
                <x-page-header eyebrow="Produk Terkait" title="Masih Dalam Bayangan Sama" />

                <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($relatedProducts as $related)
                        <article class="border border-glass bg-ink p-5">
                            <p class="font-mono text-xs uppercase tracking-[0.25em] text-lens">{{ $related->category?->name }}</p>
                            <h2 class="mt-2 font-display text-xl font-bold uppercase text-brass">{{ $related->name }}</h2>
                            <p class="mt-3 font-mono text-lg text-lens">Rp {{ number_format((float) $related->price, 0, ',', '.') }}</p>
                            <x-link-button :href="route('products.show', $related)" variant="secondary" class="mt-5 w-full">Lihat</x-link-button>
                        </article>
                    @endforeach
                </div>
            </x-card>
        @endif
    </div>
@endsection
