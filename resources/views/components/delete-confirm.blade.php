<div x-data="{ open: false }" @keydown.escape.window="open = false" class="inline-block">
    <button type="button"
            @click="open = true"
            {{ $attributes->merge(['class' => 'inline-flex items-center justify-center px-5 py-4 border border-rose-500 bg-lens text-white font-mono text-xs font-semibold uppercase tracking-[0.18em] transition-colors hover:bg-rose-700 focus:outline-none focus:ring-4 focus:ring-lens/30']) }}>
        {{ $slot ?? 'Hapus' }}
    </button>

    {{-- Modal --}}
    <div x-show="open"
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="open = false"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/95 backdrop-blur-sm"
         style="display: none;">
        <div class="relative bg-ink border border-glass rounded-lg p-6 max-w-md w-full shadow-2xl" @click.stop>
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-brass mb-2">Konfirmasi Hapus</h3>
                    <p class="text-sm text-zinc-400">{{ $message }}</p>
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="button" @click="open = false" class="flex-1 inline-flex items-center justify-center px-5 py-3 border border-glass bg-night text-brass font-mono text-sm font-semibold uppercase tracking-[0.18em] transition-colors hover:border-lens hover:text-white focus:outline-none focus:ring-4 focus:ring-lens/30">
                    Batal
                </button>
                <form method="POST" action="{{ $action }}" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex items-center justify-center px-5 py-3 border border-red-600 bg-red-700 text-white font-mono text-sm font-semibold uppercase tracking-[0.18em] transition-colors hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-500/30">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>