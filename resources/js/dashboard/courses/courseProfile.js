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
		{ data: 'title', name: 'title', className: "js-link cursor-pointer" },
		{ data: 'active', name: 'course_material.active' },
		{ data: 'priority', name: 'priority',  width: "5%", searchable: false },
		{ data: 'type', name: 'type', className: "js-link cursor-pointer" },
		{ data: 'updated_at', name: 'updated_at',  className: "js-link cursor-pointer" },
		{ data: 'created_at', name: 'created_at', className: "js-link cursor-pointer" },
	],
	language: utilities.tableLocale,
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		$(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
		$(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
		$(".js-remove-table-classes > thead > tr > th").removeClass("js-link cursor-pointer");

		jsLinkEventListener();
		activeMaterialsCheckboxToggle();
		toggleCourseMaterial()
		sortInputsInit();
		// trHoverEffectInit();
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
		{data: 'materialName', name: 'materials.title', className: "cursor-default"},
		{data: 'topicName', name: 'topics.name', className: "cursor-default"},
		{data: 'type', name: 'materials.type', className: "cursor-default"},
		{data: 'addBtn', width: "12%", searchable: false, orderable: false},
	],
	language: utilities.tableLocale,
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
	language: utilities.tableLocale,
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
	language: utilities.tableLocale,
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

//* Active Materials filters
const courseMaterialListLength = $("#course-materials-list_length");
let courseMaterialState = createStateSelect();

courseMaterialListLength.append( courseMaterialState );
courseMaterialState.addEventListener( "change", function() {

	courseMaterialsTable.columns( 2 ).search( this.value ).draw();

});

//! DataTables function / EventListener

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

//* emfanizi sto hover to pano + apo ka8e row
function trHoverEffectInit() {

	let row = $("#course-materials-list > tbody > tr");

	// row.unbind();

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

function createStateSelect() {
	const selectElm = document.createElement("select");
	selectElm.classList.add("ml-1", "custom-select", "custom-select-sm", "form-control", "form-control-sm");

	selectElm.innerHTML = `
		<option value="">Όλες οι Καταστάσεις</option>
		<option value="1">Ενεργά</option>
		<option value="0">Ανενεργά</option>
	`;
	
	return selectElm;
}

axios.post("/materials/material-types")
	.then( (res) => {
		createTopicSelect( res );
	})
	.catch( (err) => {
		console.log(err);
	})

function createTopicSelect( res ) {
	const selectElm = document.createElement("select");
	let data = res.data;
	let options = "<option value=''>Όλοι οι τύποι</option>";

	selectElm.classList.add("ml-1", "custom-select", "custom-select-sm", "form-control", "form-control-sm");

	for ( let i = 0; i < data.length; i++ ) {
		options += `<option value="${data[i].type}">${data[i].type}</option>`;
	}

	selectElm.innerHTML = options;

	courseMaterialListLength.append( selectElm );

	selectElm.addEventListener('change', function() {

		courseMaterialsTable.columns( 4 ).search( this.value ).draw();

	})
}

$("#add-material-modal").on("show.bs.modal", function(event) {
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

	for ( let i = 0; i < rows.length; i++ ) {
		rowId = rows[i].dataset.materialId;

		if ( id == rowId ) {
			newRow = createTableRow( type, priority );
			newRow.appendAfter( rows[i] );
		}
	}

	$('#add-material-modal').modal('hide')

});

function linkFormContent( type, priority) {

	return `<td class="text-left" colspan="7">
				<div id="additional-content-form">
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
					<div class="form-row">
						<div class="form-group col-9">
							<label for="new-subtitle">Ανακοίνωση</label>
							<input type="text" id="new-subtitle" class="js-empty js-subtitle form-control" placeholder="Εισάγετε ανακοίνωση..."/>
							<div class="invalid-feedback">
        						Παρακαλώ εισάγετε τίτλο.
							</div>
						</div>
						<div class="form-group col-3 d-flex justify-content-center align-items-start" style="padding-top: 1.85rem;">
							<button  class="js-add-content btn btn-primary" data-type="Annoucement" data-priority="${ priority }">Αποθήκευση</button>
							<button  class="js-cancel-addition btn btn-secondary ml-2">Άκυρο</button>
						</div>
					</div>
				</div>
			</td>`
}


function createTableRow( type, priority ) {
	let rowElm = document.createElement("tr");

	rowElm.innerHTML = type == "Annoucement" ? annoucementForm( priority ) : linkFormContent( type, priority)

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