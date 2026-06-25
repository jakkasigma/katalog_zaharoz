@extends('admin.layout')

@section('content')
    <x-card>
        <x-page-header eyebrow="Reports" title="Laporan Penjualan" description="Ringkasan omzet, order, dan produk terlaris periode {{ $label }}." />

        {{-- Compact Filter Bar --}}
        <form method="GET" class="mt-8 flex flex-wrap items-center gap-3">
            <fieldset class="flex rounded border border-glass overflow-hidden">
                @foreach(['daily' => 'Harian', 'monthly' => 'Bulanan', 'yearly' => 'Tahunan'] as $val => $label)
                    <button type="submit" name="period" value="{{ $val }}"
                            class="px-4 py-2 font-mono text-[10px] uppercase tracking-[0.2em] transition-colors
                                   {{ $period === $val ? 'bg-lens text-white' : 'text-zinc-500 hover:text-brass hover:bg-white/5' }}">
                        {{ $label }}
                    </button>
                @endforeach
            </fieldset>

            @if($period === 'daily')
                <input type="date" name="date" value="{{ $date }}"
                       class="border border-glass bg-night px-4 py-2 text-brass outline-none focus:border-lens focus:ring-2 focus:ring-lens/20">
            @elseif($period === 'monthly')
                <input type="month" name="month" value="{{ $month }}"
                       class="border border-glass bg-night px-4 py-2 text-brass outline-none focus:border-lens focus:ring-2 focus:ring-lens/20">
            @else
                <input type="number" name="year" value="{{ $year }}" min="2000" max="2100" placeholder="Tahun"
                       class="border border-glass bg-night px-4 py-2 text-brass outline-none focus:border-lens focus:ring-2 focus:ring-lens/20 w-24">
            @endif
        </form>

        {{-- Stats Grid --}}
        <div class="mt-8 grid gap-6 md:grid-cols-4">
            <div class="border border-glass bg-ink p-6">
                <p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Revenue</p>
                <p class="mt-2 font-display text-2xl font-bold text-brass">Rp {{ number_format($summary['revenue'], 0, ',', '.') }}</p>
            </div>
            <div class="border border-glass bg-ink p-6">
                <p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Orders</p>
                <p class="mt-2 font-display text-3xl font-bold text-brass">{{ $summary['orders'] }}</p>
            </div>
            <div class="border border-glass bg-ink p-6">
                <p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Average</p>
                <p class="mt-2 font-display text-2xl font-bold text-brass">Rp {{ number_format($summary['average_order'], 0, ',', '.') }}</p>
            </div>
            <div class="border border-glass bg-ink p-6">
                <p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Products Sold</p>
                <p class="mt-2 font-display text-3xl font-bold text-brass">{{ $summary['products_sold'] }}</p>
            </div>
        </div>

        {{-- Top Products & Daily Sales Tables --}}
        <div class="mt-8 grid gap-6 lg:grid-cols-2">
            <div class="overflow-x-auto border border-glass bg-ink">
                <div class="border-b border-glass p-4">
                    <h2 class="font-display text-2xl font-bold uppercase text-brass">Produk Terlaris</h2>
                </div>
                <table class="w-full min-w-[520px] text-left text-sm">
                    <thead class="border-b border-glass font-mono text-xs uppercase tracking-[0.2em] text-zinc-400">
                        <tr>
                            <th class="px-4 py-3">Produk</th>
                            <th class="px-4 py-3 text-right">Qty</th>
                            <th class="px-4 py-3 text-right">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-glass text-zinc-300">
                        @forelse($topProducts as $item)
                            <tr>
                                <td class="px-4 py-4 text-brass">{{ $item->product_name }}</td>
                                <td class="px-4 py-4 text-right">{{ $item->total_quantity }}</td>
                                <td class="px-4 py-4 text-right font-mono text-lens">Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-zinc-500">Belum ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="overflow-x-auto border border-glass bg-ink">
                <div class="border-b border-glass p-4">
                    <h2 class="font-display text-2xl font-bold uppercase text-brass">Sales Harian</h2>
                </div>
                <table class="w-full min-w-[520px] text-left text-sm">
                    <thead class="border-b border-glass font-mono text-xs uppercase tracking-[0.2em] text-zinc-400">
                        <tr>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3 text-right">Orders</th>
                            <th class="px-4 py-3 text-right">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-glass text-zinc-300">
                        @forelse($dailySales as $sale)
                            <tr>
                                <td class="px-4 py-4 text-brass">{{ $sale->sale_date }}</td>
                                <td class="px-4 py-4 text-right">{{ $sale->total_orders }}</td>
                                <td class="px-4 py-4 text-right font-mono text-lens">Rp {{ number_format($sale->total_revenue, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-zinc-500">Belum ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </x-card>
@endsection
