@extends('layouts.admin_lay')
@section('title', 'Dashboard')
@section('content')

<style>
    .container {
        width: 100% !important;
    }
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .table {
        min-width: 1000px;
    }

    .details-card {
        display: none;
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        border-left: 5px solid #0d6efd;
        margin-top: 10px;
    }

    .details-card.show {
        display: block;
    }

    .details-label {
        font-weight: bold;
        color: #495057;
    }

    .action-icons i {
        font-size: 18px;
    }

    .btn-view {
        background-color: #0d6efd;
        color: white;
    }

    .btn-view:hover {
        background-color: #0b5ed7;
    }

</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<div class="container mt-3">
    <h2 class="mb-4">
          <i class="bi bi-box-seam-fill text-primary me-2"></i>Manage Products
    </h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th><i class="bi bi-box"></i> Name</th>
                    <th><i class="bi bi-currency-rupee"></i> Discount Price</th>
                    <th><i class="bi bi-box-seam"></i> Stock</th>
                    <th><i class="bi bi-tag-fill"></i> On Sell</th>
                    <th><i class="bi bi-grid"></i> Category</th>
                    <th><i class="bi bi-gear-fill"></i> Actions</th>
                    <th><i class="bi bi-eye-fill"></i> View</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->productName }}</td>
                    <td>₹{{ $product->discountPrice }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        <span class="badge bg-{{ $product->on_sell ? 'success' : 'secondary' }}">
                            {{ $product->on_sell ? 'Yes' : 'No' }}
                        </span>
                    </td>
                    <td>{{ $product->category }}</td>
                    <td class="action-icons">
                        <a href="{{ route('admin.edit_product', $product->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <form action="{{ route('admin.delete_product', $product->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-view" onclick="toggleDetails({{ $product->id }})">
                            <i class="bi bi-eye"></i>
                        </button>
                    </td>
                </tr>
            <tr id="details-{{ $product->id }}" class="details-row">
    <td colspan="8">
        <div class="details-card" id="card-{{ $product->id }}">
            <div class="row">
                <div class="col-md-6">
                    <p><span class="details-label">Description 1:</span> {{ $product->productDescription1 }}</p>
                    <p><span class="details-label">Description 2:</span> {{ $product->productDescription2 }}</p>
                    <p><span class="details-label">Price:</span> ₹{{ $product->price }}</p>
                    <p><span class="details-label">Coupon Code:</span> {{ $product->coupon_code }}</p>
                    <p><span class="details-label">Shipping Fee:</span> ₹{{ $product->shipping_fee }}</p>
                    <p><span class="details-label">Availability:</span> {{ $product->availability ? 'Available' : 'Unavailable' }}</p>
                    <p><span class="details-label">Created:</span> {{ $product->created_at }}</p>
                    <p><span class="details-label">Size:</span> {{ $product->size ?? 'N/A' }}</p>
                    <p><span class="details-label">Weight:</span> 
                        @if($product->multiple_weights)
                            @foreach(explode(',', $product->multiple_weights) as $weight)
                                <span class="badge bg-secondary me-1">{{ trim($weight) }}</span>
                            @endforeach
                        @else
                            {{ $product->weight ?? 'N/A' }}
                        @endif
                    </p>
                </div>
                <div class="col-md-6">
                    <p><span class="details-label">Images:</span></p>
                    @if($product->image1)
                        <img src="{{ asset('public/storage/products/' . $product->image1) }}" width="70" class="me-2 mb-2" />
                    @endif
                    @if($product->image2)
                        <img src="{{ asset('public/storage/products/' . $product->image2) }}" width="70" class="me-2 mb-2" />
                    @endif
                    @if($product->image3)
                        <img src="{{ asset('public/storage/products/' . $product->image3) }}" width="70" class="me-2 mb-2" />
                    @endif
                </div>
            </div>
        </div>
    </td>
</tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function toggleDetails(id) {
        const card = document.getElementById(`card-${id}`);
        card.classList.toggle('show');
    }
</script>

@endsection
