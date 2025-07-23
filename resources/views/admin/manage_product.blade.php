@extends('layouts.admin_lay')
@section('title', 'Dashboard')
@section('content')

<style>
    .container {
        width: 100% !important;
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch; /* Smooth scrolling for touch devices */
    }
    .table {
        min-width: 1800px; /* Adjust to match your table's content */
    }

</style>

<div class="container mt-1">
    <div class="row justify-content-end">
        <div class="col-lg-12 col-md-10 col-sm-12">
            <h1>Manage Products</h1>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Description 1</th>
                            <th>Description 2</th>
                            <th>Price</th>
                            <th>Discount Price</th>
                            <th>Stock</th>
                            <th>Availability</th>
                            <th>On Sell</th>
                            <th>Category</th>
                            <th>Images</th>
                            <th>Coupon Code</th>
                            <th>Shipping Fee</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->productName }}</td>
                                <td>{{ $product->productDescription1 }}</td>
                                <td>{{ $product->productDescription2 }}</td>
                                <td>${{ $product->price }}</td>
                                <td>${{ $product->discountPrice }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ $product->availability ? 'Available' : 'Unavailable' }}</td>
                                <td>{{ $product->on_sell ? 'Yes' : 'No' }}</td>
                                <td>{{ $product->category }}</td>
                                <td>
                                    <img src="{{ asset('public/storage/products/' . $product->image1) }}" alt="Image 1" width="50">
                                    @if($product->image2)
                                        <img src="{{ asset('public/storage/products/' . $product->image2) }}" alt="Image 2" width="50">
                                    @endif
                                    @if($product->image3)
                                        <img src="{{ asset('public/storage/products/' . $product->image3) }}" alt="Image 3" width="50">
                                    @endif
                                </td>
                                <td>{{ $product->coupon_code }}</td>
                                <td>{{ $product->shipping_fee }}</td>
                                <td>{{ $product->created_at }}</td>
                                <td>
                                    <a href="{{ route('admin.edit_product', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.delete_product', $product->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE') <!-- Ensure this method is included -->
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
