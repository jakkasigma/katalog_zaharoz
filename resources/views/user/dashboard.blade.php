<x-store-layout title="Dashboard">
    <div class="pt-14 bg-zinc-950 min-h-screen">

        {{-- Header --}}
        <div class="border-b border-zinc-900 bg-zinc-950">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-rose-400 mb-3">Customer Area</p>
                <h1 class="font-display text-4xl sm:text-5xl uppercase text-white leading-none">
                    Halo, <span class="text-rose-500">{{ auth()->user()->name }}</span>
                </h1>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

            {{-- Stats --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-px bg-zinc-900 mb-10">
                <div class="bg-zinc-950 p-5">
                    <p class="font-mono text-[9px] uppercase tracking-[0.3em] text-zinc-700 mb-2">Email</p>
                    <p class="text-sm text-zinc-400 truncate">{{ auth()->user()->email }}</p>
                </div>
                <div class="bg-zinc-950 p-5">
                    <p class="font-mono text-[9px] uppercase tracking-[0.3em] text-zinc-700 mb-2">Nomor HP</p>
                    <p class="text-sm text-zinc-400">{{ auth()->user()->phone ?? '—' }}</p>
                </div>
                <div class="bg-zinc-950 p-5">
                    <p class="font-mono text-[9px] uppercase tracking-[0.3em] text-zinc-700 mb-2">Alamat</p>
                    <p class="text-sm text-zinc-400">{{ auth()->user()->addresses()->count() }} tersimpan</p>
                </div>
                <div class="bg-zinc-950 p-5">
                    <p class="font-mono text-[9px] uppercase tracking-[0.3em] text-zinc-700 mb-2">Pesanan</p>
                    <p class="text-sm text-zinc-400">{{ auth()->user()->orders()->count() }} order</p>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-px bg-zinc-900 mb-10">

                <a href="{{ route('store.index') }}"
                   class="group bg-zinc-950 hover:bg-zinc-900 p-6 transition-colors duration-200">
                    <div class="flex items-start justify-between mb-5">
                        <div class="w-2 h-2 bg-rose-600 rotate-45"></div>
                        <span class="font-mono text-[10px] text-zinc-800 group-hover:text-rose-400 transition-colors">→</span>
                    </div>
                    <h3 class="font-cinzel text-sm uppercase tracking-[0.1em] text-white mb-1">Katalog</h3>
                    <p class="text-xs text-zinc-700">Jelajahi koleksi terbaru</p>
                </a>

                @if(!auth()->user()->is_admin)
                <a href="{{ route('cart.index') }}"
                   class="group bg-zinc-950 hover:bg-zinc-900 p-6 transition-colors duration-200">
                    <div class="flex items-start justify-between mb-5">
                        <div class="w-2 h-2 bg-zinc-800 rotate-45 group-hover:bg-rose-600 transition-colors"></div>
                        <span class="font-mono text-[10px] text-zinc-800 group-hover:text-rose-400 transition-colors">→</span>
                    </div>
                    <h3 class="font-cinzel text-sm uppercase tracking-[0.1em] text-white mb-1">Keranjang</h3>
                    <p class="text-xs text-zinc-700">Lanjutkan belanja</p>
                </a>

                <a href="{{ route('orders.index') }}"
                   class="group bg-zinc-950 hover:bg-zinc-900 p-6 transition-colors duration-200">
                    <div class="flex items-start justify-between mb-5">
                        <div class="w-2 h-2 bg-zinc-800 rotate-45 group-hover:bg-rose-600 transition-colors"></div>
                        <span class="font-mono text-[10px] text-zinc-800 group-hover:text-rose-400 transition-colors">→</span>
                    </div>
                    <h3 class="font-cinzel text-sm uppercase tracking-[0.1em] text-white mb-1">Pesanan Saya</h3>
                    <p class="text-xs text-zinc-700">Tracking & riwayat order</p>
                </a>
                @endif

                <a href="{{ route('profile.edit') }}"
                   class="group bg-zinc-950 hover:bg-zinc-900 p-6 transition-colors duration-200">
                    <div class="flex items-start justify-between mb-5">
                        <div class="w-2 h-2 bg-zinc-800 rotate-45 group-hover:bg-rose-600 transition-colors"></div>
                        <span class="font-mono text-[10px] text-zinc-800 group-hover:text-rose-400 transition-colors">→</span>
                    </div>
                    <h3 class="font-cinzel text-sm uppercase tracking-[0.1em] text-white mb-1">Edit Profil</h3>
                    <p class="text-xs text-zinc-700">Nama, email, nomor HP</p>
                </a>

                <a href="{{ route('profile.password') }}"
                   class="group bg-zinc-950 hover:bg-zinc-900 p-6 transition-colors duration-200">
                    <div class="flex items-start justify-between mb-5">
                        <div class="w-2 h-2 bg-zinc-800 rotate-45 group-hover:bg-rose-600 transition-colors"></div>
                        <span class="font-mono text-[10px] text-zinc-800 group-hover:text-rose-400 transition-colors">→</span>
                    </div>
                    <h3 class="font-cinzel text-sm uppercase tracking-[0.1em] text-white mb-1">Ganti Password</h3>
                    <p class="text-xs text-zinc-700">Keamanan akun</p>
                </a>

                @if(!auth()->user()->is_admin)
                <a href="{{ route('addresses.index') }}"
                   class="group bg-zinc-950 hover:bg-zinc-900 p-6 transition-colors duration-200">
                    <div class="flex items-start justify-between mb-5">
                        <div class="w-2 h-2 bg-zinc-800 rotate-45 group-hover:bg-rose-600 transition-colors"></div>
                        <span class="font-mono text-[10px] text-zinc-800 group-hover:text-rose-400 transition-colors">→</span>
                    </div>
                    <h3 class="font-cinzel text-sm uppercase tracking-[0.1em] text-white mb-1">Alamat</h3>
                    <p class="text-xs text-zinc-700">Kelola alamat pengiriman</p>
                </a>
                @endif

            </div>

        </div>
    </div>
</x-store-layout>


