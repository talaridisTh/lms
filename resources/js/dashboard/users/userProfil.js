import utilities from '../main';
import * as FilePond from 'filepond';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import 'filepond/dist/filepond.min.css';
import Swal from 'sweetalert2';

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

function resetAvatarConfirm() {
	return Swal.fire({
		title: "Είστε σίγουρος/η;",
		text: "Η ενέργεια θα επαναφέρει την προεπιλεγμένη εικόνα.",
		icon: "info",
		showCancelButton: true,
		confirmButtonColor: '#536de6',
        confirmButtonText: 'Ορισμός προεπιλογής',
        cancelButtonText: 'Άκυρο'
	})
}

//! DATATABLES INIT
//!============================================================
const courses = $(".course-materials-list").DataTable({
	searchDelay: "1000",
    processing: true,
    serverSide: true,
    ajax: {
        url: "/users/view-user",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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
    language: utilities.tableLocale,

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
        url: "/user/add-course-modal",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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

    language: utilities.tableLocale,

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
            const {status} = await axios.patch("/user/add-course", {
                "course_id": id,
                "user_id": userId,
            })
            if (status == 200) {
                utilities.resetBulk($("#user-addCourses-bulk-action-btn"), $(".js-user-profile-checkbox"));
                courses.ajax.reload(null, false);
                addCourse.ajax.reload(null, false);

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
            const {value} = await utilities.toastAlertDelete(`H ενέργεια θα αφαιρέσει το course απο τον χρήστη!`)
            if (value) {
                let {status} = await axios.delete("/user/delete", {
                    data: {
                        'course_id': this.dataset.courseId,
                        'user_id': userId
                    }
                })
                if (status == 200) {
                    utilities.toastAlert('info', `Αφαιρέθηκε...`)
                    courses.ajax.reload(null, false);
                    addCourse.ajax.reload(null, false);
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

        let ids = [];

        for (let i = 0; i < checkedBoxes.length; i++) {
            ids.push(checkedBoxes[i].dataset.courseId);
        }
//!!!!! na gini route
        try {
            const {value} = await utilities.toastAlertDelete(`Η ενέργεια θα αφαιρέσει ${ids.length} course απο τον χρήστη`)
            if (value) {
                let {status} = await axios.delete( "", {
                    data: {
                        'course_id': ids,
                        'user_id': userId
                    }

                })
                if (status == 200) {
                    utilities.toastAlert('error', `Αφαιρέθηκαν`)
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
            let {status} = await axios.patch("/user/multiple/add-course", {
                'course_id': ids,
                'user_id': checkedBoxes[0].findParent(3).dataset.userId

            })
            if (status == 200) {
                utilities.toastAlert('success', `${ids.length}  Προστέθηκαν `)
                courses.ajax.reload(null, false);
                addCourse.ajax.reload(null, false);
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

$("#image-search").on("input", utilities.searchHandler);

$(".js-gallery-page-btn").on( 'click', utilities.paginationHandler);

$(".js-add-image").on("click", utilities.imageHandler);

$("#change-cover-btn").on("click", function () {

    $("#gallery-content")[0].dataset.action = "cover";

    $("#gallery-modal").modal('show');
})

$("#reset-avatar").on("click", async function() {

	try {
		const {isConfirmed} = await resetAvatarConfirm();

		if ( !isConfirmed ) return;

		const {status} = await axios.patch(`/users-ajax/${userId}/reset-avatar`);

		if (status > 199 && status < 300) {
			$("#cover-image").attr("src", "/images/avatar-placeholder.png" );
		}

	}
	catch (err) {
		console.log(err);
		utilities.toastAlert("error", "Κάποιο σφάλμα παρουσιάστηκε...");
	}
});

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
		$(this).on("click", successMail);

		const {isConfirmed} = await sendMailPermission();
		
		if ( !isConfirmed ) {
			return;
		}
		
		const {status} = await axios.post(`/users-ajax/${userId}/sent-info`);
		
        if (status < 200 && status > 299) {
			throw "failed";
		}

		successMail();

    }catch (err){
		$(this).off("click");
		$(this).on("click", sendPassword);

		console.log(err)
		utilities.toastAlert("error", "Κάποιο σφάλμα παρουσιάστηκε...")
    }
}

function successMail() {
	Swal.fire({
		title: 'Στάλθηκε',
		text: "Ο κωδικός έχει αποσταλεί με επιτυχία!",
		icon: "success",
		confirmButtonColor: '#536de6',
		confirmButtonText: 'Εντάξει!'
	});
}

$("#show-password").on("click", function() {
	Swal.fire({
		title: "Επιβεβαίωση ενέργειας",
		text: "Παρακαλώ συμπληρώστε το κωδικό εισόδου σας",
		input: "password",
		confirmButtonColor: '#536de6',
		confirmButtonText: 'Επόμενο &rarr;',
		showCancelButton: true,
		cancelButtonText: 'Άκυρο',
		preConfirm: (password) => {
			return axios.post(`/users-ajax/${userId}/show-password`, {
				password: password
			})
			.then( res => {

				return res;
			})
			.catch( err => {

				return err.response;
				
			})
		}
	}).then( res => {
		const {status} = res.value;

		if (status < 200 || status > 299) {
			throw new Error(res.value.data.error);
		}
		
		Swal.fire(
			'Ο κωδικός χρήστη είναι',
  			`${res.value.data.password}`,
  			'info'
		)
	})
	.catch(err => {
		utilities.toastAlert("error", err.message)
		console.log(err);
	})
});

$(".under-development").on("click", function() {
	utilities.toastAlert("info", "Under Development");
});