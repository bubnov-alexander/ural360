// jQuery(document).ready(function ($) {
//     const swiperGallery = new Swiper("#gallery-block .gallery", {
//         direction: "vertical",
//         slidesPerView: 1,
//         pagination: {
//             el: ".swiper-pagination",
//             clickable: true,
//         },
//         navigation: {
//             prevEl: "#gallery-block .nav__prev",
//             nextEl: "#gallery-block .nav__next",
//         },
//         autoplay: {
//             delay: 4000,
//         },
//         breakpoints: {
//             320: {
//                 slidesPerView: 1,
//                 spaceBetween: 10,
//             },
//             380: {
//                 slidesPerView: 1,
//                 spaceBetween: 20,
//             },
//             752: {
//                 slidesPerView: 1,
//                 spaceBetween: 20,
//             },
//             950: {
//                 slidesPerView: 1,
//                 spaceBetween: 30,
//             }
//         },
//     });
// });


jQuery(document).ready(function ($) {
    const swiperGallery = new Swiper("#gallery-block .gallery", {
        direction: "horizontal", // Change this to "vertical"
        slidesPerView: 1,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            prevEl: "#gallery-block .nav__prev",
            nextEl: "#gallery-block .nav__next",
        },
        autoplay: {
            delay: 4000,
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
                spaceBetween: 10,
            },
            380: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            752: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
            950: {
                slidesPerView: 3,
                spaceBetween: 30,
            }
        },
    });
});
