//! GLOBAL VARIABLES
//!============================================================
const courseId = $("#course-materials-list")[0].dataset.courseId
const namespace = "App\\Course";
const courseSlug = $("#course-materials-list")[0].dataset.courseSlug
const baseUrl = window.location.origin;

let timer = 0;

//!######################################
//! 				Imports				#
//!######################################
import utilities from '../main';
import ArticleEditor from "../../../plugins/article-editor/article-editor"
require("../../../plugins/article-editor/plugins/reorder/reorder");

import * as FilePond from 'filepond';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import 'filepond/dist/filepond.min.css';

import CodeMirror from "codemirror/lib/codemirror";
require("codemirror/mode/htmlmixed/htmlmixed");
require("codemirror/addon/display/autorefresh");
import "codemirror/lib/codemirror.css";
import "codemirror/theme/night.css";

const beautify_html = require('js-beautify').html

//!##########################################
//! 			EventListerners				#
//!##########################################

$("#new-content-btn").on("click", function() {
	const rows = $("#course-materials-list > tbody > tr");
	const firstRowPriority = rows[0].dataset.priority;
	const priorityInput = $("#store-material-priority");

	$("#add-additions-modal").modal("show");

	if ( typeof firstRowPriority === "undefined" ) {
		priorityInput.val(0);
	}
	else {
		priorityInput.val(rows[rows.length - 1].dataset.priority);
	}

	$("#store-material-id").val(0);

})

$("#section-new-pdf-material").on("click", function() {

	const modal = $("#sections-additions-modal")[0];
	const sectionSlug = modal.dataset.sectionSlug;
	const priority = modal.dataset.priority;

	window.location = `/dashboard/create-pdf/${courseSlug}/${priority}/${sectionSlug}`;
})

$("#section-chapter-btn").on("click", function() {

	const modal = $("#sections-additions-modal")[0];
	const sectionId = modal.dataset.sectionId;
	const priority = modal.dataset.priority;

	window.location = `/dashboard/materials/create/${courseSlug}/${priority}/${sectionId}`;

})

$(".js-section-material").on("click", function() {

	const modal = $("#sections-additions-modal")[0];
	const sectionId = modal.dataset.sectionId;
	const priority = modal.dataset.priority;
	const type = this.dataset.type;
	
	const row = $(`table[data-section-id='${sectionId}'] > tbody > tr[data-priority='${priority}']`)[0];
	const newRow = createTableRow(type, priority);

	newRow.appendAfter(row);
	sectionAdditionEventInit(newRow, sectionId);

	if ( type == "Announcement" ) {
		$R('#new-announcement', utilities.redactorConfig );
	}

	$("#sections-additions-modal").modal("hide");

	let statusElm = newRow.getElementsByClassName("select2")[0];
	$(statusElm).select2({
		minimumResultsForSearch: -1,
	});

})

$("#sections-additions-modal").on("show.bs.modal", function(event) {

	const btn = event.relatedTarget;
	const sectionId = btn.dataset.sectionId;
	const sectionSlug = btn.dataset.sectionSlug;
	const priority = btn.dataset.priority;

	this.dataset.sectionId = sectionId;
	this.dataset.sectionSlug = sectionSlug;
	this.dataset.priority = priority;

});


$(".js-editors-toggle").on("change", function() {
	let editorToggles = $(".js-editors-toggle");
	let field = {};

	for ( let i = 0; i < editorToggles.length; i++) {

		field[`${editorToggles[i].dataset.field}`] = editorToggles[i].checked ? 1 : 0;
	}

	let fields = JSON.stringify(field);

	axios.patch(`/course/${courseSlug}/toggle-editors`, {
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

$("#add-materials-modal").on("show.bs.modal", function(event) {
	let button = $(event.relatedTarget);
	let chapter = button.data("chapter");
	let modal = $("#add-materials-modal")[0];

	modal.dataset.chapter = chapter;
})

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
		confirmButtonColor: '#536de6',
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
	const priority = $("#store-material-priority").val();

	window.location = `/dashboard/materials/create/${courseSlug}/${priority}`;
})

$("#add-new-pdf-material-main").on("click", function() {
	const priority = $("#store-material-priority").val();
	
	window.location = `/dashboard/create-pdf/${courseSlug}/${priority}`;
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
		confirmButtonColor: '#536de6',
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
		confirmButtonColor: '#536de6',
		confirmButtonText: 'Ναι, απενεργοποίηση!',
		cancelButtonText: 'Άκυρο'
	}).then( (result) => {

		if (result.isConfirmed) {

			toggleState( data );

		}
	})

});

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
		confirmButtonColor: '#536de6',
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
	let chapterId = document.getElementById("add-materials-modal").dataset.chapter;
	let ids = [];

	if ( checkboxes.length == 0 ) {
		utilities.toastAlert( 'info', "Δεν υπάρχουν επιλεγμένα μαθήματα..." );
		return;
	}
	else {
		for ( let i = 0; i < checkboxes.length; i++ ) {
			ids.push(checkboxes[i].dataset.materialId);
		}

		if ( chapterId == "main" ) {
			addCourseMaterials( ids );
		}
		else {
			addChapterMaterials( chapterId, ids );
		}
	}

	$('#add-materials-modal').modal('hide');
});

$('#remove-selection-btn').on( "click", function() {
	let checkboxes = $('.js-course-material-checkbox:checked');
	let materials = [];

	if ( checkboxes.length == 0 ) {

		utilities.toastAlert( 'info', "Δεν υπάρχουν επιλεγμένα μαθήματα..." );
		return;
	}
	else {
		for ( var i = 0; i < checkboxes.length; i++ ) {
			materials.push( checkboxes[i].dataset.materialId );
		}

		Swal.fire({
			title: 'Είστε σίγουρος/η;',
			html: `<p class="mb-0">Η ενέργεια θα αφαιρέσει ${i} απο</p>τα περιεχόμενα του Course.`,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#536de6',
			confirmButtonText: 'Ναι, αφαίρεση!',
			cancelButtonText: 'Άκυρο'
		}).then( (result) => {
			if (result.value) {

				removeMaterials( materials );

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
	order: [4, "asc"],
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
		{ data: 'highlight', name: 'pivot.highlight', className: "text-center align-middle", },
		{ data: 'status', name: 'pivot.status', className: "text-center align-middle", },
		{ data: 'priority', name: 'pivot.priority', className: "align-middle",  width: "5%", searchable: false },
		{ data: 'type', name: 'type', className: "cursor-default text-center align-middle" },
		{
			data: 'updated_at',name: 'updated_at',
			className: "cursor-default text-center align-middle", searchable: false,
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
			data: 'created_at', name: 'created_at',
			className: "cursor-default text-center align-middle", searchable: false,
			render: function(data) {
				let date = new Date(data);
				let day = date.toLocaleDateString().replace( /[/]/g, "-");
				let hours = `${date.getHours()}`.padStart(2, "0");
				let minutes = `${date.getMinutes()}`.padStart(2, "0");

				let time = `${hours}:${minutes}`;
				return `<p class="mb-0">${day}</p><p class="mb-0">${time}</p>`;
			}
		},
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
		highlightCheckboxInit();
		toggleCourseMaterial();
		sortInputsInit();
		removeMaterialInit();
		editChapterBtnInit();
		chapterInputInit();
		chapterSubmitBtnInit();
		removeMaterialSectionBtnInit();
		setShownSlugInit();
		sectionDotsBehaviorInit();
		multipleChapterRemoveInit();
		chapterCheckInit();
		sectionCheckInit();
		chapterStatusInit();
		chapterPriorityInit();
		multipleChapterActivateInit();
		multipleChapterDeactivateInit();
		showSectionBtnInit();
		sectionMaterialHighlightInit();
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
		{data: 'action', className: "text-center", orderable: false},
		{data: 'title', name: 'title', className: "cursor-default"},
		{data: 'type', name: 'type', className: "text-center cursor-default"},
		{data: 'addBtn', class: "text-center", searchable: false, orderable: false},
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
	order: [1, "asc"],
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
		{data: 'action', width: "5%", className: "text-center align-middle", orderable: false, searchable: false},
		{data: 'last_name', name: 'last_name', className: "text-left align-middle cursor-default" },
		// {data: 'first_name', name: 'first_name', className: "text-left cursor-default" },
		{data: 'email', name: 'email', className: "text-left align-middle cursor-default" },
		{data: 'phone', name: 'phone', className: "align-middle cursor-default" },
		{data: 'role', name: 'role', className: "cursor-default align-middle" },
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
	order: [1, "asc"],
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
		{data: 'last_name', name: 'last_name', className: "text-left cursor-pointer js-user-link" },
		// {data: 'first_name', name: 'first_name', className: "text-left cursor-pointer js-user-link" },
		{data: 'email', name: 'email', className: "text-left cursor-pointer js-user-link" },
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
        {data: "size", name: "size", className:"text-center align-middle"},
        {data: "action", className:"text-center", searchable: false, orderable: false},
    ],
    language: utilities.tableLocale,
    drawCallback: function () {
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");

		addFilesBtnInit();
    }
})

function sectionMaterialHighlightInit() {

	$(".js-chapter-material-highlight").on("change", function() {
		const sectionId = this.dataset.sectionId;
		const materialId = this.dataset.materialId;
		const status = this.checked ? 1 : 0;

		sectionMaterialHightlightToggle(sectionId, [materialId], status);
	})
}

function showSectionBtnInit() {

	$(".js-section").on("click", function() {
		$("#sections-tab-btn").tab("show");
		$(`#${this.dataset.slug}-collapse`).collapse("show");
	})
}

function multipleChapterDeactivateInit() {
	// deactivate-chapters

	$(".deactivate-chapters").on( 'click', function() {
		let mainCnt = this.findParent(7);
		let sectionId = this.dataset.sectionId;
		let checkedboxes = mainCnt.querySelectorAll(".js-chapter-checkbox:checked");
		let data = [];

		checkedboxes.forEach( checkbox => {
			data.push({
				id: checkbox.dataset.materialId,
				status: 0
			})
		});

		Swal.fire({
			title: 'Απενεργοποίηση;',
			html: `<p class='mb-0'>Η ενέργεια θα απενεργοποιήσει ${checkedboxes.length}</p>απο τα μαθήματα του Course.`,
			icon: 'info',
			showCancelButton: true,
			confirmButtonColor: '#536de6',
			confirmButtonText: 'Ναι, απενεργοποιήση!',
			cancelButtonText: 'Άκυρο'
		}).then( (result) => {

			if (result.isConfirmed) {

				toggleChapters( sectionId, data, mainCnt, checkedboxes )

			}
		})

	});

}

function multipleChapterActivateInit() {
	$(".activate-chapters").on( 'click', function() {
		let mainCnt = this.findParent(7);
		let sectionId = this.dataset.sectionId;
		let checkedboxes = mainCnt.querySelectorAll(".js-chapter-checkbox:checked");
		let data = [];

		checkedboxes.forEach( checkbox => {
			data.push({
				id: checkbox.dataset.materialId,
				status: 1
			})
		});

		Swal.fire({
			title: 'Ενεργοποίηση;',
			html: `<p class='mb-0'>Η ενέργεια θα ενεργοποιήσει ${checkedboxes.length}</p>απο τα μαθήματα του Course.`,
			icon: 'info',
			showCancelButton: true,
			confirmButtonColor: '#536de6',
			confirmButtonText: 'Ναι, ενεργοποίηση!',
			cancelButtonText: 'Άκυρο'
		}).then( (result) => {

			if (result.isConfirmed) {

				toggleChapters( sectionId, data, mainCnt, checkedboxes )

			}
		})

	});
}

function chapterPriorityInit() {

	$(".js-chapter-priority").on("input", function() {
		let inputValue = this.value;

		if ( isNaN( inputValue ) || inputValue < 0 ) {
			return this.value = inputValue.replace(/[^0-9]/g, '');
		}
	});

	$('.js-chapter-priority').on('keyup', function() {

		if ( event.keyCode == 13 && !isNaN( this.value) ) {

			let sectionId = this.dataset.sectionId;

			axios.patch(`/section/chapters-priority`, {
				courseId, sectionId,
				materialId: this.dataset.materialId,
				priority: {
					new: this.value,
					old: this.dataset.currentPriority
				},
			})
			.then( (res) => {
				let sectionsCnt = document.getElementsByClassName("accordion")[0];
				sectionsCnt.innerHTML = res.data;

				let sections = sectionsCnt.getElementsByClassName("collapse");
				for (let i = 0; i < sections.length; i++ ) {
					sections[i].classList.remove("show");
				}

				let shownChapter = sectionsCnt.dataset.shownChapter;
				if ( typeof shownChapter !== "undefined" ) {
					document.getElementById(`${shownChapter}-collapse`).classList.add("show");
				}
				else {
					sectionsCnt.getElementsByClassName("collapse")[0].classList.add("show");
				}

				courseMaterialsTable.ajax.reload( null, false );
			})

			$('.js-chapter-priority').prop("disabled", true);
		}

	});
}

function chapterStatusInit() {

	$(".js-chapter-toggle").on("change", function() {

		let sectionId = this.dataset.sectionId;

		axios.patch(`/section/toggle-chapters`, {
			courseId, sectionId,
			data: [{
				id: this.dataset.materialId,
				status: this.checked ? 1 : 0
			}],
		})
		.then( res => {
			let icon = this.checked ? "success" : "info";
			let message = this.checked ? "Ενεργοποιήθηκε" : "Απενεργοποιήθηκε";

			utilities.toastAlert( icon, message );
		})
		.catch( err => {
			console.log(err);
			utilities.toastAlert( 'error', "Παρουσιάστηκε κάποιο πρόβλημα ..." );
		})
	});

}

function sectionCheckInit() {

	$(".js-section-main-checkbox").on("change", function() {
		let mainCnt = this.findParent(8);
		let minorCheck = mainCnt.querySelectorAll(".js-chapter-checkbox");
		let removeBtn = mainCnt.getElementsByClassName("js-multiple-chapter-remove")[0];
		let statusMenu = mainCnt.getElementsByClassName("js-chapters-status")[0];
		let counter = 0;

		if ( this.checked && minorCheck.length > 0 ) {
			minorCheck.forEach( checkbox => {
				checkbox.checked = true;
			});
			counter = minorCheck.length;
		}
		else {
			minorCheck.forEach( checkbox => {
				checkbox.checked = false;
			});
		}

		removeBtn.textContent = `Αφαίρεση επιλεγμένων (${counter})`;
		statusMenu.textContent = `Αλλαγή κατάστασης (${counter})`;
	})
}

function chapterCheckInit() {

	$(".js-chapter-checkbox").on("change", function() {

		let mainCnt = this.findParent(8);
		let checked = mainCnt.querySelectorAll(".js-chapter-checkbox");
		let mainCheckbox = mainCnt.getElementsByClassName("js-section-main-checkbox")[0];
		let removeBtn = mainCnt.getElementsByClassName("js-multiple-chapter-remove")[0];
		let statusMenu = mainCnt.getElementsByClassName("js-chapters-status")[0];
		let counter = 0;

		checked.forEach( checkbox => {
			if (checkbox.checked) {
				counter++;
			}
		});

		if ( counter == checked.length) {
			mainCheckbox.checked = true;
		}
		else {
			mainCheckbox.checked = false;
		}

		removeBtn.textContent = `Αφαίρεση επιλεγμένων (${counter})`;
		statusMenu.textContent = `Αλλαγή κατάστασης (${counter})`;
	});
}

function multipleChapterRemoveInit() {

	$(".js-multiple-chapter-remove").on("click", function() {

		let mainCnt = this.findParent(5);
		let sectionId = mainCnt.getElementsByClassName("table")[0].dataset.sectionId;
		let checked = mainCnt.querySelectorAll(".js-chapter-checkbox:checked");
		let ids = [];

		checked.forEach( checked => {
			ids.push(checked.dataset.materialId)
		});

		Swal.fire({
			title: 'Είστε σίγουρος/η;',
			html: `<p class="mb-0">Η ενέργεια θα αφαιρέσει ${ids.length} απο</p>τα περιεχόμενα του Course.`,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#536de6',
			confirmButtonText: 'Ναι, αφαίρεση!',
			cancelButtonText: 'Άκυρο'
		}).then( (result) => {
			if (result.isConfirmed) {

				removeChapters(sectionId, ids);

			}
		})
	})
}

function sectionDotsBehaviorInit() {

	$(".js-section-dots").on("click", function() {

		let parent = this.findParent(4);
		let collapseBtn = parent.getElementsByClassName("collapse")[0];

		$(collapseBtn).collapse("show");

	});

}

function setShownSlugInit() {

	$(".js-chapter-title").on("click", function() {

		let slug = this.dataset.materialSlug;

		$("#section-accordion")[0].dataset.shownChapter = slug;
	})
}

function removeMaterialSectionBtnInit() {

	let btn = $(".js-remove-chapter");

	btn.on("click", function() {

		let sectionId = this.findParent(4).dataset.sectionId;
		let id = [this.dataset.materialId];

		Swal.fire({
			title: "Είστε σίγουρος/η;",
			text: 'Το υλικό θα αφαιρεθεί απο το Course.',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#536de6',
			confirmButtonText: 'Ναι, αφαίρεση!',
			cancelButtonText: 'Άκυρο'
		}).then( (result) => {

			if (result.isConfirmed) {

				removeChapters(sectionId, id);

			}
		})
	})
}

function chapterSubmitBtnInit() {

	let submitBtn = $(".js-sumbit-chapter-title-btn");
	let cancelbtn = $(".js-cancel-chapter-title-btn")

	submitBtn.on("click", submitChapterBtnHandler);
	cancelbtn.on("click", editChapterOnBlurHandler )
}

function chapterInputInit() {

	$(".js-chapter-input").on("keyup", editChapterOnKeyupHandler)

}

function editChapterBtnInit() {

	let btn = $(".js-edit-chapter-btn");

	btn.on("click", editChapterBtnHandler);
}

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

	courseUsersDatatable.columns(4).search( this.value ).draw();

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
	addCourseUsersDatatable.columns(4).search( this.value ).draw();

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

	binBtn.on( "click", removeMaterialHandler);
}

function newUserCheckboxInit() {

	let mainCheckbox = $("#add-user-checkbox")[0];
	let minorCheckboxes = $(".js-new-user-checkbox");
	let bulkBtn = $("#add-multiple-users-btn")[0]

	minorCheckboxes.on( "change", function() {
		utilities.mainCheckboxSwitcher( mainCheckbox, minorCheckboxes, bulkBtn );
	});

}

function activeUsersCheckboxInit() {

	let mainCheckbox = $("#select-all-active-users")[0];
	let minorCheckboxes = $(".js-active-user-checkbox");
	let bulkBtn = $("#active-users-bulk")[0]

	minorCheckboxes.on( "change", function() {
		utilities.mainCheckboxSwitcher( mainCheckbox, minorCheckboxes, bulkBtn );
	});
}

function userLinkInit() {

	let link = $(".js-user-link");

	link.on( "click", function() {

		let userSlug = this.parentElement.dataset.userSlug

		window.location = `/dashboard/users/${ userSlug }`;
	});
}

function removeUserBtnInit() {

	let removeUserBtn = $(".js-remove-user");

	removeUserBtn.on( "click", function() {

		let id = [ this.dataset.userId ];

		Swal.fire({
			title: 'Είστε σίγουρος/η;',
			html: "<p class='mb-0'>Η ενέργεια θα αφαιρέσει έναν</p>απο τους χρήστες του Course.",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#536de6',
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

	addUserBtn.on( "click", function() {

		let userId = [ this.dataset.userId ];

		addUsers( userId );
	})
}

function addMaterialsEventListerner() {

	let addMaterialBtn = $('.js-add-material-btn');

	addMaterialBtn.on( "click", function() {
		let chapterId = document.getElementById("add-materials-modal").dataset.chapter;
		let materialId = [this.dataset.materialId];

		for (let i = 0; i < addMaterialBtn.length; i++) {
			addMaterialBtn[i].disabled = true;
		}

		if ( chapterId == "main" ) {
			addCourseMaterials( materialId );
		}
		else {
			addChapterMaterials( chapterId, materialId );
		}

	});
}

function sortInputsInit() {

	$('.js-sort-input').on( "input", function() {

		let inputValue = this.value;

		if ( isNaN( inputValue ) || inputValue < 0 ) {
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

				$("#section-accordion").html(res.data);
			})

			$('.js-sort-input').prop("disabled", true);
		}

	});
}

function toggleCourseMaterial() {

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
			let badge = $(`.js-chapter-badge[data-material-id="${this.dataset.materialId}"]`);

			if ( this.checked ) {
				badge.removeClass("badge-outline-danger");
				badge.addClass("badge-outline-success px-1 mr-1");
				badge.text("Active");
			}
			else {
				badge.removeClass("badge-outline-success px-1 mr-1");
				badge.addClass("badge-outline-danger");
				badge.text("Inactive");
			}

			utilities.toastAlert( icon, message );

		})
		.catch( (err) => {
			utilities.toastAlert( 'error', "Παρουσιάστηκε κάποιο πρόβλημα ..." );
		});
	});
}

function remainingsCheckboxes() {

	let remainingCheckboxes = $('.js-remainings-checkbox');

	remainingCheckboxes.on( "change", remainingMaterialsCheckboxHandler );
}

$(".js-date-search").on( "input", function() {

	this.value = this.value.replace( /[^0-9]/g, "" )
		.replace(/^(\d{2})?(\d{2})?(\d{4})?(\d{2})?(\d{2})?(\d{4})?/g, '$1/$2/$3 - $4/$5/$6')
		.substr(0, 23)

});
// DataTables function / EventListener End

function sectionAdditionHandler() {

	const form = document.getElementById("additional-content-form");
	const type = this.dataset.type;
	const priority = this.dataset.priority;
	const sectionId = this.dataset.sectionId;

	let valid = checkEmpty( form, "js-empty" );

	if ( !valid ) {
		Swal.fire(
			'Προσοχή!',
			'Παρακαλώ συμπληρώστε όλα τα πεδία.',
			'info'
		);
		return;
	}

	const data = new FormData(form);

	data.append("courseId", courseId);
	data.append("sectionId", sectionId);
	data.append("type", type);
	data.append("priority", priority);

	axios.post( "/section/add-content", data )
		.then( res => {
			let sectionsCnt = document.getElementsByClassName("accordion")[0];
			sectionsCnt.innerHTML = res.data;

			let sections = sectionsCnt.getElementsByClassName("collapse");
			for (let i = 0; i < sections.length; i++ ) {
				sections[i].classList.remove("show");
			}

			let shownChapter = sectionsCnt.dataset.shownChapter;
			if ( typeof shownChapter !== "undefined" ) {
				document.getElementById(`${shownChapter}-collapse`).classList.add("show");
			}
			else {
				sectionsCnt.getElementsByClassName("collapse")[0].classList.add("show");
			}

			courseMaterialsTable.ajax.reload( null, false );

			utilities.toastAlert( "success", "Αποθηκεύτηκε" );
		})
		.catch( (err) => {

			if ( err.response.status === 422 && typeof err.response.data.errors.file !== "undefined" ) {
				additionsErrorMessage(err.response.data.errors.file[0])

				return;
			}
			else if ( err.response.status === 422 && typeof err.response.data.errors.title !== "undefined" ) {
				additionsErrorMessage(err.response.data.errors.title[0])
				
				return;
			}

			utilities.toastAlert( "error", "Παρουσιάστηκε κάποιο πρόβλημα ...")
		});
}

function submitChapterBtnHandler() {

	let input = this.findParent(2).getElementsByClassName("js-chapter-input")[0];
	let slug = input.dataset.materialSlug;
	let title = input.value;

	editChaptersTitle(slug, title);

}

function editChapterOnKeyupHandler(event) {

	if (event.keyCode == 27 ) {
		let cnt = this.findParent(4);
		let titleCnt = cnt.getElementsByClassName("js-chapter-title")[0];
		let editCnt = cnt.getElementsByClassName("js-edit-chapter")[0];

		titleCnt.classList.remove("d-none");
		titleCnt.classList.add("d-block");
		editCnt.classList.add("d-none");
	}
	else if ( event.keyCode == 13 ) {
		editChaptersTitle(this.dataset.materialSlug, this.value);
	}
}

function editChapterOnBlurHandler() {

	let cnt = this.findParent(4);

	let titleCnt = cnt.getElementsByClassName("js-chapter-title")[0];
	let editCnt = cnt.getElementsByClassName("js-edit-chapter")[0];

	titleCnt.classList.remove("d-none");
	titleCnt.classList.add("d-flex");

	editCnt.classList.add("d-none");

}

function editChapterBtnHandler() {

	let cnt = this.findParent(2);
	let titleCnt = cnt.getElementsByClassName("js-chapter-title")[0];
	let editCnt = cnt.getElementsByClassName("js-edit-chapter")[0];
	let input = editCnt.getElementsByTagName("input")[0];

	titleCnt.classList.remove("d-flex");
	titleCnt.classList.add("d-none");

	editCnt.classList.remove("d-none");
	input.focus();
	input.value = "";
	input.value = input.defaultValue;
}

function removeMaterialHandler() {

	const id = this.dataset.materialId;
	const type = this.dataset.materialType;
	let text, confirmButtonColor, confirmButtonText;

	if ( type === "Section" ) {
		text = 'Η ενότητα θα διαγραφεί απο το Course.';
		confirmButtonColor = '#ff5b5b';
		confirmButtonText = 'Ναι, διαγραφή!';
	}
	else {
		text = 'Το υλικό θα αφαιρεθεί απο το Course.';
		confirmButtonColor = '#536de6';
		confirmButtonText = 'Ναι, αφαίρεση!';
	}

	Swal.fire({
		title: "Είστε σίγουρος/η;",
		text,
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor,
		confirmButtonText,
		cancelButtonText: 'Άκυρο'
	}).then( (result) => {

		if (result.value) {

			removeMaterials( [id] );

		}
	})
}

function highlightCheckboxInit() {

	$(".js-course-material-highlight").on("change", function() {
		const materialId = this.dataset.materialId;
		const status = this.checked ? 1 : 0;

		// console.log(this);
		toggleHighlight([materialId], status);
	});

}

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

function toggleChapters( sectionId, data, mainCnt, checkedboxes ) {

	axios.patch(`/section/toggle-chapters`, {
		courseId, sectionId, data
	})
	.then( res => {
		let icon = "";
		let message = "";

		if ( data[0].status == 1 ) {
			icon = "success";
			message = data.length == 1 ? "Ενεργοποιήθηκε" : "Ενεργοποιήθηκαν";
			checkedboxes.forEach( checkbox => {
				checkbox.checked = false;
				checkbox.findParent(3).getElementsByClassName("js-chapter-toggle")[0].checked = true;
			});
		}
		else {
			icon = "info";
			message = data.length == 1 ? "Απενεργοποιήθηκε" : "Απενεργοποιήθηκαν";
			checkedboxes.forEach( checkbox => {
				checkbox.checked = false;
				checkbox.findParent(3).getElementsByClassName("js-chapter-toggle")[0].checked = false;
			});
		}

		mainCnt.getElementsByClassName("js-section-main-checkbox")[0].checked = false;
		mainCnt.getElementsByClassName("js-multiple-chapter-remove")[0].textContent = "Αφαίρεση επιλεγμένων (0)"
		mainCnt.getElementsByClassName("js-chapters-status")[0].textContent = "Αλλαγή κατάστασης (0)";
		utilities.toastAlert( icon, message );
	})
	.catch( err => {
		console.log(err);
		utilities.toastAlert( 'error', "Παρουσιάστηκε κάποιο πρόβλημα ..." );
	})

}

function removeChapters(sectionId, chapterIds) {

	axios.post(`/section/remove-chapters`, {
		courseId, sectionId, chapterIds
	})
	.then( res => {
		let message = chapterIds.length == 1 ? "1 αρχείο εκτός ύλης" : `${chapterIds.length} αρχεία εκτός ύλης`;
		let sectionsCnt = document.getElementsByClassName("accordion")[0];
		sectionsCnt.innerHTML = res.data;

		let sections = sectionsCnt.getElementsByClassName("collapse");
		for (let i = 0; i < sections.length; i++ ) {
			sections[i].classList.remove("show");
		}

		let shownChapter = sectionsCnt.dataset.shownChapter;
		if ( typeof shownChapter !== "undefined" ) {
			document.getElementById(`${shownChapter}-collapse`).classList.add("show");
		}
		else {
			sectionsCnt.getElementsByClassName("collapse")[0].classList.add("show");
		}

		courseMaterialsTable.ajax.reload(null, false);
		remainingMaterialsTables.ajax.reload(null, false);
		utilities.toastAlert( 'info', message );
	})
	.catch( err => {
		console.log(err);
		utilities.toastAlert( 'error', "Παρουσιάστηκε κάποιο πρόβλημα ..." );
	})
}

function editChaptersTitle(materialSlug, title) {

	axios.patch(`/materials/edit-chapter/${materialSlug}`, {
		courseId, title
	})
	.then( res => {
		$("#section-accordion").html(res.data);
		courseMaterialsTable.ajax.reload(null, false);
	})
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

function addChapterMaterials( chapterId, materialIds ) {
	axios.post("/materials/add-materials", {
		courseId, chapterId, materialIds
	})
	.then( res => {
		let sectionsCnt = document.getElementsByClassName("accordion")[0];
		sectionsCnt.innerHTML = res.data;

		let sections = sectionsCnt.getElementsByClassName("collapse");
		for (let i = 0; i < sections.length; i++ ) {
			sections[i].classList.remove("show");
		}

		let shownChapter = sectionsCnt.dataset.shownChapter;
		if ( typeof shownChapter !== "undefined" ) {
			document.getElementById(`${shownChapter}-collapse`).classList.add("show");
		}
		else {
			sectionsCnt.getElementsByClassName("collapse")[0].classList.add("show");
		}

		courseMaterialsTable.ajax.reload( null, false );
		remainingMaterialsTables.ajax.reload( null, false );
	})
	.catch( err => {
		console.log(err);
	})
}

function addCourseMaterials( materialId ) {
	axios.post( "/courses/add-materials", {
		courseId, materialId
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
		utilities.toastAlert( 'error', "Κάποιο σφάλμα παρουσιάστηκε ..." );
	})
}

function toggleHighlight(materialIds, status) {

	axios.patch(`/course/${courseId}/toggle-highlight`, {materialIds, status})
	.then( res => {
		const message = status === 1 ? "Highlighted." : "De-emphasized."
		const icon = status === 1 ? "success" : "info"
		utilities.toastAlert(icon, message);
	})
	.catch( err => {
		console.log(err);
		utilities.toastAlert("error", "Κάποιο σφάλμα παρουσιάστηκε ...");
	})
}

function sectionMaterialHightlightToggle(sectionId, materialIds, status) {

	axios.patch(`/section/toggle-hightlight/${sectionId}`, {materialIds, status})
	.then( res => {
		const message = status === 1 ? "Highlighted." : "De-emphasized."
		const icon = status === 1 ? "success" : "info"
		utilities.toastAlert(icon, message);
	})
	.catch( err => {
		console.log(err);
		utilities.toastAlert("error", "Κάποιο σφάλμα παρουσιάστηκε ...");
	})
}

function removeMaterials( materials ) {

	axios.patch( "/courses/remove-materials", {
		courseId,
		materials
	})
	.then( (res) => {

		let message = materials.length == 1 ? "1 αρχείο εκτός ύλης" : `${materials.length} αρχεία εκτός ύλης`;


		utilities.toastAlert( 'success', message );
		courseMaterialsTable.ajax.reload( null, false );
		remainingMaterialsTables.ajax.reload( null, false );

		utilities.resetAddButton( $("#add-remaingings-btn"), $("#all-remainings-checkbox") );
		utilities.resetBulk( $("#active-material-bulk"), $("#all-active-materials-checkbox") );

		$("#section-accordion").html(res.data);
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
		let activeMaterials = createTypeSelect( res, "selected-materials-types" );
		let remainingMaterials = createTypeSelect( res, "remaining-materials-types" );

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
			remainingMaterialsTables.columns( 2 ).search( this.value ).draw();
		})

	})
	.catch( (err) => {
		console.log(err);
	})

function createTypeSelect( res, id = "" ) {
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
	let type = this.dataset.type;
	let rows = $("#course-materials-list > tbody > tr");

	const selectedRow = findMaterialRow(rows, id);
	const newRow = createTableRow( type, priority );

	newRow.appendAfter( selectedRow );

	mainAdditionEventInit(newRow);

	if ( type == "Announcement" ) {
		$R('#new-announcement', utilities.redactorConfig );
	}

	let statusElm = newRow.getElementsByClassName("js-state")[0];
	$(statusElm).select2({
		minimumResultsForSearch: -1,
	});

	$('#add-additions-modal').modal('hide')

});

function findMaterialRow(rows, id = false) {

	let rowId = 0;

	for ( let i = 0; i < rows.length; i++ ) {
		rowId = rows[i].dataset.materialId;

		if ( id == rowId ) {
			
			return rows[i];
		}
	}

	return rows[rows.length - 1];
}

function linkForm( type, priority) {

	return `<td id="add-content-row" class="px-0 text-left" colspan="9">
		<h3 class="text-center font-20 line-height-05 b-block mb-3 underline">Νέο ${ type }</h3>
		<form id="additional-content-form">
			<div class="form-row">
				<div class="form-group col-6">
					<label for="new-title">Τίτλος <span class="text-danger">*</span></label>
					<input type="text" id="new-title" class="js-empty js-title form-control" name="title" placeholder="Εισάγετε τίτλο..." />
					<div class="invalid-feedback">
						Παρακαλώ εισάγετε τίτλο.
					</div>
				</div>
				<div class="form-group col-6">
					<label for="new-subtitle">Υπότιτλος</label>
					<input type="text" id="new-subtitle" class="js-subtitle form-control" name="subtitle" placeholder="Εισάγετε υπότιτλο..."/>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-9">
					<label>${ type } <span class="text-danger">*</span></label>
					<input type="text" class="${ type === "Video" ? "js-empty" : ""} form-control" name="video" ${ type === "Video" ? "" : "hidden"} placeholder="Εισάγετε video link..."/>
					<input type="text" class="${ type === "Video" ? "" : "js-empty"} form-control" name="link" ${ type === "Video" ? "hidden" : ""} placeholder="Εισάγετε link..."/>
					<div class="invalid-feedback">
						Παρακαλώ εισάγετε link.
        			</div>
				</div>
				<div class="form-group col-3 d-flex flex-column">
					<label for="state-select">Κατάσταση</label>
					<select class="js-state form-control select2" id="state-select" name="status">
						<option value="1">Ενεργό</option>
						<option value="0" selected>Ανενεργό</option>
					</select>
				</div>
			</div>
			<input type="text" name="content" hidden/>
		</form>
		<div class="form-group d-flex justify-content-end">
			<button  class="js-add-content js-section-content btn btn-primary" data-type="${ type }" data-priority="${ priority }">Αποθήκευση</button>
			<button  class="js-cancel-addition btn btn-secondary ml-2">Άκυρο</button>
		</div>
	</td>`;
}

function annoucementForm( priority ) {

	return `<td id="add-content-row" class="px-0 text-left" colspan="9">
		<h3 class="text-center font-20 line-height-05 b-block mb-3 underline">Νέα Ανακοίνωση</h3>
		<form id="additional-content-form">
			<div class="form-row">
				<div class="form-group col-9">
					<label for="new-title">Τίτλος <span class="text-danger">*</span></label>
					<input type="text" id="new-title" class="js-empty js-title form-control" name="title" placeholder="Εισάγετε τίτλο..." />
					<div class="invalid-feedback">
						Παρακαλώ εισάγετε τίτλο.
					</div>
				</div>
				<div class="form-group col-3 d-flex flex-column">
					<label for="state-select">Κατάσταση</label>
					<select class="js-state form-control select2" id="state-select" name="status">
						<option value="1">Ενεργό</option>
						<option value="0" selected>Ανενεργό</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="new-announcement">Ανακοίνωση <span class="text-danger">*</span></label>
				<textarea id="new-announcement" class="js-empty js-content form-control" name="content" placeholder="Εισάγετε ανακοίνωση..."></textarea>
				<div class="invalid-feedback">
					Παρακαλώ εισάγετε Ανακοίνωση.
				</div>
			</div>
			<input type="text" name="video" hidden/>
			<input type="text" name="link" hidden/>
			<input type="text" name="subtitle" hidden/>
		</form>
		<div class="form-group float-right">
			<button  class="js-add-content js-section-content btn btn-primary" data-type="Announcement" data-priority="${ priority }">Αποθήκευση</button>
			<button  class="js-cancel-addition btn btn-secondary ml-2">Άκυρο</button>
		</div>
	</td>`;
}

function sectionForm(priority) {

	return `<td id="add-content-row" class="px-0 text-left" colspan="9">

		<h3 class="text-center font-20 line-height-05 b-block mb-3 underline">Νέο Section</h3>
		<form id="additional-content-form">
			<div class="form-row">
				<div class="form-group col-9">
					<label for="new-title">Τίτλος <span class="text-danger">*</span></label>
					<input type="text" id="new-title" class="js-empty js-title form-control" name="title" placeholder="Εισάγετε τίτλο..." />
					<div class="invalid-feedback">
						Παρακαλώ εισάγετε τίτλο.
					</div>
				</div>
				<div class="form-group col-3 d-flex flex-column">
					<label for="state-select">Κατάσταση</label>
					<select class="js-state form-control select2" id="state-select" name="status">
						<option value="1">Ενεργό</option>
						<option value="0" selected>Ανενεργό</option>
					</select>
				</div>
			</div>
			<input type="text" name="video" hidden/>
			<input type="text" name="link" hidden/>
			<input type="text" name="subtitle" hidden>
			<input type="text" name="content" hidden>
		</form>
		<div class="form-group d-flex justify-content-end">
			<button  class="js-add-content btn btn-primary" data-type="Section" data-priority="${ priority }">Αποθήκευση</button>
			<button  class="js-cancel-addition btn btn-secondary ml-2">Άκυρο</button>
		</div>
	</td>`;
}

function createTableRow( type, priority ) {

	let addContentRow = $(".extra-content-row")[0];

	if ( addContentRow ) {
		addContentRow.remove();
	}

	let rowElm = document.createElement("tr");
	rowElm.classList.add("extra-content-row")

	if (type == "Announcement") {
		rowElm.innerHTML = annoucementForm( priority );
	}
	else if ( type == "Section" ) {
		rowElm.innerHTML = sectionForm( priority );
	}
	else {
		rowElm.innerHTML = linkForm( type, priority);
	}

	return rowElm;
}


function cancelAddition() {

	const additionRow = document.getElementsByClassName("extra-content-row")[0];
	const saveBtn = additionRow.getElementsByClassName("js-add-content")[0];

	saveBtn.removeEventListener( "click", addContent );
	this.removeEventListener( "click", cancelAddition );

	additionRow.remove();
}

function addContent() {
	const form = document.getElementById("additional-content-form");
	const priority = this.dataset.priority;
	const type = this.dataset.type;
	let valid = checkEmpty( form, "js-empty" );

	if ( !valid ) {

		Swal.fire(
			'Προσοχή!',
			'Παρακαλώ συμπληρώστε όλα τα πεδία.',
			'info'
		);

		return
	}

	this.disabled = true;

	let data = new FormData(form);

	data.append( "courseId", courseId );
	data.append( "priority", priority );
	data.append( "type", type );

	axios.post( "/materials/add-additionnal-content",
		data
	)
		.then( (res) => {

			courseMaterialsTable.ajax.reload( null, false );

			$("#section-accordion").html(res.data);

			utilities.toastAlert( "success", "Αποθηκεύτηκε" );
		})
		.catch( (err) => {

			if ( err.response.status === 422 && typeof err.response.data.errors.file !== "undefined" ) {
				additionsErrorMessage(err.response.data.errors.file[0])

				return;
			}
			else if ( err.response.status === 422 && typeof err.response.data.errors.title !== "undefined" ) {
				additionsErrorMessage(err.response.data.errors.title[0])
				
				return;
			}

			utilities.toastAlert( "error", "Παρουσιάστηκε κάποιο πρόβλημα ...");
		});

}

function additionsErrorMessage(text) {
	Swal.fire({
		title: 'Error',
		html: text,
		icon: 'warning',
		confirmButtonColor: '#536de6'
	});
}

function mainAdditionEventInit(row) {
	const saveBtn = row.getElementsByClassName("js-add-content")[0];
	const cancelBtn = row.getElementsByClassName("js-cancel-addition")[0];

	saveBtn.addEventListener("click", addContent);
	cancelBtn.addEventListener("click", cancelAddition );

}

function sectionAdditionEventInit(row, sectionId) {
	const saveBtn = row.getElementsByClassName("js-section-content")[0];
	const cancelBtn = row.getElementsByClassName("js-cancel-addition")[0];

	saveBtn.dataset.sectionId = sectionId;
	saveBtn.addEventListener("click", sectionAdditionHandler);

	cancelBtn.addEventListener("click", removeSectionAdditionHandler);

}

function removeSectionAdditionHandler() {
	const row = document.getElementsByClassName("extra-content-row")[0];
	const saveBtn = row.getElementsByClassName("js-section-content")[0];

	saveBtn.removeEventListener( "click", sectionAdditionHandler );
	this.removeEventListener( "click", removeSectionAdditionHandler );

	row.remove();

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

	input.classList.add("form-control", "date", "d-inline-block", "ml-0", "js-date-search");
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
		let badge = "";

		if ( materialCount == 1 ) {
			message = status == 1 ? "Ενεργοποιήθηκε" : "Απενεργοποιήθηκε";
		}
		else {
			message = status == 1 ? "Ενεργοποιήθηκαν" : "Απενεργοποιήθηκαν";
		}

		for (let i = 0; i < data.length; i++) {
			badge = $(`.js-chapter-badge[data-material-id="${data[i].id}"]`);

			if ( data[i].status == 1 ) {
				badge.removeClass("badge-outline-danger");
				badge.addClass("badge-outline-success px-1 mr-1");
				badge.text("Active");
			}
			else {
				badge.removeClass("badge-outline-success px-1 mr-1");
				badge.addClass("badge-outline-danger");
				badge.text("Inactive");
			}

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
	width: "100%",
	closeOnSelect: false,
	placeholder: "Επιλέξτε Topics..."
})

$("#version-select").select2({
	width: "100%",
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
		}
	}
});
FilePond.setOptions({
    name: 'file[]',
	allowMultiple: true,
	className: "js-filepond-file-dragging",
	labelIdle: "Drag & Drop your files or Browse",
	allowRevert: false
});

FilePond.registerPlugin(FilePondPluginFileValidateType);
FilePond.registerPlugin(FilePondPluginFileValidateSize);

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
	onprocessfiles: function() {

		let files = pond.getFiles();

		for (let i = 0; i < files.length; i++ ) {

			timer = setTimeout(function() {
				pond.removeFile(files[i]);
				
			}, ( i + 1 ) * 500);
			
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

		if ( courseFilePond.status === 2 ) {

			clearTimeout(timer);
			let files = courseFilePond.getFiles();

			for (let i = 0; i < files.length; i++ ) {

				if ( files[i].status === 5 ) {
					timer = setTimeout(function() {
						courseFilePond.removeFile(files[i]);
					}, ( i + 1 ) * 500);
				}

			}
			$("#files-cnt").removeClass("d-none");
			$("#active-files-loading").addClass("d-none");
		}
		
	},
	onprocessfileabort: function() {
		$("#files-cnt").removeClass("d-none");
		$("#active-files-loading").addClass("d-none");
	},
	onprocessfiles: function() {

		let files = courseFilePond.getFiles();

		for (let i = 0; i < files.length; i++ ) {

			timer = setTimeout(function() {
				courseFilePond.removeFile(files[i]);
				
			}, ( i + 1 ) * 500);
			
		}

		$("#files-cnt").removeClass("d-none");
		$("#active-files-loading").addClass("d-none");

	},
    acceptedFileTypes: utilities.ALLOWEDTYPES,
	fileValidateTypeDetectType: (source, type) => new Promise((resolve, reject) => {
		
		// Do custom type detection here and return with promise
		const extension = source.name.split(".").pop();

		if ( utilities.ALLOWEDTYPES.includes(type) ) {
			resolve(type);
		}
		else if (extension === "ev3" || extension === "rar" || extension === "sb3") {
			type = "application/octet-stream";
			resolve(type);
		}

		reject(type);
    }),
	maxFileSize: "50MB"
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

	dropArea[i].addEventListener("drop", function(event) {
		const draggingArea = this.getElementsByClassName("filepond--drop-label")[0];
		const label = draggingArea.querySelector("label");

		draggingArea.classList.remove("limegreen");
		label.classList.remove("text-limegreen");
	});
}

const editor = document.getElementById("editor");
const scriptArea = document.getElementById("script-area");

const format = beautify_html(scriptArea.value, {indent_size: 4})

const myCodeMirror = CodeMirror(editor, {
	viewportMargin: Infinity,
	value: format,
	mode:  "htmlmixed",
	theme: "night",
	indentWithTabs: true,
	lineNumbers: true,
	lineWrapping: true,
	autoRefresh: true,
	styleActiveLine: true
});

$("#edit-course-form").on("submit", function(event) {
	event.preventDefault();
	
	const scriptValue = myCodeMirror.getValue();
	scriptArea.value = scriptValue;

	this.submit();
});