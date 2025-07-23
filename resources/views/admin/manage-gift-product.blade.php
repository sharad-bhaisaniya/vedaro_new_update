@extends('layouts.admin_lay')
@section('title', 'Gift Products')
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
            <h1>Manage Gift Products</h1>
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
                            <th>Price</th>
                            <th>Size</th>
                            <th>Weight</th>
                            <th>Description 1</th>
                            <th>Description 2</th>
                            <th>Images</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->product_name }}</td>
                                <td>${{ $product->price }}</td>
                                <td>{{ $product->size }}</td>
                                <td>{{ $product->weight }}</td>
                                <td>{{ $product->product_description1 }}</td>
                                <td>{{ $product->product_description2 }}</td>
                                <td>
                                    @if($product->product_image1)
                                        <img src="{{ asset('public/storage/products/' . $product->product_image1) }}" alt="Image 1" width="50">
                                    @endif
                                    @if($product->product_image2)
                                        <img src="{{ asset('public/storage/products/' . $product->product_image2) }}" alt="Image 2" width="50">
                                    @endif
                                    @if($product->product_image3)
                                        <img src="{{ asset('public/storage/products/' . $product->product_image3) }}" alt="Image 3" width="50">
                                    @endif
                                </td>
                                <td>{{ $product->created_at }}</td>
                                <td>
                                    <a href="{{ route('admin.edit_product', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.delete_product', $product->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
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
