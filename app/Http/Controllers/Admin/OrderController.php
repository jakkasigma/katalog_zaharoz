<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateOrderStatusRequest;
use App\Models\Notification;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = Order::query()
            ->with(['user', 'payment'])
            ->where('payment_status', 'verified') // hanya tampil setelah pembayaran di-approve
            ->when($request->filled('search'), fn ($query) => $query->where('order_number', 'like', '%'.$request->string('search')->toString().'%'))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')->toString()))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'address', 'items.product', 'payment.verifier']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(UpdateOrderStatusRequest $request, Order $order): RedirectResponse
    {
        $validated = $request->validated();
        $updates = ['status' => $validated['status']];

        if ($validated['status'] === 'shipped') {
            $updates['tracking_number'] = $validated['tracking_number'];
            $updates['shipped_at'] = now();

            Notification::create([
                'user_id' => $order->user_id,
                'title' => 'Pesanan Dikirim',
                'message' => "Pesanan #{$order->order_number} telah dikirim. Nomor resi: {$validated['tracking_number']}",
                'type' => 'info',
                'link' => route('orders.show', $order),
            ]);
        }

        if ($validated['status'] === 'delivered') {
            $updates['delivered_at'] = now();

            Notification::create([
                'user_id' => $order->user_id,
                'title' => 'Pesanan Diterima',
                'message' => "Pesanan #{$order->order_number} telah diterima. Terima kasih telah berbelanja di Eyes Zaharoz!",
                'type' => 'success',
                'link' => route('orders.show', $order),
            ]);
        }

        $order->update($updates);

        return redirect()->route('admin.orders.index')
            ->with('status', 'Status pesanan berhasil diperbarui.');
    }
}
