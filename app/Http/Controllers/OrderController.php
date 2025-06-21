<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Order::class, 'order');
    }

    /**
     * Display a listing of the resource (My Orders page).
     */
    public function index()
    {
        $orders = Order::with(['orderItems.product'])
            ->byUser(Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Create a demo order for a product (simulating WhatsApp order).
     */
    public function create(Request $request)
    {
        $productId = $request->get('product_id');
        $quantity = $request->get('quantity', 1);

        if (!$productId) {
            return redirect()->back()->withErrors(['error' => 'Product not specified.']);
        }

        $product = Product::findOrFail($productId);

        return view('orders.create', compact('product', 'quantity'));
    }

    /**
     * Store a newly created order (demo order creation).
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check stock availability
        if (!$product->hasSufficientStock($request->quantity)) {
            return back()->withErrors(['quantity' => 'Insufficient stock available.']);
        }

        DB::transaction(function () use ($request, $product) {
            // Create the order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $product->price * $request->quantity,
                'status' => Order::STATUS_PENDING,
            ]);

            // Create order item
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'unit_price' => $product->price,
            ]);

            // Reduce product stock
            $product->reduceStock($request->quantity);
        });

        return redirect()->route('orders.index')
            ->with('success', 'Demo order created successfully! In a real scenario, you would contact the seller via WhatsApp.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['orderItems.product.category', 'orderItems.product.user']);
        return view('orders.show', compact('order'));
    }

    /**
     * Update the order status (for demo purposes).
     */
    public function updateStatus(Request $request, Order $order)
    {
        $this->authorize('update', $order);

        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order status updated successfully.');
    }

    /**
     * Cancel an order.
     */
    public function cancel(Order $order)
    {
        $this->authorize('cancel', $order);

        if (!$order->canBeCancelled()) {
            return back()->withErrors(['error' => 'This order cannot be cancelled.']);
        }

        DB::transaction(function () use ($order) {
            // Restore product stock
            foreach ($order->orderItems as $item) {
                $item->product->increment('stock', $item->quantity);
            }

            // Update order status
            $order->update(['status' => Order::STATUS_CANCELLED]);
        });

        return redirect()->route('orders.index')
            ->with('success', 'Order cancelled successfully.');
    }
}
