import utilities from "../main";

const mailsDatatable = $("#mails-datatable").DataTable({
	// order: [6, "desc"],
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
		{ data: 'action', name: 'action', className: "align-middle text-center", searchable:false, orderable: false },
		{ data: 'message' },
		{ data: 'details', className: "align-middle", searchable:false, orderable: false },
		{ data: 'sent_at', name: "sent_at", visible: false },
	],
	language: utilities.tableLocale,
	fnInitComplete: function( oSettings, json ) {
		let lenthSelection = $("select[name='mails-datatable_length']");
		// lenthSelection.addClass("select2");

		lenthSelection.select2({
			minimumResultsForSearch: -1,
		});
	},
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		// $(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
		// $(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
		// $(".js-remove-table-classes > thead > tr > th").removeClass("cursor-pointer");

		// toggleStatus();
		// checkeBoxesEventListener();
		// cloneEventListener();
		// utilities.resetBulk( $("#course-bulk-action-btn"), $("#select-all-courses"));
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