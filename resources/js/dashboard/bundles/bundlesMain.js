//!######################################
//! 				Imports				#
//!######################################
import utilities from '../main';

//! EventListeners
//!==================

$("#submit-form-btn").click( function() {
	
	$("#new-bundle-form").submit()

});

$("#delete-bundles-btn").click( function() {
	let checkedBoxes = $(".js-bundle-checkbox:checked");
	let ids = [];

	for ( let i = 0; i < checkedBoxes.length; i++ ) {
		ids.push( checkedBoxes[i].dataset.bundleId );
	}

	Swal.fire({
		title: 'Είστε σίγουρος;',
		text: `${checkedBoxes.length} ${checkedBoxes.length == 1 ? " Bundle θα διαγραφεί" : " Bundles θα διαγραφούν"}`,
		icon: 'warning',
		showCancelButton: true,
		confirmButtonText: 'Ναί, διαγραφή!',
		cancelButtonText: 'Άκυρο'
	}).then( (result) => {

		if (result.value) {

			axios.delete(`/bundles/destroy/${ids}`)
			.then(function (response) {

				let message = checkedBoxes.length == 1 ? "Διεγράφη" : "Διαγράφηκαν"

				utilities.toastAlert( "success", message );

				bundlesDatatable.ajax.reload();
			})
			.catch(function (error) {
				
				utilities.toastAlert( "error", "Παρουσιάστηκε κάποιο πρόβλημα ..." );

			});
			
		}
	})
});

const bundlesDatatable = $("#bundle-table").DataTable({
	columns: [
		{ data: "action", name: "action", width: "5%", orderable: false, searchable: false },
		{ data: "name", name: "name", className: "js-link cursor-pointer"},
		{ data: "status", name: "status", width: "5%", searchable: false },
		{ data: "updated_at", name: "updated_at", className: "js-link cursor-pointer"},
		{ data: "created_at", name: "created_at", className: "js-link cursor-pointer"},
	],
	processing: true,
	serverSide: true,
	ajax: {
		url: "/bundles/bundles-datatable",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		type: "post"
	},
	language: utilities.tableLocale,
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		$(".js-remove-table-classes > thead > tr > th").removeClass("js-link cursor-pointer");

		jsLinkInit();
		activeToggleInit();
	}
})

function activeToggleInit() {

	let toggle = $(".js-toggle");

	toggle.change( function() {

		axios.patch( `/bundles/bundles-toggle-status/${this.dataset.bundleId}`, {
			state: this.checked ? 1 : 0
		})
		.then( (res) => {
			let icon = this.checked ? "success" : "info";
			let message = this.checked ? "Ενεργοποιήθηκε!" : "Απενεργοποιήθηκε";
			utilities.toastAlert( icon, message );
		})
		.catch( (err) => {
			utilities.toastAlert( "error", "Παρουσιάστηκε κάποιο πρόβλημα ..." );
		})
	});
}

function jsLinkInit() {

	$('.js-link').click( function() {
		let bundleId = this.parentElement.dataset.bundleId;

		window.location = `bundle/${bundleId}`;
	});

}