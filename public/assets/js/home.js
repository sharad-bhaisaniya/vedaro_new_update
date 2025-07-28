    var previousButton, nextButton;
    var slides;

    window.addEventListener('DOMContentLoaded', function () {
        previousButton = document.querySelector('.carousel .previous-button');
        nextButton = document.querySelector('.carousel .next-button');
        slides = document.querySelectorAll('.carousel .slides .slide');

        // Fix layout reflow issues after initialization
        $('.carousel .slides').on('init', function (e, slick) {
            setTimeout(function () {
                slick.$slider.slick('setPosition');
            }, 100); // small delay to ensure layout is settled
        });

        $('.carousel .slides').on('beforeChange', function (e, slick, currentSlide, nextSlide) {
            // Optional: Add custom logic if needed
        });

        $('.carousel .slides').on('afterChange', function (e, slick, currentSlide) {
            // Optional: Add custom logic if needed
        });

        $('.carousel .slides').slick({
            dots: false, // ✅ Removed dots
            accessibility: false,
            autoplay: true,
            autoplaySpeed: 2000,
            arrows: true,
            fade: false, // ✅ Using slide animation
            speed: 700,
            cssEase: 'ease-in-out',
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            prevArrow: previousButton,
            nextArrow: nextButton
        });
    });


// 	--------------------------------------------------------------------------------------
	
	
	const toggleBtn = document.getElementById("toggleBtn");
	const imageSection = document.getElementById("imageSection");
	const videoSection = document.getElementById("videoSection");
	
	toggleBtn.addEventListener("click", () => {
	const isImageVisible = !imageSection.classList.contains("d-none");
	
	if (isImageVisible) {
	  imageSection.classList.add("d-none");
	  videoSection.classList.remove("d-none");
	  toggleBtn.textContent = "Show Image";
	} else {
	  videoSection.classList.add("d-none");
	  imageSection.classList.remove("d-none");
	  toggleBtn.textContent = "Show Video";
	}
	});



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
	
	
	
	
	
	
	function changeMainImage(newSrc) {
	    const mainImage = document.getElementById('mainImage');
	    if (mainImage) {
	        mainImage.src = newSrc;
	
	        // Optional: Add a simple class for a quick visual effect on change
	        mainImage.classList.add('image-changing');
	        setTimeout(() => {
	            mainImage.classList.remove('image-changing');
	        }, 300); // Remove the class after the transition duration
	    } else {
	        console.error("Main image element with ID 'mainImage' not found.");
	    }
	}

	
	
	function scrollToLeft() {
	  document.getElementById('scrollContainer').scrollBy({
	    left: -300,
	    behavior: 'smooth'
	  });
	}
	
	function scrollToRight() {
	  document.getElementById('scrollContainer').scrollBy({
	    left: 300,
	    behavior: 'smooth'
	  });
	}
	
	function scrollToCards() {
	  const target = document.getElementById("productCards");
	  if (target) {
	    target.scrollIntoView({ behavior: "smooth" });
	  }
	}