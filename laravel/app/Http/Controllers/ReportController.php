<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function summary(Request $request)
    {
        $from = $request->query('from', now()->startOfDay());
        $to   = $request->query('to',   now()->endOfDay());

        $orders    = Order::whereBetween('created_at', [$from, $to])->get();
        $completed = $orders->where('status', 'completed');

        return response()->json([
            'total_revenue'    => $completed->sum('total'),
            'completed_orders' => $completed->count(),
            'total_orders'     => $orders->count(),
            'avg_order_value'  => $completed->count() > 0
                ? round($completed->sum('total') / $completed->count(), 2)
                : 0,
            'items_sold'       => OrderItem::whereHas('order', fn($q) =>
                $q->where('status', 'completed')->whereBetween('created_at', [$from, $to])
            )->sum('quantity'),
        ]);
    }

    public function topItems(Request $request)
    {
        $from = $request->query('from', now()->startOfDay());
        $to   = $request->query('to',   now()->endOfDay());

        $items = OrderItem::select(
                'menu_item_id',
                DB::raw('SUM(quantity) as total_qty'),
                DB::raw('SUM(subtotal) as total_revenue')
            )
            ->whereHas('order', fn($q) =>
                $q->where('status', 'completed')->whereBetween('created_at', [$from, $to])
            )
            ->with('menuItem:id,name')
            ->groupBy('menu_item_id')
            ->orderByDesc('total_qty')
            ->limit(10)
            ->get();

        return response()->json($items);
    }
}
