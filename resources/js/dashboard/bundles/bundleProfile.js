//!######################################
//! 				Imports				#
//!######################################
import utilities from '../main';
import Dropzone from "../../../plugins/dropzone/js/dropzone";
import ArticleEditor from "../../../plugins/article-editor/article-editor"

//! GLOBAL VARIABLES
const bundleId = $("#bundle-title")[0].dataset.bundleId

//! EventListerners

$(".tab-link").on("show.bs.tab", function(event) {

	event.preventDefault();
	Swal.fire(
		'Προσοχή',
		'<p>Θα πρέπει να αποθηκεύσετε το Bundle</p>για να συνεχίσετε!',
		'info'
	);
})

$(".under-development").click( function() {
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
		data: {
			bundleId: bundleId
		}
	},
	columns: [
		{ data: 'action', name: 'action', orderable: false, width: "5%" },
		{ data: 'title', name: 'title', className: "cursor-default" },
		{ data: 'curator', name: 'curator', className: "cursor-default" },
		{ data: 'topics', name: 'topics.title', className: "cursor-default" },
		{ data: 'version', name: 'version', className: "cursor-default" },
		{ data: 'updated_at', name: 'updated_at',  className: "cursor-default" },
		{ data: 'created_at', name: 'created_at', className: "cursor-default" },
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

function activeCoursesCheckboxToggle() {

	let mainCheckbox = $('#main-active-courses-checkbox')[0];
	let minorCheckbox = $('.js-course-checkbox');
	let bulkBtn = $("#courses-bulk")[0];

	minorCheckbox.unbind();
	minorCheckbox.change( function() {
		utilities.mainCheckboxSwitcher(mainCheckbox, minorCheckbox, bulkBtn);
	});
}

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
		{data: 'action', name:'action', orderable: false, searchable: false, className: "text-center"},
		{data: 'title', name: 'title', className: "cursor-default"},
		{data: 'addBtn', name: 'addBtn', orderable: false, searchable: false, className: "text-center"}
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

$R("#summary", utilities.redactorConfig);

ArticleEditor('#description', {
	css: "/css/",
	custom: {
		css: [
			"/css/arx-content.min.css"
		]
	},
	editor: {
		minHeight: "300px"
	},
	// classes: {
	// 	'p': 'text-muted',
	// 	'h1': 'text-muted',
	// 	'h2': 'text-muted',
	// 	'h3': 'text-muted',
	// 	'h4': 'text-muted',
	// 	'h5': 'text-muted',
	// }
	/* image: {
		upload: "/materials/upload-content-images",
		data: {
			"_token": $('meta[name="csrf-token"]').attr('content')
		}
	} */
});


let dropzone = new Dropzone("#cover-dropzone", {
	previewTemplate: $("#uploadPreviewTemplate").html(),
	url: "/target-url",
  	thumbnailWidth: 80,
  	thumbnailHeight: 80,
})
