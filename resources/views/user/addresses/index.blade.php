<x-store-layout title="Alamat Saya">
    {{-- Address List Page --}}
    <section class="pt-14 pb-16 bg-black min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-6 mb-12">
                <div>
                    <p class="font-mono text-xs uppercase tracking-[0.3em] text-rose-400 mb-4">Pengiriman</p>
                    <h1 class="font-display text-5xl sm:text-6xl uppercase text-white leading-none mb-6">
                        Alamat<br><span class="text-rose-500">Saya</span>
                    </h1>
                    <div class="w-16 h-px bg-rose-600"></div>
                </div>
                <a href="{{ route('addresses.create') }}"
                   class="font-cinzel text-xs uppercase tracking-[0.15em] px-6 py-3 bg-rose-600 hover:bg-rose-500 text-white transition-colors duration-200">
                    Tambah Alamat
                </a>
            </div>

            {{-- Address Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse ($addresses as $address)
                    <article class="bg-zinc-950 border border-zinc-800 p-6 hover:border-rose-600/50 transition-colors duration-200">
                        <div class="flex items-start justify-between gap-4 mb-4">
                            <div>
                                <h2 class="font-display text-xl uppercase text-white mb-1">{{ $address->recipient_name }}</h2>
                                <p class="font-mono text-xs text-zinc-500">{{ $address->phone }}</p>
                            </div>
                            @if ($address->is_default)
                                <span class="font-mono text-xs uppercase tracking-wider px-2 py-1 bg-rose-600 text-white">Default</span>
                            @endif
                        </div>

                        <div class="space-y-2 text-sm text-zinc-400 mb-4">
                            <p>{{ $address->full_address }}</p>
                            <p class="text-zinc-600">{{ $address->district }}, {{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}</p>
                            @if ($address->latitude && $address->longitude)
                                <p class="font-mono text-xs text-zinc-700">{{ $address->latitude }} / {{ $address->longitude }}</p>
                            @endif
                        </div>

                        <div class="flex gap-4 pt-4 border-t border-zinc-800">
                            <a href="{{ route('addresses.edit', $address) }}"
                               class="font-cinzel text-xs uppercase tracking-[0.15em] text-rose-400 hover:text-rose-300 transition-colors">
                                Edit
                            </a>
                            @if (!$address->is_default)
                                <form method="POST" action="{{ route('addresses.destroy', $address) }}" onsubmit="return confirm('Hapus alamat ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-cinzel text-xs uppercase tracking-[0.15em] text-zinc-600 hover:text-red-400 transition-colors">
                                        Hapus
                                    </button>
                                </form>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="md:col-span-2 border border-dashed border-zinc-800 bg-zinc-950/50 p-12 text-center">
                        <p class="font-display text-2xl uppercase text-zinc-600 mb-2">Belum ada alamat</p>
                        <p class="text-sm text-zinc-700 mb-6">Tambah alamat pengiriman pertama kamu</p>
                        <a href="{{ route('addresses.create') }}"
                           class="inline-block font-cinzel text-xs uppercase tracking-[0.15em] px-6 py-3 bg-rose-600 hover:bg-rose-500 text-white transition-colors duration-200">
                            Tambah Alamat
                        </a>
                    </div>
                @endforelse
            </div>

        </div>
    </section>
</x-store-layout>



