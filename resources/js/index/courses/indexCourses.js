import utilities from '../../index/main';
import Swiper from 'swiper/bundle';
import 'swiper/swiper-bundle.css';

utilities.addWhatchlist()


if ($('meta[name=route]').attr('content') == "index.userCourse") {
    const slugCourse = $(".course-slug")[0].dataset.courseSlug
    window.PREVIEW_PAGE_COURSE = `/dashboard/course/${slugCourse}`
}


//! announcements-swiper
//!============================================================
var swiperAnnouncements = new Swiper('.swiper-container-announcements', {
    // Optional parameters


    // If we need pagination
    pagination: {
        el: '.swiper-pagination-announcements',
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
        el: '.swiper-scrollbar-announcements',
    },
    keyboard: {
        enabled: true,
        onlyInViewport: false,
    },
})
$('#announcements-modal').on('shown.bs.modal', function (e) {
    swiperAnnouncements.update();
    var $invoker = $(e.relatedTarget);
    swiperAnnouncements.slideTo($invoker.data('slider'));
    swiperAnnouncements.update();
});

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

        handlerCountMaterial()

    }

}

function handlerCountMaterial() {
    let materialCount = 0
    let extraMaterialCount = 0
    document.querySelectorAll('.all-material').forEach(material => {
        materialCount += parseInt(material.innerHTML.replace("Μαθήματα : ", ""));

    })

    document.querySelectorAll('.all-extra-material').forEach(material => {
        extraMaterialCount += parseInt(material.innerHTML.replace("Βοηθητικά Αρχεία :", ""));

    })

    $(".cnt-count-material")[0].innerHTML = `


            <div class="offset-4 col-md-4 offset-4 d-flex justify-content-around ">

                <div class="text-center">
                    <i class="mdi font-24 mdi-book-open-page-variant"></i>
                    <p>${materialCount}</p>
                    <p>Μαθήματα</p>
                </div>

                <div class="text-center">
                     <i class="uil font-24 uil-books"></i>
                    <p>${extraMaterialCount}</p>
                    <p>Βοηθητικά Αρχεία</p>
                </div>

            </div>

        `
}

if (window.location.pathname == "/courses/admin") {

    handlerCountMaterial()
}

//WATCHLIST
$(".material-count").on("click", function (e) {
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

            this.innerHTML = `${this.findParent(4).dataset.materialPriority}`
        }
    }, 150)

});

$(".js-watchlist-btn").on("click", function () {


    axiosAddWitchlist(this.dataset.courseId, this.dataset.materialId, null, this)
})

const axiosAddWitchlist = async (courseId, materialId, materialPriority = null, that) => {
    // console.log(courseId)
    // console.log(materialId)
    // console.log(materialPriority)
    // console.log(that)
    const btnWatchlist = $(".js-watchlist-btn")[0];
    try {
        const {data} = await axios.patch(`/add-witchlist/material`, {
            courseId,
            materialId
        })
        console.log(data)
        if (data === "remove") {
            that.innerHTML = `${materialPriority}`
            if (!materialPriority) {
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
    if (e.target.tagName === "SPAN" || e.target.tagName === "I") {
        console.log(e.target)
        return

    } else {
        const {value} = await Swal.fire({
            icon: 'question',
            html: "Mεταφερθείτε στο Link!" + "<br>" + href,
            showCancelButton: true,
            confirmButtonText: 'Εντάξει',
            cancelButtonText: "Ακύρωση "
        })
        if (value) {
            console.log(href)
            window.open(href, '_target');

        }
    }


})

document.querySelectorAll('.section-list').forEach(sectionList => {
    if (!sectionList.children.length) {
        console.log(sectionList.findParent(4).remove())
    } else {

    }


})
document.querySelectorAll(".section").forEach((section, idx) => {

    console.log(section.findChild(5).innerHTML = `Ενότητα ${idx + 1}: &nbsp `)
})


$(".template-prevent").on("click", async function (e) {
    e.preventDefault();


    try {
        const {data, status} = await axios.get(this.href)


        templateHandler(data, this);
        onFullScreen();
        onCloseFullScreen();
        onPreviewMaterial();
    } catch (e) {
        console.log(e)
    }
})

const templateHandler = (data, that) => {
    $(".template-single-page").html($(data).find("#content-custom"));
    $(".template-hidden").hide();
    $(".template-col-12")[0].classList.add("col-lg-12")

    $(".template-cnt-title")[0].innerHTML = `
                 <h2 data-material-slug="${that.dataset.materialSlug}" class="template-title">${that.dataset.materialTitle}</h2>
                <div >
                    <i class="font-18 uil-window-maximize cursor-pointer mr-1"></i>
                    <i class="font-18 uil-times-circle cursor-pointer"></i>
                </div>
            `
}

const onPreviewMaterial = () => {
    const previewMaterial = $(".edit-preview-page-material")[0]
    previewMaterial.classList.remove("d-none")

    const slugMaterial = $(".template-title")[0].dataset.materialSlug
    window.PREVIEW_PAGE_MATERIAL = `/dashboard/material/${slugMaterial}`
    previewMaterial.href = window.PREVIEW_PAGE_MATERIAL
}

const onFullScreen = () => {
    $(".uil-window-maximize").on("click", function () {
        const templateLeft = $(".template-single-page")[0]
        const templateRight = $(".template-material-list")[0]

        if (templateRight.classList.contains("d-lg-none")) {
            this.classList.add("uil-window-maximize")
            this.classList.remove("uil-minus-path")

            templateLeft.classList.remove("col-lg-12")
            templateLeft.classList.add("col-lg-8")

            templateRight.classList.remove("d-lg-none")
            templateRight.classList.add("d-lg-block")
        } else {
            this.classList.remove("uil-window-maximize")
            this.classList.add("uil-minus-path")

            templateLeft.classList.add("col-lg-12")
            templateLeft.classList.remove("col-lg-8")

            templateRight.classList.add("d-lg-none")
            templateRight.classList.remove("d-lg-block")

        }
    })
}
// uil-minus-path
const onCloseFullScreen = () => {
    $(".uil-times-circle").on("click", async () => {

        try {
            const {data, status} = await axios.get(window.location.href)

            $(".template-single-page").html($(data).find(".template-single-page > div"));

            const templateLeft = $(".template-single-page")[0]
            const templateRight = $(".template-material-list")[0]

            templateRight.classList.remove("d-lg-none")
            templateRight.classList.add("d-lg-block")

            templateLeft.classList.remove("col-lg-12")
            templateLeft.classList.add("col-lg-8")


        } catch (e) {
            console.log(e)
        }
    })


}








