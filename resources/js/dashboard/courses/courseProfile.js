import utilities from '../main';

//! GLOBAL VARIABLES
//!============================================================
const courseId = $("#course-materials-list")[0].dataset.courseId
const totalLessons = $('#total-lessons')[0];
const totalAdditions = $('#total-additions')[0];
const updatedAt = $("#last-update-cnt")[0];

//! Prototype Additions
//!============================================================

Element.prototype.appendAfter = function (element) {

	element.parentNode.insertBefore(this, element.nextSibling);

},false;

//! EventListerners
//!============================================================

$("#add-multiple-users-btn").click( function() {
	let newUsers = $(".js-new-user-checkbox:checked");
	let userIds = [];

	for ( let i = 0; i < newUsers.length; i++ ) {
		userIds.push( newUsers[i].dataset.userId );
	}

	addUsers(userIds);
})

$("#remove-selected-users-btn").click( function() {

	let usersCheckbox = $(".js-active-user-checkbox:checked");
	let userIds = [];

	for ( let i = 0; i < usersCheckbox.length; i++ ) {
		userIds.push( usersCheckbox[i].dataset.userId );
	}

	removeUsers(userIds);
})

$("#course-cover-input").change( function() {
	let label = $("#course-cover-label")[0];

	label.textContent = this.value.replace("C:\\fakepath\\", "");
});

$('#all-remainings-checkbox').change( function() {
	let checkboxes = $('.js-remainings-checkbox')

	utilities.minorCheckboxSwitcher( this, checkboxes );

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
		postMaterialIds( ids, lessonsCount, additionsCount );
	}
});

$('#remove-selection-btn').click( function() {
	let checkboxes = $('.js-course-material-checkbox:checked');
	let lessonsCount = 0;
	let additionsCount = 0;
	let ids = []

	if ( checkboxes.length == 0 ) {

		utilities.toastAlert( 'info', "Δεν υπάρχουν επιλεγμένα μαθήματα..." );
		return;
	}
	else {
		for ( let i = 0; i < checkboxes.length; i++ ) {
			ids.push( checkboxes[i].dataset.materialId );

			if ( checkboxes[i].dataset.materialType == "Lesson" ) {
				lessonsCount++
			}
			else {
				additionsCount++
			}
		}
		removeMaterials(ids, lessonsCount, additionsCount);
	}
});

$("#all-active-materials-checkbox").change( function() {

	let checkboxes = $(".js-course-material-checkbox");

	utilities.minorCheckboxSwitcher( this, checkboxes )

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
		data: {
			courseId: courseId
		}
	},
	columns: [
		{ data: 'action', name: 'action', orderable: false },
		{ data: 'name', name: 'name', className: "js-link cursor-pointer" },
		{ data: 'active', name: 'active' },
		{ data: 'priority', name: 'priority',  width: "5%", searchable: false },
		{ data: 'type', name: 'type', className: "js-link cursor-pointer" },
		{ data: 'updated_at', name: 'updated_at',  className: "js-link cursor-pointer" },
		{ data: 'created_at', name: 'created_at', className: "js-link cursor-pointer" },
	],
	language:{
		emptyTable: 		"Δεν υπάρχουν εγγραφές",
		info: 				"_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα",
		infoEmpty:      	"0 απο 0 τα 0 αποτελέσματα",
		lengthMenu: 		"_MENU_",
		loadingRecords: 	"Φόρτωση ...",
		processing: 		"Επεξεργασία ...",
		search: 			"",
		searchPlaceholder: 	"Αναζήτηση... ",
		zeroRecords: 		"Δεν βρέθηκαν αποτελέσματα",
		paginate:{
			previous:"<i class='mdi mdi-chevron-left'>",
			next:"<i class='mdi mdi-chevron-right'>"}
	},
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		$(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
		$(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
		$(".js-remove-table-classes > thead > tr > th").removeClass("js-link cursor-pointer");

		jsLinkEventListener();
		activeMaterialsCheckboxToggle();
		toggleCourseMaterial()
		sortInputsInit();
		trHoverEffectInit();
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
		data: {
			courseId: courseId
		}
	},
	columns: [
		{data: 'action', width: "5%", orderable: false},
		{data: 'materialName', name: 'materials.name', className: "cursor-default"},
		{data: 'topicName', name: 'topics.name', className: "cursor-default"},
		{data: 'type', name: 'materials.type', className: "cursor-default"},
		{data: 'addBtn', width: "12%", searchable: false, orderable: false},
	],
	language:{
		emptyTable: 		"Δεν υπάρχουν εγγραφές",
		info: 				"_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα",
		infoEmpty:      	"0 απο 0 τα 0 αποτελέσματα",
		lengthMenu: 		"_MENU_",
		loadingRecords: 	"Φόρτωση ...",
		processing: 		"Επεξεργασία ...",
		search: 			"",
		searchPlaceholder: 	"Αναζήτηση... ",
		zeroRecords: 		"Δεν βρέθηκαν αποτελέσματα",
		paginate:{
			previous:"<i class='mdi mdi-chevron-left'>",
			next:"<i class='mdi mdi-chevron-right'>"}
	},
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		$(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
		$(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
		$(".js-remove-table-classes > thead > tr > th").removeClass("cursor-pointer");
		$(".js-remove-table-classes > tfoot > tr > th").removeClass("cursor-pointer");

		addMaterialsEventListerner();
		remainingsCheckboxes();
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
		{data: 'first_name', name: 'first_name', className: "cursor-pointer js-user-link" },
		{data: 'last_name', name: 'last_name', className: "cursor-pointer js-user-link" },
		{data: 'role', name: 'role', className: "cursor-pointer js-user-link" },
		{data: 'btn', width: "5%", orderable: false, searchable: false },
	],
	language:{
		emptyTable: 		"Δεν υπάρχουν εγγραφές",
		info: 				"_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα",
		infoEmpty:      	"0 απο 0 τα 0 αποτελέσματα",
		lengthMenu: 		"_MENU_",
		loadingRecords: 	"Φόρτωση ...",
		processing: 		"Επεξεργασία ...",
		search: 			"",
		searchPlaceholder: 	"Αναζήτηση... ",
		zeroRecords: 		"Δεν βρέθηκαν αποτελέσματα",
		paginate:{
			previous:"<i class='mdi mdi-chevron-left'>",
			next:"<i class='mdi mdi-chevron-right'>"}
	},
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		$(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
		$(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
		$(".js-remove-table-classes > thead > tr > th").removeClass("cursor-pointer js-user-link");
		$(".js-remove-table-classes > tfoot > tr > th").removeClass("cursor-pointer js-user-link");

		removeUserBtnInit();
		userLinkInit();
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
	language:{
		emptyTable: 		"Δεν υπάρχουν εγγραφές",
		info: 				"_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα",
		infoEmpty:      	"0 απο 0 τα 0 αποτελέσματα",
		lengthMenu: 		"_MENU_",
		loadingRecords: 	"Φόρτωση ...",
		processing: 		"Επεξεργασία ...",
		search: 			"",
		searchPlaceholder: 	"Αναζήτηση... ",
		zeroRecords: 		"Δεν βρέθηκαν αποτελέσματα",
		paginate:{
			previous:"<i class='mdi mdi-chevron-left'>",
			next:"<i class='mdi mdi-chevron-right'>"}
	},
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		$(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
		$(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
		$(".js-remove-table-classes > thead > tr > th").removeClass("cursor-pointer");
		$(".js-remove-table-classes > tfoot > tr > th").removeClass("cursor-pointer");

		adduserBtnInit();
		userLinkInit();
	},

});

//!######################################
//! 		Datatable Filters			#
//!######################################

//* active users table filters
let activeUserslistLength = $('#active-users-list_length > label');
let activeUsersFilter = createRoleSelect();

activeUserslistLength.append( activeUsersFilter );
activeUsersFilter.addEventListener('change', function () {
	
	courseUsersDatatable.columns(3).search( this.value ).draw();
	
});

//* add new users table filters
let addUsersListLength = $('#add-users-list_length > label');
let addUsersFilter = createRoleSelect();

addUsersListLength.append(addUsersFilter);

addUsersFilter.addEventListener('change', function () {
	
	addCourseUsersDatatable.columns(3).search( this.value ).draw();
	
});

//! DataTables function / EventListener

function createRoleSelect() {
	const selectElm = document.createElement("select");
	selectElm.classList.add("ml-1", "custom-select", "custom-select-sm", "form-control", "form-control-sm");

	selectElm.innerHTML = `
		<option value="">Όλες οι ιδιότητες</option>
		<option value="Εισηγητής">Εισηγητές</option>
		<option value="Μαθητής">Μαθητές</option>
	`;
	
	return selectElm;
}

function userLinkInit() {

	let link = $(".js-user-link");

	link.unbind();
	link.click( function() {

		let userId = this.parentElement.dataset.userId

		window.location = `/dashboard/users/${ userId }`;
	});
}

function removeUserBtnInit() {

	let removeUserBtn = $(".js-remove-user");

	removeUserBtn.unbind();
	removeUserBtn.click( function() {

		let id = [ this.dataset.userId ];

		removeUsers( id );
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
		const lessonsCount = this.dataset.materialType == "Lesson" ? 1 : 0;
		const additionsCount = this.dataset.materialType != "Lesson" ? 1 : 0;
		postMaterialIds( materialId, lessonsCount, additionsCount );
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
				updatedAt.textContent = "Μόλις τώρα";
			})
		}

	});
}

function toggleCourseMaterial() {
	$('.js-toggle').unbind();

	$('.js-toggle').on('change', function() {

		axios.patch('/courses/toggle-materials', {
			courseId: this.dataset.courseId,
			materialId: this.dataset.materialId,
			state: this.checked
		})
		.then( (res) => {
			let icon = this.checked ? "success" : "info";
			let message = this.checked ? "Ενεργοποιήθηκε" : "Απενεργοποιήθηκε";

			utilities.toastAlert( icon, message );
			updatedAt.textContent = "Μόλις τώρα";
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

function jsLinkEventListener() {
	
	let links = $(".js-link");
	
	links.unbind();
	links.click( function() {
		
		let id = this.parentElement.dataset.materialId;
		
		window.location = `/dashboard/material/${id}`;
	});
}

function trHoverEffectInit() {

	let row = $("#course-materials-list > tbody > tr");

	row.on( 'mouseover', function() {
		let previousSibling = this.previousSibling;
		if ( !previousSibling ) {
			return;
		}
		let plusIcon = previousSibling.querySelector(".add-material");

		plusIcon.style.display = "inline";
		plusIcon.style.color = "green";
	})
	row.on( 'mouseleave', function() {
		let previousSibling = this.previousSibling;

		if ( !previousSibling ) {
			return;
		}
		let plusIcon = previousSibling.querySelector(".add-material");

		plusIcon.style.display = "none";
	})

}
// DataTables function / EventListener End

function remainingMaterialsCheckboxHandler() {

	let mainCheckbox = $('#all-remainings-checkbox')[0];
	let checkbox = $('.js-remainings-checkbox');

	utilities.mainCheckboxSwitcher( mainCheckbox, checkbox );
}

function activeMaterialsCheckboxToggle() {

	let activeCheckboxes = $(".js-course-material-checkbox");

	activeCheckboxes.change( activeMaterialsCheckboxHandler );
}

function activeMaterialsCheckboxHandler() {

	let mainCheckbox = $('#all-active-materials-checkbox')[0];
	let checkbox = $('.js-course-material-checkbox');

	utilities.mainCheckboxSwitcher( mainCheckbox, checkbox);
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

	})
	.catch( (err) => {
		console.log(err);
		utilities.toastAlert( 'error', "Παρουσιάστηκε κάποιο πρόβλημα ..." );

	})
}

function removeUsers( userIds ) {
	axios.patch( "/courses/remove-students", {
		courseId,
		userIds
	})
	.then( (res) => {

		let message = userIds.length == 1 ? "Ένας χρήστης αφαιρέθηκε" : `${userIds.length} χρήστες αφαιρέθηκαν`;
		utilities.toastAlert( 'success', message );
		courseUsersDatatable.ajax.reload();
		addCourseUsersDatatable.ajax.reload();

	})
	.catch( (err) => {
		console.log(err);
		utilities.toastAlert( 'error', "Παρουσιάστηκε κάποιο πρόβλημα ..." );

	})
}

function postMaterialIds( materialId, lessonsCount, additionsCount ) {
	axios.post( "/courses/add-materials", {
		courseId,
		materialId
	})
	.then( (res) => {
		let message = materialId.length == 1 ? "1 αρχείο εντός ύλης" : `${materialId.length} αρχεία εντός ύλης`;

		utilities.toastAlert( 'success', message );
		courseMaterialsTable.ajax.reload();
		remainingMaterialsTables.ajax.reload();
		totalLessons.textContent = parseInt(totalLessons.textContent) + lessonsCount;
		totalAdditions.textContent = parseInt(totalAdditions.textContent) + additionsCount;
		updatedAt.textContent = "Μόλις τώρα";
	})
	.catch( (err) => {
		console.log(err);
		utilities.toastAlert( 'error', "Παρουσιάστηκε κάποιο πρόβλημα ..." );
	})
}

function removeMaterials( materialIds, lessonsCount, additionsCount ) {

	axios.patch( "/courses/remove-materials", {
		courseId,
		materialIds
	})
	.then( (res) => {

		let message = materialIds.length == 1 ? "1 αρχείο εκτός ύλης" : `${materialIds.length} αρχεία εκτός ύλης`;

		utilities.toastAlert( 'success', message );
		courseMaterialsTable.ajax.reload();
		remainingMaterialsTables.ajax.reload();
		totalLessons.textContent = parseInt(totalLessons.textContent) - lessonsCount;
		totalAdditions.textContent = parseInt(totalAdditions.textContent) - additionsCount;
		updatedAt.textContent = "Μόλις τώρα";
	})
	.catch( (err) => {
		utilities.toastAlert( 'error', "Παρουσιάστηκε κάποιο πρόβλημα ..." );
	})
}
