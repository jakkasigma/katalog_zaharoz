<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $user = auth()->user();

        if ($user->addresses()->count() === 0) {
            return redirect()->route('addresses.create')
                ->with('status', 'Tambahkan alamat pengiriman terlebih dahulu untuk melanjutkan checkout.');
        }

        $addresses = $user->addresses()->get();
        $defaultAddress = $addresses->firstWhere('is_default', true) ?? $addresses->first();

        return view('checkout.index', compact('addresses', 'defaultAddress'));
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $orderNumber = 'ORD-'.strtoupper(str()->random(4)).date('ymd').strtoupper(str()->random(4));

            $subtotal = 0;

            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => auth()->id(),
                'address_id' => $validated['address_id'],
                'status' => 'pending',
                'payment_status' => 'pending',
                'subtotal' => $subtotal,
                'shipping_cost' => 0,
                'total' => $subtotal,
                'notes' => $validated['notes'] ?? null,
            ]);

            Payment::create([
                'order_id' => $order->id,
                'amount' => $order->total,
                'method' => 'transfer',
                'status' => 'pending',
            ]);

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('status', 'Pesanan berhasil dibuat. Silakan upload bukti pembayaran.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Terjadi kesalahan saat membuat pesanan. Silakan coba lagi.');
        }
    }
}
