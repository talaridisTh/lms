import 'swiper/swiper-bundle.css';

import Splide from '@splidejs/splide';
import Grid from '@splidejs/splide-extension-grid';


const CURRENT_ROUTE = $('meta[name=route]').attr('content');

if (CURRENT_ROUTE == "home") {
    if ($("#card-slider-primary").length) {
        document.addEventListener('DOMContentLoaded', function () {
            new Splide('#card-slider-primary', {
                gap: 10,
                perPage: 3,
                breakpoints: {
                    600: {
                        perPage: 1,
                    }
                },

            }).mount();
        });
    }
    if ($("#card-slider-secondary").length) {
        document.addEventListener('DOMContentLoaded', function () {
            new Splide('#card-slider-secondary', {
                gap: 10,
                perPage: 3,
                breakpoints: {
                    600: {
                        perPage: 1,
                    }
                },

            }).mount();
        });
    }
}

if (CURRENT_ROUTE == "index.userCourses") {
    document.addEventListener('DOMContentLoaded', function () {
        new Splide("#lessons-slide", {
            grid: {
                rows: 2,
                cols: 3,
            },
            breakpoints: {
                1588: {
                    grid: {
                        rows: 2,
                        cols: 3,
                    }
                },
                1246: {
                    grid: {
                        rows: 2,
                        cols: 2,
                    }
                },
                863: {
                    grid: false,
                }
            },
        }).mount({Grid});
    });
}

// document.addEventListener('DOMContentLoaded', function () {
//     new Splide('#card-slider', {
//         perPage: 3,
//         breakpoints: {
//             600: {
//                 perPage: 1,
//             }
//         },
//
//     }).mount();
// });
