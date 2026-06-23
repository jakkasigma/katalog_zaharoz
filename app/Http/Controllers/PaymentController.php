<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadPaymentProofRequest;
use App\Models\Order;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PaymentController extends Controller
{
    use AuthorizesRequests;

    public function create(Order $order): View
    {
        $this->authorize('update', $order);

        if (! in_array($order->payment_status, ['pending', 'rejected'])) {
            abort(403, 'Pembayaran sudah diupload atau tidak dapat diubah.');
        }

        return view('payments.create', compact('order'));
    }

    public function store(UploadPaymentProofRequest $request, Order $order): RedirectResponse
    {
        $this->authorize('update', $order);

        if (! in_array($order->payment_status, ['pending', 'rejected'])) {
            return back()->with('error', 'Pembayaran sudah diupload atau tidak dapat diubah.');
        }

        $path = $request->file('payment_proof')->store('payment-proofs', 'public');

        $order->payment()->update([
            'proof_path' => $path,
            'status' => 'pending_verification',
        ]);

        $order->update([
            'payment_status' => 'pending_verification',
        ]);

        return redirect()->route('orders.show', $order)
            ->with('status', 'Bukti pembayaran berhasil diupload. Tunggu verifikasi dari admin.');
    }
}
