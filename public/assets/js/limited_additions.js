        $(document).ready(function() {
            // Smooth scroll for navigation links
            $('a[href^="#"]').on('click', function(event) {
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: $($.attr(this, 'href')).offset().top - 80 // Adjust for fixed header if any
                }, 500);
            });

            // Show/hide back to top button
            $(window).scroll(function() {
                if ($(this).scrollTop() > 300) { // Show button after scrolling 300px
                    $('#backToTop').fadeIn();
                } else {
                    $('#backToTop').fadeOut();
                }
            });

            // Scroll to top when button is clicked
            $('#backToTop').on('click', function(event) {
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: 0
                }, 500);
            });
        });