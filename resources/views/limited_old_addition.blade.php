@extends('layouts.main')

@section('title', 'Limited Edition')

@section('content')
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/assets/css/limited_additions.css') }}">
    
    <style>
      .banner {
          background-image: url("{{ asset('public/assets/images/limited_edition/limited_edition.jpg') }}") !important;
          background-size: cover;
          background-position: center;
          margin-top:2%;
        }
        
        @media (max-width: 768px) {
          .banner {
            background-image: url("{{ asset('public/assets/images/limited_edition/limited_edition_mobile.jpg') }}") !important;
            background-size: cover;
            background-position: center;
          }
        }
        
    </style>

    <section class="banner bg-cover bg-center h-96 flex items-center justify-center text-white text-center"></section>

    <section id="collection" class="mx-auto py-16">
        <h1 class="text-4xl font-bold text-center mb-12 text-gray-800 section-title">Our Exclusive Limited Editions</h1>

        <div class="grid-container">
            @forelse ($limitedEditionProducts as $product)
                <a href="{{ url('/product_details/' . urlencode($product->productName)) }}" class="limi-product-card 
                    @if($loop->first) grid-item-large
                    @elseif(in_array($loop->index, [3, 9, 10])) grid-item-medium-h 
                    @elseif(in_array($loop->index, [6, 12, 13])) grid-item-medium-v
                    @elseif($loop->index == 15) grid-item-large
                    @endif"> 
                    
                    <div class="product-image-container">
                        <img src="{{ asset('storage/products/' . $product->image1) }}" 
                             alt="{{ $product->productName }}" 
                             class="product-image">
                        <span class="product-badge">Limited Edition</span>
                    </div>
                    
                    <div class="product-content">
                        <h3 class="product-title">{{ $product->productName }}</h3>
                        <p class="product-description">{{ Str::limit($product->productDescription1, 120) }}</p>
                        
                        <div class="product-price">
                            @if($product->discountPrice)
                                <div>
                                    <span class="price-amount">₹{{ number_format($product->discountPrice, 2) }}</span>
                                    @if ($product->discountPercentage != 0)
                                    <span class="original-price">₹{{ number_format($product->price, 2) }}</span>
                                    @endif
                                </div>
                            @else
                                <span class="price-amount">₹{{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>
                        
                        {{-- Timer Container (initially visible for products with timer_end_at) --}}
                        <div class="timer-container" id="timer-{{ $product->id }}" 
                             data-end-time="{{ $product->timer_end_at ? \Carbon\Carbon::parse($product->timer_end_at)->timestamp : '' }}">
                            <div class="timer-part">
                                <span class="timer-value days">00</span>
                                <span class="timer-label">Days</span>
                            </div>
                            <div class="timer-part">
                                <span class="timer-value hours">00</span>
                                <span class="timer-label">Hrs</span>
                            </div>
                            <div class="timer-part">
                                <span class="timer-value minutes">00</span>
                                <span class="timer-label">Mins</span>
                            </div>
                            <div class="timer-part">
                                <span class="timer-value seconds">00</span>
                                <span class="timer-label">Secs</span>
                            </div>
                        </div>

                        {{-- "Available to Buy" message and Add to Cart button (initially hidden) --}}
        
                        
                        
                        {{-- ✅ If product is in stock --}}
                    @if($product->current_stock > 0)
                        {{-- Timer logic: show Buy Now or Add to Cart based on timer --}}
                        @if($product->add_timer && $product->timer_end_at)
                            {{-- Show Buy Now form after timer expires --}}
                            <form action="{{ route('checkout.single', $product->id) }}" method="GET" 
                                  id="available-message-{{ $product->id }}" 
                                  class="timer-expired-message hidden">
                                <button type="submit" class="btn btn-success w-100" style="padding: 0.75rem;">
                                    Buy Now
                                </button>
                            </form>
                       
                            {{-- Normal Add to Cart form --}}
                            <form id="purchaseButtons-{{ $product->id }}" class="w-100 hidden">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="product_qty" value="1">
                                <button type="submit" class="add-to-cart btn btn-primary w-100">
                                    Add to Cart
                                </button>
                            </form>
                             @else
                        @endif
                    
                    @else
                        {{-- ✅ If product is out of stock: show Prebook button --}}
                       <form action="{{ url('/product_details/' . urlencode($product->productName)) }}" method="GET">
                            <div class="d-flex flex-column gap-2">
                                <span class="badge bg-danger position-relative ps-4 py-2 rounded-end">
                                    Out Of Stock
                                    <span class="position-absolute start-0 top-0 bottom-0 w-3 opacity-25 bg-danger rounded-start"></span>
                                </span>
                                <button type="submit" class="btn btn-warning w-100">
                                    Prebook on WhatsApp
                                </button>
                            </div>
                        </form>
                    @endif
                    </div>
                </a>
            @empty
                <div class="empty-state">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold mb-2">No Limited Edition Items Available</h3>
                    <p class="text-gray-600">Check back soon for our exclusive limited edition collections.</p>
                </div>
            @endforelse
        </div>
    </section>
  

    <section id="why-choose-us" class="bg-gray-50 py-16 mt-12">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold text-gray-800 mb-12 section-title">Why Choose Elegance Gems?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-lg transform hover:scale-[1.02] transition duration-300 ease-in-out">
                    <div class="w-20 h-20 mx-auto mb-4 bg-purple-100 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L3 12l5.714-2.143L11 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-3">Unmatched Craftsmanship</h3>
                    <p class="text-gray-600">
                            Every Vedaro piece is carefully handcrafted by skilled artisans, reflecting precision, artistry, and timeless appeal.</p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-lg transform hover:scale-[1.02] transition duration-300 ease-in-out">
                    <div class="w-20 h-20 mx-auto mb-4 bg-orange-100 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.592 1L19 18H5l1.408-6.092A9.956 9.956 0 0112 8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-3">Ethically Sourced Silver</h3>
                    <p class="text-gray-600">We use responsibly sourced materials, ensuring our silver is both high-quality and conflict-free — beauty with integrity.
</p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-lg transform hover:scale-[1.02] transition duration-300 ease-in-out">
                    <div class="w-20 h-20 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.007 12.007 0 002.944 12c0 2.897.834 5.618 2.378 7.056L12 21.056l6.678-5.992A12.007 12.007 0 0021.056 12c0-2.897-.834-5.618-2.378-7.056z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-3">Distinctive Designs</h3>
                    <p class="text-gray-600">Our limited-edition collections feature unique, statement-worthy pieces — rooted in tradition, styled for the modern wearer.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="container mx-auto px-4 my-16">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-700 rounded-xl p-8 md:p-12 text-center text-white">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Don't Miss Your Chance!</h2>
            <p class="text-xl mb-6 max-w-2xl mx-auto">These exclusive pieces are available for a limited time only. Secure your unique treasure today.</p>
            <a href="#collection" class="inline-block bg-white text-purple-700 hover:bg-gray-100 px-8 py-3 rounded-full text-lg font-semibold shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                View Collection
            </a>
        </div>
    </section>

    <button id="backToTop" title="Go to top">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        // Back to top button
        window.onscroll = function() {
            if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
                document.getElementById("backToTop").style.display = "flex";
            } else {
                document.getElementById("backToTop").style.display = "none";
            }
        };

        document.getElementById("backToTop").addEventListener("click", function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Countdown timer function
        function updateCountdownTimers() {
            const now = new Date().getTime();
            
            document.querySelectorAll('.timer-container').forEach(timerContainer => {
                const productId = timerContainer.id.replace('timer-', '');
                const endTimeAttribute = timerContainer.dataset.endTime;
                const addToCartButton = document.getElementById(`purchaseButtons-${productId}`);
                const availableMessage = document.getElementById(`available-message-${productId}`);

                // If no end time is set, assume it's available for purchase immediately
                if (!endTimeAttribute || endTimeAttribute === '') {
                    timerContainer.style.display = 'none'; // Hide the timer
                    if (addToCartButton) addToCartButton.style.display = 'block'; // Show Add to Cart
                    if (availableMessage) availableMessage.classList.remove('hidden'); // Show Available message
                    return; 
                }

                const endTime = parseInt(endTimeAttribute) * 1000;
                const distance = endTime - now;
                
                if (distance < 0) {
                    // Timer has ended
                    timerContainer.style.display = 'none'; // Hide the timer
                    if (addToCartButton) addToCartButton.style.display = 'block'; // Show Add to Cart
                    if (availableMessage) availableMessage.classList.remove('hidden'); // Show Available message
                } else {
                    // Timer is running
                    timerContainer.style.display = 'grid'; // Show the timer grid
                    if (addToCartButton) addToCartButton.style.display = 'none'; // Hide Add to Cart
                    if (availableMessage) availableMessage.classList.add('hidden'); // Hide Available message

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
        
        // Initialize and update timers every second
        updateCountdownTimers();
        setInterval(updateCountdownTimers, 1000);
        
        // Add to cart functionality
       
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
        let formData = form.serialize();

        $.ajax({
            type: "POST",
            url: "{{ route('cart.add') }}", // Ensure this route accepts POST
            data: formData,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Added!',
                    text: response.message ?? 'Product added to cart.',
                    timer: 1500,
                    showConfirmButton: false
                });

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


    
    
@endsection