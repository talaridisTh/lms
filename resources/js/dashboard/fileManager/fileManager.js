//!######################################
//!					Imports				#
//!######################################
import utilities from "../main";

const fileManagerDatatable = $("#file-manager-datatable").DataTable({
	order: [ 3, "desc" ],
	columns: [
		{ data: "action", name: "action", className: "align-middle text-center", width: "5%", orderable: false, searchable: false },
		{ data: "image", className: "cursor-default"},
		{ data: "title", name: "title", className: "cursor-default"},
		{ data: "type", name: "type", className: "align-middle text-center", width: "5%", searchable: false },
		{ data: "ext", name: "ext", className: "align-middle text-center cursor-default"},
		{ data: "size", name: "size", className: "align-middle text-center cursor-default" },
	],
	processing: true,
	serverSide: true,
	ajax: {
		url: "/file-manager",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		type: "post",
		data: function( d ) {
			return $.extend( {}, d, {
				startDate: utilities.startDate( $("#bundle-date-range")[0] ),
				endDate: utilities.endDate( $("#bundle-date-range")[0] ),
			})
		}
	},
	language: utilities.tableLocale,
	fnInitComplete: function( oSettings, json ) {
		let lenthSelection = $("select[name='bundle-table_length']");
		lenthSelection.addClass("select2");

		lenthSelection.select2({
			minimumResultsForSearch: -1,
		});
	},
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		$(".js-remove-table-classes > thead > tr > th").removeClass("cursor-default");

		// activeToggleInit();
	}
});