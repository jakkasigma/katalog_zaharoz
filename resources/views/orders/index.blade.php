<x-store-layout title="Pesanan Saya">

    <div class="pt-14 pb-16 bg-black min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-10 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                <div>
                    <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-rose-400 mb-3">Akun</p>
                    <h1 class="font-display text-5xl uppercase text-white leading-none">
                        Pesanan <span class="text-zinc-700">Saya</span>
                    </h1>
                </div>
                <a href="{{ route('store.index') }}"
                   class="inline-flex items-center gap-2 font-cinzel text-xs uppercase tracking-[0.2em] px-5 py-3 border border-zinc-800 hover:border-rose-600 text-zinc-600 hover:text-rose-400 transition-colors duration-200 w-fit">
                    Belanja Lagi →
                </a>
            </div>

            {{-- Orders List --}}
            @forelse ($orders as $order)
                <article class="group border border-zinc-900 hover:border-zinc-700 bg-zinc-950 mb-px transition-colors duration-200">
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6">

                            {{-- Order Info --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-start gap-3 mb-4">
                                    <h2 class="font-mono text-sm uppercase tracking-[0.15em] text-white">{{ $order->order_number }}</h2>
                                    <span class="font-mono text-[10px] uppercase tracking-widest px-2 py-1
                                        @if($order->status === 'delivered') bg-green-950 text-green-400 border border-green-900
                                        @elseif($order->status === 'shipped') bg-blue-950 text-blue-400 border border-blue-900
                                        @elseif($order->status === 'processing') bg-zinc-900 text-yellow-400 border border-zinc-800
                                        @elseif($order->status === 'cancelled') bg-red-950 text-red-500 border border-red-900
                                        @else bg-zinc-900 text-zinc-500 border border-zinc-800 @endif">
                                        @php
                                            $statusLabel = [
                                                'pending' => 'Menunggu',
                                                'processing' => 'Diproses',
                                                'shipped' => 'Dikirim',
                                                'delivered' => 'Selesai',
                                                'cancelled' => 'Dibatalkan',
                                            ];
                                        @endphp
                                        {{ $statusLabel[$order->status] ?? $order->status }}
                                    </span>
                                    <span class="font-mono text-[10px] uppercase tracking-widest px-2 py-1
                                        @if($order->payment_status === 'verified') bg-green-950 text-green-400 border border-green-900
                                        @elseif($order->payment_status === 'waiting_confirmation') bg-yellow-950 text-yellow-400 border border-yellow-900
                                        @elseif($order->payment_status === 'rejected') bg-red-950 text-red-500 border border-red-900
                                        @else bg-zinc-900 text-zinc-600 border border-zinc-800 @endif">
                                        @php
                                            $payLabel = [
                                                'pending' => 'Belum Bayar',
                                                'waiting_confirmation' => 'Menunggu Konfirmasi',
                                                'verified' => 'Pembayaran OK',
                                                'rejected' => 'Ditolak',
                                            ];
                                        @endphp
                                        {{ $payLabel[$order->payment_status] ?? $order->payment_status }}
                                    </span>
                                </div>

                                <p class="font-mono text-xs text-zinc-700 mb-4">{{ $order->created_at->format('d M Y, H:i') }}</p>

                                {{-- Items preview --}}
                                <div class="flex items-center gap-2 flex-wrap">
                                    @foreach($order->items->take(3) as $item)
                                        <span class="font-cinzel text-[10px] uppercase tracking-[0.08em] text-zinc-600 bg-zinc-900 px-2 py-1">
                                            {{ $item->product_name }}
                                            <span class="text-zinc-700">×{{ $item->quantity }}</span>
                                        </span>
                                    @endforeach
                                    @if($order->items->count() > 3)
                                        <span class="font-mono text-[10px] text-zinc-700">+{{ $order->items->count() - 3 }} lainnya</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Price + Actions --}}
                            <div class="flex flex-col items-start md:items-end gap-4 shrink-0">
                                <p class="font-mono text-xl text-white">Rp {{ number_format($order->total, 0, ',', '.') }}</p>

                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('orders.show', $order) }}"
                                       class="font-cinzel text-[10px] uppercase tracking-[0.15em] px-4 py-2 border border-zinc-800 hover:border-zinc-600 text-zinc-500 hover:text-white transition-colors">
                                        Detail
                                    </a>
                                    @if(in_array($order->payment_status, ['pending', 'rejected']))
                                        <a href="{{ route('orders.show', $order) }}"
                                           class="font-cinzel text-[10px] uppercase tracking-[0.15em] px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white transition-colors">
                                            Bayar Sekarang
                                        </a>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </article>
            @empty
                <div class="text-center py-24 border border-dashed border-zinc-900">
                    <div class="w-16 h-16 rotate-45 border border-zinc-800 mx-auto mb-8"></div>
                    <p class="font-display text-3xl uppercase text-zinc-700 mb-3">Belum Ada Pesanan</p>
                    <p class="text-sm text-zinc-700 mb-8">Pesanan kamu akan muncul di sini.</p>
                    <a href="{{ route('store.index') }}"
                       class="inline-block font-cinzel text-[11px] uppercase tracking-[0.25em] px-8 py-4 bg-rose-600 hover:bg-rose-500 text-white transition-colors">
                        Mulai Belanja
                    </a>
                </div>
            @endforelse

            @if($orders->hasPages())
                <div class="mt-10 flex justify-center">
                    {{ $orders->links() }}
                </div>
            @endif

        </div>
    </div>

</x-store-layout>

