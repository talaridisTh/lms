//! GLOBAL VARIABLES
//!============================================================
const courseId = $("#course-materials-list")[0].dataset.courseId
const namespace = "App\\Course";
const courseSlug = $("#course-materials-list")[0].dataset.courseSlug
const baseUrl = window.location.origin;

//!######################################
//! 				Imports				#
//!######################################
import utilities from '../main';
import ArticleEditor from "../../../plugins/article-editor/article-editor"
import Reorder from "../../../plugins/article-editor/plugins/reorder/reorder"

import * as FilePond from 'filepond';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import 'filepond/dist/filepond.min.css';

//!##########################################
//! 			EventListerners				#
//!##########################################

$("#remove-all-files-btn").on("click", function() {

	let fileRow = $(".js-file-row")
	let ids = [];

	for (let i = 0; i < fileRow.length; i++) {
		ids.push(fileRow[i].dataset.fileId);
	}

	Swal.fire({
		icon: 'info',
		title: 'Προσοχή!',
		text: 'Αφαίρεση όλων των αρχείων;',
		showCancelButton: true,
		confirmButtonText: `Ναι, αφαίρεση!`,
		cancelButtonText: `Ακύρωση`,
	}).then((result) => {
		if (result.isConfirmed) {
			removeFiles(ids);
		}
	})
})

$(".js-remove-file").on("click", function() {
	removeFiles( [this.dataset.fileId] );
})

$(".js-audio-btn").on("click", audioPlayerHandler);

$("#remove-cover-btn").on("click", function() {
	
	axios.patch( "/media/remove-cover", {
		namespace,
		id: courseId
	})
	.then( res => {

		let cnt = this.parentElement;

		$("#cover-image").addClass("d-none");
		$("#cover-status").removeClass("d-none");
		$("#change-cover-btn").text("Προσθήκη")

		cnt.classList.remove("d-flex");
		cnt.classList.add("d-none");

	})
	.catch( err => {
		console.log(err);
	})
});

$("#title").on("input", function() {
	if (this.value) {
		this.classList.remove("is-invalid");
	}
});

$("#version-select").on("change", function() {

	if (this.value) {
		this.classList.remove("is-invalid");
	}

})

$("#add-new-material-btn").on("click", function() {
	let priority = $("#store-material-priority").val();

	window.location = `/dashboard/materials/coursematerial/${courseSlug}/${priority}`;
})

$("#change-cover-btn").on("click", function() {

	$("#gallery-content")[0].dataset.type = "cover";

	$("#gallery-modal").modal('show');
})

$("#image-search").on("input", utilities.searchHandler);

$(".js-gallery-page-btn").on( 'click', utilities.paginationHandler);

$(".js-add-image").on( "click", utilities.imageHandler);

$("#activate-selection").on( 'click', function() {
	let selection = $(".js-course-material-checkbox:checked");
	let data = [];

	for ( var i = 0; i < selection.length; i++ ) {
		data.push({
			id: selection[i].dataset.materialId,
			status: 1
		});
	}

	Swal.fire({
		title: 'Ενεργοποίηση;',
		html: `<p class='mb-0'>Η ενέργεια θα ενεργοποιήσει ${i}</p>απο τα μαθήματα του Course.`,
		icon: 'info',
		showCancelButton: true,
		confirmButtonText: 'Ναι, ενεργοποίηση!',
		cancelButtonText: 'Άκυρο'
	}).then( (result) => {

		if (result.value) {

			toggleState( data );

		}
	})

});

$("#deactivate-selection").on( "click", function() {
	let selection = $(".js-course-material-checkbox:checked");
	let data = [];

	for ( var i = 0; i < selection.length; i++ ) {
		data.push({
			id: selection[i].dataset.materialId,
			status: 0
		});
	}

	Swal.fire({
		title: 'Απενεργοποίηση;',
		html: `<p class='mb-0'>Η ενέργεια θα απενεργοποιήσει ${i}</p>απο τα μαθήματα του Course.`,
		icon: 'warning',
		showCancelButton: true,
		confirmButtonText: 'Ναι, απενεργοποίηση!',
		cancelButtonText: 'Άκυρο'
	}).then( (result) => {

		if (result.value) {

			toggleState( data );

		}
	})

});

$(".tab-link").on("show.bs.tab", function(event) {

		event.preventDefault();
		Swal.fire(
			'Προσοχή',
			'<p>Θα πρέπει να αποθηκεύσετε το Course</p>για να συνεχίσετε!',
			'info'
		);
})

$("#courseDelete-btn").on( "click", function() {
	Swal.fire({
		title: 'Είστε σίγουρος;',
		text: "Η ενέργεια θα είναι μη αναστρέψιμη!",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonText: 'Ναι, διαγραφή!',
		cancelButtonText: 'Άκυρο'
	}).then( (result) => {

		if (result.value) {

			$("#delete-course-form").submit();

		}
	})
})

let publishDate = $("#publish-date-select").daterangepicker({
	singleDatePicker: true,
	drops: "auto",
    opens: "center",
	timePicker: true,
	autoUpdateInput: false,
	timePicker24Hour: true,
	cancelButtonClasses: "btn-secondary",
	locale: {
		format: "DD-MM-YYYY H:mm",
		cancelLabel: "Clear"
    },
});

publishDate.on( "apply.daterangepicker", function(event, picker) {

	let startDate = picker.startDate.format('DD-MM-YYYY H:mm');
	this.value = startDate;

});

publishDate.on( 'cancel.daterangepicker', function(event, picker) {
	this.value = "";
});

$("#publish-date-select").on("input", function() {

	this.value = this.value.replace( /[^0-9]/g, "" )
		.replace(/^(\d{2})?(\d{2})?(\d{4})?(\d{2})?(\d{2})?(\d{4})?/g, '$1-$2-$3 $4:$5')
		.substr(0, 16);

})

$("#add-user-checkbox").on( "change", function() {
	let minorCheckboxes = $(".js-new-user-checkbox");
	let bulkBtn = $("#add-multiple-users-btn")[0]

	utilities.minorCheckboxSwitcher(this, minorCheckboxes, bulkBtn);
})

$("#select-all-active-users").on( "change", function() {

	let minorCheckboxes = $(".js-active-user-checkbox")
	let bulkBtn = $("#active-users-bulk")[0]

	utilities.minorCheckboxSwitcher(this, minorCheckboxes, bulkBtn);
});

$("#update-btn").on( "click", function() {
	$("#edit-course-form").submit();
});

$("#active-switch").on( "change", function() {

	axios.patch( "/courses/status", {
		course: courseId,
		state: this.checked ? 1 : 0
	})
	.then( (res) => {

		let icon = this.checked ? "success" : "info";
		let message = this.checked ? "Ενεργοποιήθηκε" : "Απενεργοποιήθηκε";

		utilities.toastAlert( icon, message );
	})
	.catch( (err) => {
		console.log(err);
		utilities.toastAlert( "error", "Παρουσιάστηκε κάποιο πρόβλημα ..." );
	});
});

$("#add-multiple-users-btn").on( "click", function() {
	let newUsers = $(".js-new-user-checkbox:checked");
	let userIds = [];

	for ( let i = 0; i < newUsers.length; i++ ) {
		userIds.push( newUsers[i].dataset.userId );
	}

	addUsers(userIds);
	$('#add-user-modal').modal('hide')
});

$("#remove-selected-users-btn").on( "click", function() {

	let usersCheckbox = $(".js-active-user-checkbox:checked");
	let userIds = [];

	for ( var i = 0; i < usersCheckbox.length; i++ ) {
		userIds.push( usersCheckbox[i].dataset.userId );
	}

	Swal.fire({
		title: 'Είστε σίγουρος/η;',
		text: `Η ενέργεια θα αφαιρέσει ${ i > 1 ? i : "έναν" } απο τους χρήστες.`,
		icon: 'warning',
		showCancelButton: true,
		confirmButtonText: 'Ναι, αφαίρεση!',
		cancelButtonText: 'Άκυρο'
	}).then( (result) => {

		if (result.value) {

			removeUsers(userIds, this);

		}
	})

});

$("#course-cover-input").on( "change", function() {
	let label = $("#course-cover-label")[0];

	label.textContent = this.value.replace("C:\\fakepath\\", "");
});

$('#all-remainings-checkbox').on( "change", function() {
	let checkboxes = $('.js-remainings-checkbox');
	let bulkBtn = $("#add-remaingings-btn")[0];

	utilities.minorCheckboxSwitcher( this, checkboxes, bulkBtn );

});

$('#add-remaingings-btn').on( "click", function() {
	let checkboxes = $('.js-remainings-checkbox:checked');
	let ids = [];

	if ( checkboxes.length == 0 ) {
		utilities.toastAlert( 'info', "Δεν υπάρχουν επιλεγμένα μαθήματα..." );
		return;
	}
	else {
		for ( let i = 0; i < checkboxes.length; i++ ) {
			ids.push(checkboxes[i].dataset.materialId);
		}
		postMaterialIds( ids);
	}

	$('#add-materials-modal').modal('hide');
});

$('#remove-selection-btn').on( "click", function() {
	let checkboxes = $('.js-course-material-checkbox:checked');
	let ids = [];

	if ( checkboxes.length == 0 ) {

		utilities.toastAlert( 'info', "Δεν υπάρχουν επιλεγμένα μαθήματα..." );
		return;
	}
	else {
		for ( var i = 0; i < checkboxes.length; i++ ) {
			ids.push( checkboxes[i].dataset.materialId );
		}

		Swal.fire({
			title: 'Είστε σίγουρος/η;',
			html: `<p class="mb-0">Η ενέργεια θα αφαιρέσει ${i} απο</p>τα περιεχόμενα του Course.`,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Ναι, αφαίρεση!',
			cancelButtonText: 'Άκυρο'
		}).then( (result) => {
			if (result.value) {

				removeMaterials( ids );

			}
		})

	}
});

$("#all-active-materials-checkbox").on( "change", function() {

	let checkboxes = $(".js-course-material-checkbox");
	let bulkBtn = $("#active-material-bulk")[0];

	utilities.minorCheckboxSwitcher( this, checkboxes, bulkBtn );

});

//!##################################################
//! 			Datatables Initialization			#
//!##################################################
const courseMaterialsTable = $("#course-materials-list").DataTable({
	order: [3, "asc"],
	processing: true,
	serverSide: true,
	ajax: {
		url: "/courses/course-materials-datatable",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		type: "post",
		data: function( d ) {
			return $.extend( {}, d, {
				courseId: courseId,
				startDate: startDate( $("#course-material-date-range")[0] ),
				endDate: endDate( $("#course-material-date-range")[0] )
			})
		}

	},
	columns: [
		{ data: 'action', className: "position-relative text-center align-middle", orderable: false },
		{ data: 'title', name: 'title' },
		{ data: 'status', name: 'pivot.status', className: "text-center align-middle", },
		{ data: 'priority', name: 'pivot.priority', className: "align-middle",  width: "5%", searchable: false },
		{ data: 'type', name: 'type', className: "cursor-default text-center align-middle" },
		{ data: 'updated_at', name: 'updated_at',  className: "cursor-default text-center align-middle", searchable: false },
		{ data: 'created_at', name: 'created_at', className: "cursor-default text-center align-middle", searchable: false },
		{ data: 'btns', className: "cursor-default text-center align-middle", searchable: false, orderable: false },
	],
	language: utilities.tableLocale,
	fnInitComplete: function( oSettings, json ) {
		let lenthSelection = $("select[name='course-materials-list_length']");
		lenthSelection.addClass("select2");

		lenthSelection.select2({
			minimumResultsForSearch: -1,
		});
	},
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		$(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
		$(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
		$(".js-remove-table-classes > thead > tr > th").removeClass("cursor-default");

		activeMaterialsCheckboxToggle();
		toggleCourseMaterial();
		sortInputsInit();
		removeMaterialInit();
		utilities.resetBulk( $("#active-material-bulk"), $("#all-active-materials-checkbox") );
	},

});

const remainingMaterialsTables = $("#remaining-materials-table").DataTable({
	order: [1, "asc"],
	processing: true,
	serverSide: true,
	ajax: {
		url: "/courses/not-incourse-materials-datatable",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		type: "post",
		data: function( d ) {
			return $.extend( {}, d, {
				courseId: courseId,
				startDate: startDate( $("#remaining-materials-date-range")[0] ),
				endDate: endDate( $("#remaining-materials-date-range")[0] )
			})
		}
	},
	columns: [
		{data: 'action', width: "5%", className: "text-center", orderable: false},
		{data: 'title', name: 'materials.title', className: "cursor-default"},
		{data: 'topics', name: 'topics.title', className: "text-center cursor-default"},
		{data: 'type', name: 'materials.type', className: "text-center cursor-default"},
		{data: 'addBtn', width: "12%", class: "text-center", searchable: false, orderable: false},
	],
	language: utilities.tableLocale,
	fnInitComplete: function( oSettings, json ) {
		let lenthSelection = $("select[name='remaining-materials-table_length']");
		lenthSelection.addClass("select2");

		lenthSelection.select2({
			minimumResultsForSearch: -1,
		});
	},
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		$(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
		$(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
		$(".js-remove-table-classes > thead > tr > th").removeClass("cursor-pointer");
		$(".js-remove-table-classes > tfoot > tr > th").removeClass("cursor-pointer");

		addMaterialsEventListerner();
		remainingsCheckboxes();
		utilities.resetAddButton( $("#add-remaingings-btn"), $("#all-remainings-checkbox") );
	},

});

const courseUsersDatatable = $("#active-users-list").DataTable({
	order: [2, "asc"],
	processing: true,
	serverSide: true,
	ajax: {
		url: "/courses/course-users-datatable",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		type: "post",
		data: {
			courseId: courseId
		}
	},
	columns: [
		{data: 'action', width: "5%", className: "text-center", orderable: false, searchable: false},
		{data: 'first_name', name: 'first_name', className: "cursor-default" },
		{data: 'last_name', name: 'last_name', className: "cursor-default" },
		{data: 'email', name: 'email', className: "cursor-default" },
		{data: 'phone', name: 'phone', className: "cursor-default" },
		{data: 'role', name: 'role', className: "cursor-default" },
		{data: 'btn', width: "5%", orderable: false, searchable: false },
	],
	language: utilities.tableLocale,
	fnInitComplete: function( oSettings, json ) {
		let lenthSelection = $("select[name='active-users-list_length']");
		lenthSelection.addClass("select2");

		lenthSelection.select2({
			minimumResultsForSearch: -1,
		});
	},
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		$(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
		$(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
		$(".js-remove-table-classes > thead > tr > th").removeClass("cursor-default");
		$(".js-remove-table-classes > tfoot > tr > th").removeClass("cursor-default");

		removeUserBtnInit();
		userLinkInit();
		activeUsersCheckboxInit();
		utilities.resetBulk( $("#active-users-bulk"), $("#select-all-active-users") );
	},

});

const addCourseUsersDatatable = $("#add-users-list").DataTable({
	order: [2, "asc"],
	processing: true,
	serverSide: true,
	ajax: {
		url: "/courses/add-course-students-datatable",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		type: "post",
		data: {
			courseId: courseId
		}
	},
	columns: [
		{data: 'action', width: "5%", orderable: false, searchable: false},
		{data: 'first_name', name: 'first_name', className: "cursor-pointer js-user-link" },
		{data: 'last_name', name: 'last_name', className: "cursor-pointer js-user-link" },
		{data: 'email', name: 'email', className: "cursor-pointer js-user-link" },
		{data: 'phone', name: 'phone', className: "cursor-pointer js-user-link" },
		{data: 'role', name: 'role', className: "cursor-pointer js-user-link" },
		{data: 'addBtn', width: "5%", orderable: false, searchable: false },
	],
	language: utilities.tableLocale,
	fnInitComplete: function( oSettings, json ) {
		let lenthSelection = $("select[name='add-users-list_length']");
		lenthSelection.addClass("select2");

		lenthSelection.select2({
			minimumResultsForSearch: -1,
		});
	},
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		$(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
		$(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
		$(".js-remove-table-classes > thead > tr > th").removeClass("cursor-pointer");
		$(".js-remove-table-classes > tfoot > tr > th").removeClass("cursor-pointer");

		adduserBtnInit();
		userLinkInit();
		newUserCheckboxInit();
		utilities.resetAddButton( $("#add-multiple-users-btn"), $("#add-user-checkbox") );
	},

});

const remainingFilesTable = $("#remaining-files-datatable").DataTable({
    order: [ 0, "asc" ],
    processing: true,
    serverSide: true,
    ajax: {
        url: '/media/remaining-files',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "post",
        data: {
			namespace,
			id: courseId
        }
    },
    columns: [
        {data: "original_name", name: "original_name"},
        {data: "ext", name: "ext", className:"text-center"},
        {data: "size", name: "size", className:"text-center"},
        {data: "action", className:"text-center", searchable: false, orderable: false},
    ],
    language: utilities.tableLocale,
    drawCallback: function () {
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");

		addFilesBtnInit();
    }
})

function addFilesBtnInit() {
	let btns = $(".js-add-file-btn");

	btns.on("click", function() {
		addCourseFiles( [this.dataset.fileId] );
	})
}

function addCourseFiles(ids) {

	axios.post("/media/add-files", {
		namespace, 
		modelId: courseId,
		ids
	})
	.then( res => {
		let container = $("#files-cnt");
		container.html(res.data);

		let audioBtns = $(".js-audio-btn");
		audioBtns.on("click", audioPlayerHandler);

		let removeBtns = container.find(".js-remove-file");
		removeBtns.on("click", function() {
			removeFiles( [this.dataset.fileId] );
		});

		$("#remove-all-files-btn").removeClass("d-none");

		$("#remainings-files-modal").modal("hide");
		remainingFilesTable.ajax.reload(null, false);
	})
	.catch( err => {
		console.log(err);
	})

}

function removeFiles(ids) {

	axios.post("/media/remove-files", {
		namespace, 
		modelId: courseId,
		ids
	})
	.then( res => {
		let container = $("#files-cnt");
		container.html(res.data);

		let audioBtns = $(".js-audio-btn");
		audioBtns.on("click", audioPlayerHandler);

		let btns = container.find(".js-remove-file");
		btns.on("click", function() {
			removeFiles( [this.dataset.fileId] );
		});

		if ( btns.length == 0 ) {
			$("#remove-all-files-btn").addClass("d-none");
		}
		else {
			$("#remove-all-files-btn").removeClass("d-none");
		}

		remainingFilesTable.ajax.reload(null, false);
		utilities.toastAlert("info", "Τα αρχεία αφαιρέθηκαν");
	})
	.catch( err => {
		console.log(err);
		utilities.toastAlert( 'error', "Παρουσιάστηκε κάποιο πρόβλημα ..." );
	})
}

//!######################################
//! 		Datatable Filters			#
//!######################################

//* active users table filters
let activeUserslistLength = $('#active-users-list_length > label')[0];
let activeUsersFilter = createRoleSelect("active-user-roles");

activeUserslistLength.append( activeUsersFilter );

$("#active-user-roles").select2({
	minimumResultsForSearch: -1,
});

$("#active-user-roles").on( "change", function () {

	let label = $("#select2-active-user-roles-container")[0];
	utilities.filterStyle( label, this.value )

	courseUsersDatatable.columns(3).search( this.value ).draw();

});

//* add new users table filters
let addUsersListLength = $('#add-users-list_length > label');
let addUsersFilter = createRoleSelect("add-users-roles");

addUsersListLength.append(addUsersFilter);

$("#add-users-roles").select2({
	minimumResultsForSearch: -1,
});

$("#add-users-roles").on( "change", function () {

	let label = $('#select2-add-users-roles-container')[0];

	utilities.filterStyle( label, this.value )
	addCourseUsersDatatable.columns(3).search( this.value ).draw();

});

//* Active Materials filters
const courseMaterialListLength = $("#course-materials-list_length > label")[0];
let courseMaterialState = utilities.createStateSelect("active-course-status");
courseMaterialListLength.append( courseMaterialState );

$("#active-course-status").select2({
	minimumResultsForSearch: -1,
});

$("#active-course-status").on( "change", function() {

	let label = $('#select2-active-course-status-container')[0];

	utilities.filterStyle( label, this.value )
	courseMaterialsTable.columns( 2 ).search( this.value ).draw();
});

//* Append Course Materials Date Picker Filter
let courseMaterialSearchInput = $("#course-materials-list_filter > label > input")[0];
let courseMaterialDateInput = createDateElm( "course-material-date-range" );

courseMaterialDateInput.appendBefore( courseMaterialSearchInput );

//* Append Remainging Materials Date Picker Filter
let remainingMaterialsSearchInput = $("#remaining-materials-table_filter > label > input")[0];
let remainingMaterialsDateInput = createDateElm( "remaining-materials-date-range" );

remainingMaterialsDateInput.appendBefore( remainingMaterialsSearchInput );


//* Date Search
let dateRange = $(".js-date-search");

dateRange.daterangepicker( utilities.datePickerConfig );

dateRange.on( "apply.daterangepicker", function(event, picker) {

	let startDate = picker.startDate.format('DD/MM/YYYY');
	let endDate = picker.endDate.format('DD/MM/YYYY');
	this.value = `${ startDate } - ${ endDate }`;

	this.classList.add("select2-selected");
	let tableId = $(this).closest(".table-cnt").find(".js-table").attr("id");
	$(`#${tableId}`).DataTable().ajax.reload();

});

dateRange.on( 'cancel.daterangepicker', function(event, picker) {

	this.value = "";
	this.classList.remove("select2-selected");
	let tableId = $(this).closest(".table-cnt").find(".js-table").attr("id");
	$(`#${tableId}`).DataTable().ajax.reload();

});

//! DataTables function / EventListener

function removeMaterialInit() {

	let binBtn = $(".js-remove-material")

	binBtn.unbind();

	binBtn.on( "click", function() {

		let id = [ this.dataset.materialId ];

		Swal.fire({
			title: "Είστε σίγουρος/η;",
			text: 'Το υλικό θα αφαιρεθεί απο το Course.',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Ναι, αφαίρεση!',
			cancelButtonText: 'Άκυρο'
		}).then( (result) => {

			if (result.value) {

				removeMaterials( id );

			}
		})
	});
}

function newUserCheckboxInit() {

	let mainCheckbox = $("#add-user-checkbox")[0];
	let minorCheckboxes = $(".js-new-user-checkbox");
	let bulkBtn = $("#add-multiple-users-btn")[0]

	minorCheckboxes.unbind();

	minorCheckboxes.on( "change", function() {
		utilities.mainCheckboxSwitcher( mainCheckbox, minorCheckboxes, bulkBtn );
	});

}

function activeUsersCheckboxInit() {

	let mainCheckbox = $("#select-all-active-users")[0];
	let minorCheckboxes = $(".js-active-user-checkbox");
	let bulkBtn = $("#active-users-bulk")[0]

	minorCheckboxes.unbind();

	minorCheckboxes.on( "change", function() {
		utilities.mainCheckboxSwitcher( mainCheckbox, minorCheckboxes, bulkBtn );
	});
}

function userLinkInit() {

	let link = $(".js-user-link");

	link.unbind();
	link.on( "click", function() {

		let userSlug = this.parentElement.dataset.userSlug

		window.location = `/dashboard/users/${ userSlug }`;
	});
}

function removeUserBtnInit() {

	let removeUserBtn = $(".js-remove-user");

	removeUserBtn.unbind();
	removeUserBtn.on( "click", function() {

		let id = [ this.dataset.userId ];

		Swal.fire({
			title: 'Είστε σίγουρος/η;',
			html: "<p class='mb-0'>Η ενέργεια θα αφαιρέσει έναν</p>απο τους χρήστες του Course.",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Ναι, αφαίρεση!',
			cancelButtonText: 'Άκυρο'
		}).then( (result) => {

			if (result.value) {

				removeUsers( id );

			}
		})

	})
}

function adduserBtnInit() {

	let addUserBtn = $(".js-add-user-btn");

	addUserBtn.unbind();
	addUserBtn.on( "click", function() {

		let userId = [ this.dataset.userId ];

		addUsers( userId );
	})
}

function addMaterialsEventListerner() {

	let addMaterialBtn = $('.js-add-material-btn');

	addMaterialBtn.unbind();
	addMaterialBtn.on( "click", function() {
		const materialId = [this.dataset.materialId];

		for (let i = 0; i < addMaterialBtn.length; i++) {
			addMaterialBtn[i].disabled = true;
		}

		postMaterialIds( materialId );
	});
}

function sortInputsInit() {

	$('.js-sort-input').unbind();

	$('.js-sort-input').on( "input", function() {

		let inputValue = this.value;

		if ( isNaN( inputValue ) ) {
			return this.value = inputValue.replace(/[^0-9]/g, '');
		}

	});

	$('.js-sort-input').on('keyup', function() {

		if ( event.keyCode == 13 && !isNaN( this.value) ) {
			axios.patch('/courses/priority', {
				courseId: $('#course-materials-list')[0].dataset.courseId,
				materialId: this.dataset.materialId,
				priority: {
					new: this.value,
					old: this.dataset.currentPriority
				},
			})
			.then( (res) => {
				courseMaterialsTable.ajax.reload( null, false );

			})
		}

	});
}

function toggleCourseMaterial() {
	$('.js-toggle').unbind();

	$('.js-toggle').on('change', function() {

		//& an empene to function (toggleState)
		//& 8a ginotan ena PERITO reload tou table
		axios.patch('/courses/toggle-materials', {
			courseId: this.dataset.courseId,
			data: [{
				id: this.dataset.materialId,
				status: this.checked ? 1 : 0
			}],
		})
		.then( (res) => {
			let icon = this.checked ? "success" : "info";
			let message = this.checked ? "Ενεργοποιήθηκε" : "Απενεργοποιήθηκε";

			utilities.toastAlert( icon, message );

		})
		.catch( (err) => {
			utilities.toastAlert( 'error', "Παρουσιάστηκε κάποιο πρόβλημα ..." );
		});
	});
}

function remainingsCheckboxes() {

	let remainingCheckboxes = $('.js-remainings-checkbox');

	remainingCheckboxes.unbind();
	remainingCheckboxes.on( "change", remainingMaterialsCheckboxHandler );
}

$(".js-date-search").on( "input", function() {

	this.value = this.value.replace( /[^0-9]/g, "" )
		.replace(/^(\d{2})?(\d{2})?(\d{4})?(\d{2})?(\d{2})?(\d{4})?/g, '$1/$2/$3 - $4/$5/$6')
		.substr(0, 23)

});
// DataTables function / EventListener End

function remainingMaterialsCheckboxHandler() {

	let mainCheckbox = $('#all-remainings-checkbox')[0];
	let checkbox = $('.js-remainings-checkbox');
	let addMaterialsBulk = $("#add-remaingings-btn")[0];

	utilities.mainCheckboxSwitcher( mainCheckbox, checkbox, addMaterialsBulk );
}

function activeMaterialsCheckboxToggle() {

	let activeCheckboxes = $(".js-course-material-checkbox");

	activeCheckboxes.on( "change", activeMaterialsCheckboxHandler );
}

function activeMaterialsCheckboxHandler() {

	let mainCheckbox = $('#all-active-materials-checkbox')[0];
	let checkbox = $('.js-course-material-checkbox');
	let bulkBtn = $("#active-material-bulk")[0];

	utilities.mainCheckboxSwitcher( mainCheckbox, checkbox, bulkBtn );
}

function addUsers( userIds ) {
	axios.patch( "/courses/add-students", {
		courseId,
		userIds
	})
	.then( (res) => {

		let message = userIds.length == 1 ? "Ένας χρήστης προστέθηκε" : `${userIds.length} χρήστες προστέθηκαν`;
		utilities.toastAlert( 'success', message );
		courseUsersDatatable.ajax.reload( null, false );
		addCourseUsersDatatable.ajax.reload( null, false );

		utilities.resetBulk( $("#active-users-bulk"), $("#select-all-active-users") );
		utilities.resetAddButton( $("#add-multiple-users-btn"), $("#add-user-checkbox") );

	})
	.catch( (err) => {
		console.log(err);
		utilities.toastAlert( 'error', "Παρουσιάστηκε κάποιο πρόβλημα ..." );

	})
}

function removeUsers( userIds, caller ) {
	axios.patch( "/courses/remove-students", {
		courseId,
		userIds
	})
	.then( (res) => {

		let message = userIds.length == 1 ? "Ένας χρήστης αφαιρέθηκε" : `${userIds.length} χρήστες αφαιρέθηκαν`;
		utilities.toastAlert( 'success', message );
		courseUsersDatatable.ajax.reload( null, false );
		addCourseUsersDatatable.ajax.reload( null, false );

		utilities.resetBulk( $("#active-users-bulk"), $("#select-all-active-users") );
		utilities.resetAddButton( $("#add-multiple-users-btn"), $("#add-user-checkbox") );

	})
	.catch( (err) => {
		console.log(err);
		utilities.toastAlert( 'error', "Παρουσιάστηκε κάποιο πρόβλημα ..." );

	})
}

function postMaterialIds( materialId ) {
	axios.post( "/courses/add-materials", {
		courseId,
		materialId
	})
	.then( (res) => {
		let message = materialId.length == 1 ? "1 αρχείο εντός ύλης" : `${materialId.length} αρχεία εντός ύλης`;

		utilities.toastAlert( 'success', message );
		courseMaterialsTable.ajax.reload( null, false );
		remainingMaterialsTables.ajax.reload( null, false );

		utilities.resetBulk( $("#active-material-bulk"), $("#all-active-materials-checkbox") );
		utilities.resetAddButton( $("#add-remaingings-btn"), $("#all-remainings-checkbox") );

	})
	.catch( (err) => {
		console.log(err);
		utilities.toastAlert( 'error', "Παρουσιάστηκε κάποιο πρόβλημα ..." );
	})
}

function removeMaterials( materialIds ) {

	axios.patch( "/courses/remove-materials", {
		courseId,
		materialIds
	})
	.then( (res) => {

		let message = materialIds.length == 1 ? "1 αρχείο εκτός ύλης" : `${materialIds.length} αρχεία εκτός ύλης`;

		utilities.toastAlert( 'success', message );
		courseMaterialsTable.ajax.reload( null, false );
		remainingMaterialsTables.ajax.reload( null, false );

		utilities.resetAddButton( $("#add-remaingings-btn"), $("#all-remainings-checkbox") );
		utilities.resetBulk( $("#active-material-bulk"), $("#all-active-materials-checkbox") );
	})
	.catch( (err) => {
		utilities.toastAlert( 'error', "Παρουσιάστηκε κάποιο πρόβλημα ..." );
	})
}

function createRoleSelect( id = "" ) {
	const selectElm = document.createElement("select");
	selectElm.classList.add( "ml-1", "select2" );
	selectElm.id = id

	selectElm.innerHTML = `
		<option value="">Όλες οι ιδιότητες</option>
		<option value="Εισηγητής">Εισηγητές</option>
		<option value="Μαθητής">Μαθητές</option>
	`;

	return selectElm;
}

axios.post("/materials/material-types")
	.then( (res) => {
		let activeMaterials = createTopicSelect( res, "selected-materials-types" );
		let remainingMaterials = createTopicSelect( res, "remaining-materials-types" );

		courseMaterialListLength.append( activeMaterials );
		$("#remaining-materials-table_length > label")[0].append( remainingMaterials );

		$("#selected-materials-types").select2({
			minimumResultsForSearch: -1,
		});

		$("#selected-materials-types").on( "change", function() {

			let label = $('#select2-selected-materials-types-container')[0];

			utilities.filterStyle( label, this.value )

			courseMaterialsTable.columns( 4 ).search( this.value ).draw();
		})

		$("#remaining-materials-types").select2({
			minimumResultsForSearch: -1,
		});

		$("#remaining-materials-types").on( "change", function() {

			let label = $('#select2-remaining-materials-types-container')[0];

			utilities.filterStyle( label, this.value )
			remainingMaterialsTables.columns( 3 ).search( this.value ).draw();
		})

	})
	.catch( (err) => {
		console.log(err);
	})

function createTopicSelect( res, id = "" ) {
	const selectElm = document.createElement("select");
	let data = res.data;
	let options = "<option value=''>Όλοι οι τύποι</option>";

	selectElm.classList.add("ml-1", "select2");
	selectElm.id = id

	for ( let i = 0; i < data.length; i++ ) {
		options += `<option value="${data[i].type}">${data[i].type}</option>`;
	}

	selectElm.innerHTML = options;

	return selectElm

}

$("#add-additions-modal").on("show.bs.modal", function(event) {
	let button = $( event.relatedTarget );
	let id = button.data("material-id");
	let priority = button.data("priority");

	$(this).find("#store-material-id").val( id );
	$(this).find("#store-material-priority").val( priority );
})

$(".js-material").on( "click", function() {
	let id = $("#store-material-id").val();
	let priority = $("#store-material-priority").val();
	let rows = $("#course-materials-list > tbody > tr");
	let type = this.dataset.type;
	let newRow = "";
	let rowId = "";

	for ( let i = 0; i < rows.length; i++ ) {
		rowId = rows[i].dataset.materialId;

		if ( id == rowId ) {
			newRow = createTableRow( type, priority );
			newRow.appendAfter( rows[i] );
			break;
		}
	}

	if ( type == "Announcement" ) {
		$R('#new-announcement', utilities.redactorConfig );
	}

	$('#add-additions-modal').modal('hide')

});

function linkForm( type, priority) {

	return `<td id="add-content-row" class="text-left" colspan="8">
				<div id="additional-content-form">
					<h3 class="text-center font-20 line-height-05 b-block mb-3 underline">Προσθήκη ${ type }</h3>
					<div class="form-row">
						<div class="form-group col-6">
							<label for="new-title">Τίτλος</label>
							<input type="text" id="new-title" class="js-empty js-title form-control" placeholder="Εισάγετε τίτλο..." />
							<div class="invalid-feedback">
        						Παρακαλώ εισάγετε τίτλο.
							</div>
						</div>
						<div class="form-group col-6">
							<label for="new-subtitle">Υπότιτλος</label>
							<input type="text" id="new-subtitle" class="js-empty js-subtitle form-control" placeholder="Εισάγετε υπότιτλο..."/>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-6">
							<label for="link-input">${ type }</label>
							<input type="text" id="link-input" class="js-empty js-link form-control" placeholder="Εισάγετε link..."/>
						</div>
						<div class="form-group col-3">
							<label for="state-select">Κατάσταση</label>
							<select class="js-state form-control" id="state-select">
								<option value="1">Ενεργό</option>
								<option value="0" selected>Ανενεργό</option>
							</select>
						</div>
						<div class="form-group col-3 d-flex justify-content-center align-items-start" style="padding-top: 1.85rem;">
							<button  class="js-add-content btn btn-primary" data-type="${ type }" data-priority="${ priority }">Αποθήκευση</button>
							<button  class="js-cancel-addition btn btn-secondary ml-2">Άκυρο</button>
						</div>
					</div>
				</div>
			</td>`;
}

function annoucementForm( priority ) {

	return `<td id="add-content-row" class="text-left" colspan="8">
				<div id="additional-content-form">
					<h3 class="text-center font-20 line-height-05 b-block mb-3 underline">Προσθήκη Ανακοίνωσης</h3>
					<div class="form-row">
						<div class="form-group col-9">
							<label for="new-title">Τίτλος</label>
							<input type="text" id="new-title" class="js-empty js-title form-control" placeholder="Εισάγετε τίτλο..." />
						</div>

						<div class="form-group col-3">
							<label for="state-select">Κατάσταση</label>
							<select class="js-state form-control" id="state-select">
								<option value="1">Ενεργό</option>
								<option value="0" selected>Ανενεργό</option>
							</select>
						</div>
					</div>
						<div class="form-group">
							<label for="new-announcement">Ανακοίνωση</label>
							<textarea id="new-announcement" class="js-empty js-subtitle form-control" placeholder="Εισάγετε ανακοίνωση..."></textarea>
						</div>
						<div class="form-group float-right">
							<button  class="js-add-content btn btn-primary" data-type="Announcement" data-priority="${ priority }">Αποθήκευση</button>
							<button  class="js-cancel-addition btn btn-secondary ml-2">Άκυρο</button>
						</div>

				</div>
			</td>`
}

function createTableRow( type, priority ) {
	let rowElm = document.createElement("tr");
	rowElm.classList.add("extra-content-row")

	let addContentRow = $("#add-content-row")[0];

	if ( addContentRow ) {

		addContentRow.remove();

	}

	rowElm.innerHTML = type == "Announcement" ? annoucementForm( priority ) : linkForm( type, priority)

	let saveBtn = rowElm.getElementsByClassName("js-add-content")[0];
	let cancelBtn = rowElm.getElementsByClassName("js-cancel-addition")[0];
	saveBtn.addEventListener("click", addContent);
	cancelBtn.addEventListener("click", cancelAddition );

	return rowElm;
}

function cancelAddition() {

	let parent = this.parentElement.parentElement.parentElement.parentElement;
	let saveBtn = parent.getElementsByClassName("js-add-content")[0];

	saveBtn.removeEventListener( "click", addContent );
	this.removeEventListener( "click", cancelAddition );

	parent.remove();
}

function addContent() {
	let container = this.parentElement.parentElement.parentElement;
	let priority = this.dataset.priority;
	let type = this.dataset.type;
	let title = container.getElementsByClassName("js-title")[0];
	let subtitle = container.getElementsByClassName("js-subtitle")[0];
	let link = container.getElementsByClassName("js-link")[0];
	let state = container.getElementsByClassName("js-state")[0];
	let valid = checkEmpty( container, "js-empty" );

	if ( !valid ) {

		Swal.fire(
			'Προσοχή!',
			'Παρακαλώ συμπληρώστε όλα τα πεδία.',
			'info'
		);

		return
	}

	let data = new FormData();

	data.append( "courseId", courseId );
	data.append( "title", title.value );
	data.append( "subtitle", subtitle.value );
	data.append( "priority", priority );
	data.append( "type", type );
	data.append( "state", state.value );

	if ( link ) {
		data.append( `${ type.toLowerCase() }`, link.value );
	}

	axios.post( "/materials/add-additionnal-content",
		data
	)
		.then( (res) => {

			courseMaterialsTable.ajax.reload( null, false );
			utilities.toastAlert( "success", "Αποθηκεύτηκε" )
		})
		.catch( (err) => {
			utilities.toastAlert( "error", "Παρουσιάστηκε κάποιο πρόβλημα ...")
		});

}

function audioPlayerHandler() {

	let cnt = this.parentElement;
	let audio = cnt.getElementsByClassName("js-audio")[0];

	if ( this.dataset.audioStatus == "paused" ) {
		this.classList.remove("mdi-play-circle-outline");
		this.classList.add("mdi-pause-circle-outline");
		this.dataset.audioStatus = "playing";

		audio.currentTime = 0;
		audio.play();
	}
	else {
		this.classList.remove("mdi-pause-circle-outline");
		this.classList.add("mdi-play-circle-outline");
		this.dataset.audioStatus = "paused";

		audio.pause();
	}
}

function checkEmpty( container, elmClass) {

	let elements = container.getElementsByClassName( elmClass );
	let valid = true;

	for ( let i = 0; i < elements.length; i++ ) {

		if ( !elements[i].value ) {
			valid = false;
		}

	}

	return valid;
}

function createDateElm( id ) {

	let input = document.createElement("input");

	input.classList.add("form-control", "date", "d-inline-block", "ml-1", "js-date-search");
	input.id = id;
	input.dataset.toggle = "date-picker";
	input.dataset.cancelClass = "btn-secondary";
	input.style.height = "31.96px";
	input.style.width = "195px";
	input.placeholder = "Επιλέξτε ημερομηνίες...";

	return input;
}

function toggleState(data) {
	axios.patch('/courses/toggle-materials', {
		courseId,
		data
	})
	.then( (res) => {
		let materialCount = data.length;
		let status = data[0].status;
		let message = "";
		let icon = status == 1 ? "success" : "info";

		if ( materialCount == 1 ) {
			message = status == 1 ? "Ενεργοποιήθηκε" : "Απενεργοποιήθηκε";
		}
		else {
			message = status == 1 ? "Ενεργοποιήθηκαν" : "Απενεργοποιήθηκαν";
		}

		utilities.toastAlert( icon, message );
		courseMaterialsTable.ajax.reload( null, false);

	})
	.catch( (err) => {
		console.log(err);
		utilities.toastAlert( 'error', "Παρουσιάστηκε κάποιο πρόβλημα ..." );
	})
}

function startDate( input ) {

	let dateInput = input;

	if ( !dateInput || dateInput.value == "" ) {
		return "";
	}

	let dateInputValue = dateInput.value.split(" - ");
	let firstDate = dateInputValue[0].split("/").reverse().join("-");

	return firstDate;
}

function endDate( input ) {

	let dateInput = input;

	if ( !dateInput || dateInput.value == "" ) {
		return "";
	}

	let dateInputValue = dateInput.value.split(" - ");
	let secondDate = dateInputValue[1].split("/").reverse().join("-");

	return secondDate;
}

//!##########################################
//!				Initializations				#
//!##########################################

$("#topics-select").select2({
	closeOnSelect: false,
	placeholder: "Επιλέξτε Topics..."
})

$("#version-select").select2({
	minimumResultsForSearch: -1
})

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
		$('#gallery-content')[0].dataset.editorId = "#summary"
		$('#gallery-content')[0].dataset.type = "redactor"
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

// Create a plugin
ArticleEditor.add('plugin', 'mediaLibrary', {
    start: function() {
        this.app.addbar.add('mediaButton', {
            title: 'Media Library',
            icon: "<i class='mdi mdi-book-open-page-variant'></i>'",
            command: 'mediaLibrary.modal'
        });
    },
    modal: function(params, button) {
		this.app.popup.close();
		$('#gallery-content')[0].dataset.editorId = "#description"
		$('#gallery-content')[0].dataset.type = "article"
        $('#gallery-modal').modal('show')
    }
});

ArticleEditor('#description', {
	css: "/css/",
	custom: {
		css: [
			"/css/bootstrap.min.css",
			"/css/customArticleStyle.css",
		]
	},
	plugins: ['mediaLibrary', 'reorder'],
	classes: {
		img: 'img-fluid',
		p: 'text-wrap'
	},
	grid: {
		classname: 'row',
		columns: 12,
		gutter: '1px',
		offset: {
			left: '15px',
			right: '15px'
		},
		patterns: {
			'6|6': 'col-6|col-6',
			'4|4|4': 'col-4|col-4|col-4',
			'3|3|3|3': 'col-3|col-3|col-3|col-3',
			'2|2|2|2|2|2': 'col-2|col-2|col-2|col-2|col-2|col-2',
			'3|6|3': 'col-3|col-6|col-3',
			'2|8|2': 'col-2|col-8|col-2',
			'5|7': 'col-5|col-7',
			'7|5': 'col-7|col-5',
			'4|8': 'col-4|col-8',
			'8|4': 'col-8|col-4',
			'3|9': 'col-3|col-9',
			'9|3': 'col-9|col-3',
			'2|10': 'col-2|col-10',
			'10|2': 'col-10|col-2',
			'12': 'col-12'
		}
	},
	align: {
		left: "text-left",
		center: "text-center",
		right: "text-right",
	},
	editor: {
		minHeight: "300px"
	},
	image: {
		upload: "/media/upload-images",
		data: {
			"_token": $('meta[name="csrf-token"]').attr('content'),
			// "id": courseId,
			// namespace: "App\\Course"
		}
	}
});
FilePond.setOptions({
    name: 'file[]',
    allowMultiple: true,
});

FilePond.registerPlugin(FilePondPluginFileValidateType);

let dropzone = document.getElementById("file-pond");
const pond = FilePond.create( dropzone, {
	server: {
		url: baseUrl,
		process: {
			url: '/media/upload-images',
			headers: {
				"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
			},
			onload: function(data) {
				utilities.paginationRequest( 1, "" );
			}
		}
		
	},
	acceptedFileTypes: ['image/png', 'image/jpeg'],
} );

const courseFileUpload = $("#course-file-upload")[0];
const courseFilePond = FilePond.create(courseFileUpload, {
	name: "file",
    server: {
        url: baseUrl,
        process: {
            url: '/media/files-upload',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
			},

			onload: function(data) {

				let container = $("#files-cnt")
				container.html(data)

				let removeBtns = container.find(".js-remove-file");
				removeBtns.on("click", function() {
					removeFiles( [this.dataset.fileId] );
				});

				let audioPlayerBtns = container.find(".js-audio-btn");
				audioPlayerBtns.on("click", audioPlayerHandler)

				$("#remove-all-files-btn").removeClass("d-none");
				remainingFilesTable.ajax.reload(null, false);

			},
			ondata: function(formData) {
				formData.append("namespace", namespace);
				formData.append("id", courseId);
				return formData
			}
		},
	},
    onprocessfile: function (error, data) {

		// setTimeout(function() {
		// 	materialFilePond.removeFile(data.file);
		// }, 2000);

		$("#files-cnt").removeClass("d-none");
		$("#active-files-loading").addClass("d-none");
	},
	onprocessfileabort: function() {
		$("#files-cnt").removeClass("d-none");
		$("#active-files-loading").addClass("d-none");
	},
	onprocessfiles: function() {

		// let instance = materialFilePond.getFiles()

		// for (let i = 0; i < instance.length; i++ ) {

		// 	setTimeout(function() {
		// 		materialFilePond.removeFile(instance[i].file);

		// 	}, i * 1000);

		// }

	},
	oninitfile: function(file) {
		$("#files-cnt").addClass("d-none");
		$("#active-files-loading").removeClass("d-none");
	},
    acceptedFileTypes: [
		"application/octet-stream", "application/x-zip-compressed", "application/pdf",
		"application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
		"application/vnd.openxmlformats-officedocument.wordprocessingml.template", "application/vnd.ms-word.document.macroEnabled.12",
		"application/vnd.ms-word.template.macroEnabled.12", "application/vnd.ms-excel", "application/vnd.ms-excel", "application/vnd.ms-excel",
		"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/vnd.openxmlformats-officedocument.spreadsheetml.template",
		"application/vnd.ms-excel.sheet.macroEnabled.12", "application/vnd.ms-excel.template.macroEnabled.12",
		"application/vnd.ms-excel.addin.macroEnabled.12", "application/vnd.ms-excel.sheet.binary.macroEnabled.12",
		"application/vnd.ms-powerpoint", "application/vnd.openxmlformats-officedocument.presentationml.presentation",
		"application/vnd.openxmlformats-officedocument.presentationml.template", "application/vnd.openxmlformats-officedocument.presentationml.slideshow",
		"application/vnd.ms-powerpoint.addin.macroEnabled.12", "application/vnd.ms-powerpoint.presentation.macroEnabled.12",
		"application/vnd.ms-powerpoint.template.macroEnabled.12", "application/vnd.ms-powerpoint.slideshow.macroEnabled.12",
		"application/vnd.ms-access", "audio/mpeg", "application/vnd.oasis.opendocument.presentation",
		"application/vnd.oasis.opendocument.spreadsheet", "application/vnd.oasis.opendocument.text",
		"application/rtf", "application/vnd.oasis.opendocument.graphics"
	],
});