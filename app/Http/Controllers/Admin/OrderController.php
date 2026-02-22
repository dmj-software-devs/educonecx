<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $query = Order::with('user');

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('payment_status', $request->status);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('transaction_id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load('user', 'items.course');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Process refund for an order.
     */
    public function refund(Request $request, Order $order)
    {
        if ($order->payment_status !== 'paid') {
            return back()->with('error', 'Only paid orders can be refunded.');
        }

        // Here you would integrate with payment gateway to process refund
        // For now, just update status

        $order->update(['payment_status' => 'refunded']);

        // Update enrollments
        $order->enrollments()->update(['status' => 'cancelled']);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order refunded successfully.');
    }

    /**
     * Remove the specified order.
     */
    public function destroy(Order $order)
    {
        if ($order->payment_status === 'paid') {
            return back()->with('error', 'Cannot delete a paid order.');
        }

        $order->items()->delete();
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully.');
    }
}