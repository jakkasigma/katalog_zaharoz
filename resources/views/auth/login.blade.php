<x-store-layout title="Masuk">
    {{-- Login Page --}}
    <section class="pt-14 pb-16 bg-black min-h-screen flex items-center">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                {{-- Left: Hero Content --}}
                <div class="text-center lg:text-left">
                    <p class="font-mono text-xs uppercase tracking-[0.3em] text-rose-400 mb-4">Customer Area</p>
                    <h1 class="font-display text-5xl sm:text-6xl uppercase text-white leading-none mb-6">
                        Masuk<br>ke<br><span class="text-rose-500">Darkroom</span>
                    </h1>
                    <div class="w-16 h-px bg-rose-600 mb-6 mx-auto lg:mx-0"></div>
                    <p class="text-sm text-zinc-500 leading-relaxed max-w-md mx-auto lg:mx-0">
                        Akses dashboard kamu untuk kelola profil, alamat pengiriman, dan checkout koleksi custom gothic kami.
                    </p>

                    {{-- Decorative elements --}}
                    <div class="mt-12 hidden lg:flex gap-8 text-xs text-zinc-700 font-mono uppercase tracking-widest">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-rose-600 rotate-45"></div>
                            <span>Rework</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-zinc-800 rotate-45"></div>
                            <span>Cybersigilism</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-zinc-800 rotate-45"></div>
                            <span>Anti-Fashion</span>
                        </div>
                    </div>
                </div>

                {{-- Right: Login Form --}}
                <div class="bg-zinc-950 border border-zinc-800 p-8 sm:p-10">
                    <div class="mb-8">
                        <p class="font-mono text-xs uppercase tracking-[0.3em] text-zinc-600 mb-2">Login</p>
                        <h2 class="font-display text-3xl uppercase text-white">Akses Akun</h2>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-rose-950/50 border border-rose-900/50 rounded">
                            <p class="text-sm text-rose-400">{{ $errors->first() }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="block font-mono text-xs uppercase tracking-[0.2em] text-zinc-500 mb-2">Email</label>
                            <input id="email"
                                   type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autofocus
                                   class="w-full px-4 py-3 bg-black border border-zinc-800 text-white placeholder-zinc-700 focus:border-rose-600 focus:outline-none focus:ring-1 focus:ring-rose-600 transition-colors"
                                   placeholder="nama@email.com">
                            @error('email')
                                <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block font-mono text-xs uppercase tracking-[0.2em] text-zinc-500 mb-2">Password</label>
                            <input id="password"
                                   type="password"
                                   name="password"
                                   required
                                   class="w-full px-4 py-3 bg-black border border-zinc-800 text-white placeholder-zinc-700 focus:border-rose-600 focus:outline-none focus:ring-1 focus:ring-rose-600 transition-colors"
                                   placeholder="••••••••">
                            @error('password')
                                <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                                class="w-full font-cinzel text-xs uppercase tracking-[0.15em] px-6 py-4 bg-rose-600 hover:bg-rose-500 text-white transition-colors duration-200">
                            Masuk Dashboard
                        </button>
                    </form>

                    <div class="mt-8 pt-6 border-t border-zinc-800 text-center">
                        <p class="text-sm text-zinc-500">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="font-mono uppercase tracking-[0.15em] text-rose-400 hover:text-rose-300 transition-colors">
                                Daftar
                            </a>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-store-layout>


