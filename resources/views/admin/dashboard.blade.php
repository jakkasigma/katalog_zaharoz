@extends('admin.layout')

@section('content')
    <x-card>
        <x-page-header
            eyebrow="Admin Control"
            title="Dashboard"
            description="Kelola inventory, pesanan, dan laporan Eye of Zaharoz."
        />

        <div class="mt-8 grid gap-6 md:grid-cols-4">
            <div class="border border-glass bg-ink p-6">
                <p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Total Users</p>
                <p class="mt-2 font-display text-3xl font-bold text-brass">{{ $stats['users'] }}</p>
            </div>

            <div class="border border-glass bg-ink p-6">
                <p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Total Products</p>
                <p class="mt-2 font-display text-3xl font-bold text-brass">{{ $stats['products'] }}</p>
            </div>

            <div class="border border-glass bg-ink p-6">
                <p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Pending Payments</p>
                <p class="mt-2 font-display text-3xl font-bold text-brass">{{ $stats['pending_payments'] }}</p>
            </div>

            <div class="border border-glass bg-ink p-6">
                <p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Pending Orders</p>
                <p class="mt-2 font-display text-3xl font-bold text-brass">{{ $stats['pending_orders'] }}</p>
            </div>
        </div>

        <div class="mt-8 border-t border-glass pt-6">
            <p class="font-mono text-xs uppercase tracking-[0.25em] text-zinc-400">Quick Actions</p>
            <div class="mt-4 flex flex-wrap gap-3">
                <x-link-button :href="route('admin.products.index')">Kelola Produk</x-link-button>
                <x-link-button :href="route('admin.payments.index')" variant="secondary">Verifikasi Pembayaran</x-link-button>
                <x-link-button :href="route('admin.orders.index')" variant="secondary">Lihat Pesanan</x-link-button>
                <x-link-button :href="route('admin.reports.index')" variant="secondary">Laporan</x-link-button>
            </div>
        </div>

        <div class="mt-8 overflow-x-auto border border-glass bg-ink">
            <table class="w-full min-w-[720px] text-left text-sm">
                <thead class="border-b border-glass font-mono text-xs uppercase tracking-[0.2em] text-zinc-400">
                    <tr>
                        <th class="px-4 py-3">Order</th>
                        <th class="px-4 py-3">User</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Payment</th>
                        <th class="px-4 py-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-glass text-zinc-300">
                    @forelse ($recentOrders as $order)
                        <tr>
                            <td class="px-4 py-4 font-mono text-lens">
                                <a href="{{ route('admin.orders.show', $order) }}" class="hover:text-rose-300">{{ $order->order_number }}</a>
                            </td>
                            <td class="px-4 py-4">{{ $order->user?->name ?? 'Guest' }}</td>
                            <td class="px-4 py-4">{{ ucfirst($order->status) }}</td>
                            <td class="px-4 py-4">{{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}</td>
                            <td class="px-4 py-4 text-right font-mono text-brass">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-zinc-500">Belum ada pesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>
@endsection
