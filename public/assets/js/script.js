$(document).ready(function() {
    $('.hover-container').hover(
        function() {
            $(this).find('.starts_from').hide();
            $(this).find('.view-details').show();
        },
        function() {
            $(this).find('.view-details').hide();
            $(this).find('.starts_from').show();
        }
    );
});

// ----------------------product details tabs----------------------------