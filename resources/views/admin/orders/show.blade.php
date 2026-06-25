@extends('admin.layout')

@section('content')
    <x-card>
        <x-page-header eyebrow="Orders" title="{{ $order->order_number }}" description="Detail pesanan dan kontrol status pengiriman.">
            <x-slot:actions><x-link-button :href="route('admin.orders.index')" variant="secondary">Kembali</x-link-button></x-slot:actions>
        </x-page-header>

        <div class="mt-8 grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
            <div class="grid gap-6">
                <div class="overflow-x-auto border border-glass bg-ink">
                    <table class="w-full min-w-[640px] text-left text-sm">
                        <thead class="border-b border-glass font-mono text-xs uppercase tracking-[0.2em] text-zinc-400"><tr><th class="px-4 py-3">Item</th><th class="px-4 py-3 text-right">Harga</th><th class="px-4 py-3 text-right">Qty</th><th class="px-4 py-3 text-right">Subtotal</th></tr></thead>
                        <tbody class="divide-y divide-glass text-zinc-300">
                            @forelse ($order->items as $item)
                                <tr>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-3">
                                            @if($item->product && $item->product->image_path)
                                                <img src="{{ asset('storage/' . $item->product->image_path) }}"
                                                     alt="{{ $item->product_name }}"
                                                     class="w-12 h-16 object-cover border border-glass shrink-0">
                                            @else
                                                <div class="w-12 h-16 bg-zinc-900 border border-glass flex items-center justify-center shrink-0">
                                                    <span class="font-mono text-[8px] text-zinc-700">IMG</span>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="text-brass">{{ $item->product_name }}</p>
                                                @if($item->product)
                                                    <a href="{{ route('admin.products.show', $item->product) }}" class="font-mono text-[10px] text-zinc-600 hover:text-lens transition-colors">Lihat Produk →</a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-right font-mono text-zinc-400">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-4 text-right">{{ $item->quantity }}</td>
                                    <td class="px-4 py-4 text-right font-mono text-lens">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-4 py-8 text-center text-zinc-500">Belum ada item.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="grid gap-4 md:grid-cols-3">
                    <div class="border border-glass bg-ink p-5"><p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Subtotal</p><p class="mt-2 font-mono text-brass">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</p></div>
                    <div class="border border-glass bg-ink p-5"><p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Ongkir</p><p class="mt-2 font-mono text-xs text-zinc-500 uppercase">{{ $order->shipping_cost == 0 ? 'Ditanggung Pembeli' : 'Rp '.number_format($order->shipping_cost, 0, ',', '.') }}</p></div>
                    <div class="border border-glass bg-ink p-5"><p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Total</p><p class="mt-2 font-mono text-brass">Rp {{ number_format($order->total, 0, ',', '.') }}</p></div>
                </div>

                {{-- Order Notes --}}
                @if($order->notes)
                <div class="border border-glass bg-ink p-5">
                    <p class="font-mono text-xs uppercase tracking-[0.2em] text-lens mb-2">Catatan Pesanan</p>
                    <p class="text-sm text-zinc-300">{{ $order->notes }}</p>
                </div>
                @endif

                {{-- Payment Info --}}
                @if($order->payment)
                <div class="border border-glass bg-ink p-5">
                    <p class="font-mono text-xs uppercase tracking-[0.2em] text-lens mb-2">Pembayaran</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-brass">Status: {{ ucfirst(str_replace('_', ' ', $order->payment->status)) }}</span>
                        <span class="font-mono text-sm text-brass">Rp {{ number_format($order->payment->amount, 0, ',', '.') }}</span>
                    </div>
                    @if($order->payment->method)
                        <p class="mt-1 text-xs text-zinc-500">Metode: {{ $order->payment->method }}</p>
                    @endif
                    @if($order->payment->verified_at)
                        <p class="mt-1 text-xs text-zinc-500">Diverifikasi: {{ $order->payment->verified_at->format('d M Y, H:i') }}</p>
                    @endif
                    @if($order->payment->rejection_reason)
                        <p class="mt-2 text-xs text-red-400">Alasan ditolak: {{ $order->payment->rejection_reason }}</p>
                    @endif
                    <a href="{{ route('admin.payments.show', $order->payment) }}" class="mt-3 inline-block font-mono text-xs uppercase tracking-[0.15em] text-lens hover:underline">Lihat Detail Pembayaran →</a>
                </div>
                @endif
            </div>

            <div class="grid gap-5">
                <div class="border border-glass bg-ink p-5"><p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Customer</p><p class="mt-2 text-brass">{{ $order->user?->name ?? '-' }}</p><p class="text-sm text-zinc-500">{{ $order->user?->email }}</p></div>
                <div class="border border-glass bg-ink p-5">
                    <p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Alamat Pengiriman</p>
                    @if($order->address)
                        <p class="mt-2 font-semibold text-brass">{{ $order->address->recipient_name }}</p>
                        <p class="mt-1 font-mono text-xs text-zinc-400">{{ $order->address->phone }}</p>
                        <p class="mt-3 text-sm text-zinc-300 leading-6">{{ $order->address->full_address }}</p>
                        <p class="mt-1 text-sm text-zinc-500">
                            {{ $order->address->district }}, {{ $order->address->city }}
                        </p>
                        <p class="text-sm text-zinc-500">
                            {{ $order->address->province }}, {{ $order->address->postal_code }}
                        </p>
                        @if($order->address->latitude && $order->address->longitude)
                            <a href="https://maps.google.com/?q={{ $order->address->latitude }},{{ $order->address->longitude }}"
                               target="_blank"
                               class="mt-3 inline-flex items-center gap-1.5 font-mono text-xs uppercase tracking-[0.15em] text-lens hover:underline">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Lihat di Maps
                            </a>
                        @endif
                    @else
                        <p class="mt-2 text-sm text-zinc-500">—</p>
                    @endif
                </div>
                <div class="border border-glass bg-ink p-5"><p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Status Saat Ini</p><p class="mt-2 text-brass">{{ ucfirst($order->status) }} / {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}</p><p class="mt-1 font-mono text-xs text-zinc-500">Resi: {{ $order->tracking_number ?? '-' }}</p></div>

                @if (! in_array($order->status, ['delivered', 'cancelled']))
                    <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="grid gap-4 border border-glass bg-ink p-5">
                        @csrf
                        @method('PATCH')
                        <x-label for="status">Update Status</x-label>
                        <select id="status" name="status" class="border border-glass bg-night px-4 py-3 text-brass outline-none focus:border-lens focus:ring-4 focus:ring-lens/20">
                            @foreach (['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                                <option value="{{ $status }}" @selected(old('status', $order->status) === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                        @error('status') <p class="text-sm text-red-400">{{ $message }}</p> @enderror
                        <div>
                            <x-label for="tracking_number">Nomor Resi</x-label>
                            <x-input id="tracking_number" name="tracking_number" value="{{ old('tracking_number', $order->tracking_number) }}" />
                            @error('tracking_number') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                        </div>
                        <x-button type="submit">Update Status</x-button>
                    </form>
                @endif
            </div>
        </div>
    </x-card>
@endsection
