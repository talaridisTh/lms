import utilities from '../../index/main';
require('../../../../node_modules/lightbox2/dist/js/lightbox');

import * as FilePond from 'filepond';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';
import 'filepond/dist/filepond.min.css';
import Swiper from "swiper";

FilePond.setOptions({
    maxFiles: 6,
    allowMultiple: true,
    className: "js-filepond-file-dragging",
    labelIdle: "Drag & Drop your files or Browse",
    allowRevert: false
});

FilePond.registerPlugin(FilePondPluginFileValidateType);
FilePond.registerPlugin(FilePondPluginFileValidateSize);
FilePond.registerPlugin(FilePondPluginImagePreview);
var pond = {};
const initFilepond = () => {

    let dropzone = document.getElementById("file-pond");
    pond = FilePond.create(dropzone, {
        server: {
            url: window.location.origin,
            process: {
                url: '/discussion/comment/upload',
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                },
                onload: function (data) {
                }
            }

        },

        onprocessfiles: function () {

            let files = pond.getFiles().map(file => {
                return file.filenameWithoutExtension
            })
            $(".js-form-reply").prop('disabled', false);
            // delete   $(".js-form-reply")[0].dataset.upload
            $(".js-form-reply")[0].dataset.upload = JSON.stringify(files);

        },
        onaddfile: function (error, file) {
            $(".js-form-reply").prop('disabled', true);
        },

        acceptedFileTypes: ['image/png', 'image/jpeg'],
        allowReorder: true
    });
}

initFilepond();

utilities.addWhatchlist()


//! CAROUSEL-swiper
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


//! announcements-swiper
//!============================================================

var swiperAnnouncements = new Swiper('.swiper-container-announcements', {
    // Optional parameters


    // If we need pagination
    pagination: {
        el: '.swiper-pagination-announcements',
        draggable: true,
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
let countSlider = 0
$(".cnt-announcement").on("click", function (e) {
    countSlider = $(e.target).data("count")
})
$('#announcements-modal').on('shown.bs.modal', function (e) {
    swiperAnnouncements.update();
    var $invoker = $(e.relatedTarget);
    swiperAnnouncements.slideTo($invoker.data('slider'));
    swiperAnnouncements.update();
    swiperAnnouncements.slideTo(countSlider);
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

$(".js-link-material").on("click", async function (e) {

    const href = this.href;
    e.preventDefault()
    console.log(e.target.tagName)
    if (e.target.tagName === "SPAN" || e.target.tagName === "I") {
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

$(".material-count").on("click", function (e) {
    event.preventDefault();

    axiosAddWitchlist(
        this.findParent(5).dataset.courseId,
        this.findParent(4).dataset.materialId,
        this.findParent(4).dataset.materialPriority,
        this
    )

    console.log(this)


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
    console.log(this)

    axiosAddWitchlist(this.dataset.courseId, this.dataset.materialId, null, this)
})

const axiosAddWitchlist = async (courseId, materialId, materialPriority = null, that) => {
    const btnWatchlist = $(".js-watchlist-btn")[0];
    try {
        const {data} = await axios.patch(`/add-witchlist/material`, {
            courseId,
            materialId
        })
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

$(".list-material-select")[0].findParent(3).classList.add("show")

// $(".list-material-select")[0].findParent(4).children[0].children[0].classList.add("bg-list")


document.querySelectorAll('.section-list').forEach(sectionList=>{
    if(!sectionList.children.length){
        console.log(sectionList.findParent(4).remove())
    }else{

    }


})
document.querySelectorAll(".section").forEach((section,idx)=>{

    console.log(section.findChild(5).innerHTML = `Ενότητα ${idx+1}: &nbsp `)
})


let href = $(".nav-tabs").children().first().find("a").attr( "href").substring(1);

$(".nav-tabs").children().first().find("a").addClass("active")
$(".tab-content").find(`#${href}`).addClass("active");


$(document).on("click", ".js-form-reply", async function (e) {
    e.preventDefault()
    let body = $('textarea#reply-body').val()


    if (!body) {
        if (!$(".validate-form-post").length) {
            $('#new-reply').modal('show');
            $("<p class='text-danger mt-2 validate-form-post'>*Tο πεδίο είναι απαραίτητο</p>").insertAfter("#reply-body");

        }
        return
    } else {
        body = `<span class="text-info">${$(".replay-name").text()}</span> ${body}`
    }

    console.log(this)
    const modelInfo = JSON.parse(this.dataset.model)
    const parentId = this.dataset.parent;
    const namespace = this.dataset.namespace;
    // delete this.dataset.upload;
    let upload = typeof this.dataset.upload == "undefined" ? [] : JSON.parse(this.dataset.upload);
    this.disabled = true
    $(".validate-form-post").remove();
    try {
        const {data, status} = await axios.post(`/model/comment`, {
            modelInfo,
            body,
            namespace,
            parentId,
            upload

        });
        if (status == 200) {
            $(".cnt-reply-list").html($(data).find(".reply-list")) //reload post
            $('#new-reply').modal('hide')
            $('#form-create-reply')[0].reset()
            pond.removeFiles();
            delete this.dataset.upload;
            this.disabled = false
            $(".text-reply-comment").text("Νέο μήνυμα")
        }

    } catch (e) {
        console.log(e)
    }

})

const onFirstReplayBtnEvent = () => {

    $(document).on("click", ".first-thread-replay", function () {
        let model = $(".hidden-post").data("model-info");
        let namespace = $(".hidden-post").data("namespace");


        $("#new-reply").find(".replay-name").text("");
        $(".js-form-reply")[0].dataset.model = JSON.stringify(model)
        $(".js-form-reply")[0].dataset.parent = 0
        $(".js-form-reply")[0].dataset.namespace = namespace;

    })

}

const onCommentReplayBtnEvent = () => {
    $(".cnt-reply-list").on("click", ".js-comment-reply", function () {
        let model = $(".hidden-post").data("model-info");
        let parentId = this.closest(".main-post").dataset.commentId;
        let author = $(this).closest(".main-post").find(".author-post-name").text()

        $("#new-reply").find(".replay-name").text(`@${author}`);
        $(".js-form-reply")[0].dataset.model = JSON.stringify(model)
        $(".js-form-reply")[0].dataset.parent = parentId
    })
}

const onSubCommentReplayBtnEvent = () => {
    $(".cnt-reply-list").on("click", ".js-sub-comment-reply", function () {
        let model = $(".hidden-post").data("model-info");
        let parentId = this.closest(".main-post").dataset.commentId;
        let author = $(this).closest(".main-post").find(".author-post-name").text()

        $("#new-reply").find(".replay-name").text(`@${author}`);
        $(".js-form-reply")[0].dataset.model = JSON.stringify(model)
        $(".js-form-reply")[0].dataset.parent = parentId
    })
}


const bestAnswer = () => {
    $(".cnt-list-content").on("click", ".js-best-answer", async function () {
        $(".js-best-answer").not($(this)).removeClass("is-active-best").addClass("is-active-best text-info")

        $(".js-best-answer").not($(this)).closest(".main-post").removeClass("best-answer-cnt")


        if ($(this).hasClass("is-active-best")) {

            $(this).closest(".main-post").addClass("best-answer-cnt")

            $(this).removeClass("is-active-best text-info").addClass("text-success")

            $(this).parent().append('<a href="#" class="ml-3 mt-2 badge badge-success badge-best font-14">Best Answer</a>\n');
        } else {

            $(this).closest(".main-post").removeClass("best-answer-cnt")

            $(this).removeClass("text-success").addClass("is-active-best text-info")

            $(this).parent().find(".badge-best").remove()

        }

        $(".js-best-answer").not($(this)).parent().find(".badge-best").remove();


        let commentId = $(this).closest(".main-post").data("threadId")
        let model = $(".hidden-post").data("model-info").id;

        try {

            const {data, status} = await axios.patch(`/discussion/best/${commentId}`, {
                model
            })

            if (status == 200) {

            }

        } catch (e) {
            console.log(e)
        }

    })


}

const onDeleteComment = () => {

    $(".cnt-reply-list").on("click", ".js-delete-comment", async function (e) {
        e.preventDefault();
        const id = this.closest(".main-post").dataset.threadId
        const modelInfo = $(".hidden-post").data("model-info");
        try {
            const {data, status} = await axios.post(`/model/delete`, {
                modelInfo,
                id
            })

            if (!data.comment){
                $(".text-reply-comment").text("Έναρξη συζήτησης")
            }

            if (status == 200) {
                $(".cnt-reply-list").html($(data.view).find(".reply-list")) //reload post

            }

        } catch (e) {
            console.log(e)
        }
    })

}

const onLikebtn = () => {
    $(".cnt-reply-list").on("click", ".btn-reply-like", async function () {
        try {
            const {data, status} = await axios.patch(`/discussion/like-comment/${this.dataset.commentId}`)

            if (status == 200) {
                if (data) {
                    this.classList.add("like-class")

                    this.firstElementChild.innerHTML.trim().length == 0 ?
                        this.firstElementChild.innerHTML = parseInt(1) :
                        this.firstElementChild.innerHTML = parseInt(this.firstElementChild.innerHTML) + 1
                } else {
                    this.classList.remove("like-class")
                    this.firstElementChild.innerHTML.trim() == "1" ?
                        this.firstElementChild.innerHTML = "" :
                        this.firstElementChild.innerHTML = parseInt(this.firstElementChild.innerHTML) - 1
                }
            }
        } catch (e) {
            console.log(e)
        }
    })
}
const onChangeReplyButton  =  ()=>{
    if($(".main-post").attr("data-count")){
        $(".text-reply-comment").text("Νέο μήνυμα")
    }else{

        $(".text-reply-comment").text("Έναρξη συζήτησης")
    }
}
const onInitEventHandler = ()=>{
    onDeleteComment();
    onLikebtn();
    onFirstReplayBtnEvent()
    onCommentReplayBtnEvent()
    onSubCommentReplayBtnEvent();
    bestAnswer();
    onChangeReplyButton();
}
onInitEventHandler();


//pros to paron mexri n ftiaxoun ta link
(".js-link-material").parent().addClass("d-none");
