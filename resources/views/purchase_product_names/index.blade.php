@extends('layouts.admin_lay')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Purchase Product Names</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('purchase-product-names.create') }}" class="btn btn-primary">+ Add Product Name</a>
    </div>

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Product Name</th>
                <th width="180">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->name }}</td>
                    <td>
                        <a href="{{ route('purchase-product-names.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('purchase-product-names.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this product name?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center text-muted">No product names found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
