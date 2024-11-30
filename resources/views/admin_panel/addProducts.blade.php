@extends('layout.admin_layout')


@section('content')
                <div class="container-fluid pt-4 px-4">
                            <div class="bg-secondary rounded h-100 p-4">
                                <h6 class="mb-4">Add Product</h6>
                                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Name</label>
                                        <input type="text" name="name" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp">
                                        <div id="emailHelp" class="form-text">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="floatingTextarea">Description</label>
                                        <textarea class="form-control" name="description" placeholder="..."
                                            id="floatingTextarea" style="height: 150px;"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Category</label>
                                        <select name="category" class="form-select mb-3" aria-label="Default select example" id="category">
                                            <option selected>Open this select menu</option>
                                            <option value="keyboard">Keyboard</option>
                                            <option value="mouse">Mouse</option>
                                            <option value="headset">Headset</option>
                                            <option value="pc_case">PC Case</option>
                                        </select>
                                    </div>
                                    <div class="row g-7 mb-5">
                                        <div class="col-auto">
                                            <label for="price" class="form-label">Price</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">₱</span>
                                                    <input type="number" name="price" class="form-control" aria-label="Amount (to the nearest Peso)" id="price">
                                                </div>
                                        </div>
                                        <div class="col-auto">
                                            <label for="stock" class="form-label">Stock Quantity</label>
                                            <div class="input-group mb-3">
                                                <input type="number" name="stock_quantity" class="form-control" id="stock">
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <label for="formFile" class="form-label">Default file input example</label>
                                            <div class="input-group mb-3">
                                                <input class="form-control bg-dark" type="file" id="formFile" name="image_path">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div>
                <div>
<!-- TOAST -->
<div class="toast-container position-fixed bottom-0 right-0 p-3" style="z-index: 1050;">
    <div id="toastMessage" class="toast custom-toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000">
        <div class="toast-body">
            <!-- Success message dynamically injected here -->
            <strong>Success:</strong> Product added to cart!
            <button type="button" class="close ml-3" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
</div>

<!-- END TOAST -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            // Show the toast
            const toastElement = document.getElementById('toastMessage');
            const toast = new bootstrap.Toast(toastElement);
            toastElement.querySelector('.toast-body').textContent = "{{ session('success') }}";
            toast.show();
        @endif
    });
</script>
@endsection