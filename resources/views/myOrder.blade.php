@extends('layout.layout')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <!-- Title Section -->
        <div class="col-12 text-center mb-4">
            <h2 style="font-size: 36px; font-weight: bold; color: #333;">My Orders</h2>
        </div>

        <!-- Nav Menu Section (Tabs) -->
        <div class="col-12">
            <ul class="nav nav-pills nav-fill mb-4" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pending-orders-tab" data-toggle="tab" href="#pending-orders" role="tab" aria-controls="pending-orders" aria-selected="true">
                        Pending Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="processing-orders-tab" data-toggle="tab" href="#processing-orders" role="tab" aria-controls="processing-orders" aria-selected="false">
                        To Receive
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="completed-orders-tab" data-toggle="tab" href="#completed-orders" role="tab" aria-controls="completed-orders" aria-selected="false">
                        Completed Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="cancelled-orders-tab" data-toggle="tab" href="#cancelled-orders" role="tab" aria-controls="cancelled-orders" aria-selected="false">
                        Cancelled Orders
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                
                <!-- Pending Orders Tab -->
                <div class="tab-pane fade show active" id="pending-orders" role="tabpanel" aria-labelledby="pending-orders-tab">
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Date</th>
                                <th>Action</th> <!-- New column for the action button -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingOrders as $order)
                                <tr>
                                    <td>#{{ $order->order_number }}</td>
                                    <td>{{ ucfirst($order->status) }}</td>
                                    <td>₱{{ number_format($order->total_price, 2) }}</td>
                                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <!-- Add Cancel button -->
                                        <form action="{{ route('order.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?');">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-danger btn-sm">Cancel Order</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <!-- To Receive Orders (Processing Orders) Tab -->
                <div class="tab-pane fade" id="processing-orders" role="tabpanel" aria-labelledby="processing-orders-tab">
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($processingOrders as $order)
                                <tr>
                                    <td>#{{ $order->order_number }}</td>
                                    <td>{{ ucfirst($order->status) }}</td>
                                    <td>₱{{ number_format($order->total_price, 2) }}</td>
                                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Completed Orders Tab -->
                <div class="tab-pane fade" id="completed-orders" role="tabpanel" aria-labelledby="completed-orders-tab">
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($completedOrders as $order)
                                <tr>
                                    <td>#{{ $order->order_number }}</td>
                                    <td>{{ ucfirst($order->status) }}</td>
                                    <td>₱{{ number_format($order->total_price, 2) }}</td>
                                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Cancelled Orders Tab -->
                <div class="tab-pane fade" id="cancelled-orders" role="tabpanel" aria-labelledby="cancelled-orders-tab">
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cancelledOrders as $order)
                                <tr>
                                    <td>#{{ $order->order_number }}</td>
                                    <td>{{ ucfirst($order->status) }}</td>
                                    <td>₱{{ number_format($order->total_price, 2) }}</td>
                                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .nav-pills .nav-link {
        background-color: #000; /* Default black background */
        color: white; /* White text */
        font-weight: bold;
        border-radius: 0; /* Remove rounded corners */
        transition: background-color 0.3s ease, color 0.3s ease; /* Smooth transition */
    }

    .nav-pills .nav-link:hover {
        background-color: #F3A9A9; /* Light red on hover */
        color: #333; /* Dark text on hover */
    }

    .nav-pills .nav-link.active {
        background-color: #EB1616; /* Current red when active */
    }

    .nav-pills .nav-link:focus {
        outline: none; /* Remove the default outline on focus */
    }
</style>
<!-- Required Bootstrap 4 and jQuery for tabs -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
@endsection