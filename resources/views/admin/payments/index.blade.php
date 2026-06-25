@extends('admin.layout')

@section('content')
    <x-card>
        <x-page-header eyebrow="Verification" title="Verifikasi Pembayaran" description="Periksa bukti transfer dan terima/tolak pembayaran." />

        <form method="GET" class="mt-8 flex flex-wrap gap-3">
            <select name="status" class="border border-glass bg-night px-4 py-3 text-brass outline-none focus:border-lens focus:ring-4 focus:ring-lens/20">
                <option value="">Semua status</option>
                @foreach (['pending', 'waiting_confirmation', 'verified', 'rejected'] as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                @endforeach
            </select>
            <x-button type="submit">Filter</x-button>
        </form>

        <div class="mt-8 overflow-x-auto border border-glass bg-ink">
            <table class="w-full min-w-[860px] text-left text-sm">
                <thead class="border-b border-glass font-mono text-xs uppercase tracking-[0.2em] text-zinc-400"><tr><th class="px-4 py-3">Order</th><th class="px-4 py-3">User</th><th class="px-4 py-3 text-right">Amount</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Tanggal</th><th class="px-4 py-3 text-right">Aksi</th></tr></thead>
                <tbody class="divide-y divide-glass text-zinc-300">
                    @forelse ($payments as $payment)
                        <tr>
                            <td class="px-4 py-4 font-mono text-lens">{{ $payment->order?->order_number }}</td>
                            <td class="px-4 py-4">{{ $payment->order?->user?->name ?? '-' }}</td>
                            <td class="px-4 py-4 text-right font-mono text-brass">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td class="px-4 py-4"><span class="border border-glass bg-night px-3 py-1 font-mono text-xs uppercase tracking-[0.2em] {{ $payment->status === 'verified' ? 'text-green-400' : ($payment->status === 'rejected' ? 'text-red-400' : 'text-yellow-400') }}">{{ str_replace('_', ' ', $payment->status) }}</span></td>
                            <td class="px-4 py-4">{{ $payment->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-4 text-right"><x-link-button :href="route('admin.payments.show', $payment)" variant="secondary" class="px-3 py-2 text-xs">Detail</x-link-button></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-8 text-center text-zinc-500">Tidak ada pembayaran.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($payments->hasPages())<div class="mt-6">{{ $payments->links() }}</div>@endif
    </x-card>
@endsection
