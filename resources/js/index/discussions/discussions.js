//pagination event
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


// filter sidebar
$(".filter-sidebar").on("change", async function () {

    let course = $(".filter-course")[0].options[$(".filter-course")[0].selectedIndex].value
    let option = $(".filter-sidebar")[0].options[$(".filter-sidebar")[0].selectedIndex].value

    const {data, status} = await axios.get("/discussion/change/filter-sidebar", {
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

// filter course
$(".filter-course").on("change", async function () {

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
$(".js-show-body").on("click", function () {
    onShowBody()
    $(".js-post-body").each((idx, el) => {
        el.classList.remove("d-none")
    });
})
$(".js-hidden-body").on("click", function () {
    onHideBody()

    $(".js-post-body").each((idx, el) => {
        el.classList.add("d-none")
    });
})

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
const onChangeFirstButton = () => {
    let firstBtn = $(".first-thread")

    console.log("S")
    firstBtn[0].innerHTML = `Replay`
    firstBtn[0].dataset.target = "#new-reply"
    firstBtn[0].classList.add("first-thread-replay")
    firstBtn[0].classList.remove("first-thread")
    onFirstReplayBtnEvent();
}

// submit create form
$(".js-form-create").on("click", function (e) {
    e.preventDefault()
    $("#form-create-thread").submit();
})
// submit reply form
$(".js-form-reply").on("click", async function (e) {
    e.preventDefault()
    let postId = this.dataset.post;
    let parentId = this.dataset.parent;
    let body = $('textarea#reply-body').val()
    this.disabled = true

    try {
        const {data, status} = await axios.post("/discussion/post/store-reply", {
            postId,
            parentId,
            body
        })

        if (status == 200) {
            $(".cnt-reply-list").html($(data).find(".reply-list"))
            $('#new-reply').modal('hide')
            $('#form-create-reply')[0].reset()
            this.disabled = false

        }

    } catch (e) {
        console.log(e)
    }

})

// show post
$(".cnt-threads-main-list").on("click", '.js-thread-title', async function () {
    let postId = this.closest(".single-thread").dataset.postId
    let watched = $(this).closest(".single-thread").find(".js-thread-watched")[0]
    try {
        // const {data, status} = await axios.patch(`/discussion/watched/${postId}`)
        const {data, status} = await axios.get(`/discussion/${postId}`)

        if (status === 200) {
            $(".discussions-right").html(data)

            onChangeFirstButton()
            onCommentReplayBtnEvent()
            onSubCommentReplayBtnEvent()
            onLikebtn()
            onDeleteComment()
            rangeSlider()
            handlerReply()
            bestAnswer()

        }

    } catch (e) {
        console.log(e)
    }

})

//replay comment first button
const onFirstReplayBtnEvent = () => {
    $(".first-thread-replay").on("click", function () {
        let postId = $(".main-post")[0].dataset.postId;
        let parentId = 0;

        $(".js-form-reply")[0].dataset.post = postId
        $(".js-form-reply")[0].dataset.parent = parentId

    })

}
//replay comment
const onCommentReplayBtnEvent = () => {

    $(".cnt-reply-list").on("click", ".js-comment-reply", function () {
        let postId = $(".main-post")[0].dataset.postId;
        let parentId = this.closest(".main-post").dataset.commentId;

        console.log(parentId)
        $(".js-form-reply")[0].dataset.post = postId
        $(".js-form-reply")[0].dataset.parent = parentId
    })
}
//replay subcomment
const onSubCommentReplayBtnEvent = () => {

    $(".cnt-reply-list").on("click", ".js-sub-comment-reply", function () {
        let postId = $(".main-post")[0].dataset.postId;
        let parentId = this.closest(".main-post").dataset.commentId;


        console.log(parentId)
        $(".js-form-reply")[0].dataset.post = postId
        $(".js-form-reply")[0].dataset.parent = parentId
    })
}

//likes system comment
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
//delete comment
const onDeleteComment = () => {
    $(".cnt-reply-list").on("click", ".js-delete-comment", async function () {
        const id = this.closest(".main-post").dataset.threadId
        const postId = $(".main-post")[0].dataset.postId;
        try {
            const {data, status} = await axios.delete(`/discussion/delete/${id}`, {
                params: {
                    postId
                }
            })

            if (status == 200) {
                $(".cnt-reply-list").html($(data).find(".reply-list"))
            }

        } catch (e) {
            console.log(e)
        }
    })

}

//ranger system
const rangeSlider = () => {


    let reply = $(".main-reply").map((idx, el) => {
        return el.id
    })


    $(".js-range-slider").ionRangeSlider({
        values: reply,
        skin: "round"
    });


    $(".js-range-slider").on("change", function () {

        var topOfElement = document.querySelector(`#${this.value}`).offsetTop - 100;
        window.scroll({top: topOfElement, behavior: "smooth"});

        console.log(this.value)
    })

    $(".original-post").on("click", function () {

        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });

        console.log(this.value)
    })

    $(".new-post").on("click", function () {

        $('html,body').animate({scrollTop: 9999}, 'slow');
    })


}
//show hide subcoomment
const handlerReply = () => {

    $(".js-show-body").on("click", function () {
        onShowBody()
        $(".single-post-show").addClass("d-none")

        $(".js-reply-body").each((idx, el) => {
            el.classList.remove("d-none")
            el.classList.add("d-flex")
        });
    })

    $(".js-hidden-body").on("click", function () {
        onHideBody()
        $(".single-post-show").removeClass("d-none")
        $(".single-post-show").children('i').css('color', '#c3c3c3')

        $(".js-reply-body").each((idx, el) => {
            el.classList.add("d-none")
            el.classList.remove("d-flex")
        });
    })


    $(".cnt-reply-list").on("click", ".single-post-show", function () {
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

const bestAnswer = () => {
    $(".cnt-reply-list").on("click", ".js-best-answer", async function () {
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

        try{

            const {data,status} = await axios.patch(`/discussion/best/${commentId}`,{
                postId
            })

            if (status==200){

            }

        }catch (e){
            console.log(e)
        }

    })



}
