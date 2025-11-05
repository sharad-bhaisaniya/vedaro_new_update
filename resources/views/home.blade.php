@extends('layouts.main')

@section('title', 'Vedaro – Elegant Jewelry Online | Shop Timeless Designs')
@section('meta_description', 'Shop handcrafted jewelry online at Vedaro. Discover elegant rings, necklaces, earrings & timeless designs crafted with premium materials and care.')

<!-- Slick Carousel CSS -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
<link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-...your-integrity..." crossorigin="anonymous" referrerpolicy="no-referrer" />
		<!--<link rel="stylesheet" href="{{ asset('/assets/css/header.css') }}">-->
		<!--<link rel="stylesheet" href="{{ asset('/assets/css/ourCollectionHome.css') }}">-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
		<!--<link rel="stylesheet" href="{{ asset('/assets/css/slider.css') }}">-->
		<!--<link rel="stylesheet" href="{{ asset('/assets/css/suggestion.css') }}">-->
		<!--<link rel="stylesheet" href="{{ asset('/assets/css/categoryHome.css') }}">-->
		<!--<link rel="stylesheet" href="{{ asset('/assets/css/aboutHome.css') }}">-->
		<!--<link rel="stylesheet" href="{{ asset('/assets/css/featureSection.css') }}">-->
		<!--<link rel="stylesheet" href="{{ asset('/assets/css/videoHome.css') }}">-->
		<!--<link rel="stylesheet" href="{{ asset('/assets/css/divinity.css') }}">-->
		<!--<link rel="stylesheet" href="{{ asset('/assets/css/limitedAdditionHome.css') }}">-->
		
		<link rel="stylesheet" href="{{ asset('/assets/css/combined.css') }}">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">


@section('content')

<!-- SweetAlert2 CDN -->
@if(session('success'))
<div class="success-message">
   {{ session('success') }}
</div>
@endif
@if(!Auth::check())
<div class="success_msgs_home">
   <h1>Welcome, Guest!</h1>
   <p>Please <a href="{{ route('login') }}">log in</a> to access your account.</p>
   @endif
   <button class="close-btn">X</button>
</div>
@php
$activeBanner = $banners->where('is_active', true)->first();
@endphp
@if($activeBanner)



<div class="orderWhatsApp" onclick="openWhatsApp()">
  <div class="wIcon"><i class="fa-brands fa-whatsapp"></i></div>
  <div class="wText">Order with WhatsApp</div>
</div>

<script>
function openWhatsApp() {
  // Your WhatsApp number (with country code, no spaces or + sign)
  const phoneNumber = "919005008004"; // change this to your business number

  // Prefilled message (URL encoded)
  const message = encodeURIComponent(
    "Hello, I have visited Vedaro website and I want to shop a product."
  );

  // WhatsApp API URL
  const url = `https://wa.me/${phoneNumber}?text=${message}`;

  // Open in new tab
  window.open(url, "_blank");
}
</script>


   
   
   @endif
   




 <div class="w-full flex flex-col items-center">
        <div class="carousel-container">
            <div class="carousel-track">
                <!-- These are your 7 images. The script will handle cloning for the infinite loop. -->
                <div class="carousel-slide">
                    <img src="{{asset('assets/images/home/main2/Banner_1.webp')}}" alt="Showcase Image 1">
                </div>
                <div class="carousel-slide">
                    <img src="{{asset('assets/images/home/main2/Banner_2.webp')}}" alt="Showcase Image 2">
                </div>
                <div class="carousel-slide">
                    <img src="{{asset('assets/images/home/main2/Banner_3.webp')}}" alt="Showcase Image 3">
                </div>
                <div class="carousel-slide">
                    <img src="{{asset('assets/images/home/main2/Banner_4.webp')}}" alt="Showcase Image 4">
                </div>
                <div class="carousel-slide">
                    <img src="{{asset('assets/images/home/main2/Banner_5.webp')}}" alt="Showcase Image 5">
                </div>
                <div class="carousel-slide">
                    <img src="{{asset('assets/images/home/main2/Banner_6.webp')}}" alt="Showcase Image 6">
                </div>
                <div class="carousel-slide">
                    <img src="{{asset('assets/images/home/main2/Banner_7.webp')}}" alt="Showcase Image 7">
                </div>
            </div>
        </div>
        <div class="pagination-dots mt-8">
            <!-- Dots will be generated here by JavaScript -->
        </div>
    </div>



      <section class="collection-section">
         <div class="collection-header">
               <h2>Our Collection</h2>
               <p>Take a look at our new Collections</p>
         </div>

         <div class="collection-banner">
            <img src="{{ asset('assets/images/home/Our_Collection_Banner_Large.webp') }}" 
     alt="Collection Banner">

         </div>

         <div class="collection-grid">
               <div class="collection-item">
                  <img src="{{ asset('assets/images/home/Ring_Image_Large.webp') }}" alt="Product 1">
               </div>
               <div class="collection-item">
                  <img src="{{ asset('assets/images/home/Pendent_Image_Large.webp') }}" alt="Product 2">
               </div>
               <div class="collection-item">
                  <img src="{{ asset('assets/images/home/Earing_Image_Large.webp') }}" alt="Product 3">
               </div>
         </div>
      </section>




                  <section class="category-section">
                     <div class="category-header">
                        <h2>Find your Perfect Match</h2>
                        <p>Shop by your choice</p>
                     </div>

                     <div class="category-grid">
                        @php
                           $activeCategories = $categories->where('active', true);
                        @endphp

                        @foreach($activeCategories as $category)
                        <a href="{{ route('product.show', ['id' => $category->id]) }}" 
                        class="category-card" 
                        style="text-decoration:none; color:inherit;">
                        <img src="{{ $category->image 
                           ? asset('storage/products/' . $category->image) 
                           : 'https://via.placeholder.com/600x800?text=No+Image' }}" 
                           alt="{{ $category->name }}">
                        <h3>{{ $category->name }}</h3>
                     </a>

                        @endforeach
                     </div>
                  </section>


                  <section class="limited-edition">
                    <div class="limited-edition-box">
                      <h2 class="section-title">Limited Edition</h2>
                      <p class="section-subtitle">Shop our exclusive limited edition Jewels.</p>
                           <a href="/limited_edition">
                    
                      <div class="edition-grid">
                        <!-- Left big image with overlay -->
                        <div class="edition-main">
                    
                              <img src="{{asset('assets/images/home/limited/Limited_Edition_section_Banner_Large.webp')}}" alt="Limited Edition Jewelry" />
                          <div class="overlay">
                            <!--<button>Shop Now</button>-->
                          </div>
                           
                        </div>
                    
                        <!-- Right two stacked images -->
                            
                        <div class="edition-side">
                          <img src="{{asset('assets/images/home/limited/DSC_0759_Large.webp')}}" alt="Jewelry 1" />
                          <img src="{{asset('assets/images/home/limited/EDF_ (19)_Large.webp')}}" alt="Jewelry 2" />
                        </div>
                         
                      </div>
                     </a>
                             </div>
                    </section>

    <section class="suggestions-section">
      <h2 class="header-title-suggestion">Suggestions for You</h2>
    
      <!-- Top row -->
        @php
            // Find the category by name
            $category = \App\Models\Category::where('name', 'mangalsutra')->first();
            // Fetch products of this category
            $categoryProducts = \App\Models\Product::where('category', $category->id)->get();
        @endphp
        @if($categoryProducts->count() >= 5)
        <div class="row-container">
            <div class="arrow left disabled">&#8249;</div>
            <div class="slider-wrapper">
                <div class="slider-track">
                    @foreach($categoryProducts as $product)
                         <a href="{{ route('product.details',$product->productName) }}" class="redirect-details">
                        <div class="product-card">
                            <img src="{{ asset('storage/products/' . $product->image1) }}" alt="{{ $product->productName }}">
                            <p>{{ $product->productName }}</p>
                            <p class="price">₹{{ $product->discountPrice }}</p>
    
                            {{-- Show old price if discounted --}}
                            @if($product->discountPercentage != 0)
                                <p class="old-price"><s>₹{{ $product->price }}</s></p>
                            @endif
    
                            {{-- Show colors --}}
                            @if($product->colors)
                                <div class="color-list">
                                    @foreach($product->colors as $color)
                                        <span class="color-dot" style="background-color: {{ $color }}"></span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="arrow right">&#8250;</div>
        </div>
        @endif
    
    
            <!-- Bottom row -->
            @php
                // Find the category by name
                $category = \App\Models\Category::where('name', 'pendants')->first();
                // Fetch products of this category
                $categoryProducts = \App\Models\Product::where('category', $category->id)->get();
            @endphp
    
          @if($categoryProducts->count() >= 5)
          <div class="row-container">
              <div class="arrow left disabled">&#8249;</div>
              <div class="slider-wrapper">
                <div class="slider-track">
                  @foreach($categoryProducts as $product)
                  <a href="{{ route('product.details',$product->productName) }}"  class="redirect-details">
                          <div class="product-card">
                              <img src="{{ asset('storage/products/' . $product->image1) }}" alt="{{ $product->productName }}">
                              <p>{{ $product->productName }}</p>
                              <p class="price">₹{{ $product->discountPrice }}</p>
                              {{-- Show old price if discounted --}}
                              @if($product->discountPercentage != 0)
                                  <p class="old-price"><s>₹{{ $product->price }}</s></p>
                              @endif
                              {{-- Show colors --}}
                              @if($product->colors)
                                  <div class="color-list">
                                      @foreach($product->colors as $color)
                                          <span class="color-dot" style="background-color: {{ $color }}"></span>
                                      @endforeach
                                  </div>
                              @endif
                          </div>
                        </a>
                      @endforeach
                  </div>
              </div>
              <div class="arrow right">&#8250;</div>
          </div>
          @endif
    </section>
    



    <div class="vedaro-hero">
       
       <div class="vedaro-overlay">
          <div class="vedaro-logo">A Touch of Divinity.</div>
          <h3 class="vedaro-heading">Vedaro spiritual gifting brings together tradition and <br> elegance, perfect for those you love.</h3>
       </div>
       
       <div class="vedaro-img-container">
          <img src="{{asset('assets/images/home/Spiritual_Section_Banner_Large.webp')}}" alt="Vedaro Banner" class="vedaro-bg">
          <a href="#" class="vedaro-btn">Shop Now</a>
       </div>
    
    
      <section class="divinity-section">
    
      <!-- Top row -->
    
      <h2 class="header-title-suggestion">Suggestions for You</h2>
    
    
                  <!-- Top row -->
        @php
        // Find the category by name
        $category = \App\Models\Category::where('name', 'rings')->first();
    
        // Fetch products of this category
        $categoryProducts = \App\Models\Product::where('category', $category->id)->get();
    @endphp
    
    @if($categoryProducts->count() >= 5)
    <div class="row-container">
        <div class="arrow left disabled">&#8249;</div>
        <div class="slider-wrapper">
            <div class="slider-track">
                @foreach($categoryProducts as $product)
                    @php
                        $variants = $product->product_type == 'variant' ? App\Models\ProductVariant::where('product_id', $product->id)->get() : collect();
                        $firstVariant = $variants->first();
                    @endphp
                    <div class="product-card">
                        <a href="{{ route('product.details',$product->productName) }}" class="redirect-details">
                            <img src="{{ asset('storage/products/' . $product->image1) }}" alt="{{ $product->productName }}">
                            <p>{{ $product->productName }}</p>
    
                            @if($product->product_type != 'variant')
                                <p class="price">₹{{ $product->discountPrice }}</p>
                                @if($product->discountPercentage != 0)
                                    <p class="old-price"><s>₹{{ $product->price }}</s></p>
                                @endif
                            @else
                                {{-- <p class="price variant-price" data-variant-id="{{ $firstVariant->id }}">₹{{ $firstVariant->discount_price }}</p>
                                <p class="old-price variant-old-price">₹{{ $firstVariant->price }}</p> --}}
                                  <p class="price"data-variant-id="{{ $firstVariant->id }}">₹{{ $firstVariant->discount_price }}</p>
    
                        {{-- Show old price if discounted --}}
                        @if($product->discountPercentage != 0)
                            <p class="old-price"><s>₹{{ $firstVariant->price }}</s></p>
                        @endif                          
                            @endif
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="arrow right">&#8250;</div>
    </div>
    @endif
    
    
    
          
          
          
          
          
          
          
          
          
          
          
          
          
    
      <!-- Bottom row -->
     @php
        // Find the category by name
        $category = \App\Models\Category::where('name', 'bracelets')->first();
    
        // Fetch products of this category
        $categoryProducts = \App\Models\Product::where('category', $category->id)->get();
    @endphp
    
    @if($categoryProducts->count() >= 5)
    <div class="row-container">
        <div class="arrow left disabled">&#8249;</div>
        <div class="slider-wrapper">
            <div class="slider-track">
                @foreach($categoryProducts as $product)
                     <a href="{{ route('product.details',$product->productName) }}" class="redirect-details">
                    <div class="product-card">
                        <img src="{{ asset('storage/products/' . $product->image1) }}" alt="{{ $product->productName }}">
                        <p>{{ $product->productName }}</p>
                        <p class="price">₹{{ $product->discountPrice }}</p>
    
                        {{-- Show old price if discounted --}}
                        @if($product->discountPercentage != 0)
                            <p class="old-price"><s>₹{{ $product->price }}</s></p>
                        @endif
    
                        {{-- Show colors --}}
                        @if($product->colors)
                            <div class="color-list">
                                @foreach($product->colors as $color)
                                    <span class="color-dot" style="background-color: {{ $color }}"></span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                        </a>
                @endforeach
            </div>
        </div>
        <div class="arrow right">&#8250;</div>
    </div>
    @endif
    
    
    </section>
    </div>
    



  <!-- video container codes -->

    
    <div class="d-flex flex-column align-items-center justify-content-center overflow-hidden">
    
        <div class="text-center w-100 px-4" style="max-width: 960px;">
          <h1 class="text-3xl md:text-4xl font-semibold text-[#1A3A32]">Discover Vedaro, As It Was Meant to Be Seen.</h1>
            <div class="carousel-container position-relative d-flex align-items-center justify-content-center w-100 mt-5" style="height: 500px;">
                
               <button id="prevBtn" class="nav-arrow position-absolute start-0 z-2 rounded-4 d-flex align-items-center justify-content-center border-0"
                   style="width: clamp(40px, 8vw, 60px); height: clamp(60px, 15vw, 120px); left: 0; transform: translateX(25%);">
                         <svg xmlns="http://www.w3.org/2000/svg" width="50%" height="50%" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                               </svg>
                            </button>
    
                            <div id="carousel" class="carousel position-relative w-100 h-100 d-flex align-items-center justify-content-center">
                            </div>
    
                            <button id="nextBtn" class="nav-arrow position-absolute end-0 z-2 rounded-4 d-flex align-items-center justify-content-center border-0"
                            style="width: clamp(40px, 8vw, 60px); height: clamp(60px, 15vw, 120px); right: 0; transform: translateX(-25%);">
                         <svg xmlns="http://www.w3.org/2000/svg" width="50%" height="50%" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
             </button>
    
    
            </div>
        </div>
    </div>
    





<section class="px-3 py-5">
   <div class="container px-3 px-md-5">
      <div class="row align-items-center g-5">
         <div class="col-md-6">
            <p class="small text-uppercase text-muted fw-semibold mb-2">About VEDARO</p>
            <h2 class="fw-bold text-dark mb-3" style="font-size: 2rem; line-height: 1.3;">
               Sustainably Crafted,<br>
               Eternally Beautiful
            </h2>
            <p class="text-muted mb-4" style="line-height: 1.7;">
               Vedaro was founded by Bhavya Garodia, a young visionary from Rajasthan with an old soul and a deep reverence for timeless beauty. Raised amidst the spiritual richness of Indian tradition and driven by a passion for design, Bhavya envisioned a brand where purity meets purpose. Vedaro was born not just to adorn, but to tell stories — of devotion, detail, and quiet luxury. Each piece reflects his belief: that true elegance lies in simplicity, and meaning is the finest ornament.
            </p>
            <!-- <a href="/about">
            <button class="btn border border-dark text-dark text-uppercase px-4 py-2 small fw-semibold" style="transition: 0.3s;">
            About  
            </button>
            </a> -->
         </div>
         <div class="col-md-6 text-center imageAbout">
            <img src="{{ asset('assets/images/about/about.webp') }}" alt="VEDARO Store" class="img-fluid rounded shadow-sm" style="max-height: 450px; object-fit: cover;">
         </div>
      </div>
   </div>
</section>



<section style="display: flex; justify-content: center;" >
   <div class="features-section">
    <div class="feature-box">
      <div class="feature-icon"><i class="fas fa-hands"></i></div>
      <div class="feature-title">Hand Crafted</div>
      <div class="feature-text">
        Every piece is designed with care and handcrafted by skilled artisans using ethically sourced silver.
      </div>
    </div>

    <div class="feature-box">
      <div class="feature-icon"><i class="fas fa-certificate"></i></div>
      <div class="feature-title">Responsible Craftsmanship</div>
      <div class="feature-text">
        We’re committed to climate action through sustainable practices and mindful material choices.
      </div>
    </div>

    <div class="feature-box">
      <div class="feature-icon"><i class="fas fa-infinity"></i></div>
      <div class="feature-title">Timeless Design</div>
      <div class="feature-text">
        Our jewelry blends traditional artistry with modern elegance, made to be worn every day or treasured for years.
      </div>
    </div>
    </div>
  </section>






</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script src="{{ asset('assets/js/home.js') }}"></script>
<script>
   // Countdown timer function
   function updateCountdownTimers() {
       const now = new Date().getTime();
   
       document.querySelectorAll('.timer-container').forEach(timerContainer => {
           const productId = timerContainer.id.replace('timer-', '');
           const endTimeAttribute = timerContainer.dataset.endTime;
           const addToCartButton = document.getElementById(`add-to-cart-${productId}`);
   
           // If no end time is set, hide the timer and show the "Add to Cart" button.
           if (!endTimeAttribute || endTimeAttribute === '') {
               timerContainer.style.display = 'none';
               if (addToCartButton) {
                   addToCartButton.style.display = 'flex'; // Use flex since it's a lock-icon with text
               }
               return;
           }
   
           const endTime = parseInt(endTimeAttribute) * 1000;
           const distance = endTime - now;
   
           if (distance < 0) {
               // Timer has ended
               timerContainer.style.display = 'none';
               if (addToCartButton) {
                   addToCartButton.style.display = 'flex'; // Show "Add to Cart" button
               }
           } else {
               // Timer is running
               timerContainer.style.display = 'grid'; // Show the timer grid
               if (addToCartButton) {
                   addToCartButton.style.display = 'none'; // Hide "Add to Cart" button
               }
   
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
</script>
<script>
   document.addEventListener("DOMContentLoaded", function () {
   const timers = document.querySelectorAll(".countdown-timer");
   
   timers.forEach(timer => {
       const timeEl = timer.querySelector(".time-remaining");
       const endTime = parseInt(timer.dataset.endTime);
   
       const updateTimer = () => {
           const now = Math.floor(Date.now() / 1000);
           let remaining = endTime - now;
   
           if (remaining <= 0) {
               timeEl.textContent = "Now Available for Sale";
               return;
           }
   
           const d = Math.floor(remaining / 86400);
           const h = Math.floor((remaining % 86400) / 3600);
           const m = Math.floor((remaining % 3600) / 60);
           const s = remaining % 60;
   
           timeEl.textContent = `${d}d ${h.toString().padStart(2, '0')}h ${m.toString().padStart(2, '0')}m ${s.toString().padStart(2, '0')}s`;
   
           setTimeout(updateTimer, 1000);
       };
   
       updateTimer();
   });
   });
</script>
<script>
   $(document).ready(function () {
   $('.add-to-cart-btn').on('click', function (e) {
      e.preventDefault();
   
      var productId = $(this).data('product-id');
   
      $.ajax({
          url: '{{ route("cart.add") }}',
          type: 'POST',
          data: {
              product_id: productId,
              product_qty: 1, // default quantity
              _token: '{{ csrf_token() }}'
          },
          success: function (response) {
              if (response.success) {
                  Swal.fire({
                      icon: 'success',
                      title: 'Added!',
                      text: response.message,
                      timer: 1500,
                      showConfirmButton: false
                  });
                     // 🔁 Update cart count after success
                      updateCartCount();
              }
          },
          error: function (xhr) {
              let errorMessage = "Something went wrong!";
              if (xhr.responseJSON && xhr.responseJSON.message) {
                  errorMessage = xhr.responseJSON.message;
              }
   
              Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: errorMessage,
              });
          }
      });
   });
   });
   
     function updateCartCount() {
      $.ajax({
          url: '/cart/count',
          method: 'GET',
          dataType: 'json',
          success: function (response) {
              if (response.cartCount !== undefined) {
                  $('#cart-count').text(response.cartCount);
              }
          },
          error: function () {
              console.error('Failed to update cart count.');
          }
      });
   }
</script>
<!--script for the home categories products shows-->
<script>
   function scrollProducts(direction, containerId) {
       const container = document.getElementById(containerId);
       const scrollAmount = 300; // Adjust this value to control scroll distance
       
       if (direction === 'left') {
           container.scrollBy({
               left: -scrollAmount,
               behavior: 'smooth'
           });
       } else {
           container.scrollBy({
               left: scrollAmount,
               behavior: 'smooth'
           });
       }
   }
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".row-container").forEach((container) => {
        const track = container.querySelector(".slider-track");
        const cards = container.querySelectorAll(".product-card");
        const leftArrow = container.querySelector(".arrow.left");
        const rightArrow = container.querySelector(".arrow.right");

        let currentIndex = 0;
        const gap = parseInt(getComputedStyle(track).gap) || 20;
        const cardWidth = cards[0]?.offsetWidth || 160;

        function moveSlide(direction) {
            const visibleCards = Math.floor(track.offsetWidth / (cardWidth + gap));
            const maxIndex = cards.length - visibleCards;

            currentIndex += direction;
            if (currentIndex < 0) currentIndex = 0;
            if (currentIndex > maxIndex) currentIndex = maxIndex;

            const offset = -(currentIndex * (cardWidth + gap));
            track.style.transform = `translateX(${offset}px)`;

            // Update arrow states
            if (leftArrow) leftArrow.classList.toggle("disabled", currentIndex === 0);
            if (rightArrow) rightArrow.classList.toggle("disabled", currentIndex === maxIndex);
        }

        if (leftArrow) leftArrow.addEventListener("click", () => moveSlide(-1));
        if (rightArrow) rightArrow.addEventListener("click", () => moveSlide(1));

        // Initialize position
        moveSlide(0);

        // Reset when resizing
        window.addEventListener("resize", () => {
            currentIndex = 0;
            moveSlide(0);
        });
    });
});
</script>


<script> 
   // Optional: Add hover effect enhancement
document.querySelectorAll('.category-card').forEach(card => {
    card.addEventListener('mouseenter', () => {
        card.style.transform = 'scale(1.05)';
        
    });
    card.addEventListener('mouseleave', () => {
        card.style.transform = 'scale(1)';
        
    });
});
</script>

  <script>
        document.addEventListener('DOMContentLoaded', () => {
            const track = document.querySelector('.carousel-track');
            const paginationContainer = document.querySelector('.pagination-dots');
            const originalSlides = Array.from(track.children);
            let isTransitioning = false;
            let intervalId;

            // --- Setup Clones for Seamless Loop ---
            // Clone the first few and last few slides to ensure the loop is always smooth
            const clonesToCreate = 3;
            for (let i = 0; i < clonesToCreate; i++) {
                const cloneFirst = originalSlides[i].cloneNode(true);
                cloneFirst.classList.add('clone');
                track.appendChild(cloneFirst);

                const cloneLast = originalSlides[originalSlides.length - 1 - i].cloneNode(true);
                cloneLast.classList.add('clone');
                track.insertBefore(cloneLast, originalSlides[0]);
            }

            const allSlides = Array.from(track.children);
            // We start at the second image from the original set
            let currentIndex = clonesToCreate + 1;

            // --- Create Pagination Dots ---
            originalSlides.forEach((_, index) => {
                const dot = document.createElement('button');
                dot.classList.add('dot');
                dot.addEventListener('click', () => {
                    setPosition(clonesToCreate + index);
                    // Reset interval on manual navigation
                    startAutoScroll();
                });
                paginationContainer.appendChild(dot);
            });
            const dots = Array.from(paginationContainer.children);

            const getSlideWidth = () => {
                const slide = originalSlides[0]; // Calculate based on an original slide
                const style = window.getComputedStyle(slide);
                const margin = parseFloat(style.marginLeft) + parseFloat(style.marginRight);
                return slide.offsetWidth + margin;
            };

            const updateActiveElements = () => {
                // Calculate which of the ORIGINAL slides should be active (0-6)
                const activeOriginalIndex = (currentIndex - clonesToCreate + originalSlides.length) % originalSlides.length;

                allSlides.forEach((slide, index) => {
                    slide.classList.toggle('active', index === currentIndex);
                });

                dots.forEach((dot, index) => {
                    dot.classList.toggle('active', index === activeOriginalIndex);
                });
            };

            const setPosition = (index, withTransition = true) => {
                const slideWidth = getSlideWidth();
                // Calculate an offset to center the active slide in the viewport.
                // Using window.innerWidth is more reliable for getting the full viewport width.
                const containerWidth = window.innerWidth;
                const offset = (containerWidth / 2) - (slideWidth / 2);
                const transformValue = -(slideWidth * index) + offset;

                track.style.transition = withTransition ? 'transform 0.8s ease-in-out' : 'none';
                track.style.transform = `translateX(${transformValue}px)`;
                currentIndex = index;
                updateActiveElements();
            };

            const moveToNext = () => {
                if (isTransitioning) return;
                isTransitioning = true;
                setPosition(currentIndex + 1);
            };

            // --- Event Listener for Loop Reset ---
            track.addEventListener('transitionend', () => {
                isTransitioning = false;
                // If we've reached one of the clones at the end
                if (currentIndex >= clonesToCreate + originalSlides.length) {
                    setPosition(currentIndex - originalSlides.length, false);
                }
                // If we've reached one of the clones at the beginning (for potential manual controls)
                if (currentIndex < clonesToCreate) {
                    setPosition(currentIndex + originalSlides.length, false);
                }
            });

            const startAutoScroll = () => {
                clearInterval(intervalId); // Clear existing interval
                intervalId = setInterval(moveToNext, 2000);
            };

            // --- Initial Setup ---
            const initialize = () => {
                setPosition(currentIndex, false);
                startAutoScroll();
            };

            window.addEventListener('load', initialize);
            window.addEventListener('resize', () => setPosition(currentIndex, false));

            // Optional: Pause scrolling when the user hovers over the carousel
            track.addEventListener('mouseenter', () => clearInterval(intervalId));
            track.addEventListener('mouseleave', startAutoScroll);
        });
    </script>




    

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const carousel = document.getElementById('carousel');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');

            // Using the video links you provided
            const videoSources = [
                'https://cdn.pixabay.com/video/2025/06/03/283431_tiny.mp4',
                'https://cdn.pixabay.com/video/2025/03/23/266987_tiny.mp4',
                'https://cdn.pixabay.com/video/2025/04/29/275498_tiny.mp4',
                'https://cdn.pixabay.com/video/2025/05/01/275983_tiny.mp4',
                'https://cdn.pixabay.com/video/2023/03/08/153821-806526710_tiny.mp4',
            ];

            let slides = [];
            let currentIndex = 0;
            
            // Create and append video slides
            videoSources.forEach((src, index) => {
                const slide = document.createElement('div');
                slide.className = 'video-slide position-absolute overflow-hidden';
                slide.style.width = '240px';
                slide.style.height = '384px';
                
                const video = document.createElement('video');
                video.src = src;
                video.muted = true;
                video.loop = true;
                video.setAttribute('playsinline', ''); // For iOS compatibility
                
                slide.appendChild(video);

                if (index === 1) { // Add V logo to the second slide
                    const logo = document.createElement('div');
                    logo.className = 'v-logo position-absolute z-10 d-flex align-items-center justify-content-center fw-bold fs-5 rounded-circle';
                    logo.textContent = 'V';
                    slide.appendChild(logo);
                }

                carousel.appendChild(slide);
                slides.push({element: slide, video: video});
            });

            function updateCarousel() {
                slides.forEach((slide, index) => {
                    slide.video.pause();
                    slide.video.currentTime = 0;
                    
                    const classList = slide.element.classList;
                    classList.remove('active', 'prev', 'next', 'prev-outer', 'next-outer', 'hide-prev', 'hide-next');
                    
                    const pos = (index - currentIndex + slides.length) % slides.length;

                    switch(pos) {
                        case 0:
                            classList.add('active');
                            slide.video.play().catch(error => console.error("Autoplay failed:", error));
                            break;
                        case 1:
                            classList.add('next');
                            break;
                        case 2:
                            classList.add('next-outer');
                            break;
                        case slides.length - 1:
                             classList.add('prev');
                            break;
                        case slides.length - 2:
                             classList.add('prev-outer');
                            break;
                        default:
                            if(index < currentIndex) classList.add('hide-prev');
                            else classList.add('hide-next');
                            break;
                    }
                });
            }

            nextBtn.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % slides.length;
                updateCarousel();
            });

            prevBtn.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + slides.length) % slides.length;
                updateCarousel();
            });

            // Initial setup
            updateCarousel();
        });
    </script>

    <script>
      $(document).ready(function () {
    let searchTimeout; // To debounce search input

    $('#global-search-input').on('keyup', function () {
        const query = $(this).val().trim();
        const searchResultsContainer = $('#search-results-dropdown');

        // Clear previous timeout
        clearTimeout(searchTimeout);

        // If the query is empty, hide the dropdown
        if (query.length === 0) {
            searchResultsContainer.hide();
            return;
        }

        // Set a new timeout to delay the AJAX request (debouncing)
        // This prevents sending requests on every single keystroke
        searchTimeout = setTimeout(() => {
            $.ajax({
                url: '{{ route("global.search") }}', // Your Laravel route for global search
                type: 'GET',
                data: { q: query }, // 'q' matches your controller's input name
                dataType: 'json', // Expect JSON response
                success: function (response) {
                    let resultsHtml = '';
                    if (response.products && response.products.length > 0) {
                        response.products.forEach(function (product) {
                            // Assuming your product object has 'id', 'productName', and 'image' (or a URL to it)
                            // Adjust these keys based on your actual Product model and API response
                            let productName = product.productName || 'N/A';
                            let productUrl = '{{ route("product.details", ":id") }}'.replace(':id', product.id); // Assuming 'product.details' route exists and takes product ID
                            let productImageUrl = product.image ? '/storage/' + product.image : '/path/to/default/image.png'; // Adjust path as needed

                            resultsHtml += `
                                <div class="search-result-item" data-product-id="${product.id}">
                                    <a href="${productUrl}" class="d-flex align-items-center">
                                        <img src="${productImageUrl}" alt="${productName}" style="width: 40px; height: 40px; margin-right: 10px; object-fit: cover;">
                                        <span>${productName}</span>
                                    </a>
                                </div>
                            `;
                        });
                        searchResultsContainer.html(resultsHtml).show();
                    } else {
                        searchResultsContainer.html('<div class="search-result-item no-results">No products found.</div>').show();
                    }
                },
                error: function (xhr) {
                    console.error('Search request failed:', xhr);
                    searchResultsContainer.html('<div class="search-result-item error">An error occurred.</div>').show();
                }
            });
        }, 300); // Wait 300ms after the user stops typing
    });

    // Hide dropdown when clicking outside of it
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.search-container').length) {
            $('#search-results-dropdown').hide();
        }
    });

    // Optional: Navigate to product details page when a result item is clicked
    // This is already handled by the <a> tag within the resultsHtml, but you might want to add
    // additional logic here if needed (e.g., tracking clicks).
});
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>



@endsection



