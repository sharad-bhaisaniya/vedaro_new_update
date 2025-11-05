@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background-color: #fefefe;
        color: #2c3b32;
        line-height: 1.6;
    }

    .container-fluid-shop {
        max-width: 1200px;
        margin: auto;
        padding: 15px;
    }

    @media (max-width: 768px) {
        .container-fluid-shop {
            padding: 10px;
        }
    }

    .breadcrumb-text {
        text-align: left;
        font-size: 12px;
        margin-bottom: 15px;
        color: #666;
    }

    @media (max-width: 480px) {
        .breadcrumb-text {
            font-size: 11px;
            margin-bottom: 10px;
        }
    }

    .collection-banner {
        margin-bottom: 20px;
    }

    .collection-banner .banner-img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-radius: 15px;
    }

    @media (max-width: 768px) {
        .collection-banner .banner-img {
            height: 180px;
            border-radius: 12px;
        }
    }

    @media (max-width: 480px) {
        .collection-banner .banner-img {
            height: 150px;
            border-radius: 10px;
        }
    }

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
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 20px;
    }

    .sort-btn:hover {
        background-color: #e9e4d6;
    }

    .sort-btn i {
        font-size: 10px;
    }

    @media (max-width: 480px) {
        .sort-btn {
            padding: 6px 12px;
            font-size: 13px;
            margin-bottom: 15px;
        }
    }

    .section-title {
        color:#2c3b32 ;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 20px;
        font-size: 24px;
    }

    @media (max-width: 768px) {
        .section-title {
            font-size: 20px;
            margin-bottom: 15px;
        }
    }

    @media (max-width: 480px) {
        .section-title {
            font-size: 18px;
            margin-bottom: 12px;
        }
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -8px;
    }

    @media (max-width: 480px) {
        .row {
            margin: 0 -5px;
        }
    }

    .col {
        flex: 0 0 50%;
        padding: 8px;
    }

    @media (min-width: 576px) {
        .col {
            flex: 0 0 50%;
        }
    }

    @media (min-width: 768px) {
        .col {
            flex: 0 0 33.333%;
        }
    }

    @media (min-width: 992px) {
        .col {
            flex: 0 0 25%;
        }
    }

    @media (max-width: 480px) {
        .col {
            padding: 5px;
        }
    }

    .card {
        background-color: transparent;
        border: none;
        width: 100%;
        cursor: pointer;
        transition: transform 0.3s ease;
        margin-bottom: 10px;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-img-wrapper {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
    }

    .card img {
        width: 100%;
        height: 230px;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
    }

    .card:hover img {
        transform: scale(1.05);
    }

    @media (max-width: 992px) {
        .card img {
            height: 200px;
        }
    }

    @media (max-width: 768px) {
        .card img {
            height: 180px;
        }
    }

    @media (max-width: 576px) {
        .card img {
            height: 160px;
        }
    }

    @media (max-width: 480px) {
        .card img {
            height: 140px;
        }
    }

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
        width: 32px;
        height: 32px;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .wishlist:hover {
        background: #d4e7c8;
        color: #d32f2f;
        transform: scale(1.1);
    }

    @media (max-width: 480px) {
        .wishlist {
            width: 28px;
            height: 28px;
            font-size: 12px;
            top: 8px;
            right: 8px;
        }
    }

    .card h3 {
        font-size: 16px;
        margin: 12px 0 6px;
        color: #2c3b32;
        font-weight: 500;
        line-height: 1.3;
        min-height: 40px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    @media (max-width: 768px) {
        .card h3 {
            font-size: 15px;
            min-height: 36px;
            margin: 10px 0 5px;
        }
    }

    @media (max-width: 480px) {
        .card h3 {
            font-size: 14px;
            min-height: 32px;
            margin: 8px 0 4px;
        }
    }

    .price-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 8px;
        flex-wrap: wrap;
        gap: 5px;
    }

    .price-wrapper {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }

    .price {
        font-weight: bold;
        color: #2c3b32;
        font-size: 16px;
    }

    .old-price {
        text-decoration: line-through;
        color: #999;
        font-size: 14px;
        margin-left: 8px;
    }

    @media (max-width: 480px) {
        .price {
            font-size: 14px;
        }
        
        .old-price {
            font-size: 12px;
            margin-left: 6px;
        }
    }

    .add-to-cart {
        background-color: #2c3b32;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
        min-width: 100px;
    }

    .add-to-cart:hover {
        background-color: #3a4d40;
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .add-to-cart {
            padding: 6px 10px;
            font-size: 13px;
            min-width: 90px;
        }
    }

    @media (max-width: 480px) {
        .add-to-cart {
            padding: 5px 8px;
            font-size: 12px;
            min-width: 80px;
        }
    }

    .text-muted {
        color: #999;
        text-align: center;
        width: 100%;
        padding: 20px;
        font-size: 16px;
    }

    @media (max-width: 480px) {
        .text-muted {
            font-size: 14px;
            padding: 15px;
        }
    }

    .timer-container {
        width: calc(100% - 16px);
        padding: 6px;
        grid-template-columns: repeat(4, 1fr);
        gap: 4px;
        text-align: center;
        display: grid;
        position: absolute;
        bottom: 8px;
        left: 8px;
        right: 8px;
        z-index: 9;
        backdrop-filter: blur(15px);
        background: rgba(255, 255, 255, 0.9);
        border-radius: 6px;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    @media (max-width: 480px) {
        .timer-container {
            padding: 4px;
            gap: 3px;
            bottom: 6px;
            left: 6px;
            right: 6px;
        }
    }

    .timer-part {
        display: flex;
        flex-direction: column;
        align-items: center;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 4px;
        padding: 3px;
    }

    @media (max-width: 480px) {
        .timer-part {
            padding: 2px;
        }
    }

    .timer-value {
        font-size: 12px;
        font-weight: 700;
        color: #6b46c1;
    }

    .timer-label {
        font-size: 9px;
        text-transform: uppercase;
        color: #b7791f;
        letter-spacing: 0.05em;
    }

    @media (max-width: 480px) {
        .timer-value {
            font-size: 10px;
        }
        
        .timer-label {
            font-size: 8px;
        }
    }

    /* Loading state */
    .loading {
        opacity: 0.7;
        pointer-events: none;
    }

    /* Success state for add to cart */
    .added-to-cart {
        background-color: #4caf50 !important;
    }

    /* Mobile menu adjustments */
    @media (max-width: 480px) {
        .container-fluid-shop {
            padding: 8px;
        }
        
        .row {
            margin: 0 -4px;
        }
        
        .col {
            padding: 4px;
        }
    }

    /* Extra small devices */
    @media (max-width: 360px) {
        .card h3 {
            font-size: 13px;
        }
        
        .price {
            font-size: 13px;
        }
        
        .add-to-cart {
            font-size: 11px;
            min-width: 70px;
            padding: 4px 6px;
        }
        
        .wishlist {
            width: 26px;
            height: 26px;
            font-size: 11px;
        }
    }
</style>
    
    <div class="container-fluid-shop">
        <div class="row">
            <div class="col-12">
                <h6 class="breadcrumb-text">
                    Home > Gifting
                </h6>
            </div>
        </div>

        <div class="collection-banner mb-4">
            <img src="https://images.unsplash.com/photo-1605100804763-247f67b3557e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80" 
                 alt="Shop All Banner" 
                 class="banner-img">
        </div>

   <div class="row">
    @forelse ($gifts as $gift)
        <div class="col">
            <div class="card h-100 position-relative">
                <a href="#" class="text-decoration-none">
                    <div class="card-img-wrapper">
                        <img src="{{ asset('storage/products/' . $gift->product_image1) }}" alt="{{ $gift->product_name }}" class="img-fluid rounded">
                    </div>

                    <h3 class="mt-3">{{ $gift->product_name }}</h3>
                       {{-- ✅ Show "Available Gift" badge only if active --}}
                @if($gift->is_active == 1)
                    <span class="badge bg-success position-absolute top-0 start-0 m-2 px-3 py-2 fs-12">
                        🎁 Available Gift
                    </span>
                @endif

                    <div class="price-container mb-2">
                        <div class="d-flex align-items-center">
                            <span class="price fw-semibold">₹{{ number_format($gift->price, 2) }}</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    @empty
        <div class="text-muted text-center py-5">No gifts available at the moment.</div>
    @endforelse
</div>


    </div>

    <script>
        // Countdown timer function
        function updateCountdownTimers() {
            const now = new Date().getTime();
            document.querySelectorAll('.timer-container').forEach(timerContainer => {
                const productId = timerContainer.id.replace('timer-', '');
                const endTimeAttribute = timerContainer.dataset.endTime;
                const addToCartButton = timerContainer.closest('.card').querySelector('.add-to-cart');

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

        // Initialize timers
        updateCountdownTimers();
        setInterval(updateCountdownTimers, 1000);

        // Wishlist functionality
        document.querySelectorAll('.wishlist').forEach(wishlist => {
            wishlist.addEventListener('click', function(e) {
                e.preventDefault();
                const icon = this.querySelector('i');
                
                if (icon.classList.contains('fa-regular')) {
                    icon.classList.remove('fa-regular');
                    icon.classList.add('fa-solid');
                    this.style.color = '#d32f2f';
                } else {
                    icon.classList.remove('fa-solid');
                    icon.classList.add('fa-regular');
                    this.style.color = '#444';
                }
            });
        });

        // Add to cart functionality
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const originalText = this.textContent;
                
                if (originalText === 'Add to cart') {
                    this.textContent = 'Added';
                    this.style.backgroundColor = '#4caf50';
                    
                    setTimeout(() => {
                        this.textContent = originalText;
                        this.style.backgroundColor = '#2c3b32';
                    }, 2000);
                }
            });
        });
    </script>
@endsection