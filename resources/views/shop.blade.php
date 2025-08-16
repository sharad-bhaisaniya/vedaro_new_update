@extends('layouts.main')

@section('content')

<style>
    @media (min-width: 768px) and (max-width: 950px) {
  .all-cards {
    width: 300px !important;
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
	bottom: 8px;
	border-radius: 0;
	background: transparent;
	border: none !important;
	backdrop-filter: blur(20px);
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
</style>



<div class="container-fluid" style="margin-block:150px;">
    <div class="row">
        <!-- Sidebar -->
        <aside class="col-md-3">
            <div class="p-3 border rounded bg-light">
                <h5 class="mb-4 text-uppercase text-center" style="font-weight: bold; color: #b08d57;">Jewellery Categories</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="{{route('shop')}}" class="text-decoration-none text-dark">All Category Products</a>
                        <!--<span class="badge bg-warning text-dark rounded-pill">New</span>-->
                    </li>
                    @foreach($categories as $cat)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ route('product.show', ['id' => $cat->id]) }}" class="text-decoration-none text-dark">
                                {{ $cat->name }}
                            </a>
                            <span class="badge bg-warning text-dark rounded-pill">New</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="col-md-9">
            <h4 class="mb-4 text-uppercase" style="color: #b08d57; font-weight: bold;">
                @if(request('category'))
                    {{ $currentCategoryName ?? 'Selected Category' }} Products
                @else
                    All Jewellery Category Products
                @endif
            </h4>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                @forelse($products as $product)
                <div class="col all-cards">
                    
                    
                <a  href="{{ url('/product_details/' . urlencode($product->productName)) }}" class="text-decoration-none">
                                  <div class="card h-100 border-0 shadow-sm position-relative">
                    <img src="{{ asset('storage/products/' . $product->image1) }}" class="img-front" alt="{{ $product->productName }}" style="height: 220px; object-fit: cover;">
                    <div class="card-body">
                        <h6 class="card-title text-uppercase" style="color: #b08d57;">{{ $product->name }}</h6>
                        <p class="small text-secondary">{{ $product->productName }}</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 d-flex gap-2 w-100">
                        @if($product->current_stock > 0)
                    {{-- ✅ If timer is enabled and still running, hide buttons --}}
                    @if($product->add_timer && $product->timer_end_at && now()->lt($product->timer_end_at))
                        {{-- Timer running → No buttons shown --}}
                    @else
                        {{-- Timer not running → Show Add to Cart & Buy Now --}}
                        <div class="d-flex gap-2 w-100">
                            <!-- Add to Cart Button -->
                            {{-- Normal Add to Cart form --}}
                                            <form id="purchaseButtons-{{ $product->id }}" class="w-100 ">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="product_qty" value="1">
                                                <button type="submit" class="add-to-cart btn btn-primary w-100">
                                    Add to Cart
                                </button>
                            </form>
                
                            <!-- Buy Now Button -->
                            <form action="{{ route('checkout.single', $product->id) }}" method="GET" 
                                                  id="available-message-{{ $product->id }}" 
                                                  class="timer-expired-message w-100">
                                                <button type="submit" class="btn btn-success w-100" >
                                    Buy Now
                                </button>
                            </form>
                        </div>
                    @endif
                @else
                    {{-- ✅ Out of stock → Show Prebook button --}}
                    <form action="{{ url('/product_details/' . urlencode($product->productName)) }}" method="GET" class="w-100">
                        <button type="submit" class="btn btn-warning w-100">
                            Prebook on WhatsApp
                        </button>
                    </form>
                @endif
                
                    </div>
                    
                    	@if($product->total_stock)
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
            
                            </div>
                            @empty
                            <div class="col-12">
                                <p class="text-muted">No products found in this category.</p>
                            </div>
                            @endforelse
                        </div>
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




