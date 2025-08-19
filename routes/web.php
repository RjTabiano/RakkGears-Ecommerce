<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'home'])->name('home');

Auth::routes();
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');



route::get('/tracking', [HomeController::class, 'tracking'])->name('tracking');
route::get('/about', [HomeController::class, 'about'])->name('about');
route::get('/warranty', [HomeController::class, 'warranty'])->name('warranty');
route::get('/faq', [HomeController::class, 'faq'])->name('faq');
route::get('/forgotPass', [HomeController::class, 'forgotPass'])->name('forgotPass');


route::get('/product_list', [HomeController::class, 'product_list'])->name('product_list');
Route::get('/product_info/{id}', [ProductController::class, 'product_info'])->name('product.info');



route::get('/admin', [AdminController::class, 'dashboard'])->middleware(['auth', 'admin'])->name('admin');

route::get('/orders', [OrderController::class, 'orders'])->middleware(['auth', 'admin'])->name('orders');
Route::get('/orders/{id}/confirm', [OrderController::class, 'confirm'])->middleware(['auth', 'admin'])->name('orders.confirm');
Route::get('/orders/{id}/cancel', [OrderController::class, 'cancel'])->middleware(['auth', 'admin'])->name('orders.cancel');
Route::get('/orders/{id}/refund', [OrderController::class, 'refund'])->middleware(['auth', 'admin'])->name('orders.refund');



route::get('/products', [ProductController::class, 'all_products'])->middleware(['auth', 'admin'])->name('products');
route::post('/products/store', [ProductController::class, 'store_product'])->middleware(['auth', 'admin'])->name('product.store');
Route::get('/products/{id}', [ProductController::class, 'show'])->middleware(['auth', 'admin'])->name('product.show');

route::get('/add_products', [ProductController::class, 'add_products'])->middleware(['auth', 'admin'])->name('add_products');
Route::get('/products/{id}/edit', [ProductController::class, 'edit_product'])->middleware(['auth', 'admin'])->name('product.edit');
Route::put('/products/{id}', [ProductController::class, 'update_product'])->middleware(['auth', 'admin'])->name('product.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy_product'])->middleware(['auth', 'admin'])->name('product.destroy');
route::get('/accounts', [AdminController::class, 'accounts'])->middleware(['auth', 'admin'])->name('accounts');
Route::get('/users/{id}/make-admin', [AdminController::class, 'makeAdmin'])->middleware(['auth', 'admin'])->name('users.makeAdmin');
Route::get('/users/{id}/make-user', [AdminController::class, 'makeUser'])->middleware(['auth', 'admin'])->name('users.makeUser');


Route::middleware('auth')->group(function () {
    Route::get('/editProfile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/editProfile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/cart', [CartController::class, 'cart'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::put('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');

    Route::post('/products/{id}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    Route::get('/cart/{cart?}', [CheckoutController::class, 'showOrder'])->name('checkout.show');
    Route::post('/cart/checkout', [CheckoutController::class, 'storeOrder'])->name('checkout.store');
    Route::get('/cart//{order}/confirmation', [CheckoutController::class, 'cartConfirmation'])->name('order.confirmation');


    Route::get('/my_orders', [OrderController::class, 'showUserOrder'])->name('my.orders');
    Route::put('/order/{order}/cancel', [OrderController::class, 'cancelOrder'])->name('order.cancel');

});


