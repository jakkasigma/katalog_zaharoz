{{-- Recipient Info --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
    <div>
        <label for="recipient_name" class="block font-mono text-xs uppercase tracking-[0.2em] text-zinc-500 mb-2">Nama Penerima</label>
        <input id="recipient_name"
               type="text"
               name="recipient_name"
               value="{{ old('recipient_name', $address->recipient_name ?? '') }}"
               required
               class="w-full px-4 py-3 bg-black border border-zinc-800 text-white placeholder-zinc-700 focus:border-rose-600 focus:outline-none focus:ring-1 focus:ring-rose-600 transition-colors"
               placeholder="John Doe">
        @error('recipient_name')
            <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="phone" class="block font-mono text-xs uppercase tracking-[0.2em] text-zinc-500 mb-2">Nomor HP</label>
        <input id="phone"
               type="text"
               name="phone"
               value="{{ old('phone', $address->phone ?? '') }}"
               required
               class="w-full px-4 py-3 bg-black border border-zinc-800 text-white placeholder-zinc-700 focus:border-rose-600 focus:outline-none focus:ring-1 focus:ring-rose-600 transition-colors"
               placeholder="081234567890">
        @error('phone')
            <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
        @enderror
    </div>
</div>

{{-- Hidden Coordinates --}}
<input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $address->latitude ?? '') }}">
<input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $address->longitude ?? '') }}">

{{-- Map Picker --}}
<section class="border border-zinc-800 bg-zinc-950 p-6"
         data-address-map
         data-latitude="{{ old('latitude', $address->latitude ?? '') }}"
         data-longitude="{{ old('longitude', $address->longitude ?? '') }}">

    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
        <div>
            <p class="font-mono text-xs uppercase tracking-[0.25em] text-rose-400 mb-1">Lokasi Pengiriman</p>
            <h2 class="font-display text-xl uppercase text-white">Pilih Titik Pada Peta</h2>
        </div>
        <button type="button"
                data-current-location
                class="font-cinzel text-xs uppercase tracking-[0.15em] px-4 py-2 border border-zinc-700 hover:border-rose-600 text-zinc-400 hover:text-rose-400 transition-colors duration-200">
            📍 Gunakan Lokasi Saya
        </button>
    </div>

    <div data-map-alert class="mb-4 hidden px-4 py-3 bg-rose-950/50 border border-rose-900/50 rounded font-mono text-sm text-rose-400"></div>

    <div class="overflow-hidden border border-zinc-800 mb-4">
        <div data-map-canvas class="min-h-[400px] w-full bg-zinc-900"></div>
    </div>

    <div class="px-4 py-3 bg-black border border-zinc-800 font-mono text-sm">
        <span class="text-zinc-500">Koordinat terpilih:</span>
        <span data-coordinate-display class="text-zinc-300 ml-2">Belum dipilih</span>
    </div>

    @error('latitude')
        <p class="mt-2 text-xs text-rose-400">{{ $message }}</p>
    @enderror
    @error('longitude')
        <p class="mt-2 text-xs text-rose-400">{{ $message }}</p>
    @enderror
</section>

{{-- Address Details --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
    <div>
        <label for="province" class="block font-mono text-xs uppercase tracking-[0.2em] text-zinc-500 mb-2">Provinsi</label>
        <input id="province"
               type="text"
               name="province"
               value="{{ old('province', $address->province ?? '') }}"
               required
               class="w-full px-4 py-3 bg-black border border-zinc-800 text-white placeholder-zinc-700 focus:border-rose-600 focus:outline-none focus:ring-1 focus:ring-rose-600 transition-colors"
               placeholder="Jawa Barat">
        @error('province')
            <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="city" class="block font-mono text-xs uppercase tracking-[0.2em] text-zinc-500 mb-2">Kota/Kabupaten</label>
        <input id="city"
               type="text"
               name="city"
               value="{{ old('city', $address->city ?? '') }}"
               required
               class="w-full px-4 py-3 bg-black border border-zinc-800 text-white placeholder-zinc-700 focus:border-rose-600 focus:outline-none focus:ring-1 focus:ring-rose-600 transition-colors"
               placeholder="Bandung">
        @error('city')
            <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="district" class="block font-mono text-xs uppercase tracking-[0.2em] text-zinc-500 mb-2">Kecamatan</label>
        <input id="district"
               type="text"
               name="district"
               value="{{ old('district', $address->district ?? '') }}"
               required
               class="w-full px-4 py-3 bg-black border border-zinc-800 text-white placeholder-zinc-700 focus:border-rose-600 focus:outline-none focus:ring-1 focus:ring-rose-600 transition-colors"
               placeholder="Coblong">
        @error('district')
            <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="postal_code" class="block font-mono text-xs uppercase tracking-[0.2em] text-zinc-500 mb-2">Kode Pos</label>
        <input id="postal_code"
               type="text"
               name="postal_code"
               value="{{ old('postal_code', $address->postal_code ?? '') }}"
               required
               class="w-full px-4 py-3 bg-black border border-zinc-800 text-white placeholder-zinc-700 focus:border-rose-600 focus:outline-none focus:ring-1 focus:ring-rose-600 transition-colors"
               placeholder="40132">
        @error('postal_code')
            <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
        @enderror
    </div>
</div>

{{-- Full Address --}}
<div>
    <label for="full_address" class="block font-mono text-xs uppercase tracking-[0.2em] text-zinc-500 mb-2">Alamat Lengkap / Detail Lokasi</label>
    <textarea id="full_address"
              name="full_address"
              rows="4"
              required
              class="w-full px-4 py-3 bg-black border border-zinc-800 text-white placeholder-zinc-700 focus:border-rose-600 focus:outline-none focus:ring-1 focus:ring-rose-600 transition-colors resize-none"
              placeholder="Jl. Dipatiukur No. 35, detail patokan, dll.">{{ old('full_address', $address->full_address ?? '') }}</textarea>
    @error('full_address')
        <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
    @enderror
</div>


