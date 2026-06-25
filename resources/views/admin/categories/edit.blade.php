@extends('admin.layout')

@section('content')
    <x-card>
        <x-page-header eyebrow="Inventory" title="Edit Kategori" description="Perbarui kategori {{ $category->name }}.">
            <x-slot:actions>
                <x-link-button :href="route('admin.categories.index')" variant="secondary">Kembali</x-link-button>
            </x-slot:actions>
        </x-page-header>

        <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="mt-8 grid gap-5">
            @csrf
            @method('PATCH')
            <div>
                <x-label for="name">Nama</x-label>
                <x-input id="name" name="name" value="{{ old('name', $category->name) }}" required />
                @error('name') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <x-label for="description">Deskripsi</x-label>
                <textarea id="description" name="description" rows="4" class="mt-2 w-full border border-glass bg-night px-4 py-3 text-brass outline-none focus:border-lens focus:ring-4 focus:ring-lens/20">{{ old('description', $category->description) }}</textarea>
                @error('description') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <x-label for="sort_order">Urutan</x-label>
                <x-input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0" />
                @error('sort_order') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
            </div>
            <label class="flex items-center gap-3 font-mono text-xs uppercase tracking-[0.2em] text-zinc-300">
                <input type="checkbox" name="is_active" value="1" class="border-glass bg-night text-lens" @checked(old('is_active', $category->is_active))>
                Aktif
            </label>
            <x-button type="submit" class="w-fit">Simpan Perubahan</x-button>
        </form>
    </x-card>
@endsection
