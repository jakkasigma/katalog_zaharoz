@extends('layouts.app')

@section('content')
    <x-card>
        <x-page-header eyebrow="Checkout" title="Konfirmasi Pesanan" description="Pilih alamat pengiriman dan review pesanan Anda." />

        <form method="POST" action="{{ route('checkout.store') }}" class="mt-8">
            @csrf

            <div class="space-y-8">
                <div>
                    <h2 class="font-display text-xl font-bold uppercase text-brass">Alamat Pengiriman</h2>
                    <p class="mt-2 text-sm text-zinc-400">Pilih alamat tujuan pengiriman.</p>

                    <div class="mt-6 grid gap-4 md:grid-cols-2">
                        @foreach ($addresses as $address)
                            <label class="group cursor-pointer border border-glass bg-ink p-5 transition-all hover:border-lens/50 has-[:checked]:border-lens">
                                <div class="flex items-start gap-4">
                                    <input type="radio" name="address_id" value="{{ $address->id }}"
                                           class="mt-1 text-lens focus:ring-lens"
                                           {{ ($defaultAddress && $defaultAddress->id === $address->id) ? 'checked' : '' }}
                                           required>
                                    <div class="flex-1">
                                        <h3 class="font-display text-lg font-bold uppercase text-brass">{{ $address->recipient_name }}</h3>
                                        <p class="mt-1 font-mono text-sm text-zinc-400">{{ $address->phone }}</p>
                                        <p class="mt-3 text-sm leading-6 text-zinc-200">{{ $address->full_address }}</p>
                                        <p class="mt-2 text-sm text-zinc-500">{{ $address->district }}, {{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}</p>
                                        @if ($address->is_default)
                                            <span class="mt-3 inline-block font-mono text-xs uppercase tracking-[0.2em] text-lens">Alamat Utama</span>
                                        @endif
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    @error('address_id')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror

                    <div class="mt-4">
                        <x-link-button :href="route('addresses.create')" variant="secondary" class="px-4 py-2 text-sm">
                            + Tambah Alamat Baru
                        </x-link-button>
                    </div>
                </div>

                <div>
                    <h2 class="font-display text-xl font-bold uppercase text-brass">Catatan Pesanan</h2>
                    <p class="mt-2 text-sm text-zinc-400">Opsional. Tambahkan catatan khusus untuk pesanan ini.</p>

                    <div class="mt-6">
                        <textarea name="notes" rows="4"
                                  class="w-full border border-glass bg-input px-4 py-3 text-sm text-brass placeholder:text-zinc-500 focus:border-lens focus:outline-none focus:ring-2 focus:ring-lens/50"
                                  placeholder="Contoh: Kirim setelah tanggal 25, tolong packing bubble wrap extra, dll.">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="border-t border-glass pt-6">
                    <div class="flex flex-col items-end gap-4">
                        <div class="w-full max-w-md space-y-3 border border-glass bg-night p-6">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-zinc-400">Subtotal</span>
                                <span class="font-mono text-brass">Rp 0</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-zinc-400">Ongkos Kirim</span>
                                <span class="font-mono text-brass">Rp 0</span>
                            </div>
                            <div class="border-t border-glass pt-3">
                                <div class="flex items-center justify-between">
                                    <span class="font-display text-lg font-bold uppercase text-brass">Total</span>
                                    <span class="font-mono text-2xl font-bold text-lens">Rp 0</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <x-link-button :href="route('dashboard')" variant="secondary" class="px-6 py-3">
                                Kembali
                            </x-link-button>
                            <x-button type="submit" class="px-6 py-3">
                                Buat Pesanan
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </x-card>
@endsection
