import utilities from '../index/main';
import Swiper from 'swiper/bundle';
import 'swiper/swiper-bundle.css';

import Splide from '@splidejs/splide';

document.addEventListener( 'DOMContentLoaded', function () {
    new Splide( '#card-slider-primary', {
        gap       : 10,
        perPage    : 3,
        breakpoints: {
            600: {
                perPage: 1,
            }
        },

    } ).mount();
} );

document.addEventListener( 'DOMContentLoaded', function () {
    new Splide( '#card-slider-secondary', {
        gap       : 10,
        perPage    : 3,
        breakpoints: {
            600: {
                perPage: 1,
            }
        },

    } ).mount();
} );


document.addEventListener( 'DOMContentLoaded', function () {
    new Splide( '#card-slider', {
        perPage    : 3,
        breakpoints: {
            600: {
                perPage: 1,
            }
        },

    } ).mount();
} );


