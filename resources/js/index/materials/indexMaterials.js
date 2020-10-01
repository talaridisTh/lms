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
$('#bs-example-modal-lg').on('shown.bs.modal', function (e) {
    console.log("S")
    swiper.update();
    var $invoker = $(e.relatedTarget);
    swiper.slideTo($invoker.data('slider'));
    swiper.update();
});

$(".js-audio-btn").click(function () {
    let cnt = this.parentElement;
    let audio = cnt.getElementsByClassName("js-audio")[0];

    if (this.dataset.audioStatus == "paused") {
        this.classList.remove("mdi-play-circle-outline");
        this.classList.add("mdi-pause-circle-outline");
        this.dataset.audioStatus = "playing";

        audio.currentTime = 0;
        audio.play();
    } else {
        this.classList.remove("mdi-pause-circle-outline");
        this.classList.add("mdi-play-circle-outline");
        this.dataset.audioStatus = "paused";

        audio.pause();
    }
})

$(".js-alert").on("click",async function (e) {
    const href = this.findParent(1).href;
    this.findParent(1).removeAttribute("href")
    const {value} = await Swal.fire({
        icon: 'question',
        text: ' Πατήστε στο ok  για να μεταφερθείτε! ',
        showCancelButton: true,
    })
    if (value) {
        window.open(`${href}`, '_blank');
    }
})

$(".material-count").on("click", async function (e) {
    event.preventDefault();
    const courseId = this.findParent(5).dataset.courseId;
    const materialId = this.findParent(4).dataset.materialId;
    const materialPriority = this.findParent(4).dataset.materialPriority;

    try {
        const {data, status} = await axios.patch(`/add-witchlist/material`, {
            courseId,
            materialId
        })
        if (data === "remove") {
            this.children[0].innerHTML = "<i class='text-danger h4 mdi mdi-check-bold'></i>"
            this.dataset.hover = "hover"
        } else {
            this.children[0].innerHTML = `<span>${materialPriority}</span>`
            delete this.dataset.hover
        }

    } catch (e) {
        console.log(e)
    }


}).on('mouseenter', function () {
    if (!this.dataset.hover) {

        this.children[0].innerHTML = "<i style='opacity: 0.6' class='text-danger  h4 mdi mdi-check-bold'></i>"
    }
}).on('mouseleave', function () {
    if (!this.dataset.hover) {
        this.children[0].innerHTML = `<span>${this.findParent(4).dataset.materialPriority}</span>`
    }
});

