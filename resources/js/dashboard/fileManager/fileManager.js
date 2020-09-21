//!######################################
//!					Imports				#
//!######################################
import utilities from "../main";

//!######################################
//!				Global Variables		#
//!######################################

let timer = 0;

//!######################################
//!				EventListeners			#
//!######################################

$("#file-search").on("input", searchHandler);

$(".js-gallery-page-btn").on( 'click', paginationHandler);

$(".custom-tabs").on( "click", function() {
	let tabs = $(".tab-pane");
	$(".custom-tabs.btn-dark").removeClass("btn-dark").addClass("btn-light");

	for ( let i = 0; i < tabs.length; i++ ) {
		tabs[i].style.display = "none";
	}

	this.classList.remove("btn-light");
	this.classList.add("btn-dark");
	document.getElementById(this.dataset.customTab).style.display = "block";
});

const fileManagerDatatable = $("#file-manager-datatable").DataTable({
	order: [ 1, "asc" ],
	columns: [
		// { data: "action", name: "action", className: "align-middle text-center", width: "5%", orderable: false, searchable: false },
		{ data: "image", className: "cursor-default", searchable: false, orderable: false },
		{ data: "original_name", name: "original_name", className: "cursor-default align-middle"},
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
		let lenthSelection = $("select[name='file-manager-datatable_length']");
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

//!######################################
//! 		Grid View Functions			#
//!######################################

function paginationHandler(event) {

	event.preventDefault();

	let activePage = this.href.split("page=")[1];
	let search = $("#file-search").val();

	paginationRequest( activePage, search );

}

function searchHandler() {

	clearTimeout(timer);

	if ( this.value.length < 3 || this.value == "" ) {
		timer = setTimeout(paginationRequest, 800, 1, "");
	}
	else {
		timer = setTimeout(paginationRequest, 800, 1, this.value);
	}

}

function paginationRequest( activePage, search) {

	axios.get( `/files`, {
		params: {
			page: activePage,
			search
		}
	})
	.then( (res) => {
		let gallery = $("#file-manager-content")[0]
		gallery.innerHTML = res.data;

		let pagination = gallery.getElementsByClassName("js-gallery-page-btn");

		for (let i = 0; i < pagination.length; i++) {
			pagination[i].removeEventListener("click", paginationHandler);
			pagination[i].addEventListener("click", paginationHandler);
		}
	})
	.catch( err => {
		console.log(err);
	})
}

//!##########################################
//!				Initializers				#
//!##########################################

let lengthLabel = document.querySelector("#file-manager-datatable_length > label");
let filter = document.getElementById("ext-table-filter")
lengthLabel.appendChild( filter );

$("#ext-table-filter").select2({
	minimumResultsForSearch: -1
});

$("#ext-table-filter").on("change", function() {
	fileManagerDatatable.column(3).search( this.value ).draw();
});

