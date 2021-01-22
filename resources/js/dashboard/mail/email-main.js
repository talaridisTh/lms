import utilities from "../main";

const mailsDatatable = $("#mails-datatable").DataTable({
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
		url: "/email/data-table",
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
		{ data: 'author.last_name', name: "author.last_name", className: "align-middle text-center" },
		{ data: 'details', className: "align-middle position-relative", searchable:false, orderable: false },
		{ data: 'sent_at', name: "sent_at", visible: false },
		{ data: 'subject', name: "subject", visible: false },
	],
	language: utilities.tableLocale,
	fnInitComplete: function( oSettings, json ) {
		let lenthSelection = $("select[name='mails-datatable_length']");

		lenthSelection.select2({
			minimumResultsForSearch: -1,
		});
	},
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");

		$(".js-delete-mail").on("click", deleteBtnHandler);
	}
});

async function deleteBtnHandler() {
	try {
		const {isConfirmed} = await swalDelete();

		if ( !isConfirmed ) return;

		await axios.post("/email/delete", {
			mailIds: [this.dataset.mailId]
		});

		mailsDatatable.ajax.reload(null, false)
	}
	catch (err) {
		console.log(err);
		utilities.toastAlert("error", "Κάποιο σφάλμα παρουσιάστηκε ...")
	}
}

function swalDelete() {

	return Swal.fire({
		title: "Διαγραφή;",
		text: "Η ενέργεια θα είναι μη αναστρέψιμη...",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#ff5b5b',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ναι, διαγραφή!',
		cancelButtonText: 'Άκυρο!',
	});
}