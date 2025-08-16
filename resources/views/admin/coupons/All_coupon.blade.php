@extends('layouts.admin_lay')
@section('title', 'All Coupons')

@section('content')
<div class="container mt-5">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

    <h4 class="mb-4">View Coupons by Type</h4>

    {{-- Selector Dropdown --}}
    <div class="mb-4">
        <label for="couponTypeSelector" class="form-label">Select Coupon Type:</label>
        <select id="couponTypeSelector" class="form-select w-50">
            <option value="all">Show All</option>
            <option value="universal">Universal Coupons</option>
            <option value="category">Category-Based Coupons</option>
            <option value="product">Product-Based Coupons</option>
        </select>
    </div>

    <div class="row g-4">

        {{-- Universal Coupons --}}
        <div class="col-md-12 coupon-section" id="universalSection">
            <div class="card border-success shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Universal Coupons</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered text-center">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Coupon Code</th>
                                <th>Discount (%)</th>
                                <th>Validity</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($universalCoupons as $index => $coupon)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $coupon->code }}</td>
                                    <td>{{ $coupon->discount_percentage }}%</td>
                                <td>
    {{ optional($coupon->valid_from)->format('m/d/Y g:i A') ?? 'N/A' }} -
    {{ optional($coupon->valid_to)->format('m/d/Y g:i A') ?? 'N/A' }}
</td>
                                    <td>
                                        <a href="{{ route('coupon.edit',$coupon->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('coupon.delete',$coupon->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5">No universal coupons found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Category Coupons --}}
        <div class="col-md-12 coupon-section" id="categorySection">
            <div class="card border-primary shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Category-Based Coupons</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered text-center">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Coupon Code</th>
                                <th>Discount (%)</th>
                                <th>Category</th>
                                <th>Validity</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categoryCoupons as $index => $coupon)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $coupon->code }}</td>
                                    <td>{{ $coupon->discount_percentage }}%</td>
                                    <td>{{ $coupon->category?->name ?? '-' }}</td>
                                                      <td>
    {{ optional($coupon->valid_from)->format('m/d/Y g:i A') ?? 'N/A' }} -
    {{ optional($coupon->valid_to)->format('m/d/Y g:i A') ?? 'N/A' }}
</td>
                                    <td>
                                        <a href="{{ route('coupon.edit',$coupon->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('coupon.delete',$coupon->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6">No category-based coupons found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Product Coupons --}}
        <div class="col-md-12 coupon-section" id="productSection">
            <div class="card border-info shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Product-Based Coupons</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered text-center">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Coupon Code</th>
                                <th>Discount (%)</th>
                                <th>Products</th>
                                <th>Validity</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productCoupons as $index => $coupon)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $coupon->code }}</td>
                                    <td>{{ $coupon->discount_percentage }}%</td>
                                    <td>
                                        @if(is_array($coupon->product_ids))
                                            <ul class="list-unstyled mb-0" style="max-height: 113px;
                                             overflow-y: scroll;">
                                                @foreach($coupon->product_ids as $pid)
                                                    <li><small>{{ \App\Models\Product::find($pid)?->productName ?? 'Deleted' }}</small></li>
                                                @endforeach
                                            </ul>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                            {{ optional($coupon->valid_from)->format('m/d/Y g:i A') ?? 'N/A' }} -
                                            {{ optional($coupon->valid_to)->format('m/d/Y g:i A') ?? 'N/A' }}
                                        </td>
                                    <td>
                                        <a href="{{ route('coupon.edit',$coupon->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('coupon.delete',$coupon->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6">No product-based coupons found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- JavaScript to toggle sections --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selector = document.getElementById('couponTypeSelector');
        const universal = document.getElementById('universalSection');
        const category = document.getElementById('categorySection');
        const product = document.getElementById('productSection');

        selector.addEventListener('change', function () {
            const val = selector.value;
            universal.style.display = (val === 'all' || val === 'universal') ? 'block' : 'none';
            category.style.display = (val === 'all' || val === 'category') ? 'block' : 'none';
            product.style.display = (val === 'all' || val === 'product') ? 'block' : 'none';
        });

        selector.dispatchEvent(new Event('change')); // trigger on load
    });
</script>
@endsection
