@extends('layouts.app')

@section('content')
    <section class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
        <x-card variant="dark" class="p-8">
            <p class="font-mono text-xs uppercase tracking-[0.3em] text-lens">Dashboard user</p>
            <h1 class="mt-4 font-display text-5xl font-bold leading-tight">Halo, {{ auth()->user()->name }}.</h1>
            <p class="mt-5 max-w-2xl text-white/70">Profil, password, dan alamat pengiriman berada di satu panel customer.</p>
            <div class="mt-8 grid gap-4 md:grid-cols-3">
                <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                    <p class="font-mono text-xs text-lens">EMAIL</p>
                    <p class="mt-2 break-all text-sm">{{ auth()->user()->email }}</p>
                </div>
                <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                    <p class="font-mono text-xs text-lens">HP</p>
                    <p class="mt-2 text-sm">{{ auth()->user()->phone }}</p>
                </div>
                <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                    <p class="font-mono text-xs text-lens">ALAMAT</p>
                    <p class="mt-2 text-sm">{{ auth()->user()->addresses()->count() }} tersimpan</p>
                </div>
            </div>
        </x-card>

        <x-card>
            <h2 class="font-display text-2xl font-bold">Panel cepat</h2>
            <div class="mt-6 grid gap-3">
                <x-link-button :href="route('profile.edit')" variant="secondary" class="justify-start rounded-2xl px-4 py-4">Edit profil</x-link-button>
                <x-link-button :href="route('profile.password')" variant="secondary" class="justify-start rounded-2xl px-4 py-4">Ganti password</x-link-button>
                <x-link-button :href="route('addresses.index')" variant="secondary" class="justify-start rounded-2xl px-4 py-4">Kelola alamat</x-link-button>
            </div>
        </x-card>
    </section>
@endsection
