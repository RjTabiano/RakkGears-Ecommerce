<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $id)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
        ]);

        $product = Product::findOrFail($id);

        $product->reviews()->create([
            'user_id' => auth()->id(), 
            'rating' => $validated['rating'],
            'review' => $validated['review'],
        ]);

        $product->update([
            'reviews_count' => $product->reviews()->count(),
            'rating' => $product->reviews()->avg('rating'),
        ]);

        return back()->with('success', 'Your review has been submitted.');
    }
}
