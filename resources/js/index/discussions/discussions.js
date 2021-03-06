//pagination event
import 'tippy.js/dist/tippy.css'; // optional for styling
import Swal from "sweetalert2";
import feather from "feather-icons";

$(document).ready(function () {
    feather.replace()
});
$(document).on("click", ".pagination a", async function (e) {
    e.preventDefault();
    const href = this.href;


    let option = $(".filter-sidebar")[0].options[$(".filter-sidebar")[0].selectedIndex].value

    const {data, status} = await axios.get(href, {
        params: {
            option
        }, headers: {
            'Access-Control-Allow-Origin': '*',
        },

    })
    if (status == 200) {

        $(".cnt-threads-main-list").html($(data).find(".threads-main-list"))
        onHideBody()
    }
})
$(".first-thread").hide();
const eventTopBar = () => {
    $(".discussions-right").on("change", ".filter-sidebar", async function () {

        // let course = $(".filter-course")[0].options[$(".filter-course")[0].selectedIndex].value
        let option = $(".filter-sidebar").find(":selected").val()
        // console.log($(".filter-sidebar").find(":selected").text())

        let filterName = $(".active-thread").attr('id').replace("filter-", "")
        filterName = filterName == "all-threads" ? "" : filterName;
        const {data, status} = await axios.get(`/discussion/${filterName}`, {
            params: {
                option,
            }
        })

        if (status == 200) {
            $(".cnt-threads-main-list").html($(data).find(".threads-main-list"))
            onHideBody()

        }

    })

//todo den doulevi
    $(".discussions-right").on("change", ".filter-course", async function () {

        let course = $(".filter-course")[0].options[$(".filter-course")[0].selectedIndex].value
        let option = $(".filter-sidebar")[0].options[$(".filter-sidebar")[0].selectedIndex].value

        const {data, status} = await axios.get("/discussion/change/filter-course", {
            params: {
                option,
                course
            }
        })

        if (status == 200) {
            $(".cnt-threads-main-list").html($(data).find(".threads-main-list"))
            onHideBody()
        }
    })

// filter show body
    $(".discussions-right").on("click", ".js-show-body", function () {
        onShowBody()
        $(".js-post-body").each((idx, el) => {
            el.classList.remove("d-none")
        });
    })
    $(".discussions-right").on("click", ".js-hidden-body", function () {
        onHideBody()

        $(".js-post-body").each((idx, el) => {
            el.classList.add("d-none")
        });
    })
}
eventTopBar();

// Evenet listener show body
const onHideBody = () => {
    $(".js-hidden-body")[0].classList.add("js-body-active")
    $(".js-show-body")[0].classList.remove("js-body-active")
}
const onShowBody = () => {
    $(".js-show-body")[0].classList.add("js-body-active")
    $(".js-hidden-body")[0].classList.remove("js-body-active")
}
// Evenet change first button
const onChangeFirstButtonNew = () => {
    let firstBtn = $(".first-thread")

    firstBtn[0].innerHTML = `ΑΠΑΝΤΗΣΗ`
    firstBtn[0].dataset.target = "#new-reply"
    firstBtn[0].classList.add("first-thread-replay")
    firstBtn[0].classList.remove("first-thread")
    onFirstReplayBtnEvent();
}
const onChangeFirstButtonReplay = () => {
    if ($(".first-thread-replay").length) {

        let firstBtn = $(".first-thread-replay")
        firstBtn[0].innerHTML = `NEO POST`
        firstBtn[0].dataset.target = "#new-threads"
        firstBtn[0].classList.remove("first-thread-replay")
        firstBtn[0].classList.add("first-thread")
        firstBtn[0].disabled = false;
//new na ta tsekarw!
        firstBtn[0].classList.remove("bg-danger")
        $(".ul-thread").find(".first-thread").unbind('mouseover').unbind('mouseout');

    }
}

//update main page reload
const axiosUpdateMain = (that, data) => {
    $(".ul-thread .bg-thread").removeClass("active-thread")
    $(that).addClass("active-thread")
    $(".discussions-right").html($(data).find(".discussions-right> *"))
    onHideBody()
    onChangeFirstButtonReplay()
    $(".first-thread").hide();
}

// submit create form
$(".js-form-create").on("click", async function (e) {
    e.preventDefault()
    let title = $('input#post-title').val()
    let course = $('#post-course').val()
    this.disabled = true


    if (!title) {
        if (!$(".validate-form-post-body").length) {
            $('#new-threads').modal('show');
            $("<p class='text-danger mt-2 validate-form-post-body'>*Συμπληρώστε όλα τα παιδιά</p>").insertAfter("#post-body");

        }
        return
    }

    try {
        const {data, status} = await axios.post("/discussion/post/store-thread", {
            title,
            course
        })

        if (status == 200) {
            $(".discussions-right").html($(data).find(".discussions-right> *"))
            onHideBody()
            $('#new-threads').modal('hide')
            $('#form-create-thread')[0].reset()
            this.disabled = false

        }

    } catch (e) {
        console.log(e)
    }
})

// submit reply form
$(".js-form-reply").on("click", async function (e) {
    e.preventDefault()
    let body = $('textarea#reply-body').val()


    if (!body) {
        if (!$(".validate-form-post").length) {
            $('#new-reply').modal('show');
            $("<p class='text-danger mt-2 validate-form-post'>*Tο πεδίο είναι απαραίτητο</p>").insertAfter("#reply-body");

        }
        return
    } else {
        body = `<span class="text-info author-reply">${$(".replay-name").text()}</span> ${body}`


    }
    let postId = this.dataset.post;
    let parentId = this.dataset.parent;
    let namespace = this.dataset.namespace;
    this.disabled = true
    $(".validate-form-post").remove();

    try {
        const {data, status} = await axios.post("/discussion/post/store-reply", {
            postId,
            parentId,
            body,
            namespace
        })

        if (status == 200) {
            $(".cnt-reply-list").html($(data).find(".reply-list")) //reload post
            $(".cnt-top-bar-post").html($(data).find(".top-bar-post")) //reload topbar
            $(".post-scrollbar-cnt").html($(data).find(".post-scrollbar")) //rolad ranger slider
            rangeSlider();
            $('#new-reply').modal('hide')
            $('#form-create-reply')[0].reset()
            this.disabled = false

        }

    } catch (e) {
        console.log(e)
    }

})

// show post
$(document).on("click", '.js-thread-title', async function () {
    let postId = this.closest(".single-thread").dataset.postId
    try {
        // const {data, status} = await axios.patch(`/discussion/watched/${postId}`)
        const {data, status} = await axios.get(`/discussion/${postId}`, {
            params: {
                namespace: this.closest(".single-thread").dataset.namespace,
            }
        })

        if (status === 200) {
            $(".discussions-right").off();
            $(".discussions-right").html(data)
            $(".first-thread").show();

            onChangeFirstButtonNew()
            onCommentReplayBtnEvent()
            onSubCommentReplayBtnEvent()
            onLikebtn()
            onDeleteComment()
            rangeSlider()
            handlerReply()
            bestAnswer()
            closedPost()
            eventTopBar()
            onEditComment()


        }

    } catch (e) {
        console.log(e)
    }

})

// search
$(document).on("keyup", ".js-search-post", async function (e) {
    let term = e.target.value;

    if (e.keyCode === 13 && term.length >= 3) {
        try {
            const {data, status} = await axios.post("/discussion/search", {
                term
            })
            if (status == 200) {
                $(".discussions-right").html($(data).find(".discussions-right>*"))
                e.target.value = ""
                $('#centermodal').modal('hide')
                onHideBody();
            }
        } catch (e) {
            console.log(e)
        }
    }
})
// Global search
$(document).on("keyup", function (e) {

    if (e.keyCode === 191) {

        if (!$(".js-search-snippet").length)
            $("<span class='js-search-snippet' data-toggle='modal' data-target='#centermodal'></span>")
                .insertBefore('#centermodal');
        $(".js-search-snippet").click();

        $('#centermodal').on('shown.bs.modal', function () {
            $('.css-search-snippet').focus();
        })
    }


})

//replay comment first button
const onFirstReplayBtnEvent = () => {

    $(document).on("click", ".first-thread-replay", function () {

        let postId = $(".main-post")[0].dataset.postId;
        let parentId = 0;
        let namespace = $(".main-post")[0].dataset.namespace;

        $("#new-reply").find(".replay-name").text("");
        $(".js-form-reply")[0].dataset.post = postId
        $(".js-form-reply")[0].dataset.parent = parentId
        $(".js-form-reply")[0].dataset.namespace = namespace

    })

}
//replay comment
const onCommentReplayBtnEvent = () => {
    $(".discussions-right").on("click", ".js-comment-reply", function () {
        let postId = $(".main-post")[0].dataset.postId;
        let namespace = $(".main-post")[0].dataset.namespace;

        let parentId = this.closest(".main-post").dataset.commentId;
        let author = $(this).closest(".main-post").find(".author-post-name").text()

        $("#new-reply").find(".replay-name").text(`@${author}`);
        $(".js-form-reply")[0].dataset.post = postId
        $(".js-form-reply")[0].dataset.namespace = namespace
        $(".js-form-reply")[0].dataset.parent = parentId
    })
}
//replay subcomment
const onSubCommentReplayBtnEvent = () => {
    $(".discussions-right").on("click", ".js-sub-comment-reply", function () {
        let postId = $(".main-post")[0].dataset.postId;
        let parentId = this.closest(".main-post").dataset.commentId;
        let author = $(this).closest(".main-post").find(".author-post-name").text()

        $("#new-reply").find(".replay-name").text(`@${author}`);
        $(".js-form-reply")[0].dataset.post = postId
        $(".js-form-reply")[0].dataset.parent = parentId
    })
}


//likes system comment
const onLikebtn = () => {
    $(".discussions-right").on("click", ".btn-reply-like", async function () {
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
//delete comment
const onDeleteComment = () => {
    $(".discussions-right").on("click", ".js-delete-comment", async function () {
        const id = this.closest(".main-post").dataset.threadId
        const postId = $(".main-post")[0].dataset.postId;
        const namespace = $(".main-post")[0].dataset.namespace
        try {
            const {data, status} = await axios.delete(`/discussion/delete/${id}`, {
                params: {
                    postId,
                    namespace
                }
            })

            if (status == 200) {
                $(".cnt-reply-list").html($(data).find(".reply-list")) //reload post
                $(".cnt-top-bar-post").html($(data).find(".top-bar-post")) //reload topbar
                $(".post-scrollbar-cnt").html($(data).find(".post-scrollbar")) //rolad ranger slider
                rangeSlider();

            }

        } catch (e) {
            console.log(e)
        }
    })

}
//edit comment
const onEditComment = () => {
    $(".discussions-right").on("click", ".js-edit-comment", function (e) {
        e.preventDefault()
        $(".js-edit-comment").prop("disabled", true)
        const thisContainer = $(this).closest(".main-post");
        const commentId = this.closest(".main-post").dataset.threadId
        const postId = $(".main-post").data("post-id")
        const namespace = $(".main-post").data("namespace");
        let author = thisContainer.find(".author-reply")
        const pre = thisContainer.find("pre");
        thisContainer.find(".cnt-body-comment").append(`
             <div class="btn-group cnt-btn-comment my-3 space-x-3" role="group" >
                 <button class="px-2 py-1 rounded-lg text-black bg-gray-300 btn-body-close">Close</button>
                 <button class="px-3 py-1 rounded-lg bg-blue-300 text-black btn-body-edit">Edit</button>
            </div>`)
        pre.replaceWith(function () {
            thisContainer.find($(".author-reply").remove());
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
            const {data, status} = await axios.patch(`/discussion/update/${commentId}`, {
                postId,
                editBody: `${$(".edit-input").val()}`,
                namespace
            })


            if (status == 200) {
                $(".cnt-reply-list").html($(data).find(".reply-list")) //reload post
                $(".cnt-top-bar-post").html($(data).find(".top-bar-post")) //reload topbar
                $(".post-scrollbar-cnt").html($(data).find(".post-scrollbar")) //rolad ranger slider
                rangeSlider();
            }
        })

        $(".btn-body-close").on("click", function (e) {
            $(".edit-input").replaceWith(pre);
            // thisContainer.find("pre").prepend(`${author[0].outerHTML}`)
            $(".cnt-btn-comment").remove();
            $(".js-edit-comment").prop("disabled", false)
        })
    })
}
//ranger system
const rangeSlider = () => {

    let reply = $(".main-reply").map((idx, el) => {
        return typeof el.id == "undefined" ? "post-1" : el.id
    })


    $(".js-range-slider").ionRangeSlider({
        values: reply,
        skin: "round"
    });

    if ($(".irs-grid-text").text() == 'undefined') {
        $(".irs-grid-text").text("reply-1")
    }

    $(".js-range-slider").on("change", function () {

        var topOfElement = document.querySelector(`#${this.value}`).offsetTop - 100;
        window.scroll({top: topOfElement, behavior: "smooth"});


    })

    $(".original-post").on("click", function () {

        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });

    })

    $(".new-post").on("click", function () {

        $('html,body').animate({scrollTop: 9999}, 'slow');
    })


}
//show hide subcoomment
const handlerReply = () => {

    $(".discussions-right").on("click", ".js-show-body", function () {
        onShowBody()
        $(".single-post-show").addClass("d-none")

        $(".js-reply-body").each((idx, el) => {
            el.classList.remove("d-none")
            el.classList.add("d-flex")
        });
    })

    $(".discussions-right").on("click", ".js-hidden-body", function () {
        onHideBody()
        $(".single-post-show").removeClass("d-none")
        $(".single-post-show").children('i').css('color', '#c3c3c3')

        $(".js-reply-body").each((idx, el) => {
            el.classList.add("d-none")
            el.classList.remove("d-flex")
        });
    })


    $(".discussions-right").on("click", ".single-post-show", function () {
        let commentId = this.closest(".main-post").dataset.commentId
        let element = $(`.js-reply-body[data-comment-id=${commentId}]`)


        if (element.hasClass("d-none")) {
            element.removeClass("d-none")
            element.addClass("d-flex")
            this.children[0].style.color = '#676767'
        } else {
            element.addClass("d-none")
            element.removeClass("d-flex")
            this.children[0].style.color = '#c3c3c3'


        }


    })


}
//handler best answer
const bestAnswer = () => {
    $(".discussions-right").on("click", ".js-best-answer", async function () {
        // $(".badge-best").addClass("d-none")
        // $(this).closest(".main-post").find(".badge-best").removeClass("d-none");


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
        let postId = $(".main-post")[0].dataset.postId;

        try {

            const {data, status} = await axios.patch(`/discussion/best/${commentId}`, {
                postId
            })

            if (status == 200) {

            }

        } catch (e) {
            console.log(e)
        }

    })


}

//handler closes post
const closedPost = () => {
    styleClosedPost()

    $(".discussions-right").on("click", ".js-post-closed", async function () {
        let postId = $(".main-post")[0].dataset.postId;


        try {
            const {status} = await axios.patch(`/discussion/closed/${postId}`)

            if (status == 200) {
                $(this).toggleClass("badge-danger")
                $(this).toggleClass("badge-info")
                $(this).siblings("a").toggleClass("d-none")
                $(".js-comment-reply").toggleClass("d-none")
                $(".js-sub-comment-reply").toggleClass("d-none")
                $(".discussions-right").find(".first-thread-replay").toggleClass("d-none")
                $(".first-thread-replay").toggleClass("bg-danger cursor-not-allowed");
                styleClosedPost()
            }

        } catch (e) {

        }


    })
}

//style closes post
const styleClosedPost = () => {


    if ($(".js-post-closed").hasClass("badge-danger") || !$(".badge-danger").hasClass("d-none")) {
        $(".ul-thread").find(".first-thread-replay").text("CLOSED").addClass("bg-danger").prop('disabled', true)

        $(".ul-thread").find(".first-thread-replay").mouseover(function () {
            $(this).css("cursor", "not-allowed");
        })
        $(".ul-thread").find(".first-thread-replay").mouseout(function () {
            $(this).css("cursor", "pointer");
        })

    } else {
        $(".ul-thread").find(".first-thread-replay").text("ΑΠΑΝΤΗΣΗ").removeClass("bg-danger").prop('disabled', false)

        $(".ul-thread").find(".first-thread-replay").unbind('mouseover').unbind('mouseout');

    }
}
//style collapsed
const styleCollapse = () => {
    if (!$('#accordionExample').children().length) {
        $(".show-task").hide()
    }
    $(".dashboard-box").on("click", ".headline", function () {
        if (!$(this).closest(".card").find(".collapse").hasClass("show")) {
            $(".card-header").removeClass("border-left-card")
            $(this).closest(".card-header").addClass("border-left-card")

        } else {
            $(".card-header").removeClass("border-left-card")
            $(this).closest(".card-header").removeClass("border-left-card")
        }
    })
}
//send task
const sendTask = () => {

    validationUploadTest()

    $(".discussions-right").on("click", ".js-send-task", async function (e) {
        if (!$("#file-target").children().length && $('#editor-task').val().length == 11) {
            if (!$(".alert-body").length) {
                $("<p class='alert-body p-2 bg-transparent text-danger'>* Eισάγετε εικόνα η κείμενο στο πεδίο</p>").insertAfter(".redactor-box");
            }
            return;
        }
        $(".alert-body").remove();
        e.preventDefault()
        $(".js-send-task").prop('disabled', true);
        $(this).find(".spinner-border").removeClass("d-none");

        const {data, status} = await axios.post("/discussion/task/send", {
            "subject": $("#subject-task").val(),
            "curator": $("#curator-task").val(),
            "body": $("#editor-task").val(),
            "attachment": $("#attachment-task").val(),
            "course": $("#curator-task option:selected").text()

        })
        if (status == 200) {

            let dataAttr = $("#curator-task option:selected").text();
            let attacmentVal = $("#attachment-task").val()
            $(".discussions-right").html($(data))
            toastAlert("success", "Επιτυχής αποστολή")
            if (attacmentVal) {
                $(".show-task").addClass("active")
                $("#upload-task-content").removeClass("active show")
                $("#show-task-content").addClass("active show")
                $(".upload-task").removeClass("active")

                $(`#collapse-${slugify(dataAttr)}`).addClass("show").prev().addClass("border-left-card")

                $("html, body").animate({
                    scrollTop: $(`#collapse-${slugify(dataAttr)} .dashboard-box-list .dashboard-box-li:last-child`).position().top
                }, 'slow');

            }

            styleCollapse();
            validationUploadTest()
            $(this).find(".spinner-border").addClass("d-none");


        }

    });
}

const removeTask = () => {
    $(".discussions-right").on("click", ".js-remove-task", async function (e) {
        e.preventDefault();
        const taskId = $(this).closest(".dashboard-box-li").data("task-id")
        const collapseId = $(this).closest("[data-parent]").attr('id');
        const {isConfirmed} = await toastAlertDelete();
        if (isConfirmed) {
            try {
                const {data, status} = await axios.delete(`/discussion/delete-task/${taskId}`)
                if (status == 200) {
                    $(".discussions-right").html($(data))
                    validationUploadTest();
                    iziToast.show({
                        class: "rounded-lg",
                        timeout: 4000,
                        zindex: 99999,
                        // title: `${this.getAcceptedFiles().length > 1 ? "εργασίες ανέβηκαν" : "εργασία ανέβηκε"} `,
                        position: 'topRight',
                        theme: "dark",
                        iconUrl: "/theme/images/refresh.svg",
                        message: `${name} ${last} ενημερώθηκε!`

                    });
                    if ($('#accordionExample').children().length) {
                        $("#show-task-content").addClass("active");
                        $("#upload-task-content").removeClass("active");
                        $(".show-task").addClass("active");
                        $(".upload-task").removeClass("active");

                        if ($(`#${collapseId}`).children().length) {
                            $(`#${collapseId}`).addClass("show").prev().addClass("border-left-card");
                        }
                    } else {
                        $(".show-task").hide();
                    }
                }
            } catch (e) {
                console.log(e)
            }
        }
    });
}

const onCompletedTask = () => {
    $(".discussions-right").off();
    $(".discussions-right").on("click", ".js-complete-task", async function () {
        const taskId = $(this).closest(".dashboard-box-li").data("task-id")
        const {data, status} = await axios.patch(`/discussion/complete-task/${taskId}`)

        if (status === 200) {
            if (data.completed_at) {
                $(this).closest(".dashboard-box-li").find(".dashboard-status-button").removeClass("red").addClass("green").html(`Ελέγχθηκε ${getDate()}`)
                $(this).closest(".dashboard-box-li").find(".js-complete-task ").removeClass("btn-outline-custom-primary").addClass("btn-outline-danger")
                $(this).text("Δεν ελέγχθηκε");
                toastAlert("success", "H εργασία ελέγχθηκε")
            } else {
                $(this).closest(".dashboard-box-li").find(".dashboard-status-button").removeClass("green").addClass("red").html(`Αναμονή..`)
                $(this).closest(".dashboard-box-li").find(".js-complete-task ").removeClass("btn-outline-danger").addClass("btn-outline-custom-primary")
                $(this).text("Ελέγχθηκε");
                toastAlert("success", "Αφαίρεση ελέγχου")
            }
            // let completedTask = $(this).closest(".dashboard-box-list").find(".green").length;
            //
            //
            // $(this).closest(".card").find(".js-num-task").text(completedTask)

        }

    })
}

//sent question
const onSendQuestion = () => {
    $(".discussions-right").on("click", ".sent-question", async function () {
            const thisBtn = $(this)
            if (thisBtn.data("exist-post")) {
                thisBtn.removeAttr("data-target")
                // $(".question-task").trigger("click");
                let postId = thisBtn.data("post")
                try {
                    // const {data, status} = await axios.patch(`/discussion/watched/${postId}`)
                    const {data, status} = await axios.get(`/discussion/${postId}`)

                    if (status === 200) {
                        $(".discussions-right").off();
                        $(".discussions-right").html(data)
                        $(".first-thread").show();
                        onChangeFirstButtonNew()
                        onCommentReplayBtnEvent()
                        onSubCommentReplayBtnEvent()
                        onLikebtn()
                        onDeleteComment()
                        // rangeSlider()
                        handlerReply()
                        bestAnswer()
                        closedPost()
                        eventTopBar()
                        onEditComment()
                        $(".js-range-slider").remove();


                    }

                } catch (e) {
                    console.log(e)
                }


                return;
            }
            const id = thisBtn.data("attachment").id
            $("#new-post-task").off();
            $("#new-post-task").on("click", ".js-question-btn", async function () {
                const {status, data} = await axios.post("discussion/question/post", {
                    id
                })

                const postId = data;
                if (status == 200) {
                    $('#new-post-task').modal('hide')
                    $(".modal-backdrop").addClass("d-none");
                    try {
                        const {data, status} = await axios.get(`/discussion/${postId}`)

                        if (status === 200) {
                            $(".discussions-right").off();
                            $(".discussions-right").html(data)
                            $(".first-thread").show();
                            onChangeFirstButtonNew()
                            onCommentReplayBtnEvent()
                            onSubCommentReplayBtnEvent()
                            onLikebtn()
                            onDeleteComment()
                            // rangeSlider()
                            handlerReply()
                            bestAnswer()
                            closedPost()
                            eventTopBar()
                            onEditComment()
                            $(".js-range-slider").remove();


                        }

                    } catch (e) {
                        console.log(e)
                    }
                }

            })


        }
    )
}

const validationUploadTest = () => {
    $('#subject-task').keyup(function () {
        if ($("#subject-task").val().length) {
            $(".js-send-task").prop('disabled', false);

        } else {
            $(".js-send-task").prop('disabled', true);
        }
    });
}

function getDate() {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    var minute = today.getMinutes();
    var hour = today.getHours();

    return `<span class="text-muted font-12">(${dd}/${mm}/${yyyy}  ${hour}:${minute})</span>`
}

function slugify(string) {
    return string
        .toString()
        .trim()
        .toLowerCase()
        .replace(/\s+/g, "-")
        .replace(/[^\w\-]+/g, "")
        .replace(/\-\-+/g, "-")
        .replace(/^-+/, "")
        .replace(/-+$/, "");
}

function toastAlertDelete(text, icon = "warning") {
    return Swal.fire({
        title: 'Είστε σίγουρος/η;',
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: '#ff5b5b',
        confirmButtonText: 'Ναί, διαγραφή!',
        cancelButtonText: 'Άκυρο'
    });
}

function toastAlert(icon, message) {
    Swal.fire({
        toast: 'true',
        position: 'top-end',
        icon: icon,
        title: message,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
}

const onAnnouncement = () => {
    let users;
    let courses;


    $("#user-task").select2({
        placeholder: "Όλοι οι μαθητές",
        width: "resolve",
        tags: true,
        tokenSeparators: [',', ' '],
        ajax: {
            url: "/discussion/users/json-search",
            delay: 1000,
            dataType: "json",
            data: function (params) {
                return {
                    search: params.term,
                    page: params.page || 1
                }
            }
        }
    }).on("select2:select", function (e) {
        $(document).off("click", ".select2-selection__choice")
        $(document).on("click", ".select2-selection__choice", function () {
            if ($(".select2-selection__rendered").children().length > 2) {
                $("#curator-task").prop("disabled", true);
            } else {
                $("#curator-task").prop("disabled", false);
            }
        })
        users = $(e.currentTarget).val();
        $("#curator-task").attr('disabled', 'disabled');

    });

    $("#curator-task").select2({
        placeholder: "Όλα τα μαθήματα",
        width: "resolve",
        ajax: {
            url: "/discussion/courses/json-search",
            delay: 1000,
            dataType: "json",
            data: function (params) {
                return {
                    search: params.term,
                    page: params.page || 1
                }
            }
        }
    }).on("select2:select", function (e) {
        courses = $(e.currentTarget).val();

        if ($(e.currentTarget).val().length > 1) {
            $("#user-task").prop("disabled", true);
        } else {

            $("#user-task").prop("disabled", false);
        }
    });


    $(".js-send-announcement").on("click", async function () {
        $(".spinner-border").removeClass("hidden");
        $(this).prop("disabled", true);
        try {
            const {status, data} = await axios.post("/discussion/upload-announcement", {
                users,
                courses,
                body: $("#editor-task").val(),
                title: $("#announcement-title").val()
            })
            if (status == 200) {
                $(".discussions-right").html($(data))
                onAnnouncement();

                // $(".show-announcement").trigger("click");


            }
        } catch (e) {
            console.log(e)
        }


    })
}

//all thread sidebar
$(".discussions-left").on("click", "#filter-all-threads", async function () {
    try {
        const {data, status} = await axios.get("/discussion")
        if (status == 200) {
            axiosUpdateMain($(this), data)
        }


    } catch (e) {
        console.log(e)
    }
})
//my question sidebar
$(".discussions-left").on("click", "#filter-my-question", async function () {

    try {
        const {data, status} = await axios.get("/discussion/my-question")

        if (status == 200) {
            axiosUpdateMain($(this), data)
        }


    } catch (e) {
        console.log(e)
    }
})
//my simetoxi se post
$(".discussions-left").on("click", "#filter-participation", async function () {

    try {
        const {data, status} = await axios.get("/discussion/participation")

        if (status == 200) {
            axiosUpdateMain($(this), data)
        }


    } catch (e) {
        console.log(e)
    }
})
//my kaliteri apantisi
$(".discussions-left").on("click", "#filter-best-answer", async function () {

    try {
        const {data, status} = await axios.get("/discussion/best-answer")

        if (status == 200) {
            axiosUpdateMain($(this), data)
        }


    } catch (e) {
        console.log(e)
    }
})
//my popular this wwek
$(".discussions-left").on("click", "#filter-popular-week", async function () {

    try {
        const {data, status} = await axios.get("/discussion/popular-week")

        if (status == 200) {
            axiosUpdateMain($(this), data)
            $(".filter-thread").children().first().css('visibility', 'hidden');
        }


    } catch (e) {
        console.log(e)
    }
})
//my popular all time
$(".discussions-left").on("click", "#filter-popular-allTime", async function () {

    try {
        const {data, status} = await axios.get("/discussion/popular-allTime")

        if (status == 200) {
            axiosUpdateMain($(this), data)
            $(".filter-thread").children().first().css('visibility', 'hidden');
        }


    } catch (e) {
        console.log(e)
    }
})
//my post pou einai closed
$(".discussions-left").on("click", "#filter-isClosed", async function () {

    try {
        const {data, status} = await axios.get("/discussion/isClosed")

        if (status == 200) {
            axiosUpdateMain($(this), data)
        }


    } catch (e) {
        console.log(e)
    }
})
//my xoris apantisi
$(".discussions-left").on("click", "#filter-no-replies", async function () {

    try {
        const {data, status} = await axios.get("/discussion/no-replies")

        if (status == 200) {
            axiosUpdateMain($(this), data)
        }


    } catch (e) {
        console.log(e)
    }
})
//my task
$(".discussions-left").on("click", "#filter-my-task", async function () {

    const roles = ["admin", "super-admin", "instructor"]
    try {
        const {data, status} = await axios.get("/discussion/my-task")
        if (status == 200) {
            $(".discussions-right").html($(data))
            $(".ul-thread .bg-thread").removeClass("active-thread")
            $(this).addClass("active-thread")
            onCompletedTask();
            onSendQuestion()
            styleCollapse();
            removeTask();
            onFirstReplayBtnEvent();
            if (roles.includes($(this).data("role-user"))) {
                if (!$('#accordionExample').children().length) {
                    $(".discussions-right").hide()
                    Swal.fire(
                        'Προσοχή',
                        '<p>Δεν υπάρχουν εργασίες </p>',
                        'info'
                    );

                    const {data, status} = await axios.get("/discussion")
                    if (status == 200) {
                        axiosUpdateMain($("#filter-all-threads"), data)
                        $(".discussions-right").show()

                    }
                }

            } else {

                $(".ul-thread .bg-thread").removeClass("active-thread")
                $(this).addClass("active-thread")
                sendTask();
                styleCollapse();

            }
        }
    } catch (e) {
        console.log(e)
    }
})
//announcment
$(".discussions-left").on("click", "#filter-announcement", async function () {

    try {
        const {data, status} = await axios.get("/discussion/my-announcement")
        if (status == 200) {
            $(".discussions-right").html($(data))
            $(".ul-thread .bg-thread").removeClass("active-thread")
            $(this).addClass("active-thread")
            onCompletedTask();
            onSendQuestion()
            styleCollapse();
            removeTask();
            onFirstReplayBtnEvent();

            onAnnouncement();

            //
            // $(".ul-thread .bg-thread").removeClass("active-thread")
            // $(this).addClass("active-thread")
            // sendTask();
            // styleCollapse();

        }
    } catch (e) {
        console.log(e)
    }
})

// $R("#post-body", {
//     buttons: [
//         'html', 'undo', 'redo', 'format',
//         'bold', 'underline', 'italic', 'deleted',
//         'sup', 'sub', 'lists', 'file', 'link', 'image'
//     ],
//     style: false,
//     plugins: [ 'alignment']h
//     minHeight: '150px',
//     imageResizable: true,
//     imagePosition : {
//         "left": "image-left",
//         "right": "image-right",
//         "center": "image-center text-center"
//     },
//     imageFloatMargin: '20px',
//     imageUpload: "/media/upload-images",
//     callbacks: {
//         upload: {
//             beforeSend: function(xhr)
//             {
//                 xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
//             }
//         }
//     }
// });
let url = window.location.href;
if (url.includes('?')) {
    const filterId = window.location.search.replace("?", "#")

    $(filterId).removeClass("hidden").addClass("active-thread")

    $(filterId).trigger("click");
    setTimeout(function () {
            $(".discussions-right").removeClass("hidden");

        },
        300);
}


$(document).on("click", ".js-task-seen", async function (e) {
    e.preventDefault()

    if (($(this).data("role") == "student")) {
        window.location.href = "/discussion?filter-my-task";
    } else {
        window.location.href = "/dashboard/homeworks"
    }


})