import utilities from '../index/main';
import Swiper from 'swiper/bundle';
import 'swiper/swiper-bundle.css';


//primary slide
new Swiper('.primary-slide', {
    // Optional parameters
    // If we need pagination
    slidesPerView: 3,
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
new Swiper('.secondary-slide', {
    // Optional parameters
    // If we need pagination
    slidesPerView: 3,
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
