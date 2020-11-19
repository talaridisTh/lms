import utilities from '../index/main';
import Swiper from 'swiper/bundle';
import 'swiper/swiper-bundle.css';

import Splide from '@splidejs/splide';

document.addEventListener( 'DOMContentLoaded', function () {
    new Splide( '#card-slider-primary', {
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
        perPage    : 3,
        breakpoints: {
            600: {
                perPage: 1,
            }
        },

    } ).mount();
} );




function animateValue($obj, start, end, duration) {
    var range = end - start;
    var current = start;
    var increment = end > start? 1 : -1;
    var stepTime = Math.abs(Math.floor(duration / range));
    var timer = setInterval(function() {
        current += increment;
        $obj.text(current);
        if (current == end) {
            // $obj.text($obj.text()+'+');
            clearInterval(timer);
        }
    }, stepTime);
}


for (let i = 1; i <=$('.count-number').length ; i++) {
    var $number = $(`.count-number-${i}`),
        start = $number.attr('data-start')*1,
        end = $number.attr('data-end')*1;


    animateValue($number, start, end, 500);
}



