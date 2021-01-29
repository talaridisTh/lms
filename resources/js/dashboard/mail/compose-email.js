import utilities from '../main';
import Dropzone from "../../../theme/js/vendor/dropzone.min.js";

//! Global Variables
const baseUrl = window.location.origin;
//!====================================

utilities.redactorConfig.minHeight = "300px"

$R("#editor", utilities.redactorConfig);
sessionStorage.removeItem("recipients");

utilities.tableLocale.emptyTable = "Δεν ορίστικαν παραλήπτες";
utilities.tableLocale.zeroRecords = "Δεν βρέθηκαν παραλήπτες";

const usersDatatable = $("#users-datatable").DataTable({
	order: [1, "asc"],
	autoWidth: false,
	columnDefs: [
		{ targets: 0, width: "50px"},
		{ targets: 2, width: "130px"},
		{ targets: 3, width: "100px"},
	],
	searchDelay: "1000",
	processing: true,
	serverSide: true,
	ajax: {
		url: "/email/select-users",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		type: "post",
		data: function( d ) {
			return $.extend( {}, d, {
				recipients: sessionStorage.getItem("recipients")
			})
		}
	},
	columns: [
		{ data: 'action', name: 'action', className: "align-middle text-center", orderable: false },
		{ data: 'name', name: 'users.last_name', className: "align-middle" },
		{ data: 'role', name: 'roles.name', className: "align-middle text-center text-wrap" },
		{ data: 'btn', className: "align-middle text-center text-wrap", orderable: false, searchable: false },
		{ data: 'courses', name: 'courses.title', className: "align-middle text-center text-wrap", visible: false },
		{ data: 'first_name', name: "first_name", visible: false },
		{ data: 'last_name', name: "last_name", visible: false },
	],
	language: utilities.tableLocale,
	fnInitComplete: function( oSettings, json ) {
		let lenthSelection = $("select[name='users-datatable_length']");

		lenthSelection.select2({
			minimumResultsForSearch: -1,
		});
	},
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		$(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
		$(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");

		$(".js-add-recipient").on("click", addRecipientHandler);
		$(".js-user-checkbox").on("change", addUserCheckboxHandler);

		utilities.resetAddButton( $("#add-recipients-blk"), $("#select-all-users") );
	}
});

const recipientsDatatable = $("#recipients-datatable").DataTable({
	order: [1, "asc"],
	autoWidth: false,
	columnDefs: [
		{ targets: [0, 3], width: "50px"},
		{ targets: 2, width: "200px"},
	],
	searchDelay: "1000",
	processing: true,
	serverSide: true,
	ajax: {
		url: "/email/recipients-data-table",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		type: "post",
		data: function( d ) {
			return $.extend( {}, d, {
				recipients: sessionStorage.getItem("recipients")
			})
		}
	},
	columns: [
		{ data: 'action', name: 'action', className: "align-middle text-center", orderable: false },
		{ data: 'name', name: 'users.last_name', className: "align-middle" },
		{ data: 'role', name: 'roles.name', className: "align-middle text-center text-wrap" },
		{ data: 'btn', className: "align-middle text-center text-wrap", orderable: false, searchable: false },
		{ data: 'courses', name: 'courses.title', className: "align-middle text-center text-wrap", visible: false},
		{ data: 'first_name', name: "first_name", visible: false },
		{ data: 'last_name', name: "last_name", visible: false },
	],
	language: utilities.tableLocale,
	fnInitComplete: function( oSettings, json ) {
		let lenthSelection = $("select[name='recipients-datatable_length']");

		lenthSelection.select2({
			minimumResultsForSearch: -1,
		});
	},
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");

		$(".js-remove-recipient").on("click", removeRecipientHandler);
		$(".js-recipient-checkbox").on("change", removeRecipientsCheckboxHandler);

		utilities.resetBulk( $("#remove-recipients-btn"), $("#select-all-recipients"), "Αφαίρεση (0)")
	}
});

function removeRecipientsCheckboxHandler() {
	let mainCheckbox = $("#select-all-recipients")[0];
	let minorCheckboxes = $(".js-recipient-checkbox");
	let bulkBtn = $("#remove-recipients-btn")[0]

	utilities.mainCheckboxSwitcher( mainCheckbox, minorCheckboxes, bulkBtn );
}

function addUserCheckboxHandler() {
	let mainCheckbox = $("#select-all-users")[0];
	let minorCheckboxes = $(".js-user-checkbox");
	let bulkBtn = $("#add-recipients-blk")[0]

	utilities.mainCheckboxSwitcher( mainCheckbox, minorCheckboxes, bulkBtn );
}

function addRecipientHandler() {

	$(".js-add-recipient").prop("disabled", true);

	const id = this.dataset.userId;
	let recipients = sessionStorage.getItem("recipients");
	
	if (recipients === null) {
		recipients = `${id}`;
	}
	else {
		recipients += `,${id}`;
	}
	
	userTablesUpdate(recipients);
}

function removeRecipientHandler() {
	const id = this.dataset.userId;
	const recipients = sessionStorage.getItem("recipients").split(",");
	const index = recipients.indexOf(id);

	recipients.splice(index, 1);
	
	userTablesUpdate(recipients);
}

function userTablesUpdate(recipients) {
	sessionStorage.removeItem("recipients");
	sessionStorage.setItem("recipients", recipients);

	usersDatatable.ajax.reload(null, false);
	recipientsDatatable.ajax.reload(null, false);
}

function createSelect(id) {
	const select = document.createElement("select");
	select.classList.add("select2", "form-control", "select2-multiple");
	select.id = id;

	return select;
}

//! Users table filters
(function coursesFilter() {
	const lengthCnt = document.getElementById("users-datatable_length");
	const select = createSelect("course-user-filter");

	lengthCnt.append(select);

	$(select).select2({
		placeholder: "Όλα τα Courses",
		width: "150px",
		ajax: {
			url: "/courses/json-search",
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
		const label = $('#select2-course-user-filter-container')[0];

		utilities.filterStyle( label, this.value.trim() );
		usersDatatable.column(4).search( this.value ).draw();
	})
})();

(function rolesFilter() {
	const lengthCnt = document.getElementById("users-datatable_length");
	const select = createSelect("user-role-filter");
	select.innerHTML = `
		<option value="">Όλοι οι Ρόλοι</option>
		<option value="admin">Admin</option>
		<option value="instructor">Εισηγητές</option>
		<option value="partner">Partners</option>
		<option value="student">Μαθητές</option>
	`;

	lengthCnt.append(select);

	$(select).select2({
		width: "150px",
	})

	$(select).on("change", function() {
		const label = $('#select2-user-role-filter-container')[0];

		utilities.filterStyle( label, this.value );
		usersDatatable.column(2).search( this.value ).draw();
	})
})();

//! Recipients table filters
(function coursesRecipientFilter() {
	const lengthCnt = document.getElementById("recipients-datatable_length");
	const select = createSelect("course-recipients-filter");

	lengthCnt.append(select);

	$(select).select2({
		placeholder: "Όλα τα Courses",
		width: "150px",
		ajax: {
			url: "/courses/json-search",
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
		const label = $('#select2-course-recipients-filter-container')[0];

		utilities.filterStyle( label, this.value.trim() );
		recipientsDatatable.column(4).search( this.value ).draw();
	})
})();

(function rolesFilter() {
	const lengthCnt = document.getElementById("recipients-datatable_length");
	const select = createSelect("recipient-role-filter");
	select.innerHTML = `
		<option value="">Όλοι οι Ρόλοι</option>
		<option value="admin">Admin</option>
		<option value="instructor">Εισηγητές</option>
		<option value="partner">Partners</option>
		<option value="student">Μαθητές</option>
	`;

	lengthCnt.append(select);

	$(select).select2({
		width: "150px",
	})

	$(select).on("change", function() {
		const label = $('#select2-recipient-role-filter-container')[0];

		utilities.filterStyle( label, this.value );
		recipientsDatatable.column(2).search( this.value ).draw();
	})
})();

$("#select-all-users").on("change", function() {
	let checkboxes = $('.js-user-checkbox');
	let bulkBtn = $("#add-recipients-blk")[0];

	utilities.minorCheckboxSwitcher( this, checkboxes, bulkBtn );
});

$("#select-all-recipients").on("change", function() {
	let checkboxes = $('.js-recipient-checkbox');
	let bulkBtn = $("#remove-recipients-btn")[0];

	utilities.minorCheckboxSwitcher( this, checkboxes, bulkBtn );
});

$("#remove-recipients-btn").on("click", function() {
	const recipients = sessionStorage.getItem("recipients").split(",");
	const unwanted = $(".js-recipient-checkbox:checked");
	let index;

	for (let i = 0; i < unwanted.length; i++) {
		index = recipients.indexOf(unwanted[i].dataset.userId);
		recipients.splice(index, 1);
	}

	userTablesUpdate(recipients.toString());
});

$("#add-recipients-blk").on("click", function() {
	const recipients = sessionStorage.getItem("recipients") === null 
		? [] : sessionStorage.getItem("recipients").split(",");
	const users = $(".js-user-checkbox:checked");

	for ( let i = 0; i < users.length; i++ ) {
		recipients.push(users[i].dataset.userId);
	}

	userTablesUpdate(recipients.toString());

	$("#users-table-modal").modal("hide");
});

function dzCancelHandler() {

	const fileName = this.findParent(3)
		.querySelector(".dz-filename > span").textContent;

	const files = attachmentDropzone.getAcceptedFiles();

	for ( let i = 0; i < files.length; i++ ) {
		if ( files[i].name === fileName ) {
			attachmentDropzone.removeFile(files[i]);
		}
	}
}

utilities.ALLOWEDTYPES.push("image/jpeg");
utilities.ALLOWEDTYPES.push("image/png");

const filePreviewTemplate = document.getElementById("file-preview-template").innerHTML;
const bannerDropzoneCnt = document.getElementById("my-awesome-dropzone");
const attachmentDropzone = new Dropzone(bannerDropzoneCnt, {
	url: "/dashboard/email",
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
	},
	autoProcessQueue: false,
	parallelUploads: 10,
	uploadMultiple: true,
	previewTemplate: filePreviewTemplate,
	previewsContainer: "#previews",
	acceptedFiles: utilities.ALLOWEDTYPES.join(),
	dictInvalidFileType: "Μη υποστηριζόμενος τύπος αρχείου.",
});

attachmentDropzone.on("addedfile", function(file) {

	file.cancelBtn = file.previewTemplate
		.getElementsByClassName("js-cancel-btn")[0];

	file.cancelBtn.addEventListener("click", dzCancelHandler);
});

attachmentDropzone.on("complete", function(file) {

	const {accepted} = file;

	if ( ! accepted) {

		this.removeFile(file); //! invalid type

		utilities.toastAlert("info", "Ο τύπος αρχείου δεν υποστηρίζεται...");

		return;
	}
});

attachmentDropzone.on("sendingmultiple", function(file, xhr, formData) {

	const subject = $("#subject").val();
	const content = $R('#editor', 'source.getCode');
	const recipients = sessionStorage.getItem("recipients") == null
		? "" : sessionStorage.getItem("recipients");

	formData.append("subject", subject);
	formData.append("content", content);
	formData.append("recipients", recipients);
});

attachmentDropzone.on("successmultiple", function(file, res) {

	if ( res === "Successful" ) {
		window.location.href = `${baseUrl}/dashboard/email`;
	}
});

attachmentDropzone.on("errormultiple", function(files, res) {

	for (let i = 0; i < files.length; i++) {
		files[i].status = "queued";
	}

	$(`#subject-error`).addClass("d-none");
	$(`#content-error`).addClass("d-none");

	for (const error in res.errors) {

		if ( error !== "recipients") {
			
			$(`#${error}-error`).removeClass("d-none");
		}
		else {
			utilities.toastAlert("info", "Δεν ορίστηκαν παραλήπτες...");
		}
	}

});

$(".js-submit-btn").on("click", function() {

	const files = attachmentDropzone.getAcceptedFiles();

	if (files.length > 0) {
		attachmentDropzone.processQueue();

		return;
	}

	const form = document.getElementById("email-form");
	const recipients = sessionStorage.getItem("recipients");

	$("#recipients-input").val(recipients);

	form.submit();
});