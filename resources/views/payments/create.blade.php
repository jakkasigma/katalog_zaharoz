@extends('layouts.app')

@section('content')
    <x-card>
        <x-page-header eyebrow="Pembayaran" title="Upload Bukti Transfer" description="Upload bukti pembayaran Anda untuk pesanan {{ $order->order_number }}." />

        <div class="mt-8 grid gap-8 lg:grid-cols-[1fr_0.6fr]">
            <form method="POST" action="{{ route('payments.store', $order) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <section class="border border-glass bg-night p-6">
                    <h2 class="font-display text-xl font-bold uppercase text-brass">Informasi Rekening</h2>
                    <div class="mt-4 space-y-4">
                        <div class="border border-glass bg-ink p-5">
                            <p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Bank BCA</p>
                            <p class="mt-3 font-mono text-2xl font-bold text-brass">1234567890</p>
                            <p class="mt-2 text-sm text-zinc-400">a.n. Eyes of Zaharoz</p>
                        </div>

                        <div class="border border-glass bg-ink p-5">
                            <p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Bank Mandiri</p>
                            <p class="mt-3 font-mono text-2xl font-bold text-brass">0987654321</p>
                            <p class="mt-2 text-sm text-zinc-400">a.n. Eyes of Zaharoz</p>
                        </div>
                    </div>

                    <div class="mt-6 border-t border-glass pt-6">
                        <p class="font-display text-lg font-bold uppercase text-brass">Total Transfer</p>
                        <p class="mt-2 font-mono text-3xl font-bold text-lens">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                        <p class="mt-3 text-sm text-zinc-400">Pastikan jumlah transfer sesuai dengan total pesanan.</p>
                    </div>
                </section>

                <section class="border border-glass bg-night p-6">
                    <h2 class="font-display text-xl font-bold uppercase text-brass">Upload Bukti</h2>
                    <p class="mt-2 text-sm text-zinc-400">Upload foto atau screenshot bukti transfer Anda.</p>

                    <div class="mt-6">
                        <x-label for="payment_proof">Bukti Pembayaran *</x-label>
                        <input type="file" id="payment_proof" name="payment_proof"
                               class="mt-2 w-full border border-glass bg-input px-4 py-3 text-sm text-brass file:mr-4 file:border-0 file:bg-lens file:px-4 file:py-2 file:font-mono file:text-xs file:uppercase file:tracking-[0.16em] file:text-white focus:border-lens focus:outline-none focus:ring-2 focus:ring-lens/50"
                               accept="image/jpeg,image/jpg,image/png" required>
                        <p class="mt-2 text-xs text-zinc-500">Format: JPG, JPEG, PNG. Maksimal 2MB.</p>
                        @error('payment_proof')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </section>

                <div class="flex gap-3">
                    <x-link-button :href="route('orders.show', $order)" variant="secondary" class="px-6 py-3">
                        Kembali
                    </x-link-button>
                    <x-button type="submit" class="px-6 py-3">
                        Upload Bukti
                    </x-button>
                </div>
            </form>

            <div class="space-y-6">
                <section class="border border-glass bg-night p-6">
                    <h2 class="font-display text-xl font-bold uppercase text-brass">Detail Pesanan</h2>
                    <div class="mt-4 space-y-3 text-sm">
                        <div>
                            <p class="font-mono text-xs uppercase tracking-[0.2em] text-zinc-500">Nomor Pesanan</p>
                            <p class="mt-1 font-mono font-bold text-brass">{{ $order->order_number }}</p>
                        </div>
                        <div>
                            <p class="font-mono text-xs uppercase tracking-[0.2em] text-zinc-500">Tanggal</p>
                            <p class="mt-1 text-zinc-300">{{ $order->created_at->format('d F Y, H:i') }}</p>
                        </div>
                        <div>
                            <p class="font-mono text-xs uppercase tracking-[0.2em] text-zinc-500">Total Bayar</p>
                            <p class="mt-1 font-mono text-xl font-bold text-lens">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </section>

                <section class="border border-dashed border-lens/50 bg-ink p-6">
                    <p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Catatan</p>
                    <ul class="mt-4 space-y-2 text-sm text-zinc-300">
                        <li class="flex gap-2">
                            <span class="text-lens">•</span>
                            <span>Upload bukti transfer yang jelas dan dapat dibaca.</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="text-lens">•</span>
                            <span>Pastikan nominal transfer sesuai dengan total pesanan.</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="text-lens">•</span>
                            <span>Admin akan memverifikasi dalam 1x24 jam.</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="text-lens">•</span>
                            <span>Pesanan akan diproses setelah pembayaran diverifikasi.</span>
                        </li>
                    </ul>
                </section>
            </div>
        </div>
    </x-card>
@endsection
