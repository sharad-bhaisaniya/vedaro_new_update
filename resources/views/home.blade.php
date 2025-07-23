@extends('layouts.main')
@section('title', 'Home')
<!-- Slick Carousel CSS -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
<link rel="stylesheet" href="{{ asset('public/assets/css/home.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-...your-integrity..." crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
	.limited-content-overlay {
	position: absolute;
	top: 20px;
	left: 30px;
	background-color: rgba(0, 0, 0, 0.6);
	color: #fff;
	padding: 15px 20px;
	border-radius: 8px;
	z-index: 10;
	}
	.timer-text {
	font-size: 18px;
	font-weight: bold;
	color: #ffcc00;
	margin: 0 0 5px;
	}
	.product-name {
	font-size: 22px;
	font-weight: 600;
	margin: 0;
	}

	.timer-value {
	animation: pulse 1.2s infinite ease-in-out;
	}
	@keyframes pulse {
	0% { transform: scale(1); opacity: 1; }
	50% { transform: scale(1.1); opacity: 0.85; }
	100% { transform: scale(1); opacity: 1; }
	}
	.background-image {
	object-fit: cover;
	height: 100vh;
	}
	.limited-content-overlay {
	padding: 40px;
	text-align: center;
	}
</style>
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
<section class="d-flex flex-column flex-md-row h-100vh">
	{{-- Image Banner --}}
	@if($activeBanner->type === 'image')
	<div id="imageSection" class="w-100 position-relative h-100vh overflow-hidden">
		<img src="{{ asset('public/storage/products/' . $activeBanner->file_path) }}" alt="Banner Image"
			class="position-absolute top-0 start-0 w-100 h-100 object-cover">
		<div class="position-absolute bottom-0 start-0 p-4 p-md-5 text-start text-white" style="z-index: 10">
			<p class="small text-uppercase mb-2">Introducing</p>
			<h1 class="display-5 fw-bold mb-4 mb-md-3">{{ $activeBanner->title }}</h1>
			<a href="#" class="btn" style="border-radius: 0; background-color: #2b2542; color: #fff; padding: 10px 20px; text-transform: uppercase; letter-spacing: 1px;">
			Discover Collection
			</a>
		</div>
	</div>
	@endif
	{{-- Video Banner --}}
	@if($activeBanner->type === 'video')
	<div id="videoSection" class="w-100 position-relative h-100vh">
		<video autoplay muted loop playsinline class="w-100 h-100 object-cover">
			<source src="{{ asset('public/storage/products/' . $activeBanner->file_path) }}" type="video/mp4">
			Your browser does not support the video tag.
		</video>
		<div class="position-absolute bottom-0 start-0 p-4 p-md-5 text-start text-white" style="z-index: 10">
			<p class="small text-uppercase mb-2">Introducing</p>
			<h1 class="display-5 fw-bold mb-4 mb-md-3">{{ $activeBanner->title }}</h1>
			<a href="#" class="btn" style="border-radius: 0; background-color: #2b2542; color: #fff; padding: 10px 20px; text-transform: uppercase; letter-spacing: 1px;">
			Discover Collection
			</a>
		</div>
	</div>
	@endif
</section>
@endif
<!-- Script -->

<!--Banner section Ends -->
<section class="carousel" aria-label="hero banner carousel">
	<p class="sr-only">This is a carousel with auto-rotating slides. Activate any of the buttons to disable rotation. Use Next and Previous buttons to navigate, or jump to a slide using the slide dots.</p>
	<!-- Pause/resume button -->
	<!-- Previous button -->
	<button class="previous-button is-control">
	<span class="fas fa-angle-left" aria-hidden="true"></span>
	<span class="sr-only">Previous slide</span>
	</button>
	<div class="slides">
		@foreach ($limitedEditionBanners as $index => $banner)
		<div class="slide position-relative" role="group" aria-label="slide {{ $index + 1 }} of {{ $limitedEditionBanners->count() }}">
			<img src="{{ asset('storage/products/' . $banner->image) }}" class="background-image w-100" alt="{{ $banner->title }}">
			{{-- Content Overlay --}}
			<div class="limited-content-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center text-white" style="background: rgba(0,0,0,0.5);">
				<h2 class="timer-text mb-4">⏳ Limited Time Offer</h2>
				<div class="d-flex flex-wrap justify-content-center gap-3 px-3 w-100">
					@foreach($products->where('add_timer', true)->where('timer_end_at', '>', now())->take(5) as $product)
					<a href="/product_details/{{ $product->id }}" class="text-decoration-none text-white">
						<div class="card bg-light text-dark" style="width: 180px;">
							<div class="card-body text-center p-2">
								<h6 class="fw-semibold text-truncate" style="font-size: 0.95rem">{{ $product->productName }}</h6>
								@if($product->add_timer && $product->timer_end_at)
								<div class="countdown-timer text-danger small fw-bold"
									data-end-time="{{ \Carbon\Carbon::parse($product->timer_end_at)->timestamp }}">
									<span class="time-remaining">--:--:--</span>
								</div>
								@endif
							</div>
						</div>
					</a>
					@endforeach
				</div>
			</div>
		</div>
		@endforeach
	</div>

	<!-- Next button -->
	<button class="next-button is-control">
	<span class="fas fa-angle-right" aria-hidden="true"></span>
	<span class="sr-only">Next slide</span>
	</button>
</section>
{{-- product section --}}

<section class="position-relative w-100 mb-5" style="padding: 0;">
	<!-- Scroll Buttons -->
	<button onclick="scrollToLeft()" class="btn position-absolute start-0 top-50 translate-middle-y px-2 py-2 shadow-sm" style="z-index: 10; background-color: #1c1b33; color: white;">
	<i class="fas fa-chevron-left"></i>
	</button>
	<button onclick="scrollToRight()" class="btn position-absolute end-0 top-50 translate-middle-y px-2 py-2 shadow-sm" style="z-index: 10; background-color: #1c1b33; color: white;">
	<i class="fas fa-chevron-right"></i>
	</button>
	<div id="scrollContainer" class="d-flex flex-nowrap overflow-auto scroll-smooth" style="gap: 12px; padding: 0 12px; -ms-overflow-style: none; scrollbar-width: none;">
		@foreach($products as $product)
		<a href="/product_details/{{ $product->id }}" class="text-decoration-none text-dark">
			<div class="card product-card bg-white shadow-sm">
				<!-- NEW Badge -->
				<span class="position-absolute top-0 start-0 m-2 badge text-dark small fw-medium bg-success {{ $product->stock ? '' : 'bg-danger text-white' }} text-white rounded-pill px-2 py-1" style="width: fit-content; z-index: 10;">{{ $product->stock ? 'In Stock' : 'Out of Stock' }}</span>
				<!-- Images -->
				<div class="product-img-wrapper">
					<img src="{{ asset('storage/products/' . $product->image1) }}" class="img-front" alt="{{ $product->productName }}">
					@if($product->image2)
					<img src="{{ asset('storage/products/' . $product->image2) }}" class="img-back" alt="{{ $product->productName }} Hover">
					@else
					<img src="{{ asset('storage/products/' . $product->image1) }}" class="img-back" alt="{{ $product->productName }} Hover">
					@endif
					<div class="lock-icon add-to-cart-btn" data-product-id="{{ $product->id }}">
						<i class="fa-solid fa-lock text-white small"></i>
					</div>
				</div>
				<!-- Content -->
				<div class="card-body px-2 py-3">
					<h6 class="product_name">{{ $product->productName }}</h6>
					<!--<p class="text-muted small mb-2">₹ {{ $product->price }}</p>-->
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
				@if($product->stock)
				{{-- Show Product Name --}}
				<h1 class="product-name">{{ $product->name }}</h1>
				{{-- Show Timer if applicable --}}
				@if($product->add_timer && $product->timer_end_at)
				<div class="px-2 pb-2">
					<div class="countdown-timer text-danger small fw-bold"
						data-end-time="{{ \Carbon\Carbon::parse($product->timer_end_at)->timestamp }}">
						<span class="time-remaining">--:--:--</span>
					</div>
				</div>
				@endif
				@endif
			</div>
		</a>
		@endforeach
	</div>
</section>
{{-- touch section  --}}
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
{{--  Traditional content --}}
@php
$activeCategories = $categories->where('active', true)->take(4)->values(); // Get only active, max 4
@endphp
@if($activeCategories->count())
<div class="d-flex justify-content-end align-items-center mb-2 " style="margin-right:5px;">
	<a href="{{route('categories_page')}}" id="toggleCategoryView" class="btn btn-outline-dark btn-sm">
	View All Categories
	</a>
</div>
<section class="row gx-1 gy-1 overflow-hidden mx-0">
	@foreach($activeCategories as $index => $category)
	@if($index === 0)
	<!-- Left Side -->
	<div class="col-12 col-md-6 position-relative" style="height: 100vh;">
		<img src="{{ $category->image ? asset('public/storage/products/' . $category->image) : 'https://via.placeholder.com/600x800?text=No+Image' }}"
			alt="{{ $category->name }}" class="w-100 h-100" style="object-fit: cover;">
		<div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
			<a href="{{ route('product.show', ['id' => $category->id]) }}" 
				class="category-item  btn btn-dark text-uppercase small px-4 py-1" 
				data-category-id="{{ $category->id }}">
			{{ $category->name }}
			</a>
		</div>
	</div>
	@elseif($index === 1)
	<!-- Right Side Column Start -->
	<div class="col-12 col-md-6 d-flex flex-column" style="height: 100vh;">
		<!-- Top Right -->
		<div class="position-relative" style="height: 50%;">
			<img src="{{ $category->image ? asset('public/storage/products/' . $category->image) : 'https://via.placeholder.com/600x800?text=No+Image' }}"
				alt="{{ $category->name }}" class="w-100 h-100" style="object-fit: cover;">
			<div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
				<a href="{{ route('product.show', ['id' => $category->id]) }}" 
					class="category-item  btn btn-dark text-uppercase small px-4 py-1" 
					data-category-id="{{ $category->id }}">
				{{ $category->name }}
				</a>
			</div>
		</div>
		@elseif($index === 2 || $index === 3)
		@if($index === 2)
		<!-- Bottom Two Columns Start -->
		<div class="row gx-1 gy-1 flex-grow-1 mx-0" style="height: 50%;">
			@endif
			<div class="col-6 position-relative">
				<img src="{{ $category->image ? asset('public/storage/products/' . $category->image) : 'https://via.placeholder.com/600x800?text=No+Image' }}"
					alt="{{ $category->name }}" class="w-100 h-100" style="object-fit: cover;">
				<div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
					<a href="{{ route('product.show', ['id' => $category->id]) }}" 
						class="category-item  btn btn-dark text-uppercase small px-4 py-1" 
						data-category-id="{{ $category->id }}">
					{{ $category->name }}
					</a>
				</div>
			</div>
			@if($index === 3)
		</div>
		<!-- Close bottom 2 columns row -->
	</div>
	<!-- Close right side flex column -->
	@endif
	@endif
	@endforeach
</section>
@endif
{{-- video sectionstart --}}
<section class="position-relative w-100" style="height: 80vh">
	<video autoplay="" muted="" loop="" playsinline="" src="https://cdn.pixabay.com/video/2020/02/15/32387-392248830_tiny.mp4" alt="Model with Necklace" class="w-100 h-100 object-cover"></video>
	<div class="position-absolute bottom-0 start-0 bg-white shadow-sm d-flex align-items-center p-3 rounded m-3" style="max-width: 400px">
		<img src="https://cdn.pixabay.com/photo/2024/10/12/03/15/women-9114238_1280.jpg" alt="Product" class="img-fluid rounded me-3" style="width: 64px; height: 64px; object-fit: contain">
		<div class="flex-grow-1">
			<h3 class="fs-6 fw-medium text-[#1c1b33] lh-sm">
				Lola Yellow Gold<br>Tennis Necklace
			</h3>
			<p class="small text-muted mt-1">$9,500.00 USD</p>
		</div>
		<div class="ms-3">
			<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#1c1b33]" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h18v18H3V3zm3 7h12M9 3v4m6-4v4"></path>
			</svg>
		</div>
	</div>
</section>
{{-- video section end --}}
{{-- other section start --}}
<section class="container-fluid py-5 px-5 px-md-5" >
	<div class="row justify-content-center align-items-center" style="background-color: #fff7ef;">
		<!-- Left Side Image -->
		<div class="col-lg-6 mb-4 mb-lg-0 d-flex justify-content-center p-0" style="height: 90vh;">
			<img
				src="https://primavera-precision.myshopify.com/cdn/shop/files/flatlay_055f605d-750a-46b6-bbfe-fa1825515cbb.jpg?v=1740137524&width=1000"
				class="img-fluid"
				alt="Jewelry Image"
				style="object-fit: cover; border-radius: 0;"
				>
		</div>
		<!-- Right Side Text Content -->
		<div class="col-lg-6 d-flex align-items-center h-60 p-0" >
			<div class="w-100 px-3 px-md-4 py-4 text-center" >
				<p class="text-uppercase small fw-semibold mb-2" style="letter-spacing: 0.05em; color: #1c1b33;">
					Our Commitment
				</p>
				<h2 class="fw-bold mb-3" style="color: #1c1b33; font-size: 2rem;">
					Sustainably Crafted,<br>
					Eternally Beautiful
				</h2>
				<p class="text-muted mb-4" style="font-size: 0.95rem; line-height: 1.7;">
					At Primavera, luxury meets responsibility. Our fine jewelry is crafted with
					ethically sourced gemstones and recycled precious metals, ensuring beauty
					without compromise. We partner with sustainable suppliers to create pieces
					that shine with integrity—for you and the planet.
				</p>
				<a href="#" class="btn btn-sm px-4 py-2 text-white" style="background-color: #1c1b33;">
				About
				</a>
			</div>
		</div>
	</div>
</section>
{{-- other section end --}}
{{-- heavy product  --}}
<section class="position-relative bg-cover bg-center d-flex align-items-center justify-content-center px-3" style="
	background-image: url('https://cdn.pixabay.com/photo/2016/06/17/09/54/woman-1462986_1280.jpg');
	height:80vh;">
	<div class="position-absolute inset-0 bg-dark opacity-25"></div>
	<div class="position-relative z-1 container">
		<div class="row flex-column flex-lg-row align-items-center justify-content-between g-4">
			<div class="text-center text-lg-start text-white col-lg-8">
				<p class="small text-uppercase mb-2 tracking-widest">
					Client Exclusive
				</p>
				<h1 class="display-4 display-md-3 fw-semibold mb-3 text-[#1c1b33]">
					Beverly Hills Private Sale
				</h1>
				<p class="text-[#1c1b33] mb-4">
					RSVP to our exclusive Private Sale event at VEDARO Beverly Hills.
				</p>
				<a href="#" class="btn  text-white px-4 py-2 rounded hover:bg-[#16162a]" style="background-color: #1c1b33">
				RSVP
				</a>
			</div>
		</div>
	</div>
</section>
{{-- heavy product end --}}
<section class="container-fluid px-3 px-lg-5 py-5 bg-[#fdfaf6] text-[#1c1b33]">
	<div class="row g-5">
		@foreach($featuredProducts as $product)
		<div class="col-lg-12 d-flex flex-column flex-lg-row gap-4">
			<!-- Image Gallery -->
			<div class="d-flex flex-column flex-md-row gap-3">
				<div class="d-flex flex-md-column gap-3 overflow-auto order-1 order-md-0 images-slides">
					@if($product->image1)
					<img onclick="changeMainImage(this.src)" src="{{ asset('storage/products/' . $product->image1) }}" class="img-fluid border cursor-pointer flex-shrink-0" style="width: 80px; height: 120px; object-fit: cover;">
					@endif
					@if($product->image12)
					<img onclick="changeMainImage(this.src)" src="{{ asset('storage/products/' . $product->image2) }}" class="img-fluid border cursor-pointer flex-shrink-0" style="width: 80px; height: 120px; object-fit: cover;">
					@endif
					@if($product->image3)
					<img onclick="changeMainImage(this.src)" src="{{ asset('storage/products/' . $product->image3) }}" class="img-fluid border cursor-pointer flex-shrink-0" style="width: 80px; height: 120px; object-fit: cover;">
					@endif
				</div>
				<!-- Main Image -->
				<div class="flex-grow-1 order-0 order-md-1">
					<img id="mainImage" src="{{ asset('storage/products/' . $product->image1) }}" class="img-fluid border transition-all duration-300 w-100" style="height: 500px; object-fit: cover;">
				</div>
			</div>
			<!-- Product Info -->
			<div class="flex-grow-1">
				<p class="small text-uppercase tracking-widest text-muted mb-2">New</p>
				<h1 class="fs-2 fw-semibold mb-2">{{ $product->productName }}</h1>
				@php
				$price = number_format($product->price, 2);
				$discountPrice = $product->discountPrice ? number_format($product->discountPrice, 2) : null;
				@endphp
				<p class="fs-5 mb-1">
					@if($discountPrice)
					<del class="text-muted me-2">${{ $price }} USD</del>
					<span class="text-danger fw-bold">${{ $discountPrice }} USD</span>
					@else
					${{ $price }} USD
					@endif
				</p>
				<p class="small text-muted mb-4">Taxes included.</p>
				<p class="small mb-4">{!! nl2br(e($product->productDescription1)) !!}</p>
				<!-- Metal Color Options (example, not dynamic) -->
				{{--
				<div class="mb-4">
					<p class="small fw-medium mb-2">METAL: WHITE GOLD</p>
					<div class="d-flex gap-3">
						<div class="rounded-circle border border-2 border-dark bg-secondary" style="width: 24px; height: 24px"></div>
						<div class="rounded-circle border bg-warning" style="width: 24px; height: 24px"></div>
						<div class="rounded-circle border bg-danger" style="width: 24px; height: 24px"></div>
						<div class="rounded-circle border bg-dark" style="width: 24px; height: 24px"></div>
					</div>
				</div>
				--}}
				<!-- Engraving Input -->
				<div class="mb-4">
					<!--<label class="small fw-medium form-label">Engraving</label>-->
					<input type="text" class="form-control border-bottom border-secondary bg-transparent py-1"
						style="border-top: none; border-left: none; border-right: none; border-radius: 0;">
				</div>
				<!-- Add to Cart Button -->
				<button class="btn bg-[#1c1b33] text-white w-100 py-2 fw-medium mb-4 hover:bg-[#14132a]">
				ADD TO CART
				</button>
				<!-- Alert -->
				<div class="alert alert-warning small rounded mb-4" role="alert">
					❤️ Order now to receive in time for special occasions!
				</div>
				<!-- Expandable Sections -->
				{{-- 
				<div class="mt-4 border-top pt-3 small">
					<p class="d-flex justify-content-between cursor-pointer">
						Details <span>+</span>
					</p>
					<p class="mt-3 d-flex justify-content-between cursor-pointer">
						Maintenance &amp; Care <span>+</span>
					</p>
				</div>
				--}}
			</div>
		</div>
		@endforeach
	</div>
</section>
{{-- golden jwellery start --}}


{{-- Vedaro about  start --}}
<section class="bg-white px-3 py-5" style="background-color: #FDFBF9;">
	<div class="container px-3 px-md-5">
		<div class="row align-items-center g-5">
			<!-- Text Left -->
			<div class="col-md-6">
				<p class="small text-uppercase text-muted fw-semibold mb-2">About VEDARO</p>
				<h2 class="fw-bold text-dark mb-3" style="font-size: 2rem; line-height: 1.3;">
					Scandinavian elegance<br>
					with a New York pulse
				</h2>
				<p class="text-muted mb-4" style="line-height: 1.7;">
					VEDARO was founded by Una Langgaard, a Copenhagen-born designer who moved to New York in the 90’s. Growing up surrounded by the quiet elegance of Scandinavian design, she was also fascinated by the energy and chaos of New York. From the beginning, VEDARO was about balance — sleek, architectural lines softened by the asymmetry of a petal, a vine, or the curve of a wave. Today, VEDARO is celebrated as the epitome of quiet luxury.
				</p>
				<a href="/contact">
				<button class="btn border border-dark text-dark text-uppercase px-4 py-2 small fw-semibold" style="transition: 0.3s;">
				About  
				</button>
				</a>
			</div>
			<!-- Image Right -->
			<div class="col-md-6 text-center">
				<img src="https://cdn.pixabay.com/photo/2024/12/09/05/57/girl-9254216_1280.jpg" alt="VEDARO Store" class="img-fluid rounded shadow-sm" style="max-height: 450px; object-fit: cover;">
			</div>
		</div>
	</div>
</section>
{{-- Vedaro about  ends --}}
{{-- Vedaro advertise products --}}
<section class="bg-[#FDFBF9] my-4">
	<div class="container mx-auto row g-3 align-items-center" style="max-width: 1400px">
		<div class="position-relative col-12 col-md-3">
			<img src="https://cdn.pixabay.com/photo/2023/03/02/19/11/woman-7826139_1280.jpg" alt="Bracelet" class="w-100 img-fluid rounded">
			<button class="btn bg-[#1E1E3F] text-white p-2 rounded position-absolute bottom-0 end-0 m-3">
				<div class="lock-icon" style="z-index:10;">
					<i class="fa-solid fa-lock text-white small"></i>
				</div>
			</button>
		</div>
		<div class="col-12 col-md-3 text-center py-4 px-3">
			<p class="small text-muted mb-1">Tag your</p>
			<h2 class="fs-2 fw-bold text-[#1E1E3F] mb-2">#PMVA</h2>
			<a href="#" class="small text-[#1E1E3F] text-decoration-underline">Follow Us</a>
		</div>
		<div class="position-relative col-12 col-md-3">
			<img src="https://cdn.pixabay.com/photo/2023/11/10/02/30/woman-8378634_1280.jpg" alt="Model in dress" class="w-100 img-fluid rounded">
			<button class="btn bg-[#1E1E3F] text-white p-2 rounded position-absolute bottom-0 end-0 m-3">
				<div class="lock-icon" style="z-index:10;">
					<i class="fa-solid fa-lock text-white small"></i>
				</div>
			</button>
		</div>
		<div class="position-relative col-12 col-md-3">
			<img src="https://cdn.pixabay.com/photo/2022/11/10/07/15/portrait-7582123_1280.jpg" alt="Model selfie" class="w-100 img-fluid rounded">
			<button class="btn bg-[#1E1E3F] text-white p-2 rounded position-absolute bottom-0 end-0 m-3">
				<div class="lock-icon" style="z-index:10;">
					<i class="fa-solid fa-lock text-white small"></i>
				</div>
			</button>
		</div>
	</div>
</section>
{{-- Vedaro advertise products end --}}
{{-- vedaro detailing  --}}
<section class=" py-5 px-3" style="background-color: #FDF1E7;">
	<div class="container mx-auto row g-4 text-center" style="max-width: 1140px">
		<div class="col-12 col-md-4 d-flex flex-column align-items-center">
			<svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#1E1E3F] mb-3" width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l8.5 5.1L20 7M3 17l8.5-5.1L20 17M3 12l8.5 5.1L20 12"></path>
			</svg>
			<h3 class="fs-5 fw-medium text-[#1E1E3F] mb-2">
				Free Shipping &amp; Returns
			</h3>
			<p class="text-muted">
				We offer worldwide complimentary<br>shipping and returns on all
				orders.
			</p>
		</div>
		<div class="col-12 col-md-4 d-flex flex-column align-items-center">
			<svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#1E1E3F] mb-3" width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2a10 10 0 100 20 10 10 0 000-20zM2 12h20"></path>
			</svg>
			<h3 class="fs-5 fw-medium text-[#1E1E3F] mb-2">
				Committed to Climate Action
			</h3>
			<p class="text-muted">
				We're committed to using sustainable<br>materials in a responsible
				way.
			</p>
		</div>
		<div class="col-12 col-md-4 d-flex flex-column align-items-center">
			<svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#1E1E3F] mb-3" width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
				<path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 6
					3.5 4 5.5 4c1.54 0 3.04.99 3.57 2.36h1.87C13.46 4.99
					14.96 4 16.5 4 18.5 4 20 6 20 8.5c0 3.78-3.4 6.86-8.55
					11.54L12 21.35z"></path>
			</svg>
			<h3 class="fs-5 fw-medium text-[#1E1E3F] mb-2">Customer Love</h3>
			<p class="text-muted">
				Speak to one of our expert consultants<br>via email or text,
				Monday through Sunday.
			</p>
		</div>
	</div>
</section>
{{-- Organic section --}}
{{-- 
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
--}}
{{-- some detailing ends --}}
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script src="{{ asset('public/assets/js/home.js') }}"></script>
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
<!--Add to cart and update cart script-->
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
@endsection