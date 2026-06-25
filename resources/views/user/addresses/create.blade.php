<x-store-layout title="Tambah Alamat">
    <section class="pt-14 pb-16 bg-black min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-12">
                <p class="font-mono text-xs uppercase tracking-[0.3em] text-rose-400 mb-4">Alamat Baru</p>
                <h1 class="font-display text-5xl uppercase text-white leading-none mb-6">
                    Tambah<br><span class="text-rose-500">Alamat</span>
                </h1>
                <div class="w-16 h-px bg-rose-600"></div>
            </div>

            <div class="bg-zinc-950 border border-zinc-800 p-8 sm:p-10">
                <form method="POST" action="{{ route('addresses.store') }}" class="space-y-6">
                    @csrf
                    @include('user.addresses._form')

                    <div class="flex gap-4 pt-6 border-t border-zinc-800">
                        <button type="submit" class="flex-1 font-cinzel text-xs uppercase tracking-[0.15em] px-6 py-4 bg-rose-600 hover:bg-rose-500 text-white transition-colors duration-200">
                            Simpan Alamat
                        </button>
                        <a href="{{ route('addresses.index') }}" class="flex-1 text-center font-cinzel text-xs uppercase tracking-[0.15em] px-6 py-4 border border-zinc-700 hover:border-zinc-600 text-zinc-400 hover:text-white transition-colors duration-200">
                            Batal
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </section>
</x-store-layout>



