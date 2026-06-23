<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;

class OrderController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        $orders = auth()->user()
            ->orders()
            ->with(['items.product', 'payment', 'address'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $this->authorize('view', $order);

        $order->load(['items.product', 'payment', 'address', 'user']);

        return view('orders.show', compact('order'));
    }
}
