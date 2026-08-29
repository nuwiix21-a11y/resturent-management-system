<?php
namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function index()
    {
        return response()->json(
            Bill::with('order')->orderBy('created_at', 'desc')->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id'       => 'required|exists:orders,id',
            'subtotal'       => 'required|numeric|min:0',
            'discount'       => 'nullable|numeric|min:0',
            'tax'            => 'nullable|numeric|min:0',
            'total'          => 'required|numeric|min:0',
            'payment_status' => 'nullable|in:paid,unpaid',
        ]);

        // Prevent duplicate bills for same order
        $existing = Bill::where('order_id', $data['order_id'])->first();
        if ($existing) {
            $existing->update($data);
            return response()->json($existing);
        }

        $bill = Bill::create($data);
        return response()->json($bill, 201);
    }

    public function show(Bill $bill)
    {
        return response()->json($bill->load('order.orderItems.menuItem'));
    }

    public function markPaid(Bill $bill)
    {
        $bill->update(['payment_status' => 'paid']);
        return response()->json($bill);
    }
}
