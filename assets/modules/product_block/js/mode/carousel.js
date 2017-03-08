$(function() {
    var swiper = new Swiper('.swiper-container._carousel', {
        pagination: '._carousel .swiper-pagination',
        slidesPerView: carousel_col,
        paginationClickable: true,
        // autoplay: 3000,
        loop:true,
        nextButton: '._carousel ._carousel-button-next'+carousel_col,
    		prevButton: '._carousel ._carousel-button-prev'+carousel_col,
        //nextButton: 'swiper-button-next',
    		//prevButton: 'swiper-button-prev',

        spaceBetween: 0,
        breakpoints: {
          2048: {
              slidesPerView: 3,
              spaceBetween: 0
          },
            1024: {
                slidesPerView: 3,
                spaceBetween: 0
            },
            768: {
                slidesPerView: 1,
                spaceBetween: 0
            }
        }
    });
});
