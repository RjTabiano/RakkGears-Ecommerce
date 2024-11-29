@extends('layout.admin_layout')

@section('content')


<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Orders</h6>
            <div class="dropdown">
    <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        Filter
    </button>
        <ul class="dropdown-menu" aria-labelledby="filterDropdown">
            <li><a class="dropdown-item small {{ $status == 'pending' ? 'active' : '' }}" href="?status=pending">Pending</a></li>
            <li><a class="dropdown-item small {{ $status == 'processing' ? 'active' : '' }}" href="?status=processing">Processing</a></li>
            <li><a class="dropdown-item small {{ $status == 'completed' ? 'active' : '' }}" href="?status=completed">Completed</a></li>
            <li><a class="dropdown-item small {{ $status == 'cancelled' ? 'active' : '' }}" href="?status=cancelled">Cancelled</a></li>
            <li><a class="dropdown-item small" href="{{ route('orders') }}">Clear Filter</a></li>
        </ul>
        </div>
    </div>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-3">
                <thead>
                    <tr class="text-white">
                        <th scope="col">Order #</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Date</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Status</th>
                        <th scope="col">Details</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->user_id }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>₱{{ $order->total_price }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>
                            <button 
                                class="btn btn-sm btn-info" 
                                data-bs-toggle="modal" 
                                data-bs-target="#orderDetailModal" 
                                data-billing="{{ json_encode($order->billing_details) }}"
                                data-shipping="{{ json_encode($order->shipping_details) }}"
                                data-order="{{ $order->order_number }}">
                                Details
                            </button>
                        </td>
                        <td>
                            @if($order->status == 'pending')
                                <a class="btn btn-sm btn-success" href="{{ route('orders.confirm', $order->id) }}">Confirm</a>
                            @elseif($order->status == 'processing')
                                <a class="btn btn-sm btn-warning" href="{{ route('orders.cancel', $order->id) }}">Cancel</a>
                            @elseif($order->status == 'completed')
                                <a class="btn btn-sm btn-danger" href="{{ route('orders.refund', $order->id) }}">Refund</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
<div class="d-flex justify-content-end">
    {{ $orders->appends(['status' => request()->query('status')])->links('pagination::bootstrap-4') }}
</div>


        </div>
    </div>
</div>
<div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-secondary text-white">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="orderDetailModalLabel">Order Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <h3 class="fw-bold">Order #<span id="modalOrderNumber"></span></h3>
                </div>

                <div>
                    <h5>Billing Details</h5>
                    <ul id="modalBillingDetails">
                    </ul>
                </div>

                <div>
                    <h5>Shipping Details</h5>
                    <ul id="modalShippingDetails">
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const orderDetailModal = document.getElementById('orderDetailModal');

    orderDetailModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const orderNumber = button.getAttribute('data-order');
        const billingDetails = JSON.parse(button.getAttribute('data-billing'));
        const shippingDetails = button.getAttribute('data-shipping') ? JSON.parse(button.getAttribute('data-shipping')) : null;

        document.getElementById('modalOrderNumber').textContent = orderNumber;

        const billingList = document.getElementById('modalBillingDetails');
        billingList.innerHTML = '';
        for (const [key, value] of Object.entries(billingDetails)) {
            const li = document.createElement('li');
            li.textContent = `${key.replace('_', ' ').toUpperCase()}: ${value}`;
            billingList.appendChild(li);
        }

        const shippingList = document.getElementById('modalShippingDetails');
        shippingList.innerHTML = ''; 
        if (shippingDetails) {
            for (const [key, value] of Object.entries(shippingDetails)) {
                const li = document.createElement('li');
                li.textContent = `${key.replace('_', ' ').toUpperCase()}: ${value}`;
                shippingList.appendChild(li);
            }
        } else {
            shippingList.innerHTML = '<li>No shipping details provided.</li>';
        }
    });
});
</script>

<style>
/* Make pagination links transparent with minimalistic style */
.pagination {
    background-color: transparent !important;
    border: none;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    margin-top: 20px;
    padding: 0;
}

.pagination a,
.pagination .page-link {
    background-color: transparent !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    color: #fff !important;
    padding: 5px 10px;
    margin: 0 5px;
    text-decoration: none;
    border-radius: 5px;
    font-weight: 500;
}

.pagination .page-item.active .page-link {
    color: #EB1616 !important;
}

.pagination .page-item:hover .page-link,
.pagination .page-item:focus-within .page-link {
    background-color: rgba(255, 0, 0, 0.1) !important; /* Red hover */
    color: red !important;
    border-color: rgba(255, 0, 0, 0.2) !important;
}

.pagination .page-link:focus {
    box-shadow: none;
}

</style>


@endsection
@endsection