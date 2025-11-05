
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'Vedaro – Handcrafted Jewelry | Rings, Necklaces & Earrings')</title>

        <meta name="description" content="@yield('meta_description', 'Shop handcrafted jewelry online at Vedaro. Discover elegant rings, necklaces, earrings & timeless designs crafted with premium materials and care.')">

</head>
        
         <!-- Open Graph / Facebook -->
          <meta property="og:title" content="Vedaro Handcrafted Jewelry | Unique Rings, Necklaces & Earrings">
          <meta property="og:description" content="Shop exquisite handcrafted jewelry at Vedaro. Discover unique rings, necklaces, earrings & more, crafted with premium materials and timeless designs.">
          <meta property="og:type" content="website">
          <meta property="og:url" content="https://www.vedaro.com/">
          <meta property="og:image" content="{{ asset('assets/images/VEDARO_logo.png') }}">
          <meta property="og:site_name" content="Vedaro">
		  
        
        
        
		<link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">
		
		<link rel="stylesheet" href="{{ asset('/assets/css/header.css') }}">
		<!--FavIcon-->
		<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/VEDARO_logo.png') }}">
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
		<link rel="canonical" href="https://vedaro.in/" />
		
		<style>
		    /* Hide scrollbar but keep scroll */

			*{
				padding:0;
				margin:0;
				box-sizing:border-box;
			}
                ::-webkit-scrollbar {
                    display: none;
                }
                
                html, body {
                    scrollbar-width: none; /* Firefox */
                    -ms-overflow-style: none; /* IE and Edge */
                }


				@font-face {
					font-family: "MyCustomFont";
					src: url("{{ asset('fonts/myfont.ttf') }}") format("truetype");
					font-weight: normal;
					font-style: normal;
					}

					body {
						font-family: "MyCustomFont", sans-serif;
						padding:0;
						margin:0;
					}


		</style>
		
		
		
		<script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "JewelryStore",
          "name": "Vedaro",
          "url": "https://www.vedaro.com/",
          "logo": "https://www.vedaro.com/images/logo.png",
          "image": "https://www.vedaro.com/images/og-image.jpg",
          "description": "Vedaro offers handcrafted jewelry including unique rings, necklaces, earrings and more, crafted with premium materials and timeless designs.",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "123 Jewelry Lane",
            "addressLocality": "Your City",
            "addressRegion": "Your State",
            "postalCode": "123456",
            "addressCountry": "IN"
          },
          "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+91-9876543210",
            "contactType": "Customer Service",
            "areaServed": "IN",
            "availableLanguage": ["English", "Hindi"]
          },
          "sameAs": [
            "https://www.facebook.com/vedaro",
            "https://www.instagram.com/vedaro",
            "https://www.pinterest.com/vedaro"
          ]
        }
        </script>

		
		
	</head>
	<body style="background-color: #f2ecdd;">
		<!-- Bootstrap Header -->
		<!-- Bootstrap Header with Full Z-Index -->
		<div class="dropdown-overlay" id="dropdownOverlay"></div>
		<!-- <div id="topbar" class="text-white small py-2 px-3 d-flex align-items-center justify-content-between fixed-top w-100"
			>
			<div>
				Private Sale at |
				<a href="/" class="text-white text-decoration-underline">VEDARO</a>
			</div>
			<div class="small">IND / INR</div>
		</div> -->
		   <!-- HEADER -->
   @include('layouts.header')

    <!-- SIDEBAR MENU (Mobile Only) -->
    @include('layouts.sidebar')

    <!-- overlay visible when sidebar is open -->
    <div class="sidebar-overlay" id="sidebarOverlay" tabindex="-1" aria-hidden="true"></div>



		<main>
			@yield('content')
		</main>

		<style>

/* #0f2a1d -dark ...... #f2ecdd - light */

    /* Footer Styles */
    .footer-heading {
        position: relative;
        padding-bottom: 5px;
    }
    .footer-heading::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 40px;
        height: 2px;
        background-color: #f2ecdd;
    }
    .footer-link {
        transition: color 0.3s ease;
    }
    .footer-link:hover {
        color: #cccccc !important;
    }
    .footer-email-input {
        background-color: transparent;
        border: 1px solid #ffffff;
        color: #ffffff;
        border-radius: 8px;
        padding: 10px;
    }
    .footer-email-input::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }
    .footer-subscribe-btn {
        background-color: #f2f0e7;
        border: none;
        border-radius: 8px;
        padding: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .footer-subscribe-btn:hover {
        background-color: #e2e6ea;
        color: #212529;
    }
    .social-icons a {
        color: #f2ecdd;
        font-size: 1.5rem;
        transition: color 0.3s ease;
    }
    .social-icons a:hover {
        color: #cccccc !important;
    }
    .footer-bottom {
        border-top: 1px solid rgba(255,255,255,0.2);
        padding-top: 15px;
        margin-top: 20px;
		color:#bcb8ad;
    }
    #footer-img {
        max-width: 60px;
        height: auto;
    }

	.list-unstyled li a{
		color:#f2ecdd;
	}

    /* Responsive */
    @media (max-width: 767.98px) {
        .footer-heading::after {
            left: 50%;
            transform: translateX(-50%);
        }
        .social-icons {
            justify-content: center;
        }
        .footer-bottom {
            text-align: center;
        }
    }
</style>

@include('layouts.footer')

		<script src="{{ asset('assets/js/script.js') }}"async></script>
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
		 <script>
        // Elements
        const menuToggle = document.getElementById('menuToggle');
        const sidebarMenu = document.getElementById('sidebarMenu');
        const closeSidebar = document.getElementById('closeSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function openSidebar() {
            if (!sidebarMenu) return;
            sidebarMenu.classList.add('active');
            sidebarOverlay.classList.add('active');
            document.body.classList.add('no-scroll');
            sidebarMenu.setAttribute('aria-hidden', 'false');
            sidebarOverlay.setAttribute('aria-hidden', 'false');
        }

        function closeSidebarFn() {
            if (!sidebarMenu) return;
            sidebarMenu.classList.remove('active');
            sidebarOverlay.classList.remove('active');
            document.body.classList.remove('no-scroll');
            sidebarMenu.setAttribute('aria-hidden', 'true');
            sidebarOverlay.setAttribute('aria-hidden', 'true');
        }

        if (menuToggle) {
            menuToggle.addEventListener('click', openSidebar);
        }
        if (closeSidebar) {
            closeSidebar.addEventListener('click', closeSidebarFn);
        }
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', closeSidebarFn);
        }

        // also close with Escape key for accessibility
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && sidebarMenu && sidebarMenu.classList.contains('active')) {
                closeSidebarFn();
            }
        });
    </script>
	</body>
</html>