<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['orderItems.menuItem', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type'           => 'required|in:dine_in,takeaway',
            'table_number'   => 'nullable|integer|min:1',
            'notes'          => 'nullable|string',
            'items'          => 'required|array|min:1',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity'     => 'required|integer|min:1',
            'items.*.unit_price'   => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Calculate total
            $total = collect($data['items'])->sum(fn($i) => $i['unit_price'] * $i['quantity']);

            $order = Order::create([
                'user_id'      => $request->user()->id,
                'type'         => $data['type'],
                'table_number' => $data['table_number'] ?? null,
                'notes'        => $data['notes'] ?? null,
                'status'       => 'pending',
                'total'        => $total,
            ]);

            foreach ($data['items'] as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'menu_item_id' => $item['menu_item_id'],
                    'quantity'     => $item['quantity'],
                    'unit_price'   => $item['unit_price'],
                    'subtotal'     => $item['unit_price'] * $item['quantity'],
                ]);
            }

            DB::commit();
            return response()->json($order->load('orderItems.menuItem'), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to create order: ' . $e->getMessage()], 500);
        }
    }

    public function show(Order $order)
    {
        return response()->json($order->load(['orderItems.menuItem', 'user']));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,preparing,ready,completed,cancelled',
        ]);
        $order->update(['status' => $data['status']]);
        return response()->json($order);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(['message' => 'Order deleted.']);
    }
}
