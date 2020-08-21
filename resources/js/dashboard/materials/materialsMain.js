import utilities from '../main';

const materialsDatatable = $("#materials-datatable").DataTable({
	dom: 'lfrtip',

	order: [1, "asc"],
	processing: true,
	serverSide: true,
	ajax: {
		url: "/materials/materials-datatable",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		type: "post"
	},
	columns: [
		{ data: "action", name: "action", width: "5%", searchable: false, orderable: false },
		{ data: "title", name: "title", className: "js-link cursor-pointer" },
		{ data: "active", name: "active", width: "5%", searchable: false },
		{ data: "type", name: "type", className: "js-link cursor-pointer" },
		{ data: "updated_at", name: "updated_at",  className: "js-link cursor-pointer js-updated-at" },
		{ data: "created_at", name: "created_at",  className: "js-link cursor-pointer" },
	],
	language:{
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
		$(".js-remove-table-classes > thead > tr > th").removeClass("js-link cursor-pointer js-updated-at");
		atLinkEventListener();
		toggleInit();
	}
});


function toggleInit() {
	$(".js-toggle").change( function() {

		let materialId = this.dataset.materialId
		let updatedAtCnt = this.parentElement.parentElement.getElementsByClassName("js-updated-at")[0];
		
		axios.patch( `/materials/toggle-active/${materialId}`, {
			state: this.checked ? 1 : 0
		})
		.then( (res) => {
			let icon = this.checked ? "success" : "info";
			let message = this.checked ? "Ενεργοποιήθηκε" : "Απενεργοποιήθηκε";
			utilities.toastAlert( icon, message );
			updatedAtCnt.textContent = "Μόλις τώρα";
		})
		.catch( (err) => {
			utilities.toastAlert( "error", "Παρουσιάστηκε κάποιο πρόβλημα ..." );
		})
	});
}

function atLinkEventListener() {
	$('.js-link').click( function() {
		let materialId = this.parentElement.dataset.materialId;

		window.location = `material/${materialId}`;
	});
}