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

				toastAlert( "success", message );

				bundlesDatatable.ajax.reload();
			})
			.catch(function (error) {
				
				toastAlert( "error", "Παρουσιάστηκε κάποιο πρόβλημα ..." );

			});
			
		}
	})
});

const bundlesDatatable = $("#bundle-table").DataTable({
	columns: [
		{ data: "action", name: "action", width: "5%", orderable: false, searchable: false },
		{ data: "name", name: "name", className: "js-link cursor-pointer"},
		{ data: "active", name: "active", width: "5%", searchable: false },
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
	language: {
		emptyTable: 		"Δεν υπάρχουν εγγραφές",
		info: 				"_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα",
		infoEmpty:      	"0 απο 0 τα 0 αποτελέσματα",
		lengthMenu: 		"_MENU_ Αποτελέσματα ανα σελίδα",
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
		$(".js-remove-table-classes > thead > tr > th").removeClass("js-link cursor-pointer");

		jsLinkInit();
		activeToggleInit();
	}
})

function activeToggleInit() {

	let toggle = $(".js-toggle");

	toggle.change( function() {

		axios.patch( `/bundles/bundles-toggle-active/${this.dataset.bundleId}`, {
			state: this.checked ? 1 : 0
		})
		.then( (res) => {
			let icon = this.checked ? "success" : "info";
			let message = this.checked ? "Ενεργοποιήθηκε!" : "Απενεργοποιήθηκε";
			toastAlert( icon, message );
		})
		.catch( (err) => {
			toastAlert( "error", "Παρουσιάστηκε κάποιο πρόβλημα ..." );
		})
	});
}

function jsLinkInit() {

	$('.js-link').click( function() {
		let bundleId = this.parentElement.dataset.bundleId;

		window.location = `bundle/${bundleId}`;
	});

}

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