jQuery(function ($) {
    // =============== КАРТОЧКА ТОВАРА =============

    // const swiperCard = new Swiper('#main.single-product .slider__holder', {
    //   direction: 'horizontal',
    //   loop: true,
    //   slidesPerView: 1,
    //   navigation: {
    //     nextEl: '.swiper-button-next',
    //     prevEl: '.swiper-button-prev',
    //   },
    //   autoplay: {
    //    delay: 3000,
    //   },
    //   thumbs: {
    //     swiper: {
    //       el: '#main.single-product .thumbs__holder',
    //       slidesPerView: 5,
    //       direction: 'horizontal',
    //       spaceBetween: 10,
    //       breakpoints: {
    // 	    // when window width is >= 320px
    // 	    320: {
    // 	      slidesPerView: 3,
    // 	    },
    // 	    // when window width is >= 480px
    // 	    480: {
    // 	      slidesPerView: 4,
    // 	    },
    // 	    // when window width is >= 640px
    // 	    640: {
    // 	      slidesPerView: 5,
    // 	    }
    // 	  }
    //     }
    //   }
    // });
    
    const swiperProject = new Swiper(".product__gallery-swiper", {
        direction: "horizontal",
        slidesPerView: 1,
        spaceBetween: 20,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        autoplay: {
            delay: 4000,
        },
    });

    

    const swiperRelated = new Swiper("#related_slider", {
        direction: "horizontal",
        slidesPerView: 1,
        spaceBetween: 15,
        pagination: {
            el: ".swiper-pagination",
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
    	    460: {
                slidesPerView: 2,
    	    },
    	    730: {
                slidesPerView: 3,
    	    },
    	    800: {
                slidesPerView: 3,
    	    },
            1000: {
                slidesPerView: 3,
            },
            1200: {
                slidesPerView: 4,
                spaceBetween: 30,
            }
    	}
    });
});
