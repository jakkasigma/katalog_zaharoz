@extends('admin.layout')

@section('content')
    <x-card>
        <x-page-header eyebrow="Inventory" title="{{ $product->name }}" description="Detail produk dan histori pemesanan.">
            <x-slot:actions>
                <x-link-button :href="route('admin.products.edit', $product)">Edit</x-link-button>
                <x-link-button :href="route('admin.products.index')" variant="secondary">Kembali</x-link-button>
            </x-slot:actions>
        </x-page-header>

        <div class="mt-8 grid gap-6 lg:grid-cols-[0.8fr_1.2fr]">
            <div class="border border-glass bg-ink p-6">
                <div class="flex h-64 items-center justify-center border border-dashed border-glass bg-night text-center text-zinc-500">
                    @if ($product->image_path)
                        <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                    @else
                        <span class="font-mono text-xs uppercase tracking-[0.2em]">No Image</span>
                    @endif
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div class="border border-glass bg-ink p-5"><p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">SKU</p><p class="mt-2 text-brass">{{ $product->sku ?? '-' }}</p></div>
                <div class="border border-glass bg-ink p-5"><p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Kategori</p><p class="mt-2 text-brass">{{ $product->category?->name ?? '-' }}</p></div>
                <div class="border border-glass bg-ink p-5"><p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Harga</p><p class="mt-2 font-mono text-brass">Rp {{ number_format($product->price, 0, ',', '.') }}</p></div>
                <div class="border border-glass bg-ink p-5"><p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Stok</p><p class="mt-2 text-brass">{{ $product->stock }}</p></div>
                <div class="border border-glass bg-ink p-5 md:col-span-2"><p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Deskripsi</p><p class="mt-2 text-sm leading-6 text-zinc-300">{{ $product->description ?? '-' }}</p></div>
            </div>
        </div>
    </x-card>
@endsection
