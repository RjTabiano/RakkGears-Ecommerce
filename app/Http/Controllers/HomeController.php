<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        return view('welcome');
    }

    public function index()
    {
        return view('home');
    }

    public function product_list(Request $request)
    {
        $categories = $request->query('categories', []); // Get selected categories as an array
        $searchTerm = $request->query('search'); // Get the search term from the query string

        $query = Product::query();

        // Filter products by category if categories are selected
        if (!empty($categories)) {
            $query->whereIn('category', $categories);
        }

        // Filter products by search term if provided
        if ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        $products = $query->get(); // Execute the query

        // Get all categories for the sidebar dynamically (assumes Product has a 'category' column)
        $allCategories = Product::select('category')
            ->distinct()
            ->get()
            ->map(function ($product) {
                return $product->category;
            });

        return view('productList', [
            'products' => $products,
            'allCategories' => $allCategories,
            'selectedCategories' => $categories,
        ]);
    }



    public function tracking()
    {
        return view('tracking');
    }

    public function about()
    {
        return view('about');
    }

    public function warranty()
    {
        return view('warranty');
    }

    public function faq()
    {
        return view('faq');
    }

    public function forgotPass()
    {
        return view('forgotPass');
    }
}
