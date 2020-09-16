//!######################################
//! 				Imports				#
//!######################################
import utilities from '../main';
import ArticleEditor from "../../../plugins/article-editor/article-editor"

import * as FilePond from 'filepond';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import 'filepond/dist/filepond.min.css';

//! GLOBAL VARIABLES
const bundleId = $("#bundle-title")[0].dataset.bundleId;
const baseUrl = window.location.origin;

//!##########################################
//! 			EventListerners				#
//!##########################################

$("#change-cover-btn").on("click", function() {

	$("#gallery-content")[0].dataset.action = "cover";

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

$("#bundle-delete-btn").click( function() {
	Swal.fire({
		title: 'Είστε σίγουρος;',
		text: "Η ενέργεια θα είναι μη αναστρέψιμη!",
		icon: 'warning',
		showCancelButton: true,
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

$("#publish-date-select").on("input", function() {

	this.value = this.value.replace( /[^0-9]/g, "" )
		.replace(/^(\d{2})?(\d{2})?(\d{4})?(\d{2})?(\d{2})?(\d{4})?/g, '$1-$2-$3 $4:$5')
		.substr(0, 16);

})



$('#main-active-courses-checkbox').click( function() {
	let checkboxes = $('.js-course-checkbox');
	let bulkBtn = $("#courses-bulk")[0];

	utilities.minorCheckboxSwitcher( this, checkboxes, bulkBtn );
});

$('#all-courses-checkbox').change( function() {
	let checkboxes = $('.js-remainings-checkbox');
	let bulkBtn = $("#add-courses-btn")[0];

	utilities.minorCheckboxSwitcher( this, checkboxes, bulkBtn );
});

$('#add-courses-btn').click( function() {
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
	}
});

$('#remove-selected-courses-btn').click( function() {
	let checkboxes = $('.js-course-checkbox:checked');
	let ids = [];

	if ( checkboxes.length == 0 ) {

		utilities.toastAlert( 'info', "Δεν υπάρχουν επιλεγμένα μαθήματα..." );
		return;
	}
	else {
		for ( let i = 0; i < checkboxes.length; i++ ) {
			ids.push( checkboxes[i].dataset.courseId );
		}
		removeCourses(ids);
	}
});

//! EventListerners /end

//! Datatables
const bundleCoursesTable = $("#bundle-courses-list").DataTable({
	order: [3, "desc"],
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
		{ data: 'curator', name: 'curator', className: "align-middle text-center cursor-default" },
		{ data: 'topics', name: 'topics', className: "align-middle cursor-default" },
		{ data: 'version', name: 'version', className: "align-middle text-center cursor-default" },
		{ data: 'updated_at', name: 'updated_at',  className: "align-middle text-center cursor-default" },
		{ data: 'created_at', name: 'created_at', className: "align-middle text-center cursor-default" },
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

$("#topic-filter").change( function() {

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

$("#active-course-type-slt").change( function() {

	let label = $("#select2-active-course-type-slt-container")[0];
	utilities.filterStyle( label, this.value );

	bundleCoursesTable.column(4).search( this.value ).draw();

});

//! Event Initializers!
function activeCoursesCheckboxToggle() {

	let mainCheckbox = $('#main-active-courses-checkbox')[0];
	let minorCheckbox = $('.js-course-checkbox');
	let bulkBtn = $("#courses-bulk")[0];

	minorCheckbox.unbind();
	minorCheckbox.change( function() {
		utilities.mainCheckboxSwitcher(mainCheckbox, minorCheckbox, bulkBtn);
	});
}


const bundleUsersTable = $("#bundle-users-table").DataTable({
	order: [1, "asc"],
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
		{data: 'last_name', name: 'last_name', className: "cursor-default"},
		{data: 'first_name', name: 'first_name', className: "align-middle text-center cursor-default"},
		{data: 'btn', name: 'btn', orderable: false, searchable: false, className: "align-middle text-center"}
	],
	language: utilities.tableLocale,
	// fnInitComplete: function( oSettings, json ) {
	// 	let lenthSelection = $("select[name='remaining-courses-table_length']");
	// 	lenthSelection.addClass("select2");

	// 	lenthSelection.select2({
	// 		minimumResultsForSearch: -1,
	// 	});
	// },
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		$(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
		$(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
		// $(".js-remove-table-classes > thead > tr > th").removeClass("cursor-pointer");
		// $(".js-remove-table-classes > tfoot > tr > th").removeClass("cursor-pointer");

		// addcourse();
		// remainingsCheckboxes();
		// utilities.resetAddButton(  $("#add-courses-btn"), $("#all-courses-checkbox") );
	},
})




const remainingCoursesTable = $("#remaining-courses-table").DataTable({
	order: [1, "asc"],
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
	$('.js-add-course-btn').click( function() {

		const courseId = [this.dataset.courseId];

		postCourseIds( courseId );
	});
}

function remainingsCheckboxes() {

	let mainCheckbox = $('#all-courses-checkbox')[0];
	let minorCheckbox = $('.js-remainings-checkbox');
	let bulkBtn = $("#add-courses-btn")[0];

	minorCheckbox.unbind();
	minorCheckbox.change( function() {
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

$("#add-course-topic-filter").change( function() {

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

$("#add-courses-type-filter").change( function() {

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
		utilities.toastAlert( 'success', message );

		bundleCoursesTable.ajax.reload();
		remainingCoursesTable.ajax.reload();
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

		utilities.toastAlert( 'success', message );

		bundleCoursesTable.ajax.reload();
		remainingCoursesTable.ajax.reload();

		utilities.resetBulk(  $("#courses-bulk"), $("#main-active-courses-checkbox") );
	})
	.catch( (err) => {
		console.log(err);
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
		$('#gallery-content')[0].dataset.action = "summary"
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
		$('#gallery-content')[0].dataset.action = "description"
        $('#gallery-modal').modal('show')
    }
});

ArticleEditor('#description', {
	css: "/css/",
	custom: {
		css: [
			"/css/bootstrap.min.css"
		]
	},
	plugins: ['mediaLibrary'],
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
const pond = FilePond.create( dropzone );

FilePond.setOptions({
	name: 'file[]',
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

});
