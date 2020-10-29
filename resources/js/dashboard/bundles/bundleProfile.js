//!######################################
//! 				Imports				#
//!######################################
import utilities from '../main';
import ArticleEditor from "../../../plugins/article-editor/article-editor"
require("../../../plugins/article-editor/plugins/reorder/reorder");

import * as FilePond from 'filepond';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import 'filepond/dist/filepond.min.css';

//!##############################################
//! 			GLOBAL VARIABLES				#
//!##############################################
const bundleId = $("#bundle-title")[0].dataset.bundleId;
const bundleSlug = $("#bundle-title")[0].dataset.bundleSlug;
const namespace = "App\\Bundle";
const baseUrl = window.location.origin;

//!##########################################
//! 			EventListerners				#
//!##########################################

$(".js-editors-toggle").on("change", function() {
	let editorToggles = $(".js-editors-toggle");
	let field = {};

	for ( let i = 0; i < editorToggles.length; i++) {

		field[`${editorToggles[i].dataset.field}`] = editorToggles[i].checked ? 1 : 0;
	}

	let fields = JSON.stringify(field);

	axios.patch(`/bundle/${bundleSlug}/toggle-editors`, {
		fields
	})
	.then( res => {
		let icon = this.checked ? "success" : "info";
		let message = this.checked ? "Ενεργοποιήθηκε" : "Απενεργοποιήθηκε";

		utilities.toastAlert( icon, message );
	})
	.catch( err => {
		console.log(err);
		utilities.toastAlert( "error", "Παρουσιάστηκε κάποιο πρόβλημα ..." );
	})

})

$("#remove-cover-btn").on("click", function() {
	
	axios.patch( "/media/remove-cover", {
		namespace,
		id: bundleId
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

$("#add-users-btn").on("click", function() {
	let pickedUsers = $(".js-remaining-user-checkbox:checked");
	let ids = [];

	for ( let i = 0; i < pickedUsers.length; i++ ) {
		ids.push( pickedUsers[i].dataset.userId );
	}

	addUserBundle( ids )
});

$("#remove-selected-users-btn").on("click", function() {

	let pickUsers = $(".js-active-user-checkbox:checked");
	let ids = [];

	for (var i = 0; i < pickUsers.length; i++) {
		ids.push(pickUsers[i].dataset.userId);
	}

	Swal.fire({
		title: "Είστε σίγουρος/η;",
		text: `Η ενέργεια θα αφαιρέσει ${i} απο τους χρήστες του Bundle.`,
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#536de6',
		confirmButtonText: 'Ναι, αφαίρεση!',
		cancelButtonText: 'Άκυρο'
	}).then( (result) => {
		if (result.isConfirmed) {
			removeUsers(ids);
		}
	})
	

});

$("#remaining-all-users-checkbox").on("click", function() {
	let minorCheckboxes = $(".js-remaining-user-checkbox");
	let bulk = $("#add-users-btn")[0];

	utilities.minorCheckboxSwitcher(this, minorCheckboxes, bulk);
});

$("#main-active-users-checkbox").on("change", function() {
	let minorCheckboxes = $(".js-active-user-checkbox");
	let bulk = $("#users-bulk")[0];

	utilities.minorCheckboxSwitcher( this, minorCheckboxes, bulk );
});

$("#change-cover-btn").on("click", function() {

	$("#gallery-content")[0].dataset.type = "cover";

	$("#gallery-modal").modal('show');
})

$("#image-search").on("input", utilities.searchHandler);

$(".js-gallery-page-btn").on( 'click', utilities.paginationHandler);

$(".js-add-image").on( "click", utilities.imageHandler);

$(".tab-link").on("show.bs.tab", function(event) {

	event.preventDefault();
	Swal.fire(
		'Προσοχή',
		'<p>Θα πρέπει να αποθηκεύσετε το Bundle</p>για να συνεχίσετε!',
		'info'
	);
})

$(".under-development").on( 'click', function() {
	Swal.fire({
        toast: 'true',
        position: 'top-end',
        icon: "info",
        title: "Under Development...",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
});

$("#bundle-delete-btn").on( "click", function() {
	Swal.fire({
		title: 'Είστε σίγουρος;',
		text: "Η ενέργεια θα είναι μη αναστρέψιμη!",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#ff5b5b',
		confirmButtonText: 'Ναι, διαγραφή!',
		cancelButtonText: 'Άκυρο'
	}).then( (result) => {

		if (result.value) {

			$("#delete-bundle-form").submit();

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
    },
});

publishDate.on( "apply.daterangepicker", function(event, picker) {

	let startDate = picker.startDate.format('DD-MM-YYYY H:mm');
	this.value = startDate;

});

publishDate.on( 'cancel.daterangepicker', function(event, picker) {
	this.value = "";
});

$('#main-active-courses-checkbox').on( "click", function() {
	let checkboxes = $('.js-course-checkbox');
	let bulkBtn = $("#courses-bulk")[0];

	utilities.minorCheckboxSwitcher( this, checkboxes, bulkBtn );
});

$('#all-courses-checkbox').on( "change", function() {
	let checkboxes = $('.js-remainings-checkbox');
	let bulkBtn = $("#add-courses-btn")[0];

	utilities.minorCheckboxSwitcher( this, checkboxes, bulkBtn );
});

$('#add-courses-btn').on( "click", function() {
	let checkboxes = $('.js-remainings-checkbox:checked');
	let ids = [];

	if ( checkboxes.length == 0 ) {
		utilities.toastAlert( 'info', "Δεν υπάρχουν επιλεγμένα μαθήματα..." );
		return;
	}
	else {
		for ( let i = 0; i < checkboxes.length; i++) {
			ids.push(checkboxes[i].dataset.courseId);
		}
		postCourseIds( ids );
		$("#remaining-courses-modal").modal("hide");
	}
});

$('#remove-selected-courses-btn').on( "click", function() {
	let checkboxes = $('.js-course-checkbox:checked');
	let ids = [];

	if ( checkboxes.length == 0 ) {

		utilities.toastAlert( 'info', "Δεν υπάρχουν επιλεγμένα μαθήματα..." );
		return;
	}
	else {
		for ( var i = 0; i < checkboxes.length; i++ ) {
			ids.push( checkboxes[i].dataset.courseId );
		}

		Swal.fire({
			title: "Είστε σίγουρος/η;",
			html: `<p class="mb-0">Η ενέργεια θα αφαιρέσει ${i} Course(s)</p>απο το Bundle.`,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#536de6',
			confirmButtonText: 'Ναι, αφαίρεση!',
			cancelButtonText: 'Άκυρο'
		}).then( (result) => {
			if (result.isConfirmed) {
				removeCourses(ids);
			}
		})
	}
});

//! EventListerners /end

//! Datatables
const bundleCoursesTable = $("#bundle-courses-list").DataTable({
	order: [3, "desc"],
	searchDelay: "1000",
	processing: true,
	serverSide: true,
	ajax: {
		url: "/bundles/bundle-courses-datatable",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		type: "post",
		data: function( d ) {
			return $.extend( {}, d, {
				bundleId: bundleId,
				startDate: utilities.startDate( $("#bundle-course-date-range")[0] ),
				endDate: utilities.endDate( $("#bundle-course-date-range")[0] )
			})
		}
	},
	columns: [
		{ data: 'action', name: 'action', className: "align-middle text-center", orderable: false, width: "5%" },
		{ data: 'title', name: 'title', className: "align-middle cursor-default" },
		{ data: 'curator', name: 'curator', className: "align-middle cursor-default" },
		{ data: 'topics', name: 'topics', className: "align-middle cursor-default" },
		{ data: 'version', name: 'version', className: "align-middle text-center cursor-default" },
		{
			data: 'updated_at',
			name: 'updated_at',
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
		{
			data: 'created_at',
			name: 'created_at',
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
		{ data: 'btns', className: "align-middle text-center", searchable: false, orderable: false }
	],
	language: utilities.tableLocale,
	fnInitComplete: function( oSettings, json ) {
		let lenthSelection = $("select[name='bundle-courses-list_length']");
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

		activeCoursesCheckboxToggle();
		removeCourseBtnInit();
		utilities.resetBulk(  $("#courses-bulk"), $("#main-active-courses-checkbox") );
	},

});

//!##########################################
//!				Datatable filters			#
//!##########################################

//* Append Course Materials Date Picker Filter
let bundleCourseSearchInput = $("#bundle-courses-list_filter > label > input")[0];
let bundleCourseDateInput = utilities.createDateElm( "bundle-course-date-range" );

bundleCourseDateInput.appendBefore( bundleCourseSearchInput );

//* Topic Filter
let courseLengthElm = $("#bundle-courses-list_length > label")[0];
let topicFIlter = $("#topic-filter")[0];

courseLengthElm.append(topicFIlter);

$("#topic-filter").select2({

});

$("#topic-filter").on( "change", function() {

	let label = $("#select2-topic-filter-container")[0];

	utilities.filterStyle( label, this.value );

	bundleCoursesTable.column(3).search( this.value ).draw();

});

//* Course type filter

let activeCoursesType = utilities.createCourseTypeSelect("active-course-type-slt");
courseLengthElm.append(activeCoursesType);

$("#active-course-type-slt").select2({
	minimumResultsForSearch: -1,
});

$("#active-course-type-slt").on( "change", function() {

	let label = $("#select2-active-course-type-slt-container")[0];
	utilities.filterStyle( label, this.value );

	bundleCoursesTable.column(4).search( this.value ).draw();

});

//! Event Initializers!
function removeCourseBtnInit() {

	$(".js-remove-course").on("click", function() {

		const id = this.dataset.courseId;

		Swal.fire({
			title: "Είστε σίγουρος/η;",
			text: `Η ενέργεια θα αφαιρέσει ένα απο τα Courses.`,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#536de6',
			confirmButtonText: 'Ναι, αφαίρεση!',
			cancelButtonText: 'Άκυρο'
		}).then( (result) => {
			if (result.isConfirmed) {
				removeCourses([id]);
			}
		})
	})
}

function activeCoursesCheckboxToggle() {

	let mainCheckbox = $('#main-active-courses-checkbox')[0];
	let minorCheckbox = $('.js-course-checkbox');
	let bulkBtn = $("#courses-bulk")[0];

	minorCheckbox.unbind();
	minorCheckbox.on( "change", function() {
		utilities.mainCheckboxSwitcher(mainCheckbox, minorCheckbox, bulkBtn);
	});
}


const bundleUsersTable = $("#bundle-users-table").DataTable({
	order: [1, "asc"],
	searchDelay: "1000",
	processing: true,
	serverSide: true,
	ajax: {
		url: "/bundles/bundle-users-datatable",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		type: "post",
		data: {
			id: bundleId
		}
	},
	columns: [
		{data: 'action', name:'action', orderable: false, searchable: false, className: "align-middle text-center"},
		{data: 'last_name', name: 'last_name', className: "align-middle cursor-default"},
		{data: 'email', name: 'email', className: "align-middle text-center cursor-default"},
		{data: 'phone', name: 'phone', className: "align-middle text-center cursor-default"},
		{data: 'btn', name: 'btn', orderable: false, searchable: false, className: "align-middle text-center"}
	],
	language: utilities.tableLocale,
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		$(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
		$(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");

		utilities.resetBulk(  $("#users-bulk"), $("#main-active-users-checkbox") );
		activeUsersCheckboxesInit();
		removeUserBinInit();
	},
})

//* Table eventlisteners init

function removeUserBinInit() {
	
	let bin = $(".js-remove-user");

	bin.off();
	bin.on("click", function() {

		Swal.fire({
			title: 'Είστε σίγουρος/η;',
			html: `<p class="mb-0">Η ενέργεια θα αφαιρέσει έναν απο</p>τους χρήστες του Bundle.`,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#536de6',
			confirmButtonText: 'Ναι, αφαίρεση!',
			cancelButtonText: 'Άκυρο'
		}).then( (result) => {
			if (result.value) {

				removeUsers([this.dataset.userId]);

			}
		})
	});
}

function activeUsersCheckboxesInit() {
	
	let minorCheckboxes = $(".js-active-user-checkbox")
	let mainCheckbox = $("#main-active-users-checkbox")[0];
	let bulk = $("#users-bulk")[0];

	minorCheckboxes.off();
	minorCheckboxes.on( "change", function() {
		utilities.mainCheckboxSwitcher( mainCheckbox, minorCheckboxes, bulk );
	});

}

const remainingCoursesTable = $("#remaining-courses-table").DataTable({
	order: [1, "asc"],
	searchDelay: "1000",
	processing: true,
	serverSide: true,
	ajax: {
		url: "/bundles/remaining-courses-datatable",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		type: "post",
		data: {
			bundleId: bundleId
		}
	},
	columns: [
		{data: 'action', name:'action', orderable: false, searchable: false, className: "align-middle text-center"},
		{data: 'title', name: 'title', className: "cursor-default"},
		{data: 'curator', name: 'curator', className: "align-middle text-center cursor-default"},
		{data: 'topics', name: 'topics', className: "align-middle cursor-default"},
		{data: 'version', name: 'version', className: "align-middle text-center cursor-default"},
		{data: 'addBtn', name: 'addBtn', orderable: false, searchable: false, className: "align-middle text-center"}
	],
	language: utilities.tableLocale,
	fnInitComplete: function( oSettings, json ) {
		let lenthSelection = $("select[name='remaining-courses-table_length']");
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

		addcourse();
		remainingsCheckboxes();
		utilities.resetAddButton(  $("#add-courses-btn"), $("#all-courses-checkbox") );
	},

});
//! DataTables /end

//! DataTables function / EventListener

function addcourse() {
	$('.js-add-course-btn').on( "click", function() {

		$('.js-add-course-btn').prop("disabled", true);

		const courseId = [this.dataset.courseId];

		postCourseIds( courseId );
	});
}

function remainingsCheckboxes() {

	let mainCheckbox = $('#all-courses-checkbox')[0];
	let minorCheckbox = $('.js-remainings-checkbox');
	let bulkBtn = $("#add-courses-btn")[0];

	minorCheckbox.unbind();
	minorCheckbox.on( "change", function() {
		utilities.mainCheckboxSwitcher(mainCheckbox, minorCheckbox, bulkBtn);
	});
}

// DataTables function / EventListener End

//!##################################################
//!					Add Courses Filters				#
//!##################################################

//* Topic Filter
let remainingCoursesLength = $("#remaining-courses-table_length > label")[0];
let addCourseTopicFilter = $("#add-course-topic-filter")[0];

remainingCoursesLength.append(addCourseTopicFilter);
$("#add-course-topic-filter").select2({

});

$("#add-course-topic-filter").on( "change", function() {

	let label = $("#select2-add-course-topic-filter-container")[0];

	utilities.filterStyle( label, this.value );

	remainingCoursesTable.column(3).search( this.value ).draw();

});

//* Course type filter

let addCoursesTypesFilter = utilities.createCourseTypeSelect("add-courses-type-filter");

remainingCoursesLength.append(addCoursesTypesFilter),

$("#add-courses-type-filter").select2({
	minimumResultsForSearch: -1,
});

$("#add-courses-type-filter").on( "change", function() {

	let label = $("#select2-add-courses-type-filter-container")[0];
	utilities.filterStyle( label, this.value );

	remainingCoursesTable.column(4).search( this.value ).draw();

});


function postCourseIds( courseIds ) {
	axios.patch( "/bundles/add-courses", {
		bundleId,
		courseIds
	})
	.then( (res) => {
		let message = courseIds.length == 1 ? "1 Course προστέθηκε" : `${courseIds.length} Course προστέθηκαν`;
		
		bundleCoursesTable.ajax.reload();
		remainingCoursesTable.ajax.reload();

		utilities.toastAlert( 'success', message );
	})
	.catch( (err) => {
		console.log(err);
		utilities.toastAlert( 'error', "Παρουσιάστηκε κάποιο πρόβλημα ..." );
	})
}

function removeCourses( courseIds ) {

	axios.patch( "/bundles/remove-courses", {
		bundleId,
		courseIds
	})
	.then( (res) => {

		let message = courseIds.length == 1 ? "1 Course Αφαιρέθηκε" : `${courseIds.length} Course αφαιρέθηκαν`;

		utilities.toastAlert( 'info', message );

		bundleCoursesTable.ajax.reload();
		remainingCoursesTable.ajax.reload();

		utilities.resetBulk(  $("#courses-bulk"), $("#main-active-courses-checkbox") );
	})
	.catch( (err) => {
		utilities.toastAlert( 'error', "Παρουσιάστηκε κάποιο πρόβλημα ..." );
	})
}

function removeUsers( users ) {
	axios.post("/bundles/remove-users", {
		bundleId,
		users
	})
	.then( res => {

		let count = users.length;
		let message = count == 1 ? `Ο χρήστης αφαιρέθηκε...` : `${count} χρήστες αφαιρέθηκαν...`;

		utilities.toastAlert("info", message);
		bundleUsersTable.ajax.reload();
		remainingUsersTable.ajax.reload();

	})
	.catch( err => {
		utilities.toastAlert( 'error', "Παρουσιάστηκε κάποιο πρόβλημα ..." );
	})
}

const remainingUsersTable = $("#remaining-users-table").DataTable({
	order: [1, "asc"],
	searchDelay: "1000",
	processing: true,
	serverSide: true,
	ajax: {
		url: "/bundles/remaining-users-datatable",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		type: "post",
		data: {
			bundleId: bundleId
		}
	},
	columns: [
		{data: 'action', name:'action', orderable: false, searchable: false, className: "align-middle text-center"},
		{data: 'last_name', name: 'last_name', className: "align-middle cursor-default"},
		{data: 'email', name: 'email', className: "align-middle text-center cursor-default"},
		{data: 'phone', name: 'phone', className: "align-middle text-center cursor-default"},
		{data: 'btn', name: 'btn', orderable: false, searchable: false, className: "align-middle text-center"}
	],
	language: utilities.tableLocale,
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		$(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
		$(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");

		addUserBtnInit();
		minorUsersCheckboxInit();
		utilities.resetAddButton(  $("#add-users-btn"), $("#remaining-all-users-checkbox") );
	},

});

function addUserBtnInit() {
	let addBtn = $(".js-add-user-btn");

	addBtn.on("click", function() {

		addBtn.prop("disabled", true);
		addUserBundle( [this.dataset.userId] );

	});
}

function minorUsersCheckboxInit() {

	let main = $("#remaining-all-users-checkbox")[0];
	let minors = $(".js-remaining-user-checkbox");
	let bulk = $("#add-users-btn")[0];

	minors.off();
	minors.on("change", function() {
		utilities.mainCheckboxSwitcher( main, minors, bulk );
	});

}

function addUserBundle( users ) {
	axios.post("/bundles/add-users", {
		bundleId,
		users
	})
	.then( res => {

		let count = users.length
		let message = count == 1 ? "Ένας χρήστης προστέθηκε." : `${count} χρήστες προστέθηκαν.`

		remainingUsersTable.ajax.reload();
		bundleUsersTable.ajax.reload();
		utilities.toastAlert( "success", message );

		if (count > 1) {
			$("#add-users").modal("hide");
		}
	})
	.catch( err => {
		
		utilities.toastAlert( 'error', "Παρουσιάστηκε κάποιο πρόβλημα ..." );
	})
}

//!##########################################
//!				Initializations				#
//!##########################################

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

dateRange.on( "input", function() {

	this.value = this.value.replace( /[^0-9]/g, "" )
		.replace(/^(\d{2})?(\d{2})?(\d{4})?(\d{2})?(\d{2})?(\d{4})?/g, '$1/$2/$3 - $4/$5/$6')
		.substr(0, 23)

});

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
	// 	id: bundleId,
	// 	namespace: "App\\Bundle"
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
			// "id": bundleId,
			// namespace: "App\\Bundle"
		}
	}
});

let dropzone = document.getElementById("file-pond");

FilePond.registerPlugin(FilePondPluginFileValidateType);
const pond = FilePond.create( dropzone, {
	name: 'file[]',
	labelIdle: "Drag & Drop your files or Browse",
	server: {
		url: baseUrl,
		process: {
			url: '/media/upload-images',
			headers: {
				"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
			}
		},
	},
	onprocessfiles: function(){
		
		utilities.paginationRequest( 1, "" );

	},
	allowMultiple: true,
	allowRemove: true,
	allowRevert: false,
	acceptedFileTypes: ['image/png', 'image/jpeg'],
	className: "js-filepond-file-dragging"
});

const dropArea = document.getElementsByClassName("js-filepond-file-dragging");

for ( let i = 0; i < dropArea.length; i++ ) {
	
	dropArea[i].addEventListener("dragover", function(event) {
		const draggingArea = this.getElementsByClassName("filepond--drop-label")[0];
		const label = draggingArea.querySelector("label");

		draggingArea.classList.add("limegreen");
		label.classList.add("text-limegreen");

	});
	
	dropArea[i].addEventListener("dragleave", function(event) {
		const draggingArea = this.getElementsByClassName("filepond--drop-label")[0];
		const label = draggingArea.querySelector("label");

		draggingArea.classList.remove("limegreen");
		label.classList.remove("text-limegreen");

	});

	dropArea[i].addEventListener("mouseleave", function(event) {
		const draggingArea = this.getElementsByClassName("filepond--drop-label")[0];
		const label = draggingArea.querySelector("label");

		draggingArea.classList.remove("limegreen");
		label.classList.remove("text-limegreen");

	});
}