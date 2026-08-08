<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StaffOrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
            'table_number' => 'required|integer|between:1,10',
        ]);

        $menu = Menu::findOrFail($validated['menu_id']);
        $totalPrice = $menu->price * $validated['quantity'];

        try {
            DB::transaction(function () use ($validated, $menu, $totalPrice) {
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'table_number' => $validated['table_number'],
                    'total_price' => $totalPrice,
                    'status' => 'pending',
                ]);

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $menu->id,
                    'quantity' => $validated['quantity'],
                    'price' => $menu->price,
                ]);
            });

            return back()->with('success', 'Order successfully placed for Table ' . $validated['table_number']);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        try {
            $order->update([
                'status' => $validated['status'],
            ]);

            return back()->with('success', 'Order status updated to ' . ucfirst($validated['status']));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update order status: ' . $e->getMessage());
        }
    }
}
