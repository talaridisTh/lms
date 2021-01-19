import Swiper from 'swiper/bundle'; //slider.js
import 'swiper/swiper-bundle.css'; // slider.css
import "lightbox2/dist/js/lightbox" //lightbox
import feather from "feather-icons"; //icon feather
import "../../../../resources/theme/js/vendor/dropzone.min"
import * as FilePond from 'filepond';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';
import 'filepond/dist/filepond.min.css';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';

require('../../../../node_modules/lightbox2/dist/js/lightbox');

FilePond.registerPlugin(FilePondPluginFileValidateType);
FilePond.registerPlugin(FilePondPluginFileValidateSize);
FilePond.registerPlugin(FilePondPluginImagePreview);

let timer = 0;
feather.replace();

var swiperAnnouncements = new Swiper('.swiper-container-announcements', {
    autoHeight: true, //enable auto height

    pagination: {
        el: '.swiper-pagination-announcements',
        draggable: true,
    },


    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },


    scrollbar: {
        el: '.swiper-scrollbar-announcements',
    },
    keyboard: {
        enabled: true,
        onlyInViewport: false,
    },
})//init slider

$('.test-an').click(swiperAnnouncements, function () {
    toggleModal();
    swiperAnnouncements.slideTo($(this).data("swiper-count"));
})//specific swipper slider

$(".spa-click").on("click", async function (e) {
    e.preventDefault();
    const href = $(this).data("href")

    if ($(this).data("type") == "Link") {
        $('.spa-cnt').html($(""));
        const {value} = await Swal.fire({
            icon: 'question',
            html: "Mεταφερθείτε στο Link!" + "<br>" + href,
            showCancelButton: true,
            confirmButtonText: 'Εντάξει',
            cancelButtonText: "Ακύρωση "
        })
        if (value) {
            window.open(href, '_target');

        }
        return;
    }

    try {
        const {data, status} = await axios.get(href)
        if (status == 200) {
            $(".spa-click").removeClass("bg-gray-400")
            $(this).addClass("bg-gray-400")

            $('.spa-cnt').html($(data).find(".spa-cnt-material"))

            $('html,body').animate({
                    scrollTop: $("#scrollTo").offset().top - 150
                },
                'slow');

            $(".cnt-curator").remove();
            if ($(".spa-cnt").next().hasClass("lg:mt-0")) {
                $(".spa-cnt").next().addClass("lg:mt-16").removeClass("lg:mt-0")
            }


            $(".spa-tabs")[1].classList.remove("lg:w-4/6")
            $(".spa-tabs")[1].classList.remove("w-full")
            $(".spa-tabs")[1].classList.add("w-auto")
            initTabs();
            $(".cnt-dropzone").addClass("hidden").removeClass("flex-1");

            // fixPaddingTabs();
            // templateHandler(data, this);
            onFullScreen();
            onCloseFullScreen();
            // onPreviewMaterial();
            onInitEventHandler();
            initFilepond();


        }


    } catch (e) {
        console.log(e)
    }
})  //create container spa

const onCloseFullScreen = () => {

    $(".js-close-fullscreen").on("click", async function () {
        try {
            const {data, status} = await axios.get(window.location.href)
            if (status == 200) {
                $('.spa-cnt').html($(data).find(".spa-cnt > *"))
                $(".spa-click").removeClass("bg-gray-400")
                $(".spa-cnt").addClass("lg:w-4/6")
                $(".spa-list-material").removeClass("hidden lg:mt-16 lg:mt-0").addClass("lg:mt-0")
                $(".cnt-dropzone").removeClass("hidden").addClass("flex-1");
                initDropzone()
                initTabs();
                onInitEventHandler();
                initFilepond();
            }
        } catch (e) {
            console.log(e)
        }
    })
} // close spa

const onFullScreen = () => {

    $(".js-open-fullscreen").on("click", async function () {
        $(".spa-cnt").toggleClass("lg:w-4/6")
        $(".spa-list-material").toggleClass("hidden")

        $(this).toggleClass("mdi-window-maximize  mdi-dock-window")


    })
}  // fullscreen spa

const initTabs = () => {
    let tabsContainer = document.querySelector("#tabs");
    let tabTogglers = tabsContainer.querySelectorAll("a");

    tabTogglers.forEach(function (toggler) {
        toggler.addEventListener("click", function (e) {
            e.preventDefault();

            let tabName = this.getAttribute("href");

            let tabContents = document.querySelector("#tab-contents");

            for (let i = 0; i < tabContents.children.length; i++) {
                tabTogglers[i].parentElement.classList.add("bg-gray-200");
                tabTogglers[i].parentElement.classList.remove("border-t", "border-r", "border-l", "-mb-px");
                tabContents.children[i].classList.remove("hidden");
                if ("#" + tabContents.children[i].id === tabName) {
                    tabTogglers[i].parentElement.classList.add("bg-white");
                    tabTogglers[i].parentElement.classList.remove("bg-gray-200");
                    continue;
                }
                tabContents.children[i].classList.add("hidden");

            }
            e.target.parentElement.classList.add("border-t", "border-r", "border-l", "-mb-px", "bg-white");
        });
    });

    $("#tabs").children().not(".hidden").first().children().first().attr("id", "default-tab")

    document.getElementById("default-tab").click();
} // create tabs
initTabs();

if ($(".modal-button-custom").length) {
    const button = document.querySelector('.modal-button-custom')

    button.addEventListener('click', toggleModal)

    const overlay = document.querySelector('.modal-overlay-custom')

    overlay.addEventListener('click', toggleModal)
}

function toggleModal() {
    swiperAnnouncements.slideTo(0);
    const modal = document.querySelector('.modal-custom')
    modal.classList.toggle('opacity-0')
    modal.classList.toggle('pointer-events-none')

} // create modal

const initDropzone = () => {
    let myTaskSend = $(".dropzone-task").dropzone(
        {
            url: "/discussion/task/send",
            parallelUploads: 10,
            uploadMultiple: true,
            paramName: "attachment",
            init: function () {
                this.on("success", function (file) {

                    iziToast.show({
                        class: "rounded-lg",
                        timeout: 4000,
                        zindex: 99999,
                        // title: `${this.getAcceptedFiles().length > 1 ? "εργασίες ανέβηκαν" : "εργασία ανέβηκε"} `,
                        position: 'topRight',
                        theme: "dark",
                        iconUrl: "/theme/images/upload.png",
                        message: this.getAcceptedFiles().length > 1 ? ` ${this.getAcceptedFiles().length} εργασίες ανέβηκαν` : `${this.getAcceptedFiles().length} εργασία ανέβηκε `
                    });


                });
                this.on("sending", function (file, xhr, formData) {
                    const model = $(".dropzone-task").data("model")
                    formData.append("subject", model.title);
                    formData.append("body", model.title);
                    formData.append("curator", model.user_id);
                    // formData.append("receiver", model.user_id);
                    formData.append("course", model.title);
                    formData.append("dropzone", model.id);
                });
                this.on('error', function (file, errorMessage) {
                    Swal.fire({
                        toast: 'true',
                        position: 'top-end',
                        icon: "danger",
                        title: `Κάτι Πήγε Στραβά`,
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true
                    })
                });
            },

            totaluploadprogress: function (progress) {
                let bar = document.getElementById("the-progress-div")
                $(".cnt-task-bar").removeClass("invisible");
                setTimeout(function () {
                    bar.classList.remove('w-0');
                    bar.classList.add('w-full');
                }, 500);

                setTimeout(function () {
                    $(".cnt-task-bar").addClass("invisible");
                }, 2000);
            }

        }
    );
}
initDropzone()


if ($('meta[name=route]').attr('content') == "index.showCourse") {
    const slugCourse = $(".course-slug")[0].dataset.courseSlug
    window.PREVIEW_PAGE_COURSE = ` / dashboard / courses /${slugCourse}/edit`
}


FilePond.setOptions({
    maxFiles: 4,
    allowMultiple: true,
    className: "js-filepond-file-dragging",
    labelIdle: "Ανέβασμα φωτογραφιών",
    allowRevert: false
});
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
            $(".js-form-reply").prop('disabled', false).addClass("bg-theme-1").removeClass("bg-gray-500 cursor-not-allowed");
            // delete   $(".js-form-reply")[0].dataset.upload
            $(".js-form-reply")[0].dataset.upload = JSON.stringify(files);

            iziToast.show({
                class: "rounded-lg",
                timeout: 4000,
                zindex: 99999,
                // title: `${this.getAcceptedFiles().length > 1 ? "εργασίες ανέβηκαν" : "εργασία ανέβηκε"} `,
                position: 'topRight',
                theme: "dark",
                iconUrl: "/theme/images/upload.png",
                message: pond.getFiles().length > 1 ? ` ${pond.getFiles().length} φωτογραφίες ανέβηκαν` : `${pond.getFiles().length} φωτογραφία ανέβηκε `

            });

            // if (pond.status === 4) {
            //
            //     clearTimeout(timer);
            //     let files = pond.getFiles();
            //     console.log(files)
            //
            //     for (let i = 0; i < files.length; i++) {
            //
            //         if (files[i].status === 5) {
            //             timer = setTimeout(function () {
            //                 pond.removeFile(files[i]);
            //             }, (i + 1) * 500);
            //         }
            //
            //
            //     }
            // }

        },
        onaddfile: function (error, file) {
            $(".filepond--drop-label").hide();
            $(".js-form-reply").prop('disabled', true).removeClass("bg-theme-1").addClass("bg-gray-500 cursor-not-allowed");
        },

        acceptedFileTypes: ['image/png', 'image/jpeg'],
        allowReorder: true
    });
}
initFilepond();


// $('#announcements-modal').on('shown.bs.modal', function (e) {
//     swiperAnnouncements.update();
//     var $invoker = $(e.relatedTarget);
//     swiperAnnouncements.slideTo($invoker.data('slider'));
//     swiperAnnouncements.update();
//     swiperAnnouncements.slideTo(countSlider);
// });
//
// //FILTER TOPIC
// $(".filter-topic").click(function () {
//     filterTopic(this.dataset.topicId, this.findParent(1).dataset.userSlug)
//
//     for (let i = 0; i < $(".filter-topic").length; i++) {
//         $(".filter-topic")[i].firstElementChild.children[0].classList.remove("text-light")
//     }
//
//     this.firstElementChild.children[0].classList.add("text-light")
//
//
// })
//
// const filterTopic = async (idsTopic, userSlug) => {
//
//     const res = await axios.get(`/courses/${userSlug}`, {
//         params: {
//             "idsTopic": idsTopic
//         }
//
//     })
//     if (res.status == 200) {
//         $('.content-filter').html($(res.data).find(".filter-data")
//             .addClass('w-100 flex-wrap'))
//
//         handlerCountMaterial()
//
//     }
//
// }
//
// function handlerCountMaterial() {
//     let materialCount = 0
//     let extraMaterialCount = 0
//     document.querySelectorAll('.all-material').forEach(material => {
//         materialCount += parseInt(material.innerHTML.replace("Μαθήματα : ", ""));
//
//     })
//
//     document.querySelectorAll('.all-extra-material').forEach(material => {
//         extraMaterialCount += parseInt(material.innerHTML.replace("Βοηθητικά Αρχεία :", ""));
//
//     })
//
//     $(".cnt-count-material")[0].innerHTML = `
//             <div class="offset-4 col-md-4 offset-4 d-flex justify-content-around ">
//
//                 <div class="text-center">
//                     <i class="mdi font-24 mdi-book-open-page-variant"></i>
//                     <p>${materialCount}</p>
//                     <p>Μαθήματα</p>
//                 </div>
//
//                 <div class="text-center">
//                      <i class="uil font-24 uil-books"></i>
//                     <p>${extraMaterialCount}</p>
//                     <p>Βοηθητικά Αρχεία</p>
//                 </div>
//
//             </div>
//         `
// }
//
// if (window.location.pathname == "/courses/admin") {
//
//     handlerCountMaterial()
// }
//
// //WATCHLIST
// $(".material-count").on("click", function (e) {
//     event.preventDefault();
//
//
//     axiosAddWitchlist(
//         this.findParent(5).dataset.courseId,
//         this.findParent(4).dataset.materialId,
//         this.findParent(4).dataset.materialPriority,
//         this
//     )
//
//
// }).on('mouseenter', function () {
//     setTimeout(() => {
//         if (!this.dataset.hover) {
//             this.innerHTML = "<i style='opacity: 0.6' class='text-danger  h4 mdi mdi-check-bold'></i>"
//         }
//     }, 150)
// }).on('mouseleave', function () {
//     setTimeout(() => {
//         if (!this.dataset.hover) {
//
//             this.innerHTML = `${this.findParent(4).dataset.materialPriority}`
//         }
//     }, 150)
//
// });
//
// $(".js-watchlist-btn").on("click", function () {
//
//
//     axiosAddWitchlist(this.dataset.courseId, this.dataset.materialId, null, this)
// })
//
// const axiosAddWitchlist = async (courseId, materialId, materialPriority = null, that) => {
//     const btnWatchlist = $(".js-watchlist-btn")[0];
//     try {
//         const {data} = await axios.patch(`/add-witchlist/material`, {
//             courseId,
//             materialId
//         })
//         if (data === "remove") {
//             that.innerHTML = `${materialPriority}`
//             if (!materialPriority) {
//                 btnWatchlist.innerHTML = "<span class='font-16'>Το έχω δει</span>"
//                 btnWatchlist.style.backgroundColor = null
//                 btnWatchlist.classList.remove("bg-white")
//             }
//
//             delete that.dataset.hover
//
//         } else {
//             that.innerHTML = "<i class='text-danger h4 mdi mdi-check-bold'></i>"
//             that.dataset.hover = "hover"
//             if (!materialPriority) {
//                 btnWatchlist.innerHTML = "<span class='text-dark font-16'>Δεν το έχω δει</span>"
//                 btnWatchlist.style.backgroundColor = "white"
//             }
//         }
//
//     } catch (e) {
//         console.log(e)
//     }
// }
//
// // EVENET LISTENER
// $(".js-audio-btn").click(function () {
//     let cnt = this.parentElement;
//     let audio = cnt.getElementsByClassName("js-audio")[0];
//
//     if (this.dataset.audioStatus == "paused") {
//         this.classList.remove("mdi-play-circle-outline");
//         this.classList.add("mdi-pause-circle-outline");
//         this.dataset.audioStatus = "playing";
//
//         audio.currentTime = 0;
//         audio.play();
//     } else {
//         this.classList.remove("mdi-pause-circle-outline");
//         this.classList.add("mdi-play-circle-outline");
//         this.dataset.audioStatus = "paused";
//
//         audio.pause();
//     }
// })
//
// $(".js-link-material").on("click", async function (e) {
//
//     const href = this.href;
//     e.preventDefault()
//     $(".single-section-material").off();
//     if (e.target.tagName === "SPAN" || e.target.tagName === "I") {
//         return
//
//     } else {
//         const {value} = await Swal.fire({
//             icon: 'question',
//             html: "Mεταφερθείτε στο Link!" + "<br>" + href,
//             showCancelButton: true,
//             confirmButtonText: 'Εντάξει',
//             cancelButtonText: "Ακύρωση "
//         })
//         if (value) {
//             window.open(href, '_target');
//
//         }
//     }
//
//
// })
//
// document.querySelectorAll('.section-list').forEach(sectionList => {
//     if (!sectionList.children.length) {
//         sectionList.findParent(4).remove()
//     } else {
//
//     }
//
//
// })
// document.querySelectorAll(".section").forEach((section, idx) => {
//
//     section.findChild(5).innerHTML = `Ενότητα ${idx + 1}: &nbsp `
// })
//
//
// $(".template-prevent").on("click", async function (e) {
//     e.preventDefault();
//     console.log(e.target)
//     $(".single-section-material").off();
//     $(".single-section-material").on("click",".list-material",function (){
//         $('html,body').animate({
//                 scrollTop: $("#scrollTo").offset().top- 35},
//             'slow');
//     })
//     try {
//         const {data, status} = await axios.get(this.href)
//
//         if (status == 200) {
//
//             templateHandler(data, this);
//             onFullScreen();
//             onCloseFullScreen();
//             onPreviewMaterial();
//             onInitEventHandler();
//             initFilepond();
//
//             let href = $(".nav-tabs").children().first().find("a").attr("href").substring(1);
//             $(".nav-tabs").children().first().find("a").addClass("active")
//             $(".tab-content").find(`#${href}`).addClass("active");
//
//             $(".list-material ").removeAttr("style")
//             $(".bg-custom").removeAttr("style")
//             $(this).closest("li").css('cssText', 'background-color: #bebebe  !important');
//
//
//         }
//
//
//     } catch (e) {
//         console.log(e)
//     }
// })
//
// const templateHandler = (data, that) => {
//     $(".template-single-page").html($(data).find("#content-custom"));
//     $(".template-hidden").hide();
//     $(".template-col-12")[0].classList.add("col-lg-12")
//
//     $(".template-cnt-title")[0].innerHTML = `
//                  <h2 data-material-slug="${that.dataset.materialSlug}" style="margin-left: 1.1rem;" class="template-title">${that.dataset.materialTitle}</h2>
//                 <div >
//                     <i class="font-18 uil-window-maximize cursor-pointer mr-1"></i>
//                     <i class="font-18 uil-times-circle cursor-pointer"></i>
//                 </div>
//             `
//
//     $(".material-cnt").prepend(`<nav aria-label='breadcrumb'>
//             <ol class='breadcrumb mb-0'>
//                 <li class='breadcrumb-item'>
//                 <span class="uil-times-circle invisible ">
//                     <a href='#' class="visible">${$(".course-slug").text()}</a>
//                 </spanc>
//                 </li>
//                     <span class='mx-1 font-16'>/</span>
//                 <li class='breadcrumb-item active' aria-current='page'>${that.dataset.materialTitle}</li>
//             </ol>
//         </nav>`);
//
//
// }
//
// const onPreviewMaterial = () => {
//     const previewMaterial = $(".edit-preview-page-material")[0]
//     previewMaterial.classList.remove("d-none")
//
//     const slugMaterial = $(".template-title")[0].dataset.materialSlug
//     window.PREVIEW_PAGE_MATERIAL = `/dashboard/materials/${slugMaterial}/edit`
//     previewMaterial.href = window.PREVIEW_PAGE_MATERIAL
// }
//
// const onFullScreen = () => {
//     $(".uil-window-maximize").on("click", function () {
//         const templateLeft = $(".template-single-page")[0]
//         const templateRight = $(".template-material-list")[0]
//
//         if (templateRight.classList.contains("d-lg-none")) {
//             this.classList.add("uil-window-maximize")
//             this.classList.remove("uil-minus-path")
//
//             templateLeft.classList.remove("col-lg-12")
//             templateLeft.classList.add("col-lg-8")
//
//             templateRight.classList.remove("d-lg-none")
//             templateRight.classList.add("d-lg-block")
//         } else {
//             this.classList.remove("uil-window-maximize")
//             this.classList.add("uil-minus-path")
//
//             templateLeft.classList.add("col-lg-12")
//             templateLeft.classList.remove("col-lg-8")
//
//             templateRight.classList.add("d-lg-none")
//             templateRight.classList.remove("d-lg-block")
//
//         }
//     })
// }
// // uil-minus-path
// const onCloseFullScreen = () => {
//     $(".uil-times-circle").on("click", async () => {
//
//         try {
//             const {data, status} = await axios.get(window.location.href)
//             $(".list-material").removeAttr("style")
//             $(".template-single-page").html($(data).find(".template-single-page > div"));
//             const templateLeft = $(".template-single-page")[0]
//
//             const templateRight = $(".template-material-list")[0]
//             templateRight.classList.remove("d-lg-none")
//
//             templateRight.classList.add("d-lg-block")
//             templateLeft.classList.remove("col-lg-12")
//
//             templateLeft.classList.add("col-lg-8")
//             $(".edit-preview-page-material").hide();
//
//             onInitEventHandler();
//         } catch (e) {
//             console.log(e)
//         }
//
//     })
//
//
// }
$(document).on("click", ".js-form-reply", async function (e) {
    e.preventDefault()
    let body = $('textarea#reply-body').val()


    if (!body) {
        if (!$(".validate-form-post").length) {
            $('#new-reply').modal('show');
            $("<p class='text-red-400 mt-4 validate-form-post'>*Tο πεδίο είναι απαραίτητο</p>").insertAfter("#reply-body");

        }
        return
    } else {
        body = `<span class="text-blue-500 author-reply">${$(".replay-name").text()}</span> ${body}`
    }

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
            feather.replace()
            $(".filepond--drop-label").show();
            // FilePond.destroy( inputElement );
        }

    } catch (e) {
        console.log(e)
    }

})

//edit comment
const onEditComment = () => {

    $(document).on("click", ".js-edit-comment", function (e) {

        e.preventDefault()
        $(".dropdown").addClass("hidden");
        $(".dropdown-box__content").addClass("hidden");

        const thisContainer = $(`.comment-${$(this).data("class-comment")}`)
        const commentId = thisContainer.data('threadId');
        const postId = $(".hidden-post").data("model-id");
        const namespace = $(".hidden-post").data("namespace");
        let author = thisContainer.find(".author-reply")
        const pre = thisContainer.find("pre");
        thisContainer.find(".cnt-body-comment").append(`
             <div class="btn-group cnt-btn-comment my-2 space-x-3" role="group" >
                <button class="px-2 py-1 rounded-md text-black bg-gray-300 hover:bg-gray-500 btn-body-close">Close</button>
                 <button class="px-3 py-1 rounded-md bg-blue-300 hover:bg-blue-500 text-black btn-body-edit">Edit</button>
            </div>`)
        pre.replaceWith(function () {

            return $("<textarea  />", {
                // "type": "text",
                "name": "body",
                'value': $(pre).text(),
                'class': 'edit-input focus:outline-none focus:ring focus:border-blue-300 shadow-inner bg-white w-full rounded-md  text-grey-darkest flex-1 p-2 mt-4 bg-transparent',
            })
        })

        $(".edit-input").on("keyup", function (e) {
            if (e.target.value.length) {

                $(".btn-body-edit").prop("disabled", false)
            } else {

                $(".btn-body-edit").prop("disabled", true)
            }
        })

        $(".btn-body-edit").on("click", async function () {

            const {data, status} = await axios.patch(`/model/update/${commentId}`, {
                postId,
                editBody: `${author[0].outerHTML} ${$(".edit-input").val()}`,
                namespace
            })

            if (status == 200) {
                $(".cnt-reply-list").html($(data).find(".reply-list")) //reload post

                $(".dropdown").removeClass("hidden");
                $(".dropdown-box__content").removeClass("hidden");
                feather.replace()
            }
        })

        $(".btn-body-close").on("click", function (e) {
            $(".edit-input").replaceWith(pre);
            $(".cnt-btn-comment").remove();
            $(".dropdown").removeClass("hidden");
            $(".dropdown-box__content").removeClass("hidden");
        })
    })
}

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

    $(document).on("click", ".js-delete-comment", async function (e) {
        e.preventDefault();
        const thisContainer = $(`.comment-${$(this).data("class-comment")}`)
        const id = thisContainer.data('thread-id')
        const modelInfo = $(".hidden-post").data("model-info");
        try {
            const {data, status, comment} = await axios.post(`/model/delete`, {
                modelInfo,
                id
            })

            if (!data.comment) {
                $(".text-reply-comment").text("Έναρξη συζήτησης")
            }

            if (status == 200) {
                $(".cnt-reply-list").html($(data.view).find(".reply-list")) //reload post

                feather.replace()
                $(".dropdown-box").hide();
            }


        } catch (e) {
            console.log(e)
        }
    })

}

const onLikebtn = () => {
    $(".cnt-reply-list").on("click", ".btn-reply-like", async function () {
        try {
            const {
                data,
                status
            } = await axios.patch(`/discussion/like-comment/${this.dataset.commentId}`)

            if (status == 200) {
                if (data) {
                    this.classList.add("text-red-700")

                    this.firstElementChild.innerHTML.trim().length == 0 ?
                        this.firstElementChild.innerHTML = parseInt(1) :
                        this.firstElementChild.innerHTML = parseInt(this.firstElementChild.innerHTML) + 1
                } else {
                    this.classList.remove("text-red-700")
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

const onDeletePhoto = () => {
    $(".cnt-reply-list").on("click", ".js-delete-comments-photo", async function () {

        const commentId = $(this).closest(".main-post").data("comment-id")
        const imageId = $(this).prev().data("image-id")
        $(this).parent().removeAttr("href data-lightbox")

        try {
            const {status, data} = await axios.post(`/model/delete/image/${imageId}`, {
                imageId, commentId
            })

            if (status == 200) {
                if (data < 1) {
                    $(this).closest(".border-t").remove();
                }
                $(this).prev().remove();
                $(this).remove();

            }
        } catch (e) {
            console.log(e)
        }

    })
}

const onChangeReplyButton = () => {
    if ($(".main-post").attr("data-count")) {
        $(".text-reply-comment").text("Νέο μήνυμα")
    } else {

        $(".text-reply-comment").text("Έναρξη συζήτησης")
    }
}

const onInitEventHandler = () => {
    onDeleteComment();
    onLikebtn();
    onFirstReplayBtnEvent()
    onCommentReplayBtnEvent()
    onSubCommentReplayBtnEvent();
    bestAnswer();
    onChangeReplyButton();
    onEditComment()
    onDeletePhoto()
}

onInitEventHandler();
