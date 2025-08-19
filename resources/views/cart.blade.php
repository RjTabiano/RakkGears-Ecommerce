@extends('layout.layout')

@section('csrf')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
 

 <!--shopping cart area start -->
<div class="shopping_cart_area mt-60">
    <div class="container">  
        <form action="{{ route('cart.update') }}" method="POST"> 
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-12">
                    <div class="table_desc">
                        <div class="cart_page table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="product_thumb">Image</th>
                                        <th class="product_name">Product</th>
                                        <th class="product-price">Price</th>
                                        <th class="product_quantity">Quantity</th>
                                        <th class="product_total">Total</th>
                                        <th class="product_remove">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($cart && $cart->items->count() > 0)
                                        @foreach($cart->items as $item)
                                            <tr>
                                                <td class="product_thumb">
                                                    <a href="#">
                                                        <img src="{{ $item->product->image_path }}" alt="{{ $item->product->name }}">
                                                    </a>
                                                </td>
                                                <td class="product_name">
                                                    <a href="#">{{ $item->product->name }}</a>
                                                </td>
                                                <td class="product-price">₱{{ number_format($item->price, 2) }}</td>
                                                <td class="product_quantity">
                                                    <input type="number" name="quantities[{{ $item->id }}]" value="{{ $item->quantity }}" min="1">
                                                </td>
                                                <td class="product_total">₱{{ number_format($item->quantity * $item->price, 2) }}</td>
                                                <td class="product_remove">
                                                    <button 
                                                        type="button" 
                                                        class="btn btn-danger btn-sm delete-item" 
                                                        data-url="{{ route('cart.remove', $item->id) }}" 
                                                        onclick="removeItem(this)"
                                                    >
                                                        <i class="ion-android-close"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">Your cart is empty.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>   
                        </div>  
                        <div class="cart_submit">
                            <button type="submit">Update Cart</button>
                        </div>      
                    </div>
                </div>
            </div>
            <!--coupon code area start-->
            <div class="coupon_area">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="coupon_code left">
                            <h3>Coupon</h3>
                            <div class="coupon_inner">   
                                <p>Enter your coupon code if you have one.</p>                                
                                <input placeholder="Coupon code" type="text" name="coupon_code">
                                <button type="submit">Apply Coupon</button>
                            </div>    
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="coupon_code right">
                            <h3>Cart Totals</h3>
                            <div class="coupon_inner">
                                <div class="cart_subtotal">
                                    <p>Subtotal</p>
                                    <p class="cart_amount">₱{{ number_format($subtotal, 2) }}</p>
                                </div>
                                <div class="checkout_btn">
                                    <a href="{{ route('checkout.show', ['cart' => $cart]) }}">Proceed to Checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--coupon code area end-->
        </form> 
    </div>     
</div>
<!--shopping cart area end -->
@endsection

@section('scripts')
<script>
    function removeItem(button) {
        const url = button.getAttribute('data-url');

        if (confirm('Are you sure you want to remove this item?')) {
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Failed to remove item.');
                }
            })
            .then(data => {
                if (data.success) {
                    alert('Item removed successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error(error);
                alert('An error occurred. Please try again.');
            });
        }
    }
</script>
@endsection