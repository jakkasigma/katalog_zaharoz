@extends('layouts.app')

@section('content')
    <section class="mx-auto grid min-h-[76vh] max-w-5xl border border-glass bg-ink shadow-2xl lg:grid-cols-2">
        <div class="relative hidden overflow-hidden border-r border-glass bg-night p-10 lg:block">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(225,29,72,0.32),transparent_28%),linear-gradient(135deg,rgba(255,255,255,0.08)_0_1px,transparent_1px_22px)]"></div>
            <div class="absolute left-10 top-10 h-44 w-44 rotate-45 border border-lens/60"></div>
            <div class="absolute bottom-16 right-12 h-32 w-32 -rotate-12 border border-brass/20"></div>
            <div class="absolute bottom-0 left-0 h-56 w-56 bg-lens/20 blur-3xl"></div>

            <div class="relative flex h-full flex-col justify-between">
                <a href="{{ url('/') }}" class="font-display text-xl font-bold uppercase tracking-[0.22em] text-brass">
                    Eyes <span class="text-lens">Of</span> Zaharoz
                </a>

                <div>
                    <p class="font-mono text-xs uppercase tracking-[0.35em] text-lens">Custom gothic wear</p>
                    <h1 class="mt-5 font-display text-5xl font-bold uppercase leading-none text-brass">
                        Sign in to the darkroom.
                    </h1>
                    <p class="mt-5 max-w-sm text-sm leading-6 text-zinc-400">
                        Masuk untuk kelola profil, alamat pengiriman, dan checkout koleksi custom gothic.
                    </p>
                </div>

                <div class="border-t border-glass pt-5 font-mono text-xs uppercase tracking-[0.25em] text-zinc-500">
                    Rework • Cybersigilism • Anti fast fashion
                </div>
            </div>
        </div>

        <div class="flex items-center p-6 sm:p-10">
            <div class="w-full">
                <div class="mb-8 lg:hidden">
                    <p class="font-display text-xl font-bold uppercase tracking-[0.22em] text-brass">
                        Eyes <span class="text-lens">Of</span> Zaharoz
                    </p>
                </div>

                <div class="mb-8">
                    <p class="font-mono text-xs uppercase tracking-[0.3em] text-lens">Customer login</p>
                    <h2 class="mt-3 font-display text-4xl font-bold uppercase text-brass">Masuk akun</h2>
                    <p class="mt-3 text-sm text-zinc-400">Gunakan email dan password yang sudah terdaftar.</p>
                </div>

                <form method="POST" action="{{ route('login.store') }}" class="grid gap-5">
                    @csrf
                    <div>
                        <x-label for="email">Email</x-label>
                        <x-input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus />
                        @error('email') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-label for="password">Password</x-label>
                        <x-input id="password" type="password" name="password" placeholder="••••••••" required />
                        @error('password') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <x-button type="submit" class="w-full">Masuk dashboard</x-button>
                </form>

                <div class="mt-8 border-t border-glass pt-6 text-center text-sm text-zinc-400">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-mono font-semibold uppercase tracking-[0.16em] text-lens hover:text-rose-300">Registrasi</a>
                </div>
            </div>
        </div>
    </section>
@endsection
