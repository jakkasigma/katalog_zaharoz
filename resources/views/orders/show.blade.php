<x-store-layout title="{{ $order->order_number }}">

    <div class="pt-14 pb-16 bg-black min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 font-mono text-[10px] uppercase tracking-[0.25em] text-zinc-700 mb-10">
                <a href="{{ route('orders.index') }}" class="hover:text-rose-400 transition-colors">Pesanan Saya</a>
                <span>/</span>
                <span class="text-zinc-600">{{ $order->order_number }}</span>
            </nav>

            {{-- Order Header --}}
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-10 pb-8 border-b border-zinc-900">
                <div>
                    <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-rose-400 mb-2">Detail Pesanan</p>
                    <h1 class="font-mono text-2xl text-white tracking-widest">{{ $order->order_number }}</h1>
                    <p class="font-mono text-xs text-zinc-700 mt-2">{{ $order->created_at->format('d F Y, H:i') }}</p>
                </div>

                {{-- Status badges --}}
                <div class="flex flex-wrap gap-2">
                    @php
                        $statusLabel = ['pending'=>'Menunggu','processing'=>'Diproses','shipped'=>'Dikirim','delivered'=>'Selesai','cancelled'=>'Dibatalkan'];
                        $payLabel = ['pending'=>'Belum Bayar','waiting_confirmation'=>'Menunggu Konfirmasi','verified'=>'Pembayaran OK','rejected'=>'Ditolak'];
                    @endphp
                    <span class="font-mono text-[10px] uppercase tracking-widest px-3 py-1.5
                        @if($order->status === 'delivered') bg-green-950 text-green-400 border border-green-900
                        @elseif($order->status === 'shipped') bg-blue-950 text-blue-400 border border-blue-900
                        @elseif($order->status === 'processing') bg-zinc-900 text-yellow-400 border border-zinc-800
                        @elseif($order->status === 'cancelled') bg-red-950 text-red-500 border border-red-900
                        @else bg-zinc-900 text-zinc-500 border border-zinc-800 @endif">
                        {{ $statusLabel[$order->status] ?? $order->status }}
                    </span>
                    <span class="font-mono text-[10px] uppercase tracking-widest px-3 py-1.5
                        @if($order->payment_status === 'verified') bg-green-950 text-green-400 border border-green-900
                        @elseif($order->payment_status === 'waiting_confirmation') bg-yellow-950 text-yellow-400 border border-yellow-900
                        @elseif($order->payment_status === 'rejected') bg-red-950 text-red-500 border border-red-900
                        @else bg-zinc-900 text-zinc-600 border border-zinc-800 @endif">
                        {{ $payLabel[$order->payment_status] ?? $order->payment_status }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-[1fr_360px] gap-8 items-start">

                {{-- LEFT COLUMN --}}
                <div class="space-y-6">

                    {{-- Order Timeline --}}
                    <div class="bg-zinc-950 border border-zinc-900 p-6">
                        <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-rose-400 mb-6">Status Pesanan</p>
                        <div class="relative space-y-0">
                            @php
                                $steps = [
                                    ['label' => 'Pesanan Dibuat',   'done' => true, 'info' => $order->created_at->format('d M Y, H:i')],
                                    ['label' => 'Pembayaran',
                                     'done' => in_array($order->payment_status, ['verified', 'waiting_confirmation']),
                                     'info' => match($order->payment_status) {
                                         'verified' => 'Dikonfirmasi',
                                         'waiting_confirmation' => 'Menunggu konfirmasi admin',
                                         'rejected' => 'Ditolak — upload ulang',
                                         default => 'Belum upload bukti',
                                     },
                                     'warn' => $order->payment_status === 'rejected',
                                    ],
                                    ['label' => 'Diproses',  'done' => in_array($order->status, ['processing', 'shipped', 'delivered']), 'info' => null],
                                    ['label' => 'Dikirim',   'done' => in_array($order->status, ['shipped', 'delivered']),
                                     'info' => $order->tracking_number ? 'Resi: '.$order->tracking_number : null],
                                    ['label' => 'Selesai',   'done' => $order->status === 'delivered',
                                     'info' => $order->delivered_at?->format('d M Y, H:i')],
                                ];
                            @endphp

                            @foreach($steps as $i => $step)
                                <div class="flex items-start gap-4 pb-6 last:pb-0">
                                    {{-- Dot + line --}}
                                    <div class="flex flex-col items-center shrink-0">
                                        <div class="w-8 h-8 flex items-center justify-center
                                            @if($step['done']) bg-rose-600 @elseif($step['warn'] ?? false) bg-red-900 border border-red-700 @else bg-zinc-900 border border-zinc-800 @endif">
                                            @if($step['done'])
                                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="square" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            @else
                                                <span class="font-mono text-[10px] text-zinc-700">{{ $i + 1 }}</span>
                                            @endif
                                        </div>
                                        @if(!$loop->last)
                                            <div class="w-px flex-1 mt-1 min-h-[1.5rem] {{ $step['done'] ? 'bg-rose-900' : 'bg-zinc-900' }}"></div>
                                        @endif
                                    </div>
                                    {{-- Text --}}
                                    <div class="pt-1">
                                        <p class="font-cinzel text-xs uppercase tracking-[0.1em] {{ $step['done'] ? 'text-white' : (($step['warn'] ?? false) ? 'text-red-400' : 'text-zinc-700') }}">
                                            {{ $step['label'] }}
                                        </p>
                                        @if($step['info'])
                                            <p class="font-mono text-[10px] text-zinc-600 mt-0.5">{{ $step['info'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Items --}}
                    <div class="bg-zinc-950 border border-zinc-900 p-6">
                        <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-rose-400 mb-6">Item Pesanan</p>
                        <div class="space-y-px bg-zinc-900">
                            @forelse($order->items as $item)
                                <div class="bg-zinc-950 grid grid-cols-[64px_1fr] gap-4 p-4 items-center">
                                    <div class="aspect-square bg-zinc-900 overflow-hidden">
                                        @if($item->product?->image_path)
                                            <img src="{{ asset('storage/'.$item->product->image_path) }}"
                                                 alt="{{ $item->product_name }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <div class="w-6 h-6 rotate-45 border border-zinc-800"></div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex items-center justify-between gap-4">
                                        <div>
                                            <p class="font-cinzel text-xs uppercase tracking-[0.08em] text-white">{{ $item->product_name }}</p>
                                            <p class="font-mono text-[10px] text-zinc-700 mt-1">{{ $item->quantity }} × Rp {{ number_format($item->unit_price, 0, ',', '.') }}</p>
                                        </div>
                                        <p class="font-mono text-sm text-zinc-300 shrink-0">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="bg-zinc-950 p-6 text-center">
                                    <p class="font-mono text-xs text-zinc-700">Tidak ada item.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    @if($order->notes)
                        <div class="bg-zinc-950 border border-zinc-900 p-6">
                            <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-rose-400 mb-3">Catatan</p>
                            <p class="text-sm text-zinc-500 leading-relaxed">{{ $order->notes }}</p>
                        </div>
                    @endif

                </div>

                {{-- RIGHT COLUMN --}}
                <div class="space-y-4">

                    {{-- Ringkasan Harga --}}
                    <div class="bg-zinc-950 border border-zinc-900 p-6">
                        <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-rose-400 mb-5">Ringkasan</p>
                        <div class="space-y-3 text-sm pb-5 border-b border-zinc-900">
                            <div class="flex justify-between gap-4">
                                <span class="text-zinc-600">Subtotal</span>
                                <span class="font-mono text-zinc-400">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between gap-4">
                                <span class="text-zinc-600">Ongkir</span>
                                <span class="font-mono text-zinc-500 text-xs uppercase tracking-wider">
                                    {{ $order->shipping_cost == 0 ? 'Ditanggung Pembeli' : 'Rp '.number_format($order->shipping_cost, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                        <div class="flex justify-between items-baseline pt-5">
                            <span class="font-cinzel text-sm uppercase tracking-[0.1em] text-white">Total</span>
                            <span class="font-mono text-2xl text-white">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    {{-- PAYMENT INFO — hanya saat pending atau rejected --}}
                    @if($order->payment_status === 'rejected')
                        @php $cp = \App\Models\CompanyProfile::query()->first(); @endphp

                        <div class="bg-zinc-950 border border-rose-900 p-6">
                            <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-rose-400 mb-5">Upload Ulang Bukti Bayar</p>

                            <div class="border border-red-900 bg-red-950 p-4 mb-5">
                                <p class="font-mono text-[10px] uppercase tracking-[0.2em] text-red-400 mb-1">Pembayaran Ditolak</p>
                                @if($order->payment?->rejection_reason)
                                    <p class="text-xs text-red-400">{{ $order->payment->rejection_reason }}</p>
                                @endif
                            </div>

                            {{-- Info rekening untuk referensi --}}
                            @if($cp?->bank_name || $cp?->bank_account_number)
                                <div class="border border-zinc-800 bg-black p-4 mb-4">
                                    <p class="font-mono text-[9px] uppercase tracking-[0.3em] text-zinc-600 mb-2">Transfer ke</p>
                                    <p class="font-cinzel text-xs uppercase text-zinc-500 mb-1">{{ $cp->bank_name ?? '' }}</p>
                                    <p class="font-mono text-xl text-white tracking-widest">{{ $cp->bank_account_number ?? '-' }}</p>
                                    @if($cp?->bank_account_name)
                                        <p class="font-mono text-xs text-zinc-700 mt-1">a.n. {{ $cp->bank_account_name }}</p>
                                    @endif
                                </div>
                            @endif

                            <form method="POST" action="{{ route('payments.store', $order) }}" enctype="multipart/form-data">
                                @csrf
                                <p class="font-mono text-[9px] uppercase tracking-[0.3em] text-zinc-600 mb-3">Bukti Baru</p>
                                <input type="file" name="payment_proof" id="payment_proof"
                                       accept="image/jpeg,image/jpg,image/png" required
                                       class="w-full text-sm text-zinc-600 file:mr-3 file:font-cinzel file:text-[10px] file:uppercase file:tracking-[0.15em] file:px-3 file:py-2 file:border-0 file:bg-zinc-800 file:text-zinc-400 hover:file:bg-zinc-700 file:cursor-pointer bg-black border border-zinc-800 focus-within:border-rose-600 transition-colors mb-1">
                                <p class="font-mono text-[10px] text-zinc-700 mb-4">JPG, JPEG, PNG — maks. 2MB</p>
                                @error('payment_proof')
                                    <p class="text-xs text-red-400 mb-3">{{ $message }}</p>
                                @enderror
                                <button type="submit"
                                        class="w-full font-cinzel text-[11px] uppercase tracking-[0.25em] py-3.5 bg-rose-600 hover:bg-rose-500 text-white transition-colors">
                                    Upload Ulang
                                </button>
                            </form>
                        </div>
                    @endif

                    {{-- Bukti yang sudah diupload --}}
                    @if($order->payment?->proof_path && $order->payment_status !== 'pending')
                        <div class="bg-zinc-950 border border-zinc-900 p-4 sm:p-6" x-data="{
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
                            <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-rose-400 mb-4">Bukti Pembayaran</p>

                            {{-- Thumbnail --}}
                            <div class="relative group cursor-pointer inline-block" @click="showProof = true">
                                <img src="{{ asset('storage/' . $order->payment->proof_path) }}"
                                     alt="Bukti Pembayaran"
                                     class="w-24 h-24 sm:w-32 sm:h-32 object-cover border border-zinc-800 group-hover:border-rose-600 transition-colors">
                                <div class="absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                    </svg>
                                </div>
                            </div>

                            <p class="font-mono text-[9px] text-zinc-600 mt-2 uppercase tracking-wider">Klik untuk perbesar</p>

                            <p class="font-mono text-[10px] uppercase tracking-widest mt-3
                                @if($order->payment->status === 'waiting_confirmation') text-yellow-500
                                @elseif($order->payment->status === 'verified') text-green-500
                                @else text-red-500 @endif">
                                @if($order->payment->status === 'waiting_confirmation') ● Menunggu Konfirmasi
                                @elseif($order->payment->status === 'verified') ● Dikonfirmasi
                                @else ● Ditolak @endif
                            </p>

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
                                        class="absolute top-4 right-4 w-10 h-10 flex items-center justify-center bg-zinc-900 hover:bg-rose-600 text-white transition-colors rounded z-10">
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
                                    <img src="{{ asset('storage/' . $order->payment->proof_path) }}"
                                         alt="Bukti Pembayaran"
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

                    {{-- Alamat Pengiriman --}}
                    <div class="bg-zinc-950 border border-zinc-900 p-6">
                        <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-rose-400 mb-4">Dikirim ke</p>
                        <p class="font-cinzel text-sm uppercase tracking-[0.08em] text-white mb-1">{{ $order->address->recipient_name }}</p>
                        <p class="font-mono text-xs text-zinc-600 mb-3">{{ $order->address->phone }}</p>
                        <p class="text-xs text-zinc-500 leading-relaxed">
                            {{ $order->address->full_address }},<br>
                            {{ $order->address->district }}, {{ $order->address->city }},<br>
                            {{ $order->address->province }} {{ $order->address->postal_code }}
                        </p>
                    </div>

                    {{-- Back --}}
                    <a href="{{ route('orders.index') }}"
                       class="block w-full text-center font-cinzel text-[11px] uppercase tracking-[0.2em] py-3 border border-zinc-800 hover:border-zinc-600 text-zinc-700 hover:text-white transition-colors">
                        ← Semua Pesanan
                    </a>

                </div>
            </div>

        </div>
    </div>

</x-store-layout>

