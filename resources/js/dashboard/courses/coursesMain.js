//!######################################
//! 				Imports				#
//!######################################
import utilities from '../main';

//!##########################################
//! 			EventListeners				#
//!##########################################

$("#clone-course-modal").on( 'show.bs.modal', function() {

	if ( !event ) {
		return;
	}

	let button = event.target;
	let courseId = button.dataset.courseId;

	document.getElementById("cloning-course-id").value = courseId;

});

$("#select-all-courses").change( function() {
	let minorCheckboxes = $(".js-course-checkbox");
	let bulkBtn = $("#course-bulk-action-btn")[0];

	utilities.minorCheckboxSwitcher(this, minorCheckboxes, bulkBtn );

})

$("#submit-form-btn").click( function() {

	$("#new-course-form").submit()

});

$("#cover-input").change( function() {
	$("#cover-input-label")[0].textContent = this.value.replace("C:\\fakepath\\", "");
});

$('#delete-courses-btn').click( function() {

	let checkedBoxes = $('.js-course-checkbox:checked');

	if ( checkedBoxes.length == 0 ) {
		Swal.fire('Δεν έχετε επιλέξει τίποτα');
		return;
	}

	let ids = [];

	for ( let i = 0; i < checkedBoxes.length; i++ ) {
		ids.push( checkedBoxes[i].dataset.courseId );
	}

	Swal.fire({
		title: 'Είστε σίγουρος;',
		text: `${checkedBoxes.length} ${checkedBoxes.length == 1 ? "αρχείο θα διαγραφεί" : " αρχεία θα διαγραφούν"}`,
		icon: 'warning',
		showCancelButton: true,
		confirmButtonText: 'Ναι, διαγραφή!',
		cancelButtonText: 'Άκυρο'
	}).then( (result) => {

		if (result.value) {

			axios.delete(`/courses/destroy/${ids}`)
			.then(function (response) {

				let message = checkedBoxes.length == 1 ? "Διεγράφη" : "Διαγράφηκαν"

				utilities.toastAlert( "success", message );

				coursesDatatable.ajax.reload();
				utilities.resetBulk( $("#course-bulk-action-btn"), $("#select-all-courses") );
			})
			.catch(function (error) {

				utilities.toastAlert( "error", "Παρουσιάστηκε κάποιο πρόβλημα ..." );

			});

		}
	})
});

//!##########################################
//! 				Datatables				#
//!##########################################
const coursesDatatable = $("#courses-datatable").DataTable({
	order: [7, "desc"],
	processing: true,
	serverSide: true,
	ajax: {
		url: "/courses/courses-datatable",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		type: "post",
		data: function( d ) {
			return $.extend( {}, d, {
				startDate: startDate( $("#course-date-range")[0] ),
				endDate: endDate( $("#course-date-range")[0] ),
				// topicId: $("#topic-filter").val()
			})
		}
	},
	columns: [
		{data: 'action', name: 'action', className: "align-middle", width: "5%", orderable: false },
		{data: 'title', name: 'title' },
		{data: 'status', name: 'status', className: "align-middle"},
		{data: 'curator', name: 'curator', className: "align-middle" },
		{data: 'topics', name: 'topics', className: "align-middle" },
		{data: 'type', name: 'type', className: "align-middle" },
		{data: 'updated_at', name: 'updated_at', className: "align-middle cursor-default js-updated-at" },
		{data: 'created_at', name: 'created_at',  className: "align-middle cursor-default"},
	],
	language: utilities.tableLocale,
	fnInitComplete: function( oSettings, json ) {
		let lenthSelection = $("select[name='courses-datatable_length']");
		lenthSelection.addClass("select2");

		lenthSelection.select2({
			minimumResultsForSearch: -1,
		});
	},
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		$(".js-remove-table-classes > thead > tr > th").removeClass("cursor-pointer js-updated-at");

		toggleStatus();
		checkeBoxesEventListener();
		cloneEventListener();
		utilities.resetBulk( $("#course-bulk-action-btn"), $("#select-all-courses"));
	}
})

//! #################################################
//!		Datatable event initialazion functions		#
//! #################################################

function cloneEventListener() {

	let cloneBtns = $(".js-course-clone-btn");

	cloneBtns.click( function() {

		$('#clone-course-modal').modal('show')

	});
}

function checkeBoxesEventListener() {

	let minorCheckboxes = $(".js-course-checkbox");
	let mainCheckbox = $("#select-all-courses")[0];
	let bulkBtn = $("#course-bulk-action-btn")[0];

	minorCheckboxes.unbind();

	minorCheckboxes.change( function() {
		utilities.mainCheckboxSwitcher( mainCheckbox, minorCheckboxes, bulkBtn)
	})

}

function toggleStatus() {
	$('.js-toggle').unbind();

	$('.js-toggle').on('change', function() {
		let courseCnt = this.parentElement.parentElement;
		let updatedAtElm = courseCnt.getElementsByClassName("js-updated-at")[0];
		axios.patch('/courses/status', {
			course: this.dataset.courseId,
			state: this.checked
		})
		.then( (res) => {

			let icon = this.checked ? "success" : "info";
			let message = this.checked ? "Ενεργοποιήθηκε" : "Απενεργοποιήθηκε";

			utilities.toastAlert( icon, message );

			updatedAtElm.textContent = "Μόλις τώρα";
		})
		.catch( (err) => {

			utilities.toastAlert( "error", "Παρουσιάστηκε κάποιο πρόβλημα ..." );

		});
	});
}

//!##########################################
//!				Datatable filters			#
//!##########################################

let searchFieldLabel = $("#courses-datatable_filter > label > input")[0];
let dateInput = createDateElm();

dateInput.appendBefore( searchFieldLabel );
dateInput.addEventListener("input", function() {

	this.value = this.value.replace( /[^0-9]/g, "" )
		.replace(/^(\d{2})?(\d{2})?(\d{4})?(\d{2})?(\d{2})?(\d{4})?/g, '$1/$2/$3 - $4/$5/$6')
		.substr(0, 23)

})

let dateRange = $("#course-date-range");

dateRange.daterangepicker( utilities.datePickerConfig );

dateRange.on( "apply.daterangepicker", function(event, picker) {

	let startDate = picker.startDate.format('DD/MM/YYYY');
	let endDate = picker.endDate.format('DD/MM/YYYY');

	this.classList.add("select2-selected");
	this.value = `${ startDate } - ${ endDate }`;

	coursesDatatable.ajax.reload();

})

dateRange.on( 'cancel.daterangepicker', function(event, picker) {

	this.classList.remove("select2-selected");
	dateInput.value = "";
	coursesDatatable.ajax.reload();
})

let tablesLengthLabel = $("#courses-datatable_length > label")[0];
let topicFIlter = $("#topic-filter")[0];


let activeCoursesFilter = utilities.createStateSelect("course-state-select");
tablesLengthLabel.append( activeCoursesFilter );

$("#course-state-select").select2({
	minimumResultsForSearch: -1,
})

$("#course-state-select").change( function () {

	let label = $("#select2-course-state-select-container")[0];

	utilities.filterStyle( label, this.value );

	coursesDatatable.column(2).search( this.value ).draw();

});

tablesLengthLabel.append(topicFIlter);

$("#topic-filter").select2({

});

$("#topic-filter").change( function() {

	let label = $("#select2-topic-filter-container")[0];

	utilities.filterStyle( label, this.value );
	coursesDatatable.column(4).search( this.value ).draw();

});

let courseTypesSelect = utilities.createCourseTypeSelect("course-type-selection");
tablesLengthLabel.append(courseTypesSelect);

$("#course-type-selection").select2({
	minimumResultsForSearch: -1,
});

$("#course-type-selection").change( function() {

	let label = $("#select2-course-type-selection-container")[0];
	utilities.filterStyle( label, this.value );

	coursesDatatable.column(5).search( this.value ).draw();

});




//!##########################################
//!				script functions			#
//!##########################################

function createDateElm() {

	let input = document.createElement("input");

	input.classList.add("form-control", "date", "d-inline-block", "ml-1");
	input.id = "course-date-range";
	input.dataset.toggle = "date-picker";
	input.dataset.cancelClass = "btn-secondary";
	input.style.height = "31.96px";
	input.style.width = "195px";
	input.placeholder = "Επιλέξτε ημερομηνίες...";

	return input;
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

$R("#summary", utilities.redactorConfig);

$R("#description", utilities.redactorConfig);
