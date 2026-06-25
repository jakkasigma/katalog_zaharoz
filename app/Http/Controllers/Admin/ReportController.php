<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $period = $request->string('period')->toString() ?: 'monthly';
        $date = $request->string('date')->toString() ?: now()->toDateString();
        $month = $request->string('month')->toString() ?: now()->format('Y-m');
        $year = $request->string('year')->toString() ?: now()->format('Y');

        [$startDate, $endDate, $label] = $this->resolvePeriod($period, $date, $month, $year);

        $orders = Order::query()
            ->where('payment_status', 'verified')
            ->whereBetween('created_at', [$startDate, $endDate]);

        $summary = [
            'revenue' => (clone $orders)->sum('total'),
            'orders' => (clone $orders)->count(),
            'average_order' => (clone $orders)->avg('total') ?? 0,
            'products_sold' => OrderItem::query()
                ->whereHas('order', fn ($query) => $query->where('payment_status', 'verified')->whereBetween('created_at', [$startDate, $endDate]))
                ->sum('quantity'),
        ];

        $topProducts = OrderItem::query()
            ->select('product_id', 'product_name')
            ->selectRaw('SUM(quantity) as total_quantity')
            ->selectRaw('SUM(subtotal) as total_revenue')
            ->whereHas('order', fn ($query) => $query->where('payment_status', 'verified')->whereBetween('created_at', [$startDate, $endDate]))
            ->groupBy('product_id', 'product_name')
            ->orderByDesc('total_quantity')
            ->take(10)
            ->get();

        $dailySales = Order::query()
            ->select(DB::raw('DATE(created_at) as sale_date'))
            ->selectRaw('COUNT(*) as total_orders')
            ->selectRaw('SUM(total) as total_revenue')
            ->where('payment_status', 'verified')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('sale_date')
            ->get();

        return view('admin.reports.index', compact('period', 'date', 'month', 'year', 'label', 'summary', 'topProducts', 'dailySales'));
    }

    /**
     * @return array{0: Carbon, 1: Carbon, 2: string}
     */
    private function resolvePeriod(string $period, string $date, string $month, string $year): array
    {
        return match ($period) {
            'daily' => [Carbon::parse($date)->startOfDay(), Carbon::parse($date)->endOfDay(), Carbon::parse($date)->translatedFormat('d F Y')],
            'yearly' => [Carbon::createFromDate((int) $year)->startOfYear(), Carbon::createFromDate((int) $year)->endOfYear(), $year],
            default => [Carbon::parse($month.'-01')->startOfMonth(), Carbon::parse($month.'-01')->endOfMonth(), Carbon::parse($month.'-01')->translatedFormat('F Y')],
        };
    }
}
