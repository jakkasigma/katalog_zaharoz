<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            'users' => User::query()->where('is_admin', false)->count(),
            'products' => Product::query()->count(),
            'pending_payments' => Payment::query()->where('status', 'pending_verification')->count(),
            'pending_orders' => Order::query()->where('status', 'pending')->count(),
        ];

        $recentOrders = Order::query()
            ->with(['user', 'payment'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
