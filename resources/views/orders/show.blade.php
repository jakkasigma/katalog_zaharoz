@extends('layouts.app')

@section('content')
    <x-card>
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="font-mono text-xs uppercase tracking-[0.3em] text-lens">Detail Pesanan</p>
                <h1 class="mt-2 font-display text-3xl font-bold uppercase text-brass">{{ $order->order_number }}</h1>
                <p class="mt-2 font-mono text-sm text-zinc-400">{{ $order->created_at->format('d F Y, H:i') }}</p>
            </div>
            <div class="h-12 w-12 rotate-45 border border-lens/60"></div>
        </div>

        <div class="mt-8 grid gap-6 lg:grid-cols-[1fr_0.5fr]">
            <div class="space-y-6">
                <section class="border border-glass bg-night p-6">
                    <h2 class="font-display text-xl font-bold uppercase text-brass">Status Pesanan</h2>
                    <div class="mt-4 space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center border border-lens bg-lens/10">
                                <span class="font-mono text-xs font-bold text-lens">1</span>
                            </div>
                            <div>
                                <p class="font-mono text-sm font-bold uppercase tracking-[0.16em] text-brass">Pesanan Dibuat</p>
                                <p class="text-xs text-zinc-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center border
                                @if(in_array($order->payment_status, ['verified', 'pending_verification'])) border-lens bg-lens/10 @else border-glass bg-ink @endif">
                                <span class="font-mono text-xs font-bold @if(in_array($order->payment_status, ['verified', 'pending_verification'])) text-lens @else text-zinc-500 @endif">2</span>
                            </div>
                            <div>
                                <p class="font-mono text-sm font-bold uppercase tracking-[0.16em]
                                    @if(in_array($order->payment_status, ['verified', 'pending_verification'])) text-brass @else text-zinc-500 @endif">
                                    Pembayaran
                                </p>
                                @if($order->payment_status === 'verified')
                                    <p class="text-xs text-green-400">Verified</p>
                                @elseif($order->payment_status === 'pending_verification')
                                    <p class="text-xs text-yellow-400">Menunggu Verifikasi</p>
                                @elseif($order->payment_status === 'rejected')
                                    <p class="text-xs text-red-400">Ditolak</p>
                                @else
                                    <p class="text-xs text-zinc-500">Menunggu Upload</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center border
                                @if(in_array($order->status, ['packed', 'shipped', 'delivered'])) border-lens bg-lens/10 @else border-glass bg-ink @endif">
                                <span class="font-mono text-xs font-bold @if(in_array($order->status, ['packed', 'shipped', 'delivered'])) text-lens @else text-zinc-500 @endif">3</span>
                            </div>
                            <div>
                                <p class="font-mono text-sm font-bold uppercase tracking-[0.16em]
                                    @if(in_array($order->status, ['packed', 'shipped', 'delivered'])) text-brass @else text-zinc-500 @endif">
                                    Sedang Dikemas
                                </p>
                                @if(in_array($order->status, ['packed', 'shipped', 'delivered']))
                                    <p class="text-xs text-green-400">Selesai</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center border
                                @if(in_array($order->status, ['shipped', 'delivered'])) border-lens bg-lens/10 @else border-glass bg-ink @endif">
                                <span class="font-mono text-xs font-bold @if(in_array($order->status, ['shipped', 'delivered'])) text-lens @else text-zinc-500 @endif">4</span>
                            </div>
                            <div>
                                <p class="font-mono text-sm font-bold uppercase tracking-[0.16em]
                                    @if(in_array($order->status, ['shipped', 'delivered'])) text-brass @else text-zinc-500 @endif">
                                    Sedang Dikirim
                                </p>
                                @if($order->tracking_number)
                                    <p class="text-xs text-zinc-400">Resi: {{ $order->tracking_number }}</p>
                                @endif
                                @if($order->shipped_at)
                                    <p class="text-xs text-zinc-500">{{ $order->shipped_at->format('d M Y, H:i') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center border
                                @if($order->status === 'delivered') border-lens bg-lens/10 @else border-glass bg-ink @endif">
                                <span class="font-mono text-xs font-bold @if($order->status === 'delivered') text-lens @else text-zinc-500 @endif">5</span>
                            </div>
                            <div>
                                <p class="font-mono text-sm font-bold uppercase tracking-[0.16em]
                                    @if($order->status === 'delivered') text-brass @else text-zinc-500 @endif">
                                    Pesanan Selesai
                                </p>
                                @if($order->delivered_at)
                                    <p class="text-xs text-green-400">{{ $order->delivered_at->format('d M Y, H:i') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </section>

                <section class="border border-glass bg-night p-6">
                    <h2 class="font-display text-xl font-bold uppercase text-brass">Item Pesanan</h2>
                    <div class="mt-4 space-y-3">
                        @foreach($order->items as $item)
                            <div class="flex items-center gap-4 border-b border-glass pb-3 last:border-0">
                                <div class="h-16 w-16 border border-glass bg-ink"></div>
                                <div class="flex-1">
                                    <p class="font-semibold text-brass">{{ $item->product_name }}</p>
                                    <p class="mt-1 font-mono text-xs text-zinc-500">{{ $item->quantity }} × Rp {{ number_format($item->unit_price, 0, ',', '.') }}</p>
                                </div>
                                <p class="font-mono font-bold text-lens">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>

                @if($order->notes)
                    <section class="border border-glass bg-night p-6">
                        <h2 class="font-display text-xl font-bold uppercase text-brass">Catatan</h2>
                        <p class="mt-3 text-sm leading-6 text-zinc-300">{{ $order->notes }}</p>
                    </section>
                @endif
            </div>

            <div class="space-y-6">
                <section class="border border-glass bg-night p-6">
                    <h2 class="font-display text-xl font-bold uppercase text-brass">Ringkasan</h2>
                    <div class="mt-4 space-y-3 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-zinc-400">Subtotal</span>
                            <span class="font-mono text-brass">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-zinc-400">Ongkir</span>
                            <span class="font-mono text-brass">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="border-t border-glass pt-3">
                            <div class="flex items-center justify-between">
                                <span class="font-display font-bold uppercase text-brass">Total</span>
                                <span class="font-mono text-xl font-bold text-lens">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    @if(in_array($order->payment_status, ['pending', 'rejected']))
                        <div class="mt-6">
                            <x-link-button :href="route('payments.create', $order)" class="w-full justify-center px-4 py-3 text-sm">
                                Upload Bukti Pembayaran
                            </x-link-button>
                        </div>
                    @endif
                </section>

                <section class="border border-glass bg-night p-6">
                    <h2 class="font-display text-xl font-bold uppercase text-brass">Alamat Pengiriman</h2>
                    <div class="mt-4 space-y-2 text-sm">
                        <p class="font-bold text-brass">{{ $order->address->recipient_name }}</p>
                        <p class="font-mono text-zinc-400">{{ $order->address->phone }}</p>
                        <p class="mt-3 leading-6 text-zinc-300">{{ $order->address->full_address }}</p>
                        <p class="text-zinc-500">{{ $order->address->district }}, {{ $order->address->city }}</p>
                        <p class="text-zinc-500">{{ $order->address->province }} {{ $order->address->postal_code }}</p>
                    </div>
                </section>

                @if($order->payment && $order->payment->proof_path)
                    <section class="border border-glass bg-night p-6">
                        <h2 class="font-display text-xl font-bold uppercase text-brass">Bukti Pembayaran</h2>
                        <div class="mt-4">
                            <img src="{{ asset('storage/' . $order->payment->proof_path) }}" alt="Bukti Pembayaran" class="w-full border border-glass">
                            @if($order->payment->status === 'pending_verification')
                                <p class="mt-3 font-mono text-xs uppercase tracking-[0.2em] text-yellow-400">Menunggu Verifikasi Admin</p>
                            @elseif($order->payment->status === 'verified')
                                <p class="mt-3 font-mono text-xs uppercase tracking-[0.2em] text-green-400">Verified</p>
                            @elseif($order->payment->status === 'rejected')
                                <p class="mt-3 font-mono text-xs uppercase tracking-[0.2em] text-red-400">Ditolak</p>
                                @if($order->payment->rejection_reason)
                                    <p class="mt-2 text-sm text-red-400">{{ $order->payment->rejection_reason }}</p>
                                @endif
                            @endif
                        </div>
                    </section>
                @endif
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <x-link-button :href="route('orders.index')" variant="secondary" class="px-6 py-3">
                Kembali ke Riwayat
            </x-link-button>
        </div>
    </x-card>
@endsection
