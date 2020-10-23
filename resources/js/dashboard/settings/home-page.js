//!######################################
//! 				Imports				#
//!######################################
import utilities from '../main';
import ArticleEditor from "../../../plugins/article-editor/article-editor"
require("../../../plugins/article-editor/plugins/reorder/reorder");
import dragula from "../../../theme/js/vendor/dragula.min.js";

// require("../../../theme/js/vendor/dragula.min.js");

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

$(".js-carousel-switch").on("change", function() {
	
	const bannersData = bannerJsonBuilder();


	axios.patch( "/home-content/banners-update", {
		updatedData: bannersData,
		selectedBanners: false
	})
	.then( res => {
		if ( this.checked ){
			utilities.toastAlert("success", "Το Carousel ενεργοποιήθηκε.");
		}
		else {
			utilities.toastAlert("info", "Το Carousel απενεργοποιήθηκε...");
		}
	})
	.catch( err => {
		console.log(err);
		utilities.toastAlert( "error", "Παρουσιάστηκε κάποιο πρόβλημα ..." );
	})
})

$("#save-banners-btn").on("click", function() {

	const importance = this.dataset.importance;
	const newBanners = setDefaultBanners( importance );
	const bannerJson = bannerJsonBuilder(importance, newBanners);

	updateBannerData( importance, bannerJson, newBanners );

})

$("#edit-banners-modal").on("hide.bs.modal", resetBannersModalHandler);

$("#change-category-btn").on("click", function() {

	const importance = this.dataset.importance;
	const table = this.dataset.table;

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
			$("#type-select").val(table);
			$("#type-select").attr("data-importance", importance);
			$("#type-select").trigger("change");
		}
	})

})

//? an mpei me jQuery den boleuei stin afairesi tou event argotera
const removeCallout = document.getElementsByClassName("js-remove-callout");
for ( let i = 0; i < removeCallout.length; i++ ) {
	removeCallout[i].addEventListener("click", hideCalloutHandler);
}

$("#edit-banners-modal").on("show.bs.modal", function(event) {
	const button = event.relatedTarget;
	const modalTitle = button.dataset.modalTitle;
	const importance = button.dataset.importance;

	$("#edit-banners-modalLabel").text(modalTitle);
	$(".js-banner-selection-cnt").addClass("d-none");
	$(`#${importance}-banner-selection`).removeClass("d-none");
	$("#save-banners-btn").attr("data-importance", importance);
})

$("#image-search").on("input", utilities.searchHandler);

$(".js-gallery-page-btn").on( 'click', utilities.paginationHandler);

$(".js-add-image").on( "click", utilities.imageHandler);

$("#type-select").on("change", function() {

	const importance = this.dataset.importance;
	const selectionCnt = $(`#${importance}-banner-selection`);
	let namespace;

	if (this.value == "materials") {
		namespace = "App\\Material";
	}
	else if (this.value == "courses") {
		namespace = "App\\Course";
	}
	else {
		namespace = "App\\Bundle";
	}

	selectionCnt.attr("data-namespace", namespace);

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

function createSelectedCallout(id, title, subtitle, namespace) {
	
	const newCallout = document.createElement("div");
	newCallout.classList.add("js-selected-banner", "callout", "callout-warning");
	newCallout.dataset.modelId = id;
	newCallout.dataset.namespace = namespace;

	newCallout.innerHTML = `<div class="d-flex justify-content-between mb-1">
			<h5>${ title }</h5>
			<button class="close"><span>×</span></button>
		</div>
		<p>${ subtitle }</p>`;

	const closeBtn = newCallout.getElementsByClassName("close")[0];
	closeBtn.classList.add("js-remove-callout");
	closeBtn.addEventListener("click", removeNewlySelectedHandler);
	
	return newCallout;
}

function clearCallouts( container ) {

	container.find(".js-active-banner").addClass("d-none");
	container.find(".js-selected-banner").remove();
	container.find(".js-empty-callout").removeClass("d-none");

}

function updateBannerData( importance, updatedData, selectedBanners ) {

	axios.patch( "/home-content/banners-update", {
		updatedData, selectedBanners
	})
	.then( res => {
		$(`#${importance}-banners-row`).html(res.data);
		$("#edit-banners-modal").modal("hide");
		showOverflowBtn();
		overflowBtnInit();
		utilities.toastAlert("success", "Τα Banners άλλαξαν.")
	})
	.catch( err => {
		console.log(err);
		utilities.toastAlert( "error", "Παρουσιάστηκε κάποιο πρόβλημα ..." );
	})
}

//!###########################################
//!					Eventhandlers			 #
//!###########################################

function showMoreBtnHandler() {
	const container = this.findParent(2);
	const subtitle = container.getElementsByClassName("js-overflow-check")[0];
	subtitle.classList.toggle("height-auto");
	
	if ( subtitle.classList.contains("height-auto") ) {
			this.textContent = "Λιγότερα...";
	}
	else {
		this.textContent = "Περισσότερα...";
	}
}

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
	const namespace = this.dataset.namespace;
	
	for ( let i = 0; i < children.length; i++ ) {
		if (children[i].dataset.modelId == id && children[i].dataset.namespace == namespace) {
			utilities.toastAlert("warning", "Το Banner είναι ήδη επιλεγμένο...")
			return false;
		}
	}
	if ( children.length > 10 ) {
		Swal.fire({
			icon: 'info',
			title: 'Προσοχή!',
			text: 'Έχετε φτάσει τον μέγιστο αριθμό banner.',
			confirmButtonColor: '#536de6',
		})
		return false;
	}

	const title = this.dataset.modelTitle;
	const subtitle = this.dataset.modelSubtitle;
	emptyCallout.classList.add("d-none");
	const newCallout = createSelectedCallout(id, title, subtitle, namespace);
	
	container.append( newCallout );
}

function resetBannersModalHandler() {
	const categories = $(".js-banner-selection-cnt");
	let activeBanners, selectedBanners;

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

function hideCalloutHandler() {
	const mainCnt = this.findParent(3);
	this.findParent(2).classList.add("d-none");
	const activeChildren = mainCnt.querySelectorAll(".callout:not(.d-none)");

	if (activeChildren.length == 0) {
		mainCnt.getElementsByClassName("js-empty-callout")[0]
			.classList.remove("d-none");
	}
}

function setDefaultBanners( importance ) {

	const container = $(`#${importance}-banner-selection`);
	const activeBanners = container.find(".callout:not(.d-none)");
	const removedBanners = container.find(".d-none:not(.js-empty-callout)");
	const statusInput = $(`#${importance}-banners-switch`)[0]; //!checked i oxi
	let data = {
		models: [],
		status: statusInput.checked ? 1 : 0
	};

	let closeBtn, namespace, id, temp = {};

	for ( let i = 0; i < activeBanners.length; i++ ) {
		namespace = activeBanners[i].dataset.namespace;
		id = activeBanners[i].dataset.modelId;

		activeBanners[i].classList.add("js-active-banner", "callout-success");
		activeBanners[i].classList.remove("js-selected-banner", "callout-warning");

		closeBtn = activeBanners[i].getElementsByTagName("button")[0];
		closeBtn.removeEventListener("click", removeNewlySelectedHandler);
		closeBtn.removeEventListener("click", hideCalloutHandler);
		closeBtn.addEventListener("click", hideCalloutHandler);

		temp = {};
		temp[namespace] = id;
		data.models.push(temp);
	}

	removedBanners.remove();

	return data;

}

function bannerJsonBuilder( editedSection = false, selected = false ) {

	const bannerCnt = document.getElementsByClassName("js-banner-cnt");
	let data = {}, namespace, id, section, banner,
		status, temp = {};

	for ( let i = 0; i < bannerCnt.length; i++ ) {
		section = bannerCnt[i].dataset.importance;
		status = document.getElementById(`${section}-banners-switch`);
		data[section] = {
			models: [],
			status: status.checked ? 1 : 0
		}

		if ( section === editedSection ) {
			data[section] = { ...data[section], ...selected };
			continue;
		}

		banner = bannerCnt[i].getElementsByClassName("js-banner");
		for ( let j = 0; j < banner.length; j++ ) {
			namespace = banner[j].dataset.namespace;
			id = banner[j].dataset.modelId;

			temp = {};
			temp[namespace] = id;
			data[section].models.push(temp);
		}

	}

	data = JSON.stringify(data);

	return data

}

function showOverflowBtn() {
	const subText = document.getElementsByClassName("js-overflow-check");
	let button = "";
	
	for ( let i = 0; i < subText.length; i++ ) {
		if ( overflowCheck(subText[i]) ){
			button = subText[i].parentElement.getElementsByClassName("js-show-more")[0];
			
			button.classList.remove("invisible");
		}
	}
};
showOverflowBtn();

function overflowBtnInit() {

	const button = $(".js-show-more");

	button.off("click", showMoreBtnHandler);
	button.on("click", showMoreBtnHandler );

};
overflowBtnInit();


function overflowCheck(element) {
	return element.scrollHeight > element.clientHeight;
}

function updateBanners( updatedData ) {
	axios.patch( "/home-content/banners-update", {
		updatedData,
		selectedBanners: false
	})
	.catch( err => {
		console.log(err);
		utilities.toastAlert( "error", "Παρουσιάστηκε κάποιο πρόβλημα ..." );
	})
}







const primaryContainerRow = document.getElementById("primary-banners-row");
const secondaryContainerRow = document.getElementById("secondary-banners-row");

dragula( [primaryContainerRow, secondaryContainerRow], {

}).on("drop", function() {

	const bannersData = bannerJsonBuilder();

	updateBanners( bannersData );
})
