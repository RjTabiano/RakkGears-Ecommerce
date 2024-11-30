<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Checkout;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;

class CheckoutController extends Controller
{
    private function generateOrderNumber()
    {
        $prefix = 'ORD';
        return $prefix . '-' . str_pad(Order::max('id') + 1, 8, '0', STR_PAD_LEFT);
    }


    public function showOrder(Cart $cart = null)
    {
        if (!$cart) {
            return redirect()->route('cart')->with('error', 'Cart not found. Please add items to your cart.');
        }

        $this->authorize('view', $cart);

        $cart->load('items.product');

        return view('checkout', compact('cart'));
    }

    public function storeOrder(Request $request)
    {
        $totalPrice = preg_replace('/,/', '', $request->total_price);
        $totalPrice = (float)$totalPrice;
        $request->validate([
            'billing_first_name' => 'required|string',
            'billing_last_name' => 'required|string',
            'billing_email' => 'required|email',
            'billing_phone' => 'required|string',
            'billing_address' => 'required|string',
            'billing_city' => 'required|string',
            'billing_country' => 'required|string',
            'payment_method' => 'required|string',
        ]);


        // Handle shipping details based on whether the user has selected "ship to different address"
        $shippingDetails = $request->has('ship_to_different_address') ? [
            'first_name' => $request->shipping_first_name,
            'last_name' => $request->shipping_last_name,
            'company' => $request->shipping_company,
            'address' => $request->shipping_address,
            'city' => $request->shipping_city,
            'state' => $request->shipping_state,
            'zip' => $request->shipping_zip,
            'country' => $request->shipping_country,
        ] : [
            'first_name' => $request->billing_first_name,
            'last_name' => $request->billing_last_name,
            'company' => $request->billing_company,
            'address' => $request->billing_address,
            'city' => $request->billing_city,
            'state' => $request->billing_state,
            'zip' => $request->billing_zip,
            'country' => $request->billing_country,
        ];

        // Prepare billing details
        $billingDetails = [
            'first_name' => $request->billing_first_name,
            'last_name' => $request->billing_last_name,
            'company' => $request->billing_company,
            'address' => $request->billing_address,
            'city' => $request->billing_city,
            'state' => $request->billing_state,
            'zip' => $request->billing_zip,
            'country' => $request->billing_country,
            'phone' => $request->billing_phone,
            'email' => $request->billing_email,
        ];


        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => $this->generateOrderNumber(),
            'billing_details' => json_encode($billingDetails),  // Save as JSON
            'shipping_details' => json_encode($shippingDetails), // Save as JSON
            'payment_method' => $request->payment_method,
            'total_price' => (float)$totalPrice,
            'status' => 'pending',
        ]);

        $cart = Cart::where('user_id', auth()->id())->first();

        if ($cart) {
            // Iterate over the items in the user's cart and create OrderItem records
            foreach ($cart->items as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                ]);
            }

            // Optionally clear the cart after the order is placed
            $cart->items()->delete();
        }

        // Redirect to the order confirmation page
        return redirect()->route('order.confirmation', ['order' => $order->id])
                ->with('success', 'Your order has been placed successfully!');

    }

    public function cartConfirmation(Order $order)
    {   
        return view('orderConfirmation', compact('order'));
    }

}
