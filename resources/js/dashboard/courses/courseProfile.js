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

$("#add-multiple-students-btn").click( function() {
	let newStudents = $(".js-new-user-checkbox:checked");
	let studentIds = [];

	for ( let i = 0; i < newStudents.length; i++ ) {
		studentIds.push( newStudents[i].dataset.userId );
	}

	addStudent(studentIds);
})

$("#remove-selected-students-btn").click( function() {

	let studentsCheckbox = $(".js-active-student-checkbox:checked");
	let studentIds = [];

	for ( let i = 0; i < studentsCheckbox.length; i++ ) {
		studentIds.push( studentsCheckbox[i].dataset.userId );
	}

	removeStudent(studentIds);
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
//! EventListerners /end

//! Datatables
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
		lengthMenu: 		"Αποτελέσματα ανα σελίδα: _MENU_",
		loadingRecords: 	"Φόρτωση ...",
		processing: 		"Επεξεργασία ...",
		search: 			"Αναζήτηση: ",
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
		setRows();
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
		lengthMenu: 		"Αποτελέσματα ανα σελίδα: _MENU_",
		loadingRecords: 	"Φόρτωση ...",
		processing: 		"Επεξεργασία ...",
		search: 			"Αναζήτηση: ",
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

const courseStudentsDatatable = $("#students-list").DataTable({
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
		{data: 'action', width: "5%", orderable: false, searchable: false},
		{data: 'first_name', name: 'first_name', className: "cursor-pointer js-student-link" },
		{data: 'last_name', name: 'last_name', className: "cursor-pointer js-student-link" },
		{data: 'btn', width: "5%", orderable: false, searchable: false },
	],
	language:{
		emptyTable: 		"Δεν υπάρχουν εγγραφές",
		info: 				"_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα",
		infoEmpty:      	"0 απο 0 τα 0 αποτελέσματα",
		lengthMenu: 		"Αποτελέσματα ανα σελίδα: _MENU_",
		loadingRecords: 	"Φόρτωση ...",
		processing: 		"Επεξεργασία ...",
		search: 			"Αναζήτηση: ",
		zeroRecords: 		"Δεν βρέθηκαν αποτελέσματα",
		paginate:{
			previous:"<i class='mdi mdi-chevron-left'>",
			next:"<i class='mdi mdi-chevron-right'>"}
	},
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		$(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
		$(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
		$(".js-remove-table-classes > thead > tr > th").removeClass("cursor-pointer js-student-link");
		$(".js-remove-table-classes > tfoot > tr > th").removeClass("cursor-pointer js-student-link");

		/* addMaterialsEventListerner();
		remainingsCheckboxes(); */
		removeStudentBtnInit();
		studentLinkInit();
	},
	
});

const addCourseStudentsDatatable = $("#add-students-list").DataTable({
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
		{data: 'first_name', name: 'first_name', className: "cursor-pointer js-student-link" },
		{data: 'last_name', name: 'last_name', className: "cursor-pointer js-student-link" },
		{data: 'addBtn', width: "5%", orderable: false, searchable: false },
	],
	language:{
		emptyTable: 		"Δεν υπάρχουν εγγραφές",
		info: 				"_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα",
		infoEmpty:      	"0 απο 0 τα 0 αποτελέσματα",
		lengthMenu: 		"Αποτελέσματα ανα σελίδα: _MENU_",
		loadingRecords: 	"Φόρτωση ...",
		processing: 		"Επεξεργασία ...",
		search: 			"Αναζήτηση: ",
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

		addStudentBtnInit();
		studentLinkInit();
	},
	
});
//! DataTables /end

//! DataTables function / EventListener

function studentLinkInit() {

	let link = $(".js-student-link");

	link.unbind();
	link.click( function() {

		let studentId = this.parentElement.dataset.studentId
		
		window.location = `/dashboard/users/${ studentId }`;
	});
}

function removeStudentBtnInit() {

	let removeStudentBtn = $(".js-remove-student");
	
	removeStudentBtn.unbind();
	removeStudentBtn.click( function() {
		
		let id = [ this.dataset.userId ];

		removeStudent( id ); 
	})
}

function addStudentBtnInit() {

	let addStudentBtn = $(".js-add-student-btn");
	
	addStudentBtn.unbind();
	addStudentBtn.click( function() {
		
		let userId = [ this.dataset.userId ];

		addStudent( userId );
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
// DataTables function / EventListener End

function jsLinkEventListener() {

	let links = $(".js-link");

	links.unbind();
	links.click( function() {
				
	let id = this.parentElement.dataset.materialId;

	window.location = `/dashboard/material/${id}`;
	});
}

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

function addStudent( studentIds ) {
	axios.patch( "/courses/add-students", {
		courseId,
		studentIds
	})
	.then( (res) => {

		let message = studentIds.length == 1 ? "Ένας μαθητής προστέθηκε" : `${studentIds.length} μαθητές προστέθηκαν`;
		utilities.toastAlert( 'success', message );
		courseStudentsDatatable.ajax.reload();
		addCourseStudentsDatatable.ajax.reload();

	})
	.catch( (err) => {
		console.log(err);
		utilities.toastAlert( 'error', "Παρουσιάστηκε κάποιο πρόβλημα ..." );

	})
}

function removeStudent( studentIds ) {
	axios.patch( "/courses/remove-students", {
		courseId,
		studentIds
	})
	.then( (res) => {

		let message = studentIds.length == 1 ? "Ένας μαθητής αφαιρέθηκε" : `${studentIds.length} μαθητές αφαιρέθηκαν`;
		utilities.toastAlert( 'success', message );
		courseStudentsDatatable.ajax.reload();
		addCourseStudentsDatatable.ajax.reload();

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

function setRows() {
	let materialRows = $("#course-materials-list > tbody > tr");
	
	for ( let i = 0; i < materialRows.length; i++ ) {
		
		let newRow = createRow();
		newRow.appendAfter(materialRows[i])

	}

}

function createRow() {

	let row = document.createElement("tr");
	row.classList.add("position-relative", "extra-content-row");

	row.innerHTML = `
					<td class='add-content-cell'>
						<button type="button" class="btn btn-primary btn-sm">
							<i class='mdi mdi-sticker-plus-outline mr-2'></i>
							Προσθήκη Υλικού
						</button>
					</td>
					`

	return row;
}