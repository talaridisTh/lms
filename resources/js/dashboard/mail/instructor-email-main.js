import utilities from "../main";
import { deleteMails, swalDelete } from "./mail-helpers";

async function deleteBtnHandler() {
	try {
		const {isConfirmed} = await swalDelete();

		if ( !isConfirmed ) return;

		deleteMails("/email/instructor-delete", [this.dataset.mailId], instructorsMailsDatatable);
	}
	catch (err) {
		console.log(err);
		utilities.toastAlert("error", "Κάποιο σφάλμα παρουσιάστηκε ...")
	}

}

function checkeBoxesEventListener() {

	let minorCheckboxes = $(".js-mail-checkbox");
	let mainCheckbox = $("#select-all-mails")[0];
	let bulkBtn = $("#mail-delete-btn")[0];

	minorCheckboxes.on("change", function() {
		utilities.mainCheckboxSwitcher( mainCheckbox, minorCheckboxes, bulkBtn)
	});
}


const instructorsMailsDatatable = $("#instructor-mails-datatable").DataTable({
	order: [0, "desc"],
	searchDelay: "1000",
	autoWidth: false,
	columnDefs: [
		{ targets: 1, width: "50px"},
		{ targets: 3, width: "250px"},
	],
	processing: true,
	serverSide: true,
	ajax: {
		url: "/email/instructors-data-table",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		type: "post",
		// data: function( d ) {
		// 	return $.extend( {}, d, {
		// 		startDate: startDate( $("#course-date-range")[0] ),
		// 		endDate: endDate( $("#course-date-range")[0] ),
		// 	})
		// }
	},
	columns: [
		{ data: 'id', name: "id", visible: false },
		{ data: 'action', name: 'action', className: "align-middle text-center", searchable:false, orderable: false },
		{ data: 'message', className: "align-middle" },
		{ data: 'details', className: "align-middle position-relative", searchable:false, orderable: false },
		{ data: 'sent_at', name: "sent_at", visible: false },
	],
	language: utilities.tableLocale,
	fnInitComplete: function( oSettings, json ) {
		let lenthSelection = $("select[name='instructor-mails-datatable_length']");

		lenthSelection.select2({
			minimumResultsForSearch: -1,
		});
	},
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");

		checkeBoxesEventListener();
		utilities.resetBulk( $("#mail-delete-btn"), $("#select-all-mails"), "Διαγραφή (0)");
		$(".js-delete-mail").on("click", deleteBtnHandler);
	}
});

$("#mail-delete-btn").on("click", async function() {

	const selectedMails = $(".js-mail-checkbox:checked");
	const mailIds = [];

	for (let i = 0; i < selectedMails.length; i++) {
		mailIds.push(selectedMails[i].dataset.mailId);
	}

	try {
		const {isConfirmed} = await swalDelete();

		if ( !isConfirmed ) return;

		deleteMails("/email/instructor-delete", mailIds, instructorsMailsDatatable);
	}
	catch (err) {
		console.log(err);
		utilities.toastAlert("error", "Κάποιο σφάλμα παρουσιάστηκε...");
	}
});

$("#select-all-mails").on("change", function() {
	let minorCheckboxes = $(".js-mail-checkbox");
	let bulkBtn = $("#mail-delete-btn")[0];

	utilities.minorCheckboxSwitcher(this, minorCheckboxes, bulkBtn );

});