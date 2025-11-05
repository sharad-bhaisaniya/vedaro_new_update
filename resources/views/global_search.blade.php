@extends('layouts.main')
@section('title', 'Search Results')

<style>
    .col {
        margin-bottom: 20px;
    }

    @media (min-width: 768px) and (max-width: 1063px) {
        .col {
            width: 29%!important;
            margin-inline: auto;
        }
    }
    
    
    	.timer-container {
	width: 100%;
	background-color: #fffaf0;
	color: #9c4221;
	padding: 0.75rem;
	grid-template-columns: repeat(4, 1fr);
	gap: 0.5rem;
	text-align: center;
	display: grid;
	position: absolute;
	z-index: 9;
	bottom: 96px;
	border-radius: 0;
	background: transparent;
	border: none !important;
	backdrop-filter: blur(20px);
	}
	.timer-expired-message {
	background-color: #e0f2f7;
	border: 1px solid #b2ebf2;
	color: #00838f;
	padding: 0.75rem;
	border-radius: 0.5rem;
	margin: 1rem 0;
	font-weight: 600;
	text-align: center;
	}
	.timer-part {
	display: flex;
	flex-direction: column;
	align-items: center;
	background: #ffffffad;
	color: #3103fc;
	}
	.timer-value {
	font-size: 1.25rem;
	font-weight: 700;
	color: #6b46c1;
	}
	.timer-label {
	font-size: 0.65rem;
	text-transform: uppercase;
	color: #b7791f;
	letter-spacing: 0.05em;
	}
	.product-availability {
	display: inline-block;
	padding: 8px 16px;
	border-radius: 4px;
	font-size: 14px;
	font-weight: 600;
	text-transform: uppercase;
	letter-spacing: 0.5px;
	margin-inline: auto;
	width: 100%;
	background-color: #ffeeee;
	color: #d32f2f;
	border: 1px solid #ffcdcd;
	}
	.product-availability.available {
	background-color: #e8f5e9;
	color: #2e7d32;
	border: 1px solid #c8e6c9;
	}
	.faq-section {
	background-color: #faf7f2;
	}
	.accordion-button {
	background-color: white;
	color: #333;
	font-weight: 500;
	padding: 1.25rem;
	box-shadow: 0 2px 10px rgba(0,0,0,0.05);
	border-radius: 8px !important;
	}
	.accordion-button:not(.collapsed) {
	background-color: white;
	color: #b78d65;
	box-shadow: 0 2px 15px rgba(0,0,0,0.1);
	}
	.accordion-button:focus {
	box-shadow: 0 0 0 0.25rem rgba(183, 141, 101, 0.25);
	border-color: #b78d65;
	}
	.accordion-body {
	padding: 1.5rem;
	background-color: white;
	border-radius: 0 0 8px 8px;
	box-shadow: 0 5px 15px rgba(0,0,0,0.05);
	}
	.accordion-item {
	border-radius: 8px;
	overflow: hidden;
	}
    /*Reels styling */
    .horizontal-reels-container {
        width: 100%;
        overflow-x: auto;
        white-space: nowrap;
        padding: 10px 0;
        /*background-color: #000;*/
        scrollbar-width: none; /* Hide scrollbar for Firefox */
        -ms-overflow-style: none; /* Hide scrollbar for IE/Edge */
    }
    
    .horizontal-reels-container::-webkit-scrollbar {
        display: none; /* Hide scrollbar for Chrome/Safari */
    }
    
    .reel-card {
        display: inline-block;
        width: 280px;
        height: 500px;
        margin-right: 15px;
        border-radius: 15px;
        overflow: hidden;
        position: relative;
        background-color: #222;
        vertical-align: top;
    }
    
    .reel-video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .reel-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 15px;
        background: linear-gradient(transparent, rgba(0,0,0,0.8));
        color: white;
    }
    
    .reel-title {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 8px;
        white-space: normal;
    }
    
    .reel-description {
        font-size: 12px;
        margin-bottom: 12px;
        white-space: normal;
    }
    
    .reel-actions {
        display: flex;
        justify-content: space-between;
    }
    
    .reel-button {
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: bold;
        cursor: pointer;
    }
    
    .reel-button.cta {
        background-color: #FF0050;
    }
    
    .reel-stats {
        display: flex;
        gap: 10px;
    }
    
    .reel-stat {
        display: flex;
        flex-direction: column;
        align-items: center;
        font-size: 10px;
    }
    
    .reel-stat i {
        font-size: 18px;
        margin-bottom: 2px;
    }
    
    .video-placeholder {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        color: white;
        font-size: 18px;
        background: linear-gradient(45deg, #ff0050, #ff8c00, #00bfff, #00ff7f);
        background-size: 400% 400%;
        animation: gradient 15s ease infinite;
    }
    
    @keyframes gradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
        /*Banner Slider with Product Styling */
    /* Responsive adjustments */
    @media (max-width: 1200px) {
        .limited-content-overlay {
            flex-direction: column;
            gap: 1rem !important;
        }
        
        .banner-text-container,
        .product-cards-container {
            max-width: 100% !important;
            width: 100% !important;
        }
        
        .banner-title {
            font-size: 2.5rem !important;
        }
        
        .banner-description {
            font-size: 1.2rem !important;
        }
    }
    
    @media (max-width: 768px) {
        
        
        .img-container {
            height: 150px !important;
        }
        
        .banner-title {
            font-size: 2rem !important;
        }
    }
    
    @media (max-width: 576px) {
        .product-card {
            /*width: 140px !important;*/
            justify-self: center;
        }
        
        .img-container {
            height: 140px !important;
        }
    }
    
    @media (max-width: 768px){
        .product-card{
            width: 300px;
        }
          }
        
    
    /* Hover effects */
    /*.product-card:hover {*/
    /*    transform: translateY(-8px) scale(1.03) !important;*/
    /*    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4) !important;*/
    /*}*/
    
    .badge-wrapper {
	position: absolute;
	top: 8px; 
	left: 8px; 
	z-index: 10;
	display: flex;
	flex-direction: row;
	gap: 4px; 
	justify-content: space-between;
	width: 100%;
	padding-right: 15px;
	}
	.product-badge {
	font-size: 0.75rem;
	font-weight: 500;
	border-radius: 50rem;
	padding: 0.25rem 0.5rem;
	width: fit-content;
	}
	.limited-badge {
	background-color: #6b46c1;
	color: #ffffff;
	}
	.in-stock-badge {
	background-color: #28A745;
	color: white;
	}
	.out-stock-badge {
	background-color: #DC3545;
	color: white;
	}
    
    .product-card:hover img {
        transform: scale(1.08) !important;
    }
    
    
.product-card {
	width: 315px;
	transition: all 0.3s ease-in-out;
	flex-shrink: 0;
	border-radius: 0;
}

.product-img-wrapper {
	height: 380px;
	width: 100%;
	overflow: hidden;
	position: relative;
	/* border-radius: 0.25rem; */
}

#scrollContainer {
	/*justify-content: space-between;*/
}

.product-img-wrapper img {
	transition: opacity 0.4s ease;
	object-fit: cover;
	width: 100%;
	height: 100%;
	position: absolute;
	z-index: 5;
	top: 0;
	left: 0;
}

.img-front {
	opacity: 1;
	z-index: 2;
}

.img-back {
	opacity: 0;
	z-index: 1;
}

.product-img-wrapper:hover .img-front {
	opacity: 0;
}

.product-img-wrapper:hover .img-back {
	opacity: 1;
}

.lock-icon {
	position: absolute;
	bottom: 10px;
	right: 10px;
	background-color: #1c1b33;
	width: 30px;
	height: 30px;
	display: flex;
	align-items: center;
	justify-content: center;
	z-index: 99;
}

.color-dot {
	width: 14px;
	height: 14px;
	border-radius: 50%;
	margin-right: 6px;
	display: inline-block;
	border: 1px solid #ddd;
}


/* Custom CSS for responsiveness */
@media (max-width: 767.98px) {
	.flex-md-column {
		flex-direction: row !important;
		/* On small screens, make thumbnails horizontal */
	}

	.order-1.order-md-0 {
		order: 0 !important;
		/* Change order for small screens */
	}

	.order-0.order-md-1 {
		order: 1 !important;
		/* Change order for small screens */
	}

	/* Ensure horizontal scroll for thumbnails on small screens */
	.overflow-auto {
		overflow-x: auto !important;
		white-space: nowrap;
	}

	.flex-shrink-0 {
		flex-shrink: 0;
	}


	.images-slides {
		width: 100%;
	}
</style>

<div class="container-fluid" style="margin-block: 150px;">
    <div class="row">
        <main class="col-md-12">
            <h4 class="mb-4 text-uppercase" style="color: #b08d57; font-weight: bold;">
                Results for "{{ $query }}"
            </h4>

            @if($products->count() > 0)
          
           <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-3 row-cols-xl-5 g-2">
               
                       	@foreach($products as $product)
        		<a href="{{ url('/product_details/' . urlencode($product->productName)) }}" class="text-decoration-none anchor text-dark">
        			<div class="card product-card bg-white shadow-sm">
        				<div class="badge-wrapper">
        					@if($product->add_timer == 1)
        					<span class="product-badge limited-badge">
               <i class="fas fa-star me-1"></i>
               Limited Edition
               </span>
        					@endif
        				<span class="product-badge {{ $product->current_stock ? 'in-stock-badge' : 'out-stock-badge' }}">
               <i class="fas {{ $product->current_stock ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i>
               {{ $product->current_stock ? 'In Stock' : 'Out of Stock' }}
               </span>
        				</div>
        				<div class="product-img-wrapper">
        					<img src="{{ asset('storage/products/' . $product->image1) }}" class="img-front" alt="{{ $product->productName }}">
        					@if($product->image2)
        					<img src="{{ asset('storage/products/' . $product->image2) }}" class="img-back" alt="{{ $product->productName }} Hover">
        					@else
        					<img src="{{ asset('storage/products/' . $product->image1) }}" class="img-back" alt="{{ $product->productName }} Hover">
        					@endif
        				
        									 @if($product->current_stock > 0)
               <div class="lock-icon add-to-cart-btn" id="add-to-cart-{{ $product->id }}" data-product-id="{{ $product->id }}" style="{{ ($product->add_timer && $product->timer_end_at) ? 'display: none;' : '' }}">
                  <i class="fa-solid fa-lock text-white small"></i>
               </div>
               @endif
        				</div>
        				<div class="card-body px-2 py-3">
        					<h6 class="product_name">{{ $product->productName }}</h6>
        					<div class="d-flex align-items-center justify-content-between mt-2">
        						<div>
        							<span class="discountPrice fw-bold fs-6">₹{{ $product->discountPrice }}</span>
        							@if ($product->discountPercentage != 0)
        							<s class="text-muted text-dark small ms-2">₹{{ $product->price }}</s>
        							@endif
        			
        						</div>
        					</div>
        					@if($product->colors)
        					<div class="d-flex mb-2">
        						@foreach($product->colors as $color)
        						<span class="color-dot" style="background-color: {{ $color }}"></span>
        						@endforeach
        					</div>
        					@endif
        				</div>
                    				@if($product->current_stock)
                    				@if($product->add_timer && $product->timer_end_at)
                    				<div class="timer-container" id="timer-{{ $product->id }}"
                    					data-end-time="{{ \Carbon\Carbon::parse($product->timer_end_at)->timestamp }}">
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
                    				@endif
                    				@else
                    				<!--<div class="product-availability">Product Not Available</div>-->
                    				@endif
                    			</div>
                    		</a>
                    		@endforeach
            </div>
            @else
                <p>No products found for "{{ $query }}".</p>
            @endif

            @if($categories->count() > 0)
                <hr>
                <h5 class="text-uppercase mt-4" style="color: #b08d57;">Matching Categories</h5>
                <ul class="list-group mt-2">
                    @foreach($categories as $cat)
                        <li class="list-group-item">
                            <a href="{{ route('categories_page', ['category' => $cat->id]) }}">{{ $cat->name }}</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </main>
    </div>
</div>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
