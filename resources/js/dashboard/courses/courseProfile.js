//! GLOBAL VARIABLES
//!============================================================
const courseId = $("#course-materials-list")[0].dataset.courseId

//!######################################
//! 				Imports				#
//!######################################
import utilities from '../main';
import Dropzone from "../../../plugins/dropzone/js/dropzone";
import ArticleEditor from "../../../plugins/article-editor/article-editor"

//! EventListerners
//!============================================================

$("#activate-selection").click( function() {
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

$("#deactivate-selection").click( function() {
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

$("#course-delete-btn").click( function() {
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

$("#add-user-checkbox").change( function() {
	let minorCheckboxes = $(".js-new-user-checkbox");
	let bulkBtn = $("#add-multiple-users-btn")[0]

	utilities.minorCheckboxSwitcher(this, minorCheckboxes, bulkBtn);
})

$("#select-all-active-users").change( function() {

	let minorCheckboxes = $(".js-active-user-checkbox")
	let bulkBtn = $("#active-users-bulk")[0]

	utilities.minorCheckboxSwitcher(this, minorCheckboxes, bulkBtn);
});

$("#update-btn").click( function() {
	$("#edit-course-form").submit();
});

$("#active-switch").change( function() {

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

$("#add-multiple-users-btn").click( function() {
	let newUsers = $(".js-new-user-checkbox:checked");
	let userIds = [];

	for ( let i = 0; i < newUsers.length; i++ ) {
		userIds.push( newUsers[i].dataset.userId );
	}

	addUsers(userIds);
	$('#add-user-modal').modal('hide')
})

$("#remove-selected-users-btn").click( function() {

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

})

$("#course-cover-input").change( function() {
	let label = $("#course-cover-label")[0];

	label.textContent = this.value.replace("C:\\fakepath\\", "");
});

$('#all-remainings-checkbox').change( function() {
	let checkboxes = $('.js-remainings-checkbox');
	let bulkBtn = $("#add-remaingings-btn")[0];

	utilities.minorCheckboxSwitcher( this, checkboxes, bulkBtn );

});

$('#add-remaingings-btn').click( function() {
	let checkboxes = $('.js-remainings-checkbox:checked');
	let lessonsCount = 0;
	let additionsCount = 0;
	let ids = [];

	if ( checkboxes.length == 0 ) {
		utilities.toastAlert( 'info', "Δεν υπάρχουν επιλεγμένα μαθήματα..." );
		return;
	}
	else {
		for ( let i = 0; i < checkboxes.length; i++) {
			ids.push(checkboxes[i].dataset.materialId);

			if ( checkboxes[i].dataset.materialType == "Lesson" ) {
				lessonsCount++
			}
			else {
				additionsCount++
			}
		}
		postMaterialIds( ids);
	}

	$('#add-materials-modal').modal('hide');
});

$('#remove-selection-btn').click( function() {
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

$("#all-active-materials-checkbox").change( function() {

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
		{ data: 'action', className: "position-relative align-middle", orderable: false },
		{ data: 'title', name: 'title' },
		{ data: 'status', name: 'pivot.status', className: "align-middle", },
		{ data: 'priority', name: 'pivot.priority', className: "align-middle",  width: "5%", searchable: false },
		{ data: 'type', name: 'type', className: "cursor-default align-middle" },
		{ data: 'updated_at', name: 'updated_at',  className: "cursor-default align-middle", searchable: false },
		{ data: 'created_at', name: 'created_at', className: "cursor-default align-middle", searchable: false },
		{ data: 'btns', className: "cursor-default align-middle", searchable: false, orderable: false },
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
		{data: 'action', width: "5%", orderable: false},
		{data: 'title', name: 'materials.title', className: "cursor-default"},
		{data: 'topics', name: 'topics.title', className: "cursor-default"},
		{data: 'type', name: 'materials.type', className: "cursor-default"},
		{data: 'addBtn', width: "12%", searchable: false, orderable: false},
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
		url: "/courses/course-students-datatable",
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

$("#active-user-roles").change( function () {

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

$("#add-users-roles").change( function () {

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

$("#active-course-status").change( function() {

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

	binBtn.click( function() {

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

	minorCheckboxes.change( function() {
		utilities.mainCheckboxSwitcher( mainCheckbox, minorCheckboxes, bulkBtn );
	});

}

function activeUsersCheckboxInit() {

	let mainCheckbox = $("#select-all-active-users")[0];
	let minorCheckboxes = $(".js-active-user-checkbox");
	let bulkBtn = $("#active-users-bulk")[0]

	minorCheckboxes.unbind();

	minorCheckboxes.change( function() {
		utilities.mainCheckboxSwitcher( mainCheckbox, minorCheckboxes, bulkBtn );
	});
}

function userLinkInit() {

	let link = $(".js-user-link");

	link.unbind();
	link.click( function() {

		let userSlug = this.parentElement.dataset.userSlug

		window.location = `/dashboard/users/${ userSlug }`;
	});
}

function removeUserBtnInit() {

	let removeUserBtn = $(".js-remove-user");

	removeUserBtn.unbind();
	removeUserBtn.click( function() {

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
	addUserBtn.click( function() {

		let userId = [ this.dataset.userId ];

		addUsers( userId );
	})
}

function addMaterialsEventListerner() {

	let addMaterialBtn = $('.js-add-material-btn');

	addMaterialBtn.unbind();
	addMaterialBtn.click( function() {
		const materialId = [this.dataset.materialId];

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
				courseMaterialsTable.ajax.reload();

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
	remainingCheckboxes.change( remainingMaterialsCheckboxHandler );
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

	activeCheckboxes.change( activeMaterialsCheckboxHandler );
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
		courseUsersDatatable.ajax.reload();
		addCourseUsersDatatable.ajax.reload();

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
		courseUsersDatatable.ajax.reload();
		addCourseUsersDatatable.ajax.reload();

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
		courseMaterialsTable.ajax.reload();
		remainingMaterialsTables.ajax.reload();

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
		courseMaterialsTable.ajax.reload();
		remainingMaterialsTables.ajax.reload();

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

		$("#selected-materials-types").change( function() {

			let label = $('#select2-selected-materials-types-container')[0];

			utilities.filterStyle( label, this.value )

			courseMaterialsTable.columns( 4 ).search( this.value ).draw();
		})

		$("#remaining-materials-types").select2({
			minimumResultsForSearch: -1,
		});

		$("#remaining-materials-types").change( function() {

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

$(".js-material").click( function() {
	let id = $("#store-material-id").val();
	let priority = $("#store-material-priority").val();
	let rows = $("#course-materials-list > tbody > tr");
	let type = this.dataset.type;
	let newRow = "";
	let rowId = "";

	console.log(id);
	console.log(priority);
	console.log(rows);
	console.log(type);

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

	return `<td class="text-left" colspan="7">
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
							<div class="invalid-feedback">
        						Παρακαλώ εισάγετε υπότιτλο.
							</div>
						</div>

					</div>
					<div class="form-row">
						<div class="form-group col-6">
							<label for="link-input">${ type }</label>
							<input type="text" id="link-input" class="js-empty js-link form-control" placeholder="Εισάγετε link..."/>
							<div class="invalid-feedback">
        						Παρακαλώ εισάγετε link.
							</div>
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

	return `<td class="text-left" colspan="7">
				<div id="additional-content-form">
					<h3 class="text-center font-20 line-height-05 b-block mb-3 underline">Προσθήκη Ανακοίνωσης</h3>
					<div class="form-row">
						<div class="form-group col-9">
							<label for="new-title">Τίτλος</label>
							<input type="text" id="new-title" class="js-empty js-title form-control" placeholder="Εισάγετε τίτλο..." />
							<div class="invalid-feedback">
        						Παρακαλώ εισάγετε τίτλο.
							</div>
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

			courseMaterialsTable.ajax.reload();
			utilities.toastAlert( "success", "Αποθηκεύτηκε" )
		})
		.catch( (err) => {
			utilities.toastAlert( "error", "Παρουσιάστηκε κάποιο πρόβλημα ...")
		});

}

function checkEmpty( container, elmClass) {

	let elements = container.getElementsByClassName( elmClass );
	let valid = true;

	for ( let i = 0; i < elements.length; i++ ) {

		if ( !elements[i].value ) {
			elements[i].classList.add("is-invalid");
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

$("#version-select").select2({
	minimumResultsForSearch: -1
})

$R("#summary", {
	buttons: [
		'html', 'undo', 'redo', 'format', 
		'bold', 'underline', 'italic', 'deleted',
		'sup', 'sub', 'lists', 'image', 'file', 'link'
	],
    style: false,
	minHeight: '150px',
	imageResizable: true,
	imagePosition: true,
	imagePosition : {
        "left": "text-left",
        "right": "text-right",
        "center": "text-center"
	},
	imageFloatMargin: '20px',
	imageUpload: "/courses/upload-images",
	imageData: {
		id: courseId
	},
	callbacks: {
        upload: {
            beforeSend: function(xhr)
            {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            }
        }
    }
});

ArticleEditor('#description', {
	css: "/css/",
	custom: {
		css: [
			"/css/bootstrap.min.css"
		]
	},
	classes: {
		img: 'img-fluid'
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
		upload: "/courses/upload-images",
		data: {
			"_token": $('meta[name="csrf-token"]').attr('content'),
			"id": courseId
		}
	}
});


let dropzone = new Dropzone("#cover-dropzone", {
	previewTemplate: $("#uploadPreviewTemplate").html(),
	autoProcessQueue: false,
	url: "/target-url",
  	thumbnailWidth: 80,
	thumbnailHeight: 80,
	/* init: function() {

		this.on("drop", function(event) {
	
			// let coverInput = $("#cover-input")[0];
		
			// coverInput.value = file;
			console.log(event);
		})

	}   */
});

// $("#cover-input").change( function() {
// 	console.log(this);
// })

dropzone.on("addedfile", function(file) {
	
	// let coverInput = $("#cover-input")[0];

	// coverInput.value = file;
	console.log(file);
})
