<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="mt-8 grid gap-6 lg:grid-cols-2">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="grid gap-5">
        <div>
            <x-label for="name">Nama Produk</x-label>
            <x-input id="name" name="name" value="{{ old('name', $product?->name) }}" required />
            @error('name') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
        </div>

        <div>
            <x-label for="category_id">Kategori</x-label>
            <select id="category_id" name="category_id" class="mt-2 w-full border border-glass bg-night px-4 py-3 text-brass outline-none focus:border-lens focus:ring-4 focus:ring-lens/20">
                <option value="">Tanpa kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) old('category_id', $product?->category_id) === (string) $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
        </div>

        <div>
            <x-label for="sku">SKU</x-label>
            <x-input id="sku" name="sku" value="{{ old('sku', $product?->sku) }}" />
            @error('sku') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
        </div>

        <div>
            <x-label for="description">Deskripsi</x-label>
            <textarea id="description" name="description" rows="6" class="mt-2 w-full border border-glass bg-night px-4 py-3 text-brass outline-none focus:border-lens focus:ring-4 focus:ring-lens/20">{{ old('description', $product?->description) }}</textarea>
            @error('description') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="grid gap-5">
        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <x-label for="price">Harga</x-label>
                <x-input id="price" type="number" name="price" value="{{ old('price', $product?->price) }}" min="0" step="1000" required />
                @error('price') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <x-label for="stock">Stok</x-label>
                <x-input id="stock" type="number" name="stock" value="{{ old('stock', $product?->stock ?? 0) }}" min="0" required />
                @error('stock') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <x-label for="image">Gambar Produk</x-label>
            <x-input id="image" type="file" name="image" accept="image/*" />
            @if ($product?->image_path)
                <p class="mt-2 font-mono text-xs text-zinc-500">Gambar saat ini: {{ $product->image_path }}</p>
            @endif
            @error('image') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
        </div>

        <label class="flex items-center gap-3 font-mono text-xs uppercase tracking-[0.2em] text-zinc-300">
            <input type="checkbox" name="is_active" value="1" class="border-glass bg-night text-lens" @checked(old('is_active', $product?->is_active ?? true))>
            Produk aktif
        </label>

        <div class="border border-glass bg-ink p-5">
            <p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Stock Control</p>
            <p class="mt-3 text-sm text-zinc-400">Produk nonaktif tidak muncul di katalog user, tapi tetap aman untuk histori pesanan.</p>
        </div>

        <x-button type="submit" class="w-fit">Simpan Produk</x-button>
    </div>
</form>
