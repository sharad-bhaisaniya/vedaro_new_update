@extends('layouts.main')
@section('title', 'Product-details')
@section('content')
<link rel="stylesheet" href="{{ asset('public/assets/css/product_details.css') }}">

<div class="product_details pt-5"style="margin-top: 40px;">
<!-- <div class="sect_head">
	<h3 style="font-size: 3.5rem;">🛍️ Product Details</h3>
	<p>Review your selected items before completing the order.</p>
	</div> -->
	
	<style>
	
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
                    margin: 1.5rem 0;
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
                    margin: 1.5rem 0;
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
                    margin-bottom: 4px;
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
						<span>₹{{ $product->discountPrice }} </span>
						<span>
					<p class="last-price"><span>₹{{ $product->price }}</span></p>
					</span>
					</p>
				</div>
				<p class="product_disc">{{ $product->productDescription1 }}</p>
				<div style="width: 90%; margin: 0 auto">
				    
				    <div class="size-selector-container">
    <h4 class="size-selector-title">Select Size Option</h4>

    <input type="hidden" name="size" id="selectedSize" value="{{ old('size', $product->size ?? '') }}">

    <div class="size-options-grid">
        <!-- Default size option -->
        <div class="size-option-card">
            <input type="radio" name="selected_size" 
                   id="defaultSize" value="{{ old('size', $product->size ?? '') }}" 
                   class="size-option-input" checked>
            <label for="defaultSize" class="size-option-label">
                <span class="size-value">{{ old('size', $product->size ?? '') }}</span>
                <!--<span class="size-badge">Default</span>-->
            </label>
        </div>

        <!-- Multiple size options -->
        @if(isset($product) && $product->multiple_sizes)
            @foreach(json_decode($product->multiple_sizes) as $index => $size)
                <div class="size-option-card">
                    <input type="radio" name="selected_size" 
                           id="size{{ $index }}" value="{{ $size }}"
                           class="size-option-input">
                    <label for="size{{ $index }}" class="size-option-label">
                        <span class="size-value">{{ $size }}</span>
                        <!--@if($loop->first)-->
                        <!--    <span class="size-badge popular">Popular</span>-->
                        <!--@endif-->
                    </label>
                </div>
            @endforeach
        @endif
    </div>
</div>

					<div class="product-variants">
					    
					   

					
					<div class="weight-selector-container">
    <h4 class="weight-selector-title">Select Weight Option</h4>
    
    <input type="hidden" name="weight" id="selectedWeight" value="{{ old('weight', $product->weight ?? '') }}">

<div class="weight-options-grid">
    <!-- Default weight option -->
    <div class="weight-option-card">
        <input type="radio" name="selected_weight" 
               id="defaultWeight" value="{{ old('weight', $product->weight ?? '') }}" 
               class="weight-option-input" checked>
        <label for="defaultWeight" class="weight-option-label">
            <span class="weight-value">{{ old('weight', $product->weight ?? '') }}g</span>
            <span class="weight-badge">Default</span>
        </label>
    </div>
    
    <!-- Multiple weight options -->
    @if(isset($product) && $product->multiple_weights)
        @foreach(json_decode($product->multiple_weights) as $index => $weight)
            <div class="weight-option-card">
                <input type="radio" name="selected_weight" 
                       id="weight{{ $index }}" value="{{ $weight }}"
                       class="weight-option-input">
                <label for="weight{{ $index }}" class="weight-option-label">
                    <span class="weight-value">{{ $weight }}g</span>
                    @if($loop->first)
                        <span class="weight-badge popular">Popular</span>
                    @endif
                </label>
            </div>
        @endforeach
    @endif
</div>
</div>


					
						
					
					</div>
				
                    
                    @if($product->stock > 0)
                        {{-- Show Timer if enabled --}}
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
                    
                        {{-- Button Group --}}
                        <div class="d-flex gap-3 mt-3">
                            <form id="purchaseButtons" action="{{ route('cart.add') }}" method="POST" class="w-100">
                                @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="product_qty" value="1">
                        <button class="btn btn-outline-primary btn-lg px-4 w-100">
                            🛒 Add to Cart
                        </button>
                    </form>
                    <a href="{{ route('checkout.single', $product->id) }}" id="buyButtons" class="w-100">
                        <button class="btn btn-outline-primary btn-lg px-4 w-100">
                            ⚡ Buy Now
                        </button>
                    </a>
                </div>
                @else
                    {{-- Out of Stock Label --}}
                <div class="mt-4 text-center out" style="cursor:pointer;">
                  <p class="btn-shine bg-dark " target="_blank" id="openPrebookModal">
                    <i class="fas fa-box-open"></i> This product is out of stock — Go and check Pre-Book the order
                  </p>
                </div>
            @endif




					<div class="add_note_form">
						<div class="form-group" style="width: 100%;">
							<input type="text" id="note" name="note" placeholder="Add a note for this product" style="padding:5px; width: 100%;border: none; border-bottom: 1px solid #ccc; border-radius: 0;">
						</div>
						<div class="note_submit" style="text-align: left;margin: 10px 0"><input class=" text-white" style="border-radius:0; background-color:#2B2542;" type="submit"></div>
					</div>
				{{--	<div class="product-detail">
						<ul class="about-ul">
							<li class="about-list"> <span><i class="fas fa-arrow-circle-right"></i></span>Available: <span>{{ $product->stock ? 'In Stock' : 'Out of Stock' }}</span></li>
							<li class="about-list"> <span><i class="fas fa-arrow-circle-right"></i></span>Stock: <span>{{ $product->stock }}</span></li>
							<!-- <li class="about-list"> <span><i class="fas fa-arrow-circle-right"></i></span> Category: <span>{{ $product->category }}</span></li> -->
							<li class="about-list"><span><i class="fas fa-arrow-circle-right"></i></span>Shipping Fee: <span>₹{{ $product->shipping_fee }}</span></li>
							<li class="about-list"> <span><i class="fas fa-arrow-circle-right"></i></span>Weight: <span>{{ $product->weight }} g</span></li>
							<li class="about-list"> <span><i class="fas fa-arrow-circle-right"></i></span>Size: <span>{{ $product->size }}</span></li>
						</ul>
					</div>--}}
					<!--	<form action="{{ route('cart.add') }}" method="POST">-->
					<!--	@csrf-->
					<!--	<div class="purchase-info-buttons">-->
					<!-- <span>Quantity</span> -->
					<!--		<div class="purchase-info">-->
					<!-- <input type="number" name="product_qty" min="1" value="1">
						<!--			<input type="hidden" name="product_id" value="{{ $product->id }}"> -->
					<!--			<button type="submit" class="btn add_to_cart">-->
					<!--			Add to Cart <i class="fas fa-shopping-cart"></i>-->
					<!--			</button>-->
					<!--		</div>-->
					<!--                    <a href="{{ route('checkout.single', $product->id) }}" class="sr-headless-checkout">-->
					<!--                     	<div class="sr-d-flex flex-center full-width">-->
					<!--                     		<span class="sr-checkout-visible2">BUY NOW <i class="fas fa-bolt mr-2"></i></span>-->
					<!--                   		</div>-->
					<!--                    </a>-->
					<!--	</div>-->
					<!--</form>-->
					
					
					
					<div class="purchase-fixed-buttons" style="margin-bottom: 20px;flex-direction: column;">
						@if($product->stock)
						@if($product->add_timer && $product->timer_end_at)
						<div class="px-2 pb-2">
							<div class="countdown-timer" data-end-time="{{ \Carbon\Carbon::parse($product->timer_end_at)->timestamp }}">
								⏳ Offer starts in: <span class="time-remaining">--:--:--</span>
							</div>
						</div>
						@endif
						<form id="purchaseButtons" action="{{ route('cart.add') }}" method="POST">
							@csrf
							<div class="d-flex flex-md-column gap-2 buy_add_button">
								<button type="submit" class="btn btn-sm btn-primary w-100">
								Add to Cart <i class="fas fa-shopping-cart"></i>
								</button>
								<a href="{{ route('checkout.single', $product->id) }}" class="btn btn-sm btn-warning w-100 text-white">
								BUY NOW <i class="fas fa-bolt"></i>
								</a>
							</div>
						</form>
						@else
					
                    

                            <!--show fixed pre-Book Button -->
                            <!--<div class="prebook-button-wrapper position-relative">-->
                            <!--    <button type="button" id="openPrebookModal" class="black-prebook-btn">-->
                            <!--        Pre-Book Now <i class="fas fa-calendar-check"></i>-->
                                    <!-- Bubble particles -->
                            <!--        <span class="bubble" style="width: 8px; height: 8px; bottom: 10px; left: 10%; animation-delay: 0s;"></span>-->
                            <!--        <span class="bubble" style="width: 6px; height: 6px; bottom: 10px; left: 30%; animation-delay: 0.2s;"></span>-->
                            <!--        <span class="bubble" style="width: 10px; height: 10px; bottom: 10px; left: 60%; animation-delay: 0.4s;"></span>-->
                            <!--        <span class="bubble" style="width: 7px; height: 7px; bottom: 10px; left: 80%; animation-delay: 0.1s;"></span>-->
                            <!--        <span class="bubble" style="width: 5px; height: 5px; bottom: 10px; left: 50%; animation-delay: 0.3s;"></span>-->
                            <!--    </button>-->
                            <!--</div>-->

                        
						@endif
					</div>
					
					
					
					
				
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

					
					
				<div class="product_details_accordion_container">
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
    <div class="product_details_accordion_item">
        <div class="product_details_accordion_header" data-tab="tab2">
            <span>Additional Information</span>
            <span class="accordion_icon">+</span>
        </div>
        <div id="tab2" class="product_details_accordion_content">
            <h4>Specifications</h4>
            <p>{{ $product->size }}</p>
            <p>{{ $product->weight }}</p>
        </div>
    </div>
    <div class="product_details_accordion_item">
        <div class="product_details_accordion_header" data-tab="tab5">
            <span>Shipping Delivery</span>
            <span class="accordion_icon">+</span>
        </div>
        <div id="tab5" class="product_details_accordion_content">
            <h2>Shipping Delivery</h2>
            <p>This tab contains Shipping Delivery for the product.</p>
        </div>
    </div>
</div>



				</div>
			</div>
		</div>
	</div>
</div>
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
								<img src="{{ asset('public/storage/products/' . $review->image) }}" alt="Review Image">
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
				<img src="{{ asset('public/storage/products/' . $review->user->profile_image) }}" alt="User Image" class="user-image" />
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
				<img src="{{ asset('public/storage/products/' . $review->image) }}" alt="User Image" class="" />
				@endif
				<!--<img src="{{ asset('public/storage/products/' . $review->image) }}" alt="User Image" class="" />-->
			</div>
		</div>
		@endforeach
	</div>
</div>



<script src="https://unpkg.com/scrollreveal"></script>
<script href="{{ asset('public/assets/js/product_details.js') }}"></script>
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


@endsection