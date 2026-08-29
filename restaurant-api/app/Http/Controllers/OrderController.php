<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['orderItems.menuItem', 'user'])
            ->orderBy('created_at', 'desc');
            
        if ($request->user()->role !== 'admin') {
            $query->where('user_id', $request->user()->id);
        }
        
        return response()->json($query->get());
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
            if ($data['type'] === 'dine_in' && !empty($data['table_number'])) {
                $table = \App\Models\Table::where('table_number', $data['table_number'])->first();
                if ($table && $table->status === 'occupied') {
                    throw new \Exception('Table is already occupied.');
                }
                if ($table) {
                    $table->update(['status' => 'occupied']);
                }
            }

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
            return response()->json(['message' => 'Failed to create order: ' . $e->getMessage()], 400);
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

        // If cancelled and it was dine_in, free the table
        if ($data['status'] === 'cancelled' && $order->type === 'dine_in' && $order->table_number) {
            \App\Models\Table::where('table_number', $order->table_number)->update(['status' => 'available']);
        }

        return response()->json($order);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(['message' => 'Order deleted.']);
    }
}
