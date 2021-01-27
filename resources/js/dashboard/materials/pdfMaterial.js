//!##########################################
//!				Global Variables			#
//!##########################################
let materialId = $("#material-title")[0].dataset.materialId;
let materialSlug = $("#material-title")[0].dataset.materialSlug;
const namespace = "App\\Models\\Material";
const baseUrl = window.location.origin;
let timer = 0;

//!######################################
//! 				Imports				#
//!######################################
import utilities from '../main';

import * as FilePond from 'filepond';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import 'filepond/dist/filepond.min.css';

require("./data-tables");

//!######################################
//! 			Functions				#
//!######################################
function updatePDFInfo(btn) {
	const titleElm = $("#pdf-title");
	const nameElm = $("#pdf-name");
	const nameInput = $("#pdf-name-input");
	const titleInput = $("#pdf-title-input");
	const iconElm = $("#pdf-file-icon");

	iconElm.removeClass("mdi-cancel");
	iconElm.addClass("mdi-file-pdf-outline text-danger");
	nameElm.removeClass("d-none");
	$("#change-pdf-btn").text("Αλλαγή");

	titleElm.text(btn.dataset.pdfTitle);
	titleInput.val(btn.dataset.pdfTitle);
	nameElm.text(btn.dataset.pdfName);
	nameInput.val(btn.dataset.pdfName);
	$("#pdf-id").val(btn.dataset.pdfId);

	PDFDatatable.ajax.reload(null, false);
	$("#remainings-pdf-modal").modal("hide");

	utilities.toastAlert("success", "Το αρχείο άλλαξε.");
}

function changeExistingPDF(btn) {

	axios.patch(`/material/${materialId}/change-pdf`, {
		materialId,
		pdfId: btn.dataset.pdfId
	})
	.then( res => {

		const title = res.data.pdf.media_details
			? res.data.pdf.media_details.title
			: res.data.pdf.original_name;

		$("#pdf-title").text(title);
		$("#pdf-pdf").text(`${res.data.pdf.name}.${res.data.pdf.ext}`);
		$("#pdf-embed").attr("src", res.data.pdf.rel_path);

		PDFDatatable.ajax.reload(null, false);
		$("#remainings-pdf-modal").modal("hide");

		utilities.toastAlert("success", "Το αρχείο άλλαξε.");
	})
	.catch( err => {
		console.log(err);
		utilities.toastAlert("error", "Κάποιο σφάλμα παρουσιάστηκε.");
	})

}

function changePDFBtnInit() {

	const btns = $(".js-change-pdf-btn")

	btns.on("click", function() {

		if ( typeof materialId !== "undefined" ) {
			changeExistingPDF(this);
		}
		else {
			updatePDFInfo(this);
		}

	})
}

//!##########################################
//!				Initializations				#
//!##########################################
FilePond.registerPlugin(FilePondPluginFileValidateType);
FilePond.registerPlugin(FilePondPluginFileValidateSize);

let dropzone = document.getElementById("file-pond");
const pond = FilePond.create( dropzone, {
	name: 'file',
	className: "js-filepond-file-dragging",
	labelIdle: "Drag & Drop your files or Browse",
	allowRevert: false,
	server: {
		url: baseUrl,
		process: {
			url: '/media/pdf-upload',
			headers: {
				"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
			},
		}
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

				PDFDatatable.ajax.reload();

			}
		}

	},
	onprocessfiles: function() {
		let files = pond.getFiles();
		PDFDatatable.ajax.reload();

		for (let i = 0; i < files.length; i++ ) {

			timer = setTimeout(function() {
				pond.removeFile(files[i]);

			}, ( i + 1 ) * 500);

		}
	},
	acceptedFileTypes: ["application/pdf"],
	maxFileSize: "50MB"
});

utilities.redactorConfig.minHeight = "265px"
$R("#description", utilities.redactorConfig);

function getPDFid() {
	const idElm = document.getElementById("pdf-id");

	if ( idElm !== null ) {
		return idElm.value;
	}

	return false;
}

const PDFDatatable = $("#remaining-pdf-datatable").DataTable({
	order: [[ 1, "desc" ]],
	searchDelay: "1000",
    processing: true,
    serverSide: true,
    ajax: {
        url: "/materials/remaining-pdf-files",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "post",
		data: function( d ) {
			return $.extend( {}, d, {
				materialId,
				pdfId: getPDFid()
			})
		}
    },
    columns: [
		{data: "original_name", name: "original_name"},
		{data: "size", name: "size", className: "text-center align-middle"},
        {data: "action", className: "text-center align-middle", orderable: false, searchable: false},

    ],
	language: utilities.tableLocale,
	fnInitComplete: function( oSettings, json ) {
		let lenthSelection = $("select[name='remaining-pdf-datatable_length']");
		lenthSelection.addClass("select2");

		lenthSelection.select2({
			minimumResultsForSearch: -1,
		});
	},
    drawCallback: function () {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        $(".js-remove-table-classes > thead > tr > th").removeClass("js-link cursor-pointer js-updated-at");

		changePDFBtnInit();
	}
});


//!##############################################
//!		Datatable Button initializations		#
//!##############################################

$(".dataTables_wrapper:not(#remaining-pdf-datatable_wrapper) > .row:first-child > div").removeClass("col-sm-12 col-md-6");
$(".dataTables_wrapper:not(#remaining-pdf-datatable_wrapper) > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");

//!##################################################
//!					EventListeners					#
//!##################################################

$("#select-all-courses").on("change", function () {
    let minorCheckboxes = $(".js-course-inside-material");
    let bulkBtn = $("#course-indside-material-bulk")[0];

    utilities.minorCheckboxSwitcher(this, minorCheckboxes, bulkBtn);
});

$("#all-remainings-checkbox").on("change", function () {
    let minorCheckboxes = $(".remainings-checkbox");
    let bulkBtn = $("#add-remaingings-btn")[0];

    utilities.minorCheckboxSwitcher(this, minorCheckboxes, bulkBtn);

})

$(".js-editors-toggle").on("change", function() {
	let editorToggles = $(".js-editors-toggle");
	let field = {};

	for ( let i = 0; i < editorToggles.length; i++) {

		field[`${editorToggles[i].dataset.field}`] = editorToggles[i].checked ? 1 : 0;
	}

	let fields = JSON.stringify(field);

	axios.patch(`/material/${materialId}/toggle-editors`, {
		fields
	})
	.then( res => {
		let icon = this.checked ? "success" : "info";
		let message = this.checked ? "Ενεργοποιήθηκε" : "Απενεργοποιήθηκε";

		utilities.toastAlert( icon, message );
	})
	.catch( err => {
		console.log(err);
		utilities.toastAlert( "error", "Παρουσιάστηκε κάποιο πρόβλημα ..." );
	})

})

$("#pdf-material-status").on("change", function() {

	axios.patch(`/materials/toggle-status/${materialSlug}`, {
		state: this.checked ? 1 : 0
	})
		.then((res) => {
			let icon = this.checked ? "success" : "info";
			let message = this.checked ? "Ενεργοποιήθηκε" : "Απενεργοποιήθηκε";
			utilities.toastAlert(icon, message);
		})
		.catch((err) => {
			console.log(err)
			utilities.toastAlert("error", "Παρουσιάστηκε κάποιο πρόβλημα ...");
		})

})

$(".tab-link").on("show.bs.tab", function(event) {
	event.preventDefault();

	Swal.fire({
		icon: 'info',
		title: 'Προσοχή!',
		html: `<p class="mb-0">Θα πρέπει να αποθηκεύσετε το μάθημα</p>για να συνεχίσετε!`,
		confirmButtonColor: '#536de6'
	});
})

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
