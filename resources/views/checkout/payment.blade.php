<x-store-layout title="Pembayaran">

    <div class="pt-14 pb-0 bg-zinc-950 min-h-screen flex flex-col">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex-1 w-full">

            {{-- Step indicator --}}
            <div class="flex items-center gap-3 mb-10">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 flex items-center justify-center bg-zinc-800">
                        <svg class="w-3.5 h-3.5 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="square" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="font-mono text-[10px] uppercase tracking-widest text-zinc-600">Checkout</span>
                </div>
                <div class="flex-1 h-px bg-zinc-800"></div>
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 flex items-center justify-center bg-rose-600">
                        <span class="font-mono text-[10px] text-white font-bold">2</span>
                    </div>
                    <span class="font-mono text-[10px] uppercase tracking-widest text-white">Pembayaran</span>
                </div>
                <div class="flex-1 h-px bg-zinc-800"></div>
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 flex items-center justify-center bg-zinc-900 border border-zinc-800">
                        <span class="font-mono text-[10px] text-zinc-700">3</span>
                    </div>
                    <span class="font-mono text-[10px] uppercase tracking-widest text-zinc-700">Selesai</span>
                </div>
            </div>

            {{-- Header --}}
            <div class="mb-8 pb-6 border-b border-zinc-900">
                <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-rose-400 mb-2">Langkah 2 dari 3</p>
                <h1 class="font-display text-4xl uppercase text-white leading-none">Selesaikan Pembayaran</h1>
                <p class="text-sm text-zinc-600 mt-2">Transfer ke rekening atau scan QRIS, lalu upload bukti di bawah.</p>
            </div>

            @if(session('error'))
                <div class="border border-red-900 bg-red-950 p-4 mb-6">
                    <p class="font-mono text-xs text-red-400">{{ session('error') }}</p>
                </div>
            @endif

            {{-- Form wraps EVERYTHING so submit button di bawah bisa trigger form di atas --}}
            <form method="POST"
                  action="{{ route('checkout.confirm') }}"
                  enctype="multipart/form-data"
                  id="payment-form">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-[1fr_360px] gap-8 items-start">

                    {{-- LEFT: Instruksi + upload --}}
                    <div class="space-y-6">

                        {{-- Info transfer --}}
                        <div class="bg-zinc-950 border border-zinc-900 p-6">
                            <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-rose-400 mb-5">Instruksi Pembayaran</p>

                            @if($companyProfile?->bank_name || $companyProfile?->bank_account_number)
                                <div class="border border-zinc-800 bg-black p-5 mb-4">
                                    <p class="font-mono text-[9px] uppercase tracking-[0.35em] text-zinc-600 mb-3">Transfer Bank</p>
                                    <p class="font-cinzel text-xs uppercase tracking-[0.1em] text-zinc-500 mb-1">{{ $companyProfile->bank_name ?? '' }}</p>
                                    <p class="font-mono text-2xl text-white tracking-widest mb-1">{{ $companyProfile->bank_account_number ?? '—' }}</p>
                                    @if($companyProfile?->bank_account_name)
                                        <p class="font-mono text-xs text-zinc-600">a.n. {{ $companyProfile->bank_account_name }}</p>
                                    @endif
                                </div>
                            @endif

                            @if($companyProfile?->qris_path)
                                <div class="border border-zinc-800 bg-black p-5">
                                    <p class="font-mono text-[9px] uppercase tracking-[0.35em] text-zinc-600 mb-4">atau Scan QRIS</p>
                                    <img src="{{ asset('storage/' . $companyProfile->qris_path) }}"
                                         alt="QRIS"
                                         class="max-w-[220px] border border-zinc-800 blok mx-auto">
                                </div>
                            @endif

                            @if(!$companyProfile?->bank_name && !$companyProfile?->qris_path)
                                <div class="border border-dashed border-zinc-800 p-6 text-center">
                                    <p class="font-mono text-xs text-zinc-700">Info pembayaran belum diatur oleh admin.</p>
                                </div>
                            @endif
                        </div>

                        {{-- Upload bukti --}}
                        <div class="bg-zinc-950 border border-zinc-900 p-6">
                            <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-rose-400 mb-2">Upload Bukti Transfer</p>
                            <p class="text-sm text-zinc-600 mb-5">Upload screenshot atau foto bukti pembayaran setelah transfer.</p>

                            <input type="file"
                                   name="payment_proof"
                                   id="payment_proof"
                                   accept="image/jpeg,image/jpg,image/png"
                                   required
                                   class="w-full text-sm text-zinc-600
                                          file:mr-4 file:font-cinzel file:text-[10px] file:uppercase file:tracking-[0.15em]
                                          file:px-4 file:py-2.5 file:border-0 file:bg-zinc-800 file:text-zinc-300
                                          hover:file:bg-zinc-700 file:cursor-pointer
                                          bg-black border border-zinc-800 focus-within:border-rose-600 transition-colors">
                            <p class="font-mono text-[10px] text-zinc-700 mt-2">JPG, JPEG, PNG — maks. 2MB</p>
                            @error('payment_proof')
                                <p class="text-xs text-red-400 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <a href="{{ route('checkout.index') }}"
                           class="inline-flex items-center gap-2 font-mono text-[10px] uppercase tracking-[0.2em] text-zinc-700 hover:text-white transition-colors">
                            ← Ubah Alamat / Catatan
                        </a>
                    </div>

                    {{-- RIGHT: Ringkasan --}}
                    <div class="bg-zinc-950 border border-zinc-900 p-6 sticky top-20">
                        <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-rose-400 mb-5">Ringkasan Pesanan</p>

                        <div class="space-y-3 pb-5 border-b border-zinc-900 mb-5">
                            @foreach($cart->items as $item)
                                <div class="flex items-center justify-between gap-4">
                                    <div class="min-w-0">
                                        <p class="font-cinzel text-[11px] uppercase tracking-[0.05em] text-white truncate">{{ $item->product->name }}</p>
                                        <p class="font-mono text-[10px] text-zinc-700">× {{ $item->quantity }}</p>
                                    </div>
                                    <p class="font-mono text-xs text-zinc-400 shrink-0">
                                        Rp {{ number_format((float) $item->product->price * $item->quantity, 0, ',', '.') }}
                                    </p>
                                </div>
                            @endforeach
                        </div>

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

                        <div class="flex justify-between items-baseline">
                            <span class="font-cinzel text-sm uppercase tracking-[0.1em] text-white">Total Transfer</span>
                            <span class="font-mono text-2xl text-white">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        <div class="mt-5 border-t border-zinc-900 pt-5">
                            <p class="font-mono text-[9px] uppercase tracking-[0.3em] text-zinc-700">Pastikan transfer tepat:</p>
                            <p class="font-mono text-lg text-rose-400 mt-1">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                        </div>
                    </div>

                </div>

            </form>

        </div>

        {{-- Tombol konfirmasi — full width, paling bawah halaman --}}
        <div class="border-t border-zinc-900 bg-zinc-950 sticky bottom-0 z-20">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-sm text-zinc-600 hidden sm:block">
                    Upload bukti bayar lalu klik konfirmasi untuk menyelesaikan pesanan.
                </div>
                <button type="submit"
                        form="payment-form"
                        class="w-full sm:w-auto font-cinzel text-[11px] uppercase tracking-[0.25em] px-10 py-4 bg-rose-600 hover:bg-rose-500 text-white transition-colors duration-200">
                    Konfirmasi &amp; Buat Pesanan →
                </button>
            </div>
        </div>

    </div>

</x-store-layout>
