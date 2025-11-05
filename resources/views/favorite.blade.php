@extends('layouts.main')

@section('content')


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('/assets/css/ourCollectionHome.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/limitedEdition.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz,wght@0,6..12,400..900;1,6..12,400..900&display=swap" rel="stylesheet">

<style>
/* #0f2a1d -dark ...... #f2ecdd - light */

.container-fluid-shop {
  max-width: 1200px;
  margin: auto;
  padding: 20px;
}

/* Breadcrumb */
.breadcrumb-text {
  text-align: left;
  font-size: 12px;
  margin-bottom: 15px;
  color: #666;
}

/* Banner */
.collection-banner .banner-img {
  width: 100%;
  height: 220px;
  object-fit: cover;
  border-radius: 20px;
}

/* Sort button */
.sort-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 8px 14px;
  background-color: #f4efe1;
  border: 1px solid #2c3b32;
  border-radius: 8px; 
  color: #2c3b32; 
  font-size: 14px;
  font-family: "MyCustomFont", sans-serif;
  cursor: pointer;
  transition: all 0.3s ease;
}
.sort-btn i { font-size: 10px; }
.sort-btn:hover { background-color: #e9e4d6; }

/* Section Title */
.section-title {
  color: ##0f2a1d;
  font-weight: bold;
  text-transform: uppercase;
  margin: 20px 0;
}

/* Cards */
.card {
  background-color: transparent;
  border: none;
  width: 100%;
  cursor: pointer;
}
.card img {
  width: 100%;
  border-radius: 10px;
  object-fit: cover;
  display: block;
}
.card h3 {
  font-size: 16px;
  margin: 10px 0 5px;
  color: #2c3b32;
  font-weight: 500;
}

/* Wishlist icon */
.wishlist {
  position: absolute;
  top: 10px;
  right: 10px;
  background: #e3efd39c;
  border-radius: 50%;
  padding: 8px;
  font-size: 14px;
  color: #444;
  cursor: pointer;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
  width: 30px;
  height: 30px;
  display: flex;
  justify-content: center;
  align-items: center;
}
.card-img-wrapper {
  position: relative;
}

/* Timer */
.timer-container {
  width: 100%;
  padding: 0.5rem;
  grid-template-columns: repeat(4, 1fr);
  gap: 0.5rem;
  text-align: center;
  display: grid;
  position: absolute;
  bottom: 8px;
  z-index: 9;
  border: none !important;
  backdrop-filter: blur(20px);
}
.timer-part {
  display: flex;
  flex-direction: column;
  align-items: center;
  background: #ffffffad;
}
.timer-value {
  font-size: 1rem;
  font-weight: 700;
  color: #6b46c1;
}
.timer-label {
  font-size: 0.65rem;
  text-transform: uppercase;
  color: #b7791f;
  letter-spacing: 0.05em;
}

.favorite-grid {
  display: grid;
  gap: 1.5rem; /* spacing between items */
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
}

.btn-favorite{
    width: 100%;
    margin:10px 0 ;
}


/* Overlay background */
.sort-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.3);
  backdrop-filter: blur(5px);
  z-index: 99;
  display: none; /* hidden by default */
}

/* Popup container */
.sort-popup {
  position: absolute;
  top: 300px;  /* adjust to your navbar height */
  left: 100px;
  background: #f2ecdd;
  border-radius: 10px;
  padding: 10px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.2);
  width: 200px;
  animation: fadeIn 0.3s ease;
}

.sort-popup h6 {
  margin: 0 0 10px;
  font-size: 14px;
  font-weight: bold;
  color: #0f2a1d;
}

.sort-popup ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.sort-popup ul li {
  padding: 8px 10px;
  border-radius: 6px;
  cursor: pointer;
  transition: background 0.2s ease;
}

.sort-popup ul li:hover {
  background: #f2ecdd;
}

.sort-popup .close-btn {
  position: absolute;
  top: -24px;
  right: 10px;
  font-size: 24px;
  cursor: pointer;
  color: #0f2a1d;
  font-weight:bold;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0); }
}



.add-to-cart {
    padding: 6px 12px;
    border: 2px solid #2c3b32;
    border-radius: 8px;
    background: transparent;
    color: #2c3b32;
    font-size: 13px;
    cursor: pointer;
    transition: 0.3s ease;
    width: 100%;
    font-family: Arial;
    font-weight: 600;
}
.favorite-grid{
     font-family: arial;
}

/* Existing styles */
.card-img-wrapper {
    position: relative; /* This is crucial for positioning the delete icon */
}

/* Style for the close/delete icon */
.delete-from-wishlist {
    position: absolute;
    top: 10px;        /* Distance from the top */
    left: 10px;       /* Distance from the left */
    background: #e3efd39c; /* A semi-transparent background */
    border-radius: 50%;
    padding: 8px;
    font-size: 14px;
    color: #444;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    width: 30px;
    height: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 10;      /* Ensure it's on top of other elements */
}

/* Style for the heart icon on the right side */
.wishlist {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #e3efd39c;
    border-radius: 50%;
    padding: 8px;
    font-size: 14px;
    color: #444;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    width: 30px;
    height: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 10;
}



/* Force exactly 6 columns on large screens */
@media (min-width: 1200px) {
  .favorite-grid {
    grid-template-columns: repeat(6, 1fr);
  }
}

/* On mobile: ensure at least 2 columns */
@media (max-width: 576px) {
  .favorite-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}


/* Responsive adjustments */
@media (max-width: 768px) {
  .card img { height: 180px; }
  .card h3 { font-size: 14px; }
}
</style>
<style>
    
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* Section Title */
.section-title {
    font-family: 'Poppins', sans-serif;
    font-size: 25px;
    font-weight: 600;
    margin-bottom: 30px;
    text-align: left;
    color: #2c3b32;
}

/* Limited Edition Banner */
.limited-edition-banner {
    position: relative;
    width: 100%;
    height: 350px; /* Adjust height as needed */
    border-radius: 20px;
    overflow: hidden;
    margin-bottom: 40px;
}

.banner-bg-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    /* You can apply a filter here if you want a blur effect */
    /* filter: blur(3px); */
}

.banner-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to right, rgba(44, 59, 50, 0.7) 30%, rgba(44, 59, 50, 0) 70%); /* Gradient overlay */
    display: flex;
    align-items: center;
    padding: 20px;
    box-sizing: border-box;
}

.banner-content {
    max-width: 400px; /* Limit content width */
    color: #fff; /* White text for contrast */
    text-align: left;
    padding-left: 30px;
}

.banner-heading {
    font-family: 'Playfair Display', serif;
    font-size: 38px;
    font-weight: 700;
    margin-top: 0;
    margin-bottom: 15px;
    line-height: 1.2;
}

.banner-description {
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    font-weight: 300;
    line-height: 1.5;
    margin-bottom: 0;
}

/* Product Grid */
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); /* Responsive grid columns */
    gap: 20px;
    margin-top: 30px;
}

.product-card {
    background-color: #fcf8ee; /* Slightly lighter background for cards */
    border-radius: 10px;
    padding: 15px;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* Pushes button to bottom */
}

.limited-edition-tag {
    position: absolute;
    top: 10px;
    left: 10px;
    background-color: #ff0000; /* Red tag */
    color: #fff;
    font-size: 10px;
    padding: 4px 8px;
    border-radius: 5px;
    z-index: 5;
    text-transform: uppercase;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.wishlist-icon {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: rgba(255, 255, 255, 0.8);
    border-radius: 50%;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    color: #b08d57; /* Gold/brown heart icon color */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    z-index: 5;
}

.product-img-wrapper {
    width: 100%;
    height: 150px; /* Fixed height for product images */
    margin-bottom: 15px;
    border-radius: 8px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Ensures images fill the space without distortion */
    display: block;
}

.product-name {
    font-family: 'Playfair Display', serif;
    font-size: 18px;
    font-weight: 500;
    color: #2c3b32;
    margin: 10px 0 5px;
}

.product-prices {
    display: flex;
    justify-content: center;
    align-items: baseline;
    margin-bottom: 15px;
}

.current-price {
    font-family: 'Poppins', sans-serif;
    font-size: 18px;
    font-weight: 600;
    color: #2c3b32;
    margin-right: 8px;
}

.old-price {
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    color: #888;
    text-decoration: line-through;
    font-weight: 400;
}

.add-to-cart-btn {
    background-color: transparent;
    border: 1px solid #b08d57; /* Gold/brown border */
    color: #b08d57;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s ease;
    width: 100%; /* Make button full width */
}

.add-to-cart-btn:hover {
    background-color: #b08d57;
    color: #fff;
}

/* Responsive Adjustments */
@media (max-width: 992px) {
    .section-title {
        font-size: 28px;
    }
    .limited-edition-banner {
        height: 300px;
    }
    .banner-heading {
        font-size: 32px;
    }
    .banner-description {
        font-size: 15px;
    }
    .product-grid {
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    }
    .product-name {
        font-size: 16px;
    }
    .current-price {
        font-size: 16px;
    }
    .old-price {
        font-size: 13px;
    }
}

@media (max-width: 768px) {
    .section-title {
        font-size: 24px;
        text-align: center;
    }
    .limited-edition-banner {
        height: 250px;
        margin-left: 0;
        margin-right: 0;
    }
    .banner-overlay {
        background: rgba(44, 59, 50, 0.7); /* Solid overlay for smaller screens */
        justify-content: center;
        text-align: center;
    }
    .banner-content {
        max-width: 90%;
        padding-left: 0;
    }
    .banner-heading {
        font-size: 28px;
    }
    .banner-description {
        font-size: 14px;
    }
    .product-grid {
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    }
    .product-card {
        padding: 10px;
    }
    .product-img-wrapper {
        height: 120px;
    }
}

@media (max-width: 480px) {
    .container {
        padding: 10px;
    }
    .section-title {
        font-size: 22px;
        margin-bottom: 20px;
    }
    .limited-edition-banner {
        height: 200px;
    }
    .banner-heading {
        font-size: 24px;
    }
    .banner-description {
        font-size: 13px;
    }
    .product-grid {
        grid-template-columns: 1fr 1fr; /* 2 columns on extra small screens */
        gap: 15px;
    }
    .product-card {
        padding: 8px;
    }
    .wishlist-icon, .limited-edition-tag {
        font-size: 9px;
        padding: 3px 6px;
        width: 25px;
        height: 25px;
    }
    .product-name {
        font-size: 15px;
    }
    .current-price {
        font-size: 15px;
    }
    .old-price {
        font-size: 12px;
    }
    .add-to-cart-btn {
        font-size: 13px;
        padding: 8px 10px;
    }
}
</style>

    <section>
        <div class="container-fluid-shop">
            <!-- Breadcrumb -->
            <div class="row">
                <div class="col-12">
                    <h6 class="breadcrumb-text">
                        Home > favorite
                    </h6>
                </div>
            </div>

         
            <!-- Sort Button -->
            <div class="mb-3 text-start">
                <button class="sort-btn">
                    <div>Sort by</div>
                    <i class="fa-solid fa-sort"></i>
                </button>
            </div>

            <!-- Title -->
            <div class="row">
                <div class="col-12">
                    <h4 class="section-title">
                       My Favourite Items
                    </h4>
                </div>
            </div>

            <!-- favorite Grid -->
             <!-- favorite Grid -->
        <div class="favorite-grid">
    @forelse($wishlistItems as $wishlistItem)
        @php
            $product = $wishlistItem->product;
            $variant = null;

            // Default prices
            $displayPrice = $product->discountPrice ?? $product->price ?? 0;
            $oldPrice = $product->price ?? null;

            // ✅ If product type is 'variant', find the first available variant
            if ($product && $product->product_type === 'variant') {
                $variant = App\Models\ProductVariant::where('product_id', $product->id)->first();

                if ($variant) {
                    $displayPrice = $variant->discount_price ?? $variant->price ?? 0;
                    $oldPrice = $variant->price ?? null;
                }
            }

            // ✅ Image handling (prefer variant image)
            $image = $variant && $variant->image
                ? $variant->image
                : ($product->image1 ?? 'default.jpg');

            // ✅ Stock check (variant stock if applicable)
            $inStock = $variant
                ? ($variant->stock_quantity ?? 0) > 0
                : ($product->current_stock ?? 0) > 0;
        @endphp

        <div class="col">
            <div class="card h-100">
                <div class="card-img-wrapper position-relative">
                    <img 
                        src="{{ asset('storage/products/' . $image) }}" 
                        alt="{{ $product->productName }}" 
                        class="img-fluid rounded-top"
                    >

                    <!-- Remove from Wishlist Icons -->
                    <span class="delete-from-wishlist" data-id="{{ $product->id }}">
                        <i class="fa-solid fa-xmark"></i>
                    </span>

                    <span class="wishlist remove-from-wishlist" data-id="{{ $product->id }}">
                        <i class="fa-solid fa-heart" style="color: #ff0000;"></i>
                    </span>
                </div>

                <!-- Product Name -->
                <h3 class="mt-2 text-truncate">{{ $product->productName }}</h3>

                <!-- Price Section -->
                <div class="d-flex align-items-center gap-2">
                    <span class="price fw-bold">₹{{ number_format($displayPrice, 2) }}</span>
                    @if($oldPrice && $oldPrice > $displayPrice)
                        <span class="old-price text-muted text-decoration-line-through">
                            ₹{{ number_format($oldPrice, 2) }}
                        </span>
                    @endif
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-between align-items-center w-100 mt-2">
                    @if($inStock)
                        <form id="purchaseButtons-{{ $product->id }}" class="w-100">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="product_qty" value="1">
                            <button type="submit" class="add-to-cart w-100 btn-favorite">
                                Add to cart
                            </button>
                        </form>
                    @else
                        <form action="{{ url('/product_details/' . urlencode($product->productName)) }}" method="GET" class="w-100">
                            <button type="submit" class="add-to-cart w-100 btn-outline-secondary">
                                Prebook on WhatsApp
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <p class="text-center w-100 mt-4">Your wishlist is empty. Start adding some items!</p>
    @endforelse
</div>

            
    </section>
    
      @php
    $products = App\Models\Product::where('add_timer', 1)
            ->inRandomOrder()
            ->take(6)
            ->get();

@endphp

    
        <section class="limited-edition-section">
<div class="container">
    <h2 class="section-title">Limited Edition</h2>

    <div class="limited-edition-banner">
        <img src="{{ asset('assets/images/favourite/favourite_limited_banner.jpeg') }}" 
             alt="Limited Edition Banner" 
             class="banner-bg-img">
    </div>

    <div class="favorite-grid">
        @forelse($products as $product)
            @php
                $variant = null;

                // Default prices
                $displayPrice = $product->discountPrice ?? $product->price ?? 0;
                $oldPrice = $product->price ?? null;

                // ✅ If product is variant type
                if ($product->product_type === 'variant') {
                    $variant = App\Models\ProductVariant::where('product_id', $product->id)->first();

                    if ($variant) {
                        $displayPrice = $variant->discount_price ?? $variant->price ?? 0;
                        $oldPrice = $variant->price ?? null;
                    }
                }

                // ✅ Image handling (variant image > product image)
                $image = $variant && $variant->image
                    ? $variant->image
                    : ($product->image1 ?? 'default.jpg');

                // ✅ Stock check
                $inStock = $variant
                    ? ($variant->stock_quantity ?? 0) > 0
                    : ($product->current_stock ?? 0) > 0;
            @endphp

            <div class="col">
                <div class="card h-100">
                    <div class="card-img-wrapper position-relative">
                        <img 
                            src="{{ asset('storage/products/' . $image) }}" 
                            alt="{{ $product->productName }}" 
                            class="img-fluid rounded-top"
                        >

                        {{-- ❤️ Wishlist Button --}}
                        <form class="wishlist-form position-absolute top-0 end-0 m-2">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="bg-transparent border-0">
                                <span class="wishlist"><i class="fa-regular fa-heart"></i></span>
                            </button>
                        </form>
                    </div>

                    {{-- Product Name --}}
                    <h3 class="mt-2 text-truncate">{{ $product->productName }}</h3>

                    {{-- Prices --}}
                    <div class="d-flex align-items-center gap-2">
                        <span class="price fw-bold">₹{{ number_format($displayPrice, 2) }}</span>
                        @if($oldPrice && $oldPrice > $displayPrice)
                            <span class="old-price text-muted text-decoration-line-through">
                                ₹{{ number_format($oldPrice, 2) }}
                            </span>
                        @endif
                    </div>

                    {{-- Add to Cart or Prebook --}}
                    <div class="d-flex justify-content-between align-items-center w-100 mt-2">
                        @if($inStock)
                            <form id="purchaseButtons-{{ $product->id }}" class="w-100">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="product_qty" value="1">
                                <button type="submit" class="add-to-cart w-100 btn-favorite">
                                    Add to cart
                                </button>
                            </form>
                        @else
                            <form action="{{ url('/product_details/' . urlencode($product->productName)) }}" method="GET" class="w-100">
                                <button type="submit" class="add-to-cart w-100 btn-outline-secondary">
                                    Prebook on WhatsApp
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center w-100 mt-4">No limited edition products available right now.</p>
        @endforelse
    </div>
</div>
    </section>
            <!-- Sort Popup -->
        <div class="sort-overlay" id="sortOverlay">
        <div class="sort-popup">
            <span class="close-btn" onclick="closeSortPopup()">&times;</span>
            <h6>Sort by</h6>
            <ul>
            <li>New Arrival</li>
            <li>Price: Low to High</li>
            <li>Price: High to Low</li>
            <li>Most Popular</li>
            </ul>
        </div>
        </div>


<script>
    function updateCountdownTimers() {
    const now = new Date().getTime();
    document.querySelectorAll('.timer-container').forEach(timerContainer => {
        const productId = timerContainer.id.replace('timer-', '');
        const endTimeAttribute = timerContainer.dataset.endTime;
        const addToCartButton = document.getElementById(`add-to-cart btn-favorite-${productId}`);

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

            const days = Math.floor(distance / (1000*60*60*24));
            const hours = Math.floor((distance % (1000*60*60*24)) / (1000*60*60));
            const minutes = Math.floor((distance % (1000*60*60)) / (1000*60));
            const seconds = Math.floor((distance % (1000*60)) / 1000);

            timerContainer.querySelector('.days').textContent = String(days).padStart(2,'0');
            timerContainer.querySelector('.hours').textContent = String(hours).padStart(2,'0');
            timerContainer.querySelector('.minutes').textContent = String(minutes).padStart(2,'0');
            timerContainer.querySelector('.seconds').textContent = String(seconds).padStart(2,'0');
        }
    });
}
updateCountdownTimers();
setInterval(updateCountdownTimers, 1000);
</script>

<script>
  const sortOverlay = document.getElementById('sortOverlay');
  const sortBtn = document.querySelector('.sort-btn');

  sortBtn.addEventListener('click', () => {
    sortOverlay.style.display = 'block';
  });

  function closeSortPopup() {
    sortOverlay.style.display = 'none';
  }

  // Close overlay if clicked outside popup
  sortOverlay.addEventListener('click', (e) => {
    if (e.target === sortOverlay) {
      closeSortPopup();
    }
  });
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

<!--remove the wishlist item script -->
<script>
    // Set up CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Handle the click event on the delete icon
    $(document).on('click', '.delete-from-wishlist', function(e) {
        e.preventDefault();

        let productId = $(this).data('id');
        let card = $(this).closest('.col');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/favorite/' + productId,
                    type: 'DELETE',
                    success: function(response) {
                        // Use SweetAlert for success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Removed!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        
                        // Remove the item's card from the page
                        card.fadeOut(500, function() {
                            $(this).remove();
                            // Check if the wishlist is now empty
                            if ($('.favorite-grid .col').length === 0) {
                                $('.favorite-grid').append('<p>Your wishlist is empty. Start adding some items!</p>');
                            }
                        });
                    },
                    error: function(xhr) {
                        let message = 'Something went wrong!';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: message
                        });
                    }
                });
            }
        });
    });
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
