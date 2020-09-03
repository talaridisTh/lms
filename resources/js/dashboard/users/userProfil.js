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
        {data: 'chexbox', name: 'chexbox' ,orderable:false},
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
        // checkeBoxesEventListener()
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
        {data: 'chexbox' ,orderable: false ,width: '35%', name: 'chexbox'},
        {data: 'title' ,width: '50%', name: 'title'},
        {data: 'action',width: '35%', name: 'action'},

    ],

    language: config.datatable.language,

    drawCallback: () => {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        $(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
        $(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
        addCourses()
        checkeBoxesEventListenerSecont()
        updateMultipleCourse()



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
function resetBulk( bulkBtn, checkbox ) {

    bulkBtn.text("Επιλογές  (0)");
    bulkBtn.addClass("btn-secondary");
    bulkBtn.removeClass("btn-warning");
    bulkBtn.prop("disabled", true);
    checkbox.prop("checked", false);
}



const addCourses = ()=>{
    $(".js-add-courses").click( async function (){

        const id = this.findParent(2).dataset.courseId
        const userId = this.findParent(2).dataset.userId
        try {
            const {status} = await axios.patch(config.routes.addcoursesDatatable, {
                "course_id": id,
                "user_id": userId,
            })
            if (status==200){

                courses.ajax.reload();
                addCourse.ajax.reload();

            }

        } catch (e) {
            console.log(e)
        }
    })
}

//! BULK ACRTION FIRST TABLE
//!============================================================
//first datatable
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

const deleteMultipleCourse = () => {
    $('.js-chexbox-delete').unbind();
    $('.js-chexbox-delete').click(async () => {

        let checkedBoxes = $('.js-user-checkbox:checked');

        console.log(checkedBoxes)

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
                    resetBulk( $("#user-profil-bulk-action-btn"), $("#select-all-courses") );


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

function checkeBoxesEventListener() {

    let minorCheckboxes = $(".js-user-checkbox");
    let mainCheckbox = $("#select-all-courses")[0];
    let bulkBtn = $("#user-profil-bulk-action-btn")[0];

    minorCheckboxes.unbind();

    minorCheckboxes.change( function() {
        utilities.mainCheckboxSwitcher( mainCheckbox, minorCheckboxes, bulkBtn)
    })

}

$("#select-all-courses").change( function() {
    let minorCheckboxes = $(".js-user-checkbox");
    let bulkBtn = $("#user-profil-bulk-action-btn")[0];


    utilities.minorCheckboxSwitcher(this, minorCheckboxes, bulkBtn );

})


//! BULK ACRTION SECOND TABLE
//!============================================================


const  updateMultipleCourse = () => {
    $('.js-chexbox-update').unbind();
    $('.js-chexbox-update').click(async () => {

        let checkedBoxes = $('.js-user-profile-checkbox:checked');

        console.log(checkedBoxes)

        let ids = [];

        for (let i = 0; i < checkedBoxes.length; i++) {
            ids.push(checkedBoxes[i].dataset.courseId);
        }


        try {
                let {status} = await axios.patch(config.routes.addCoursesMultipleUsersDatatable, {
                        'course_id': ids,
                        'user_id': checkedBoxes[0].findParent(3).dataset.userId

                })
                if (status == 200) {
                    utilities.toastAlert('success', `${ids.length}  Προστέθηκαν `)
                    courses.ajax.reload();
                    addCourse.ajax.reload();
                    $("#select-all-courses-profile")[0].checked = false
                    resetBulk( $("#user-addCourses-bulk-action-btn"), $("#select-all-courses-profile") );
                }


        } catch (e) {
            console.log(e)
            utilities.toastAlert('error', "Παρουσιάστηκε κάποιο πρόβλημα")
        }





    })
}



function checkeBoxesEventListenerSecont() {

    let minorCheckboxes = $(".js-user-profile-checkbox");
    let mainCheckbox = $("#select-all-courses-profile")[0];
    let bulkBtn = $("#user-addCourses-bulk-action-btn")[0];


    minorCheckboxes.unbind();

    minorCheckboxes.change( function() {
        utilities.mainCheckboxSwitcher( mainCheckbox, minorCheckboxes, bulkBtn)
    })

}


$("#select-all-courses-profile").change( function() {
    let minorCheckboxes = $(".js-user-profile-checkbox");
    let bulkBtn = $("#user-addCourses-bulk-action-btn")[0];
    console.log(this)

    utilities.minorCheckboxSwitcher(this, minorCheckboxes, bulkBtn );

})




$('#material-modal-shown-btn').click(() => {
    setTimeout(() => {
        addCourse.columns.adjust();
    }, 200)
});



