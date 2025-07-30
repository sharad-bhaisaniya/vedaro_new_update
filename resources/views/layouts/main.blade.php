<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>@yield('title', 'Default Title')</title>
		<link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">
		<!--FavIcon-->
		<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('public/assets/images/VEDARO_logo.png') }}">
		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
		<!-- Font Awesome -->
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
		<!-- Conditional inclusion of Bootstrap for About Page only -->
		@if (Request::is('about'))
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
		@endif
		<script src="https://analytics.ahrefs.com/analytics.js" data-key="vc8HYOUfE/gGBDYwduVQjg" async></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
		<link rel="stylesheet" href="path/to/bootstrap.min.css">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link
			rel="stylesheet"
			href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"
			/>
		<link
			rel="stylesheet"
			href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"
			/>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
		<style>

			.limi_badge {
			background-color: #dc3545;
			color: white;
			font-size: 10px;
			padding: 2px 6px 0;
			border-radius: 4px;
			vertical-align: middle;
			margin-left: 4px;
			position: absolute;
			top: -5px;
			line-height: 16px;
			right: -15px;
			}
			/* ====== YOUR ORIGINAL HEADER BASE STYLES ====== */
			.main-header {
			padding: 12px 20px;
			border-bottom: 0.2px solid #000;
			background-color: #fefcf8;
			position: relative;
			}
			.navbar-brand {
			font-size: 30px;
			font-weight: 400;
			letter-spacing: 5px;
			font-family: 'Playfair Display', serif;
			color: #1c1c3b;
			}
			.nav-link {
			color: #1c1c3b !important;
			font-weight: 500;
			padding: 10px 15px;
			font-size: 14px;
			text-transform: uppercase;
			cursor: pointer;
			}
			.nav-link:hover {
			color: #1c1c3b !important;
			}
			/* ====== ICONS ====== */
			.header-icons i {
			font-size: 18px;
			color: #1c1c3b;
			/*margin-left: 18px;*/
			cursor: pointer;
			position: relative;
			color: white;
			}
			/* Cart count position for desktop */
			.cart-count {
			font-size: 10px;
			color: red;
			position: absolute;
			top: -5px;
			right: -5px;
			}
			/* ====== BACKDROP BLUR OVERLAY ====== */
			.dropdown-overlay {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			backdrop-filter: blur(8px);
			-webkit-backdrop-filter: blur(8px);
			background-color: rgba(255, 255, 255, 0.3);
			z-index: 900;
			display: none;
			}
			/* ====== MEGA MENU DROPDOWN (Desktop styles) ====== */
			/* Changed from left:0; width:100% to align under parent */
			.dropdown-mega {
			position: absolute;
			top: 100%;
			/* Keep 100% to be below nav link */
			left: 50%; /* Start at the center of the nav-item */
			transform: translateX(-50%); /* Pull back by half its width to truly center */
			/* max-width for "Shop All" to avoid breaking its layout, adjust as needed */
			max-width: 900px;
			width: max-content; /* Allow width to be content-driven for "Theme Features" */
			padding: 30px;
			background-color: rgba(255, 255, 255, 0.7);
			backdrop-filter: blur(12px);
			-webkit-backdrop-filter: blur(12px);
			box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
			display: none;
			z-index: 999;
			transition: all 0.3s ease;
			border-top: 1px solid rgba(0, 0, 0, 0.05);
			/* Ensure it doesn't go off screen for smaller desktop sizes */
			left: 0; /* Reset left for overall alignment within the container */
			right: 0; /* Allow it to stretch */
			margin-left: auto; /* Push it to the right */
			margin-right: auto; /* Pull it to the left */
			}
			/* Specific override for desktop mega menus to not overflow */
			.navbar-desktop .nav-item.position-static .dropdown-mega {
			left: 0; /* Reset to 0 for the nav-item's relative positioning */
			right: auto; /* Remove right constraint */
			transform: none; /* Remove translateX centering */
			width: 100%; /* Make it span the parent nav-item for consistency */
			max-width: unset; /* Allow full width within its context */
			}
			/* Further adjust for the "Theme Features" mega menu to be smaller */
			.dropdown-mega.show {
			display: block;
			opacity: 1;
			visibility: visible;
			transform: translateY(0);
			}
			.mega-column h6 {
			font-weight: bold;
			margin-bottom: 10px;
			font-size: 13px;
			color: #1c1c3b;
			text-transform: uppercase;
			}
			.mega-column a {
			display: block;
			color: #1c1c3b;
			font-size: 14px;
			margin-bottom: 8px;
			text-decoration: none;
			}
			.mega-column a:hover {
			color: #1c1c3b;
			}
			.mega-image img {
			width: 100%;
			max-width: 220px;
			border-radius: 5px;
			object-fit: cover;
			}
			.mega-image .caption {
			font-size: 13px;
			margin-top: 5px;
			color: #1c1c3b;
			}
			.mega-image .caption a {
			text-decoration: underline;
			color: #1c1c3b;
			}
			.mega-image .caption a:hover {
			color: #1c1c3b;
			}
			/* Dropdown and blur overlay */
			.dropdown-overlay.active {
			display: block;
			}
			/* Rotate dropdown icon on open */
			.nav-link svg {
			transition: transform 0.3s ease;
			}
			.nav-link.active svg {
			transform: rotate(180deg);
			}
			/* Link hover effect */
			.mega-column a:hover {
			border-bottom: 1px solid #111112;
			padding-bottom: 2px;
			transition: all 0.2s ease;
			}
			.nav-link {
			position: relative;
			display: inline-block;
			color: #1c1c3b;
			padding-bottom: 4px;
			transition: color 0.3s ease;
			}
			.nav-link::after {
			content: '';
			position: absolute;
			bottom: 0;
			left: 0;
			height: 2px;
			width: 0;
			background-color: #1c1c1d;
			transition: width 0.3s ease;
			}
			.nav-link:hover::after {
			width: 100%;
			}
			/* Link hover inside mega menu */
			.mega-column a,
			.mega-image .caption a {
			position: relative;
			display: inline-block;
			color: #1c1c3b;
			text-decoration: none;
			transition: color 0.3s ease;
			}
			.mega-column a::after,
			.mega-image .caption a::after {
			content: '';
			position: absolute;
			bottom: 0;
			left: 0;
			height: 1px;
			width: 0;
			background-color: #161617;
			transition: width 0.3s ease;
			}
			.mega-column a:hover,
			.mega-image .caption a:hover {
			color: #1d1d1e;
			}
			.mega-column a:hover::after,
			.mega-image .caption a:hover::after {
			width: 100%;
			}
			/* Blur background overlay */
			.dropdown-overlay {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			backdrop-filter: blur(10px);
			background: rgba(255, 255, 255, 0.3);
			z-index: 20;
			display: none;
			}
			.dropdown-overlay.active {
			display: block;
			}
			/* for logo name section in header */
			.navbar-brand-wrapper {
			position: static;
			transform: none;
			}
			.navbar-brand {
			font-size: 30px;
			font-weight: 600;
			font-family: 'Playfair Display', serif;
			letter-spacing: 5px;
			text-transform: uppercase;
			color: #1c1c3b;
			}
			/* in header style last icons */
			.header-icons .header-icon {
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 6px;
			color: #1a1a1a;
			transition: color 0.2s ease;
			}
			.header-icons .header-icon:hover {
			color: #1a1a1a;
			}
			/* Your original cart count style, applies to desktop primarily */
			.cart-count {
			padding: 2px 6px;
			font-size: 10px;
			bottom: 30px;
			left: 20px;
			}
			.navbar-nav .nav-item {
			display: flex;
			align-items: center;
			height: 100%;
			position: relative;
			}
			.navbar-nav .nav-link {
			display: flex;
			align-items: center;
			height: 100%;
			padding-top: 0.75rem;
			padding-bottom: 0.75rem;
			}
			header.main-header {
			position: fixed;
			width: 100%;
			top: 0px; /* Keep at 0px */
			z-index: 100;
			transition: all 0.3s ease-in-out;
			background-color: transparent;
			}
			header.main-header:hover {
			background-color: #eee;
			}
			/* Header remains at top, only background changes on scroll */
			header.main-header.scrolled {
			background-color: rgba(255, 255, 255, 0.95);
			/*box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);*/
			top: 0px; /* Ensure it stays at 0px */
			}
			#topbar {
			transition: transform 0.3s ease-in-out;
			}
			.mobile-mega-overlay{
			display: none;
			}
			/* ======== MOBILE SPECIFIC STYLES (lg breakpoint and below) ======== */
			@media (max-width: 991.98px) { /* Bootstrap's `lg` breakpoint */
			/* Hide desktop header components on mobile */
			.navbar-desktop {
			display: none !important;
			}
			/* Show mobile header components on mobile */
			.navbar-mobile {
			display: flex !important; /* Overrides d-none */
			}
			/* Adjust the logo positioning for mobile within the mobile navbar */
			.mobile-header-logo {
			position: absolute;
			left: 50%;
			transform: translateX(-50%);
			font-size: 24px; /* Slightly smaller logo for mobile */
			z-index: 1; /* Ensure logo is above other elements if needed */
			}
			/* Mobile Navbar Toggler */
			.navbar-toggler {
			z-index: 2; /* Ensure toggler is clickable */
			}
			/* Collapsible mobile menu (Side Drawer) */
			.navbar-collapse {
			position: fixed;
			top: 0;
			left: 0;
			width: 75%; /* Adjust width as needed */
			max-width: 300px; /* Max width for larger mobiles/tablets */
			height: 100%;
			background-color: rgba(255, 255, 255, 0.98);
			backdrop-filter: none;
			-webkit-backdrop-filter: none;
			z-index: 990;
			transform: translateX(-100%); /* Start off-screen to the left */
			transition: transform 0.3s ease-in-out;
			overflow-y: auto; /* Enable scrolling for long menus */
			padding: 20px;
			box-shadow: 2px 0 10px rgba(0,0,0,0.1); /* Subtle shadow */
			}
			.navbar-collapse.show {
			transform: translateX(0%); /* Slide in */
			}
			.navbar-nav {
			flex-direction: column !important;
			align-items: flex-start !important;
			width: 100%;
			padding-top: 60px; /* Space for the close button and logo in mobile menu */
			}
			.nav-item {
			width: 100%;
			border-bottom: 1px solid #eee;
			margin-bottom: 0;
			}
			.nav-item:last-child {
			border-bottom: none;
			}
			.nav-link {
			width: 100%;
			justify-content: space-between;
			padding: 15px 0 !important;
			}
			/* Mobile Menu Close Button */
			.mobile-menu-close {
			position: absolute;
			top: 15px;
			right: 15px;
			font-size: 24px;
			color: #1c1c3b;
			background: none;
			border: none;
			cursor: pointer;
			z-index: 999; /* Ensure it's above other menu content */
			}
			/* Cart count for mobile icons - now in line with the icon */
			.header-icons .cart-count {
			position: absolute;
			top: -5px;
			right: -5px;
			padding: 2px 5px;
			/*background-color: red;*/
			/*color: white !important;*/
			border-radius: 50%;
			line-height: 1;
			min-width: 18px;
			min-height: 18px;
			display: flex;
			align-items: center;
			justify-content: center;
			transform: none;
			}
			/* ====== Mobile Mega Menu Overlay (New Behavior) ====== */
			.mobile-mega-overlay {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(255, 255, 255, 0.98); /* Solid background for content */
			z-index: 1000; /* Above main mobile menu and other overlays */
			display: none; /* Hidden by default */
			overflow-y: auto; /* Enable scrolling for content */
			padding: 20px;
			transform: translateX(100%); /* Start off-screen to the right */
			transition: transform 0.3s ease-in-out;
			}
			.mobile-mega-overlay.active {
			transform: translateX(0%); /* Slide in */
			display: block; /* Make sure it's block for transition */
			}
			.mobile-mega-overlay .mega-column {
			margin-bottom: 25px; /* More space between sections */
			}
			.mobile-mega-overlay .mega-column h6 {
			font-size: 16px; /* Larger heading */
			margin-bottom: 15px;
			}
			.mobile-mega-overlay .mega-column a {
			font-size: 16px; /* Larger links for better touch */
			padding: 8px 0;
			}
			.mobile-mega-overlay .mobile-mega-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding-bottom: 20px;
			border-bottom: 1px solid #eee;
			margin-bottom: 20px;
			}
			.mobile-mega-overlay .mobile-mega-title {
			font-size: 20px;
			font-weight: bold;
			color: #1c1c3b;
			}
			.mobile-mega-overlay .mobile-mega-close {
			font-size: 28px;
			color: #1c1c3b;
			background: none;
			border: none;
			cursor: pointer;
			}
			}
			/*Styling For Header Global-Search */
			.header-icon {
			color: #fff;
			text-decoration: none;
			position: relative;
			}
			.search-dropdown {
			position: absolute;
			top: 40px;
			right: 0;
			width: 350px;
			background: white;
			padding: 10px;
			border-radius: 8px;
			box-shadow: 0 6px 15px rgba(0,0,0,0.15);
			display: none;
			z-index: 999;
			}
			.search-dropdown input {
			border-radius: 5px;
			}
			.search-dropdown.show {
			display: block;
			}
			.search-container {
			position: relative;
			display: inline-block;
			}
			.collapse {
    visibility: visible !important;
}
		</style>
	</head>
	<body>
		<!-- Bootstrap Header -->
		<!-- Bootstrap Header with Full Z-Index -->
		<div class="dropdown-overlay" id="dropdownOverlay"></div>
		<div id="topbar" class="text-white small py-2 px-3 d-flex align-items-center justify-content-between fixed-top w-100"
			style="z-index: 20; height: 40px; transition: transform 0.3s ease; background-color:#2B2542;">
			<div>
				Private Sale at |
				<a href="/" class="text-white text-decoration-underline">VEDARO</a>
				    <p>Last page: {{ session('redirect_after_login') }}</p>
			</div>
			<div class="small">IND / INR</div>
		</div>
		<header class="main-header" style="margin-top: 40px; height: 90px;">
			<nav class="navbar navbar-expand-lg navbar-light">
				<div class="container-fluid d-flex align-items-center">
					<div class="d-none d-lg-flex w-100 justify-content-between align-items-center navbar-desktop">
						<ul class="navbar-nav flex-row align-items-center">
							<li class="nav-item">
								<a href="/" class="nav-link">Home</a>
							</li>
							<li class="nav-item position-static">
								<a class="nav-link d-flex align-items-center gap-1" data-bs-toggle="collapse" href="#shopAllDropdownDesktop" role="button" aria-expanded="false" aria-controls="shopAllDropdownDesktop">
									Shop All
									<svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="currentColor">
										<path d="M4.18179 6.18181C4.35753 6.00608 4.64245 6.00608 4.81819 6.18181L7.49999 8.86362L10.1818 6.18181C10.3575 6.00608 10.6424 6.00608 10.8182 6.18181C10.9939 6.35755 10.9939 6.64247 10.8182 6.81821L7.81819 9.81821C7.73379 9.9026 7.61934 9.95001 7.49999 9.95001C7.38064 9.95001 7.26618 9.9026 7.18179 9.81821L4.18179 6.81821C4.00605 6.64247 4.00605 6.35755 4.18179 6.18181Z" fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>
									</svg>
								</a>
								<div class="dropdown-mega collapse" id="shopAllDropdownDesktop">
									<div class="row">
										<div class="col-md-2 mega-column" style="    border-right: 2px solid #ccc;">
											<h6>Categories</h6>
											<ul>
											    @php
                                                    $minCategories = $categories->take(6); // Get only first 4 categories
                                                @endphp
												@foreach($minCategories as $category)
												<li>
													<a href="{{ route('categories_page', ['category' => $category->id]) }}" 
														class="category-item" 
														data-category-id="{{ $category->id }}">
													{{ $category->name }}
													</a>
												</li>
												@endforeach
												<li>
													<a href="{{route('shop')}}">
													Shop All
													</a>
												</li>
											</ul>
										</div>
										@foreach($categories->take(3) as $category)
										<div class="col-md-3 mega-image text-center mb-4"style="    max-width: 300px;text-transform-uppercase">
											<img src="{{ asset('public/storage/products/' . $category->image) }}" class="img-fluid" alt="{{ $category->name }}">
											<div class="caption">
												<a href="#">{{ $category->name }}</a>
											</div>
										</div>
										@endforeach
										<div class="col-md-2 mt-2 d-flex align-items-center" style="right:10px; ">
											<a href="{{ route('categories_page')}}" class=" d-flex align-items-center gap-1" >
											All Categories
											<i class="bi bi-arrow-right"></i>
											</a>
										</div>
									</div>
								</div>
							</li>
							<li class="nav-item">
								<a href="/about" class="nav-link">About Us</a>
							</li>
							{{--
							<li class="nav-item">
								<a href="/fetch-shiprocket-orders" class="nav-link">My Order</a>
							</li>
							--}}
							<li class="nav-item">
								<a href="/limited_edition" class="nav-link">
								Limited Edition <span class="limi_badge bg-success ms-1">New</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="/contact" class="nav-link">Contact</a>
							</li>
							<!--<li class="nav-item position-static">-->
							<!--    <a class="nav-link d-flex align-items-center gap-1" data-bs-toggle="collapse" href="#themeFeaturesDropdownDesktop" role="button" aria-expanded="false" aria-controls="themeFeaturesDropdownDesktop">-->
							<!--        Theme Features-->
							<!--        <svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="currentColor">-->
							<!--            <path d="M4.18179 6.18181C4.35753 6.00608 4.64245 6.00608 4.81819 6.18181L7.49999 8.86362L10.1818 6.18181C10.3575 6.00608 10.6424 6.00608 10.8182 6.18181C10.9939 6.35755 10.9939 6.64247 10.8182 6.81821L7.81819 9.81821C7.73379 9.9026 7.61934 9.95001 7.49999 9.95001C7.38064 9.95001 7.26618 9.9026 7.18179 9.81821L4.18179 6.81821C4.00605 6.64247 4.00605 6.35755 4.18179 6.18181Z" fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>-->
							<!--        </svg>-->
							<!--    </a>-->
							<!--    <div class="dropdown-mega collapse" id="themeFeaturesDropdownDesktop">-->
							<!--        <div class="row">-->
							<!--            <div class="col-md-1 mega-column">-->
							<!--                <h6>Demo Stores</h6>-->
							<!--                <a href="#">Distinction</a>-->
							<!--                <a href="#">Gloss</a>-->
							<!--                <a href="#">Artistry</a>-->
							<!--                <a href="#">Composition</a>-->
							<!--            </div>-->
							<!--            <div class="col-md-2 mega-column">-->
							<!--                <h6 style="width: 8rem;">Theme Features</h6>-->
							<!--            </div>-->
							<!--            <div class="col-md-1 align-middle mega-column">-->
							<!--                <h6 style="width: 8rem;">Product Layouts</h6>-->
							<!--                <a href="#">Slideshow</a>-->
							<!--                <a href="#">Thumbnails</a>-->
							<!--                <a href="#">Vertical Scroll</a>-->
							<!--            </div>-->
							<!--            <div class="col-md-3 mega-image text-center">-->
							<!--                <img src="https://primavera-precision.myshopify.com/cdn/shop/files/distinction-desktop_8f7c94b8-0e0b-4f4d-ae3b-1a70ee0bcf06.jpg?v=1743446862&width=600" class="img-fluid">-->
							<!--                <div class="caption"><a href="#">Distinction</a></div>-->
							<!--            </div>-->
							<!--            <div class="col-md-3 mega-image text-center">-->
							<!--                <img src="https://primavera-precision.myshopify.com/cdn/shop/files/gloss-desktop_b2f857f8-9716-4774-9d59-3bbea25d8431.jpg?v=1743446863&width=600" class="img-fluid">-->
							<!--                <div class="caption"><a href="#">Gloss</a></div>-->
							<!--            </div>-->
							<!--            <div class="col-md-3 mega-image text-center">-->
							<!--                <img src="https://primavera-precision.myshopify.com/cdn/shop/files/artistry-desktop.jpg?v=1739992521&width=600" class="img-fluid">-->
							<!--                <div class="caption"><a href="#">Artistry</a></div>-->
							<!--            </div>-->
							<!--        </div>-->
							<!--    </div>-->
							<!--</li>-->
						</ul>
						<h6 class="header__heading mobile-header-logo d-flex align-itms-center m-0">
							<a href="/" class="header__heading-link navbar-brand" style="text-decoration:none;">
								<div class="header__logo-wrapper">
									<!--<img src="{{ asset('public/assets/images/VEDARO_logo2.png') }}" style="width:20px;">-->
									VEDARO
								</div>
							</a>
						</h6>
						<div class="header-icons d-flex align-items-center gap-3">
							<a href="/login" class="header-icon" rel="nofollow" title="Log in">
								<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 15 15" fill="currentColor">
									<path d="M7.5 0.875C5.49797 0.875 3.875 2.49797 3.875 4.5C3.875 6.15288 4.98124 7.54738 6.49373 7.98351C5.2997 8.12901 4.27557 8.55134 3.50407 9.31167C2.52216 10.2794 2.02502 11.72 2.02502 13.5999C2.02502 13.8623 2.23769 14.0749 2.50002 14.0749C2.76236 14.0749 2.97502 13.8623 2.97502 13.5999C2.97502 11.8799 3.42786 10.7206 4.17091 9.9883C4.91536 9.25463 6.02674 8.87499 7.49995 8.87499C8.97317 8.87499 10.0846 9.25463 10.8291 9.98831C11.5721 10.7206 12.025 11.8799 12.025 13.5999C12.025 13.8623 12.2376 14.0749 12.5 14.0749C12.7623 14.075 12.975 13.8623 12.975 13.6C12.975 11.72 12.4778 10.2794 11.4959 9.31166C10.7244 8.55135 9.70025 8.12903 8.50625 7.98352C10.0187 7.5474 11.125 6.15289 11.125 4.5C11.125 2.49797 9.50203 0.875 7.5 0.875ZM4.825 4.5C4.825 3.02264 6.02264 1.825 7.5 1.825C8.97736 1.825 10.175 3.02264 10.175 4.5C10.175 5.97736 8.97736 7.175 7.5 7.175C6.02264 7.175 4.825 5.97736 4.825 4.5Z"/>
								</svg>
							</a>
							<!-- Search icon and dropdown -->
							<div class="search-container">
								<a href="javascript:void(0);" class="header-icon" id="searchToggle" title="Search">
									<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="black" viewBox="0 0 15 15">
										<path d="M10 6.5C10 8.433 8.433 10 6.5 10C4.567 10 3 8.433 3 6.5C3 4.567 4.567 3 6.5 3C8.433 3 10 4.567 10 6.5ZM9.30884 10.0159C8.53901 10.6318 7.56251 11 6.5 11C4.01472 11 2 8.98528 2 6.5C2 4.01472 4.01472 2 6.5 2C8.98528 2 11 4.01472 11 6.5C11 7.56251 10.6318 8.53901 10.0159 9.30884L12.8536 12.1464C13.0488 12.3417 13.0488 12.6583 12.8536 12.8536C12.6583 13.0488 12.3417 13.0488 12.1464 12.8536L9.30884 10.0159Z"/>
									</svg>
								</a>
								<div class="search-dropdown" id="searchDropdown">
									<form action="{{ route('global.search') }}" method="GET" class="d-flex">
										<input type="text" name="q" class="form-control me-2" placeholder="Search products or categories..." required>
										<button type="submit" class="btn btn-primary">
										<i class="fas fa-search"></i>
										</button>
									</form>
								</div>
							</div>
							<a href="/cart" class="header-icon position-relative" title="Cart">
								<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 15 15" fill="currentColor">
									<path d="m3.16,13.24c-.62,0-1.03-.48-1.12-1.12l-.56-5.82c-.08-.67.51-1.12,1.12-1.12h9.81c.62.01,1.2.47,1.12,1.13l-.56,5.82c-.09.65-.51,1.12-1.12,1.12H3.16Z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="1"/>
									<path d="m3.93,5.18c0-1.98,1.6-3.58,3.58-3.58s3.58,1.6,3.58,3.58" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="1"/>
								</svg>
								<!--<span class="cart-count position-absolute top-0 bottom-2 start-80 translate-middle badge rounded-pill text-dark" style="font-size: 10px;">0</span>-->
								<!--<span id="cart_counter" class="cart-count position-absolute top-2 bottom-2 start-80 translate-middle badge rounded-pill text-dark" style="font-size: 10px;left:25px;top:2px;" style="font-size: 10px;">0</span>-->
								<!-- For desktop -->
								<span id="cart_counter" class="cart-count position-absolute top-2 bottom-2 start-80 translate-middle rounded-pill text-dark" style="font-size: 10px; left:25px; top:2px;">0</span>
							</a>
						</div>
					</div>
					<div class="d-lg-none w-100 d-flex justify-content-between align-items-center navbar-mobile">
						<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavMobile"
							aria-controls="navbarNavMobile" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
						</button>
						<!--<h6 class="header__heading mobile-header-logo" style="text-align: center; margin:0;">-->
						<!--    <a href="/" class="header__heading-link navbar-brand" style='text-decoration:none;'>-->
						<!--        <div class="header__logo-wrapper">-->
						<!--            VEDARO-->
						<!--        </div>-->
						<!--    </a>-->
						<!--</h6>-->
						<h6 class="header__heading mobile-header-logo d-flex align-items-center m-0">
							<a href="/" class="header__heading-link navbar-brand" style="text-decoration:none;">
								<div class="header__logo-wrapper">
									VEDARO
								</div>
							</a>
						</h6>
						<div class="header-icons d-flex align-items-center gap-3">
							<a href="/cart" class="header-icon position-relative" title="Cart">
								<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 15 15" fill="currentColor">
									<path d="m3.16,13.24c-.62,0-1.03-.48-1.12-1.12l-.56-5.82c-.08-.67.51-1.12,1.12-1.12h9.81c.62.01,1.2.47,1.12,1.13l-.56,5.82c-.09.65-.51,1.12-1.12,1.12H3.16Z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="1"/>
									<path d="m3.93,5.18c0-1.98,1.6-3.58,3.58-3.58s3.58,1.6,3.58,3.58" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="1"/>
								</svg>
								<!--<span class="cart-count badge rounded-pill text-dark" style="background-color:red;">0</span>-->
								<!-- For mobile -->
								<span id="cart_counter_2" class="cart-count badge rounded-pill text-white" style="font-size: 10px;background-color:red;">0</span>
							</a>
						</div>
						<div class="collapse navbar-collapse" id="navbarNavMobile">
							<button type="button" class="mobile-menu-close" aria-label="Close menu">
							<i class="fas fa-times"></i>
							</button>
							<ul class="navbar-nav w-100">
								<li class="nav-item">
									<a class="nav-link d-flex align-items-center gap-1" href="#" data-bs-toggle="mobile-mega" data-target-mega="#shopAllMegaMobile">
										Shop All
										<svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="currentColor">
											<path d="M4.18179 6.18181C4.35753 6.00608 4.64245 6.00608 4.81819 6.18181L7.49999 8.86362L10.1818 6.18181C10.3575 6.00608 10.6424 6.00608 10.8182 6.18181C10.9939 6.35755 10.9939 6.64247 10.8182 6.81821L7.81819 9.81821C7.73379 9.9026 7.61934 9.95001 7.49999 9.95001C7.38064 9.95001 7.26618 9.9026 7.18179 9.81821L4.18179 6.81821C4.00605 6.64247 4.00605 6.35755 4.18179 6.18181Z" fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>
										</svg>
									</a>
								</li>
								{{-- @foreach($categories as $category)
								<li class="nav-item">
									<a href="" class="nav-link"> {{ $category->name }}</a>
								</li>
								@endforeach --}}
								<li class="nav-item">
									<a href="/about" class="nav-link">About</a>
								</li>
								<li class="nav-item">
									<a href="/limited_edition" class="nav-link">Limited Edition</a>
								</li>
								<li class="nav-item">
									<a href="/contact" class="nav-link">Contact</a>
								</li>
								<!--<li class="nav-item">-->
								<!--    <a href="" class="nav-link">Rings</a>-->
								<!--</li>-->
								<!--<li class="nav-item">-->
								<!--    <a href="" class="nav-link">Necklaces</a>-->
								<!--</li>-->
								<!--<li class="nav-item">-->
								<!--    <a class="nav-link d-flex align-items-center gap-1" href="#" data-bs-toggle="mobile-mega" data-target-mega="#themeFeaturesMegaMobile">-->
								<!--        Theme Features-->
								<!--        <svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="currentColor">-->
								<!--            <path d="M4.18179 6.18181C4.35753 6.00608 4.64245 6.00608 4.81819 6.18181L7.49999 8.86362L10.1818 6.18181C10.3575 6.00608 10.6424 6.00608 10.8182 6.18181C10.9939 6.35755 10.9939 6.64247 10.8182 6.81821L7.81819 9.81821C7.73379 9.9026 7.61934 9.95001 7.49999 9.95001C7.38064 9.95001 7.26618 9.9026 7.18179 9.81821L4.18179 6.81821C4.00605 6.64247 4.00605 6.35755 4.18179 6.18181Z" fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>-->
								<!--        </svg>-->
								<!--    </a>-->
								<!--</li>-->
								<!--<li class="nav-item">-->
								<!--    <a href="/login" class="nav-link">Account</a>-->
								<!--</li>-->
							</ul>
						</div>
					</div>
				</div>
			</nav>
		</header>
		<div class="mobile-mega-overlay" id="shopAllMegaMobile">
			<div class="mobile-mega-header">
				<span class="mobile-mega-title">Shop All</span>
				<button type="button" class="mobile-mega-close" aria-label="Close mega menu">
				<i class="fas fa-arrow-left"></i> </button>
			</div>
			<div class="row">
				<div class="col-12 mega-column">
					<h6>Categories</h6>
					<ul>
						@foreach($categories as $category)
						<li>  <a href="{{ route('categories_page')}}" class="category-item" data-category-id="{{ $category->id }}">{{ $category->name }}</a>  </li>
						@endforeach 
						<li>
							<a href="{{ route('categories_page')}}">Shop All</a>
						</li>
					</ul>
					<!--<ul>-->
					<!--    <li>-->
					<!--          <a href="#">Earrings</a>-->
					<!--    </li>-->
					<!--    <li>-->
					<!--          <a href="#">Necklaces</a>-->
					<!--    </li>-->
					<!--    <li>-->
					<!--          <a href="#">Bracelets</a>-->
					<!--    </li>-->
					<!--    <li>-->
					<!--         <a href="#">Shop All</a>-->
					<!--    </li>-->
					<!--</ul>-->
				</div>
				{{--
				<div class="col-12 mega-column">
					<h6>Gifting</h6>
					<a href="#">Gifts under $500</a>
					<a href="#">Gifts under $1000</a>
					<a href="#">Gift Card</a>
				</div>
				--}}
			</div>
		</div>
		<div class="mobile-mega-overlay" id="themeFeaturesMegaMobile">
			<div class="mobile-mega-header">
				<span class="mobile-mega-title">Theme Features</span>
				<button type="button" class="mobile-mega-close" aria-label="Close mega menu">
				<i class="fas fa-arrow-left"></i> </button>
			</div>
			<div class="row">
				<div class="col-12 mega-column">
					<h6>Demo Stores</h6>
					<a href="#">Distinction</a>
					<a href="#">Gloss</a>
					<a href="#">Artistry</a>
					<a href="#">Composition</a>
				</div>
				<div class="col-12 mega-column">
					<h6>Theme Features</h6>
				</div>
				<div class="col-12 mega-column">
					<h6>Product Layouts</h6>
					<a href="#">Slideshow</a>
					<a href="#">Thumbnails</a>
					<a href="#">Vertical Scroll</a>
				</div>
			</div>
		</div>
		<main>
    

			@yield('content')
		</main>

		<style>
			/* Custom styles for the footer */
			.footer-main-logo-text {
			letter-spacing: 0.1em; /* Example: adjust letter spacing */
			}
			.footer-heading {
			position: relative;
			padding-bottom: 5px; /* Space for the underline effect */
			}
			.footer-heading::after {
			content: '';
			position: absolute;
			left: 0;
			bottom: 0;
			width: 40px; /* Underline length */
			height: 2px;
			background-color: #fff; /* Underline color */
			}
			.footer-link,
			.footer-link-bottom {
			transition: color 0.3s ease;
			}
			.footer-link:hover,
			.footer-link-bottom:hover {
			color: #cccccc !important; /* Lighter white on hover */
			}
			.footer-email-input::placeholder {
			color: rgba(255, 255, 255, 0.7);
			}
			.footer-email-input:focus {
			border-color: #fff;
			box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25);
			}
			.footer-subscribe-btn {
			transition: background-color 0.3s ease, color 0.3s ease;
			}
			.footer-subscribe-btn:hover {
			background-color: #e2e6ea; /* Slightly darker white on hover */
			color: #212529;
			}
			.social-icon-link {
			font-size: 1.5rem; /* Adjust icon size */
			transition: color 0.3s ease;
			}
			.social-icon-link:hover {
			color: #cccccc !important; /* Lighter white on hover */
			}
			/* Responsive adjustments for smaller screens */
			@media (max-width: 767.98px) {
			.footer-main-logo-text {
			font-size: 3rem !important; /* Adjust font size for mobile */
			}
			.text-md-start {
			text-align: center !important; /* Center align image on mobile */
			}
			.footer-heading::after {
			left: 0%; /* Center underline on mobile */
			/*transform: translateX(-50%);*/
			}
			.social-icons-newsletter {
			text-align: center !important; /* Center social icons on mobile */
			}
			.footer-bottom-section {
			text-align: center;
			}
			.footer-bottom-left,
			.footer-bottom-right {
			width: 100%; /* Make full width on mobile */
			}
			.footer-bottom-right span {
			display: block; /* Stack text on mobile */
			margin-top: 5px; /* Add some spacing */
			}
			}
		</style>
		<footer id="footer" class="bg-dark text-white pt-5 pb-3 w-100" style="height:auto;">
			<div class="container">
				<!--<div class="text-center mb-5">-->
				<!--	<h1 class="display-5 fw-light footer-main-logo-text">VEDARO</h1>-->
				<!--</div>-->
				<div class="row gy-5 align-items-start">
					<div class="col-12 col-md-3 text-center text-md-start">
						<img style="max-width: 150px; height: auto;" src="{{ asset('public/assets/images/VEDARO_logo.png') }}" alt="Product Image" class="img-fluid">
					</div>
					<div class="col-6 col-md-3">
						<h5 class="fw-semibold mb-3 footer-heading">Quick links</h5>
						<ul class="list-unstyled small">
							<li><a href="/" class="footer-link text-white-50 text-decoration-none">HOME</a></li>
							<li><a href="/about" class="footer-link text-white-50 text-decoration-none">ABOUT</a></li>
							<li><a href="/shop" class="footer-link text-white-50 text-decoration-none">SHOP</a></li>
							<li><a href="/contact" class="footer-link text-white-50 text-decoration-none">CONTACT</a></li>
							<li><a href="/limited_edition" class="footer-link text-white-50 text-decoration-none">LIMITED ADDITTION</a></li>
						</ul>
					</div>
					<div class="col-6 col-md-3">
    					<h5 class="fw-semibold mb-3 footer-heading">Other links</h5>
    			        <ul class="list-unstyled small">
                            <li><a href="/privacy_policy" class="footer-link text-white-50 text-decoration-none">PRIVACY POLICY</a></li>
                            <li><a href="/terms_and_condition" class="footer-link text-white-50 text-decoration-none">TERMS & CONDITIONS</a></li>
                            <li><a href="/cancellation_refund" class="footer-link text-white-50 text-decoration-none">REFUND POLICY</a></li>
                            <li><a href="/shipping_policy" class="footer-link text-white-50 text-decoration-none">SHIPPING POLICY</a></li>
                        </ul>
					</div>
					<div class="col-12 col-md-3">
						<h5 class="fw-semibold mb-3 footer-heading">Subscribe to our newsletter</h5>
						<p class="text-white-50 small newsletter-text">
							Sign up for Vedaro newsletter & be the first to discover the latest collections, special offers, and behind-the-scenes glimpses.
						</p>
						<form>
							<div class="mb-3">
								<label for="newsletterEmail" class="form-label visually-hidden">Email</label>
								<input type="email" class="form-control bg-transparent border-white text-white rounded-0 footer-email-input" id="newsletterEmail" placeholder="Email">
							</div>
							<button type="submit" class="btn btn-light w-100 text-dark fw-semibold text-uppercase btn-sm footer-subscribe-btn">SUBSCRIBE</button>
						</form>
						<!--<div class="social-icons-newsletter mt-4 text-start">-->
						<!--	<a href="#" class="social-icon-link me-3 text-white"><i class="fab fa-instagram"></i></a>-->
						<!--	<a href="#" class="social-icon-link me-3 text-white"><i class="fab fa-tiktok"></i></a>-->
						<!--	<a href="#" class="social-icon-link text-white"><i class="fab fa-pinterest"></i></a>-->
						<!--</div>-->
					</div>
				</div>
				<div class="d-flex flex-column flex-md-row justify-content-between align-items-center py-3 text-white-50 small border-top border-light mt-4 footer-bottom-section">
					<div class="footer-bottom-right text-center text-md-end">
						<span>© 2025 VEDARO &nbsp; | &nbsp; POWERED BY <a href="https://metawish.ai/">Metwish.ai</a></span>
					</div>
				</div>
			</div>
		</footer>
		<script src="{{ asset('assets/js/script.js') }}"></script>
		<!--Bottom Header Like Footer-->
		<style>
			/* Custom styles for your fixed bottom element */
			#myFixedBottomElement {
			position: fixed; /* Explicitly set position to fixed */
			bottom: 0;       /* Fix it to the bottom edge */
			left: 0;         /* Ensure it starts from the left edge */
			width: 100%;     /* Make it span the full width of the viewport */
			height: 80px;    /* <--- SET YOUR DESIRED HEIGHT HERE --- */
			z-index: 1050;   /* Ensure it's on top of other content, higher than navbars (1030/1040) */
			box-sizing: border-box; /* Include padding and border in the element's total width and height */
			/* Align content vertically if needed (useful for specific heights) */
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			display: none;
			}
			/* IMPORTANT: Add padding to your body or main content to prevent overlap */
			/* The padding-bottom must be equal to or greater than the height of your fixed element */
			/* Custom styles for general footer elements (from previous responses, kept for context) */
			.footer-main-logo-text {
			letter-spacing: 0.1em;
			}
			/* Specific styles for the "bottom header" footer */
			/* Essential CSS for fixed bottom elements */
			.fixed-bottom {
			z-index: 1030; /* Ensures it stays above most other content, like default navbars (which are usually 1020) */
			width: 100%; /* Ensures it spans the full width of the viewport */
			box-sizing: border-box; /* Important for consistent sizing with padding/border */
			/* REMOVED: height: 100px; - This height might make it too tall for a compact mobile nav. Let content define height. */
			}
			/* IMPORTANT: Add padding to your body or main content to prevent overlap */
			body {
			/* Adjust this value based on the actual height of your fixed-bottom element 
			/* Measure your fixed-bottom element's height and set padding-bottom a bit more than that. */
			/* For the example HTML above, 60px should be a good starting point. */
			}
			.bottom-nav-item {
			padding: 8px 0; /* Add some padding around items */
			transition: background-color 0.2s ease, color 0.2s ease;
			text-align: center;
			}
			.bottom-nav-item:hover {
			background-color: rgba(255, 255, 255, 0.1); /* Subtle highlight on hover */
			color: #ffffff !important; /* Ensure text is white on hover */
			}
			.bottom-nav-item.active { /* Optional: For an active state, add this class via JS/backend */
			color: #0d6efd !important; /* Example active color (Bootstrap primary blue) */
			}
			/* Padding for the body to prevent content from being hidden behind the fixed footer */
			@media (max-width: 991.98px) { /* Applies to screens smaller than large (lg) breakpoint */
			body {
			/* Adjusted padding-bottom here to match common mobile nav heights more closely */
			padding-bottom: 60px; /* This should be the height of your mobile fixed footer + a little extra */
			}
			}
			/* General responsive adjustments (from previous responses) */
			@media (max-width: 767.98px) {
			#myFixedBottomElement{
			display: block;
			}
			/* If you had a full footer that gets hidden, ensure no conflicting styles */
			}
			/* Added specific styles for the bottom header footer from the previous response */
			.fixed-bottom.d-lg-none {
			backdrop-filter: blur(5px); /* Optional: Adds a subtle blur effect if content scrolls behind it */
			-webkit-backdrop-filter: blur(5px); /* For Safari */
			background-color: rgba(33, 37, 41, 0.95) !important; /* Semi-transparent dark background */
			}
			/*Styles for mobile search  */
			.mobile-search-overlay {
			position: fixed;
			bottom: 81px;
			width: 100%;
			z-index: 999;
			background: white;
			padding: 10px 15px;
			display: none;
			box-shadow: 0 -2px 8px rgba(0,0,0,0.2);
			}
			#mobileSearchBox input {
			flex-grow: 1;
			border: 1px solid #ccc;
			border-radius: 6px;
			padding: 8px 10px;
			}
			#searchToggleBtn {
			color: #fff;
			}
			@media (max-width: 768px) {
			#searchToggleBtn {
			font-size: 20px;
			}
			}
			@media (min-width: 768px) {
			.mobile-search-overlay {
			display: none !important;
			}
			}
		</style>

		<div id="myFixedBottomElement" class="bg-dark text-white text-center py-2 shadow-lg">
			<div class="container-fluid">
				<div class="d-flex justify-content-around align-items-center">
					<a href="/" class="bottom-nav-item text-white-50 text-decoration-none d-flex flex-column align-items-center flex-grow-1">
					<i class="fas fa-home fs-5"></i>
					<small class="mt-1">Home</small>
					</a>
					<a href="javascript:void(0)" id="searchToggleBtn" class="bottom-nav-item text-white-50 text-decoration-none d-flex flex-column align-items-center flex-grow-1">
					<i class="fas fa-search fs-5"></i>
					<small class="mt-1">Search</small>
					</a>
					<a href="/shop" class="bottom-nav-item text-white-50 text-decoration-none d-flex flex-column align-items-center flex-grow-1">
					<i class="fas fa-shopping-bag fs-5"></i>
					<small class="mt-1">Shop</small>
					</a>
					<a href="/login" class="bottom-nav-item text-white-50 text-decoration-none d-flex flex-column align-items-center flex-grow-1">
					<i class="fas fa-user fs-5"></i>
					<small class="mt-1">Account</small>
					</a>
				</div>
			</div>
		</div>
		<!-- Mobile Search Overlay -->
		<div id="mobileSearchBox" class="mobile-search-overlay">
			<div class="container d-flex align-items-center">
				<form action="{{ route('global.search') }}" method="GET" class="d-flex w-100 gap-2">
					<input type="text" name="q" class="form-control" placeholder="Search products or categories...">
					<button type="submit" class="btn btn-primary">
					<i class="fas fa-search"></i>
					</button>
				</form>
			</div>
		</div>
		{{-- css for footer  --}}
		<style>
			.success-message, .error-message {
			position: fixed;
			top: 100px;
			left: 50%;
			transform: translateX(-50%);
			padding: 15px;
			border-radius: 5px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			opacity: 0;
			pointer-events: none;
			transition: opacity 0.5s ease-in-out, transform 0.5s ease;
			z-index: 9999;
			animation: fadeIn 0.5s forwards; /* Add fade-in animation */
			}
			.success-message {
			background-color: #28a745; /* Green for success */
			color: white;
			}
			.error-message {
			background-color: #dc3545; /* Red for error */
			color: white;
			}
			/* Animation for fade-in effect */
			@keyframes fadeIn {
			0% {
			opacity: 0;
			transform: translateX(-50%) translateY(-20px); /* Start position slightly above */
			}
			100% {
			opacity: 1;
			transform: translateX(-50%) translateY(0); /* End position */
			}
			}
			/* Animation for fade-out effect */
			@keyframes fadeOut {
			0% {
			opacity: 1;
			transform: translateX(-50%) translateY(0);
			}
			100% {
			opacity: 0;
			transform: translateX(-50%) translateY(20px); /* Slide out to below */
			}
			}
			.footer-link {
			display: block;
			color: #ccc;
			text-decoration: none;
			margin-bottom: 0.5rem;
			transition: all 0.3s ease-in-out;
			}
			.footer-link:hover {
			color: #f5c542; /* golden yellow */
			transform: translateX(4px);
			}
			.footer-link i {
			transition: color 0.3s ease;
			}
			.footer-link:hover i {
			color: #f5c542;
			}
			footer input::placeholder {
			color: rgba(255, 255, 255, 0.6);
			}
			/* Import fonts */
			@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=Inter:wght@300;400;500;600&display=swap');
			/* General Footer Styling */
			footer {
			background-color: #202020; /* A dark grey, slightly lighter than pure black */
			color: #e0e0e0; /* A light grey for general text */
			font-family: 'Inter', sans-serif; /* Use a modern sans-serif like Inter */
			font-weight: 300; /* Lighter font weight for overall text */
			}
			/* Main Logo/Title Text Styling */
			.footer-main-logo-text {
			font-family: 'Playfair Display', serif; /* Elegant serif font */
			color: #e0e0e0; /* Light color */
			letter-spacing: 5px;
			font-weight: 400; /* Matches common Playfair Display weight */
			font-size: 2.8rem; /* Adjusted size to be prominent */
			margin-bottom: 2.5rem; /* More space below the logo */
			}
			/* Footer Heading Styling (Quick links, Connect, Subscribe) */
			.footer-heading {
			color: #e0e0e0; /* Light color */
			font-weight: 500; /* Slightly bolder than body text */
			margin-bottom: 1.5rem; /* Standard spacing */
			text-transform: uppercase; /* Headings are uppercase in the image */
			font-size: 1.05rem; /* Slightly larger headings */
			letter-spacing: 1px;
			}
			/* Footer Links - Border Bottom Hover Effect */
			.footer-link, .footer-link-bottom {
			color: #b0b0b0; /* Slightly muted light grey for links */
			text-decoration: none;
			position: relative;
			padding-bottom: 3px; /* Space for the border */
			display: inline-block; /* Crucial for width calculation */
			transition: color 0.3s ease;
			font-size: 0.9rem; /* Smaller font for list items */
			line-height: 1.9; /* More spacing between list items */
			text-transform: uppercase; /* Links are uppercase in the image */
			letter-spacing: 0.5px;
			}
			.footer-link::after, .footer-link-bottom::after {
			content: '';
			position: absolute;
			width: 0;
			height: 1px; /* Border thickness */
			bottom: 0;
			left: 0;
			background: #e0e0e0; /* Light border color */
			transition: width 0.3s ease-in-out;
			}
			.footer-link:hover, .footer-link-bottom:hover {
			color: #e0e0e0; /* Lighten text color on hover */
			}
			.footer-link:hover::after, .footer-link-bottom:hover::after {
			width: 100%; /* Expand border to full width */
			}
			/* Newsletter Section Styling */
			.newsletter-text {
			color: #b0b0b0 !important; /* Muted light grey for descriptive text */
			font-size: 0.85rem;
			line-height: 1.6;
			}
			.footer-email-input {
			background-color: transparent !important;
			border: 1px solid rgba(255, 255, 255, 0.3) !important; /* Subtler border */
			color: #e0e0e0 !important;
			padding: 0.8rem 1rem; /* Adjust padding */
			font-size: 0.9rem;
			}
			.footer-email-input::placeholder {
			color: rgba(255, 255, 255, 0.5) !important;
			}
			.footer-email-input:focus {
			border-color: #e0e0e0 !important; /* White border on focus */
			box-shadow: 0 0 0 0.15rem rgba(255, 255, 255, 0.2) !important; /* Subtle glow */
			background-color: transparent !important;
			}
			.footer-subscribe-btn {
			background-color: #e0e0e0 !important; /* Light button background */
			color: #202020 !important; /* Dark text on button */
			border-color: #e0e0e0 !important;
			padding: 0.8rem 1rem;
			font-size: 0.9rem;
			font-weight: 600 !important; /* Bolder text for subscribe */
			transition: all 0.3s ease;
			letter-spacing: 1px;
			}
			.footer-subscribe-btn:hover {
			background-color: #c9c9c9 !important; /* Slightly darker on hover */
			border-color: #c9c9c9 !important;
			}
			/* Social Media Icons (Below Newsletter Form) */
			.social-icons-newsletter .social-icon-link {
			color: #b0b0b0; /* Muted color */
			font-size: 1.8rem; /* Larger icon size */
			transition: color 0.3s ease;
			}
			.social-icons-newsletter .social-icon-link:hover {
			color: #e0e0e0; /* Lighten on hover */
			}
			/* Disclaimer Marquee Styling */
			.footer-disclaimer {
			background-color: #282828; /* Slightly different dark shade */
			padding: 0.6rem 0;
			margin-top: 4rem !important; /* More space above */
			color: rgba(255, 255, 255, 0.75) !important;
			font-size: 0.75rem;
			white-space: nowrap; /* Ensure marquee content stays on one line */
			overflow: hidden; /* Hide overflow */
			}
			/* Footer Bottom Section (Copyright, Policy, Social Icons) */
			.footer-bottom-section {
			border-top: 1px solid rgba(255, 255, 255, 0.1) !important; /* Very thin, light border */
			color: rgba(255, 255, 255, 0.6) !important; /* Muted text color */
			font-size: 0.7rem; /* Smaller font size */
			margin-top: 2.5rem !important; /* Space above */
			padding-top: 1.5rem !important; /* Space below border */
			}
			.footer-bottom-left {
			flex-grow: 1; /* Allows it to take up available space */
			}
			.footer-bottom-right {
			text-align: right;
			flex-grow: 1; /* Allows it to take up available space */
			}
			.footer-copyright-social-icons .social-icon-link-sm {
			color: rgba(255, 255, 255, 0.6); /* Muted color for these icons */
			font-size: 1.1rem; /* Smaller icons here */
			transition: color 0.3s ease;
			}
			.footer-copyright-social-icons .social-icon-link-sm:hover {
			color: #e0e0e0; /* Lighten on hover */
			}
			/* Utility to remove Bootstrap default list-style-none padding */
			.list-unstyled li {
			padding-left: 0 !important;
			}
		</style>
		<script>
			$(document).ready(function () {
			$('#hamburger').click(function () {
			    $('.nav_links').toggleClass('active');
			});
			});
			
			$(document).ready(function() {
			// For Success Message
			if ($('.success-message').length) {
			    $('.success-message').css('opacity', '1'); // Show the success message
			    setTimeout(function() {
			        $('.success-message').css('animation', 'fadeOut 0.5s forwards'); // Apply fade-out animation after 5 seconds
			    }, 5000); // 5000ms = 5 seconds
			}
			
			// For Error Message
			if ($('.error-message').length) {
			    $('.error-message').css('opacity', '1'); // Show the error message
			    setTimeout(function() {
			        $('.error-message').css('animation', 'fadeOut 0.5s forwards'); // Apply fade-out animation after 5 seconds
			    }, 5000); // 5000ms = 5 seconds
			}
			});
			
			
		</script>
		<script>
			function updateCartCount() {
			    $.ajax({
			        url: "{{ route('cart.count') }}",
			        method: "GET",
			        success: function(response) {
			            // Update both cart counters
			            $('#cart_counter').text(response.cartCount);
			            $('#cart_counter_2').text(response.cartCount);
			        },
			        error: function() {
			            console.error("Failed to fetch cart count");
			        }
			    });
			}
			
			// Call on page load
			$(document).ready(function() {
			    updateCartCount();
			});
		</script>
		<script>
			// Wait until the full DOM is loaded
			  document.addEventListener("DOMContentLoaded", function () {
			      const header = document.getElementById("mainHeader");
			
			      if (!header) return;
			
			      // Add scroll event listener
			      window.addEventListener("scroll", function () {
			      const scrollY = window.scrollY || document.documentElement.scrollTop;
			
			      if (scrollY > 600) {
			          header.classList.add("bg-white", "shadow");
			      } else {
			          header.classList.remove("bg-white", "shadow");
			      }
			      });
			  });
		</script>
		{{-- script for toogle header  --}}
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
		<script>
			document.addEventListener('DOMContentLoaded', function() {
			    // Script for topbar and header scrolling behavior
			    const topbar = document.getElementById('topbar');
			    const mainHeader = document.querySelector('.main-header');
			    const topbarHeight = topbar.offsetHeight; // Get initial topbar height
			
			    window.addEventListener('scroll', function() {
			        if (window.scrollY > 0) {
			            mainHeader.classList.add('scrolled');
			            topbar.style.transform = `translateY(-${topbarHeight}px)`; // Hide topbar
			            mainHeader.style.marginTop = '0px'; // Ensure header is at top
			        } else {
			            mainHeader.classList.remove('scrolled');
			            topbar.style.transform = 'translateY(0)'; // Show topbar
			            mainHeader.style.marginTop = `${topbarHeight}px`; // Move header below topbar
			        }
			    });
			
			    // Handle mega menu dropdowns for DESKTOP
			    const desktopDropdownLinks = document.querySelectorAll('.navbar-desktop .nav-item.position-static > .nav-link[data-bs-toggle="collapse"]');
			    const dropdownOverlay = document.getElementById('dropdownOverlay');
			
			    desktopDropdownLinks.forEach(link => {
			        link.addEventListener('click', function(event) {
			            event.preventDefault(); // Prevent default link behavior
			
			            const targetDropdownId = this.getAttribute('href');
			            const targetDropdown = document.querySelector(targetDropdownId);
			
			            // Close other desktop dropdowns and remove 'active' class
			            desktopDropdownLinks.forEach(otherLink => {
			                const otherDropdownId = otherLink.getAttribute('href');
			                const otherDropdown = document.querySelector(otherDropdownId);
			                if (otherLink !== this && otherDropdown.classList.contains('show')) {
			                    const otherCollapse = bootstrap.Collapse.getInstance(otherDropdown) || new bootstrap.Collapse(otherDropdown, { toggle: false });
			                    otherCollapse.hide();
			                    otherLink.classList.remove('active');
			                }
			            });
			
			            // Toggle the clicked desktop dropdown
			            const bsCollapse = bootstrap.Collapse.getInstance(targetDropdown) || new bootstrap.Collapse(targetDropdown, { toggle: false });
			            if (targetDropdown.classList.contains('show')) {
			                bsCollapse.hide();
			                link.classList.remove('active');
			                dropdownOverlay.classList.remove('active');
			            } else {
			                bsCollapse.show();
			                link.classList.add('active');
			                dropdownOverlay.classList.add('active');
			            }
			        });
			    });
			
			    // Close desktop dropdowns and overlay when clicking outside
			    dropdownOverlay.addEventListener('click', function() {
			        // Check if any desktop dropdown is open
			        const desktopDropdownsOpen = document.querySelectorAll('.navbar-desktop .dropdown-mega.show');
			        if (desktopDropdownsOpen.length > 0) {
			            desktopDropdownsOpen.forEach(dropdown => {
			                const bsCollapse = bootstrap.Collapse.getInstance(dropdown) || new bootstrap.Collapse(dropdown, { toggle: false });
			                bsCollapse.hide();
			            });
			            document.querySelectorAll('.navbar-desktop .nav-link.active').forEach(link => {
			                link.classList.remove('active');
			            });
			            dropdownOverlay.classList.remove('active');
			        }
			    });
			
			    // --- Mobile Navbar specific JS ---
			    const mobileNavbarToggler = document.querySelector('.navbar-mobile .navbar-toggler');
			    const mobileNavbarCollapse = document.getElementById('navbarNavMobile');
			    const mobileMenuCloseBtn = document.querySelector('.mobile-menu-close'); // Added for the cross button
			
			    const mobileMegaTriggerLinks = document.querySelectorAll('.navbar-mobile .nav-link[data-bs-toggle="mobile-mega"]');
			    const mobileMegaOverlays = document.querySelectorAll('.mobile-mega-overlay');
			    const mobileMegaCloseButtons = document.querySelectorAll('.mobile-mega-overlay .mobile-mega-close');
			
			
			    // Toggle main mobile sidebar menu
			    if (mobileNavbarToggler) {
			        mobileNavbarToggler.addEventListener('click', function() {
			            // Toggle the overlay when the mobile menu is opened/closed
			            if (mobileNavbarCollapse.classList.contains('show')) {
			                dropdownOverlay.classList.remove('active');
			            } else {
			                dropdownOverlay.classList.add('active');
			            }
			            // Ensure no mega-overlays are active when opening/closing main menu
			            mobileMegaOverlays.forEach(overlay => {
			                overlay.classList.remove('active');
			            });
			        });
			    }
			
			    // Close mobile sidebar with the 'X' button
			    if (mobileMenuCloseBtn) {
			        mobileMenuCloseBtn.addEventListener('click', function() {
			            const bsCollapse = bootstrap.Collapse.getInstance(mobileNavbarCollapse) || new bootstrap.Collapse(mobileNavbarCollapse, { toggle: false });
			            bsCollapse.hide();
			            dropdownOverlay.classList.remove('active');
			        });
			    }
			
			    // Handle opening mobile mega menu overlays
			    mobileMegaTriggerLinks.forEach(link => {
			        link.addEventListener('click', function(event) {
			            event.preventDefault(); // Prevent default link behavior
			
			            // Close the main mobile sidebar first
			            const bsCollapse = bootstrap.Collapse.getInstance(mobileNavbarCollapse) || new bootstrap.Collapse(mobileNavbarCollapse, { toggle: false });
			            bsCollapse.hide();
			
			            const targetMegaId = this.getAttribute('data-target-mega');
			            const targetMegaOverlay = document.querySelector(targetMegaId);
			
			            if (targetMegaOverlay) {
			                // Ensure all other mega overlays are closed
			                mobileMegaOverlays.forEach(overlay => {
			                    overlay.classList.remove('active');
			                });
			                // Open the clicked mega overlay
			                targetMegaOverlay.classList.add('active');
			                dropdownOverlay.classList.add('active'); // Keep overlay active
			            }
			        });
			    });
			
			    // Handle closing mobile mega menu overlays
			    mobileMegaCloseButtons.forEach(button => {
			        button.addEventListener('click', function() {
			            this.closest('.mobile-mega-overlay').classList.remove('active');
			            dropdownOverlay.classList.remove('active'); // Remove overlay as well
			        });
			    });
			
			    // Close main mobile menu and any active mega overlays if overlay clicked
			    dropdownOverlay.addEventListener('click', function(event) {
			         // Check if the click specifically came from the overlay, not from within a collapsing element
			         if (event.target === dropdownOverlay) {
			            // Close main mobile menu
			            if (mobileNavbarCollapse.classList.contains('show')) {
			                const bsCollapse = bootstrap.Collapse.getInstance(mobileNavbarCollapse) || new bootstrap.Collapse(mobileNavbarCollapse, { toggle: false });
			                bsCollapse.hide();
			            }
			            // Close any active mobile mega overlays
			            mobileMegaOverlays.forEach(overlay => {
			                overlay.classList.remove('active');
			            });
			            dropdownOverlay.classList.remove('active');
			         }
			    });
			
			
			    // Ensure desktop dropdowns are closed if window resized from mobile to desktop
			    window.addEventListener('resize', function() {
			        if (window.innerWidth >= 992) { // 'lg' breakpoint
			            // Close mobile menu if open
			            if (mobileNavbarCollapse.classList.contains('show')) {
			                const bsCollapse = bootstrap.Collapse.getInstance(mobileNavbarCollapse) || new bootstrap.Collapse(mobileNavbarCollapse, { toggle: false });
			                bsCollapse.hide();
			            }
			            // Close any mobile mega overlays if open
			            mobileMegaOverlays.forEach(overlay => {
			                overlay.classList.remove('active');
			            });
			            dropdownOverlay.classList.remove('active'); // Ensure overlay is removed
			
			            // Ensure desktop dropdowns are not accidentally open from mobile state
			             document.querySelectorAll('.navbar-desktop .dropdown-mega.show').forEach(dropdown => {
			                const bsCollapse = bootstrap.Collapse.getInstance(dropdown) || new bootstrap.Collapse(dropdown, { toggle: false });
			                bsCollapse.hide();
			            });
			            document.querySelectorAll('.navbar-desktop .nav-link.active').forEach(link => {
			                link.classList.remove('active');
			            });
			        } else { // Less than 'lg' breakpoint (mobile)
			            // Ensure desktop mega menu dropdowns are closed if switching to mobile
			            document.querySelectorAll('.navbar-desktop .dropdown-mega.show').forEach(dropdown => {
			                const bsCollapse = bootstrap.Collapse.getInstance(dropdown) || new bootstrap.Collapse(dropdown, { toggle: false });
			                bsCollapse.hide();
			            });
			             document.querySelectorAll('.navbar-desktop .nav-link.active').forEach(link => {
			                link.classList.remove('active');
			            });
			        }
			    });
			});
		</script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script>
			const toggle = document.getElementById('searchToggle');
			const dropdown = document.getElementById('searchDropdown');
			
			toggle.addEventListener('click', () => {
			  dropdown.classList.toggle('show');
			});
			
			document.addEventListener('click', (e) => {
			  if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
			    dropdown.classList.remove('show');
			  }
			});
		</script>
		<script>
			const searchBox = document.getElementById('mobileSearchBox');
			const searchToggle = document.getElementById('searchToggleBtn');
			
			searchToggle.addEventListener('click', function () {
			    if (searchBox.style.display === 'none' || searchBox.style.display === '') {
			        searchBox.style.display = 'block';
			    } else {
			        searchBox.style.display = 'none';
			    }
			});
		</script>
	</body>
</html>