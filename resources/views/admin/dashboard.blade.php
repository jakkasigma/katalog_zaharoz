@extends('admin.layout')

@section('content')
    <x-card>
        <x-page-header
            eyebrow="Admin Control"
            title="Dashboard"
            description="Kelola inventory, pesanan, dan laporan Eyes of Zaharoz."
        />

        <div class="mt-8 grid gap-6 md:grid-cols-4">
            <div class="border border-glass bg-ink p-6">
                <p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Total Users</p>
                <p class="mt-2 font-display text-3xl font-bold text-brass">-</p>
            </div>

            <div class="border border-glass bg-ink p-6">
                <p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Total Products</p>
                <p class="mt-2 font-display text-3xl font-bold text-brass">-</p>
            </div>

            <div class="border border-glass bg-ink p-6">
                <p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Pending Payments</p>
                <p class="mt-2 font-display text-3xl font-bold text-brass">-</p>
            </div>

            <div class="border border-glass bg-ink p-6">
                <p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Pending Orders</p>
                <p class="mt-2 font-display text-3xl font-bold text-brass">-</p>
            </div>
        </div>

        <div class="mt-8 border-t border-glass pt-6">
            <p class="font-mono text-xs uppercase tracking-[0.25em] text-zinc-400">Quick Actions</p>
            <div class="mt-4 flex flex-wrap gap-3">
                <x-link-button href="#">Kelola Produk</x-link-button>
                <x-link-button href="#" variant="secondary">Verifikasi Pembayaran</x-link-button>
                <x-link-button href="#" variant="secondary">Lihat Pesanan</x-link-button>
            </div>
        </div>
    </x-card>
@endsection
