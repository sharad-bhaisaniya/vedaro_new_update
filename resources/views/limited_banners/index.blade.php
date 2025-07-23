@extends('layouts.admin_lay')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4">Limited Edition Banners</h1>
        <a href="{{ route('limited-banners.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Banner
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="dis_fl">
        <!-- Banners Section -->
        <div class="current-banners card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Current Banners</h5>
            </div>
            <div class="card-body">
                <div class="banner-grid">
                    @forelse ($banners as $banner)
                        <div class="banner-card dropzone border" data-id="{{ $banner->id }}"
                             ondrop="onDrop(event)" ondragover="allowDrop(event)">
                            <div class="banner-image-wrapper">
                                <img src="{{ asset('public/storage/products/' . $banner->image) }}" alt="{{ $banner->title }}" class="banner-img img-fluid">
                                <div class="banner-overlay mt-2">
                                    <h5 class="banner-title">{{ $banner->title }}</h5>
                                </div>
                            </div>

                            <!-- Assigned Products -->
                            @if($banner->product_ids)
                                @php
                                    $bannerProductIds = explode(',', $banner->product_ids);
                                    $assignedProducts = $allProducts->whereIn('id', $bannerProductIds);
                                @endphp
                          
                          <div class="position-absolute" style="top: 10px; right: 10px; display: flex;width: 100%;justify-content: flex-end;align-items: center;gap: 5px; flex-wrap: wrap;">
                                @foreach($assignedProducts as $assigned)
                                    <div class="card p-1" style="display:flex; flex-direction: row; gap: 5px;">
                                        <img src="{{ asset('public/storage/products/' . $assigned->image1) }}" class="img-fluid"  style="width: 45px; height: 40px;"  alt="{{ $assigned->productName }}">
                                        <small class="text-center d-block mt-2">{{ $assigned->productName }}</small>
                                
                                        <!-- Remove Button -->
                                        <button class="btn btn-sm btn-danger position-absolute top-0 end-0" style="padding: 0px 3px; font-size: 9px;"
                                                onclick="removeProductFromBanner('{{ $banner->id }}', '{{ $assigned->id }}')">
                                            &times;
                                        </button>
                                    </div>
                                @endforeach
                        </div>
                                
                            @endif

                            <!-- Actions -->
                            <div class="banner-actions ">
                                <a href="{{ route('limited-banners.show', $banner->id) }}" class="btn btn-sm btn-outline-info me-1" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('limited-banners.edit', $banner->id) }}" class="btn btn-sm btn-outline-warning me-1" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('limited-banners.destroy', $banner->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this banner?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">No banners found.</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <div class="products-card card ">
            <div class="card-header bg-white">
                <h5 class="mb-0">Featured Products</h5>
            </div>
            <div class="card-body">
                <div class="products-grid flex-wrap">
                    @forelse($unassignedProducts as $product)
                        <div class="product-card border p-2" draggable="true"
                             data-id="{{ $product->id }}" ondragstart="onDrag(event)">
                            <div class="product-image-wrapper">
                                <img src="{{ asset('public/storage/products/' . $product->image1) }}" alt="{{ $product->name ?? 'Product' }}" class="img-fluid" style="width:90px; height:70px">
                            </div>
                            <div class="product-info text-right">
                                <h6 class="product-title">{{ $product->productName }}</h6>
                                <div class="product-price">
                                    @if(isset($product->old_price) && $product->old_price > $product->price)
                                        <span class="text-muted text-decoration-line-through">${{ number_format($product->old_price, 2) }}</span>
                                        <span class="text-success">${{ number_format($product->price, 2) }}</span>
                                    @else
                                        ${{ number_format($product->price ?? 0, 2) }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info w-100">No products available.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Drag and Drop Script -->
<script>
    let draggedProductId = null;

    function onDrag(event) {
        draggedProductId = event.target.dataset.id;
    }

    function allowDrop(event) {
        event.preventDefault();
    }

    function onDrop(event) {
        event.preventDefault();
        const bannerId = event.currentTarget.dataset.id;

        if (!draggedProductId || !bannerId) return;

        fetch(`/limited-banners/${bannerId}/assign-product`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ product_id: draggedProductId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.reload(); // Refresh to reflect updated assignments
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(err => console.error('Error:', err));
    }
    
    
    
function removeProductFromBanner(bannerId, productId) {
    if (!confirm('Remove this product from the banner?')) return;

    fetch(`/limited-banners/${bannerId}/remove-product`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            window.location.reload(); // Refresh to reflect changes
        } else {
            alert('❌ Error: ' + data.message);
        }
    })
    .catch(err => console.error('Error:', err));
}

</script>
@endsection





<style>
.current-banners{
    width: 70%;
}
.products-card {
    width: 29%;
}
.dis_fl{
    display: flex;
    justify-content: space-between;
}
.card-body{
    padding: 10px !important;
}
    /* Banner Grid Styles */
    .banner-grid {
        display: flex;
        gap: 10px;
            flex-direction: column;
    }

    .banner-card {
        border-radius: 5px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: white;
        position: relative;
    }

    .banner-card:hover {
        /*transform: translateY(-5px);*/
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .banner-image-wrapper {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .banner-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .banner-card:hover .banner-img {
        transform: scale(1.05);
    }

    .banner-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
        padding: 15px;
        color: white;
    }

    .banner-title {
        font-size: 1.1rem;
        margin: 0;
        color: #fff !important;
        font-weight: 600;
    }

    .banner-actions {
        padding: 12px;
        display: flex;
        gap: 8px;
        background: #f8f9fa;
        border-top: 1px solid #eee;
    }

    /* Products Grid Styles */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 10px;
    }

    .product-card {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        background: white;
            display: flex;
            justify-content: space-between;
    align-items: center;
    }

    .product-card:hover {
        /*transform: translateY(-5px);*/
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .product-image-wrapper {
        position: relative;
        height: 70px;
        overflow: hidden;
        width: 90px;
    }

    .product-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #ff4757;
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: bold;
    }

    .product-info {
        padding: 15px;
        text-align: right;
    }

    .product-title {
        font-size: 13px;
        margin: 0 0 5px 0;
        font-weight: 600;
        color: #333;
    }

    .product-desc {
        font-size: 0.85rem;
        color: #666;
        margin: 0 0 10px 0;
    }

    .product-price {
        font-weight: bold;
        color: #2f3542;
        font-size: 12px;
    }

    .original-price {
        text-decoration: line-through;
        color: #999;
        margin-right: 8px;
        font-size: 0.9rem;
    }

    .discounted-price {
        color: #ff4757;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .banner-grid, .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        }
    }

    @media (max-width: 576px) {
        .banner-grid, .products-grid {
            grid-template-columns: 1fr;
        }
    }
</style>