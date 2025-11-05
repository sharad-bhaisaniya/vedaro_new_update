@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="{{ asset('/assets/css/ourCollectionHome.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/css/limitedEdition.css') }}">

<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Product",
  "name": "Elegant Gold Ring",
  "image": [
    "https://www.vedaro.com/images/products/gold-ring.jpg"
  ],
  "description": "Handcrafted elegant gold ring from Vedaro with timeless design.",
  "sku": "RING-001",
  "brand": {
    "@type": "Brand",
    "name": "Vedaro"
  },
  "offers": {
    "@type": "Offer",
    "url": "https://www.vedaro.com/rings/elegant-gold-ring",
    "priceCurrency": "INR",
    "price": "4999",
    "availability": "https://schema.org/InStock",
    "itemCondition": "https://schema.org/NewCondition"
  }
}
</script>

<div class="container-fluid-shop">
    <div class="row">
        <div class="col-12">
            <h6 class="breadcrumb-text">
                Home > Product
            </h6>
        </div>
    </div>

   <div class="collection-banner mb-4">
    @php
        $currentCategory = null;
        if(!empty($currentCategoryName)) {
            $currentCategory = App\Models\Category::where('name', $currentCategoryName)->first();
        }
    @endphp

    @if($currentCategory && $currentCategory->banner_image)
        {{-- Dynamic category banner --}}
        <img src="{{ asset('storage/products/'.$currentCategory->banner_image) }}" 
             alt="{{ $currentCategory->name }} Banner" 
             class="banner-img">
    @else
        {{-- Static fallback banner for "Shop All" --}}
        <img src="{{ asset('assets/images/default-shop-banner.png') }}" 
             alt="Shop All Banner" 
             class="banner-img">
    @endif
</div>


    <div class="mb-3 text-start">
        <button class="sort-btn">
            <div>Sort by</div>
            <i class="fa-solid fa-sort"></i>
        </button>
    </div>

    <div class="row">
        <div class="col-12">
            <h4 class="section-title">
                @if(request('category'))
                    {{ $currentCategoryName ?? 'Selected Category' }} Products
                @endif
            </h4>
        </div>
    </div>

  
    
    <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
    @forelse($products as $product)
        @php
            // Get variants if product type is "variant"
            $variants = $product->product_type == 'variant'
                ? App\Models\ProductVariant::where('product_id', $product->id)->get()
                : collect();

            $firstVariant = $variants->first();
        @endphp

        <div class="col">
            <div class="card h-100">
                <a href="{{ route('product.details', $product->productName) }}" class="text-decoration-none">
                    <div class="card-img-wrapper">
                        <img src="{{ asset('storage/products/' . $product->image1) }}" alt="{{ $product->productName }}">

                        {{-- Wishlist --}}
                        <form class="wishlist-form">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="wishlist p-3">
                                <span><i class="fa-regular fa-heart"></i></span>
                            </button>
                        </form>
                    </div>

                    {{-- Product Name + Stock Info --}}
                    <div class="d-flex align-items-center justify-content-between">
                        <h3>{{ $product->productName ?? 'Product' }}</h3>
                        @if($product->current_stock <= 0)
                            <small class="text-danger d-block">
                                <i class="fas fa-exclamation-circle me-1"></i> Out of Stock
                            </small>
                        @endif
                    </div>

                    {{-- Price Section --}}
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            @if($product->product_type == 'variant' && $firstVariant)
                                {{-- Show variant price --}}
                                <span class="price">₹{{ number_format($firstVariant->discount_price ?? 0, 2) }}/-</span>
                                @if($firstVariant->price > $firstVariant->discount_price)
                                    <span class="old-price">₹{{ number_format($firstVariant->price, 2) }}</span>
                                @endif
                            @else
                                {{-- Normal product price --}}
                                <span class="price">₹{{ number_format($product->discountPrice ?? $product->price ?? 0, 2) }}/-</span>
                                @if(!empty($product->price) && !empty($product->discountPercentage) && $product->discountPercentage != 0)
                                    <span class="old-price">₹{{ number_format($product->price, 2) }}</span>
                                @elseif(!empty($product->old_price))
                                    <span class="old-price">₹{{ number_format($product->old_price, 2) }}</span>
                                @endif
                            @endif
                        </div>

                        {{-- Buttons Section --}}
                        @if($product->current_stock > 0)
                            <form id="purchaseButtons-{{ $product->id }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="product_qty" value="1">
                                <button type="submit" class="add-to-cart">Add to cart</button>
                            </form>
                        @else
                            <form action="{{ url('/product_details/' . urlencode($product->productName)) }}" method="GET">
                                <button type="submit" class="add-to-cart">
                                    Prebook on WhatsApp
                                </button>
                            </form>
                        @endif
                    </div>
                </a>
            </div>
        </div>
    @empty
        <div class="col-12">
            <p class="text-muted">No products found in this category.</p>
        </div>
    @endforelse
</div>

</div>

<style>
.container-fluid-shop { max-width: 1200px; margin: auto; padding: 20px; }
.breadcrumb-text { text-align: left; font-size: 12px; margin-bottom: 15px; color: #666; }
.collection-banner .banner-img { width: 100%; height: 220px; object-fit: cover; border-radius: 20px; }
.sort-btn { display: inline-flex; align-items: center; gap: 8px; padding: 8px 14px; background-color: #f4efe1; border: 1px solid #2c3b32; border-radius: 8px; color: #2c3b32; font-size: 14px; font-family: "MyCustomFont", sans-serif; cursor: pointer; transition: all 0.3s ease; }
.sort-btn i { font-size: 10px; }
.sort-btn:hover { background-color: #e9e4d6; }
.section-title { color: #b08d57; font-weight: bold; text-transform: uppercase; margin-bottom: 20px; }
.card { background-color: transparent; border: none; width: 100%; cursor: pointer; }
.card img { width: 100%; height: 230px; border-radius: 10px; object-fit: cover; display: block; }
.card h3 { font-size: 16px; margin: 10px 0 5px; color: #2c3b32; font-weight: 500; }
.wishlist { position: absolute; top: 10px; right: 10px; background: #e3efd39c; border-radius: 50%; padding: 8px; font-size: 14px; color: #444; cursor: pointer; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2); width: 30px; height: 30px; display: flex; justify-content: center; align-items: center; }
.card-img-wrapper { position: relative; }
.timer-container { width: 100%; padding: 0.5rem; grid-template-columns: repeat(4, 1fr); gap: 0.5rem; text-align: center; display: grid; position: absolute; bottom: 8px; z-index: 9; border: none !important; backdrop-filter: blur(20px); }
.timer-part { display: flex; flex-direction: column; align-items: center; background: #ffffffad; }
.timer-value { font-size: 1rem; font-weight: 700; color: #6b46c1; }
.timer-label { font-size: 0.65rem; text-transform: uppercase; color: #b7791f; letter-spacing: 0.05em; }
@media (max-width: 768px) { .card img { height: 180px; } .card h3 { font-size: 14px; } }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Countdown timer function
function updateCountdownTimers() {
    const now = new Date().getTime();
    document.querySelectorAll('.timer-container').forEach(timerContainer => {
        const productId = timerContainer.id.replace('timer-', '');
        const endTimeAttribute = timerContainer.dataset.endTime;
        const addToCartButton = document.getElementById(`add-to-cart-${productId}`);

        if (!endTimeAttribute) {
            timerContainer.style.display = 'none';
            if (addToCartButton) addToCartButton.style.display = 'flex';
            return;
        }

        const endTime = parseInt(endTimeAttribute) * 1000;
        const distance = endTime - now;

        if (distance < 0) {
            timerContainer.style.display = 'none';
            if (addToCartButton) addToCartButton.style.display = 'flex';
        } else {
            timerContainer.style.display = 'grid';
            if (addToCartButton) addToCartButton.style.display = 'none';

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            timerContainer.querySelector('.days').textContent = String(days).padStart(2, '0');
            timerContainer.querySelector('.hours').textContent = String(hours).padStart(2, '0');
            timerContainer.querySelector('.minutes').textContent = String(minutes).padStart(2, '0');
            timerContainer.querySelector('.seconds').textContent = String(seconds).padStart(2, '0');
        }
    });
}
updateCountdownTimers();
setInterval(updateCountdownTimers, 1000);
</script>

<script>
    // 🛡️ CSRF token setup for all AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // 🛒 Handle Add to Cart on all forms starting with purchaseButtons-
   
$(document).on('submit', 'form[id^="purchaseButtons-"]', function(e) {
    e.preventDefault();

    let form = $(this);
    let button = form.find('.add-to-cart'); // Target the button inside the form
    let formData = form.serialize();

    $.ajax({
        type: "POST",
        url: "{{ route('cart.add') }}",
        data: formData,
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Added!',
                text: response.message ?? 'Product added to cart.',
                timer: 1500,
                showConfirmButton: false
            });

            // Change the button text and make it a bit more visually distinct
            button.text('Added');
            button.addClass('btn-success').removeClass('btn-primary').prop('disabled', true);

            // 🔄 Update cart count if shown on page
            updateCartCount();
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: xhr.responseJSON?.message ?? 'Something went wrong!',
            });
        }
    });
});

    // 🔁 Update the cart count
    function updateCartCount() {
        $.ajax({
            url: "{{ route('cart.count') }}",
            type: "GET",
            success: function(data) {
                $('#cart-count').text(data.count); // Update cart icon/count
            }
        });
    }
</script>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Set up CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Handle AJAX submission for all wishlist forms
    $(document).on('submit', 'form.wishlist-form', function(e) {
        e.preventDefault(); // Prevent the default form submission

        let form = $(this);
        let formData = form.serialize();

        $.ajax({
            type: "POST",
            url: "{{ route('wishlist.store') }}", // Use the correct route
            data: formData,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    showConfirmButton: false,
                    timer: 2000
                });
            },
            error: function(xhr) {
                // Handle different HTTP status codes
                let message = 'Something went wrong!';
                if (xhr.status === 409) {
                    message = 'Product is already in your wishlist.';
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                Swal.fire({
                    icon: 'info',
                    title: 'Heads Up!',
                    text: message,
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        });
    });
</script>
@endsection