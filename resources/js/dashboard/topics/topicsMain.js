//!######################################
//! 				Imports				#
//!######################################
import utilities from '../main';

//!##########################################
//!				EventListeners				#
//!##########################################

$("#select-all-topics").change( function() {

	let checkbox = $(".js-topic-checkbox");
	let bulk = $("#topic-bulk-action-btn")[0];

	utilities.minorCheckboxSwitcher( this, checkbox, bulk );

});

$("#delete-topics-btn").click( function() {
	
	let checkedBoxes = $(".js-topic-checkbox:checked");
	let ids = [];

	if ( checkedBoxes.length == 0 ) {
		Swal.fire('Δεν έχετε επιλέξει τίποτα');
		return;
	}

	for ( let i = 0; i < checkedBoxes.length; i++ ) {
		ids.push( checkedBoxes[i].dataset.topicId );
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
			
			axios.delete(`/topics/destroy/${ids}`)
			.then(function (response) {

				let message = checkedBoxes.length == 1 ? "Διεγράφη" : "Διαγράφηκαν"

				utilities.toastAlert( "success", message );

				topicsDatatable.ajax.reload();
				resetBulk( $("#topic-bulk-action-btn"), $("#select-all-topics") );
			})
			.catch(function (error) {
				
				utilities.toastAlert( "error", "Παρουσιάστηκε κάποιο πρόβλημα ..." );

			});
			
		}
	})

})

//!##########################################
//! 				Datatables				#
//!##########################################
const topicsDatatable = $("#topics-datatable").DataTable({
	order: [3, "desc"],
	processing: true,
	serverSide: true,
	ajax: {
		url: "/topics/topics-datatable",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		type: "post",
		data: function( d ) {
			return $.extend( {}, d, {
				startDate: utilities.startDate( $("#topic-date-range")[0] ),
				endDate: utilities.endDate( $("#topic-date-range")[0] ),
			})
		}
	},
	columns: [
		{data: 'action', name: 'action', className: "align-middle", width: "5%", orderable: false },
		{data: 'title', name: 'title' },
		{data: 'updated_at', name: 'updated_at', className: "align-middle cursor-default js-updated-at" },
		{data: 'created_at', name: 'created_at',  className: "align-middle cursor-default"},
	],
	language: utilities.tableLocale,
	fnInitComplete: function( oSettings, json ) {
		let lenthSelection = $("select[name='topics-datatable_length']");
		lenthSelection.addClass("select2");

		lenthSelection.select2({
			minimumResultsForSearch: -1,
		});
	},
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		$(".js-remove-table-classes > thead > tr > th").removeClass("cursor-pointer js-updated-at");

		showEditInit();
		editInputInit();
		topicCheckboxesInit();
	}
});

//!##############################################
//!				Datatable Filters				#
//!##############################################

let searchFieldLabel = $("#topics-datatable_filter > label > input")[0];
let dateInput = utilities.createDateElm( "topic-date-range" );

dateInput.appendBefore( searchFieldLabel );
dateInput.addEventListener("input", function() {

	this.value = this.value.replace( /[^0-9]/g, "" )
		.replace(/^(\d{2})?(\d{2})?(\d{4})?(\d{2})?(\d{2})?(\d{4})?/g, '$1/$2/$3 - $4/$5/$6')
		.substr(0, 23)

});

let dateRange = $("#topic-date-range");

dateRange.daterangepicker( utilities.datePickerConfig );

dateRange.on( "apply.daterangepicker", function(event, picker) {
		
	let startDate = picker.startDate.format('DD/MM/YYYY');
	let endDate = picker.endDate.format('DD/MM/YYYY');

	this.classList.add("select2-selected");
	this.value = `${ startDate } - ${ endDate }`;

	topicsDatatable.ajax.reload();

});

dateRange.on( 'cancel.daterangepicker', function(event, picker) {

	this.classList.remove("select2-selected");
	dateInput.value = "";
	topicsDatatable.ajax.reload();

});

//!##############################################
//!				EventListeners Init				#
//!##############################################

function topicCheckboxesInit() {

	let primaryCheckbox = $("#select-all-topics")[0];
	let topicCheckbox = $(".js-topic-checkbox");
	let bulk = $("#topic-bulk-action-btn")[0];
	
	topicCheckbox.change( function() {
		utilities.mainCheckboxSwitcher(primaryCheckbox, topicCheckbox, bulk );
	});

}

function showEditInit() {
	let editBtns = $(".js-quick-edit");

	editBtns.click( function() {
		let row = this.findParent(2);
		let title = row.getElementsByClassName("js-title")[0];
		let input = row.getElementsByClassName("js-edit")[0];
		let valueLen = input.value.length;

		title.classList.add("d-none");
		input.classList.remove("d-none");
		input.focus();
		input.setSelectionRange(valueLen, valueLen);
	});
}

function editInputInit() {

	let editInputs = $(".js-edit");
	
	editInputs.on( 'blur', function() {
		let row = this.findParent(2);
		let title = row.getElementsByClassName("js-title")[0];

		title.classList.remove("d-none");
		this.classList.add("d-none");
		this.classList.remove("is-invalid");
		this.value = this.defaultValue;
	});

	editInputs.on( "keyup", function() {
		if ( event.keyCode == 13 ) {
			if ( this.value == "" ) {
				this.classList.add("is-invalid");
				return
			}
			let row = this.findParent(2);
			let title = row.getElementsByClassName("js-title")[0];

			title.classList.remove("d-none");
			this.classList.add("d-none");

			updateTopic(this)
		}
		
		this.classList.remove("is-invalid");

	})
}

function updateTopic( input ) {
	let id = input.dataset.topicId;
	let title = input.value;

	axios.patch( `/topics/update/${id}`, {
		title
	})
		.then( res => {
			topicsDatatable.ajax.reload();
			utilities.toastAlert("success", "Το topic ενημερώθηκε.");
		})
		.catch( err => {
			if ( err.response.status == 422 ) {
				utilities.toastAlert( "info", "Πρέπει να δώσετε τίτλο..." );
				input.value = input.defaultValue;
			}
			else {

				console.log(err.response.status);
				utilities.toastAlert( "error", "Παρουσιάστηκε κάποιο πρόβλημα ..." );
			}
		})

}

//!##########################################
//!					Functions				#
//!##########################################

function resetBulk( bulkBtn, checkbox ) {

	bulkBtn.text("Επιλογές  (0)");
	bulkBtn.addClass("btn-secondary");
	bulkBtn.removeClass("btn-warning");
	bulkBtn.prop("disabled", true);
	checkbox.prop("checked", false);
}