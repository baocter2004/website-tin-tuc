$.noConflict();

jQuery(document).ready(function($) {

    "use strict";

    // Khởi tạo SelectFx
    [].slice.call(document.querySelectorAll('select.cs-select')).forEach(function(el) {
        new SelectFx(el);
    });

    // Kích hoạt selectpicker
    $('.selectpicker').selectpicker();

    // Search trigger
    $('.search-trigger').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        $('.search-trigger').parent('.header-left').addClass('open');
    });

    $('.search-close').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        $('.search-trigger').parent('.header-left').removeClass('open');
    });

    // Equal height
    $('.equal-height').matchHeight({
        property: 'max-height'
    });

    // Counter Number
    $('.count').each(function () {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).text()
        }, {
            duration: 3000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });

    // Menu Trigger
    $('#menuToggle').on('click', function(event) {
        var windowWidth = $(window).width();  
        if (windowWidth < 1010) {
            $('body').removeClass('open'); 
            if (windowWidth < 760) {
                $('#left-panel').slideToggle(); 
            } else {
                $('#left-panel').toggleClass('open-menu');  
            } 
        } else {
            $('body').toggleClass('open');
            $('#left-panel').removeClass('open-menu');  
        }
    });

    // Menu with children
    $(".menu-item-has-children.dropdown").each(function() {
        $(this).on('click', function() {
            var $temp_text = $(this).children('.dropdown-toggle').html();
            $(this).children('.sub-menu').prepend('<li class="subtitle">' + $temp_text + '</li>');
        });
    });

    // Load Resize
    $(window).on("load resize", function(event) {
        var windowWidth = $(window).width();
        if (windowWidth < 1010) {
            $('body').addClass('small-device');
        } else {
            $('body').removeClass('small-device');
        }
    });

});
