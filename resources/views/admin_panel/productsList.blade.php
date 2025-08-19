@extends('layout.admin_layout')


@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Products</h6>
            <div class="dropdown">
    <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        Filter
    </button>
    <ul class="dropdown-menu" aria-labelledby="filterDropdown">
        <li><a class="dropdown-item small {{ $category == 'mouse' ? 'active' : '' }}" href="?category=mouse">Mouse</a></li>
        <li><a class="dropdown-item small {{ $category == 'keyboard' ? 'active' : '' }}" href="?category=keyboard">Keyboard</a></li>
        <li><a class="dropdown-item small {{ $category == 'headset' ? 'active' : '' }}" href="?category=headset">Headset</a></li>
        <li><a class="dropdown-item small {{ $category == 'pc_case' ? 'active' : '' }}" href="?category=pc_case">PC Case</a></li>
        <li><a class="dropdown-item small" href="{{ route('products') }}">Clear Filter</a></li>
    </ul>
</div>
        </div>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-white">
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Price</th>
                        <th scope="col">Stock Quantity</th>
                        <th scope="col">Category</th>
                        <th scope="col">Details</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->stock_quantity }}</td>
                            <td>{{ $product->category }}</td>
                            <td>
                                <button 
                                    class="btn btn-sm btn-info" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#productDetailModal" 
                                    data-id="{{ $product->id }}">
                                    Detail
                                </button>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-warning" href="{{ route('product.edit', $product->id) }}">Edit</a>
                                <form action="{{ route('product.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end mt-3">
                {{ $products->appends(['category' => request()->query('category')])->links('pagination::bootstrap-4') }}
            </div>

        </div>
    </div>
</div>



<div class="modal fade" id="productDetailModal" tabindex="-1" aria-labelledby="productDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-secondary text-white">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="productDetailModalLabel">Product Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Loading Spinner -->
                <div class="text-center" id="loadingSpinner">
                    <div class="spinner-border text-light" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <!-- Modal Content -->
                <div id="modalContent" style="display:none;">
                    <!-- Product Name as Title -->
                    <div class="text-center mb-3">
                        <h2 id="productName" class="fw-bold"></h2>
                    </div>

                    <!-- Centered Image -->
                    <div class="text-center mb-4">
                        <img id="productImage" src="" alt="Product Image" class="img-fluid rounded shadow" style="max-width: 100%; margin-bottom: 20px;">
                    </div>

                    <!-- Product Data -->
                    <div class="row mb-3">
                        <!-- Description (Takes up full width) -->
                        <div class="col-12 mb-3">
                            <p class="text-center"><span id="productDescription"></span></p>
                        </div>
                        
                        <!-- Other Product Details (2 columns layout, centered) -->
                        <div class="col-md-6 d-flex justify-content-center text-center">
                            <p><strong>Price:</strong> ₱<span id="productPrice"></span></p>
                        </div>
                        <div class="col-md-6 d-flex justify-content-center text-center">
                            <p><strong>Stock Quantity:</strong> <span id="productStock"></span></p>
                        </div>
                        <div class="col-md-6 d-flex justify-content-center text-center">
                            <p><strong>Category:</strong> <span id="productCategory"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const productDetailModal = document.getElementById('productDetailModal');

    productDetailModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; 
        const productId = button.getAttribute('data-id'); 

        document.getElementById('loadingSpinner').style.display = 'block';
        document.getElementById('modalContent').style.display = 'none';

        fetch(`/products/${productId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('productName').textContent = data.name;
                document.getElementById('productDescription').textContent = data.description;
                document.getElementById('productPrice').textContent = data.price;
                document.getElementById('productStock').textContent = data.stock_quantity;
                document.getElementById('productCategory').textContent = data.category;

                const productImage = document.getElementById('productImage');
                if (data.image_path) {
                    productImage.src = `${data.image_path}`;
                    productImage.alt = `${data.name} Image`;
                } else {
                    productImage.src = 'https://via.placeholder.com/300?text=No+Image';
                    productImage.alt = 'No Image Available';
                }

                // Hide spinner and show content
                document.getElementById('loadingSpinner').style.display = 'none';
                document.getElementById('modalContent').style.display = 'block';
            })
            .catch(error => {
                console.error('Error fetching product details:', error);
                alert('Failed to load product details.');
            });
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