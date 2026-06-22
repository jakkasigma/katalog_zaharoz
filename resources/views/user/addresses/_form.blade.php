<div class=" grid gap-4 md:grid-cols-2">
    @foreach ([
        'recipient_name' => 'Nama penerima',
        'phone' => 'Nomor HP',
    ] as $field => $label)
        <div>
            <x-label for="{{ $field }}">{{ $label }}</x-label>
            <x-input id="{{ $field }}" name="{{ $field }}" value="{{ old($field, $address->$field ?? '') }}" required />
            @error($field) <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
        </div>
    @endforeach
</div>

<input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $address->latitude ?? '') }}">
<input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $address->longitude ?? '') }}">

<section
    class="mt-6 border border-glass bg-ink p-5 shadow-2xl"
    data-address-map
    data-latitude="{{ old('latitude', $address->latitude ?? '') }}"
    data-longitude="{{ old('longitude', $address->longitude ?? '') }}"
>
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="font-mono text-xs uppercase tracking-[0.25em] text-lens">Lokasi pengiriman</p>
            <h2 class="mt-1 font-display text-xl font-bold uppercase text-brass">Pilih titik pada peta</h2>
        </div>
        <x-button type="button" data-current-location class="px-4 py-2 text-sm">
            📍 Gunakan Lokasi Saya
        </x-button>
    </div>

    <div data-map-alert class="mt-4 hidden border px-4 py-3 font-mono text-sm font-medium"></div>

    <div class="mt-4 overflow-hidden border border-glass">
        <div data-map-canvas class="min-h-[400px] w-full"></div>
    </div>

    <div class="mt-4 border border-glass bg-night px-4 py-3 font-mono text-sm text-zinc-300">
        <span class="font-semibold text-brass">Koordinat terpilih:</span>
        <span data-coordinate-display>Belum dipilih</span>
    </div>

    @error('latitude') <p class="mt-2 text-sm text-red-400">{{ $message }}</p> @enderror
    @error('longitude') <p class="mt-2 text-sm text-red-400">{{ $message }}</p> @enderror
</section>

<div class="mt-6 grid gap-4 md:grid-cols-2 lg:grid-cols-4">
    @foreach ([
        'province' => 'Provinsi',
        'city' => 'Kota/Kabupaten',
        'district' => 'Kecamatan',
        'postal_code' => 'Kode pos',
    ] as $field => $label)
        <div>
            <x-label for="{{ $field }}">{{ $label }}</x-label>
            <x-input id="{{ $field }}" name="{{ $field }}" value="{{ old($field, $address->$field ?? '') }}" required />
            @error($field) <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
        </div>
    @endforeach
</div>

<div class="mt-6">
    <x-label for="full_address">Alamat lengkap / detail lokasi</x-label>
    <textarea id="full_address" name="full_address" rows="4" class="mt-2 w-full border border-glass bg-night px-4 py-3 text-brass outline-none transition placeholder:text-zinc-500 focus:border-lens focus:ring-4 focus:ring-lens/20" required>{{ old('full_address', $address->full_address ?? '') }}</textarea>
    @error('full_address') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
</div>
