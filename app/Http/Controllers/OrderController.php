<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of user's orders.
     */
    public function index()
    {
        $orders = Auth::user()->orders()
            ->orderBy('ordered_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        $categories = [
            'paket' => 'Menu Paket',
            'gyutan' => 'Spesial Gyutan',
            'dori' => 'Spesial Dori',
            'salmon' => 'Spesial Salmon',
            'nasi_goreng' => 'Spesial Nasi Goreng',
            'mie_bihun' => 'Mie/Bihun/Sohun/Kwetiau',
            'snack' => 'Snack',
            'minuman' => 'Minuman',
        ];

        $menuItems = MenuItem::where('is_available', true)->get()->groupBy('category');

        return view('orders.create', compact('categories', 'menuItems'));
    }

    /**
     * Store a newly created order in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.notes' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:500',
        ]);

        // Create order
        $order = Auth::user()->orders()->create([
            'order_number' => Order::generateOrderNumber(),
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        // Add order items
        foreach ($validated['items'] as $item) {
            $menuItem = MenuItem::findOrFail($item['menu_item_id']);

            $order->items()->create([
                'menu_item_id' => $menuItem->id,
                'quantity' => $item['quantity'],
                'unit_price' => $menuItem->price,
                'subtotal' => $menuItem->price * $item['quantity'],
                'notes' => $item['notes'] ?? null,
            ]);
        }

        // Calculate totals
        $order->calculateTotals();

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order placed successfully!');
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Authorize user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order (only pending orders).
     */
    public function edit(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Only pending orders can be edited.');
        }

        $categories = [
            'paket' => 'Menu Paket',
            'gyutan' => 'Spesial Gyutan',
            'dori' => 'Spesial Dori',
            'salmon' => 'Spesial Salmon',
            'nasi_goreng' => 'Spesial Nasi Goreng',
            'mie_bihun' => 'Mie/Bihun/Sohun/Kwetiau',
            'snack' => 'Snack',
            'minuman' => 'Minuman',
        ];

        $menuItems = MenuItem::where('is_available', true)->get()->groupBy('category');

        return view('orders.edit', compact('order', 'categories', 'menuItems'));
    }

    /**
     * Update the specified order in database.
     */
    public function update(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Only pending orders can be edited.');
        }

        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.notes' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:500',
        ]);

        // Delete old items
        $order->items()->delete();

        // Add new items
        foreach ($validated['items'] as $item) {
            $menuItem = MenuItem::findOrFail($item['menu_item_id']);

            $order->items()->create([
                'menu_item_id' => $menuItem->id,
                'quantity' => $item['quantity'],
                'unit_price' => $menuItem->price,
                'subtotal' => $menuItem->price * $item['quantity'],
                'notes' => $item['notes'] ?? null,
            ]);
        }

        $order->update([
            'notes' => $validated['notes'] ?? null,
        ]);

        // Recalculate totals
        $order->calculateTotals();

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order updated successfully!');
    }

    /**
     * Cancel the specified order.
     */
    public function destroy(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Only pending or confirmed orders can be cancelled.');
        }

        $order->update(['status' => 'cancelled']);

        return redirect()->route('orders.index')
            ->with('success', 'Order cancelled successfully!');
    }
}
