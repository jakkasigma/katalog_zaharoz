<x-store-layout title="Ganti Password">
    {{-- Password Change Page --}}
    <section class="pt-14 pb-16 bg-black min-h-screen flex items-center">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 w-full">

            {{-- Header --}}
            <div class="mb-12 text-center">
                <p class="font-mono text-xs uppercase tracking-[0.3em] text-rose-400 mb-4">Keamanan Akun</p>
                <h1 class="font-display text-5xl sm:text-6xl uppercase text-white leading-none mb-6">
                    Ganti<br><span class="text-rose-500">Password</span>
                </h1>
                <div class="w-16 h-px bg-rose-600 mb-6 mx-auto"></div>
                <p class="text-sm text-zinc-500">
                    Update password kamu untuk keamanan akun yang lebih baik.
                </p>
            </div>

            {{-- Form --}}
            <div class="bg-zinc-950 border border-zinc-800 p-8 sm:p-10">

                @if (session('status'))
                    <div class="mb-6 p-4 bg-rose-950/50 border border-rose-900/50 rounded">
                        <p class="text-sm text-rose-400">{{ session('status') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.password.update') }}" class="space-y-5">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="current_password" class="block font-mono text-xs uppercase tracking-[0.2em] text-zinc-500 mb-2">Password Saat Ini</label>
                        <input id="current_password"
                               type="password"
                               name="current_password"
                               required
                               class="w-full px-4 py-3 bg-black border border-zinc-800 text-white placeholder-zinc-700 focus:border-rose-600 focus:outline-none focus:ring-1 focus:ring-rose-600 transition-colors"
                               placeholder="••••••••">
                        @error('current_password')
                            <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="password" class="block font-mono text-xs uppercase tracking-[0.2em] text-zinc-500 mb-2">Password Baru</label>
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
                        Update Password
                    </button>
                </form>

                <div class="mt-8 pt-6 border-t border-zinc-800 text-center">
                    <a href="{{ route('profile.edit') }}" class="text-sm text-zinc-500 hover:text-zinc-300 transition-colors">
                        ← Kembali ke profil
                    </a>
                </div>
            </div>

        </div>
    </section>
</x-store-layout>



