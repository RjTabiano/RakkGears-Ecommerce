<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Product;



class ProductController extends Controller
{

    public function all_products(Request $request){

        $category = $request->query('category');

        if ($category) {
            $products = Product::where('category', $category)->get();
        } else {
            $products = Product::all();
        }
        return view('admin_panel.productsList', ['products' => $products, 'category' => $category]);
    }


    public function show($id)
    {
        $product = Product::findOrFail($id);

        return response()->json($product);
    }

    public function add_products(){
        

        return view('admin_panel.addProducts');
    }


    public function store_product(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('products', 'public');
        } else {
            $imagePath = null;
        }

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('add_products')->with('success', 'Product added successfully');
    }


    public function edit_product($id)
    {
        $product = Product::findOrFail($id); 
        return view('admin_panel.editProduct', compact('product'));
    }

    public function update_product(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::findOrFail($id); 

        if ($request->hasFile('image_path')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }

            $imagePath = $request->file('image_path')->store('products', 'public');
        } else {
            $imagePath = $product->image_path; 
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('products')->with('success', 'Product updated successfully');
    }



    public function destroy_product($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image_path) {
            // Ensure the file exists before trying to delete
            if (Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            } else {
                // Log or notify if file is missing
                \Log::warning('File not found: ' . $product->image_path);
            }
        }

        $product->delete();

        return redirect()->route('products')->with('success', 'Product deleted successfully');
    }


    public function product_info($id)
    {
        $product = Product::findOrFail($id);
        return view('productDetails', compact('product'));
    }

    
}
