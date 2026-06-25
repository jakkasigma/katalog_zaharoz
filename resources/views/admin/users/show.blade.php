@extends('admin.layout')

@section('content')
    <x-card>
        <x-page-header eyebrow="Users" title="{{ $user->name }}" description="Detail akun, alamat, dan riwayat pesanan."><x-slot:actions><x-link-button :href="route('admin.users.index')" variant="secondary">Kembali</x-link-button></x-slot:actions></x-page-header>

        <div class="mt-8 grid gap-6 md:grid-cols-3">
            <div class="border border-glass bg-ink p-5"><p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Email</p><p class="mt-2 break-all text-brass">{{ $user->email }}</p></div>
            <div class="border border-glass bg-ink p-5"><p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Phone</p><p class="mt-2 text-brass">{{ $user->phone ?? '-' }}</p></div>
            <div class="border border-glass bg-ink p-5"><p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Status</p><p class="mt-2 text-brass">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</p></div>
        </div>

        <div class="mt-8 grid gap-6 lg:grid-cols-2">
            <div class="border border-glass bg-ink p-6"><h2 class="font-display text-2xl font-bold uppercase text-brass">Alamat</h2><div class="mt-4 grid gap-3">@forelse ($user->addresses as $address)<div class="border border-glass bg-night p-4 text-sm text-zinc-300">{{ $address->recipient_name }} — {{ $address->phone }}<br>{{ $address->full_address }}, {{ $address->city }}</div>@empty<p class="text-zinc-500">Belum ada alamat.</p>@endforelse</div></div>
            <div class="border border-glass bg-ink p-6"><h2 class="font-display text-2xl font-bold uppercase text-brass">Pesanan</h2><div class="mt-4 grid gap-3">@forelse ($user->orders as $order)<a href="{{ route('admin.orders.show', $order) }}" class="border border-glass bg-night p-4 text-sm text-zinc-300 hover:border-lens"><span class="font-mono text-lens">{{ $order->order_number }}</span> — Rp {{ number_format($order->total, 0, ',', '.') }} — {{ $order->status }}</a>@empty<p class="text-zinc-500">Belum ada pesanan.</p>@endforelse</div></div>
        </div>
    </x-card>
@endsection
