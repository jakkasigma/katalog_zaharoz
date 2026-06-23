@extends('layouts.app')

@section('content')
    <x-card>
        <x-page-header eyebrow="Transaksi" title="Riwayat Pesanan" description="Lihat semua pesanan dan status pengiriman." />

        <div class="mt-8 space-y-4">
            @forelse ($orders as $order)
                <article class="border border-glass bg-ink p-6 transition-all hover:border-lens/50">
                    <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                        <div class="flex-1">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h2 class="font-display text-xl font-bold uppercase text-brass">{{ $order->order_number }}</h2>
                                    <p class="mt-1 font-mono text-xs text-zinc-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="h-10 w-10 rotate-45 border border-lens/60"></div>
                            </div>

                            <div class="mt-4 flex flex-wrap gap-3">
                                <span class="inline-block border border-glass bg-night px-3 py-1 font-mono text-xs uppercase tracking-[0.2em]
                                    @if($order->status === 'delivered') text-green-400 border-green-400/30
                                    @elseif($order->status === 'shipped') text-blue-400 border-blue-400/30
                                    @elseif($order->status === 'cancelled') text-red-400 border-red-400/30
                                    @else text-zinc-400 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>

                                <span class="inline-block border border-glass bg-night px-3 py-1 font-mono text-xs uppercase tracking-[0.2em]
                                    @if($order->payment_status === 'verified') text-green-400 border-green-400/30
                                    @elseif($order->payment_status === 'pending_verification') text-yellow-400 border-yellow-400/30
                                    @elseif($order->payment_status === 'rejected') text-red-400 border-red-400/30
                                    @else text-zinc-400 @endif">
                                    Payment: {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>

                            <div class="mt-4 space-y-2 text-sm">
                                <p class="text-zinc-400">{{ $order->items->count() }} item</p>
                                <p class="font-mono text-lg font-bold text-lens">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <x-link-button :href="route('orders.show', $order)" variant="secondary" class="px-6 py-2 text-sm">
                                Lihat Detail
                            </x-link-button>

                            @if(in_array($order->payment_status, ['pending', 'rejected']))
                                <x-link-button :href="route('payments.create', $order)" class="px-6 py-2 text-sm">
                                    Upload Bukti
                                </x-link-button>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <div class="border border-dashed border-lens/50 bg-ink p-12 text-center">
                    <p class="font-display text-2xl font-bold uppercase text-brass">Belum ada pesanan.</p>
                    <p class="mt-3 text-sm text-zinc-400">Pesanan Anda akan muncul di sini.</p>
                    <div class="mt-6">
                        <x-link-button :href="route('dashboard')" class="px-6 py-3">
                            Mulai Belanja
                        </x-link-button>
                    </div>
                </div>
            @endforelse
        </div>

        @if($orders->hasPages())
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @endif
    </x-card>
@endsection
