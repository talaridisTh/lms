//!######################################
//! 				Imports				#
//!######################################
import utilities from '../main';

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
		type: "post"
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
		editInputInit()
	}
})

//!##############################################
//!				EventListeners Init				#
//!##############################################

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