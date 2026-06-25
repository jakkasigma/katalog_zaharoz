@extends('admin.layout')

@section('content')
    <x-card>
        <x-page-header eyebrow="Verification" title="Pembayaran {{ $payment->order?->order_number }}" description="Validasi bukti pembayaran dan update status.">
            <x-slot:actions><x-link-button :href="route('admin.payments.index')" variant="secondary">Kembali</x-link-button></x-slot:actions>
        </x-page-header>

        <div class="mt-8 grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">

            {{-- LEFT: Items + Address + Notes --}}
            <div class="grid gap-6">
                {{-- Items Table --}}
                <div class="overflow-x-auto border border-glass bg-ink">
                    <table class="w-full min-w-[640px] text-left text-sm">
                        <thead class="border-b border-glass font-mono text-xs uppercase tracking-[0.2em] text-zinc-400">
                            <tr>
                                <th class="px-4 py-3">Item</th>
                                <th class="px-4 py-3 text-right">Harga</th>
                                <th class="px-4 py-3 text-right">Qty</th>
                                <th class="px-4 py-3 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-glass text-zinc-300">
                            @forelse ($payment->order?->items ?? [] as $item)
                                <tr>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-3">
                                            @if($item->product && $item->product->image_path)
                                                <img src="{{ asset('storage/' . $item->product->image_path) }}"
                                                     alt="{{ $item->product_name }}"
                                                     class="w-12 h-16 object-cover border border-glass shrink-0">
                                            @else
                                                <div class="w-12 h-16 bg-zinc-900 border border-glass flex items-center justify-center shrink-0">
                                                    <span class="font-mono text-[8px] text-zinc-700">IMG</span>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="text-brass">{{ $item->product_name }}</p>
                                                @if($item->product)
                                                    <a href="{{ route('admin.products.show', $item->product) }}" class="font-mono text-[10px] text-zinc-600 hover:text-lens transition-colors">Lihat Produk →</a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-right font-mono text-zinc-400">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-4 text-right">{{ $item->quantity }}</td>
                                    <td class="px-4 py-4 text-right font-mono text-lens">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-4 py-8 text-center text-zinc-500">Belum ada item.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Summary --}}
                <div class="grid gap-4 md:grid-cols-3">
                    <div class="border border-glass bg-ink p-5">
                        <p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Subtotal</p>
                        <p class="mt-2 font-mono text-brass">Rp {{ number_format($payment->order?->subtotal ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="border border-glass bg-ink p-5">
                        <p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Ongkir</p>
                        <p class="mt-2 font-mono text-xs text-zinc-500 uppercase">
                            {{ ($payment->order?->shipping_cost ?? 0) == 0 ? 'Ditanggung Pembeli' : 'Rp '.number_format($payment->order?->shipping_cost ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="border border-glass bg-ink p-5">
                        <p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">Total</p>
                        <p class="mt-2 font-mono text-brass">Rp {{ number_format($payment->order?->total ?? $payment->amount, 0, ',', '.') }}</p>
                    </div>
                </div>

                {{-- Shipping Address --}}
                @if($payment->order?->address)
                <div class="border border-glass bg-ink p-5">
                    <p class="font-mono text-xs uppercase tracking-[0.2em] text-lens mb-2">Alamat Pengiriman</p>
                    <p class="font-semibold text-brass">{{ $payment->order->address->recipient_name }}</p>
                    <p class="mt-1 font-mono text-xs text-zinc-400">{{ $payment->order->address->phone }}</p>
                    <p class="mt-3 text-sm text-zinc-300 leading-6">{{ $payment->order->address->full_address }}</p>
                    <p class="mt-1 text-sm text-zinc-500">{{ $payment->order->address->city }}, {{ $payment->order->address->province }} {{ $payment->order->address->postal_code }}</p>
                    @if($payment->order->address->latitude && $payment->order->address->longitude)
                        <a href="https://maps.google.com/?q={{ $payment->order->address->latitude }},{{ $payment->order->address->longitude }}"
                           target="_blank"
                           class="mt-3 inline-flex items-center gap-1.5 font-mono text-xs uppercase tracking-[0.15em] text-lens hover:underline">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Lihat di Maps
                        </a>
                    @endif
                </div>
                @endif

                {{-- Order Notes --}}
                @if($payment->order?->notes)
                <div class="border border-glass bg-ink p-5">
                    <p class="font-mono text-xs uppercase tracking-[0.2em] text-lens mb-2">Catatan Pesanan</p>
                    <p class="text-sm text-zinc-300">{{ $payment->order->notes }}</p>
                </div>
                @endif
            </div>

            {{-- RIGHT: Customer + Proof + Actions --}}
            <div class="grid gap-5 content-start">
                <div class="border border-glass bg-ink p-5">
                    <p class="font-mono text-xs uppercase tracking-[0.2em] text-lens mb-3">Customer</p>
                    <p class="text-brass font-medium">{{ $payment->order?->user?->name ?? '-' }}</p>
                    <p class="mt-1 text-sm text-zinc-500">{{ $payment->order?->user?->email ?? '-' }}</p>
                    <p class="mt-0.5 text-sm text-zinc-500">{{ $payment->order?->user?->phone ?? '-' }}</p>
                </div>

                <div class="border border-glass bg-ink p-5">
                    <p class="font-mono text-xs uppercase tracking-[0.2em] text-lens mb-2">Nominal Pembayaran</p>
                    <p class="font-mono text-xl text-brass">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                </div>

                <div class="border border-glass bg-ink p-5">
                    <p class="font-mono text-xs uppercase tracking-[0.2em] text-lens mb-2">Status</p>
                    <p class="font-mono text-sm
                        @if($payment->status === 'verified') text-green-400
                        @elseif($payment->status === 'rejected') text-red-400
                        @else text-yellow-400 @endif">
                        {{ ucfirst(str_replace('_', ' ', $payment->status)) }}
                    </p>
                    @if($payment->verified_at)
                        <p class="mt-1 text-xs text-zinc-500">Diverifikasi: {{ $payment->verified_at->format('d M Y, H:i') }}</p>
                    @endif
                    @if($payment->rejection_reason)
                        <p class="mt-2 text-xs text-red-400">Alasan ditolak: {{ $payment->rejection_reason }}</p>
                    @endif
                </div>

                {{-- Bukti Transfer --}}
                @if($payment->proof_path)
                <div class="border border-glass bg-ink p-5" x-data="{
                    showProof: false,
                    scale: 1,
                    x: 0,
                    y: 0,
                    isDragging: false,
                    startX: 0,
                    startY: 0,
                    zoomIn() { this.scale = Math.min(this.scale + 0.5, 5); },
                    zoomOut() { this.scale = Math.max(this.scale - 0.5, 1); if (this.scale === 1) { this.x = 0; this.y = 0; } },
                    reset() { this.scale = 1; this.x = 0; this.y = 0; },
                    startDrag(e) {
                        if (this.scale > 1) {
                            this.isDragging = true;
                            this.startX = (e.touches ? e.touches[0].clientX : e.clientX) - this.x;
                            this.startY = (e.touches ? e.touches[0].clientY : e.clientY) - this.y;
                        }
                    },
                    drag(e) {
                        if (this.isDragging) {
                            e.preventDefault();
                            this.x = (e.touches ? e.touches[0].clientX : e.clientX) - this.startX;
                            this.y = (e.touches ? e.touches[0].clientY : e.clientY) - this.startY;
                        }
                    },
                    endDrag() { this.isDragging = false; }
                }">
                    <p class="font-mono text-xs uppercase tracking-[0.2em] text-lens mb-3">Bukti Transfer</p>

                    {{-- Thumbnail --}}
                    <div class="relative group cursor-pointer inline-block" @click="showProof = true">
                        <img src="{{ Storage::url($payment->proof_path) }}"
                             alt="Bukti transfer"
                             class="w-32 h-32 sm:w-40 sm:h-40 object-cover border border-glass group-hover:border-lens transition-colors">
                        <div class="absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                            </svg>
                        </div>
                    </div>
                    <p class="font-mono text-xs text-zinc-600 mt-2 uppercase tracking-wider">Klik untuk perbesar</p>

                    {{-- Modal with Zoom & Pan --}}
                    <div x-show="showProof"
                         x-cloak
                         @click="showProof = false; reset()"
                         @keydown.escape.window="showProof = false; reset()"
                         class="fixed inset-0 z-50 flex flex-col items-center justify-center p-4 bg-black/95 backdrop-blur-sm"
                         style="display: none;">

                        {{-- Controls --}}
                        <div class="absolute top-4 left-1/2 -translate-x-1/2 flex items-center gap-2 bg-zinc-900/90 backdrop-blur-sm rounded-lg px-3 py-2 z-10">
                            <button @click.stop="zoomOut()"
                                    :disabled="scale <= 1"
                                    :class="scale <= 1 ? 'opacity-30 cursor-not-allowed' : 'hover:bg-zinc-700'"
                                    class="w-8 h-8 flex items-center justify-center text-white transition-colors rounded">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                </svg>
                            </button>
                            <span class="text-white font-mono text-sm min-w-[60px] text-center" x-text="Math.round(scale * 100) + '%'"></span>
                            <button @click.stop="zoomIn()"
                                    :disabled="scale >= 5"
                                    :class="scale >= 5 ? 'opacity-30 cursor-not-allowed' : 'hover:bg-zinc-700'"
                                    class="w-8 h-8 flex items-center justify-center text-white transition-colors rounded">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                            <div class="w-px h-6 bg-zinc-700 mx-1"></div>
                            <button @click.stop="reset()"
                                    class="px-3 py-1 text-xs text-white hover:bg-zinc-700 transition-colors rounded">
                                Reset
                            </button>
                        </div>

                        {{-- Close Button --}}
                        <button @click.stop="showProof = false; reset()"
                                class="absolute top-4 right-4 w-10 h-10 flex items-center justify-center bg-zinc-900 hover:bg-lens text-white transition-colors rounded z-10">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>

                        {{-- Image Container --}}
                        <div class="relative w-full h-full flex items-center justify-center overflow-hidden"
                             @click.stop
                             @mousedown="startDrag($event)"
                             @mousemove="drag($event)"
                             @mouseup="endDrag()"
                             @mouseleave="endDrag()"
                             @touchstart="startDrag($event)"
                             @touchmove="drag($event)"
                             @touchend="endDrag()"
                             @wheel.prevent.stop="if ($event.deltaY < 0) zoomIn(); else zoomOut()"
                             :class="scale > 1 ? 'cursor-grab' : 'cursor-default'"
                             :style="isDragging ? 'cursor: grabbing' : ''">
                            <img src="{{ Storage::url($payment->proof_path) }}"
                                 alt="Bukti transfer"
                                 class="max-w-full max-h-[85vh] object-contain select-none transition-transform duration-200"
                                 :style="`transform: translate(${x}px, ${y}px) scale(${scale})`">
                        </div>

                        {{-- Help Text --}}
                        <p class="absolute bottom-4 left-1/2 -translate-x-1/2 text-xs text-zinc-500 font-mono">
                            Scroll untuk zoom · Drag untuk geser
                        </p>
                    </div>
                </div>
                @endif

                @if ($payment->status === 'waiting_confirmation')
                    <form method="POST" action="{{ route('admin.payments.approve', $payment) }}">
                        @csrf
                        <x-button type="submit" class="w-full">Terima Pembayaran</x-button>
                    </form>
                    <form method="POST" action="{{ route('admin.payments.reject', $payment) }}" class="grid gap-3">
                        @csrf
                        <x-label for="rejection_reason">Alasan Tolak</x-label>
                        <textarea id="rejection_reason" name="rejection_reason" rows="3" class="w-full border border-glass bg-night px-4 py-3 text-brass outline-none focus:border-lens focus:ring-4 focus:ring-lens/20">{{ old('rejection_reason') }}</textarea>
                        @error('rejection_reason') <p class="text-sm text-red-400">{{ $message }}</p> @enderror
                        <x-button type="submit" variant="danger" class="w-full">Tolak Pembayaran</x-button>
                    </form>
                @endif
            </div>
        </div>
    </x-card>
@endsection
