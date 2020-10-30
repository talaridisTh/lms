import utilities from '../../index/main';
import Swiper from "swiper";


utilities.addWhatchlist()

//! announcements-swiper
//!============================================================
// var swiperAnnouncements = new Swiper('.swiper-container-announcements', {
//     // Optional parameters
//
//
//     // If we need pagination
//     pagination: {
//         el: '.swiper-pagination-announcements',
//         draggable: true,
//     },
//     fadeEffect: {
//         crossFade: true
//     },
//
//     // Navigation arrows
//     navigation: {
//         nextEl: '.swiper-button-next-announcements',
//         prevEl: '.swiper-button-prev-announcements',
//     },
//
//     // And if we need scrollbar
//     scrollbar: {
//         el: '.swiper-scrollbar-announcements',
//     },
//     keyboard: {
//         enabled: true,
//         onlyInViewport: false,
//     },
// })
// $('#announcements-modal').on('shown.bs.modal', function (e) {
//     swiperAnnouncements.update();
//     var $invoker = $(e.relatedTarget);
//     swiperAnnouncements.slideTo($invoker.data('slider'));
//     swiperAnnouncements.update();
// });

//FILTER TOPIC
$(".filter-topic").click(function () {
    filterTopic(this.dataset.topicId, this.findParent(1).dataset.userSlug)

    for (let i = 0; i < $(".filter-topic").length; i++) {
        $(".filter-topic")[i].firstElementChild.children[0].classList.remove("text-light")
    }

    this.firstElementChild.children[0].classList.add("text-light")


})

const filterTopic = async (idsTopic, userSlug) => {

    const res = await axios.get(`/courses/${userSlug}`, {
        params: {
            "idsTopic": idsTopic
        }

    })
    if (res.status == 200) {
        $('.content-filter').html($(res.data).find(".filter-data")
            .addClass('w-100 flex-wrap'))

    }
}

//WATCHLIST
$(".material-count").on("click",  function (e) {
    event.preventDefault();

    axiosAddWitchlist(
        this.findParent(5).dataset.courseId,
        this.findParent(4).dataset.materialId,
        this.findParent(4).dataset.materialPriority,
        this
    )




}).on('mouseenter', function () {
    setTimeout(() => {
        if (!this.dataset.hover) {
            this.innerHTML = "<i style='opacity: 0.6' class='text-danger  h4 mdi mdi-check-bold'></i>"
        }
    }, 150)
}).on('mouseleave', function () {
    setTimeout(() => {
        if (!this.dataset.hover) {

            console.log(this)
            this.innerHTML = `${this.findParent(4).dataset.materialPriority}`
        }
    }, 150)

});

$(".js-watchlist-btn").on("click",function () {


    axiosAddWitchlist(this.dataset.courseId,this.dataset.materialId,null,this)
})

const axiosAddWitchlist =async (courseId, materialId, materialPriority=null,that) => {
    const btnWatchlist  = $(".js-watchlist-btn")[0];
    try {
        const {data} = await axios.patch(`/add-witchlist/material`, {
            courseId,
            materialId
        })
        if (data === "remove") {
            that.innerHTML = `${materialPriority}`
            if (!materialPriority){
                btnWatchlist.innerHTML = "<span class='font-16'>Το έχω δει</span>"
                btnWatchlist.style.backgroundColor = null
                btnWatchlist.classList.remove("bg-white")
            }

            delete that.dataset.hover

        } else {
            that.innerHTML = "<i class='text-danger h4 mdi mdi-check-bold'></i>"
            that.dataset.hover = "hover"
            if (!materialPriority) {
                btnWatchlist.innerHTML = "<span class='text-dark font-16'>Δεν το έχω δει</span>"
                btnWatchlist.style.backgroundColor = "white"
            }
        }

    } catch (e) {
        console.log(e)
    }
}

// EVENET LISTENER
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

$(".js-link-material").on("click", async function (e) {

    const href = this.href;
    e.preventDefault()
    console.log(e.target.tagName)
    if (e.target.tagName === "SPAN" || e.target.tagName === "I" ) {
        return

    } else {
        const {value} = await Swal.fire({
            icon: 'question',
            html: "Mεταφερθείτε στο Link!"+"<br>"+href ,
            showCancelButton: true,
            confirmButtonText: 'Εντάξει',
            cancelButtonText: "Ακύρωση "
        })
        if (value) {
            console.log(href)
            window.open(href,'_target');

        }
    }


})


$(".section-list")

document.querySelectorAll('.section-list').forEach(sectionList=>{
    if(!sectionList.children.length){
        console.log(sectionList.findParent(4).remove())
    }else{

    }


})
document.querySelectorAll(".section").forEach((section,idx)=>{

    console.log(section.findChild(5).innerHTML = `Ενότητα ${idx+1}: &nbsp `)
})







