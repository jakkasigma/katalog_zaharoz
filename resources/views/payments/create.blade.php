<x-store-layout title="Upload Bukti Bayar">
    <div class="pt-14 bg-zinc-950 min-h-screen flex items-center justify-center">
        <div class="text-center py-24 px-6">
            <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-rose-400 mb-4">Pembayaran</p>
            <h1 class="font-display text-4xl uppercase text-white mb-4">Upload Bukti</h1>
            <p class="text-sm text-zinc-600 mb-8">Form upload tersedia langsung di halaman detail pesanan.</p>
            <a href="{{ route('orders.show', $order) }}"
               class="inline-block font-cinzel text-[11px] uppercase tracking-[0.25em] px-8 py-4 bg-rose-600 hover:bg-rose-500 text-white transition-colors">
                Ke Detail Pesanan →
            </a>
        </div>
    </div>
</x-store-layout>
