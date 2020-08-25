//!##############################################
//! 				Prototypes					#
//!##############################################

Element.prototype.appendBefore = function (element) {
	element.parentNode.insertBefore(this, element);
},false;

Element.prototype.appendAfter = function (element) {

	element.parentNode.insertBefore(this, element.nextSibling);

},false;

//!##########################################
//! 			EventListeners				#
//!##########################################

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
		confirmButtonText: 'Ναί, διαγραφή!',
		cancelButtonText: 'Άκυρο'
	}).then( (result) => {

		if (result.value) {

			axios.delete(`/courses/destroy/${ids}`)
			.then(function (response) {

				let message = checkedBoxes.length == 1 ? "Διεγράφη" : "Διαγράφηκαν"

				toastAlert( "success", message );

				coursesDatatable.ajax.reload();
			})
			.catch(function (error) {
				
				toastAlert( "error", "Παρουσιάστηκε κάποιο πρόβλημα ..." );

			});
			
		}
	})
});

//!##########################################
//! 				Datatables				#
//!##########################################
const coursesDatatable = $("#courses-datatable").DataTable({
	order: [1, "asc"],
	processing: true,
	serverSide: true,
	ajax: {
		url: "/courses/courses-datatable",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		type: "post",
		data: function( d ) {
			return $.extend( {}, d, {
				startDate: startDate( $("#course-date-range")[0] ),
				endDate: endDate( $("#course-date-range")[0] )
			})
		}
	},
	columns: [
		{data: 'action', name: 'action', className:'align-middle', width: "5%", orderable: false },
		{data: 'title', name: 'title' },
		{data: 'active', name: 'active', className:'align-middle' },
		{data: 'updated_at', name: 'updated_at', className: "align-middle cursor-default js-updated-at" },
		{data: 'created_at', name: 'created_at',  className: "align-middle cursor-default"},
	],
	language:{
		emptyTable: 		"Δεν υπάρχουν εγγραφές",
		info: 				"_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα",
		infoEmpty:      	"0 απο 0 τα 0 αποτελέσματα",
		lengthMenu: 		"_MENU_",
		loadingRecords: 	"Φόρτωση ...",
		processing: 		"Επεξεργασία ...",
		search: 			"",
		searchPlaceholder: 	"Αναζήτηση...",
		zeroRecords: 		"Δεν βρέθηκαν αποτελέσματα",
		paginate:{
			previous:"<i class='mdi mdi-chevron-left'>",
			next:"<i class='mdi mdi-chevron-right'>"}
	},
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		$(".js-remove-table-classes > thead > tr > th").removeClass("cursor-default js-updated-at");

		// atLinkEventListener();
		toggleActive();
	}
})

//! #################################################
//!		Datatable event initialazion functions		#
//! #################################################

function toggleActive() {

	$('.js-toggle').unbind();

	$('.js-toggle').on('change', function() {
		let courseCnt = this.parentElement.parentElement;
		let updatedAtElm = courseCnt.getElementsByClassName("js-updated-at")[0];
		axios.patch('/courses/active', {
			course: this.dataset.courseId,
			state: this.checked
		})
		.then( (res) => {

			let icon = this.checked ? "success" : "info";
			let message = this.checked ? "Ενεργοποιήθηκε" : "Απενεργοποιήθηκε";

			toastAlert( icon, message );

			updatedAtElm.textContent = "Μόλις τώρα";
		})
		.catch( (err) => {

			toastAlert( "error", "Παρουσιάστηκε κάποιο πρόβλημα ..." );

		});
	});
}

/* function atLinkEventListener() {
	$('.js-link').click( function() {
		let courseId = this.parentElement.dataset.courseId;
		window.location = `course/${courseId}`;
	});
} */

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

dateRange.daterangepicker({
	ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
	},
	alwaysShowCalendars: true,
	showCustomRangeLabel: false,
	drops: "auto",
	autoUpdateInput: false,
	opens: "center",
	locale: {
		format: "DD/MM/YYYY",
	},
});

dateRange.on( "apply.daterangepicker", function(event, picker) {
		
	let startDate = picker.startDate.format('DD/MM/YYYY');
	let endDate = picker.endDate.format('DD/MM/YYYY');
	this.value = `${ startDate } - ${ endDate }`;

	coursesDatatable.ajax.reload();

})

dateRange.on( 'cancel.daterangepicker', function(event, picker) {
	dateInput.value = "";
	coursesDatatable.ajax.reload();
})

//!##########################################
//!				script functions			#
//!##########################################

function toastAlert(icon, message) {
    Swal.fire({
        toast: 'true',
        position: 'top-end',
        icon: icon,
        title: message,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
}

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