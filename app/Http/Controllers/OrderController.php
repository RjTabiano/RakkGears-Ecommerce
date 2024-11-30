<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;


class OrderController extends Controller
{
    public function orders(Request $request)
    {
        $status = $request->query('status');

        $orders = Order::when($status, function ($query, $status) {
            $query->where('status', $status);
        })->paginate(10);

        foreach ($orders as $order) {
            $order->billing_details = json_decode($order->billing_details, true);
            $order->shipping_details = $order->shipping_details ? json_decode($order->shipping_details, true) : null;
        }

        return view('admin_panel.orders', [
            'orders' => $orders,
            'status' => $status,
        ]);
    }


    public function confirm($id)
    {
        $order = Order::find($id);
        if ($order && $order->status == 'pending') {
            $order->status = 'processing';
            $order->save();
        }
        return redirect()->route('orders');
    }

    public function cancel($id)
    {
        $order = Order::find($id);
        if ($order && $order->status == 'processing') {
            $order->status = 'cancelled';
            $order->save();
        }
        return redirect()->route('orders');
    }

    public function refund($id)
    {
        $order = Order::find($id);
        if ($order && $order->status == 'completed') {
            $order->status = 'refunded';
            $order->save();
        }
        return redirect()->route('orders');
    }
    



    public function showUserOrder()
    {
        // Get orders of the authenticated user
        $orders = Order::where('user_id', auth()->id())
                       ->orderBy('created_at', 'desc')
                       ->get();

        // Group orders by their status
        $pendingOrders = $orders->where('status', 'pending');
        $processingOrders = $orders->where('status', 'processing');
        $completedOrders = $orders->where('status', 'completed');
        $cancelledOrders = $orders->where('status', 'cancelled');

        // Return the view with the orders data
        return view('myOrder', compact('pendingOrders', 'processingOrders', 'completedOrders', 'cancelledOrders'));
    }

    public function cancelOrder($orderId)
    {
        // Find the order by its ID and ensure it's pending
        $order = Order::where('id', $orderId)
                    ->where('status', 'pending')
                    ->first();

        // If the order doesn't exist or is not pending, show an error
        if (!$order) {
            return redirect()->route('my.orders')->with('error', 'Order not found or cannot be cancelled.');
        }

        // Update the order status to cancelled
        $order->status = 'cancelled';
        $order->save();

        // Redirect back to the orders page with a success message
        return redirect()->route('my.orders')->with('success', 'Order has been cancelled successfully.');
    }

   
}
