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
		{ data: 'details' },
		{
			data: 'sent_at',
			name: 'sent_at',
			className: "align-middle text-center cursor-default",
			render: function(data) {
				const oneDay = new Date().getTime() + (24 * 60 * 60 * 1000);
				const date = new Date(data);
				const hours = date.toLocaleString('default', { hour: 'numeric', minute: 'numeric', hour12: true });
				const month = date.toLocaleString('default', { day: 'numeric', month: 'short' });
				
				if ( oneDay > date.getTime() ) {
					return `<p class="mb-0"><strong>${hours}</strong></p>`;
				}
				else {
					return `<p class="mb-0"><strong>${month}</strong></p>`;
				}
			}
		},
		{ data: 'status', name: 'status', visible: false },
	],
	language: utilities.tableLocale,
	fnInitComplete: function( oSettings, json ) {
		let lenthSelection = $("select[name='mails-datatable_length']");
		lenthSelection.addClass("select2");

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