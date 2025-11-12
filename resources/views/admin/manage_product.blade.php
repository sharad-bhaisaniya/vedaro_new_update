@extends('layouts.admin_lay')
@section('title', 'Dashboard')
@section('content')

<style>
    .container {
        width: 100% !important;
        padding: 0 2rem;
    }
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .table {
        min-width: 1000px;
        border-radius: 30px;
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

    .variant-badge {
        background: #6c757d;
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        margin: 2px;
    }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<div class="container mt-3">
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

    <h2 class="mb-4">
          <i class="bi bi-box-seam-fill text-primary me-2"></i>Manage Products
    </h2>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>S.NO</th>
                    <th><i class="bi bi-box"></i> Name</th>
                    <th><i class="bi bi-currency-rupee"></i> Price</th>
                    <th><i class="bi bi-box-seam"></i> Stock</th>
                    {{-- <th><i class="bi bi-tag-fill"></i> Status</th> --}}
                    <th><i class="bi bi-grid"></i> Category</th>
                    <th><i class="bi bi-eye-fill"></i> View</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                @php
                    // Safely get variants data
                    $variantsCount = 0;
                    $firstVariant = null;
                    $allVariants = collect();
                    
                    if($product->product_type === 'variant') {
                        // Check if variants relation is loaded
                        if(isset($product->variants) && $product->variants !== null) {
                            $variantsCount = $product->variants->count();
                            $firstVariant = $product->variants->first();
                            $allVariants = $product->variants;
                        } else {
                            // If not loaded, get from database
                            $variants = $product->variants()->orderBy('id')->get();
                            $variantsCount = $variants->count();
                            $firstVariant = $variants->first();
                            $allVariants = $variants;
                        }
                    }
                @endphp
                <tr onclick="toggleDetails({{ $product->id }})">
                    <td>{{ $loop->iteration  }}</td>
                    <td>
                        {{ $product->productName }}
                        @if($product->product_type === 'variant')
                            <span class="badge bg-info ms-1">Variant</span>
                        @endif
                    </td>
                    <td>
                        @if($product->product_type === 'variant' && $firstVariant)
                            ₹{{ $firstVariant->discount_price ?? $firstVariant->price }}
                            @if($firstVariant->discount_price)
                                <small class="text-muted"><del>₹{{ $firstVariant->price }}</del></small>
                            @endif
                        @else
                            ₹{{ $product->discountPrice ?? $product->price }}
                            @if($product->discountPrice)
                                <small class="text-muted"><del>₹{{ $product->price }}</del></small>
                            @endif
                        @endif
                    </td>
                    <td style="text-align:center">
                        @if($product->product_type === 'variant' && $firstVariant)
                            {{ $firstVariant->stock }}
                        @else
                            {{ $product->current_stock }} 
                        @endif
                    </td>
                    {{-- <td>
                        <span class="badge bg-{{ $product->availability ? 'success' : 'danger' }}">
                          {{ $product->availability ? 'Available' : 'Unavailable' }}
                        </span>
                    </td> --}}
                 <td>
                    @php
                        $category = App\Models\Category::find($product->category);
                    @endphp
                    {{ $category->name ?? 'No Category' }}
                </td>
                    <td>
                        {{-- <button class="btn btn-sm btn-view" onclick="toggleDetails({{ $product->id }})">
                            <i class="bi bi-eye"></i>
                        </button> --}}
                    </td>
                </tr>
                <tr id="details-{{ $product->id }}" class="details-row">
                    <td colspan="7" style="padding-top: 0;">
                        <div class="details-card" id="card-{{ $product->id }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><span class="details-label">Product Type:</span> 
                                        <span class="badge bg-{{ $product->product_type === 'variant' ? 'info' : 'secondary' }}">
                                            {{ ucfirst($product->product_type) }}
                                        </span>
                                    </p>
                                    
                                    <p><span class="details-label">Description 1:</span> {{ $product->productDescription1 ?? 'N/A' }}</p>
                                    <p><span class="details-label">Description 2:</span> {{ $product->productDescription2 ?? 'N/A' }}</p>
                                    
                                    @if($product->product_type === 'variant')
                                        <!-- Variant Product Details -->
                                        <p><span class="details-label">Variants Count:</span> {{ $variantsCount }}</p>
                                        
                                        @if($firstVariant)
                                            <p><span class="details-label">First Variant Size:</span> 
                                                <span class="variant-badge">{{ $firstVariant->size ?? 'N/A' }}</span>
                                            </p>
                                            <p><span class="details-label">First Variant Weight:</span> 
                                                <span class="variant-badge">{{ $firstVariant->weight ?? 'N/A' }}</span>
                                            </p>
                                            <p><span class="details-label">First Variant Price:</span> 
                                                ₹{{ $firstVariant->price }}
                                                @if($firstVariant->discount_price)
                                                    <small class="text-success">(Discounted: ₹{{ $firstVariant->discount_price }})</small>
                                                @endif
                                            </p>
                                            <p><span class="details-label">First Variant Stock:</span> {{ $firstVariant->stock }}</p>
                                        @else
                                            <p class="text-muted">No variants available</p>
                                        @endif
                                        
                                        <!-- All Variants -->
                                        @if($variantsCount > 0)
                                            <p><span class="details-label">All Variants:</span></p>
                                            <div class="variants-list" style="max-height: 200px; overflow-y: auto;">
                                                @foreach($allVariants as $variant)
                                                    <div class="variant-item border p-2 mb-2 rounded">
                                                        <strong>Variant #{{ $loop->iteration }}</strong>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <small>Size: {{ $variant->size ?? 'N/A' }}</small><br>
                                                                <small>Weight: {{ $variant->weight ?? 'N/A' }}</small>
                                                            </div>
                                                            <div class="col-6">
                                                                <small>Price: ₹{{ $variant->price }}</small><br>
                                                                <small>Stock: {{ $variant->stock }}</small>
                                                            </div>
                                                        </div>
                                                        @if($variant->discount_price)
                                                            <small class="text-success">Discount: ₹{{ $variant->discount_price }}</small>
                                                        @endif
                                                        @if($variant->sku)
                                                            <small class="text-muted d-block">SKU: {{ $variant->sku }}</small>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @else
                                        <!-- Simple Product Details -->
                                        <p><span class="details-label">Price:</span> ₹{{ $product->price }}</p>
                                        @if($product->discountPrice)
                                            <p><span class="details-label">Discount Price:</span> ₹{{ $product->discountPrice }}</p>
                                        @endif
                                        <p><span class="details-label">Size:</span> 
                                            @if(empty($product->size))
                                                <span class="badge bg-secondary">Universal</span>
                                            @else
                                                <span class="badge bg-primary">{{ $product->multiple_sizes ?? $product->size }}</span>
                                            @endif
                                        </p>
                                        <p><span class="details-label">Weight:</span> 
                                            @if($product->multiple_weights)
                                                @if(is_string($product->multiple_weights))
                                                    @foreach(explode(',', $product->multiple_weights) as $weight)
                                                        <span class="badge bg-secondary me-1">{{ trim($weight) }}</span>
                                                    @endforeach
                                                @elseif(is_array($product->multiple_weights))
                                                    @foreach($product->multiple_weights as $weight)
                                                        <span class="badge bg-secondary me-1">{{ trim($weight) }}</span>
                                                    @endforeach
                                                @endif
                                            @else
                                                {{ $product->weight ?? 'N/A' }}
                                            @endif
                                        </p>
                                    @endif
                                    
                                    <p><span class="details-label">Coupon Code:</span> {{ $product->coupon_code ?? 'N/A' }}</p>
                                    <p><span class="details-label">Shipping Fee:</span> ₹{{ $product->shipping_fee ?? 'N/A' }}</p>
                                   
                                    <p><span class="details-label">Created:</span> 
                                        @if($product->created_at)
                                            {{ $product->created_at->format('d M Y, h:i A') }}
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><span class="details-label">Images:</span></p>
                                    <div class="d-flex flex-wrap">
                                        @if($product->image1)
                                            <img src="{{ asset('storage/products/' . $product->image1) }}" width="70" class="me-2 mb-2" />
                                        @endif
                                        @if($product->image2)
                                            <img src="{{ asset('storage/products/' . $product->image2) }}" width="70" class="me-2 mb-2" />
                                        @endif
                                        @if($product->image3)
                                            <img src="{{ asset('storage/products/' . $product->image3) }}" width="70" class="me-2 mb-2" />
                                        @endif
                                        @if(!$product->image1 && !$product->image2 && !$product->image3)
                                            <span class="text-muted">No images available</span>
                                        @endif
                                    </div>
                                    
                                    <!-- Additional Product Info -->
                                    <div class="mt-3">
                                        <p><span class="details-label">HSN Code:</span> {{ $product->hsn_code ?? 'N/A' }}</p>
                                        <p><span class="details-label">Brand:</span> {{ $product->brand ?? 'N/A' }}</p>
                                        <p><span class="details-label">Tax Rate:</span>
                                            @php
                        $taxGroup = App\Models\TaxGroup::find($product->tax_rate);
                    @endphp {{ $taxGroup->name ?? 'N/A' }}%</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
<!-- Pagination Section -->
@if($products->hasPages())
<div class="d-flex justify-content-between align-items-center mt-4">
    <div class="text-muted">
        Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results
    </div>
    <nav aria-label="Page navigation">
        <ul class="pagination mb-0">
            {{-- Previous Page Link --}}
            @if($products->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">&laquo; Previous</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $products->previousPageUrl() }}" rel="prev">&laquo; Previous</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach($products->links()->elements[0] as $page => $url)
                @if($page == $products->currentPage())
                    <li class="page-item active">
                        <span class="page-link">{{ $page }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if($products->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $products->nextPageUrl() }}" rel="next">Next &raquo;</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">Next &raquo;</span>
                </li>
            @endif
        </ul>
    </nav>
</div>
@endif
</div>
    </div>
</div>

<script>
    function toggleDetails(id) {
        const card = document.getElementById(`card-${id}`);
        card.classList.toggle('show');
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(Session::has('swal'))
<script>
    window.onload = function() {
        const swalData = @json(Session::get('swal'));
        Swal.fire({
            position: 'center',
            icon: swalData.icon,
            title: swalData.title,
            text: swalData.text,
            showConfirmButton: swalData.showConfirmButton ?? true,
            timer: swalData.timer ?? null,
            timerProgressBar: true,
        });
    };
</script>
@endif

@endsection