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
    public function __construct()
    {
        $this->middleware('auth');
    }

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

        if (!empty($categories)) {
            $products = Product::whereIn('category', $categories)->get();
        } else {
            $products = Product::all();
        }

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
