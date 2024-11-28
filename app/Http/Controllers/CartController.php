<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

use Illuminate\Http\Request;

class CartController extends Controller
{

    public function cart(){
        $user = auth()->user();

        $cart = $user->cart()->with('items.product')->first();

        $subtotal = $cart ? $cart->items->sum(fn($item) => $item->quantity * $item->price) : 0;

        return view('cart', compact('cart', 'subtotal'));
    }


    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $user = auth()->user();

        $cart = $user->cart()->firstOrCreate([]);

        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->quantity += $validated['quantity'];
            $cartItem->save();
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $validated['quantity'],
                'price' => $product->price, 
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function updateCart(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
        ]);

        $cart = $user->cart()->with('items')->first();

        if ($cart) {
            foreach ($cart->items as $item) {
                if (isset($validated['quantities'][$item->id])) {
                    $item->update([
                        'quantity' => $validated['quantities'][$item->id],
                    ]);
                }
            }
        }

        return redirect()->route('cart')->with('success', 'Cart updated successfully!');
    }


    public function removeItem($id)
    {
        $user = auth()->user();
        $cart = $user->cart()->first();

        if ($cart) {
            $item = $cart->items()->find($id);

            if ($item) {
                $item->delete();
                return response()->json(['success' => true]);
            }
        }

        return response()->json(['success' => false, 'message' => 'Item not found or already removed.'], 404);
    }
}
