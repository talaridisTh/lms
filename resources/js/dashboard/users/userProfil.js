import utilities from '../main';

//! GLOBAL VAR
//!============================================================
const userId = $(".course-materials-list")[0].dataset.id

//! DATATABLES INIT
//!============================================================
const courses = $(".course-materials-list").DataTable({

    processing: true,
    serverSide: true,
    ajax: {
        url: config.routes.showDatatable,
        headers: config.headers.csrf,
        type: "post",
        data: {
            userId: userId
        }

    },
    columns: [
        {data: 'chexbox', name: 'chexbox'},
        {data: 'title', name: 'title',className: "js-link cursor-pointer"},
        {data: 'students', name: 'students',className: "js-link cursor-pointer"},
        {data: 'action', name: 'action'},
    ],
    language: config.datatable.language,

    drawCallback: () => {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        $(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
        $(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
        deleteCourse()
        deleteMultipleCourse()
        routeLink()
    },

});
// MODAL
const addCourse = $("#datatableAddCourse").DataTable({
    scrollX: !0,
    processing: true,
    serverSide: true,

    ajax: {
        url: config.routes.courseModaDatatable,
        headers: config.headers.csrf,
        type: "post",
        data: {
            userId: userId
        }
    },
    columns: [
        {data: 'title', name: 'title'},
        {data: 'action', name: 'action'},

    ],
    columnDefs: [
        {"width": "5%", "targets": 1},

    ],
    language: config.datatable.language,

    drawCallback: () => {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        $(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
        $(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
        addCourseToUser()
        modalDismiss()
        modalCloseX()


    }


});


//! GLOBAL METHID
//!============================================================

const routeLink = () =>{
    $('.js-link').click(function () {
        $('.js-link').unbind();

        let course = this.parentElement.dataset.courseId;


        window.location = `/dashboard/course/${course}`;
    });
}

$('#alertSumbit').submit(async (e) => {
    e.preventDefault()
    let buttonDelete = $('.js-delete');
    const slug = buttonDelete[0].dataset.slug;

    try {
        const {value} = await utilities.toastAlertDelete("Θέλετε να διαγράψετε αυτόν τον χρήστη ")
        if (value) {
            // const res = await axios.post(`/dashboard/users/${slug}`, {_method: 'DELETE'})
            utilities.toastAlert('success', "Διεγράφη")
            window.location = `http://127.0.0.1:8000/dashboard/users`;
        }

    } catch (e) {
        console.log(e)
        utilities.toastAlert('error', "Παρουσιάστηκε κάποιο πρόβλημα")
    }


});

console.log($("#buttonUser"));





//! METHOD COURS DATATABLE
//!============================================================
const deleteCourse = () => {
    $('.js-button-delete').unbind();
    $(".js-button-delete").click(async function() {
        try {
            const {value} = await utilities.toastAlertDelete(`Θέλετε να αφαιρέσετε το ${this.dataset.courseTitle} απο τον χρήστη `)
            if (value) {
                let {status} = await axios.delete(config.routes.destroyDatatable, {
                    data: {
                        'course_id': this.dataset.courseId,
                        'user_id': userId
                    }
                })
                if (status == 200) {
                    utilities.toastAlert('error', `${this.dataset.courseTitle}  Διεγραφη`)
                    courses.ajax.reload();
                    addCourse.ajax.reload();
                }
            }

        } catch (e) {
            console.log(e)
            utilities.toastAlert('error', "Παρουσιάστηκε κάποιο πρόβλημα")
        }

    })
}

const addCourseToUser = () => {
    $('.js-button').unbind();
    let ids = [];
    let jsButton = $(".js-button").click(function () {
        const parent = this.parentElement.parentElement
        if (parent.dataset.exist) {
            utilities.toastAlert('warning', `${this.dataset.courseTitle}  αφαιρεθηκε`)
            ids = ids.filter(val => val !== this.dataset.courseId);
            this.value = 'Επιλογη'
            this.classList.remove("btn-danger")
            this.classList.add("btn-primary")
            delete parent.dataset.exist
        } else {
            if (!ids.includes(this.dataset.courseId)) {
                ids.push(this.dataset.courseId)
            }
            utilities.toastAlert('success', `${this.dataset.courseTitle} Επιλέχθηκε`)
            this.classList.remove("btn-primary")
            this.classList.add("btn-danger")
            this.value = 'Αφαιρεση'
            parent.dataset.exist = true
        }


    })
    clickModal(ids)
}

const deleteMultipleCourse = () => {
    $('.js-chexbox-delete').unbind();
    $('.js-chexbox-delete').click(async () => {

        let checkedBoxes = $('.js-checkbox:checked');


        let ids = [];

        for (let i = 0; i < checkedBoxes.length; i++) {
            ids.push(checkedBoxes[i].dataset.courseId);
        }

        console.log(checkedBoxes)
        try {
            const {value} = await utilities.toastAlertDelete(`Θέλετε να αφαιρέσετε ${ids.length}  απο τον χρήστη `)
            if (value) {
                let {status} = await axios.delete(config.routes.destroyMultipleCoursesDatatable, {
                    data: {
                        'course_id': ids,
                        'user_id': userId
                    }

                })
                if (status == 200) {
                    utilities.toastAlert('error', `${ids.length}  Διεγραφηκαν`)
                    courses.ajax.reload();
                    addCourse.ajax.reload();
                }
            }

        } catch (e) {
            console.log(e)
            utilities.toastAlert('error', "Παρουσιάστηκε κάποιο πρόβλημα")
        }

        //
        // console.log(res);


    })
}


//! METHOD ADDCOURSE DATATABLE
//!============================================================
const clickModal = (ids) => {
    $(".modal-save").click(async function () {
        $('.modal-save').unbind();
        await utilities.toastAlert('success', `${ids.length} COURSES Προσθεθηκαν`)
        const parent = this.parentElement.parentElement
        let id = [];

        const courseTitle = [...ids];


        try {
            const res = await axios.patch(config.routes.addcoursesDatatable, {
                "course_id": ids,
                "user_id": userId,
            })

            console.log(res)
            courses.ajax.reload();

        } catch (e) {
            console.log(e)
        }

    })

}


const modalDismiss = () => {
    $('.modal-dismiss').unbind();
    $(".modal-dismiss").click(() => {
        addCourse.ajax.reload();
    })
}

const modalCloseX = () => {
    $('.close').unbind();
    $(".close").click(() => {
        addCourse.ajax.reload();
    })
}

$('#material-modal-shown-btn').click(() => {
    setTimeout(() => {
        addCourse.columns.adjust();
    }, 200)
});



