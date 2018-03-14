// Main front page slider
jQuery('.slider').slick({
    dots         : false,
    infinite     : true,
    speed        : 300,
    autoplay     : true,
    autoplaySpeed: 6000,
    arrows       : false
    // prevArrow    : jQuery(".slick-home-prev"),
    // nextArrow    : jQuery(".slick-home-next")
});
jQuery('.testimonials-wrap').slick({
    dots         : false,
    infinite     : true,
    speed        : 500,
    autoplay     : true,
    autoplaySpeed: 6000,
    arrows       : false,
    fade         : true,
    cssEase      : 'linear',
    slidesToShow : 1
});
jQuery('.testimonials-wrap').show();

jQuery('.carousel-wrap').slick({
    dots         : false,
    infinite     : true,
    speed        : 500,
    autoplay     : true,
    autoplaySpeed: 3000,
    arrows       : false,
    fade         : true,
    cssEase      : 'linear',
    slidesToShow : 1
});
jQuery('.carousel-wrap').show();
