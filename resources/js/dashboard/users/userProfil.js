import utilities from '../main';
import Dropzone from "../../../plugins/dropzone/js/dropzone";
import * as FilePond from 'filepond';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import 'filepond/dist/filepond.min.css';

//! GLOBAL VAR
//!============================================================
const userId = $("#user-name").data("user-id");

const baseUrl = window.location.origin;
const namespace = "App\\Models\\User";
let timer = 0;

//! GLOBAL METHOD AND EVENT LISTENER
//!============================================================
//* feugei
const routeLink = () => {
    $('.js-link').click(function () {
        $('.js-link').unbind();

        let course = this.parentElement.dataset.courseId;


        window.location = `/dashboard/course/${course}`;
    });
}

function sendMailPermission() {
	return Swal.fire({
        title: 'Αποστολή;',
        text: "Θέλετε να στείλετε τον κωδικό του χρήστη στο Email του;",
        icon: "info",
		showCancelButton: true,
		confirmButtonColor: '#536de6',
        confirmButtonText: 'Ναι, αποστολή!',
        cancelButtonText: 'Άκυρο'
    });
}

//! DATATABLES INIT
//!============================================================
const courses = $(".course-materials-list").DataTable({
	searchDelay: "1000",
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
        {
            data: 'publish_at',
            name: "publish_at",
            className: "align-middle text-center cursor-default",
            searchable: false
        },
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
utilities.filterButton('#VersionFilterMaterial', 2, courses, "#DataTables_Table_0_length label")
utilities.filterButton('#statusFilterMaterial', 4, courses, "#DataTables_Table_0_length label")


//!select2
//!============================================================
$("#VersionFilterMaterial").select2({

    minimumResultsForSearch: -1,
});
$(".custom-select").select2({
    minimumResultsForSearch: -1,
});
$("#statusFilterMaterial").select2({});

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
// $(".js-add-image").on("click", function () {
//     $("#cover-image").removeClass('d-none')
//     // $("#delete-cover-btn").removeAttr('hidden')
// });

$(".js-add-image").on("click", utilities.imageHandler);

$("#change-cover-btn").on("click", function () {

    $("#gallery-content")[0].dataset.action = "cover";

    $("#gallery-modal").modal('show');
})






$("#remove-cover-btn").on("click", function() {

	if ( !userId ) {

		let cnt = this.parentElement;

		$("#cover-image").addClass("d-none");
		$("#change-cover-btn").text("Προσθήκη")
		$("#custom-file").val("");

		cnt.classList.remove("d-flex");
		cnt.classList.add("d-none");

		return;
	}

	axios.patch( "/media/remove-cover", {
		namespace,
		id: userId
	})
	.then( res => {

		let cnt = this.parentElement;

		$("#cover-image").addClass("d-none");
		$("#change-cover-btn").text("Προσθήκη")

		cnt.classList.remove("d-flex");
		cnt.classList.add("d-none");

	})
	.catch( err => {
		console.log(err);
	})
});







// $("#delete-cover-btn").on("click", function () {

//     $("#cover-image").addClass('d-none')
//     $("#delete-cover-btn").attr('hidden', true)
// })


let dropzone = document.getElementById("file-pond");

FilePond.registerPlugin(FilePondPluginFileValidateType);
const pond = FilePond.create(dropzone, {
    name: 'file[]',
    server: {
        url: baseUrl,
        process: {
            url: '/media/upload-images',

            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
            },
            onload: function (data) {
				utilities.paginationRequest( 1, "" );
            }
        },
	},
	onprocessfile: function (error, data) {
		
		if ( pond.status === 2 ) {

			clearTimeout(timer);
			let files = pond.getFiles();

			for (let i = 0; i < files.length; i++ ) {

				if ( files[i].status === 5 ) {
					timer = setTimeout(function() {
						pond.removeFile(files[i]);
					}, ( i + 1 ) * 500);
				}

			}
		}

	},
    onprocessfiles: function (data) {

        let files = pond.getFiles();

		for (let i = 0; i < files.length; i++ ) {

			timer = setTimeout(function() {
				pond.removeFile(files[i]);
				
			}, ( i + 1 ) * 500);
			
		}

    },
    allowMultiple: true,
    allowRemove: false,
    allowRevert: false,
	className: "js-filepond-file-dragging",
    acceptedFileTypes: ['image/png', 'image/jpeg'],

});

//! REDACTOR
//!============================================================

$R("#profil", {
    buttons: [
        'html', 'format',
        'bold', 'underline', 'italic',
        'lists', 'link',
    ],
    buttonsAddBefore: {before: 'image', buttons: ['mediaLibrary']},
    style: false,
    plugins: ["mediaLibrary", 'alignment'],
    minHeight: '150px',
    imageResizable: true,
    imagePosition: {
        "left": "image-left",
        "right": "image-right",
        "center": "image-center text-center"
    },
    imageFloatMargin: '20px',
    imageUpload: "/media/upload-images",
    callbacks: {
        upload: {
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            }
        }
    }
});

const dropArea = document.getElementsByClassName("js-filepond-file-dragging");

for ( let i = 0; i < dropArea.length; i++ ) {

	dropArea[i].addEventListener("dragenter", function(event) {
		const draggingArea = this.getElementsByClassName("filepond--drop-label")[0];
		const label = draggingArea.querySelector("label");
		const span = label.querySelector("span");

		if (event.dataTransfer.items.length > 0) {
			draggingArea.classList.add("limegreen");
			label.classList.add("text-limegreen");
			span.classList.add("text-decoration-limegreen");
		}
	});

	dropArea[i].addEventListener("dragleave", function(event) {
		const draggingArea = this.getElementsByClassName("filepond--drop-label")[0];
		const label = draggingArea.querySelector("label");
		const span = label.querySelector("span");
		if (event.dataTransfer.items.length > 0) {
			draggingArea.classList.remove("limegreen");
			label.classList.remove("text-limegreen");
			span.classList.remove("text-decoration-limegreen");

		}
	});
}

$("#user-status").on("change", function() {

	axios.patch("/user/changeStatus", {
		'status': this.checked ? 1 : 0,
		'id': this.dataset.userId
	})
	.then ( res => {
		const icon = this.checked ? "success" : "info";
		const message = this.checked ? "Ενεργοποιήθηκε" : "Απενεργοποιήθηκε";

		utilities.toastAlert(icon, message);
	})
	.catch (err => {
		console.log(err);
		utilities.toastAlert('error', "Παρουσιάστηκε κάποιο πρόβλημα")
	})
});

$(".js-send-message").on("click", sendPassword);

async function sendPassword()  {
    try {
		$(this).off("click");

		const {isConfirmed} = await sendMailPermission();
		
		if ( !isConfirmed ) {
			return;
		}
		
		const {status} = await axios.post(`/users-ajax/${userId}/sent-info`);
		
        if (status < 200 && status > 299) {
			throw "failed";
		}

		Swal.fire({
			title: 'Στάλθηκε',
			text: "Ο κωδικός έχει αποσταλεί με επιτυχία!",
			icon: "success",
			confirmButtonColor: '#536de6',
			confirmButtonText: 'Εντάξει!'
		});

    }catch (err){
		console.log(err)

		$(this).on("click", sendPassword);
		utilities.toastAlert("error", "Κάποιο σφάλμα παρουσιάστηκε...")
    }
}










$(".under-development").on("click", function() {
	utilities.toastAlert("info", "Under Development");
})