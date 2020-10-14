//!######################################
//! 				Imports				#
//!######################################
import utilities from '../main';
import ArticleEditor from "../../../plugins/article-editor/article-editor"
require("../../../plugins/article-editor/plugins/reorder/reorder");

// Create a plugin
ArticleEditor.add('plugin', 'mediaLibrary', {
    start: function() {
        this.app.addbar.add('mediaButton', {
            title: 'Media Library',
            icon: "<i class='mdi mdi-book-open-page-variant'></i>'",
            command: 'mediaLibrary.modal'
        });
    },
    modal: function(params, button) {
		let id = this.app.$element.nodes[0].id;
		this.app.popup.close();
		$('#gallery-content')[0].dataset.editorId = `#${id}`
		$('#gallery-content')[0].dataset.type = "article"
        $('#gallery-modal').modal('show')
    }
});

utilities.articleConfig.plugins = ['mediaLibrary', 'reorder'];

ArticleEditor("#first-section-textarea", utilities.articleConfig);
ArticleEditor("#second-section-textarea", utilities.articleConfig);
ArticleEditor("#third-section-textarea", utilities.articleConfig);
ArticleEditor("#fourth-section-textarea", utilities.articleConfig);
ArticleEditor("#fifth-section-textarea", utilities.articleConfig);

//!##########################################
//!					DataTables				#
//!##########################################

const materialsDatatable = $("#materials-datatable").DataTable({
	order: [0, "asc"],
	dom: "<'d-flex justify-content-center'f>t<'d-flex justify-content-center'p>",
    processing: true,
    serverSide: true,
    ajax: {
        url: "/home-content/simple-materials-datatable",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "post"
    },
    columns: [
		{data: 'title', name: 'title', className: "align-middle"},
        {data: 'action', name: 'action', className: "align-middle text-center", width: "5%", orderable: false},
    ],
    language: utilities.tableLocale,
    fnInitComplete: function (oSettings, json) {
        // let lenthSelection = $("select[name='topics-datatable_length']");
        // lenthSelection.addClass("select2");

        // lenthSelection.select2({
        //     minimumResultsForSearch: -1,
        // });
    },
    drawCallback: function () {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        $(".js-remove-table-classes > thead > tr > th").removeClass("d-none cursor-pointer js-updated-at js-colspan");

    }
});

const coursesDatatable = $("#courses-datatable").DataTable({
	order: [0, "asc"],
	dom: "<'d-flex justify-content-center'f>t<'d-flex justify-content-center'p>",
    processing: true,
    serverSide: true,
    ajax: {
        url: "/home-content/simple-courses-datatable",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "post"
    },
    columns: [
		{data: 'title', name: 'title', className: "align-middle"},
		{ data: 'topics', name: 'topics', className: "align-middle text-wrap" },
        {data: 'action', name: 'action', className: "align-middle text-center", width: "5%", orderable: false},
    ],
    language: utilities.tableLocale,
    drawCallback: function () {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        $(".js-remove-table-classes > thead > tr > th").removeClass("d-none cursor-pointer js-updated-at js-colspan");

    }
});

const bundlesDatatable = $("#bundles-datatable").DataTable({
	order: [0, "asc"],
	dom: "<'d-flex justify-content-center'f>t<'d-flex justify-content-center'p>",
    processing: true,
    serverSide: true,
    ajax: {
        url: "/home-content/simple-bundles-datatable",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "post"
    },
    columns: [
		{data: 'title', name: 'title', className: "align-middle"},
        {data: 'action', name: 'action', className: "align-middle text-center", width: "5%", orderable: false},
    ],
    language: utilities.tableLocale,
    drawCallback: function () {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        $(".js-remove-table-classes > thead > tr > th").removeClass("d-none cursor-pointer js-updated-at js-colspan");

    }
});

//!##################################################
//!					EventListeners					#
//!##################################################

$("#edit-banners-modal").on("show.bs.modal", function(event) {
	const button = event.relatedTarget;
	const type = button.dataset.type;
	const title = type == "materials" 
		? "Μαθήματα" : capitalizeFirst(type);

	$("#table-title").text(title);
	$(".js-type").addClass("d-none");
	$(".js-banner-selection").addClass("d-none");
	$(`#${type}-card`).removeClass("d-none");
	$(`#${button.dataset.importance}-banner-selection`).removeClass("d-none");
	$("#type-select").val(type);
	$("#type-select").trigger("change");
	utilities.toastAlert("info", "Under Development");
})

$("#image-search").on("input", utilities.searchHandler);

$(".js-gallery-page-btn").on( 'click', utilities.paginationHandler);

$(".js-add-image").on( "click", utilities.imageHandler);

$("#type-select").on("change", function() {
	$(".js-type").addClass("d-none");
	$(`#${this.value}-card`).removeClass("d-none");
	let title = this.value == "materials" ? "Μαθήματα" : capitalizeFirst(this.value);

	$("#table-title").text(title);
});

//!######################################
//!				Functions				#
//!######################################

function capitalizeFirst(string) {

	return string[0].toUpperCase() + string.slice(1);

}