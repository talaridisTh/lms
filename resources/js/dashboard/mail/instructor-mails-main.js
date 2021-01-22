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