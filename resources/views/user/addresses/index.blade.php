@extends('layouts.app')

@section('content')
    <x-card>
        <x-page-header eyebrow="Pengiriman" title="Alamat Saya">
            <x-slot:actions>
                <x-link-button :href="route('addresses.create')" class="px-5 py-3 text-sm">Tambah alamat</x-link-button>
            </x-slot:actions>
        </x-page-header>

        <div class="mt-8 grid gap-4 md:grid-cols-2">
            @forelse ($addresses as $address)
                <article class="border border-glass bg-ink p-5 shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2 class="font-display text-xl font-bold uppercase text-brass">{{ $address->recipient_name }}</h2>
                            <p class="mt-1 font-mono text-sm text-zinc-400">{{ $address->phone }}</p>
                        </div>
                        <div class="h-12 w-12 rotate-45 border border-lens/60"></div>
                    </div>
                    <p class="mt-4 text-sm leading-6 text-zinc-200">{{ $address->full_address }}</p>
                    <p class="mt-2 text-sm text-zinc-500">{{ $address->district }}, {{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}</p>
                    @if ($address->latitude && $address->longitude)
                        <p class="mt-3 font-mono text-xs text-zinc-500">{{ $address->latitude }} / {{ $address->longitude }}</p>
                    @endif
                    <div class="mt-5 flex gap-3 font-mono text-sm font-semibold uppercase tracking-[0.16em]">
                        <a href="{{ route('addresses.edit', $address) }}" class="text-lens">Edit</a>
                        <form method="POST" action="{{ route('addresses.destroy', $address) }}" onsubmit="return confirm('Hapus alamat ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400">Hapus</button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="border border-dashed border-lens/50 bg-ink p-8 text-center md:col-span-2">
                    <p class="font-display text-xl font-bold uppercase text-brass">Belum ada alamat.</p>
                    <p class="mt-2 text-sm text-zinc-400">Tambah alamat pengiriman pertama.</p>
                </div>
            @endforelse
        </div>
    </x-card>
@endsection
