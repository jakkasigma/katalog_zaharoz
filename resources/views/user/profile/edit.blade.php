<x-store-layout title="Edit Profil">
    {{-- Profile Edit Page --}}
    <section class="pt-14 pb-16 bg-black min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-[0.4fr_0.6fr] gap-12">

                {{-- Left: Profile Preview --}}
                <div class="text-center lg:text-left">
                    <p class="font-mono text-xs uppercase tracking-[0.3em] text-rose-400 mb-4">Profil Customer</p>
                    <h1 class="font-display text-4xl sm:text-5xl uppercase text-white leading-none mb-6">
                        Identitas<br><span class="text-rose-500">Kamu</span>
                    </h1>
                    <div class="w-16 h-px bg-rose-600 mb-8 mx-auto lg:mx-0"></div>

                    <a href="{{ route('profile.password') }}"
                       class="inline-block font-cinzel text-xs uppercase tracking-[0.15em] px-6 py-3 border border-zinc-700 hover:border-rose-600 text-zinc-400 hover:text-rose-400 transition-colors duration-200">
                        Ganti Password
                    </a>

                    <a href="{{ route('dashboard') }}"
                       class="inline-block mt-3 font-cinzel text-xs uppercase tracking-[0.15em] px-6 py-3 border border-zinc-800 hover:border-zinc-600 text-zinc-500 hover:text-white transition-colors duration-200">
                        ← Kembali
                    </a>
                </div>

                {{-- Right: Edit Form --}}
                <div class="bg-zinc-950 border border-zinc-800 p-8 sm:p-10">
                    <div class="mb-8">
                        <p class="font-mono text-xs uppercase tracking-[0.3em] text-zinc-600 mb-2">Update Info</p>
                        <h2 class="font-display text-3xl uppercase text-white">Edit Profil</h2>
                    </div>

                    @if (session('status'))
                        <div class="mb-6 p-4 bg-rose-950/50 border border-rose-900/50 rounded">
                            <p class="text-sm text-rose-400">{{ session('status') }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="name" class="block font-mono text-xs uppercase tracking-[0.2em] text-zinc-500 mb-2">Nama Lengkap</label>
                            <input id="name"
                                   type="text"
                                   name="name"
                                   value="{{ old('name', auth()->user()->name) }}"
                                   required
                                   class="w-full px-4 py-3 bg-black border border-zinc-800 text-white placeholder-zinc-700 focus:border-rose-600 focus:outline-none focus:ring-1 focus:ring-rose-600 transition-colors">
                            @error('name')
                                <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block font-mono text-xs uppercase tracking-[0.2em] text-zinc-500 mb-2">Email</label>
                            <input id="email"
                                   type="email"
                                   name="email"
                                   value="{{ old('email', auth()->user()->email) }}"
                                   required
                                   class="w-full px-4 py-3 bg-black border border-zinc-800 text-white placeholder-zinc-700 focus:border-rose-600 focus:outline-none focus:ring-1 focus:ring-rose-600 transition-colors">
                            @error('email')
                                <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block font-mono text-xs uppercase tracking-[0.2em] text-zinc-500 mb-2">Nomor HP</label>
                            <input id="phone"
                                   type="text"
                                   name="phone"
                                   value="{{ old('phone', auth()->user()->phone) }}"
                                   required
                                   class="w-full px-4 py-3 bg-black border border-zinc-800 text-white placeholder-zinc-700 focus:border-rose-600 focus:outline-none focus:ring-1 focus:ring-rose-600 transition-colors">
                            @error('phone')
                                <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                                class="w-full font-cinzel text-xs uppercase tracking-[0.15em] px-6 py-4 bg-rose-600 hover:bg-rose-500 text-white transition-colors duration-200">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>
</x-store-layout>



