@extends('admin.layout')

@section('content')
    <x-card>
        <x-page-header eyebrow="Inventory" title="Kelola Kategori" description="Atur kanal katalog produk gothic clothing.">
            <x-slot:actions>
                <x-link-button :href="route('admin.categories.create')">Tambah Kategori</x-link-button>
            </x-slot:actions>
        </x-page-header>

        <div class="mt-8 overflow-x-auto border border-glass bg-ink">
            <table class="w-full min-w-[720px] text-left text-sm">
                <thead class="border-b border-glass font-mono text-xs uppercase tracking-[0.2em] text-zinc-400">
                    <tr>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Slug</th>
                        <th class="px-4 py-3">Produk</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-glass text-zinc-300">
                    @forelse ($categories as $category)
                        <tr>
                            <td class="px-4 py-4 font-semibold text-brass">{{ $category->name }}</td>
                            <td class="px-4 py-4 font-mono text-xs text-zinc-500">{{ $category->slug }}</td>
                            <td class="px-4 py-4">{{ $category->products_count }}</td>
                            <td class="px-4 py-4">
                                <span class="border border-glass bg-night px-3 py-1 font-mono text-xs uppercase tracking-[0.2em] {{ $category->is_active ? 'text-green-400' : 'text-red-400' }}">
                                    {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex justify-end gap-2">
                                    <x-link-button :href="route('admin.categories.edit', $category)" variant="secondary" class="px-5 py-4 text-xs">Edit</x-link-button>
                                    <x-delete-confirm :action="route('admin.categories.destroy', $category)" :message="'Yakin ingin menghapus kategori \'' . $category->name . '\'? Tindakan ini tidak dapat dibatalkan.'">
                                        Hapus
                                    </x-delete-confirm>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-zinc-500">Belum ada kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($categories->hasPages())
            <div class="mt-6">{{ $categories->links() }}</div>
        @endif
    </x-card>
@endsection
