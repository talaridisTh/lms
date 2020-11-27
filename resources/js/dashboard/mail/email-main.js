import utilities from "../main";

const mailsDatatable = $("#mails-datatable").DataTable({
	order: [0, "desc"],
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
		{ data: 'id', visible: false},
		{ data: 'action', name: 'action', className: "align-middle text-center", searchable:false, orderable: false },
		{ data: 'message' },
		{ data: 'details', className: "align-middle", searchable:false, orderable: false },
		{ data: 'sent_at', name: "sent_at", visible: false },
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

const lengthCnt = document.querySelector("#mails-datatable_length > label");
const statusFilter = document.getElementById("status-filter");

lengthCnt.after(statusFilter);

$(statusFilter).select2({
	width: "125px",
	minimumResultsForSearch: -1
});

$(statusFilter).on("change", function() {
	//! to value einai REGEX! sto draft kanei match empty strings!
	mailsDatatable.column( 3 ).search( this.value, true, false ).draw();

})

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