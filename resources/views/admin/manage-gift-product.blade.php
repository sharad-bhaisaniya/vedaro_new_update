@extends('layouts.admin_lay')
@section('title', 'Gift Products')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/admin/gift.css') }}">

<style>

</style>

<div class="container mt-3">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center"><i class="fas fa-tasks"></i> Manage Gift Products</h1>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="50">ID</th>
                            <th>Product Name</th>
                            <th width="100">Price</th>
                            <th width="120">Size</th>
                            <th width="100">Weight</th>
                            <th width="150">Status</th>
                            <th width="150">Valid From</th>
                            <th width="150">Valid To</th>
                            <th width="120">Min. Amount</th>
                            <th width="150">Images</th>
                            <th width="150" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ Str::limit($product->product_name, 30) }}</td>
                            <td>₹{{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->size }}</td>
                            <td>{{ $product->weight }}</td>
                            <td>
                                <form action="{{ route('admin.toggle_gift_status', $product->id) }}" method="POST" class="status-toggle-form">
                                    @csrf
                                    @if($product->is_active)
                                        <span class="badge bg-success">Active</span>
                                        <input type="hidden" name="is_active" value="0">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Deactivate</button>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                        <input type="hidden" name="is_active" value="1">
                                        <button type="submit" class="btn btn-sm btn-outline-success">Activate</button>
                                    @endif
                                </form>
                            </td>
                            <td>{{ $product->valid_from ? $product->valid_from->format('d M Y H:i') : 'N/A' }}</td>
                            <td>{{ $product->valid_to ? $product->valid_to->format('d M Y H:i') : 'N/A' }}</td>
                            <td>₹{{ number_format($product->minimum_cart_amount, 2) }}</td>
                            <td>
                                <div class="d-flex">
                                    @if($product->product_image1)
                                        <img src="{{ asset('storage/products/' . $product->product_image1) }}" class="img-thumbnail" alt="Image 1">
                                    @endif
                                    @if($product->product_image2)
                                        <img src="{{ asset('storage/products/' . $product->product_image2) }}" class="img-thumbnail" alt="Image 2">
                                    @endif
                                    @if($product->product_image3)
                                        <img src="{{ asset('storage/products/' . $product->product_image3) }}" class="img-thumbnail" alt="Image 3">
                                    @endif
                                </div>
                            </td>
                            <td class="action-buttons text-end">
                                <a href="{{ route('admin.edit_product', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.delete_product', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle active toggle forms
        const toggleForms = document.querySelectorAll('form[action*="toggle_gift_status"]');

        toggleForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const isActivating = this.querySelector('input[name="is_active"]').value === '1';
                const message = isActivating
                    ? 'Activating this gift will deactivate all others. Continue?'
                    : 'Are you sure you want to deactivate this gift?';

                if (confirm(message)) {
                    // Show loading state
                    const button = this.querySelector('button');
                    const originalText = button.textContent;
                    button.disabled = true;
                    button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

                    fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams(new FormData(this))
                    })
                    .then(response => {
                        if (response.ok) {
                            window.location.reload();
                        } else {
                            alert('Error updating status');
                            button.disabled = false;
                            button.textContent = originalText;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        button.disabled = false;
                        button.textContent = originalText;
                    });
                }
            });
        });
    });
</script>

@endsection
