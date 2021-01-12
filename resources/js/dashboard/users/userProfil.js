import utilities from '../main';
import * as FilePond from 'filepond';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import 'filepond/dist/filepond.min.css';
import Swal from 'sweetalert2';
import { getCanVGrowWithinCell } from '@fullcalendar/core';

//! GLOBAL VAR
//!============================================================
const userId = $("#user-name").data("user-id");

const baseUrl = window.location.origin;
const namespace = "App\\Models\\User";
let timer = 0;

//! GLOBAL METHOD AND EVENT LISTENER
//!============================================================

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
	});
}

function removeCoursesConfirm(number) {
	return Swal.fire({
		title: "Είστε σίγουρος/η;",
		text: `Θέλετε να αφαιρέσετε ${number} Course απο τον χρήστη;`,
		icon: "info",
		showCancelButton: true,
		confirmButtonColor: '#536de6',
        confirmButtonText: 'Ναι, αφαίρεση',
        cancelButtonText: 'Άκυρο'
	});
}

function removeCourses(ids) {

	return axios.post(`/users-ajax/${userId}/remove-courses`, {
		ids: ids
	});
}

function createSelect(id) {
	const select = document.createElement("select");
	select.classList.add("select2", "form-control", "select2-multiple");
	select.id = id;

	return select;
}

//! DATATABLES INIT
//!============================================================
const courses = $(".course-materials-list").DataTable({
	order: [4, "desc"],
	searchDelay: "1000",
    processing: true,
	serverSide: true,
	autoWidth: false,
	columnDefs: [
		{ targets: 0, width: "35px"},
		{ targets: [2, 3], width: "145px"}
	],
    ajax: {
        url: "/users/view-user",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "post",
        data: {
            userId: userId
        }
    },
    columns: [
        { data: 'checkbox', name: 'chexbox', className: "align-middle text-center", orderable: false },
        { data: 'title', name: 'title' },
        { data: 'version', name: 'version', className: "align-middle text-center" },
        { data: 'publish', className: "align-middle text-center", orderData: 4,searchable: false },
        { data: 'publish_at', name: "publish_at", visible: false, searchable: false },
    ],
    language: utilities.tableLocale,
    drawCallback: () => {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        utilities.resetBulk($("#multiple-course-remove"), $("#select-all-courses"), "Αφαίρεση (0)");

        $(".js-button-delete").on("click", removeCourseHandler);
        checkeBoxesEventListener()
    },

});
// MODAL
const addCourse = $("#datatableAddCourse").DataTable({
	order: [1, "desc"],
    processing: true,
    serverSide: true,
	columnDefs: [
		{ targets: 0, width: "60px"},
		{ targets: 2, width: "250px"},
		{ targets: 3, width: "145px"}
	],
    ajax: {
        url: "/user/add-course-modal",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "post",
        data: {
            userId: userId
        }
    },
    columns: [
        { data: 'chexbox', name: 'chexbox', className: "align-middle text-center", orderable: false},
		{ data: 'title', name: 'title', className: "align-middle" },
		{ data: "topics", name: "topics", className: "text-wrap align-middle" },
        { data: 'action', name: 'action', className: "align-middle text-center", orderable: false, searchable: false},
    ],
    language: utilities.tableLocale,
    drawCallback: () => {
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		
		utilities.resetAddButton( $("#add-multiple-courses-btn"), $("#select-all-courses-profile") );
		
        addCourses();
        checkeBoxesEventListenerSecont();
    }
});

const homeworksDatatable = $("#homeworks-datatable").DataTable({
	order: [2, "desc"],
	searchDelay: "1000",
	processing: true,
	serverSide: true,
	autoWidth: false,
	columnDefs: [
		{ targets: 1, width: "250px"},
		{ targets: 2, width: "180px"}
	],
	ajax: {
		url: "/users-ajax/homeworks-datatable",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		type: "post",
		data: {
            userId: userId
        }
	},
	columns: [
		{ data: 'subject', name: 'subject', className: "align-middle" },
		{ data: 'course', name: 'course.title', className: "align-middle text-center",},
		{
			data: 'created_at',
			name: 'homeworks.created_at',
			className: "align-middle text-center cursor-default",
			render: function(data) {
				let date = new Date(data);
				let day = date.toLocaleDateString().replace( /[/]/g, "-");
				let hours = `${date.getHours()}`.padStart(2, "0");
				let minutes = `${date.getMinutes()}`.padStart(2, "0");

				let time = `${hours}:${minutes}`;
				return `<p class="mb-0">${day}</p><p class="mb-0">${time}</p>`;
			}
		},
	],
	language: utilities.tableLocale,
	fnInitComplete: function( oSettings, json ) {
		let lenthSelection = $("select[name='homeworks-datatable_length']");
		lenthSelection.addClass("select2");

		lenthSelection.select2({
			minimumResultsForSearch: -1,
		});
	},
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		// $(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
		// $(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
		$(".js-remove-table-classes > thead > tr > th").removeClass("cursor-pointer");

	}
});


//! GLOBAL FUNCTION Filter
//!============================================================
utilities.filterButton('#VersionFilterMaterial', 2, courses, "#DataTables_Table_0_length label");

//!select2
//!============================================================
$("#VersionFilterMaterial").select2({

    minimumResultsForSearch: -1,
});
$(".custom-select").select2({
    minimumResultsForSearch: -1,
});

(function coursesTopicFilter() {
	const lengthCnt = document.getElementById("datatableAddCourse_length");
	const select = createSelect("course-topic-filter");

	lengthCnt.append(select);

	$(select).select2({
		placeholder: "Όλα τα Topics",
		width: "150px",
		ajax: {
			url: "/topics/json-search",
			delay: 1000,
			dataType: "json",
			data: function(params) {
				return {
					search: params.term,
					page: params.page || 1
				}
			}
		}
	})

	$(select).on("change", function() {
		const label = $('#select2-course-topic-filter-container')[0];

		utilities.filterStyle( label, this.value.trim() );
		addCourse.column(2).search( this.value ).draw();
	})
})();

//! BULK ACRTION courses TABLE
//!============================================================
//first datatable

const addCourses = () => {
    $(".js-add-courses").on("click", function () {

		$(".js-add-courses").prop("disabled", true);
		axios.patch(`/users-ajax/${userId}/add-courses`, {
            ids: [this.dataset.courseId]
        })
		.then (function () {
            courses.ajax.reload(null, false);
            addCourse.ajax.reload(null, false);
		})
		.catch (err => {
			$(".js-add-courses").prop("disabled", false);
            console.log(err)
            utilities.toastAlert('error', "Παρουσιάστηκε κάποιο πρόβλημα")
        })
    })
}

async function removeCourseHandler() {
	
	try {
		this.disabled = true;

		const {isConfirmed} = await removeCoursesConfirm(1);

		if ( !isConfirmed ) return;

		console.log(this.dataset.courseId);
		await removeCourses([this.dataset.courseId]);

		courses.ajax.reload(null, false);
		addCourse.ajax.reload(null, false);
	}
	catch(err) {
		this.disabled = false;
		console.log(err);
		utilities.toastAlert("error", "Κάποιο σφάλμα παρουσιάστηκε...")
	}
}

function checkeBoxesEventListener() {

    let minorCheckboxes = $(".js-user-checkbox");
	let mainCheckbox = $("#select-all-courses")[0];
    let bulkBtn = $("#multiple-course-remove")[0];

    minorCheckboxes.on("change", function () {
        utilities.mainCheckboxSwitcher(mainCheckbox, minorCheckboxes, bulkBtn)
    });
}

$("#select-all-courses").change(function () {
    let minorCheckboxes = $(".js-user-checkbox");
    let bulkBtn = $("#multiple-course-remove")[0];

    utilities.minorCheckboxSwitcher(this, minorCheckboxes, bulkBtn);
})


//! BULK ACRTION addCourse TABLE
//!============================================================
$("#add-multiple-courses-btn").on("click", function() {
	const checkboxes = $(".js-user-profile-checkbox:checked");
	const courseIds = [];

	for (let i = 0; i < checkboxes.length; i++) {
		courseIds.push(checkboxes[i].dataset.courseId);
	}

	axios.patch(`/users-ajax/${userId}/add-courses`, {
		ids: courseIds
	})
	.then (function () {
		courses.ajax.reload(null, false);
		addCourse.ajax.reload(null, false);
	})
	.catch (err => {
		console.log(err)
		utilities.toastAlert('error', "Παρουσιάστηκε κάποιο πρόβλημα")
	})

});

function checkeBoxesEventListenerSecont() {

    let minorCheckboxes = $(".js-user-profile-checkbox");
    let mainCheckbox = $("#select-all-courses-profile")[0];
    let bulkBtn = $("#add-multiple-courses-btn")[0];

    minorCheckboxes.change(function () {
        utilities.mainCheckboxSwitcher(mainCheckbox, minorCheckboxes, bulkBtn)
    })

}

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

$("#delete-user-btn").on("click", async function() {

	try {
		const result = await utilities.passwordValidation();

		if ( !result.isConfirmed ) return;
		
		await axios.delete(`/users-ajax/${userId}/destroy`);

		window.location = `/dashboard/users`;
	}
	catch (err) {
		console.log(err);
		utilities.toastAlert("error", "Κάποιο σφάλμα παρουσιάστηκε...");
	}
})

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
    minHeight: '170px',
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

		const {isConfirmed} = res;
		if (!isConfirmed) return;
		
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

$("#multiple-course-remove").on("click", async function() {
	const checkboxes = $(".js-user-checkbox:checked");
	const ids = [];

	for ( let i = 0; i < checkboxes.length; i++) {
		ids.push(checkboxes[i].dataset.courseId);
	}

	try {

		const {isConfirmed} = await removeCoursesConfirm(ids.length);
		if (!isConfirmed) return; 

		await removeCourses(ids);

		courses.ajax.reload();
        addCourse.ajax.reload();
	}
	catch(err) {
		console.log(err);
		utilities.toastAlert("error", "Κάποιο σφάλμα παρουσιάστηκε");
	}
});

$("#select-all-courses-profile").on("change", function() {

	const checkboxes = $(".js-user-profile-checkbox");
	const addBtn = $("#add-multiple-courses-btn")[0];

	utilities.minorCheckboxSwitcher( this, checkboxes, addBtn );
});

$("#view-homework-modal").on("show.bs.modal", function(event) {
	
	const button = $(event.relatedTarget);
	const id = button.data("id");

	axios.get(`/homework-ajax/${id}`)
		.then( res => {
			$(this).find("#homework-content").html(res.data);
		})
		.catch( err => {
			console.log(err);
			utilities.toastAlert("error", "Κάποιο σφάλμα παρουσιάστηκε...")
		})
});

$("#view-homework-modal").on("hidden.bs.modal", function() {

	const placeholder = `<div class="d-flex justify-content-center py-4">
		<div class="spinner-border avatar-md text-primary" role="status"></div>
	</div>`

	$(this).find("#homework-content").html(placeholder);
});