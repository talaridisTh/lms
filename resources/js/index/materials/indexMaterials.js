import utilities from '../../index/main';


utilities.addWhatchlist()



//! CAROUSEL
//!============================================================
var swiper = new Swiper('.swiper-container', {
    // Optional parameters



    // If we need pagination
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

    // And if we need scrollbar
    scrollbar: {
        el: '.swiper-scrollbar',
    },
    keyboard: {
        enabled: true,
        onlyInViewport: false,
    },
})
$('#bs-example-modal-lg').on('shown.bs.modal', function(e) {
    console.log("S")
    swiper.update();
    var $invoker = $(e.relatedTarget);
    swiper.slideTo($invoker.data('slider'));
    swiper.update();
});

