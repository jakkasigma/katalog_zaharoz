@extends('admin.layout')

@section('content')
    <x-card>
        <x-page-header eyebrow="Inventory" title="Kelola Produk" description="Atur katalog, harga, stok, dan status produk.">
            <x-slot:actions>
                <x-link-button :href="route('admin.products.create')">Tambah Produk</x-link-button>
            </x-slot:actions>
        </x-page-header>

        <form method="GET" class="mt-8 grid gap-4 md:grid-cols-[1fr_220px_180px_auto]">
            <x-input name="search" value="{{ request('search') }}" placeholder="Cari nama / SKU" />
            <select name="category" class="mt-2 border border-glass bg-night px-4 py-3 text-brass outline-none focus:border-lens focus:ring-4 focus:ring-lens/20">
                <option value="">Semua kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) request('category') === (string) $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            <select name="status" class="mt-2 border border-glass bg-night px-4 py-3 text-brass outline-none focus:border-lens focus:ring-4 focus:ring-lens/20">
                <option value="">Semua status</option>
                <option value="active" @selected(request('status') === 'active')>Aktif</option>
                <option value="inactive" @selected(request('status') === 'inactive')>Nonaktif</option>
            </select>
            <x-button type="submit" class="mt-2">Filter</x-button>
        </form>

        <div class="mt-8 overflow-x-auto border border-glass bg-ink">
            <table class="w-full min-w-[960px] text-left text-sm">
                <thead class="border-b border-glass font-mono text-xs uppercase tracking-[0.2em] text-zinc-400">
                    <tr>
                        <th class="px-4 py-3">Produk</th>
                        <th class="px-4 py-3">SKU</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3 text-right">Harga</th>
                        <th class="px-4 py-3 text-right">Stok</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-glass text-zinc-300">
                    @forelse ($products as $product)
                        <tr>
                            <td class="px-4 py-4">
                                <div class="font-semibold text-brass">{{ $product->name }}</div>
                                <div class="font-mono text-xs text-zinc-500">{{ $product->slug }}</div>
                            </td>
                            <td class="px-4 py-4 font-mono text-xs">{{ $product->sku ?? '-' }}</td>
                            <td class="px-4 py-4">{{ $product->category?->name ?? '-' }}</td>
                            <td class="px-4 py-4 text-right font-mono text-lens">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-4 text-right">{{ $product->stock }}</td>
                            <td class="px-4 py-4">
                                <span class="border border-glass bg-night px-3 py-1 font-mono text-xs uppercase tracking-[0.2em] {{ $product->is_active ? 'text-green-400' : 'text-red-400' }}">
                                    {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex justify-end gap-2">
                                    <x-link-button :href="route('admin.products.show', $product)" variant="ghost" class="px-3 py-2 text-xs">Detail</x-link-button>
                                    <x-link-button :href="route('admin.products.edit', $product)" variant="secondary" class="px-3 py-2 text-xs">Edit</x-link-button>
                                    <x-delete-confirm :action="route('admin.products.destroy', $product)" :message="'Yakin ingin menghapus produk \'' . $product->name . '\'? Tindakan ini tidak dapat dibatalkan.'" class="px-3 py-2 text-xs">
                                        Hapus
                                    </x-delete-confirm>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-4 py-8 text-center text-zinc-500">Belum ada produk.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($products->hasPages())
            <div class="mt-6">{{ $products->links() }}</div>
        @endif
    </x-card>
@endsection
