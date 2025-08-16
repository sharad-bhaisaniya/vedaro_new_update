@extends('layouts.main')
@section('title', 'Product-details')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/product_details.css') }}">
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<div class="product_details pt-5"style="margin-top: 40px;">
<style>
.features-section .feature-row {
  display: flex;
  justify-content: center; /* center the whole row */
  gap: 25%; /* horizontal gap between features */
  flex-wrap: nowrap; /* keep all on one row */
}

.features-section .feature-row > div {
  flex: 1 1 0;
  max-width: 200px;
  min-width: 120px;
  display: flex;
  flex-direction: column; /* icon above, label below */
  align-items: center; /* center horizontally */
  gap: 12px; /* space between icon and label */
}

.features-section .feature-icon svg {
  width: 48px; /* bigger icon */
  height: 48px;
  stroke: #6f42c1; /* match your icon color */
}

.features-section .feature-label {
  font-family: 'Inter', 'Arial', sans-serif;
  font-weight: 600;
  font-size: 1.05rem;
  color: #222;
  white-space: nowrap;
  text-align: center; /* center text under icon */
}

/* Mobile styles */
@media (max-width: 575.98px) {
  .features-section .feature-label {
    font-size: 0.9rem;
  }
  .features-section .feature-icon svg {
    width: 36px; /* slightly smaller on mobile */
    height: 36px;
  }
  .features-section .feature-row {
    gap: 24px;
  }
  .features-section .feature-row > div {
    max-width: 120px;
    min-width: 90px;
  }
}

	/*Small Images bottom side the main image */
	.img-select{
	height: 100px;
	overflow: hidden;
	/*border: 2px solid red; */
	margin-top: 10px;
	}
	@media (max-width: 575px) {
	.btn-shine {
	white-space: wrap !important;
	width: 100%;
	}
	}
	.product_details_accordion_container {
	width: 100%;
	margin: 0 auto;
	}
	.product_details_accordion_item {
	margin-bottom: 10px;
	border: 1px solid #ccc;
	border-radius: 5px;
	overflow: hidden;
	}
	.product_details_accordion_content {
	max-height: 0;
	overflow: hidden;
	transition: max-height 0.3s ease;
	padding: 0 15px;
	/*background: #fff;*/
	}
	.product_details_accordion_content.show {
	max-height: 500px; /* Adjust based on your content */
	padding: 15px;
	}
	.accordion_icon {
	font-weight: bold;
	font-size: 20px;
	margin-left: auto;
	transition: transform 0.3s;
	}
	.product_details_accordion_header {
	cursor: pointer;
	padding: 15px;
	background: #f0f0f0;
	display: flex;
	align-items: center;
	justify-content: space-between;
	}
	.product_details_accordion_header:hover {
	background: #e0e0e0;
	}
	.product_details_accordion_header.active .accordion_icon {
	transform: rotate(45deg);
	}
	.timer-container {
	background-color: #fffaf0;
	border: 1px solid #fed7aa;
	color: #9c4221;
	padding: 0.75rem;
	border-radius: 0.5rem;
	margin: 1rem 0;
	font-weight: 600;
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 0.5rem;
	text-align: center;
	}
	.timer-part {
	display: flex;
	flex-direction: column;
	align-items: center;
	}
	.timer-value {
	font-size: 1.25rem;
	font-weight: 700;
	color: var(--primary-color);
	}
	.timer-label {
	font-size: 0.65rem;
	text-transform: uppercase;
	color: #b7791f;
	letter-spacing: 0.05em;
	}
	.btn-shine {
	display: inline-block;
	padding: 14px 28px;
	font-size: 17px;
	font-weight: 700;
	text-decoration: none;
	color: #FFD700;
	border: 2px solid #FFD700;
	border-radius: 12px;
	background: linear-gradient(to right, #4d4d4d 0%, #fff8b5 10%, #4d4d4d 20%);
	background-size: 300% auto;
	background-position: 0;
	-webkit-background-clip: text;
	-webkit-text-fill-color: transparent;
	animation: shine 3s linear infinite;
	transition: all 0.3s ease;
	white-space: nowrap;
	box-shadow: 0 0 8px rgba(255, 215, 0, 0.4);
	}
	@keyframes shine {
	0% {
	background-position: 0% center;
	}
	100% {
	background-position: 300% center;
	}
	}
	/*stying for Pre-Book Now section*/
	.black-prebook-btn {
	width: 100%;
	padding: 14px 22px;
	font-size: 16px;
	font-weight: 600;
	color: #fff;
	/*background: linear-gradient(135deg, #ff0047, #f33030);*/
	background: black;
	border: 2px solid transparent;
	border-radius: 10px;
	cursor: pointer;
	position: relative;
	z-index: 1;
	overflow: hidden;
	transition: all 0.4s ease;
	box-shadow: 0 0 0 transparent;
	}
	/* Bubble particles */
	.black-prebook-btn span.bubble {
	position: absolute;
	background: rgba(255, 255, 255, 0.4);
	border-radius: 50%;
	pointer-events: none;
	opacity: 0;
	animation: none;
	}
	/* Hover state to start animation */
	.black-prebook-btn:hover {
	border-color: #ff0047;
	box-shadow: 0 0 20px #ff0047cc;
	transform: scale(1.03);
	}
	.black-prebook-btn:hover span.bubble {
	animation: rise 2s ease-out forwards;
	}
	/* Keyframe animation */
	@keyframes rise {
	0% {
	transform: translateY(0) scale(1);
	opacity: 0.8;
	}
	100% {
	transform: translateY(-60px) scale(0.5);
	opacity: 0;
	}
	}
	/* Optional icon margin */
	.black-prebook-btn i {
	margin-left: 8px;
	}
	/*Styling for the Weight Select by user */
	.weight-selector-container {
	/*margin: 1.5rem 0;*/
	padding: 1.5rem;
	/*background: #f8f9fa;*/
	border-radius: 12px;
	box-shadow: 0 2px 8px rgba(0,0,0,0.05);
	width:100%;
	}
	.weight-selector-title {
	color: #333;
	font-weight: 600;
	margin-bottom: 1.25rem;
	font-size: 1.1rem;
	}
	.weight-options-grid {
	display: grid;
	grid-template-columns: repeat(8, 1fr); /* exactly 4 columns */
	gap: 12px;
	}
	.weight-option-card {
	position: relative;
	}
	.weight-option-input {
	position: absolute;
	opacity: 0;
	}
	.weight-option-input:checked + .weight-option-label {
	border-color: #4e73df;
	background-color: rgba(78, 115, 223, 0.05);
	box-shadow: 0 0 0 2px rgba(78, 115, 223, 0.25);
	}
	.weight-option-label {
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	padding: 0 0.5rem;
	border: 1px solid #ddd;
	/*border-radius: 8px;*/
	background: white;
	cursor: pointer;
	transition: all 0.2s ease;
	height: 100%;
	text-align: center;
	width: min-content;
	}
	.weight-option-label:hover {
	border-color: #bbb;
	transform: translateY(-2px);
	}
	.weight-value {
	font-size: 0.8rem;
	font-weight: 600;
	color: #b7ab54;;
	margin-bottom: 4px;
	padding: 4px;
	}
	.weight-badge {
	font-size: 0.7rem;
	padding: 2px 6px;
	border-radius: 4px;
	background: #e9ecef;
	color: #495057;
	}
	.weight-badge.popular {
	background: #ffeeba;
	color: #856404;
	}
	@media (max-width: 768px) {
	.weight-options-grid {
	grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
	}
	}
	/*Style limited-badge */
	.badge-wrapper {
	position: absolute;
	top: 10px;
	left: 10px;
	z-index: 5;
	}
	.limited-badge {
	background-color: #28a745; /* Bootstrap green */
	color: white;
	padding: 4px 10px;
	font-size: 12px;
	border-radius: 4px;
	display: inline-flex;
	align-items: center;
	gap: 5px;
	font-weight: 500;
	}
	.weight-badge{
	display: none;
	}
	/*styling for size*/
	.size-selector-container {
	/*margin: 1.5rem 0;*/
	padding: 1.5rem;
	border-radius: 12px;
	box-shadow: 0 2px 8px rgba(0,0,0,0.05);
	width: 100%;
	}
	.size-selector-title {
	color: #333;
	font-weight: 600;
	margin-bottom: 1.25rem;
	font-size: 1.1rem;
	}
	.size-options-grid {
	display: grid;
	grid-template-columns: repeat(8, 1fr);
	gap: 12px;
	}
	.size-option-card {
	position: relative;
	min-width: 91px;
	}
	.size-option-input {
	position: absolute;
	opacity: 0;
	}
	.size-option-input:checked + .size-option-label {
	border-color: #28a745;
	background-color: rgba(40, 167, 69, 0.05);
	box-shadow: 0 0 0 2px rgba(40, 167, 69, 0.25);
	}
	.size-option-label {
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	padding: 0 0.5rem;
	border: 1px solid #ddd;
	background: white;
	cursor: pointer;
	transition: all 0.2s ease;
	height: 100%;
	text-align: center;
	width: min-content;
	width:100%;
	}
	.size-option-label:hover {
	border-color: #bbb;
	transform: translateY(-2px);
	}
	.size-value {
	font-size: 0.8rem;
	font-weight: 600;
	color: #17a2b8;
	padding: 4px;
	}
	.size-badge {
	font-size: 0.7rem;
	padding: 2px 6px;
	border-radius: 4px;
	background: #e9ecef;
	color: #495057;
	}
	.size-badge.popular {
	background: #c3e6cb;
	color: #155724;
	}
	@media (max-width: 768px) {
	.size-options-grid {
	grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
	}
	}
    
    /*suggested product section */
    .similar-products .card {
        transition: transform 0.2s ease-in-out;
        border-radius: 0.5rem;
    }
    .similar-products .card:hover {
        transform: translateY(-5px);
    }
    .swiper {
        padding-bottom: 40px;
    }
    .swiper-button-next, .swiper-button-prev {
        color: #000; /* Change arrow color */
        background: #fff;
        border-radius: 50%;
        width: 35px;
        height: 35px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }
    .swiper-button-next::after, .swiper-button-prev::after {
        font-size: 16px;
        font-weight: bold;
    }
    .swiper-pagination-bullet-active {
        background: #007bff;
    }
     .similar-products .card{
        flex-direction: column;
    }
   
</style>





@if(session('success'))
<div class="success-message">
	{{ session('success') }}
</div>
@endif
<div class="product_details_section mt-4" ">
	<div class="card-wrapper">
		<div class="card " style="display:flex; width: 100%;">
			<!-- card left -->
			<div class="product-imgs" style="width: 100%;">
				<div class="img-display">
					<div class="img-showcase">
						<img src="{{ asset('/storage/products/'.$product->image1) }}" alt="Product Image 1">
						<img src="{{ asset('/storage/products/'.$product->image2) }}" alt="Product Image 2">
						<img src="{{ asset('/storage/products/'.$product->image3) }}" alt="Product Image 3">
					</div>
				</div>
				<div class="img-select">
					<div class="img-item">
						<a href="#" data-id="1">
						<img src="{{ asset('/storage/products/'.$product->image1) }}" alt="Product Image 1">
						</a>
					</div>
					<div class="img-item">
						<a href="#" data-id="2">
						<img src="{{ asset('/storage/products/'.$product->image2) }}" alt="Product Image 1">
						</a>
					</div>
					<div class="img-item">
						<a href="#" data-id="3">
						<img src="{{ asset('/storage/products/'.$product->image3) }}" alt="Product Image 1">
						</a>
					</div>
				</div>
			</div>
			<!-- card right -->
			<div class="product-content">
				<!--<span class="dis">save &nbsp;{{ $product->discountPercentage }}%</span>-->
				<div class="badge-wrapper">
					@if($product->add_timer == 1)
					<span class="product-badge limited-badge">
					<i class="fas fa-star"></i> Limited Edition
					</span>
					@endif
				</div>
				<h2 class="product-title">{{ $product->productName }}</h2>
				<!-- <div class="product-rating">
					<div class="average-rating__stars">
						<div class="">
					@for ($i = 1; $i <= 5; $i++)
					@if ($i <= floor($averageRating))
					<span class="star filled">&#9733;</span>
					@elseif ($i == ceil($averageRating) && $averageRating - floor($averageRating) > 0)
					<span class="star half">&#9733;</span>
					@else
					<span class="star">&#9734;</span>
					@endif
					@endfor
					</div>
					<p>{{ number_format($averageRating, 1) }} ({{ $totalReviews }} ) </p>
					</div>
					</div> -->
				<div class="product-price">
					<p class="new-price">
						<span class="fw-semibold">₹{{ $product->discountPrice }} </span>
						@if($product->discountPrice < $product->price)
						<s class="fw-light fs-6 ms-2" style="color:#bab6b6;">₹{{ $product->price }}</s>
						@endif
						<!--	<span>-->
						<!--<p class="last-price"><span>₹{{ $product->price }}</span></p>-->
						<!--</span>-->
					</p>
				</div>
				<p class="product_disc">{{ $product->productDescription1 }}</p>
				<div style="width: 90%; margin: 0 auto">
					{{-- @php
					$sizes = [];
					$defaultSize = old('size', $product->size ?? '');
					if (isset($product) && $product->multiple_sizes) {
					$sizes = json_decode($product->multiple_sizes, true);
					// If default size is empty, set to first size in array
					if (empty($defaultSize) && is_array($sizes) && count($sizes) > 0) {
					$defaultSize = $sizes[0];
					}
					}
					@endphp
					<div class="size-selector-container">
						<h4 class="size-selector-title">Select Size Option</h4>
						<!-- Hidden input to store selected size -->
						<input type="hidden" name="size" id="selectedSize" value="{{ $defaultSize }}">
						<div class="size-options-grid">
							@if(!empty($sizes))
							@foreach($sizes as $index => $size)
							@if(!empty($size))
							<div class="size-option-card">
								<input type="radio" name="selected_size"
								id="size{{ $index }}" value="{{ $size }}"
								class="size-option-input"
								{{ $defaultSize === $size ? 'checked' : '' }}>
								<label for="size{{ $index }}" class="size-option-label">
								<span class="size-value">{{ $size }}</span>
								</label>
							</div>
							@endif
							@endforeach
							@else
							<!-- Fallback default size -->
							<div class="size-option-card">
								<input type="radio" name="selected_size"
									id="defaultSize" value="{{ $defaultSize }}"
									class="size-option-input" checked>
								<label for="defaultSize" class="size-option-label">
								<span class="size-value">{{ $defaultSize }}</span>
								</label>
							</div>
							@endif
						</div>
					</div>
					--}}
					{{-- update the size with their stock's --}}
					@php
					$sizes = [];
					$defaultSize = old('size', $product->size ?? '');
					if (isset($product) && $product->size_stock) {
					$sizes = json_decode($product->size_stock, true);
					if (empty($defaultSize) && is_array($sizes) && count($sizes) > 0) {
					foreach ($sizes as $sizeName => $stock) {
					if ($stock > 0) {
					$defaultSize = $sizeName;
					break;
					}
					}
					}
					}
					@endphp
					<div class="size-selector-container">
						<h4 class="size-selector-title">Select Size Option</h4>
						{{-- Hidden input to hold selected size --}}
						<input type="hidden" name="size" id="selectedSize" value="{{ $defaultSize ?? 'Universal' }}">
						@php
						$validSizes = [];
						if (is_array($sizes)) {
						foreach ($sizes as $s => $stock) {
						if (!empty($s) && $stock > 0) {
						$validSizes[$s] = $stock;
						}
						}
						}
						@endphp
						<div class="size-options-grid">
							@if(count($validSizes))
							@foreach($validSizes as $size => $stock)
							<div class="size-option-card">
								<input type="radio"
								name="selected_size"
								id="size{{ $loop->index }}"
								value="{{ $size }}"
								class="size-option-input"
								{{ $defaultSize === $size ? 'checked' : '' }}>
								<label for="size{{ $loop->index }}" class="size-option-label">
								<span class="size-value">{{ $size }}</span>
								<span class="stock-info text-muted" style="font-size: 12px;">
								({{ $stock }} left)
								</span>
								</label>
							</div>
							@endforeach
							@else
							{{-- Fallback size card --}}
							<div class="size-option-card">
								<input type="radio"
									name="selected_size"
									id="defaultSize"
									value="Universal"
									class="size-option-input"
									checked>
								<label for="defaultSize" class="size-option-label">
								<span class="size-value">Universal</span>
								</label>
							</div>
							@endif
						</div>
					</div>
					<!-- Optional: JS to update hidden input if needed -->
					<div class="weight-selector-container">
						<!--<h4 class="weight-selector-title">Products In Stock's</h4>-->
						<div class="weight-option-card">
							<input type="radio" name="selected_weight"
								id="defaultWeight" value="{{  $product->current_stock ?? '' }}"
								class="weight-option-input " checked >
							<label for="defaultWeight" class="weight-option-label w-100">
								<!--<span class="weight-value"> Only {{  $product->current_stock ?? '0' }} piece(s) remaining from  {{ $product->total_stock}} piece(s)</span>-->
								<span class="weight-value"> Only {{  $product->current_stock ?? '0' }}  pieces left</span>
								<!--<span class="weight-badge">Default</span>-->
							</label>
						</div>
					</div>
					
                				@if($product->current_stock > 0)
                    @if($product->add_timer && $product->timer_end_at && \Carbon\Carbon::now()->lt(\Carbon\Carbon::parse($product->timer_end_at)))
                        {{-- TIMER is Active --}}
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
                
                    @php
                        $timerExpired = $product->timer_end_at && \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($product->timer_end_at));
                    @endphp
                
                    @if(!$product->add_timer || $timerExpired)
                        <div class="d-flex gap-3 mt-3">
                            <form id="id="purchaseButtons" action="{{ route('cart.add') }}" method="POST" class="w-100">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="product_qty" value="1">
                                <button class="btn btn-outline-primary btn-lg px-4 w-100">
                                🛒 Add  Cart
                                </button>
                            </form>
                            <a href="{{ route('checkout.single', $product->id) }}" class="w-100">
                                <button class="btn btn-outline-primary btn-lg px-4 w-100">
                                ⚡ Buy Now
                                </button>
                            </a>
                        </div>
                    @endif
                @else
                    {{-- OUT OF STOCK — Show Prebook --}}
                    <div class="mt-4 text-center out" style="cursor:pointer;">
                        <p class="btn-shine bg-dark" target="_blank" id="openPrebookModal">
                            <i class="fas fa-box-open"></i> This product is out of stock — Go and check Pre-Book the order
                        </p>
                    </div>
                @endif

					
					
					<!--Add note-->
					<!--<div class="add_note_form">-->
					<!--	<div class="form-group" style="width: 100%;">-->
					<!--		<input type="text" id="note" name="note" placeholder="Add a note for this product" style="padding:5px; width: 100%;border: none; border-bottom: 1px solid #ccc; border-radius: 0;">-->
					<!--	</div>-->
					<!--	<div class="note_submit" style="text-align: left;margin: 10px 0"><input class=" text-white" style="border-radius:0; background-color:#2B2542;" type="submit"></div>-->
					<!--</div>-->
					{{--	
					<div class="product-detail mt-3">
						<ul class="about-ul">
							<li class="about-list"> <span><i class="fas fa-arrow-circle-right"></i></span>Available: <span>{{ $product->stock ? 'In Stock' : 'Out of Stock' }}</span></li>
							<li class="about-list"> <span><i class="fas fa-arrow-circle-right"></i></span>Stock: <span>{{ $product->stock }}</span></li>
							<!-- <li class="about-list"> <span><i class="fas fa-arrow-circle-right"></i></span> Category: <span>{{ $product->category }}</span></li> -->
							<li class="about-list"><span><i class="fas fa-arrow-circle-right"></i></span>Shipping Fee: <span>₹{{ $product->shipping_fee }}</span></li>
							<li class="about-list"> <span><i class="fas fa-arrow-circle-right"></i></span>Weight: <span>{{ $product->weight }} g</span></li>
							<li class="about-list"> <span><i class="fas fa-arrow-circle-right"></i></span>Size: <span>{{ $product->size }}</span></li>
						</ul>
					</div>
					--}}
					<!--				<div class="purchase-fixed-buttons" style="margin-bottom: 20px; flex-direction: column;">-->
					<!--    @if($product->current_stock)-->
					<!--        @if($product->add_timer && $product->timer_end_at)-->
					<!--            <div class="px-2 pb-2">-->
					<!--                <div class="countdown-timer" data-end-time="{{ \Carbon\Carbon::parse($product->timer_end_at)->timestamp }}">-->
					<!--                    ⏳ Offer starts in: <span class="time-remaining">--:--:--</span>-->
					<!--                </div>-->
					<!--            </div>-->
					<!--        @endif-->
					<!--        <form id="purchaseButtons" action="{{ route('cart.add') }}" method="POST">-->
					<!--            @csrf-->
					<!--            <div id="buyAddButtons" class="d-flex flex-md-column gap-2 buy_add_button" style="display: none;">-->
					<!--                <button type="submit" class="btn btn-sm btn-primary w-100">-->
					<!--                    Add to Cart <i class="fas fa-shopping-cart"></i>-->
					<!--                </button>-->
					<!--                <a href="{{ route('checkout.single', $product->id) }}" class="btn btn-sm btn-warning w-100 text-white">-->
					<!--                    BUY NOW <i class="fas fa-bolt"></i>-->
					<!--                </a>-->
					<!--            </div>-->
					<!--        </form>-->
					<!--    @endif-->
					<!--</div>-->
					<div id="prebookModal" class="modal-overlay">
						<div class="modal-box">
							<div class="modal-header">
								<h3>Pre-Book Product</h3>
								<button id="closePrebookModal" class="close-modal">&times;</button>
							</div>
							<div class="modal-body">
								<p>This item is currently out of stock. You can pre-book it now and we’ll notify you when it's available.</p>
								@auth
								<form action="{{ route('prebook.store', $product->id) }}" method="POST">
									@csrf
									<div class="mb-3">
										<label for="prebookQuantity">Quantity</label>
										<input type="number" id="prebookQuantity" name="quantity" min="1" value="1" required class="modal-input">
									</div>
									<div class="mb-3">
										<label for="prebookNote">Note (Optional)</label>
										<textarea id="prebookNote" name="note" rows="3" class="modal-input" placeholder="Any message or request..."></textarea>
									</div>
									<button type="submit" class="btn btn-success w-100">Confirm Pre-Booking</button>
								</form>
								@else
								<p class="text-danger">You must <a href="{{ route('login') }}">login</a> to pre-book this product.</p>
								@endauth
							</div>
						</div>
					</div>
					<div class="product_details_accordion_container mt-5">
						<div class="product_details_accordion_item">
							<div class="product_details_accordion_header" data-tab="tab1">
								<span>Description</span>
								<span class="accordion_icon">+</span>
							</div>
							<div id="tab1" class="product_details_accordion_content">
								<h4>{{ $product->productName }}</h4>
								<p>{{ $product->productDescription2 }}</p>
							</div>
						</div>
						<!--    <div class="product_details_accordion_item">-->
						<!--        <div class="product_details_accordion_header" data-tab="tab2">-->
						<!--            <span>Additional Information</span>-->
						<!--            <span class="accordion_icon">+</span>-->
						<!--        </div>-->
						<!--        <div id="tab2" class="product_details_accordion_content">-->
						<!--            <h4>Specifications</h4>-->
						<!--            <p><strong>Available Sizes:</strong>-->
						<!--     @if(count($validSizes))-->
						<!--            @foreach($validSizes as $size => $stock)-->
						<!--                         <span class="badge text-dark" style="font-size:15px">[{{ $size }}]</span>-->
						<!--            @endforeach-->
						<!--        @else-->
						<!--        <span class="badge  text-dark " style="font-size:20px">Universal</span>-->
						<!--    @endif-->
						<!--</p>        <p><strong>Available Weight:</strong> <span class="badge  text-dark" style="font-size:20px">{{ $product->weight * 1000}}g</span>-->
						<!--</p>        -->
						<!--        </div>-->
						<!--    </div>-->
						<!--<div class="product_details_accordion_item">-->
						<!--    <div class="product_details_accordion_header" data-tab="tab5">-->
						<!--        <span>Shipping Delivery</span>-->
						<!--        <span class="accordion_icon">+</span>-->
						<!--    </div>-->
						<!--    <div id="tab5" class="product_details_accordion_content">-->
						<!--        <h2>Shipping Delivery</h2>-->
						<!--        <p>This tab contains Shipping Delivery for the product.</p>-->
						<!--    </div>-->
						<!--</div>-->
						<div class="product_details_accordion_item">
							<div class="product_details_accordion_header" data-tab="tab6">
								<span>Return Policy </span>
								<span class="accordion_icon">+</span>
							</div>
							<div id="tab6" class="product_details_accordion_content">
								<ul style="  text-align: left;
									list-style: disc;
									font-size: 13px;
									}">
									<li>At Vedaro, each piece is handcrafted with precision and emotion — designed to be rare, meaningful, and truly one-of-a-kind.</li>
									<li>Due to the exclusive and limited nature of our collections, we do not offer returns or exchanges.</li>
									<li>However, in the rare case that a product arrives damaged during transit, we’re here to assist.</li>
									<li>
										To be eligible for a resolution:
										<ul>
											<li>You must share an unboxing video with clear proof of damage within 24 hours of delivery.</li>
											<li>The video should be continuous, from opening the outer packaging to revealing the product inside.</li>
											<li>Any claim without proper and complete video proof will not be entertained.</li>
										</ul>
									</li>
									<li>All final decisions regarding returns or replacements will be made by the Vedaro team.</li>
									<li>We reserve the right to accept or decline any request based on the verification of evidence provided.</li>
								</ul>
							</div>
						</div>
					</div>
					<style>
						.product_details_accordion_item .product_details_accordion_content ul li{
						list-style: disc;
						}
					</style>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<!--Suggested Products section-->

   
    @php
    use App\Models\Product;

    // Fetch up to 10 random products from the same category (excluding current product)
    $similarProducts = Product::where('category', $product->category)
        ->where('id', '!=', $product->id)
        ->inRandomOrder()
        ->take(10)
        ->get();
@endphp

@if($similarProducts->count() > 0)
<section class="mt-5">
    <div class="similar-products">
        <h4 class="mb-4 text-center">You Might Also Like</h4>

        <!-- Swiper Container -->
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @foreach($similarProducts as $similar)
                    <div class="swiper-slide" >
                        <div class="card shadow-sm border-0 h-100 d-flex w-auto">
                            <a href="{{  url('/product_details/' . urlencode($similar->productName)) }}">
                                <img src="{{ asset('storage/products/'.$similar->image1) }}"
                                     alt="{{ $similar->productName ?? 'Unnamed Product' }}" 
                                     class="card-img-top"
                                     style="height: 220px; object-fit: cover; border-radius: .5rem .5rem 0 0;">
                            </a>
                            <div class="card-body text-center">
                                <h6 class="card-title text-truncate">{{ $similar->productName ?? 'Unnamed Product' }}</h6>
                                <p class="card-text text-muted mb-2">
                                    ₹{{ isset($similar->price) ? number_format($similar->price, 2) : 'N/A' }}
                                </p>
                                <a href="{{ url('/product_details/' . urlencode($similar->productName)) }}" class="btn btn-outline-primary btn-sm">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Navigation buttons -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

            <!-- Pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
@endif

<style>
    .swiper-slide{
        width: auto!important;
    }
</style>

<!--Suggested Products section here-->



<section class="py-4  features-section">
  <div class="container">
    <div class="feature-row">

      <div class="d-flex align-items-center">
        <span class="feature-icon">
          <!-- SVG icon -->
         	<svg  fill="none" stroke="#6f42c1" stroke-width="1.5" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" d="M12 3l8 4v5c0 5.25-3.4 9.45-8 10-4.6-.55-8-4.75-8-10V7l8-4z" />
							<text x="9" y="15" font-size="6" fill="#6f42c1" font-family="Arial">6</text>
						</svg>
        </span>
        <span class="feature-label">6-Month Warranty</span>
      </div>

      <div class="d-flex align-items-center">
        <span class="feature-icon">
          <svg  viewBox="0 0 24 24" fill="none" stroke="#6f42c1" stroke-width="1.5"
							stroke-linecap="round" stroke-linejoin="round">
							<circle cx="12" cy="14" r="5" />
							<path d="M16 2l2 4 4 1-4 1-2 4-2-4-4-1 4-1 2-4z" />
						</svg>

        </span>
        <span class="feature-label">Lifetime Plating</span>
      </div>

      <div class="d-flex align-items-center">
        <span class="feature-icon">
         <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
							<circle cx="50" cy="50" r="45" stroke="#6f42c1" stroke-width="5" fill="none" />
							<text x="50%" y="50%" text-anchor="middle" fill="#6f42c1" font-size="28" font-family="Arial"
								dy=".3em">925</text>
						</svg>
        </span>
        <span class="feature-label">Fine 925 Silver</span>
      </div>

    </div>
  </div>
</section>


{{--FAQ Section --}}
<section class="faq-section py-5">
	<div class="container">
		<h2 class="text-center mb-5">Frequently Asked Questions</h2>
		<div class="accordion" id="faqAccordion">
			<!-- Q1 -->
			<div class="accordion-item mb-3 border-0">
				<h3 class="accordion-header" id="headingOne">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
						data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
					Why is Vedaro jewellery priced higher than regular silver jewellery?
					</button>
				</h3>
				<div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
					<div class="accordion-body">
						Each Vedaro piece is handcrafted using pure 925 silver and finished with exceptional detailing. We don’t mass produce — our collections are limited edition, and we work with skilled artisans to ensure every piece is a work of art. You're not just buying jewellery — you're investing in craftsmanship, purity, and timeless design.
					</div>
				</div>
			</div>
			<!-- Q2 -->
			<div class="accordion-item mb-3 border-0">
				<h3 class="accordion-header" id="headingTwo">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
						data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
					Is your jewellery made of pure silver?
					</button>
				</h3>
				<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
					<div class="accordion-body">
						Yes. All our pieces are crafted from hallmarked 925 sterling silver — the highest grade used in fine jewellery — and come with a purity certificate.
					</div>
				</div>
			</div>
			<!-- Q3 -->
			<div class="accordion-item mb-3 border-0">
				<h3 class="accordion-header" id="headingThree">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
						data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
					What makes Vedaro different from other silver brands?
					</button>
				</h3>
				<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
					<div class="accordion-body">
						Vedaro blends spirituality, luxury, and limited-edition craftsmanship. We focus on creating rare, meaningful designs — each piece tells a story. We do not follow trends, we create timeless symbols of emotion, tradition, and elegance.
					</div>
				</div>
			</div>
			<!-- Q4 -->
			<div class="accordion-item mb-3 border-0">
				<h3 class="accordion-header" id="headingFour">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
						data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
					Why don’t you offer heavy discounts?
					</button>
				</h3>
				<div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
					<div class="accordion-body">
						Vedaro is a premium brand built on value and quality, not markdowns. We price our jewellery honestly from the beginning — ensuring fair pay to artisans and unmatched quality to our customers. Our products hold their worth.
					</div>
				</div>
			</div>
			<!-- Q5 -->
			<div class="accordion-item mb-3 border-0">
				<h3 class="accordion-header" id="headingFive">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
						data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
					Do you offer customization or personalization?
					</button>
				</h3>
				<div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
					<div class="accordion-body">
						Currently, we offer limited customization options for select pieces. If you're looking for something specific, reach out to us — we love creating meaningful pieces when possible.
					</div>
				</div>
			</div>
			<!-- Q6 -->
			<div class="accordion-item mb-3 border-0">
				<h3 class="accordion-header" id="headingSix">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
						data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
					Can I return or exchange my order if I change my mind?
					</button>
				</h3>
				<div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
					<div class="accordion-body">
						Since every Vedaro piece is handcrafted and made in limited quantities, we do not accept returns or exchanges for change of mind.
						<br><br>
						However, if your product arrives damaged, we’re here to help — but we require an unboxing video and clear photo evidence shared with us within 24 hours of delivery. This helps us maintain authenticity and ensure fair practices for all customers.
					</div>
				</div>
			</div>
			<!-- Q7 -->
			<div class="accordion-item mb-3 border-0">
				<h3 class="accordion-header" id="headingSeven">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
						data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
					Is Vedaro jewellery suitable for daily wear?
					</button>
				</h3>
				<div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#faqAccordion">
					<div class="accordion-body">
						Yes, many of our designs are crafted for durability and comfort. However, like all fine jewellery, proper care ensures longevity — avoid harsh chemicals, perfumes, and excessive moisture.
					</div>
				</div>
			</div>
			<!-- Q8 -->
			<div class="accordion-item mb-3 border-0">
				<h3 class="accordion-header" id="headingEight">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
						data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
					How many pieces are made in each design?
					</button>
				</h3>
				<div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#faqAccordion">
					<div class="accordion-body">
						Most Vedaro designs are part of a Limited Edition series, with only a few pieces ever made. Once sold out, they’re not restocked — making them rare and collectible.
					</div>
				</div>
			</div>
			<!-- Q9 -->
			<div class="accordion-item mb-3 border-0">
				<h3 class="accordion-header" id="headingNine">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
						data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
					Do you offer gift packaging?
					</button>
				</h3>
				<div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine" data-bs-parent="#faqAccordion">
					<div class="accordion-body">
						Absolutely. Every Vedaro order is delivered in luxury-ready packaging with a spiritual touch — perfect for gifting, with no extra charge.
					</div>
				</div>
			</div>
			<!-- Q10 -->
			<div class="accordion-item mb-3 border-0">
				<h3 class="accordion-header" id="headingTen">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
						data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
					Where are you based and do you ship internationally?
					</button>
				</h3>
				<div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen" data-bs-parent="#faqAccordion">
					<div class="accordion-body">
						We’re proudly based in India and ship worldwide. Wherever you are, a piece of Vedaro can reach you.
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Accordion Container -->
<div class="main_review_section">
	<div class="review-container">
		<div class="review-container1">
			<div class="product-reviews">
				<div class="product-reviews__info reviews-info">
					<div class=" d-flex justify-content-between">
						<div>
							<h2 class="reviews-info__title headline"> Customer reviews</h2>
							<p>{{ $totalReviews }} global ratings</p>
						</div>
						<div>
							<button id="showReviewForm" class="btn btn-outline-primary d-flex align-items-center gap-2 px-2">
							<i class="fas fa-star"></i> Rate Products
							</button>
						</div>
					</div>
					<div class="average-rating__stars">
						<div class="">
							@for ($i = 1; $i <= 5; $i++)
							@if ($i <= floor($averageRating))
							<span class="star filled">&#9733;</span> <!-- Filled Star -->
							@elseif ($i == ceil($averageRating) && $averageRating - floor($averageRating) > 0)
							<span class="star half">&#9733;</span> <!-- Half Star -->
							@else
							<span class="star">&#9734;</span> <!-- Empty Star -->
							@endif
							@endfor
						</div>
						<p>{{ number_format($averageRating, 1) }} out of 5 </p>
					</div>
					<span class="reviews-info__caption">
					<?php
						if ($totalReviews > 0) {
						    echo round(($ratingsCount[4] + $ratingsCount[5]) / $totalReviews * 100, 2) . "% Customers recommended this product";
						} else {
						    echo "No recommendations yet";
						}
						?>
					</span>
				</div>
				<div class="product-reviews__bar reviews-bar">
					<ul class="list-reset reviews-bar__list">
						@foreach(range(5, 1) as $star)
						<li class="reviews-bar__item">
							<div class="progress-bar">
								<span class="progress-bar__star">{{ $star }}</span>
								<div class="progress-bar__outter-line" data-rating="{{ $ratingsCount[$star] }}">
									<span class="progress-bar__inner-line progress-bar__inner-line--{{ ['excellent', 'good', 'normal', 'not-bad', 'bad'][$star - 1] }}"></span>
								</div>
								<span class="progress-bar__quantity">{{ $ratingsCount[$star] }}</span>
							</div>
						</li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
		<div class="review-container2">
			<h1 class="review-title">Rate and Review Product</h1>
			<form class="review-form" method="POST" action="{{ route('reviews.store') }}" enctype="multipart/form-data">
				@csrf
				<input type="hidden" id="product_id" name="product_id" class="review-input" value="{{ $product->id }}">
				<input type="hidden" id="user_id" name="user_id" class="review-input" value="{{ auth()->check() ? auth()->user()->id : '' }}">
				<!-- Star Rating -->
				<div class="review-form-group">
					<label for="rating" class="review-label">Your Rating:</label>
					<div class="star-rating">
						<input type="radio" id="5-stars" name="rating" value="5" />
						<label for="5-stars" class="star">&#9733;</label>
						<input type="radio" id="4-stars" name="rating" value="4" />
						<label for="4-stars" class="star">&#9733;</label>
						<input type="radio" id="3-stars" name="rating" value="3" />
						<label for="3-stars" class="star">&#9733;</label>
						<input type="radio" id="2-stars" name="rating" value="2" />
						<label for="2-stars" class="star">&#9733;</label>
						<input type="radio" id="1-star" name="rating" value="1" />
						<label for="1-star" class="star">&#9733;</label>
					</div>
				</div>
				<div class="review-form-group">
					<label for="review_title" class="review-label">Title:</label>
					<input type="text" id="review_title" name="review_title" class="review-input" placeholder="Write your title here..." >
				</div>
				<!-- Review Text -->
				<div class="review-form-group">
					<label for="review" class="review-label">Your Review:</label>
					<textarea id="review" name="review" class="review-textarea" placeholder="Write your review here..." required></textarea>
				</div>
				<!-- Name -->
				<div class="review-form-group">
					<label for="name" class="review-label">Your Name:</label>
					<input type="text" id="name" name="name" class="review-input" value="{{ auth()->check() ? auth()->user()->first_name : '' }} {{ auth()->check() ? auth()->user()->last_name : '' }}">
				</div>
				<!-- Image Upload -->
				<div class="review-form-group">
					<label for="image" class="review-label">Upload Image:</label>
					<input type="file" id="image" name="image" class="review-input">
				</div>
				<!-- Submit Button -->
				<div>
					<button type="submit" class="review-btn">Submit Review</button>
				</div>
			</form>
		</div>
	</div>
	<div class="fetched_rewiews_cont">
		<div>
			<div class="container grid">
				<div class="product-reviews">
					<!-- Reviews with Images Section -->
					<div class="reviews-with-images">
						<h3>Reviews with Images</h3>
						<div class="reviews-images-grid">
							@foreach($reviews as $review)
							@if($review->image)
							<div class="review-image" data-review="{{ json_encode($review) }}">
								<img src="{{ asset('storage/products/' . $review->image) }}" alt="Review Image">
							</div>
							@endif
							@endforeach
						</div>
					</div>
				</div>
			</div>
			<!-- Popup Modal for Review Details -->
			<div id="reviewModal" class="modal" style="display: none;">
				<div class="modal-content">
					<span class="close-btn">&times;</span>
					<div class="review-details">
						<h3 class="review-title"></h3>
						<p class="review-text"></p>
						<p class="review-rating">Rating: <span class="rating-stars"></span></p>
						<div class="review-image">
							<img src="" alt="Review Image" class="modal-review-image">
						</div>
					</div>
				</div>
			</div>
		</div>
		<h3>Product Reviews</h3>
		@foreach ($reviews as $review)
		<div class="review">
			<div class="user-info">
				@if($review->user && $review->user->profile_image)
				<img src="{{ asset('storage/products/' . $review->user->profile_image) }}" alt="User Image" class="user-image" />
				@else
				<img src="{{ asset('images/default-avatar.jpg') }}" alt="Default Image" class="user-image" />
				@endif
				<span class="user-name">{{ $review->name ?: $review->user->name }}</span>
			</div>
			<div class="rat_title">
				<div class="rating">
					@for ($i = 1; $i <= 5; $i++)
					<span class="star {{ $i <= $review->rating ? 'filled' : '' }}">★</span>
					@endfor
				</div>
				<span class="rating_title">{{ $review->review_title }}</span>
			</div>
			<!-- Display the review text -->
			<p>{{ $review->review }}</p>
			<div class="rating_product_img">
				@if(!empty($review->image))
				<img src="{{ asset('storage/products/' . $review->image) }}" alt="User Image" class="" />
				@endif
				<!--<img src="{{ asset('storage/products/' . $review->image) }}" alt="User Image" class="" />-->
			</div>
		</div>
		@endforeach
	</div>
</div>
<script src="https://unpkg.com/scrollreveal"></script>
<script href="{{ asset('assets/js/product_details.js') }}"></script>
<script>
	document.addEventListener("DOMContentLoaded", function () {
	    const button = document.getElementById("showReviewForm");
	    const reviewForm = document.querySelector(".review-container2");
	
	    button.addEventListener("click", function () {
	        if (reviewForm.style.display === "none" || reviewForm.style.display === "") {
	            reviewForm.style.display = "block";
	            reviewForm.scrollIntoView({ behavior: "smooth" });
	        } else {
	            reviewForm.style.display = "none";
	        }
	    });
	});
	// ----------------------product details image slider----------------------------
	const imgs = document.querySelectorAll('.img-select a');
	const imgBtns = [...imgs];
	let imgId = 1;
	
	imgBtns.forEach((imgItem) => {
	imgItem.addEventListener('click', (event) => {
	event.preventDefault();
	imgId = imgItem.dataset.id;
	slideImage();
	});
	});
	
	function slideImage() {
	const displayWidth = document.querySelector('.img-showcase img:first-child').clientWidth;
	
	document.querySelector('.img-showcase').style.transform = `translateX(${- (imgId - 1) * displayWidth}px)`;
	}
	
	window.addEventListener('resize', slideImage);
	
	
	
	// 	------------------------------------
	
	 const bars = document.querySelectorAll('.progress-bar__outter-line');
	   const COUNT_STARS = {{ $totalReviews }};
	
	   bars.forEach(el => {
	       let rating = el.dataset.rating;
	       let percent = (100 * rating) / COUNT_STARS;
	       el.querySelector('.progress-bar__inner-line').style.width = `${percent}%`;
	   });
	
	   ScrollReveal().reveal('.headline');
	// 	--------------------------------------------------
	
	$(document).ready(function () {
	   const modal = $('#reviewModal');
	   const modalTitle = modal.find('.review-title');
	   const modalText = modal.find('.review-text');
	   const modalRating = modal.find('.rating-stars');
	   const modalImage = modal.find('.modal-review-image');
	   const closeModal = modal.find('.close-btn');
	
	   $('.review-image').on('click', function () {
	       const reviewData = $(this).data('review');  // Use jQuery's .data() to get the JSON object
	
	       modalTitle.text(reviewData.review_title || 'No Title');
	       modalText.text(reviewData.review || 'No review text available.');
	       modalRating.html('★'.repeat(reviewData.rating) + '☆'.repeat(5 - reviewData.rating));
	       modalImage.attr('src', '/storage/products/' + reviewData.image);
	
	       modal.show();
	   });
	
	   closeModal.on('click', function () {
	       modal.hide();
	   });
	   $(window).on('click', function (e) {
	       if ($(e.target).is(modal)) {
	           modal.hide();
	       }
	   });
	});
	
	
	document.addEventListener("DOMContentLoaded", function () {
	const timerEl = document.querySelector('.countdown-timer');
	const buttonsEl = document.getElementById('purchaseButtons');
	const buttonsby = document.getElementById('buyButtons');
	const footer = document.getElementById('footer');
	
	if (buttonsEl) {
		buttonsEl.style.display = 'none';
		buttonsby.style.display = 'none';
		buttonsEl.style.opacity = '0';
		buttonsby.style.opacity = '0';
	}
	
	let timerEnded = false;
	
	function showButtons() {
		if (buttonsEl) {
			buttonsEl.style.display = 'flex';
			buttonsEl.style.opacity = '1';
			buttonsEl.style.pointerEvents = 'auto';
			buttonsby.style.display = 'flex';
			buttonsby.style.opacity = '1';
			buttonsby.style.pointerEvents = 'auto';
		}
	}
	
	function hideButtons() {
		if (buttonsEl) {
			buttonsEl.style.opacity = '0';
			buttonsEl.style.pointerEvents = 'none';
		}
	}
	
	let footerObserver;
	function startFooterObserver() {
		if (!footer || !buttonsEl) return;
	
		footerObserver = new IntersectionObserver((entries) => {
			entries.forEach(entry => {
				if (entry.isIntersecting) {
					hideButtons();
				} else {
					showButtons();
				}
			});
		}, { threshold: 0 });
	
		footerObserver.observe(footer);
	}
	
	// Only execute timer logic if timer and buttons exist
	if (timerEl && buttonsEl) {
		const endTime = parseInt(timerEl.dataset.endTime);
	
		const updateTimer = () => {
			const now = Math.floor(Date.now() / 1000);
			const remaining = endTime - now;
	
			if (remaining <= 0) {
				timerEl.innerHTML = "🎉 Offer is now <strong>LIVE!</strong>";
				timerEnded = true;
				showButtons();
				startFooterObserver();
				clearInterval(interval);
				return;
			}
	
			const d = Math.floor(remaining / 86400);
			const h = Math.floor((remaining % 86400) / 3600);
			const m = Math.floor((remaining % 3600) / 60);
			const s = remaining % 60;
	
			timerEl.querySelector('.time-remaining').textContent =
				`${d > 0 ? d + 'd ' : ''}${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
		};
	
		updateTimer();
		const interval = setInterval(updateTimer, 1000);
	} else if (buttonsEl) {
		showButtons();
		startFooterObserver();
	}
	});
	
	
	
	
	
	document.addEventListener('DOMContentLoaded', function () {
	   const openBtn = document.getElementById('openPrebookModal');
	   const modal = document.getElementById('prebookModal');
	   const closeBtn = document.getElementById('closePrebookModal');
	
	   if (!modal) {
	       console.warn("Modal not found.");
	       return;
	   }
	
	   const openModal = () => {
	       modal.style.display = 'flex';
	       document.body.classList.add('modal-open');
	       setTimeout(() => {
	           const input = document.getElementById('prebookEmail');
	           if (input) input.focus();
	       }, 100);
	   };
	
	   const closeModal = () => {
	       modal.style.display = 'none';
	       document.body.classList.remove('modal-open');
	   };
	
	   // Open modal
	   if (openBtn) {
	       openBtn.addEventListener('click', function (e) {
	           e.preventDefault();
	           e.stopPropagation();
	           openModal();
	       });
	   }
	
	   // Close modal on close button click
	   if (closeBtn) {
	       closeBtn.addEventListener('click', function (e) {
	           e.preventDefault();
	           e.stopPropagation();
	           closeModal();
	       });
	   }
	
	   // Close modal when clicking outside the modal-box
	   window.addEventListener('click', function (e) {
	       if (e.target === modal) {
	           closeModal();
	       }
	   });
	
	   // Close modal on Escape key
	   document.addEventListener('keydown', function (e) {
	       if (e.key === 'Escape') {
	           closeModal();
	       }
	   });
	});
	
	
	
	
	
</script>
<script>
	document.addEventListener('DOMContentLoaded', function () {
	    const headers = document.querySelectorAll('.product_details_accordion_header');
	
	    headers.forEach(header => {
	        header.addEventListener('click', () => {
	            const tabId = header.getAttribute('data-tab');
	            const content = document.getElementById(tabId);
	            const icon = header.querySelector('.accordion_icon');
	
	            // Toggle current item
	            const isOpen = content.classList.contains('show');
	
	            if (isOpen) {
	                content.classList.remove('show');
	                icon.textContent = '+';
	            } else {
	                // Close all other items
	                document.querySelectorAll('.product_details_accordion_content').forEach(c => {
	                    c.classList.remove('show');
	                });
	                document.querySelectorAll('.accordion_icon').forEach(i => {
	                    i.textContent = '+';
	                });
	
	                // Open current item
	                content.classList.add('show');
	                icon.textContent = '−';
	            }
	        });
	    });
	});
</script>
<!--Main timer-container-->
<script>
	function updateCountdownTimers() {
	    const now = new Date().getTime();
	
	    document.querySelectorAll('.timer-container').forEach(timer => {
	        const endTimeAttr = timer.dataset.endTime;
	        if (!endTimeAttr) return; // Skip if no time
	        const endTime = parseInt(endTimeAttr) * 1000;
	
	        if (isNaN(endTime)) return;
	
	        const distance = endTime - now;
	
	        if (distance <= 0) {
	            timer.innerHTML = '<div class="text-success  font-bold py-2">NOW AVAILABLE </div>';
	            return;
	        }
	
	        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
	        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
	        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
	        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
	
	        timer.querySelector('.days').textContent = String(days).padStart(2, '0');
	        timer.querySelector('.hours').textContent = String(hours).padStart(2, '0');
	        timer.querySelector('.minutes').textContent = String(minutes).padStart(2, '0');
	        timer.querySelector('.seconds').textContent = String(seconds).padStart(2, '0');
	    });
	}
	
	// Run immediately and repeat every second
	updateCountdownTimers();
	setInterval(updateCountdownTimers, 1000);
</script>
<!--Add to Cart and Update Add to Cart Button-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
	$(document).on('submit', '#purchaseButtons', function(e) {
	    e.preventDefault();
	
	    let form = $(this);
	    let formData = form.serialize();
	
	    $.ajax({
	        type: "POST",
	        url: form.attr('action'),
	        data: formData,
	        success: function(response) {
	            Swal.fire({
	                icon: 'success',
	                title: 'Added!',
	                text: response.message,
	                timer: 1500,
	                showConfirmButton: false
	            });
	
	            // 🔁 Now fetch the new cart count via AJAX
	            updateCartCount();
	        },
	        error: function(xhr) {
	            Swal.fire({
	                icon: 'error',
	                title: 'Oops...',
	                text: xhr.responseJSON.message ?? 'Something went wrong!',
	            });
	        }
	    });
	});
	
	// 🔄 This function updates the cart count without page reload
	function updateCartCount() {
	    $.ajax({
	        url: "{{ route('cart.count') }}",
	        type: "GET",
	        success: function(data) {
	            $('#cart-count').text(data.count);
	        }
	    });
	}
</script>
<!--script for the update weight in db-->
<script>
	document.addEventListener('DOMContentLoaded', function() {
	const weightRadios = document.querySelectorAll('.weight-option-input');
	
	weightRadios.forEach(radio => {
	radio.addEventListener('change', function() {
	   const selectedWeight = this.value;
	   const productId = {{ $product->id ?? 'null' }};
	
	   if (!productId) return;
	
	   // Send AJAX request
	   fetch(`/products/${productId}/update-weight`, {
	       method: 'POST',
	       headers: {
	           'Content-Type': 'application/json',
	           'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
	       },
	       body: JSON.stringify({
	           weight: selectedWeight
	       })
	   })
	   .then(response => response.json())
	   .then(data => {
	       if (data.success) {
	           // Optional: Show success message
	           console.log('Weight updated successfully');
	       }
	   });
	});
	});
	});
</script>
<script>
	document.querySelectorAll('input[name="selected_size"]').forEach(function(input) {
	    input.addEventListener('change', function() {
	        const selectedSize = this.value;
	        const productId = {{ $product->id }};
	
	        fetch(`/product/update-size/${productId}`, {
	            method: 'POST',
	            headers: {
	                'Content-Type': 'application/json',
	                'X-CSRF-TOKEN': '{{ csrf_token() }}',
	            },
	            body: JSON.stringify({
	                size: selectedSize
	            }),
	        })
	        .then(response => response.json())
	        .then(data => {
	            if (data.success) {
	                console.log("Size updated successfully.");
	            } else {
	                alert("Failed to update size.");
	            }
	        })
	        .catch(error => {
	            console.error('Error:', error);
	            alert("Something went wrong.");
	        });
	    });
	});
</script>
<script>
	document.querySelectorAll('.size-option-input').forEach(function (input) {
	    input.addEventListener('change', function () {
	        document.getElementById('selectedSize').value = this.value;
	    });
	});
</script>


<!--suggested product section script  -->
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 7, // default for very large screens
        spaceBetween: 20,
        loop: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            0:    { slidesPerView: 3 },
            576:  { slidesPerView: 5 },
            768:  { slidesPerView: 5 },
            992:  { slidesPerView: 6 },
            1200: { slidesPerView: 7 } // ✅ explicitly 7 slides on large screens
        }
    });
</script>



@endsection