<x-store-layout title="Registrasi">
    {{-- Register Page --}}
    <section class="pt-14 pb-16 bg-black min-h-screen flex items-center">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                {{-- Left: Hero Content --}}
                <div class="text-center lg:text-left">
                    <p class="font-mono text-xs uppercase tracking-[0.3em] text-rose-400 mb-4">Join the Underground</p>
                    <h1 class="font-display text-5xl sm:text-6xl uppercase text-white leading-none mb-6">
                        Buat<br>Akun<br><span class="text-rose-500">Baru</span>
                    </h1>
                    <div class="w-16 h-px bg-rose-600 mb-6 mx-auto lg:mx-0"></div>
                    <p class="text-sm text-zinc-500 leading-relaxed max-w-md mx-auto lg:mx-0">
                        Daftar untuk akses koleksi custom gothic, checkout produk, dan kelola profil serta alamat pengiriman.
                    </p>

                    {{-- Benefits --}}
                    <div class="mt-12 space-y-3 text-left">
                        <div class="flex items-start gap-3">
                            <div class="w-1.5 h-1.5 bg-rose-600 rotate-45 mt-2 shrink-0"></div>
                            <p class="text-sm text-zinc-600">Akses koleksi limited edition & custom order</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-1.5 h-1.5 bg-zinc-800 rotate-45 mt-2 shrink-0"></div>
                            <p class="text-sm text-zinc-600">Simpan alamat pengiriman untuk checkout cepat</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-1.5 h-1.5 bg-zinc-800 rotate-45 mt-2 shrink-0"></div>
                            <p class="text-sm text-zinc-600">Tracking pesanan real-time</p>
                        </div>
                    </div>
                </div>

                {{-- Right: Register Form --}}
                <div class="bg-zinc-950 border border-zinc-800 p-8 sm:p-10">
                    <div class="mb-8">
                        <p class="font-mono text-xs uppercase tracking-[0.3em] text-zinc-600 mb-2">Sign Up</p>
                        <h2 class="font-display text-3xl uppercase text-white">Buat Akun</h2>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-rose-950/50 border border-rose-900/50 rounded">
                            <ul class="text-sm text-rose-400 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="name" class="block font-mono text-xs uppercase tracking-[0.2em] text-zinc-500 mb-2">Nama Lengkap</label>
                            <input id="name"
                                   type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   required
                                   autofocus
                                   class="w-full px-4 py-3 bg-black border border-zinc-800 text-white placeholder-zinc-700 focus:border-rose-600 focus:outline-none focus:ring-1 focus:ring-rose-600 transition-colors"
                                   placeholder="John Doe">
                            @error('name')
                                <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block font-mono text-xs uppercase tracking-[0.2em] text-zinc-500 mb-2">Email</label>
                            <input id="email"
                                   type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   class="w-full px-4 py-3 bg-black border border-zinc-800 text-white placeholder-zinc-700 focus:border-rose-600 focus:outline-none focus:ring-1 focus:ring-rose-600 transition-colors"
                                   placeholder="nama@email.com">
                            @error('email')
                                <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block font-mono text-xs uppercase tracking-[0.2em] text-zinc-500 mb-2">Nomor HP</label>
                            <input id="phone"
                                   type="text"
                                   name="phone"
                                   value="{{ old('phone') }}"
                                   required
                                   class="w-full px-4 py-3 bg-black border border-zinc-800 text-white placeholder-zinc-700 focus:border-rose-600 focus:outline-none focus:ring-1 focus:ring-rose-600 transition-colors"
                                   placeholder="081234567890">
                            @error('phone')
                                <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
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

                            <div>
                                <label for="password_confirmation" class="block font-mono text-xs uppercase tracking-[0.2em] text-zinc-500 mb-2">Konfirmasi</label>
                                <input id="password_confirmation"
                                       type="password"
                                       name="password_confirmation"
                                       required
                                       class="w-full px-4 py-3 bg-black border border-zinc-800 text-white placeholder-zinc-700 focus:border-rose-600 focus:outline-none focus:ring-1 focus:ring-rose-600 transition-colors"
                                       placeholder="••••••••">
                            </div>
                        </div>

                        <button type="submit"
                                class="w-full font-cinzel text-xs uppercase tracking-[0.15em] px-6 py-4 bg-rose-600 hover:bg-rose-500 text-white transition-colors duration-200">
                            Buat Akun
                        </button>
                    </form>

                    <div class="mt-8 pt-6 border-t border-zinc-800 text-center">
                        <p class="text-sm text-zinc-500">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="font-mono uppercase tracking-[0.15em] text-rose-400 hover:text-rose-300 transition-colors">
                                Masuk
                            </a>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-store-layout>


