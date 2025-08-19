<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use GuzzleHttp\Client;


class ProductController extends Controller
{

    public function all_products(Request $request){

        $category = $request->query('category');

        $products = Product::when($category, function ($query, $category) {
        $query->where('category', $category);
            })->paginate(10); 
            
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

    function uploadToSupabase($file, $bucket = 'Rakk') 
    {
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

        $client = new \GuzzleHttp\Client([
            'base_uri' => env('SUPABASE_URL') . '/storage/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . env('SUPABASE_ANON_KEY'),
                'apikey'        => env('SUPABASE_ANON_KEY'),
            ]
        ]);

        // Upload
        $response = $client->post("object/$bucket/products/$fileName", [
            'headers' => [
                'x-upsert' => 'true',
                'Content-Type' => $file->getMimeType(),
            ],
            'body' => file_get_contents($file->getRealPath())
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception("Upload failed: " . $response->getBody());
        }

        // Since it's public, URL is predictable:
        return env('SUPABASE_URL') . "/storage/v1/object/public/$bucket/products/$fileName";
    }

    private function deleteFromSupabase($fileUrl, $bucket = 'products')
    {
        $fileName = basename($fileUrl);

        $client = new \GuzzleHttp\Client([
            'base_uri' => env('SUPABASE_URL') . '/storage/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . env('SUPABASE_SERVICE_ROLE_KEY'),
                'apikey' => env('SUPABASE_SERVICE_ROLE_KEY'),
            ]
        ]);

        $client->delete("object/$bucket/$fileName");
    }

    public function store_product(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $imageUrl = null;

        if ($request->hasFile('image_path')) {
            $imageUrl = $this->uploadToSupabase($request->file('image_path'));
        }

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'image_path' => $imageUrl,
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

        $imageUrl = $product->image_path;

        if ($request->hasFile('image_path')) {
            if ($product->image_path) {
                $this->deleteFromSupabase($product->image_path);
            }

            $imageUrl = $this->uploadToSupabase($request->file('image_path'));
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
        $user = Auth::user();

        // Fetch product with reviews and related user data
        $product = Product::with(['reviews.user'])
                        ->withCount('reviews') // Counts reviews
                        ->withAvg('reviews', 'rating') // Averages the rating
                        ->findOrFail($id);
        
        
        
        return view('productDetails', compact('product', 'user'));
    }



    
}
