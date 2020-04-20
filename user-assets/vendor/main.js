$(`#products`).slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 1500,
    arrows: false,
    dots: false,
    pauseOnHover: false,
    responsive: [{
        breakpoint: 768,
        settings: {
            slidesToShow: 1
        }
    }, {
        breakpoint: 520,
        settings: {
            slidesToShow: 1
        }
    }]
});
$(`#${index}`).on('wheel', (function(e) {
    e.preventDefault();

    if (e.originalEvent.deltaX < 0) {
    $(this).slick('slickNext');
    } else {
    $(this).slick('slickPrev');
    }
}));