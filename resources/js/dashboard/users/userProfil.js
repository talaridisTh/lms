import utilities from '../main';
import Dropzone from "../../../plugins/dropzone/js/dropzone";
import * as FilePond from 'filepond';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import 'filepond/dist/filepond.min.css';

//! GLOBAL VAR
//!============================================================
const userId = $(".course-materials-list")[0].dataset.id
const userSlug = $(".course-materials-list")[0].dataset.slug
const baseUrl = window.location.origin;

//! GLOBAL METHOD AND EVENT LISTENER
//!============================================================
const routeLink = () => {
    $('.js-link').click(function () {
        $('.js-link').unbind();

        let course = this.parentElement.dataset.courseId;


        window.location = `/dashboard/course/${course}`;
    });
}

$(".js-link-passwordShow").click(async function () {
    const {value: password} = await Swal.fire({
        title: 'Εισάγετε  password',
        input: 'password',
        inputPlaceholder: 'Εισάγετε password',
        inputAttributes: {
            maxlength: 50,
            autocapitalize: 'off',
            autocorrect: 'off'
        }
    })
    if (password) {
        try {
            const res = await axios.post("/user/show-password", {
                password
            })
            if (res.data.success) {
                console.log("AS")
                $(".passwordShow")[0].classList.remove("d-none")
                $(".js-link-passwordShow")[0].classList.add("d-none")

            } else {
                utilities.toastAlert('error', "Λαθος password")
            }
        } catch (e) {
            utilities.toastAlert('error', "Λαθος password")
            console.log(e)
        }


    }
})

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

$(".tab-link").on("show.bs.tab", function (event) {

    event.preventDefault();
    Swal.fire(
        'Προσοχή',
        '<p>Θα πρέπει να αποθηκεύσετε </p>για να συνεχίσετε!',
        'info'
    );

})


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
        {data: 'chexbox', name: 'chexbox', orderable: false},
        {data: 'title', name: 'title', className: "js-link cursor-pointer"},
        {data: 'version', name: 'version', className: "js-link cursor-pointer"},
        {data: 'students', name: 'students', className: "js-link cursor-pointer"},
        { data: 'publish_at', name: "publish_at", className: "align-middle text-center cursor-default", searchable: false },
        {data: 'action', name: 'action'},
    ],
    language: config.datatable.language,

    drawCallback: () => {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        $(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
        $(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
        utilities.resetBulk($("#user-profil-bulk-action-btn"), $("#select-all-courses"));
        utilities.resetBulk($("#user-profil-bulk-action-btn"), $(".js-user-checkbox"));

        deleteCourse()
        deleteMultipleCourse()
        routeLink()
        checkeBoxesEventListener()
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
        {data: 'chexbox', orderable: false, width: '35%', name: 'chexbox'},
        {data: 'title', width: '50%', name: 'title'},
        {data: 'action', width: '35%', name: 'action'},

    ],

    language: config.datatable.language,

    drawCallback: () => {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        $(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
        $(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
        utilities.resetBulk($("#user-addCourses-bulk-action-btn"), $("#select-all-courses-profile"));
        utilities.resetBulk($("#user-addCourses-bulk-action-btn"), $(".js-user-profile-checkbox"));
        addCourses()
        checkeBoxesEventListenerSecont()
        updateMultipleCourse()


    }


});


//! GLOBAL FUNCTION Filter
//!============================================================
utilities.filterButton('#VersionFilterMaterial', 2, courses,"#DataTables_Table_0_length label")
utilities.filterButton('#statusFilterMaterial', 4, courses,"#DataTables_Table_0_length label")


//!select2
//!============================================================
$("#VersionFilterMaterial").select2({

    minimumResultsForSearch: -1,
});
$(".custom-select").select2({
    minimumResultsForSearch: -1,
});
$("#statusFilterMaterial").select2({

});

//! BULK ACRTION courses TABLE
//!============================================================
//first datatable

const addCourses = () => {
    $(".js-add-courses").click(async function () {

        const id = this.findParent(2).dataset.courseId
        const userId = this.findParent(2).dataset.userId
        try {
            const {status} = await axios.patch(config.routes.addcoursesDatatable, {
                "course_id": id,
                "user_id": userId,
            })
            if (status == 200) {
                utilities.toastAlert('success', `Προσθέσατε το ένα μάθημα  στον χρήστη `)
                utilities.resetBulk($("#user-addCourses-bulk-action-btn"), $(".js-user-profile-checkbox"));
                courses.ajax.reload();
                addCourse.ajax.reload();

            }

        } catch (e) {
            console.log(e)
            utilities.toastAlert('error', "Παρουσιάστηκε κάποιο πρόβλημα")
        }
    })
}

const deleteCourse = () => {
    $('.js-button-delete').unbind();
    $(".js-button-delete").click(async function () {
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

    minorCheckboxes.change(function () {
        utilities.mainCheckboxSwitcher(mainCheckbox, minorCheckboxes, bulkBtn)
    })

}

$("#select-all-courses").change(function () {
    let minorCheckboxes = $(".js-user-checkbox");
    let bulkBtn = $("#user-profil-bulk-action-btn")[0];


    utilities.minorCheckboxSwitcher(this, minorCheckboxes, bulkBtn);

})


//! BULK ACRTION addCourse TABLE
//!============================================================
const updateMultipleCourse = () => {
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

    minorCheckboxes.change(function () {
        utilities.mainCheckboxSwitcher(mainCheckbox, minorCheckboxes, bulkBtn)
    })

}

$("#select-all-cours-es-profile").change(function () {
    let minorCheckboxes = $(".js-user-profile-checkbox");
    let bulkBtn = $("#user-addCourses-bulk-action-btn")[0];
    console.log(this)

    utilities.minorCheckboxSwitcher(this, minorCheckboxes, bulkBtn);

})

$('#material-modal-shown-btn').click(() => {
    setTimeout(() => {
        addCourse.columns.adjust();
    }, 200)
});

//! DROPOZONE
//!============================================================

$(".js-add-image").on("click", utilities.imageHandler);

$("#change-cover-btn").on("click", function () {

    $("#gallery-content")[0].dataset.action = "cover";

    $("#gallery-modal").modal('show');
})

// Dropzone.autoDiscover = false;
//
// let dropzone = new Dropzone("#cover-dropzone", {
//     thumbnailWidth: 80,
//     thumbnailHeight: 80,
//     previewTemplate: $("#uploadPreviewTemplate").html(),
//     url: `/users/avatar/upload`,
//     params: {userId},
//     maxFilesize: 2,
//     maxFiles: 1,
//     acceptedFiles: 'image/*',
//     headers: {
//         'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
//     },
//     success: function (file, response) {
//         console.log(file)
//         axios.get(`/media/images`, {})
//             .then((res) => {
//                 // console.log(res.data)
//                 let gallery = $("#gallery-content")[0]
//                 gallery.innerHTML = res.data;
//
//
//                 let pagination = gallery.getElementsByClassName("js-gallery-page-btn");
//                 let addBtns = gallery.getElementsByClassName("js-add-image");
//
//                 for ( let i = 0; i < addBtns.length; i++ ) {
//                     addBtns[i].removeEventListener("click", utilities.imageHandler);
//                     addBtns[i].addEventListener("click", utilities.imageHandler);
//                 }
//
//             })
//         this.removeAllFiles();
//         $("#upload-tab-btn").removeClass("active")
//         $("#upload").removeClass("active")
//         $("#media-library-tab-btn").addClass("active")
//         $("#media-library").addClass("show active")
//
//
//
//
//
//     }
//
// })


let dropzone = document.getElementById("file-pond");

FilePond.registerPlugin(FilePondPluginFileValidateType);
const pond = FilePond.create( dropzone );

FilePond.setOptions({
    name: 'file[]',
    data:{
        param: 'test'
    },
    server: {
        url: baseUrl,
        process: {
            url: '/media/upload-images',

            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
            },
            onload: function(data) {

            },


        },

    },
    onprocessfiles: function(data) {

        utilities.paginationRequest( 1, "" );
        $("#upload-tab-btn").removeClass("active")
        $("#upload").removeClass("active")
        $("#media-library-tab-btn").addClass("active")
        $("#media-library").addClass("show active")

    },

    onupdatefiles : function( file){
        utilities.toastAlert("success", `${file.length} εικόνα ανέβηκαν`)

    },



    allowMultiple: true,
    allowRemove: false,
    allowRevert: false,
    acceptedFileTypes: ['image/png', 'image/jpeg'],

});




//! REDACTOR
//!============================================================
$R.add('plugin', 'mediaLibrary', {
    translations: {
        en: {
            "mediaLibrary": "Media Library"
        }
    },
    init: function(app) {
        this.app = app;
        this.lang = app.lang;
        this.toolbar = app.toolbar;
    },
    start: function() {
        var buttonData = {
            title: this.lang.get("mediaLibrary"),
            icon: "<i class='mdi mdi-book-open-page-variant'></i>",
            api: "plugin.mediaLibrary.toggle"
        };

        var $button = this.toolbar.addButton("mediaLibrary", buttonData);
    },
    toggle: function() {
        $('#gallery-content')[0].dataset.action = "summary"
        $('#gallery-modal').modal('show')
    }
});
$R("#summary", {
    buttons: [
        'html', 'undo', 'redo', 'format',
        'bold', 'underline', 'italic', 'deleted',
        'sup', 'sub', 'lists', 'file', 'link', 'image'
    ],
    buttonsAddBefore: { before: 'image', buttons: ['mediaLibrary'] },
    style: false,
    plugins: ["mediaLibrary", 'alignment'],
    minHeight: '150px',
    imageResizable: true,
    imagePosition : {
        "left": "image-left",
        "right": "image-right",
        "center": "image-center text-center"
    },
    imageFloatMargin: '20px',
    imageUpload: "/media/upload-images",
    // imageData: {
    // 	// id: courseId,
    // 	// namespace: "App\\Course"
    // },
    callbacks: {
        upload: {
            beforeSend: function(xhr)
            {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            }
        }
    }
});

