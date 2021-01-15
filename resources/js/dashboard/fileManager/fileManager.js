//!######################################
//!					Imports				#
//!######################################
import utilities from "../main";
import * as FilePond from "filepond";
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import 'filepond/dist/filepond.min.css';

//!######################################
//!				Global Variables		#
//!######################################

const baseUrl = window.location.origin;
let timer = 0;

//!######################################
//!				EventListeners			#
//!######################################

$("#image-light-room").on("show.bs.modal", function(event) {
	const button = event.relatedTarget;
	const imgTag = this.getElementsByTagName("img")[0];

	imgTag.src = button.dataset.source;
})

$("#save-details-btn").on("click", function() {

	let form = $("#store-file-details-form")[0];
	let data = new FormData(form);

	axios.post("/file-details-store", 
		data
	)
	.then( res => {
		utilities.toastAlert("success", "Οι αλλαγές αποθηκεύτηκαν.");

		clearInvalidMessage();
		fileManagerDatatable.ajax.reload( null, false);
		// $("#edit-file-modal").modal('hide');
	})
	.catch( err => {
		if ( err.response.status == 422 && err.response.data.errors.title !== "undefined" ) {
			$("#title-input").addClass("is-invalid");
		}
	})
});

$("#edit-file-modal").on("show.bs.modal", async function(event) {

	const modal = $(this);
	const td = event.relatedTarget.parentElement;
	const id = td.getElementsByClassName("js-id-input")[0];
	const publicPass = td.getElementsByClassName("js-public-url-input")[0];
	const copyUrlBtn = document.getElementById("copy-url-button");
	const urlToggle = document.getElementById("url-toggle");
	const placeholder = document.getElementById("edit-media-placeholder");
	const dialog = document.getElementById("edit-media-dialog");

	try {
		const res = await mediaData(id.value);
		const originalName = res.data.original_name;		

		if (res.data.media_details) {
			var {title} = res.data.media_details;
			var {subtitle} = res.data.media_details;
			var {caption} = res.data.media_details;
			var {description} = res.data.media_details;
		}

		if ( publicPass == "" ) {
			copyUrlBtn.disabled = true;
			$(copyUrlBtn).tooltip('disable');
			urlToggle.checked = false;
		}
		else {
			copyUrlBtn.disabled = false;
			$(copyUrlBtn).tooltip('enable');
			urlToggle.checked = true;
		}
		
		modal.find("#public-url").val(publicPass.value);
		modal.find("#file-id").val( id.value );
		modal.find("#title-input").val( title || originalName );
		modal.find("#caption-input").val( caption || "" );
		modal.find("#subtitle-input").val( subtitle || "" );

		$R("#file-description-area").source.setCode(description || "");

		placeholder.classList.toggle("d-flex");
		placeholder.classList.toggle("d-none");
		dialog.classList.toggle("d-none");
	}
	catch (err) {
		console.log(err);
		utilities.toastAlert("error", "Κάποιο σφάλμα παρουσιάστηκε...")
	}
});

$("#edit-file-modal").on("hidden.bs.modal", function() {
	const placeholder = document.getElementById("edit-media-placeholder");
	const dialog = document.getElementById("edit-media-dialog");

	placeholder.classList.toggle("d-flex");
	placeholder.classList.toggle("d-none");
	dialog.classList.toggle("d-none");
	clearInvalidMessage();
});

function clearInvalidMessage() {
	const invalids = document.getElementsByClassName("is-invalid");

	for (let i = 0; i < invalids.length; i++) {
		invalids[i].classList.remove("is-invalid");
	}
}

function mediaData(id) {

	return axios.get(`/media-ajax/${id}/get-media-details`);
}

$(".custom-tabs").on( "click", function() {
	let tabs = $(".tab-pane");
	$(".custom-tabs.btn-light").removeClass("btn-light").addClass("btn-dark");

	for ( let i = 0; i < tabs.length; i++ ) {
		tabs[i].style.display = "none";
	}

	this.classList.remove("btn-dark");
	this.classList.add("btn-light");
	document.getElementById(this.dataset.customTab).style.display = "block";
});

const fileManagerDatatable = $("#file-manager-datatable").DataTable({
	order: [ 4, "desc" ],
	searchDelay: "1000",
	autoWidth: false,
	columnDefs: [
		{ targets: [2, 3], width: "150px"},
		{ targets: 4, width: "200px"}
	],
	columns: [
		{ data: "image", className: "text-center cursor-default", searchable: false, orderable: false },
		{ data: "original_name", name: "original_name", className: "cursor-default align-middle"},
		{ data: "ext", name: "ext", className: "align-middle text-center cursor-default"},
		{ data: "size", name: "size", className: "align-middle text-center cursor-default" },
		{ data: 'created_at', name: 'created_at', orderData: 6, className: "cursor-default text-center align-middle", searchable: false },
		{ data: "title", name: "mediaDetails.title", className: "align-middle text-center cursor-default", visible: false },
		{ data: "id", name: "id", searchable: false, visible: false }
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
		$(".dataTables_paginate > .pagination > li > a").attr("draggable", "false");
		$(".js-remove-table-classes > thead > tr > th").removeClass("cursor-default");

		$(".js-copy-url").on("click", copyHiddenInputClickHandler);
		$(".js-copy-url").on("mouseleave", copyHiddenInputLeaveHandler);

		$('[data-toggle="tooltip"]').tooltip("dispose");
		$('[data-toggle="tooltip"]').tooltip();
	}
});

//!######################################
//! 		Grid View Functions			#
//!######################################

function copyHiddenInputLeaveHandler() {
	$(this).attr("data-original-title", "Copy to clipboard");
}

function copyHiddenInputClickHandler() {
	const td = this.parentElement;
	const publicUrl = td.getElementsByClassName("js-public-url-input")[0].value;
	const input = document.createElement("input");

	input.classList.add("absolute");
	input.value = publicUrl;
	document.body.append(input);

	input.select();
	input.setSelectionRange(0, 99999);

	document.execCommand("copy");
	$(this).attr("data-original-title", "Copied!").tooltip('show'); 

	input.remove();
}


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

});

$("#ext-table-filter").on("change", function() {

	let label = $("#select2-ext-table-filter-container")[0];

	utilities.filterStyle( label, this.value );
	fileManagerDatatable.column(2).search( this.value ).draw();
});

FilePond.registerPlugin(FilePondPluginFileValidateType);
FilePond.registerPlugin(FilePondPluginFileValidateSize);

const dropzone = document.getElementById("file-pond");
utilities.ALLOWEDTYPES.push('image/png', 'image/jpeg')
const pond = FilePond.create(dropzone, {
	instantUpload: false,
	dropOnElement: false,
	dropOnPage: true,
	allowMultiple: true,
	allowRevert: false,
	labelIdle: "Drag & Drop your files or Browse",
    server: {
        url: baseUrl,
        process: {
            url: '/file-manager/upload',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
            },
        },
	},
	onprocessfile: function (error, data) {
		
		if ( pond.status === 2 ) {

			clearTimeout(timer);
			let files = pond.getFiles();

			for (let i = 0; i < files.length; i++ ) {

				if ( files[i].status === 5 ) {
					timer = setTimeout(function() {
						pond.removeFile(files[i]);
					}, ( i + 1 ) * 500);
				}

			}
			fileManagerDatatable.ajax.reload( null, false );
		}

	},
	onprocessfiles: function() {

		let files = pond.getFiles();

		for (let i = 0; i < files.length; i++ ) {

			timer = setTimeout(function() {
				pond.removeFile(files[i]);
				
			}, ( i + 1 ) * 500);
			
		}

		fileManagerDatatable.ajax.reload( null, false );
	},
	acceptedFileTypes: utilities.ALLOWEDTYPES,
	fileValidateTypeDetectType: (source, type) => new Promise((resolve, reject) => {
		
		// Do custom type detection here and return with promise
		const extension = source.name.split(".").pop();

		if ( utilities.ALLOWEDTYPES.includes(type) ) {
			resolve(type);
		}
		else if (extension === "ev3" || extension === "rar" || extension === "sb3") {
			type = "application/octet-stream";
			resolve(type);
		}

		reject(type);
    }),
});

$("#upload-file-modal").on("show.bs.modal", function() {
	const body = document.getElementsByTagName("body")[0];
	
	removeBodyListeners(body);
});

$("#upload-file-modal").on("hide.bs.modal", function() {
	const body = document.getElementsByTagName("body")[0];
	
	removeBodyListeners(body);
	addBodyListeners(body);
})

const body = document.getElementsByTagName("body")[0];
body.addEventListener("dragover", dragOverlayHandler);
body.addEventListener("dragleave", leaveOverlayHandler);
body.addEventListener("drop", dropOverlayHandler);

function dragOverlayHandler() {
	$("#page-drag-drop-overlay").addClass("flex-opacity");
	$("#icons-cnt").addClass("w-350px");
}

function removeBodyListeners( body ) {
	body.removeEventListener("dragover", dragOverlayHandler);
	body.removeEventListener("dragleave", leaveOverlayHandler);
	body.removeEventListener("drop", dropOverlayHandler);
}

function addBodyListeners( body ) {
	body.addEventListener("dragover", dragOverlayHandler);
	body.addEventListener("dragleave", leaveOverlayHandler);
	body.addEventListener("drop", dropOverlayHandler);
}

function leaveOverlayHandler() {
	$("#page-drag-drop-overlay").removeClass("flex-opacity");
	$("#icons-cnt").removeClass("w-350px");
}

function dropOverlayHandler() {
	$("#page-drag-drop-overlay").removeClass("flex-opacity");
	$("#icons-cnt").removeClass("w-350px");

	$("#upload-file-modal").modal("show");
	removeBodyListeners( this );
}

const dropArea = document.getElementsByClassName("js-filepond-file-dragging");
for ( let i = 0; i < dropArea.length; i++ ) {

	dropArea[i].addEventListener("dragover", function(event) {
		const draggingArea = this.getElementsByClassName("filepond--drop-label")[0];
		const label = draggingArea.querySelector("label");

			draggingArea.classList.add("limegreen");
			label.classList.add("text-limegreen");

	});

	dropArea[i].addEventListener("dragleave", function(event) {
		const draggingArea = this.getElementsByClassName("filepond--drop-label")[0];
		const label = draggingArea.querySelector("label");

			draggingArea.classList.remove("limegreen");
			label.classList.remove("text-limegreen");

	});

	dropArea[i].addEventListener("drop", function(event) {
		const draggingArea = this.getElementsByClassName("filepond--drop-label")[0];
		const label = draggingArea.querySelector("label");

			draggingArea.classList.remove("limegreen");
			label.classList.remove("text-limegreen");

	});
}

//! den mporei na mpei sto change epidi to idio to modal 8a to allazei
//! an mpei sto change 8a prepei na elegxo to currentTarget
$("#url-toggle").on("click", function (event) {

	const fileId = $("#file-id").val();

	axios.patch(`/media-ajax/${fileId}/toggle-public-pass`, {
		status: this.checked ? 1 : 0
	})
	.then( res => {
		$("#public-url").val(res.data.url);

		if (this.checked) {
			$("#copy-url-button").prop("disabled", false);
			$("#copy-url-button").tooltip('enable');
		}
		else {
			$("#copy-url-button").prop("disabled", true);
			$("#copy-url-button").tooltip('disable');
		}

		fileManagerDatatable.ajax.reload(null, false);
	})
	.catch( err => {
		console.log(err);
		utilities.toastAlert("error", "Κάποιο σφάλμα παρουσιάστηκε");
	})
});

$("#copy-url-button").on("click", function() {
	const urlInput = $("#public-url")[0];
	urlInput.select();
	urlInput.setSelectionRange(0, 99999);

	document.execCommand("copy");
	$(this).attr("data-original-title", "Copied!").tooltip('show'); 
});

$("#copy-url-button").on("mouseleave", function() {
	$(this).attr("data-original-title", "Copy to clipboard");
});