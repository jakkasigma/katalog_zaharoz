<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RejectPaymentRequest;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PaymentVerificationController extends Controller
{
    public function index(Request $request): View
    {
        $payments = Payment::query()
            ->with(['order.user'])
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment): View
    {
        $payment->load(['order.user', 'order.items.product', 'order.address', 'verifier']);

        return view('admin.payments.show', compact('payment'));
    }

    public function approve(Payment $payment): RedirectResponse
    {
        abort_unless($payment->status === 'waiting_confirmation', 409, 'Pembayaran ini tidak menunggu konfirmasi.');

        DB::transaction(function () use ($payment): void {
            $payment->update([
                'status' => 'verified',
                'rejection_reason' => null,
                'verified_by' => auth()->id(),
                'verified_at' => now(),
            ]);

            $payment->order()->update([
                'payment_status' => 'verified',
                'status' => 'processing',
            ]);
        });

        return redirect()->route('admin.payments.index')
            ->with('status', 'Pembayaran berhasil diverifikasi.');
    }

    public function reject(RejectPaymentRequest $request, Payment $payment): RedirectResponse
    {
        abort_unless($payment->status === 'waiting_confirmation', 409, 'Pembayaran ini tidak menunggu konfirmasi.');

        DB::transaction(function () use ($request, $payment): void {
            $payment->update([
                'status' => 'rejected',
                'rejection_reason' => $request->validated('rejection_reason'),
                'verified_by' => auth()->id(),
                'verified_at' => now(),
            ]);

            $payment->order()->update([
                'payment_status' => 'rejected',
            ]);
        });

        return redirect()->route('admin.payments.index')
            ->with('status', 'Pembayaran ditolak.');
    }
}
