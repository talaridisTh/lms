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

		addMaterialBannerInit();
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

		addCourseBannerInit();
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

		addBundleBannerInit();
    }
});

//!##################################################
//!			Datatable EveneListeners Inits			#
//!##################################################
	//? PS an tolmas balta se ena init!!!
function addMaterialBannerInit() {

	$(".js-add-material-banner").off(addBannerHandler);
	$(".js-add-material-banner").on("click", addBannerHandler);
}

function addCourseBannerInit() {

	$(".js-add-course-banner").off(addBannerHandler);
	$(".js-add-course-banner").on("click", addBannerHandler);
}

function addBundleBannerInit() {

	$(".js-add-bundle-banner").off(addBannerHandler);
	$(".js-add-bundle-banner").on("click", addBannerHandler);
}
	//? ./PS

//!##################################################
//!					EventListeners					#
//!##################################################

$("#edit-banners-modal").on("hide.bs.modal", resetBannersModalHandler);

$("#change-category-btn").on("click", function() {

	const importance = this.dataset.importance;
	const type = this.dataset.type;

	Swal.fire({
		title: 'Είστε σίγουρος/η;',
		html: "<p class='mb-0'>Η ενέργεια θα αφαιρέσει τα ήδη</p>επιλεγμέμα banner.",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#536de6',
		confirmButtonText: 'Ναι, αφαίρεση!',
		cancelButtonText: 'Άκυρο'
	}).then( (result) => {

		if (result.isConfirmed) {
			this.classList.add("d-none");
			$("#type-select-cnt").removeClass("d-none");
			$("#type-select").val(type);
			$("#type-select").attr("data-importance", importance);
			$("#type-select").trigger("change");
		}
	})

})

$(".js-remove-callout").on("click", function() {

	const mainCnt = this.findParent(3);
	this.findParent(2).classList.add("d-none");
	const activeChildren = mainCnt.querySelectorAll(".callout:not(.d-none)");

	if (activeChildren.length == 0) {
		mainCnt.getElementsByClassName("js-empty-callout")[0]
			.classList.remove("d-none");
	}
})

$("#edit-banners-modal").on("show.bs.modal", function(event) {
	const button = event.relatedTarget;
	const type = button.dataset.type;
	const modalTitle = button.dataset.modalTitle
	const importance = button.dataset.importance
	const title = type == "materials" 
		? "Μαθήματα" : capitalizeFirst(type);

	$("#table-title").text(title);
	$("#edit-banners-modalLabel").text(modalTitle);
	$(".js-category-table-cnt").addClass("d-none");
	$(".js-banner-selection-cnt").addClass("d-none");
	$(`#${type}-card`).removeClass("d-none");
	$(`#${importance}-banner-selection`).removeClass("d-none");
	$("#change-category-btn").attr("data-importance", importance);
	$("#change-category-btn").attr("data-type", type);
})

$("#image-search").on("input", utilities.searchHandler);

$(".js-gallery-page-btn").on( 'click', utilities.paginationHandler);

$(".js-add-image").on( "click", utilities.imageHandler);

$("#type-select").on("change", function() {

	const importance = this.dataset.importance;
	const selectionCnt = $(`#${importance}-banner-selection`);

	$(".js-category-table-cnt").addClass("d-none");
	$(`#${this.value}-card`).removeClass("d-none");
	let title = this.value == "materials" ? "Μαθήματα" : capitalizeFirst(this.value);

	clearCallouts( selectionCnt );

	$("#table-title").text(title);
	$("#save-banners-btn").attr("data-table", this.value);
});

//!######################################
//!				Functions				#
//!######################################

function capitalizeFirst(string) {

	return string[0].toUpperCase() + string.slice(1);

}

function createSelectedCallout(id, title, subtitle, cover) {
	
	const newCallout = document.createElement("div");
	newCallout.classList.add("js-selected-banner", "callout", "callout-warning");
	newCallout.dataset.modelId = id;
	newCallout.dataset.modelCover = cover;

	newCallout.innerHTML = `<div class="d-flex justify-content-between mb-1">
			<h5>${ title }</h5>
			<button class="close"><span>×</span></button>
		</div>
		<p>${ subtitle }</p>`;

	const closeBtn = newCallout.getElementsByClassName("close")[0];
	closeBtn.addEventListener("click", removeNewlySelectedHandler);
	
	return newCallout;
}

function clearCallouts( container ) {

	container.find(".js-active-banner").addClass("d-none");
	container.find(".js-selected-banner").remove();
	container.find(".js-empty-callout").removeClass("d-none");

}

//!###########################################
//!					Eventhandlers			 #
//!###########################################

function removeNewlySelectedHandler() {

	const mainCnt = this.findParent(3);
	this.findParent(2).remove();

	const activeChildren = mainCnt.querySelectorAll(".callout:not(.d-none)");

	if (activeChildren.length == 0) {
		mainCnt.getElementsByClassName("js-empty-callout")[0]
			.classList.remove("d-none");
	}

}

function addBannerHandler() {

	const container = $(".js-banner-selection-cnt:not(.d-none) > .card-body")[0];
	const children = container.querySelectorAll(".callout:not(.d-none)");
	const emptyCallout = container.getElementsByClassName("js-empty-callout")[0];
	const id = this.dataset.modelId;
	
	for ( let i = 0; i < children.length; i++ ) {
		if (children[i].dataset.modelId == id) {
			utilities.toastAlert("warning", "Το Banner είναι ήδη επιλεγμένο...")
			return false;
		}
	}
	const title = this.dataset.modelTitle;
	const subtitle = this.dataset.modelSubtitle;
	const cover = this.dataset.modelCover;
	if ( children.length > 2 ) {
		Swal.fire({
			icon: 'info',
			title: 'Προσοχή!',
			text: 'Έχετε φτάσει τον μέγιστο αριθμό banner.',
			confirmButtonColor: '#536de6',
		})
		return false;
	}
	emptyCallout.classList.add("d-none");
	const newCallout = createSelectedCallout(id, title, subtitle, cover);
	
	container.append( newCallout );
}

function resetBannersModalHandler() {
	const categories = $(".js-banner-selection-cnt");
	let activeBanners, selectedBanners;

	$("#type-select-cnt").addClass("d-none");
	$("#change-category-btn").removeClass("d-none");

	for( let i = 0; i < categories.length; i++ ) {

		activeBanners = categories[i].getElementsByClassName("js-active-banner");
		selectedBanners = categories[i].getElementsByClassName("js-selected-banner");
		
		for ( let j = 0; j < activeBanners.length; j++ ) {
			activeBanners[j].classList.remove("d-none");
		}

		while ( selectedBanners.length != 0 ) {
			selectedBanners[0].remove();
		}

		if ( activeBanners.length > 0 ) {
			categories[i].getElementsByClassName("js-empty-callout")[0]
				.classList.add("d-none");
		}
		else {
			categories[i].getElementsByClassName("js-empty-callout")[0]
				.classList.remove("d-none");
		}

	}

}