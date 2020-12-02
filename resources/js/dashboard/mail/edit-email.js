import utilities from '../main';

const historyDatatable = $("#history-datatable").DataTable({
	// order: [1, "asc"],
	// processing: true,
	// serverSide: true,
	// ajax: {
	// 	url: "/email/select-users",
	// 	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	// 	type: "post",
	// 	data: function( d ) {
	// 		return $.extend( {}, d, {
	// 			recipients: sessionStorage.getItem("recipients")
	// 		})
	// 	}
	// },
	// columns: [
	// 	{ data: 'action', name: 'action', className: "align-middle text-center", orderable: false },
	// 	{ data: 'name', name: 'users.last_name', className: "align-middle" },
	// 	{ data: 'courses', name: 'courses.title', className: "align-middle text-center text-wrap" },
	// 	{ data: 'bundles', name: 'bundles.title', className: "align-middle text-center text-wrap" },
	// 	{ data: 'btn', className: "align-middle text-center text-wrap", orderable: false, searchable: false },

	// ],
	language: utilities.tableLocale,
	fnInitComplete: function( oSettings, json ) {
		let lenthSelection = $("select[name='history-datatable_length']");

		lenthSelection.select2({
			minimumResultsForSearch: -1,
		});
	},
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");

		// $(".js-add-recipient").on("click", addRecipientHandler);
	}
});