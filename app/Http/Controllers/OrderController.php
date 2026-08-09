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
        // Support legacy single-item ordering
        if ($request->has('menu_id') && !$request->has('items')) {
            $request->merge([
                'items' => [
                    [
                        'menu_id' => $request->input('menu_id'),
                        'quantity' => $request->input('quantity', 1),
                    ]
                ]
            ]);
        }

        $validated = $request->validate([
            'table_number'  => 'required|integer|between:1,10',
            'customer_name' => 'nullable|string|max:100',
            'customer_note' => 'nullable|string|max:500',
            'items'         => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                // Calculate total price
                $totalPrice = 0;
                $orderItems = [];

                foreach ($validated['items'] as $itemData) {
                    $menu = Menu::findOrFail($itemData['menu_id']);
                    $price = $menu->price;
                    $subtotal = $price * $itemData['quantity'];
                    $totalPrice += $subtotal;

                    $orderItems[] = [
                        'menu_id'  => $menu->id,
                        'quantity' => $itemData['quantity'],
                        'price'    => $price,
                    ];
                }

                $order = Order::create([
                    'user_id'       => Auth::id() ?? null,
                    'customer_name' => $validated['customer_name'] ?? null,
                    'customer_note' => $validated['customer_note'] ?? null,
                    'table_number'  => $validated['table_number'],
                    'total_price'   => $totalPrice,
                    'status'        => 'pending',
                ]);

                foreach ($orderItems as $item) {
                    $order->items()->create($item);
                }
            });

            return back()->with('success', 'Pesanan berhasil dikirim ke Meja ' . $validated['table_number'] . '! Terima kasih.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim pesanan: ' . $e->getMessage());
        }
    }
}
