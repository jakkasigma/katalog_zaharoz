@extends('admin.layout')

@section('content')
    <x-card>
        <x-page-header eyebrow="Orders" title="Kelola Pesanan" description="Pesanan aktif yang pembayarannya sudah dikonfirmasi." />

        <form method="GET" class="mt-8 grid gap-4 md:grid-cols-[1fr_200px_auto]">
            <x-input name="search" value="{{ request('search') }}" placeholder="Cari order number" />
            <select name="status" class="mt-2 border border-glass bg-night px-4 py-3 text-brass outline-none focus:border-lens focus:ring-4 focus:ring-lens/20">
                <option value="">Semua status</option>
                @foreach (['processing', 'shipped', 'delivered', 'cancelled'] as $s)
                    <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <x-button type="submit" class="mt-2">Filter</x-button>
        </form>

        <div class="mt-8 overflow-x-auto border border-glass bg-ink">
            <table class="w-full min-w-[920px] text-left text-sm">
                <thead class="border-b border-glass font-mono text-xs uppercase tracking-[0.2em] text-zinc-400">
                    <tr>
                        <th class="px-4 py-3">Order</th>
                        <th class="px-4 py-3">User</th>
                        <th class="px-4 py-3 text-right">Total</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Payment</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-glass text-zinc-300">
                    @forelse ($orders as $order)
                        @php
                            $statusLabel = [
                                'pending'    => 'Menunggu',
                                'processing' => 'Diproses',
                                'shipped'    => 'Dikirim',
                                'delivered'  => 'Selesai',
                                'cancelled'  => 'Dibatalkan',
                            ];
                        @endphp
                        <tr>
                            <td class="px-4 py-4 font-mono text-lens">{{ $order->order_number }}</td>
                            <td class="px-4 py-4">{{ $order->user?->name ?? 'Guest' }}</td>
                            <td class="px-4 py-4 text-right font-mono text-brass">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td class="px-4 py-4">
                                <span class="border border-glass bg-night px-3 py-1 font-mono text-xs uppercase tracking-[0.2em]
                                    @if($order->status === 'delivered') text-green-400
                                    @elseif($order->status === 'shipped') text-blue-400
                                    @elseif($order->status === 'cancelled') text-red-400
                                    @elseif($order->status === 'processing') text-yellow-400
                                    @else text-zinc-400 @endif">
                                    {{ $statusLabel[$order->status] ?? $order->status }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <span class="border border-glass bg-night px-3 py-1 font-mono text-xs uppercase tracking-[0.2em]
                                    {{ $order->payment_status === 'verified' ? 'text-green-400' : ($order->payment_status === 'rejected' ? 'text-red-400' : 'text-yellow-400') }}">
                                    {{ str_replace('_', ' ', $order->payment_status) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 font-mono text-xs text-zinc-500">{{ $order->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-4 text-right">
                                <x-link-button :href="route('admin.orders.show', $order)" variant="secondary" class="px-3 py-2 text-xs">
                                    Detail
                                </x-link-button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-4 py-8 text-center text-zinc-500">Tidak ada pesanan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($orders->hasPages())<div class="mt-6">{{ $orders->links() }}</div>@endif
    </x-card>
@endsection
