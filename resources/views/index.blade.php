@extends('layouts.main')
@section('title', 'Home')
<!-- Slick Carousel CSS -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
@section('content')
<div class="main_banner">
	<div class="main_banner_content">
		<a href="/shop" class="shop_now_btn">Shop Now</a>
	</div>
</div>
<div class="container">
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
	<div class="nature_section">
		<div class="center_wr">
			<div class="nature_sect_head">
				<h5 style="color:#ee2e7a;">Browse through our wide range of spiritual and gifting categories</h5>
				<h2>Explore Categories</h2>
			</div>
			<div class="pro_upper_sect">
				<div class="product_card">
					<a style="color: #000;" href="/shop" class="product-link">
					<img src="{{ asset('public/assets/images/1.png') }}" class="img-fluid" alt="Product 1">
					<a href="/shop"  class="main_button">Shop Now</a>
					</a>
				</div>
				<div class="product_card">
					<a style="color: #000;" href="/shop" class="product-link">
					<img src="{{ asset('public/assets/images/2.png') }}"  class="img-fluid" alt="Product 2">
					<a href="/shop"  class="main_button">Shop Now</a>
					</a>
				</div>
				<div class="product_card">
					<a style="color: #000;" href="/shop" class="product-link">
					<img src="{{ asset('public/assets/images/3.png') }}"  class="img-fluid" alt="Product 3">
					<a href="/shop"  class="main_button">Shop Now</a>
					</a>
				</div>
			</div>
		</div>
	</div>
	<section class="latest_section">
		<div class="center_wr">
			<h5>Shop Spiritual Essentials</h5>
			<h2>Gifts That Bless Every Occasion</h2>
			<div class="product_wrapper slick-slider">
				@foreach ($products as $product)
				@php
				$reviews = $product->reviews;
				$totalReviews = $reviews ? $reviews->count() : 0;
				$averageRating = $totalReviews > 0 ? $reviews->sum('rating') / $totalReviews : 0;
				@endphp
				<div class="product-slide">
					<a href="/product_details/{{ $product->id }}">
						<div class="product-card">
							@if ($product->on_sell)
							<p class="sale_tag">SALE</p>
							@endif
							<div class="image-container">
								<img src="{{ asset('public/storage/products/' . $product->image1) }}" alt="{{ $product->productName }}" class="default-image">
								<img src="{{ asset('public/storage/products/' . $product->image2) }}" alt="{{ $product->productName }} Hover" class="hover-image">
							</div>
							<div class="product-info">
								<div class="rating">
									@for ($i = 1; $i <= 5; $i++)
									@if ($i <= floor($averageRating))
									<span class="star filled">&#9733;</span>
									@elseif ($i == ceil($averageRating) && $averageRating - floor($averageRating) > 0)
									<span class="star half">&#9733;</span>
									@else
									<span class="star">&#9734;</span>
									@endif
									@endfor
									<span class="rating_nu">{{ number_format($averageRating, 1) }} ({{ $totalReviews }})</span>
								</div>
								<h3 class="product_name_desk">{{ $product->productName }}</h3>
								<h3 class="product_name_resp">{{ \Illuminate\Support\Str::limit($product->productName, 10) }}</h3>
								<div class="price_di dis_fl">
									@if ($product->discountPrice)
									<p class="dis_price">₹{{ $product->discountPrice }}</p>
									@endif
									<p class="main_price">₹{{ $product->price }}</p>
								</div>
							</div>
							<div class="button-container">
								<button class="btn add-to-cart-btn" data-product-id="{{ $product->id }}">
								<i class="fa fa-shopping-cart"></i> <span class="btn-text">Add to Cart</span>
								</button>
								<button class="btn add-to-wishlist-btn" data-product-id="{{ $product->id }}">
								<i class="fas fa-cart-plus"></i> <span class="btn-text">Buy Now</span>
								</button>
							</div>
						</div>
					</a>
				</div>
				@endforeach
			</div>
			<div class="pagination">
				<!-- Pagination -->
			</div>
		</div>
	</section>
	<div class="touch_section">
		<div class="center_wr">
			<div class="touch_inner dis_fl">
				<div class="touch_inner_first">
					<!--<img src="../assets/images/Untitled_img.png" alt="">-->
				</div>
			</div>
		</div>
	</div>
</div>
<section class="traditional_section" style="background-color: rgba(246, 224, 221, 0.5);" >
	<div class="center_wr">
		<div class="dis_fl" >
			<div class="traditional_inner_cont">
				<h5>Welcome to the Divine World of Mahakaaal Creations</h5>
				<h3>Your one-stop Online Destination</h3>
				<h6>for <strong>spiritual products</strong>, <strong>authentic puja samagri</strong>, and <strong>Hindu puja accessories</strong>. We specialize in offering high-quality, spiritual healing products online that are designed to enhance your spiritual journey and deepen your connection with the divine. Our products are carefully curated to bring the blessings of Mahakaal into your home.</h6>
				<div class="hover-container">
					<p class="starts_from">Starts from just &#x20B9 999</p>
					<a href="#" class="view-details">View Details</a>
				</div>
			</div>
			<div class="traditional_inner_img">
				<img src="{{ asset('public/assets/images/onestop.png') }}" alt="">
			</div>
		</div>
		<div class="dis_fl">
			<div class="traditional_inner_img">
				<img src="{{ asset('public/assets/images/shiva_honoring.png') }}" alt="">
			</div>
			<div class="traditional_inner_cont">
				<h5>Revered as the Supreme Deity in Hinduism</h5>
				<h3>Honoring the divinity of Mahakaal, or Mahakal</h3>
				<h6>Our mission is to provide a thoughtfully curated selection of spiritual gifts, gods’ idols, and pocket temples to enrich your spiritual practices. From Mahashivratri puja essentials to items inspired by Mahakal Ujjain, we bring you authentic products that infuse sacred energy into your life. Whether you're seeking to celebrate the glory of Mahakaal or searching for the perfect gift to share divine blessings, Mahakaaal Creations is your trusted destination for all things spiritual.</h6>
				<div class="hover-container">
					<!--<p class="starts_from">Starts from $35.00</p>-->
					<a href="#" class="view-details">View Details</a>
				</div>
			</div>
		</div>
		<div class="dis_fl">
			<div class="traditional_inner_cont">
				<h5>Why Choose Mahakaal Creations</h5>
				<h3>we are committed</h3>
				<h6>to delivering authentic spiritual products with exceptional customer service. Whether you are performing Mahashivratri puja or other sacred rituals, our products are designed to help you create a spiritual environment that nurtures peace, prosperity, and devotion. We ensure that every item is sourced with integrity, maintaining the highest standards of authenticity.</h6>
				<div class="hover-container">
					<!--<p class="starts_from">Starts from $35.00</p>-->
					<a href="#" class="view-details">View Details</a>
				</div>
			</div>
			<div class="traditional_inner_img">
				<img src="{{ asset('public/assets/images/chandi.png') }}" alt="">
			</div>
		</div>
	</div>
</section>
<section class="organic_section">
	<div class="center_wr">
		<div class="wi_ce">
			<h5>Explore our</h5>
			<h2> <span>Vast Range </span> of products</h2>
			<p class="inline-bullets">
				<span>• Puja Samagri Online</span>
				<span>• Spiritual Healing Products</span>
				<span>• Mahashivratri Essentials</span>
				<span>• Hindu Puja Accessories</span>
			</p>
			<style>
				.inline-bullets span {
				display: inline-block;
				margin-right: 10px;
				}
			</style>
			<button class="main_button">Explore Products</button>
		</div>
	</div>
</section>
</div>
<style>
	.main_banner {
	position: relative;
	}
	.main_banner::before {
	content: "";
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: rgba(0, 0, 0, 0.4); /* Dark overlay */
	z-index: 1;
	}
	.main_banner_content {
	position: relative;
	z-index: 2;
	}
	.shop_now_btn {
	display: inline-block;
	margin-top: 15px;
	padding: 12px 24px;
	background: #ff009c;
	color: white;
	font-size: 18px;
	text-decoration: none;
	border-radius: 50px;
	transition: 0.3s ease-in-out;
	width: 300px;
	}
	.shop_now_btn:hover {
	background: #b22d7e;
	}
	.success_msgs_home {
	position: fixed;
	background: #b83131;
	width: fit-content;
	color: #fff;
	z-index: 9999;
	text-align: center;
	padding: 10px;
	bottom: 10px;
	right: 10px;
	border-radius: 8px;
	display: none; /* Hidden by default */
	}
	.success_msgs_home h1 {
	font-size: 16px;
	}
	.success_msgs_home p {
	font-size: 13px;
	}
	.success_msgs_home p a {
	color: #2196F3;
	text-decoration: underline;
	}
	.close-btn {
	background: transparent;
	border: none;
	color: #fff;
	position: absolute;
	top: 2px;
	right: 10px;
	cursor: pointer;
	}
	.slick-slider {
	margin: 20px 0;
	}
	.slick-slide {
	/*padding: 10px;*/
	}
	.product-card {
	border: 1px solid #ddd;
	text-align: center;
	background-color: #fff;
	box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
	}
	.slick-dots li button::before {
	color: #333; /* Pagination dots color */
	}
	.slick-prev,
	.slick-next {
	background-color: rgba(0, 0, 0, 0.5);
	border-radius: 50%;
	color: white;
	}
	@media (max-width: 500px) {
	/* Show only the Buy Now text and hide icon */
	.add-to-wishlist-btn i {
	display: none; /* Hide the icon for Buy Now */
	}
	.add-to-wishlist-btn .btn-text {
	display: inline; /* Ensure Buy Now text is visible */
	}
	/* Show only the Add to Cart icon and hide text */
	.add-to-cart-btn i {
	display: inline; /* Show the icon for Add to Cart */
	}
	.add-to-cart-btn .btn-text {
	display: none; /* Hide the Add to Cart text */
	}
	/* Rest of your existing mobile styles for buttons */
	.product-card .button-container {
	padding: 0;
	border-top: none;
	bottom: 4px;
	display:none;
	}
	.product-card .btn {
	padding: 10px 15px;  /* Adjust padding for mobile */
	font-size: 14px;  /* Adjust font size */
	color: #ee2e7a;
	background: none !important;
	margin-right: 10px;
	display: flex;
	align-items: center;
	}
	.product-card .btn .fa,
	.product-card .btn .fas {
	font-size: 18px;  /* Adjust icon size */
	}
	.product-card .button-container {
	padding: 0;
	border-top: none;
	bottom: 4px;
	}
	}
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- jQuery (must load before Slick) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Slick Carousel JS -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script>
	$(document).ready(function () {
	 $('.slick-slider').slick({
	     slidesToShow: 4,
	     slidesToScroll: 1,
	     autoplay: true,
	     autoplaySpeed: 3000,
	     dots: true,
	     arrows: true,
	     responsive: [
	         {
	             breakpoint: 1024,
	             settings: {
	                 slidesToShow: 3,
	                 slidesToScroll: 1,
	             },
	         },
	         {
	             breakpoint: 768,
	             settings: {
	                 slidesToShow: 2,
	                 slidesToScroll: 1,
	             },
	         },
	         {
	             breakpoint: 480,
	             settings: {
	                 slidesToShow: 2,
	                 slidesToScroll: 1,
	             },
	         },
	     ],
	 });
	});
	
	
	 
	 
	 
	 
	 
	 
	 
	 
	$(document).ready(function () {
	 // Function to show the success message
	 function showSuccessMessage() {
	     $(".success_msgs_home").fadeIn(500); // Fade in over 500ms
	     // setTimeout(function () {
	     //     $(".success_msgs_home").fadeOut(500); // Fade out after 5 seconds
	     // }, 5000);
	 }
	
	 // Close the success message on button click
	 $(".close-btn").click(function () {
	     $(".success_msgs_home").fadeOut(500); // Fade out over 500ms
	 });
	
	 // Call the function to show the success message when needed
	 showSuccessMessage();
	});
	
	
	
	
	
	
	
	
	
	$(document).ready(function () {
	 $('.add-to-cart-btn,.add-to-wishlist-btn').on('click', function (e) {
	     e.preventDefault();
	
	     const productId = $(this).data('product-id');
	     const productQty = 1; // Default quantity for adding from the home page
	     const isWishlistButton = $(this).hasClass('add-to-wishlist-btn'); // Check if it's the wishlist button
	
	     $.ajax({
	         url: '/add-to-cart',
	         method: 'POST',
	         data: {
	             product_id: productId,
	             product_qty: productQty,
	             _token: $('meta[name="csrf-token"]').attr('content'),
	         },
	         success: function (response) {
	             if (response.success) {
	                 if (!isWishlistButton) {
	                     // Show SweetAlert only if it's not a wishlist button
	                     Swal.fire({
	                         title: 'Success!',
	                         text: response.message,
	                         icon: 'success',
	                         confirmButtonText: 'OK',
	                     }).then(() => {
	                         // Optional action after the SweetAlert
	                     });
	                 } else {
	                     // Redirect to the cart directly if it's a wishlist button
	                     window.location.href = '/cart'; // Replace '/cart' with your cart page URL if needed
	                 }
	
	                 updateCartCount(); // Update cart count in both cases
	             }
	         },
	         error: function () {
	             Swal.fire({
	                 title: 'Error!',
	                 text: 'Failed to add product to cart. Please try again.',
	                 icon: 'error',
	                 confirmButtonText: 'OK',
	             });
	         },
	     });
	 });
	});
	
	function updateCartCount() {
	 $.ajax({
	     url: '/cart/count',
	     method: 'GET',
	     success: function (response) {
	         if (response.cartCount !== undefined) {
	             $('#cart-count').text(response.cartCount);
	         }
	     },
	 });
	}
	
</script>
@endsection