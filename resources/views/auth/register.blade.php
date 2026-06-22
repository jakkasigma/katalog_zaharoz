@extends('layouts.app')

@section('content')
    <section class="grid min-h-[70vh] items-center gap-8 lg:grid-cols-[1.05fr_0.95fr]">
        <x-card variant="dark" class="p-8">
            <p class="font-mono text-xs uppercase tracking-[0.3em] text-lens">Akun customer</p>
            <h1 class="mt-4 font-display text-5xl font-bold leading-tight">Buat akun sebelum memilih lensa.</h1>
            <p class="mt-5 max-w-xl text-white/70">Data dasar dipakai untuk profil, pesanan, dan alamat pengiriman.</p>
            <div class="mt-10 h-44 rounded-full border border-lens/40 p-8">
                <div class="h-full rounded-full border border-brass/50"></div>
            </div>
        </x-card>

        <x-card>
            <h2 class="font-display text-2xl font-bold">Registrasi</h2>

            <form method="POST" action="{{ route('register.store') }}" class="mt-6 grid gap-4">
                @csrf
                <div>
                    <x-label for="name">Nama lengkap</x-label>
                    <x-input id="name" name="name" value="{{ old('name') }}" required autofocus />
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <x-label for="email">Email</x-label>
                    <x-input id="email" type="email" name="email" value="{{ old('email') }}" required />
                    @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <x-label for="phone">Nomor HP</x-label>
                    <x-input id="phone" name="phone" value="{{ old('phone') }}" required />
                    @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <x-label for="password">Password</x-label>
                        <x-input id="password" type="password" name="password" required />
                        @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <x-label for="password_confirmation">Konfirmasi</x-label>
                        <x-input id="password_confirmation" type="password" name="password_confirmation" required />
                    </div>
                </div>
                <x-button type="submit">Buat akun</x-button>
            </form>
            <p class="mt-5 text-sm text-slate-600">Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-blue-600">Login</a></p>
        </x-card>
    </section>
@endsection
