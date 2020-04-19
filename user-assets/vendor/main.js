const countProduct = document.getElementById('countProduct').getAttribute('data-value');
for (let index = 0; index < countProduct; index++) {
    $(`#${index}`).slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 1500,
        arrows: false,
        dots: true,
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
}