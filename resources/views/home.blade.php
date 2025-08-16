@extends('layouts.main')
@section('title', 'Home')
<!-- Slick Carousel CSS -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
<link rel="stylesheet" href="{{ asset('public/assets/css/home.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-...your-integrity..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    
    .category-tile {
        transition: transform 0.23s cubic-bezier(.4, 0, .2, 1), box-shadow 0.23s;
        cursor: pointer;
    }
    .category-tile:hover {
        transform: translateY(-3px) scale(1.04);
        z-index: 2;
    }
    
    .category-image-container {
        position: relative;
        min-height: 110px;
        background: #f5f5f5;
    }
    
    .category-img {
        transition: filter 0.22s;
    }
    .category-tile:hover .category-img {
        filter: brightness(0.85);
    }
    
    .category-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(0, 0, 0, 0.4) 0%, rgba(0, 0, 0, 0.65) 100%);
        z-index: 1;
        /* Always visible, no opacity toggling */
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 0.5rem;
    }
    
    .category-name {
        font-size: 1rem;
        text-shadow: 0 2px 5px rgba(0,0,0,0.8);
        letter-spacing: 1px;
        padding: 0.3rem 0.7rem;
        white-space: nowrap;
    }
    
    @media (max-width: 575.98px) {
        .category-name {
            font-size: 0.9rem;
            padding: 0.17rem 0.3rem;
            white-space: normal;
            text-align: center;
        }
    }
    
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
    	.f-product-des{
    	width: 100% !important;
    	.img-container {
    	height: 150px !important;
    	}
    	.banner-title {
    	font-size: 2rem !important;
    	}
    	}
    	@media (max-width: 576px) {
    
    	.img-container {
    	height: 140px !important;
    	}
    	}
    	.f-product-des{
    	width: 50%;
    	}
    	.product-card:hover img {
    	transform: scale(1.08) !important;
    	}
    	.slick-dots{
    	display: none !important;
    	}
            /*style in mobile for categories on home*/
        @media (max-width: 600px) {
        .lead-image {
            height: 50vh!important;
        }
        .client_exclusive{
            background-image: url({{ asset('public/assets/images/home2_banner.jpg') }})!important;
        }
    }
    </style>
    <!--Reels Section -->
    <style>
    	.reel-video {
    	width: 100%;
    	height: 100%;
    	position: relative;
    	}
    	.reel-video iframe,
    	.reel-video blockquote.instagram-media {
    	width: 100% !important;
    	height: 100% !important;
    	max-width: none !important;
    	min-width: unset !important;
    	margin: 0 !important;
    	padding: 0 !important;
    	box-sizing: border-box;
    	}
    
    	.reels-section {
    	padding: 20px;
    	background-color: #fff;
    	}
    	.reels-title {
    	font-size: 24px;
    	font-weight: bold;
    	margin-bottom: 16px;
    	}
    	.reels-container {
    	display: flex;
    	gap: 16px;
    	overflow-x: auto;
    	scroll-snap-type: x mandatory;
    	padding-bottom: 10px;
    	}
    	.reel {
    	flex: 0 0 auto;
    	width: 240px;
    	height: 420px;
    	border-radius: 12px;
    	overflow: hidden;
    	scroll-snap-align: start;
    	position: relative;
    	background-color: #000;
    	box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    	}
    	.reel video {
    	width: 100%;
    	height: 100%;
    	object-fit: cover;
    	cursor: pointer;
    	transition: transform 0.3s ease;
    	}
    	.reel video:hover {
    	transform: scale(1.02);
    	}
    	.reels-container::-webkit-scrollbar {
    	display: none;
    	}
    	.reels-container {
    	-ms-overflow-style: none;
    	scrollbar-width: none;
    	}
    	@media (max-width: 600px) {
    	.reel {
    	width: 180px;
    	height: 320px;
    	}
    	.Sustainably .py-5{
    	    padding: 0!important;
    	}
    	}
    	 
    
            .mainContainer {
                justify-content: start ;
            }
             @media (max-width: 925px) {
                .category-tile {
                    height: 100px;
                    min-width: 32%; /* Corrected */
                }
            
                /*.col-6 {*/
                /*    flex: 0 0 auto;*/
                    /*width: 47%; */
                /*}*/
                .mainContainer{
                    margin-inline: auto;
                }
                .mainContainer {
                justify-content: center ;
            }
            }
             @media (max-width: 625px) {
                .imageAbout{
                    display: none;
                }
                 
             }
        
        
           .row {
            margin-right: 0 !important;
            margin-left: 0 !important;
        }
    
    </style>
    <!--home categories Products css-->
    <style>
            /* Scroll buttons styling - Added this new style only */
            .scroll-btn {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                width: 36px;
                height: 36px;
                background-color: white;
                border: 1px solid #ddd;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                z-index: 1;
                transition: all 0.3s ease;
                opacity: 0.9;
            }
            
            .scroll-btn:hover {
                background-color: #f8f9fa;
                box-shadow: 0 2px 8px rgba(0,0,0,0.2);
                opacity: 1;
            }
            
            .scroll-btn i {
                font-size: 14px;
                color: #333;
            }
            
            .scroll-btn-left {
                left: 0px;
                z-index: 999;
            }
            
            .scroll-btn-right {
            right: 0px;
            z-index: 999;
        }
            
            /* Hide scrollbar - Added this to ensure no scrollbar shows */
            .scroll-smooth::-webkit-scrollbar {
                display: none;
            }

    <!--style for categories section -->
    

    .categories-slider-container {
        overflow: hidden;
    }
    
    .categories-slider {
        overflow-x: auto;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
        scroll-snap-type: x mandatory;
        padding-bottom: 15px; /* Space for scrollbar */
    }
    
    .categories-slider::-webkit-scrollbar {
        height: 5px;
    }
    
    .categories-slider::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .categories-slider::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }
    
    .categories-slider::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    
    .category-tile {
        scroll-snap-align: start;
        min-width: calc(100% / 3); /* 3 items on mobile */
    }
    
    @media (min-width: 768px) {
        .category-tile {
            min-width: calc(100% / 6); /* 6 items on desktop */
        }
    }
    
    .category-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        opacity: 0.5;
        transition: opacity 0.3s ease;
    }
    
    .category-tile:hover .category-overlay {
        opacity: 1;
    }
    
    .category-name {
        font-size: 0.8rem;
        text-align: center;
        padding: 0.5rem;
        background: rgba(0, 0, 0, 0.7);
        border-radius: 4px;
        transition: all 0.3s ease;
    }
    
    .category-tile:hover .category-name {
        background: rgba(0, 0, 0, 0.9);
        transform: scale(1.05);
    }
    
    .slider-prev, .slider-next {
        width: 40px;
        height: 40px;
        z-index: 1;
        opacity: 0.8;
        transition: opacity 0.3s ease;
    }
    
    .slider-prev:hover, .slider-next:hover {
        opacity: 1;
    }
    
    .slider-prev {
        left: 10px;
        z-index: 99;
    }
    
    .slider-next {
        right: 10px;
        z-index: 99;
        
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
            
                {{-- Desktop Banner Image --}}
                <img src="{{ asset('public/storage/products/' . $activeBanner->file_path) }}"
                     class="position-absolute top-0 start-0 w-100 h-100 object-cover d-none d-md-block" alt="Banner Image">
            
                {{-- Mobile Banner Image --}}
                <img src="{{ asset('public/assets/images/mobile_home_banner_final.jpg') }}"
                     class="position-absolute top-0 start-0 w-100 h-100 object-cover d-block d-md-none" alt="Mobile Banner Image">
            
                {{-- Banner Text and Button --}}
                <div class="position-absolute start-0 p-4 p-md-5 text-start text-white" style="z-index: 10;bottom:100px">
                    <!--<p class="small text-uppercase mb-2">Introducing</p>-->
                    <!--<h1 class="display-5 fw-bold mb-4 mb-md-3">{{ $activeBanner->title }}</h1>-->
                    <a href="#" class="btn"
                       style="border-radius: 0; background-color: #2b2542; color: #fff; padding: 10px 20px; text-transform: uppercase; letter-spacing: 1px;">
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
            <!--Banner section Ends -->
            <section class="carousel" aria-label="hero banner carousel" style="margin-bottom: 50px;">
            	<button class="previous-button is-control">
            	<span class="fas fa-angle-left" aria-hidden="true"></span>
            	<span class="sr-only">Previous slide</span>
            	</button>
            <div class="slides">
                @foreach ($limitedEditionBanners as $index => $banner)
                    <div class="slide position-relative" role="group" aria-label="slide {{ $index + 1 }} of {{ $limitedEditionBanners->count() }}">
                        <img src="{{ asset('storage/products/' . $banner->image) }}" class="background-image w-100" alt="{{ $banner->title }}" style="height: 600px; filter: brightness(0.5);">
            
                        <div class="limited-content-overlay position-absolute top-0 start-0 w-100 h-100 d-flex text-white" style="background: rgba(0,0,0,0.6); gap: 3rem;">
                            <!-- Left side: Banner title and description -->
                            <div class="banner-text-container p-4 d-flex flex-column justify-content-center" style="flex: 1; max-width: 40%;">
                                <h1 class="banner-title mb-3" style="font-size: 3rem; font-weight: 700; text-transform: uppercase; letter-spacing: 2px;">{{ $banner->title }}</h1>
                                <p class="banner-description mb-4" style="font-size: 1.5rem;">
                                    {{ $banner->description ?? 'To Make It Happen!' }}
                                </p>
                                <a href="/limited_edition" class="btn-view-all btn btn-warning btn-lg rounded-pill px-4 py-2" style="font-weight: 600; border: none; align-self: center;">View All Offers</a>
                            </div>
            
                            <!-- Right side: Conditionally show product cards if assigned -->
                            @if($banner->products->isNotEmpty())
                                <div class="product-cards-container d-flex flex-nowrap gap-4 p-3"
                                    style="flex: 1; max-width: 60%; align-items: center; justify-content: flex-start; overflow-x: auto; overflow-y: hidden; -ms-overflow-style: none; scrollbar-width: none;">
                                    @foreach($banner->products->take(5) as $product)
                                        <a href="{{ url('/product_details/' . urlencode($product->productName)) }}" class="product-card text-decoration-none text-white d-flex flex-column align-items-center rounded" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.15); box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2); transition: transform 0.3s ease, box-shadow 0.3s ease; width: 220px; padding: 1rem; overflow: hidden;">
                                            <div class="img-container mb-2" style="width: 100%; height: 200px; overflow: hidden; border-radius: 1rem; position: relative;">
                                                <img src="{{ asset('storage/products/' . $product->image1) }}" alt="{{ $product->productName }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;">
                                                @if($product->add_timer && $product->timer_end_at)
                                                    <div class="countdown-timer small fw-bold" style="z-index:9999; position:absolute;top:0px;width:100%;left: 0; background: red;" data-end-time="{{ \Carbon\Carbon::parse($product->timer_end_at)->timestamp }}">
                                                        <span class="time-remaining">--:--:--</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <h5 class="product-name mt-3 mb-2" style="font-size: 1rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin: 0; width: 100%; text-align: center;">
                                                {{ $product->productName }}
                                            </h5>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                            <!-- If products are empty, no right section will be shown -->
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
                <section class="position-relative w-100 mb-4" style="padding: 0;">
                	<!-- Scroll Buttons -->
                	<button onclick="scrollToLeft()" class="btn position-absolute start-0 top-50 translate-middle-y px-2 py-2 shadow-sm" style="z-index: 10; background-color: #1c1b33; color: white;">
                	<i class="fas fa-chevron-left"></i>
                	</button>
                	<button onclick="scrollToRight()" class="btn position-absolute end-0 top-50 translate-middle-y px-2 py-2 shadow-sm" style="z-index: 10; background-color: #1c1b33; color: white;">
                	<i class="fas fa-chevron-right"></i>
                	</button>
                	<div id="scrollContainer" class="d-flex flex-nowrap overflow-auto scroll-smooth" style="gap: 12px; padding: 0 12px; -ms-overflow-style: none; scrollbar-width: none;">
                		@foreach($products as $product)
                		<a href="{{ url('/product_details/' . urlencode($product->productName)) }}" class="text-decoration-none text-dark">
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



        @php
        $activeCategories =  $categories->where('active', true); // Get 8 active categories
        @endphp
        
        @if($activeCategories)
        <div class="d-flex justify-content-end align-items-center mb-3" style="margin-right: 5px;">
            <a href="{{ route('categories_page') }}" id="toggleCategoryView" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                View All Categories
            </a>
        </div>

        <section class="container-fluid mainContainer p-3 mb-5">
            <div class="categories-slider-container position-relative">
                <div class="categories-slider row gap-4 gx-2 gy-3 flex-nowrap">
                    @foreach($activeCategories as $category)
                        <div class="col-4 col-md-2 position-relative category-tile p-1 flex-shrink-0">
                            <div class="category-image-container rounded-4 h-100 overflow-hidden">
                                <img src="{{ $category->image ? asset('public/storage/products/' . $category->image) : 'https://via.placeholder.com/600x800?text=No+Image' }}"
                                    alt="{{ $category->name }}" class="w-100 h-100 rounded-4 category-img" style="object-fit: cover; min-height:110px;">
                                    
                                <div class="category-overlay d-flex align-items-center justify-content-center rounded-4">
                                    <a href="{{ route('product.show', ['id' => $category->id]) }}"
                                       class="category-name text-white text-decoration-none text-uppercase fw-bold">
                                        {{ $category->name }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Navigation Arrows -->
                <button class="slider-prev position-absolute top-50 start-0 translate-middle-y bg-white border-0 rounded-circle shadow p-2" aria-label="Previous">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="slider-next position-absolute top-50 end-0 translate-middle-y bg-white border-0 rounded-circle shadow p-2" aria-label="Next">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </section>
        @endif




{{-- Home Categories Section --}}
@foreach($homeCategories as $category)
<section class="position-relative w-100 mb-5" style="padding: 0;">
   <div class="d-flex align-items-center mb-4">
    <div class="me-2" style="width: 5px; height: 30px; background-color: #0d6efd;"></div>
    <h3 class="mb-0 text-primary fw-bold">
        {{ $category->name ?? 'Products' }}
    </h3>
</div>

    <!-- Scroll Container with Buttons -->
    <div class="position-relative">
        <!-- Left Scroll Button -->
        <button class="scroll-btn scroll-btn-left" onclick="scrollProducts('left', 'scrollContainer-{{ $category->id }}')">
            <i class="fas fa-chevron-left"></i>
        </button>
        
        <div id="scrollContainer-{{ $category->id }}" 
             class="d-flex flex-nowrap overflow-auto scroll-smooth" 
             style="gap: 12px; padding: 0 12px; -ms-overflow-style: none; scrollbar-width: none;">

            @forelse($category->products as $product)
            <a href="{{ url('/product_details/' . urlencode($product->productName)) }}" class="text-decoration-none text-dark">
                <div class="card product-card bg-white shadow-sm">
                    <div class="badge-wrapper">
                        @if($product->add_timer == 1)
                     <span class="product-badge limited-badge">
                <i class="fas fa-star me-1"></i> Limited Edition
            </span>
                        @endif
                        <span class="product-badge {{ $product->current_stock ? 'in-stock-badge' : 'out-stock-badge' }}">
                            {{ $product->current_stock ? 'In Stock' : 'Out of Stock' }}
                        </span>
                    </div>
                    <div class="product-img-wrapper">
                        <img src="{{ asset('storage/products/' . $product->image1) }}" class="img-front" alt="{{ $product->productName }}">
                        <img src="{{ asset('storage/products/' . ($product->image2 ?? $product->image1)) }}" class="img-back" alt="{{ $product->productName }} Hover">
                      @if( $product->current_stock > 0 && ( !$product->add_timer || ($product->timer_end_at && \Carbon\Carbon::parse($product->timer_end_at)->isPast())))
                    <div class="lock-icon add-to-cart-btn" 
                         id="add-to-cart-{{ $product->id }}" 
                         data-product-id="{{ $product->id }}">
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
            @empty
            <p class="text-muted">No products available in this category.</p>
            @endforelse
        </div>
        
        <!-- Right Scroll Button -->
        <button class="scroll-btn scroll-btn-right" onclick="scrollProducts('right', 'scrollContainer-{{ $category->id }}')">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
</section>
@endforeach








{{--  Home Categories Section End... --}}





<!--add image section-->
 <section class="position-relative d-none d-flex align-items-center justify-content-center px-3"
            style="
                background-image: url({{ asset('public/assets/images/our_commitement.jpg') }});
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                height: 80vh;
        ">



</section>

{{-- video sectionstart --}}
<section class="position-relative w-100" style="height: 80vh">
	<video autoplay="" muted="" loop="" playsinline="" src="https://cdn.pixabay.com/video/2020/02/15/32387-392248830_tiny.mp4" alt="Model with Necklace" class="w-100 h-100 object-cover"></video>
	<!--<div class="position-absolute bottom-0 start-0 bg-white shadow-sm d-flex align-items-center p-3 rounded m-3" style="max-width: 400px">-->
	<!--	<img src="https://cdn.pixabay.com/photo/2024/10/12/03/15/women-9114238_1280.jpg" alt="Product" class="img-fluid rounded me-3" style="width: 64px; height: 64px; object-fit: contain">-->
	<!--	<div class="flex-grow-1">-->
	<!--		<h3 class="fs-6 fw-medium text-[#1c1b33] lh-sm">-->
	<!--			Lola Yellow Gold<br>Tennis Necklace-->
	<!--		</h3>-->
	<!--		<p class="small text-muted mt-1">$9,500.00 USD</p>-->
	<!--	</div>-->
	<!--	<div class="ms-3">-->
	<!--		<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#1c1b33]" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
	<!--			<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h18v18H3V3zm3 7h12M9 3v4m6-4v4"></path>-->
	<!--		</svg>-->
	<!--	</div>-->
	<!--</div>-->
</section>
{{-- video section end --}}
{{-- other section start --}}
   

{{-- other section end --}}

{{-- heavy product  --}}
{{--
<section class="position-relative d-flex align-items-center justify-content-center px-3 client_exclusive"
    style="
        background-image: url({{ asset('public/assets/images/about/Client_Exclusive.jpg') }});
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 80vh;
        margin-bottom:20px;
    ">

    <!-- Fullscreen dark overlay -->
    <!--<div class="position-absolute top-0 start-0 w-100 h-100"-->
    <!--     style="background-color: rgba(0, 0, 0, 0.4); z-index: 1;">-->
    <!--</div>-->

    <!-- Content box with its own background -->
    <!--<div class="position-relative z-2 text-white text-center px-4 py-3 rounded"-->
    <!--     style="background-color: rgba(0, 0, 0, 0.5); backdrop-filter: blur(2px); max-width: 600px;">-->
    <!--    <small class="text-uppercase">Client Exclusive</small>-->
    <!--    <h1 class="display-4 fw-bold">Beverly Hills Private Sale</h1>-->
    <!--    <p>RSVP to our exclusive Private Sale event at VEDARO Beverly Hills.</p>-->
    <!--    <a href="#" class="btn btn-light px-4 py-2 mt-2">RSVP</a>-->
    <!--</div>-->

</section>--}}
{{-- heavy product end --}}



{{-- categories  products show section --}}
<section class="container-fluid px-3 px-lg-5 py-5 bg-[#fdfaf6] text-[#1c1b33]">
	<div class="row g-5">
		@foreach($featuredProducts as $product)
		<div class="col-lg-12 d-flex flex-column flex-lg-row gap-4">
			<!-- Image Gallery -->
			<div class="d-flex flex-column flex-md-row gap-3 ">
				<div class="d-flex flex-md-column gap-3 overflow-auto order-1 order-md-0 images-slides thumb-image">
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
				<div class="flex-grow-1 order-0 order-md-1 imageMain">
					<img id="mainImage" src="{{ asset('storage/products/' . $product->image1) }}" class="img-fluid border transition-all duration-300 w-100" style="height: 500px; object-fit: cover;">
				</div>
			</div>
			<!-- Product Info -->
			<div class="flex-grow-1 f-product-des">
    <p class="small text-uppercase tracking-widest text-muted mb-2">New</p>
    <h1 class="fs-2 fw-semibold mb-2">{{ $product->productName }}</h1>

    @php
        $price = number_format($product->price, 2);
        $discountPrice = $product->discountPrice ? number_format($product->discountPrice, 2) : null;
    @endphp

    <p class="fs-5 mb-1">
        @if($discountPrice)
            <!--<del class="text-muted me-2">₹{{ $price }}</del>-->
            <span class="text-success fw-bold">₹{{ $discountPrice }}</span>
        @else
            ${{ $price }} USD
        @endif
    </p>

    <p class="small text-muted mb-4">Taxes included.</p>

    <p class="small mb-4" style="text-align:justify">
        {!! nl2br(e($product->productDescription1)) !!}
    </p>

    <!-- Engraving Input -->
    <div class="mb-4">
        <!--<label class="small fw-medium form-label">Engraving</label>-->
        <input type="text" class="form-control border-bottom border-secondary bg-transparent py-1"
            style="border-top: none; border-left: none; border-right: none; border-radius: 0;">
    </div>

    <!-- Add to Cart Button -->
    <button class="btn bg-[#1c1b33] text-white w-100 py-2 fw-medium mb-3 hover:bg-[#14132a]">
        ADD TO CART
    </button>

    <!-- View Details Button -->
    <a href="{{ url('/product_details/' . urlencode($product->productName)) }}" class="btn btn-outline-dark w-100 py-2 fw-medium mb-3">
        View Details
    </a>

    <!-- Alert -->
    <div class="alert alert-warning small rounded mb-4" role="alert">
        ❤️ Order now to receive in time for special occasions!
    </div>
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
					Sustainably Crafted,<br>
                        Eternally Beautiful
				
				</h2>
				<p class="text-muted mb-4" style="line-height: 1.7;">
					Vedaro was founded by Bhavya Garodia, a young visionary from Rajasthan with an old soul and a deep reverence for timeless beauty. Raised amidst the spiritual richness of Indian tradition and driven by a passion for design, Bhavya envisioned a brand where purity meets purpose. Vedaro was born not just to adorn, but to tell stories — of devotion, detail, and quiet luxury. Each piece reflects his belief: that true elegance lies in simplicity, and meaning is the finest ornament.
				</p>
				<a href="/about">
				<button class="btn border border-dark text-dark text-uppercase px-4 py-2 small fw-semibold" style="transition: 0.3s;">
				About  
				</button>
				</a>
			</div>
			<!-- Image Right -->
			<div class="col-md-6 text-center imageAbout">
				<img src="{{ asset('public/assets/images/about/about.jpg') }}" alt="VEDARO Store" class="img-fluid rounded shadow-sm" style="max-height: 450px; object-fit: cover;">
			</div>
		</div>
	</div>
</section>
{{-- Vedaro about  ends --}}
{{-- Vedaro advertise products --}}
<!--<section class="bg-[#FDFBF9] my-4">-->
<!--	<div class="container mx-auto row g-3 align-items-center" style="max-width: 1400px">-->
<!--		<div class="position-relative col-12 col-md-3">-->
<!--			<img src="https://cdn.pixabay.com/photo/2023/03/02/19/11/woman-7826139_1280.jpg" alt="Bracelet" class="w-100 img-fluid rounded">-->
<!--			<button class="btn bg-[#1E1E3F] text-white p-2 rounded position-absolute bottom-0 end-0 m-3">-->
<!--				<div class="lock-icon" style="z-index:10;">-->
<!--					<i class="fa-solid fa-lock text-white small"></i>-->
<!--				</div>-->
<!--			</button>-->
<!--		</div>-->
<!--		<div class="col-12 col-md-3 text-center py-4 px-3">-->
<!--			<p class="small text-muted mb-1">Tag your</p>-->
<!--			<h2 class="fs-2 fw-bold text-[#1E1E3F] mb-2">#PMVA</h2>-->
<!--			<a href="#" class="small text-[#1E1E3F] text-decoration-underline">Follow Us</a>-->
<!--		</div>-->
<!--		<div class="position-relative col-12 col-md-3">-->
<!--			<img src="https://cdn.pixabay.com/photo/2023/11/10/02/30/woman-8378634_1280.jpg" alt="Model in dress" class="w-100 img-fluid rounded">-->
<!--			<button class="btn bg-[#1E1E3F] text-white p-2 rounded position-absolute bottom-0 end-0 m-3">-->
<!--				<div class="lock-icon" style="z-index:10;">-->
<!--					<i class="fa-solid fa-lock text-white small"></i>-->
<!--				</div>-->
<!--			</button>-->
<!--		</div>-->
<!--		<div class="position-relative col-12 col-md-3">-->
<!--			<img src="https://cdn.pixabay.com/photo/2022/11/10/07/15/portrait-7582123_1280.jpg" alt="Model selfie" class="w-100 img-fluid rounded">-->
<!--			<button class="btn bg-[#1E1E3F] text-white p-2 rounded position-absolute bottom-0 end-0 m-3">-->
<!--				<div class="lock-icon" style="z-index:10;">-->
<!--					<i class="fa-solid fa-lock text-white small"></i>-->
<!--				</div>-->
<!--			</button>-->
<!--		</div>-->
<!--	</div>-->
<!--</section>-->
{{--
<!--reels-section-->
<!--<section class="reels-section">-->
<!--	<h2 class="reels-title">🎥 Reels / Ads Showcase</h2>-->
<!--	<div class="reels-container">-->
<!--		<div class="reel">-->
<!--			<video src="https://www.w3schools.com/html/mov_bbb.mp4" muted loop onclick="this.paused ? this.play() : this.pause()"></video>-->
<!--		</div>-->
<!--		<div class="reel">-->
<!--			<video src="https://www.w3schools.com/html/movie.mp4" muted loop onclick="this.paused ? this.play() : this.pause()"></video>-->
<!--		</div>-->
<!--		<div class="reel">-->
<!--			<video src="https://interactive-examples.mdn.mozilla.net/media/cc0-videos/flower.mp4" muted loop onclick="this.paused ? this.play() : this.pause()"></video>-->
<!--		</div>-->
<!--		<div class="reel">-->
<!--			<video src="https://media.w3.org/2010/05/sintel/trailer_hd.mp4" muted loop onclick="this.paused ? this.play() : this.pause()"></video>-->
<!--		</div>-->
<!--		<div class="reel">-->
<!--			<video src="https://media.w3.org/2010/05/bunny/trailer.mp4" muted loop onclick="this.paused ? this.play() : this.pause()"></video>-->
<!--		</div>-->
<!--	</div>-->
<!--</section>-->
--}}

<!--<div class="horizontal-reels-container">-->
	<!--Reel 1 -->
<!--	<div class="reel-card">-->
<!--		<div class="reel-video">-->
<!--			<blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/p/CFa2HjTFcTf/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);">-->
<!--				<div style="padding:16px;">-->
<!--					<a href="https://www.instagram.com/p/CFa2HjTFcTf/?utm_source=ig_embed&amp;utm_campaign=loading" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank">-->
<!--						<div style=" display: flex; flex-direction: row; align-items: center;">-->
<!--							<div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div>-->
<!--							<div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;">-->
<!--								<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div>-->
<!--								<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div>-->
<!--							</div>-->
<!--						</div>-->
<!--						<div style="padding: 19% 0;"></div>-->
<!--						<div style="display:block; height:50px; margin:0 auto 12px; width:50px;">-->
<!--							<svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink">-->
<!--								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">-->
<!--									<g transform="translate(-511.000000, -20.000000)" fill="#000000">-->
<!--										<g>-->
<!--											<path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path>-->
<!--										</g>-->
<!--									</g>-->
<!--								</g>-->
<!--							</svg>-->
<!--						</div>-->
<!--						<div style="padding-top: 8px;">-->
<!--							<div style=" color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;">View this post on Instagram</div>-->
<!--						</div>-->
<!--						<div style="padding: 12.5% 0;"></div>-->
<!--						<div style="display: flex; flex-direction: row; margin-bottom: 14px; align-items: center;">-->
<!--							<div>-->
<!--								<div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(0px) translateY(7px);"></div>-->
<!--								<div style="background-color: #F4F4F4; height: 12.5px; transform: rotate(-45deg) translateX(3px) translateY(1px); width: 12.5px; flex-grow: 0; margin-right: 14px; margin-left: 2px;"></div>-->
<!--								<div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(9px) translateY(-18px);"></div>-->
<!--							</div>-->
<!--							<div style="margin-left: 8px;">-->
<!--								<div style=" background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 20px; width: 20px;"></div>-->
<!--								<div style=" width: 0; height: 0; border-top: 2px solid transparent; border-left: 6px solid #f4f4f4; border-bottom: 2px solid transparent; transform: translateX(16px) translateY(-4px) rotate(30deg)"></div>-->
<!--							</div>-->
<!--							<div style="margin-left: auto;">-->
<!--								<div style=" width: 0px; border-top: 8px solid #F4F4F4; border-right: 8px solid transparent; transform: translateY(16px);"></div>-->
<!--								<div style=" background-color: #F4F4F4; flex-grow: 0; height: 12px; width: 16px; transform: translateY(-4px);"></div>-->
<!--								<div style=" width: 0; height: 0; border-top: 8px solid #F4F4F4; border-left: 8px solid transparent; transform: translateY(-4px) translateX(8px);"></div>-->
<!--							</div>-->
<!--						</div>-->
<!--						<div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center; margin-bottom: 24px;">-->
<!--							<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 224px;"></div>-->
<!--							<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 144px;"></div>-->
<!--						</div>-->
<!--					</a>-->
<!--					<p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;"><a href="https://www.instagram.com/p/CFa2HjTFcTf/?utm_source=ig_embed&amp;utm_campaign=loading" style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none;" target="_blank">A post shared by Vintage &amp; Antique Jewelry (@trademarkantiques)</a></p>-->
<!--				</div>-->
<!--			</blockquote>-->
<!--			<script async src="//www.instagram.com/embed.js"></script>-->
<!--		</div>-->
<!--		<div class="reel-content">-->
<!--			<h3 class="reel-title">New Summer Collection</h3>-->
<!--			<p class="reel-description">30% off for first 100 customers</p>-->
<!--			<div class="reel-actions">-->
<!--				<button class="reel-button cta">Shop Now</button>-->
<!--				<div class="reel-stats">-->
<!--					<div class="reel-stat">-->
<!--						<i class="far fa-heart"></i>-->
<!--						<span>24.5k</span>-->
<!--					</div>-->
<!--					<div class="reel-stat">-->
<!--						<i class="fas fa-share"></i>-->
<!--						<span>Share</span>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
	<!--Reel 2 -->
<!--	<div class="reel-card">-->
<!--		<div class="reel-video">-->
<!--			<div class="video-placeholder">-->
<!--				<blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/p/BxY3kELnzzV/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);">-->
<!--					<div style="padding:16px;">-->
<!--						<a href="https://www.instagram.com/p/BxY3kELnzzV/?utm_source=ig_embed&amp;utm_campaign=loading" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank">-->
<!--							<div style=" display: flex; flex-direction: row; align-items: center;">-->
<!--								<div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div>-->
<!--								<div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;">-->
<!--									<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div>-->
<!--									<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div>-->
<!--								</div>-->
<!--							</div>-->
<!--							<div style="padding: 19% 0;"></div>-->
<!--							<div style="display:block; height:50px; margin:0 auto 12px; width:50px;">-->
<!--								<svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink">-->
<!--									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">-->
<!--										<g transform="translate(-511.000000, -20.000000)" fill="#000000">-->
<!--											<g>-->
<!--												<path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path>-->
<!--											</g>-->
<!--										</g>-->
<!--									</g>-->
<!--								</svg>-->
<!--							</div>-->
<!--							<div style="padding-top: 8px;">-->
<!--								<div style=" color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;">View this post on Instagram</div>-->
<!--							</div>-->
<!--							<div style="padding: 12.5% 0;"></div>-->
<!--							<div style="display: flex; flex-direction: row; margin-bottom: 14px; align-items: center;">-->
<!--								<div>-->
<!--									<div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(0px) translateY(7px);"></div>-->
<!--									<div style="background-color: #F4F4F4; height: 12.5px; transform: rotate(-45deg) translateX(3px) translateY(1px); width: 12.5px; flex-grow: 0; margin-right: 14px; margin-left: 2px;"></div>-->
<!--									<div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(9px) translateY(-18px);"></div>-->
<!--								</div>-->
<!--								<div style="margin-left: 8px;">-->
<!--									<div style=" background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 20px; width: 20px;"></div>-->
<!--									<div style=" width: 0; height: 0; border-top: 2px solid transparent; border-left: 6px solid #f4f4f4; border-bottom: 2px solid transparent; transform: translateX(16px) translateY(-4px) rotate(30deg)"></div>-->
<!--								</div>-->
<!--								<div style="margin-left: auto;">-->
<!--									<div style=" width: 0px; border-top: 8px solid #F4F4F4; border-right: 8px solid transparent; transform: translateY(16px);"></div>-->
<!--									<div style=" background-color: #F4F4F4; flex-grow: 0; height: 12px; width: 16px; transform: translateY(-4px);"></div>-->
<!--									<div style=" width: 0; height: 0; border-top: 8px solid #F4F4F4; border-left: 8px solid transparent; transform: translateY(-4px) translateX(8px);"></div>-->
<!--								</div>-->
<!--							</div>-->
<!--							<div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center; margin-bottom: 24px;">-->
<!--								<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 224px;"></div>-->
<!--								<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 144px;"></div>-->
<!--							</div>-->
<!--						</a>-->
<!--						<p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;"><a href="https://www.instagram.com/p/BxY3kELnzzV/?utm_source=ig_embed&amp;utm_campaign=loading" style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none;" target="_blank">A post shared by SUVARNAKALA (@myjewelegance)</a></p>-->
<!--					</div>-->
<!--				</blockquote>-->
<!--				<script async src="//www.instagram.com/embed.js"></script>-->
<!--			</div>-->
<!--		</div>-->
<!--		<div class="reel-content">-->
<!--			<h3 class="reel-title">Latest Tech</h3>-->
<!--			<p class="reel-description">Cutting-edge technology</p>-->
<!--			<div class="reel-actions">-->
<!--				<button class="reel-button cta">Explore</button>-->
<!--				<div class="reel-stats">-->
<!--					<div class="reel-stat">-->
<!--						<i class="far fa-heart"></i>-->
<!--						<span>18.7k</span>-->
<!--					</div>-->
<!--					<div class="reel-stat">-->
<!--						<i class="fas fa-share"></i>-->
<!--						<span>Share</span>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
	<!--Reel 3 -->
<!--	<div class="reel-card">-->
<!--		<div class="reel-video">-->
<!--			<div class="video-placeholder">-->
<!--				<blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/p/CRUTgrKn-nP/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);">-->
<!--					<div style="padding:16px;">-->
<!--						<a href="https://www.instagram.com/p/CRUTgrKn-nP/?utm_source=ig_embed&amp;utm_campaign=loading" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank">-->
<!--							<div style=" display: flex; flex-direction: row; align-items: center;">-->
<!--								<div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div>-->
<!--								<div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;">-->
<!--									<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div>-->
<!--									<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div>-->
<!--								</div>-->
<!--							</div>-->
<!--							<div style="padding: 19% 0;"></div>-->
<!--							<div style="display:block; height:50px; margin:0 auto 12px; width:50px;">-->
<!--								<svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink">-->
<!--									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">-->
<!--										<g transform="translate(-511.000000, -20.000000)" fill="#000000">-->
<!--											<g>-->
<!--												<path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path>-->
<!--											</g>-->
<!--										</g>-->
<!--									</g>-->
<!--								</svg>-->
<!--							</div>-->
<!--							<div style="padding-top: 8px;">-->
<!--								<div style=" color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;">View this post on Instagram</div>-->
<!--							</div>-->
<!--							<div style="padding: 12.5% 0;"></div>-->
<!--							<div style="display: flex; flex-direction: row; margin-bottom: 14px; align-items: center;">-->
<!--								<div>-->
<!--									<div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(0px) translateY(7px);"></div>-->
<!--									<div style="background-color: #F4F4F4; height: 12.5px; transform: rotate(-45deg) translateX(3px) translateY(1px); width: 12.5px; flex-grow: 0; margin-right: 14px; margin-left: 2px;"></div>-->
<!--									<div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(9px) translateY(-18px);"></div>-->
<!--								</div>-->
<!--								<div style="margin-left: 8px;">-->
<!--									<div style=" background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 20px; width: 20px;"></div>-->
<!--									<div style=" width: 0; height: 0; border-top: 2px solid transparent; border-left: 6px solid #f4f4f4; border-bottom: 2px solid transparent; transform: translateX(16px) translateY(-4px) rotate(30deg)"></div>-->
<!--								</div>-->
<!--								<div style="margin-left: auto;">-->
<!--									<div style=" width: 0px; border-top: 8px solid #F4F4F4; border-right: 8px solid transparent; transform: translateY(16px);"></div>-->
<!--									<div style=" background-color: #F4F4F4; flex-grow: 0; height: 12px; width: 16px; transform: translateY(-4px);"></div>-->
<!--									<div style=" width: 0; height: 0; border-top: 8px solid #F4F4F4; border-left: 8px solid transparent; transform: translateY(-4px) translateX(8px);"></div>-->
<!--								</div>-->
<!--							</div>-->
<!--							<div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center; margin-bottom: 24px;">-->
<!--								<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 224px;"></div>-->
<!--								<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 144px;"></div>-->
<!--							</div>-->
<!--						</a>-->
<!--						<p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;"><a href="https://www.instagram.com/p/CRUTgrKn-nP/?utm_source=ig_embed&amp;utm_campaign=loading" style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none;" target="_blank">A post shared by Navid Minbashi (@navidminbashi)</a></p>-->
<!--					</div>-->
<!--				</blockquote>-->
<!--				<script async src="//www.instagram.com/embed.js"></script>-->
<!--			</div>-->
<!--		</div>-->
<!--		<div class="reel-content">-->
<!--			<h3 class="reel-title">30-Day Challenge</h3>-->
<!--			<p class="reel-description">Transform your body</p>-->
<!--			<div class="reel-actions">-->
<!--				<button class="reel-button cta">Join Now</button>-->
<!--				<div class="reel-stats">-->
<!--					<div class="reel-stat">-->
<!--						<i class="far fa-heart"></i>-->
<!--						<span>32.1k</span>-->
<!--					</div>-->
<!--					<div class="reel-stat">-->
<!--						<i class="fas fa-share"></i>-->
<!--						<span>Share</span>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
	<!--Reel 4 -->
<!--	<div class="reel-card">-->
<!--		<div class="reel-video">-->
<!--			<div class="video-placeholder">-->
<!--				<blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/p/CBVdh_nltGW/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);">-->
<!--					<div style="padding:16px;">-->
<!--						<a href="https://www.instagram.com/p/CBVdh_nltGW/?utm_source=ig_embed&amp;utm_campaign=loading" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank">-->
<!--							<div style=" display: flex; flex-direction: row; align-items: center;">-->
<!--								<div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div>-->
<!--								<div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;">-->
<!--									<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div>-->
<!--									<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div>-->
<!--								</div>-->
<!--							</div>-->
<!--							<div style="padding: 19% 0;"></div>-->
<!--							<div style="display:block; height:50px; margin:0 auto 12px; width:50px;">-->
<!--								<svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink">-->
<!--									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">-->
<!--										<g transform="translate(-511.000000, -20.000000)" fill="#000000">-->
<!--											<g>-->
<!--												<path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path>-->
<!--											</g>-->
<!--										</g>-->
<!--									</g>-->
<!--								</svg>-->
<!--							</div>-->
<!--							<div style="padding-top: 8px;">-->
<!--								<div style=" color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;">View this post on Instagram</div>-->
<!--							</div>-->
<!--							<div style="padding: 12.5% 0;"></div>-->
<!--							<div style="display: flex; flex-direction: row; margin-bottom: 14px; align-items: center;">-->
<!--								<div>-->
<!--									<div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(0px) translateY(7px);"></div>-->
<!--									<div style="background-color: #F4F4F4; height: 12.5px; transform: rotate(-45deg) translateX(3px) translateY(1px); width: 12.5px; flex-grow: 0; margin-right: 14px; margin-left: 2px;"></div>-->
<!--									<div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(9px) translateY(-18px);"></div>-->
<!--								</div>-->
<!--								<div style="margin-left: 8px;">-->
<!--									<div style=" background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 20px; width: 20px;"></div>-->
<!--									<div style=" width: 0; height: 0; border-top: 2px solid transparent; border-left: 6px solid #f4f4f4; border-bottom: 2px solid transparent; transform: translateX(16px) translateY(-4px) rotate(30deg)"></div>-->
<!--								</div>-->
<!--								<div style="margin-left: auto;">-->
<!--									<div style=" width: 0px; border-top: 8px solid #F4F4F4; border-right: 8px solid transparent; transform: translateY(16px);"></div>-->
<!--									<div style=" background-color: #F4F4F4; flex-grow: 0; height: 12px; width: 16px; transform: translateY(-4px);"></div>-->
<!--									<div style=" width: 0; height: 0; border-top: 8px solid #F4F4F4; border-left: 8px solid transparent; transform: translateY(-4px) translateX(8px);"></div>-->
<!--								</div>-->
<!--							</div>-->
<!--							<div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center; margin-bottom: 24px;">-->
<!--								<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 224px;"></div>-->
<!--								<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 144px;"></div>-->
<!--							</div>-->
<!--						</a>-->
<!--						<p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;"><a href="https://www.instagram.com/p/CBVdh_nltGW/?utm_source=ig_embed&amp;utm_campaign=loading" style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none;" target="_blank">A post shared by Silversashti - Silver Jewellery (@silversashti)</a></p>-->
<!--					</div>-->
<!--				</blockquote>-->
<!--				<script async src="//www.instagram.com/embed.js"></script>-->
<!--			</div>-->
<!--		</div>-->
<!--		<div class="reel-content">-->
<!--			<h3 class="reel-title">Exotic Getaways</h3>-->
<!--			<p class="reel-description">Dream vacation</p>-->
<!--			<div class="reel-actions">-->
<!--				<button class="reel-button cta">Book Now</button>-->
<!--				<div class="reel-stats">-->
<!--					<div class="reel-stat">-->
<!--						<i class="far fa-heart"></i>-->
<!--						<span>28.9k</span>-->
<!--					</div>-->
<!--					<div class="reel-stat">-->
<!--						<i class="fas fa-share"></i>-->
<!--						<span>Share</span>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
	<!--Reel 5 -->
<!--	<div class="reel-card">-->
<!--		<div class="reel-video">-->
<!--			<div class="video-placeholder">-->
<!--				<blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/p/CBnGvGkJ3pr/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);">-->
<!--					<div style="padding:16px;">-->
<!--						<a href="https://www.instagram.com/p/CBnGvGkJ3pr/?utm_source=ig_embed&amp;utm_campaign=loading" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank">-->
<!--							<div style=" display: flex; flex-direction: row; align-items: center;">-->
<!--								<div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div>-->
<!--								<div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;">-->
<!--									<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div>-->
<!--									<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div>-->
<!--								</div>-->
<!--							</div>-->
<!--							<div style="padding: 19% 0;"></div>-->
<!--							<div style="display:block; height:50px; margin:0 auto 12px; width:50px;">-->
<!--								<svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink">-->
<!--									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">-->
<!--										<g transform="translate(-511.000000, -20.000000)" fill="#000000">-->
<!--											<g>-->
<!--												<path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path>-->
<!--											</g>-->
<!--										</g>-->
<!--									</g>-->
<!--								</svg>-->
<!--							</div>-->
<!--							<div style="padding-top: 8px;">-->
<!--								<div style=" color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;">View this post on Instagram</div>-->
<!--							</div>-->
<!--							<div style="padding: 12.5% 0;"></div>-->
<!--							<div style="display: flex; flex-direction: row; margin-bottom: 14px; align-items: center;">-->
<!--								<div>-->
<!--									<div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(0px) translateY(7px);"></div>-->
<!--									<div style="background-color: #F4F4F4; height: 12.5px; transform: rotate(-45deg) translateX(3px) translateY(1px); width: 12.5px; flex-grow: 0; margin-right: 14px; margin-left: 2px;"></div>-->
<!--									<div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(9px) translateY(-18px);"></div>-->
<!--								</div>-->
<!--								<div style="margin-left: 8px;">-->
<!--									<div style=" background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 20px; width: 20px;"></div>-->
<!--									<div style=" width: 0; height: 0; border-top: 2px solid transparent; border-left: 6px solid #f4f4f4; border-bottom: 2px solid transparent; transform: translateX(16px) translateY(-4px) rotate(30deg)"></div>-->
<!--								</div>-->
<!--								<div style="margin-left: auto;">-->
<!--									<div style=" width: 0px; border-top: 8px solid #F4F4F4; border-right: 8px solid transparent; transform: translateY(16px);"></div>-->
<!--									<div style=" background-color: #F4F4F4; flex-grow: 0; height: 12px; width: 16px; transform: translateY(-4px);"></div>-->
<!--									<div style=" width: 0; height: 0; border-top: 8px solid #F4F4F4; border-left: 8px solid transparent; transform: translateY(-4px) translateX(8px);"></div>-->
<!--								</div>-->
<!--							</div>-->
<!--							<div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center; margin-bottom: 24px;">-->
<!--								<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 224px;"></div>-->
<!--								<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 144px;"></div>-->
<!--							</div>-->
<!--						</a>-->
<!--						<p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;"><a href="https://www.instagram.com/p/CBnGvGkJ3pr/?utm_source=ig_embed&amp;utm_campaign=loading" style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none;" target="_blank">A post shared by Nita (@arunitapraharaj)</a></p>-->
<!--					</div>-->
<!--				</blockquote>-->
<!--				<script async src="//www.instagram.com/embed.js"></script>-->
<!--			</div>-->
<!--		</div>-->
<!--		<div class="reel-content">-->
<!--			<h3 class="reel-title">Gourmet Meals</h3>-->
<!--			<p class="reel-description">50% off first order</p>-->
<!--			<div class="reel-actions">-->
<!--				<button class="reel-button cta">Order Now</button>-->
<!--				<div class="reel-stats">-->
<!--					<div class="reel-stat">-->
<!--						<i class="far fa-heart"></i>-->
<!--						<span>15.3k</span>-->
<!--					</div>-->
<!--					<div class="reel-stat">-->
<!--						<i class="fas fa-share"></i>-->
<!--						<span>Share</span>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
	<!--Reel 6 -->
<!--	<div class="reel-card">-->
<!--		<div class="reel-video">-->
<!--			<div class="video-placeholder">-->
<!--				<blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/tv/CbrVJvhDyK-/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);">-->
<!--					<div style="padding:16px;">-->
<!--						<a href="https://www.instagram.com/tv/CbrVJvhDyK-/?utm_source=ig_embed&amp;utm_campaign=loading" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank">-->
<!--							<div style=" display: flex; flex-direction: row; align-items: center;">-->
<!--								<div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div>-->
<!--								<div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;">-->
<!--									<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div>-->
<!--									<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div>-->
<!--								</div>-->
<!--							</div>-->
<!--							<div style="padding: 19% 0;"></div>-->
<!--							<div style="display:block; height:50px; margin:0 auto 12px; width:50px;">-->
<!--								<svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink">-->
<!--									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">-->
<!--										<g transform="translate(-511.000000, -20.000000)" fill="#000000">-->
<!--											<g>-->
<!--												<path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path>-->
<!--											</g>-->
<!--										</g>-->
<!--									</g>-->
<!--								</svg>-->
<!--							</div>-->
<!--							<div style="padding-top: 8px;">-->
<!--								<div style=" color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;">View this post on Instagram</div>-->
<!--							</div>-->
<!--							<div style="padding: 12.5% 0;"></div>-->
<!--							<div style="display: flex; flex-direction: row; margin-bottom: 14px; align-items: center;">-->
<!--								<div>-->
<!--									<div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(0px) translateY(7px);"></div>-->
<!--									<div style="background-color: #F4F4F4; height: 12.5px; transform: rotate(-45deg) translateX(3px) translateY(1px); width: 12.5px; flex-grow: 0; margin-right: 14px; margin-left: 2px;"></div>-->
<!--									<div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(9px) translateY(-18px);"></div>-->
<!--								</div>-->
<!--								<div style="margin-left: 8px;">-->
<!--									<div style=" background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 20px; width: 20px;"></div>-->
<!--									<div style=" width: 0; height: 0; border-top: 2px solid transparent; border-left: 6px solid #f4f4f4; border-bottom: 2px solid transparent; transform: translateX(16px) translateY(-4px) rotate(30deg)"></div>-->
<!--								</div>-->
<!--								<div style="margin-left: auto;">-->
<!--									<div style=" width: 0px; border-top: 8px solid #F4F4F4; border-right: 8px solid transparent; transform: translateY(16px);"></div>-->
<!--									<div style=" background-color: #F4F4F4; flex-grow: 0; height: 12px; width: 16px; transform: translateY(-4px);"></div>-->
<!--									<div style=" width: 0; height: 0; border-top: 8px solid #F4F4F4; border-left: 8px solid transparent; transform: translateY(-4px) translateX(8px);"></div>-->
<!--								</div>-->
<!--							</div>-->
<!--							<div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center; margin-bottom: 24px;">-->
<!--								<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 224px;"></div>-->
<!--								<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 144px;"></div>-->
<!--							</div>-->
<!--						</a>-->
<!--						<p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;"><a href="https://www.instagram.com/tv/CbrVJvhDyK-/?utm_source=ig_embed&amp;utm_campaign=loading" style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none;" target="_blank">A post shared by Pal D&#39;zigns . Wedding Jewel (@paldzigns.jewel)</a></p>-->
<!--					</div>-->
<!--				</blockquote>-->
<!--				<script async src="//www.instagram.com/embed.js"></script>-->
<!--			</div>-->
<!--		</div>-->
<!--		<div class="reel-content">-->
<!--			<h3 class="reel-title">Modern Home</h3>-->
<!--			<p class="reel-description">Stylish furniture</p>-->
<!--			<div class="reel-actions">-->
<!--				<button class="reel-button cta">View</button>-->
<!--				<div class="reel-stats">-->
<!--					<div class="reel-stat">-->
<!--						<i class="far fa-heart"></i>-->
<!--						<span>12.6k</span>-->
<!--					</div>-->
<!--					<div class="reel-stat">-->
<!--						<i class="fas fa-share"></i>-->
<!--						<span>Share</span>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
	<!--Reel 7 -->
<!--	<div class="reel-card">-->
<!--		<div class="reel-video">-->
<!--			<div class="video-placeholder">-->
<!--				<blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/tv/CcQUWxVjFsV/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);">-->
<!--					<div style="padding:16px;">-->
<!--						<a href="https://www.instagram.com/tv/CcQUWxVjFsV/?utm_source=ig_embed&amp;utm_campaign=loading" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank">-->
<!--							<div style=" display: flex; flex-direction: row; align-items: center;">-->
<!--								<div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div>-->
<!--								<div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;">-->
<!--									<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div>-->
<!--									<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div>-->
<!--								</div>-->
<!--							</div>-->
<!--							<div style="padding: 19% 0;"></div>-->
<!--							<div style="display:block; height:50px; margin:0 auto 12px; width:50px;">-->
<!--								<svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink">-->
<!--									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">-->
<!--										<g transform="translate(-511.000000, -20.000000)" fill="#000000">-->
<!--											<g>-->
<!--												<path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path>-->
<!--											</g>-->
<!--										</g>-->
<!--									</g>-->
<!--								</svg>-->
<!--							</div>-->
<!--							<div style="padding-top: 8px;">-->
<!--								<div style=" color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;">View this post on Instagram</div>-->
<!--							</div>-->
<!--							<div style="padding: 12.5% 0;"></div>-->
<!--							<div style="display: flex; flex-direction: row; margin-bottom: 14px; align-items: center;">-->
<!--								<div>-->
<!--									<div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(0px) translateY(7px);"></div>-->
<!--									<div style="background-color: #F4F4F4; height: 12.5px; transform: rotate(-45deg) translateX(3px) translateY(1px); width: 12.5px; flex-grow: 0; margin-right: 14px; margin-left: 2px;"></div>-->
<!--									<div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(9px) translateY(-18px);"></div>-->
<!--								</div>-->
<!--								<div style="margin-left: 8px;">-->
<!--									<div style=" background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 20px; width: 20px;"></div>-->
<!--									<div style=" width: 0; height: 0; border-top: 2px solid transparent; border-left: 6px solid #f4f4f4; border-bottom: 2px solid transparent; transform: translateX(16px) translateY(-4px) rotate(30deg)"></div>-->
<!--								</div>-->
<!--								<div style="margin-left: auto;">-->
<!--									<div style=" width: 0px; border-top: 8px solid #F4F4F4; border-right: 8px solid transparent; transform: translateY(16px);"></div>-->
<!--									<div style=" background-color: #F4F4F4; flex-grow: 0; height: 12px; width: 16px; transform: translateY(-4px);"></div>-->
<!--									<div style=" width: 0; height: 0; border-top: 8px solid #F4F4F4; border-left: 8px solid transparent; transform: translateY(-4px) translateX(8px);"></div>-->
<!--								</div>-->
<!--							</div>-->
<!--							<div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center; margin-bottom: 24px;">-->
<!--								<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 224px;"></div>-->
<!--								<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 144px;"></div>-->
<!--							</div>-->
<!--						</a>-->
<!--						<p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;"><a href="https://www.instagram.com/tv/CcQUWxVjFsV/?utm_source=ig_embed&amp;utm_campaign=loading" style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none;" target="_blank">A post shared by Pal D&#39;zigns . Wedding Jewel (@paldzigns.jewel)</a></p>-->
<!--					</div>-->
<!--				</blockquote>-->
<!--				<script async src="//www.instagram.com/embed.js"></script>-->
<!--			</div>-->
<!--		</div>-->
<!--		<div class="reel-content">-->
<!--			<h3 class="reel-title">Skincare</h3>-->
<!--			<p class="reel-description">Glowing skin</p>-->
<!--			<div class="reel-actions">-->
<!--				<button class="reel-button cta">Shop Now</button>-->
<!--				<div class="reel-stats">-->
<!--					<div class="reel-stat">-->
<!--						<i class="far fa-heart"></i>-->
<!--						<span>21.4k</span>-->
<!--					</div>-->
<!--					<div class="reel-stat">-->
<!--						<i class="fas fa-share"></i>-->
<!--						<span>Share</span>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
	<!--Reel 8 -->
<!--	<div class="reel-card">-->
<!--		<div class="reel-video">-->
<!--			<div class="video-placeholder">-->
<!--				<blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/tv/CkBGBhDAVVP/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);">-->
<!--					<div style="padding:16px;">-->
<!--						<a href="https://www.instagram.com/tv/CkBGBhDAVVP/?utm_source=ig_embed&amp;utm_campaign=loading" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank">-->
<!--							<div style=" display: flex; flex-direction: row; align-items: center;">-->
<!--								<div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div>-->
<!--								<div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;">-->
<!--									<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div>-->
<!--									<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div>-->
<!--								</div>-->
<!--							</div>-->
<!--							<div style="padding: 19% 0;"></div>-->
<!--							<div style="display:block; height:50px; margin:0 auto 12px; width:50px;">-->
<!--								<svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink">-->
<!--									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">-->
<!--										<g transform="translate(-511.000000, -20.000000)" fill="#000000">-->
<!--											<g>-->
<!--												<path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path>-->
<!--											</g>-->
<!--										</g>-->
<!--									</g>-->
<!--								</svg>-->
<!--							</div>-->
<!--							<div style="padding-top: 8px;">-->
<!--								<div style=" color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;">View this post on Instagram</div>-->
<!--							</div>-->
<!--							<div style="padding: 12.5% 0;"></div>-->
<!--							<div style="display: flex; flex-direction: row; margin-bottom: 14px; align-items: center;">-->
<!--								<div>-->
<!--									<div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(0px) translateY(7px);"></div>-->
<!--									<div style="background-color: #F4F4F4; height: 12.5px; transform: rotate(-45deg) translateX(3px) translateY(1px); width: 12.5px; flex-grow: 0; margin-right: 14px; margin-left: 2px;"></div>-->
<!--									<div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(9px) translateY(-18px);"></div>-->
<!--								</div>-->
<!--								<div style="margin-left: 8px;">-->
<!--									<div style=" background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 20px; width: 20px;"></div>-->
<!--									<div style=" width: 0; height: 0; border-top: 2px solid transparent; border-left: 6px solid #f4f4f4; border-bottom: 2px solid transparent; transform: translateX(16px) translateY(-4px) rotate(30deg)"></div>-->
<!--								</div>-->
<!--								<div style="margin-left: auto;">-->
<!--									<div style=" width: 0px; border-top: 8px solid #F4F4F4; border-right: 8px solid transparent; transform: translateY(16px);"></div>-->
<!--									<div style=" background-color: #F4F4F4; flex-grow: 0; height: 12px; width: 16px; transform: translateY(-4px);"></div>-->
<!--									<div style=" width: 0; height: 0; border-top: 8px solid #F4F4F4; border-left: 8px solid transparent; transform: translateY(-4px) translateX(8px);"></div>-->
<!--								</div>-->
<!--							</div>-->
<!--							<div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center; margin-bottom: 24px;">-->
<!--								<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 224px;"></div>-->
<!--								<div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 144px;"></div>-->
<!--							</div>-->
<!--						</a>-->
<!--						<p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;"><a href="https://www.instagram.com/tv/CkBGBhDAVVP/?utm_source=ig_embed&amp;utm_campaign=loading" style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none;" target="_blank">A post shared by Bholasons Jewellers (@bholasonsjewellers)</a></p>-->
<!--					</div>-->
<!--				</blockquote>-->
<!--				<script async src="//www.instagram.com/embed.js"></script>-->
<!--			</div>-->
<!--		</div>-->
<!--		<div class="reel-content">-->
<!--			<h3 class="reel-title">New Model</h3>-->
<!--			<p class="reel-description">2023 launch</p>-->
<!--			<div class="reel-actions">-->
<!--				<button class="reel-button cta">Learn More</button>-->
<!--				<div class="reel-stats">-->
<!--					<div class="reel-stat">-->
<!--						<i class="far fa-heart"></i>-->
<!--						<span>19.8k</span>-->
<!--					</div>-->
<!--					<div class="reel-stat">-->
<!--						<i class="fas fa-share"></i>-->
<!--						<span>Share</span>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
<!--</div>-->
        {{-- Vedaro advertise products end --}}
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

        {{-- vedaro detailing  --}}
        <section class=" py-5 px-3" style="background-color: #FDF1E7;">
        	<div class="container mx-auto row g-4 text-center" style="max-width: 1140px">
        		<div class="col-12 col-md-4 d-flex flex-column align-items-center">
        			<svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#1E1E3F] mb-3" width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l8.5 5.1L20 7M3 17l8.5-5.1L20 17M3 12l8.5 5.1L20 12"></path>
        			</svg>
        			<h3 class="fs-5 fw-medium text-[#1E1E3F] mb-2">
        				Handcrafted Quality
        			</h3>
        			<p class="text-muted">
        				Every piece is designed with care and handcrafted by skilled artisans using ethically sourced silver.
        			</p>
        		</div>
        		<div class="col-12 col-md-4 d-flex flex-column align-items-center">
        			<svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#1E1E3F] mb-3" width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2a10 10 0 100 20 10 10 0 000-20zM2 12h20"></path>
        			</svg>
        			<h3 class="fs-5 fw-medium text-[#1E1E3F] mb-2">
        			Responsible Craftsmanship
        			</h3>
        			<p class="text-muted">
        				We’re committed to climate action through sustainable practices and mindful material choices.
        
        			</p>
        		</div>
        		<div class="col-12 col-md-4 d-flex flex-column align-items-center">
        			<svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#1E1E3F] mb-3" width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
        				<path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 6
        					3.5 4 5.5 4c1.54 0 3.04.99 3.57 2.36h1.87C13.46 4.99
        					14.96 4 16.5 4 18.5 4 20 6 20 8.5c0 3.78-3.4 6.86-8.55
        					11.54L12 21.35z"></path>
        			</svg>
        			<h3 class="fs-5 fw-medium text-[#1E1E3F] mb-2">Timeless Design</h3>
        			<p class="text-muted">
        				Our jewelry blends traditional artistry with modern elegance, made to be worn every day or treasured for years.
        			</p>
        		</div>
        	</div>
        </section>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
        <script src="{{ asset('public/assets/js/home.js') }}"></script>
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
        
        <!--script for categories scrolling section -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const slider = document.querySelector('.categories-slider');
                const prevBtn = document.querySelector('.slider-prev');
                const nextBtn = document.querySelector('.slider-next');
                
                // Calculate scroll amount (width of one category tile)
                function getScrollAmount() {
                    const tile = document.querySelector('.category-tile');
                    return tile ? tile.offsetWidth : 200;
                }
                
                // Previous button click
                prevBtn.addEventListener('click', function() {
                    slider.scrollBy({
                        left: -getScrollAmount(),
                        behavior: 'smooth'
                    });
                });
                
                // Next button click
                nextBtn.addEventListener('click', function() {
                    slider.scrollBy({
                        left: getScrollAmount(),
                        behavior: 'smooth'
                    });
                });
                
                // Hide/show arrows based on scroll position
                slider.addEventListener('scroll', function() {
                    prevBtn.style.display = slider.scrollLeft > 0 ? 'block' : 'none';
                    nextBtn.style.display = slider.scrollLeft < (slider.scrollWidth - slider.clientWidth) ? 'block' : 'none';
                });
                
                // Initialize arrow visibility
                slider.dispatchEvent(new Event('scroll'));
            });
        </script>
@endsection