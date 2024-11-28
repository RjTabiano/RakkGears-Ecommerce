@extends('layout.layout')

@section('content')
<div class="px-4 py-5">

    <h5 class="text-uppercase">Order Confirmation</h5>

    <h4 class="mt-5 theme-color mb-5">Thanks for your order!</h4>

    <span class="theme-color">Order Number: #{{ $order->order_number }}</span>
    <div class="mb-3">
        <hr class="new1">
    </div>

    <!-- Order Summary -->
    <span class="theme-color">Payment Summary</span>
    <div class="mb-3">
        <hr class="new1">
    </div>

    <!-- Product List -->
    @foreach($order->orderItems as $item)
        <div class="d-flex justify-content-between">
            <span class="font-weight-bold">{{ $item->product->name }} (Qty: {{ $item->quantity }})</span>
            <span class="text-muted">₱{{ number_format($item->price, 2) }}</span>
        </div>
    @endforeach

    <!-- Shipping and Tax -->
    <div class="d-flex justify-content-between">
        <small>Shipping</small>
        <small>₱50</small>
    </div>

    
    <!-- Total Price -->
    <div class="d-flex justify-content-between mt-3">
        <span class="font-weight-bold">Total</span>
        <span class="font-weight-bold theme-color">₱{{ number_format($order->total_price, 2) }}</span>
    </div>  

    <!-- Track Order Button -->
    <div class="text-center mt-5">
        <a href="{{ route('my.orders') }}">
            <button class="btn btn-primary">Track your order</button>
        </a>
    </div>                   

</div>


@endsection