//!##########################################
//!				Global Variables			#
//!##########################################
let materialId = $("#material-title")[0].dataset.materialId;
let materialSlug = $("#material-title")[0].dataset.materialSlug;
const namespace = "App\\Material";
const baseUrl = window.location.origin;
let timer = 0;

//!######################################
//! 				Imports				#
//!######################################
import utilities from '../main';

//!######################################
//! 			Functions				#
//!######################################
function updatePDFInfo(btn) {
	const titleElm = $("#pdf-title");
	const nameElm = $("#pdf-name");
	const iconElm = $("#pdf-file-icon");

	iconElm.removeClass("mdi-cancel");
	iconElm.addClass("mdi-file-pdf-outline text-danger");
	nameElm.removeClass("d-none");
	$("#change-pdf-btn").text("Αλλαγή");

	titleElm.text(btn.dataset.pdfTitle);
	nameElm.text(btn.dataset.pdfName);
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

//!##########################################
//!				Initializations				#
//!##########################################

utilities.redactorConfig.minHeight = "300px"
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
        {data: "action", className: "text-center align-middle"},

    ],
    language: utilities.tableLocale,
    drawCallback: function () {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        $(".js-remove-table-classes > thead > tr > th").removeClass("js-link cursor-pointer js-updated-at");
		
		changePDFBtnInit();
	}
});

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

//!##################################################
//!					EventListeners					#
//!##################################################

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