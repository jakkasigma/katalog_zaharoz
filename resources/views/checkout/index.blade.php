<x-store-layout title="Checkout">

    <div class="pt-14 pb-16 bg-black min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-10 pb-8 border-b border-zinc-900">
                <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-rose-400 mb-3">Checkout</p>
                <h1 class="font-display text-5xl uppercase text-white leading-none">
                    Konfirmasi <span class="text-zinc-700">Pesanan</span>
                </h1>
            </div>

            <form method="POST" action="{{ route('checkout.store') }}">
                @csrf

                @if(session('error'))
                    <div class="border border-red-900 bg-red-950 p-4 mb-6">
                        <p class="font-mono text-xs text-red-400">{{ session('error') }}</p>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-[1fr_360px] gap-8 items-start">

                    {{-- LEFT: Alamat + Catatan --}}
                    <div class="space-y-6">

                        {{-- Alamat --}}
                        <div class="bg-zinc-950 border border-zinc-900 p-6">
                            <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-rose-400 mb-5">Alamat Pengiriman</p>

                            <div class="space-y-3">
                                @foreach ($addresses as $address)
                                    <label class="flex items-start gap-4 cursor-pointer border border-zinc-800 hover:border-zinc-600 has-[:checked]:border-rose-600 bg-black p-4 transition-colors duration-200 group">
                                        <input type="radio" name="address_id" value="{{ $address->id }}"
                                               class="mt-1 accent-rose-600"
                                               {{ ($defaultAddress && $defaultAddress->id === $address->id) ? 'checked' : '' }}
                                               required>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <p class="font-cinzel text-sm uppercase tracking-[0.08em] text-white">{{ $address->recipient_name }}</p>
                                                @if($address->is_default)
                                                    <span class="font-mono text-[9px] uppercase tracking-widest px-1.5 py-0.5 bg-rose-900 text-rose-400">Utama</span>
                                                @endif
                                            </div>
                                            <p class="font-mono text-xs text-zinc-600 mb-2">{{ $address->phone }}</p>
                                            <p class="text-xs text-zinc-500 leading-relaxed">
                                                {{ $address->full_address }},
                                                {{ $address->district }}, {{ $address->city }},
                                                {{ $address->province }} {{ $address->postal_code }}
                                            </p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                            @error('address_id')
                                <p class="mt-3 text-sm text-red-400">{{ $message }}</p>
                            @enderror

                            <a href="{{ route('addresses.create') }}"
                               class="inline-flex items-center gap-2 mt-4 font-cinzel text-[10px] uppercase tracking-[0.2em] text-zinc-700 hover:text-rose-400 transition-colors">
                                + Tambah Alamat Baru
                            </a>
                        </div>

                        {{-- Catatan --}}
                        <div class="bg-zinc-950 border border-zinc-900 p-6">
                            <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-rose-400 mb-3">Catatan (opsional)</p>
                            <textarea name="notes" rows="3"
                                      class="w-full bg-black border border-zinc-800 focus:border-rose-600 text-white text-sm px-4 py-3 outline-none transition-colors placeholder:text-zinc-800 resize-none"
                                      placeholder="Contoh: Bubble wrap extra, kirim sore, dll.">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    {{-- RIGHT: Ringkasan + Submit --}}
                    <div class="bg-zinc-950 border border-zinc-900 p-6 sticky top-24">
                        <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-rose-400 mb-5">Ringkasan Pesanan</p>

                        {{-- Items --}}
                        <div class="space-y-3 pb-5 border-b border-zinc-900 mb-5">
                            @foreach($cart->items as $item)
                                <div class="flex items-center justify-between gap-4">
                                    <div class="min-w-0">
                                        <p class="font-cinzel text-[11px] uppercase tracking-[0.05em] text-white truncate">{{ $item->product->name }}</p>
                                        <p class="font-mono text-[10px] text-zinc-700">×{{ $item->quantity }}</p>
                                    </div>
                                    <p class="font-mono text-xs text-zinc-400 shrink-0">
                                        Rp {{ number_format((float)$item->product->price * $item->quantity, 0, ',', '.') }}
                                    </p>
                                </div>
                            @endforeach
                        </div>

                        {{-- Pricing --}}
                        <div class="space-y-2 text-sm pb-5 border-b border-zinc-900 mb-5">
                            <div class="flex justify-between gap-4">
                                <span class="text-zinc-600">Subtotal</span>
                                <span class="font-mono text-zinc-400">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between gap-4">
                                <span class="text-zinc-600">Ongkir</span>
                                <span class="font-mono text-zinc-500 text-xs uppercase tracking-wider">Ditanggung Pembeli</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-baseline mb-6">
                            <span class="font-cinzel text-sm uppercase tracking-[0.1em] text-white">Total</span>
                            <span class="font-mono text-2xl text-white">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        <button type="submit"
                                class="w-full font-cinzel text-[11px] uppercase tracking-[0.25em] py-4 bg-rose-600 hover:bg-rose-500 text-white transition-colors duration-200 mb-3">
                            Lanjut ke Pembayaran →
                        </button>
                        <a href="{{ route('cart.index') }}"
                           class="block w-full text-center font-cinzel text-[11px] uppercase tracking-[0.2em] py-3 border border-zinc-800 hover:border-zinc-600 text-zinc-700 hover:text-white transition-colors duration-200">
                            ← Kembali ke Keranjang
                        </a>
                    </div>

                </div>
            </form>

        </div>
    </div>

</x-store-layout>

