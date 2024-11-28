@extends('layout.admin_layout')


@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded h-100 p-4">
        <h6 class="mb-4">Edit Product</h6>
        <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ $product->name }}" required>
            </div>
            <div class="mb-3">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description" style="height: 150px;" required>{{ $product->description }}</textarea>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select name="category" class="form-select mb-3" id="category" required>
                    <option value="Keyboard" {{ $product->category == 'Keyboard' ? 'selected' : '' }}>Keyboard</option>
                    <option value="Mouse" {{ $product->category == 'Mouse' ? 'selected' : '' }}>Mouse</option>
                    <option value="Headset" {{ $product->category == 'Headset' ? 'selected' : '' }}>Headset</option>
                    <option value="PC Case" {{ $product->category == 'PC Case' ? 'selected' : '' }}>PC Case</option>
                </select>
            </div>
            <div class="row g-7 mb-5">
                <div class="col-auto">
                    <label for="price" class="form-label">Price</label>
                    <div class="input-group">
                        <span class="input-group-text">₱</span>
                        <input type="number" name="price" class="form-control" id="price" value="{{ $product->price }}" required>
                    </div>
                </div>
                <div class="col-auto">
                    <label for="stock_quantity" class="form-label">Stock Quantity</label>
                    <div class="input-group mb-3">
                        <input type="number" name="stock_quantity" class="form-control" id="stock_quantity" value="{{ $product->stock_quantity }}" required>
                    </div>
                </div>
                <div class="col-auto">
                    <label for="image_path" class="form-label">Product Image</label>
                    <input class="form-control bg-dark" type="file" id="image_path" name="image_path">
                    <small>Current Image: <a href="{{ asset('storage/' . $product->image_path) }}" target="_blank">View</a></small>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection