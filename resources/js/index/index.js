import utilities from '../index/main';
import Swiper from 'swiper/bundle';
import 'swiper/swiper-bundle.css';


//primary slide
const countPrimary = $(".js-banner-primary")[0].dataset.count
new Swiper('.primary-slide', {
    // Optional parameters
    // If we need pagination
    slidesPerView: countPrimary,
    spaceBetween: 30,
    freeMode: true,
    pagination: {
        el: '.swiper-pagination',
        draggable: true,
    },
    fadeEffect: {
        crossFade: true
    },

    // Navigation arrows
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

})

//secondary slide
const countSecondary = $(".js-banner-secondary")[0].dataset.count
new Swiper('.secondary-slide', {
    // Optional parameters
    // If we need pagination
    slidesPerView: countSecondary,
    spaceBetween: 30,
    freeMode: true,
    pagination: {
        el: '.swiper-pagination',
        draggable: true,
    },
    fadeEffect: {
        crossFade: true
    },

    // Navigation arrows

    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

})


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



