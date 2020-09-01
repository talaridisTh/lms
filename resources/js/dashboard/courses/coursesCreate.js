//!######################################
//! 				Imports				#
//!######################################

import utilities from '../main';
import Dropzone from "../../../plugins/dropzone/js/dropzone";
import ArticleEditor from "../../../plugins/article-editor/article-editor"

//!######################################
//!				Datatables				#
//!######################################

// let allMaterialsTable = $("#all-materials-table").DataTable({
// 	language: utilities.tableLocale,
// });

// let allUsersTable = $("#all-materials-table").DataTable({
// 	language: utilities.tableLocale,
// })

let selectedMaterialsTable = $("#selected-materials-table").DataTable({
	order: [ 3, "asc" ],
	data: [ 
		/* ["<strong><i>1</i></strong>", 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7]  */],
	language: utilities.tableLocale,
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		$(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
		$(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
		$(".js-remove-table-classes > thead > tr > th").removeClass("cursor-default");
	},
});

let selectedUsersTable = $("#selected-users-table").DataTable({
	order: [ 3, "asc" ],
	data: [ 
		/* ["<strong><i>1</i></strong>", 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7], 
		[1, 2, 3, 4, 5, 6, 7]  */],
	language: utilities.tableLocale,
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		$(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
		$(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
		$(".js-remove-table-classes > thead > tr > th").removeClass("cursor-default");
	},
});

//!######################################
//!				initializations			#
//!######################################

$("#publish-date-select").daterangepicker({
	singleDatePicker: true,
	drops: "auto",
	// autoUpdateInput: false,
    opens: "center",
	timePicker: true,
	timePicker24Hour: true,

	locale: {
        format: "DD-MM-YYYY H:mm",
    },
});

$R("#summary", utilities.redactorConfig);

ArticleEditor('#description', {
	// css: "/css/",
	custom: {
		css: [
			// "/css/app.css"
		]
	},
	editor: {
		minHeight: "300px"
	},
	// classes: {
	// 	'p': 'text-muted',
	// 	'h1': 'text-muted',
	// 	'h2': 'text-muted',
	// 	'h3': 'text-muted',
	// 	'h4': 'text-muted',
	// 	'h5': 'text-muted',
	// }
	/* image: {
		upload: "/materials/upload-content-images",
		data: {
			"_token": $('meta[name="csrf-token"]').attr('content')
		}
	} */
});

let dropzone = new Dropzone("#cover-dropzone", {
	previewTemplate: $("#uploadPreviewTemplate").html(),
	// url: "/target-url",
  	thumbnailWidth: 80,
  	thumbnailHeight: 80,
});