@extends('layouts.app')

@section('content')
    <x-card>
        <x-page-header eyebrow="Katalog" title="Produk Eyes Of Zaharoz" description="Pilih pakaian gothic dengan aksen merah tajam untuk ritual harianmu.">
            <x-slot:actions>
                @auth
                    <x-link-button :href="route('cart.index')" variant="secondary">Keranjang</x-link-button>
                @else
                    <x-link-button :href="route('login')" variant="secondary">Login untuk beli</x-link-button>
                @endauth
            </x-slot:actions>
        </x-page-header>

        <form method="GET" action="{{ route('products.index') }}" class="mt-8 grid gap-4 border border-glass bg-ink p-5 lg:grid-cols-[1fr_260px_auto] lg:items-end">
            <div>
                <x-label for="search">Cari Produk</x-label>
                <x-input id="search" name="search" value="{{ $search }}" placeholder="Nama, SKU, atau deskripsi..." />
            </div>

            <div>
                <x-label for="category">Kategori</x-label>
                <select id="category" name="category" class="mt-2 w-full border border-glass bg-night px-4 py-3 text-brass outline-none transition focus:border-lens focus:ring-4 focus:ring-lens/20">
                    <option value="">Semua kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}" @selected($categorySlug === $category->slug)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-3">
                <x-button type="submit">Filter</x-button>
                <x-link-button :href="route('products.index')" variant="ghost">Reset</x-link-button>
            </div>
        </form>

        <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($products as $product)
                <article class="flex flex-col border border-glass bg-ink shadow-sm">
                    <a href="{{ route('products.show', $product) }}" class="block border-b border-glass bg-night">
                        @if ($product->image_path)
                            <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" class="aspect-[4/5] w-full object-cover">
                        @else
                            <div class="flex aspect-[4/5] w-full items-center justify-center bg-[radial-gradient(circle_at_center,_rgba(225,29,72,0.22),_transparent_55%)]">
                                <div class="h-20 w-20 rotate-45 border border-lens/60"></div>
                            </div>
                        @endif
                    </a>

                    <div class="flex flex-1 flex-col gap-4 p-5">
                        <div>
                            <p class="font-mono text-xs uppercase tracking-[0.25em] text-lens">{{ $product->category?->name ?? 'Tanpa kategori' }}</p>
                            <h2 class="mt-2 font-display text-2xl font-bold uppercase text-brass">{{ $product->name }}</h2>
                            <p class="mt-2 line-clamp-3 text-sm leading-6 text-zinc-400">{{ $product->description }}</p>
                        </div>

                        <div class="mt-auto flex items-center justify-between gap-4">
                            <p class="font-mono text-lg font-bold text-lens">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</p>
                            <p class="font-mono text-xs uppercase tracking-[0.18em] {{ $product->stock > 0 ? 'text-zinc-400' : 'text-red-400' }}">
                                {{ $product->stock > 0 ? 'Stok '.$product->stock : 'Habis' }}
                            </p>
                        </div>

                        <div class="grid gap-3">
                            <x-link-button :href="route('products.show', $product)" variant="secondary" class="w-full">Detail</x-link-button>

                            @auth
                                @if ($product->stock > 0)
                                    <form method="POST" action="{{ route('cart.store') }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <x-button type="submit" class="w-full">Tambah Cart</x-button>
                                    </form>
                                @else
                                    <x-button type="button" class="w-full" disabled>Stok Habis</x-button>
                                @endif
                            @else
                                <x-link-button :href="route('login')" class="w-full">Login</x-link-button>
                            @endauth
                        </div>
                    </div>
                </article>
            @empty
                <div class="border border-dashed border-lens/50 bg-ink p-8 text-center sm:col-span-2 lg:col-span-3">
                    <p class="font-display text-xl font-bold uppercase text-brass">Produk tidak ditemukan.</p>
                    <p class="mt-2 text-sm text-zinc-400">Ubah kata kunci atau kategori untuk membuka katalog lain.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </x-card>
@endsection
