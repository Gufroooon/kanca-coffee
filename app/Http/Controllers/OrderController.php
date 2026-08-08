<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Public order page - no login required.
     */
    public function index()
    {
        $menus = Menu::with('category')
            ->where('is_available', true)
            ->orderBy('name', 'asc')
            ->get();

        return view('order.index', compact('menus'));
    }

    /**
     * Store a new order - public, no auth required.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_id'       => 'required|exists:menus,id',
            'quantity'      => 'required|integer|min:1',
            'table_number'  => 'required|integer|between:1,10',
            'customer_name' => 'nullable|string|max:100',
            'customer_note' => 'nullable|string|max:500',
        ]);

        $menu = Menu::findOrFail($validated['menu_id']);
        $totalPrice = $menu->price * $validated['quantity'];

        try {
            DB::transaction(function () use ($validated, $menu, $totalPrice) {
                $order = Order::create([
                    'user_id'       => Auth::id() ?? null,
                    'customer_name' => $validated['customer_name'] ?? null,
                    'customer_note' => $validated['customer_note'] ?? null,
                    'table_number'  => $validated['table_number'],
                    'total_price'   => $totalPrice,
                    'status'        => 'pending',
                ]);

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id'  => $menu->id,
                    'quantity' => $validated['quantity'],
                    'price'    => $menu->price,
                ]);
            });

            return back()->with('success', 'Pesanan berhasil dikirim ke Meja ' . $validated['table_number'] . '! Terima kasih.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim pesanan: ' . $e->getMessage());
        }
    }
}
