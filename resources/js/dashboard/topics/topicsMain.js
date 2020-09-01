//!######################################
//! 				Imports				#
//!######################################
import utilities from '../main';

//!##########################################
//! 				Datatables				#
//!##########################################
const topicsDatatable = $("#topics-datatable").DataTable({
	order: [1, "asc"],
	processing: true,
	serverSide: true,
	ajax: {
		url: "/topics/topics-datatable",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		type: "post"
	},
	columns: [
		{data: 'action', name: 'action', className: "align-middle", width: "5%", orderable: false },
		{data: 'title', name: 'title' },
		{data: 'updated_at', name: 'updated_at', className: "align-middle cursor-default js-updated-at" },
		{data: 'created_at', name: 'created_at',  className: "align-middle cursor-default"},
	],
	language: utilities.tableLocale,
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		$(".js-remove-table-classes > thead > tr > th").removeClass("cursor-pointer js-updated-at");

	}
})