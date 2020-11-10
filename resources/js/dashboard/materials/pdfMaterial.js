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

//!##########################################
//!				Initializations				#
//!##########################################

utilities.redactorConfig.minHeight = "300px"
$R("#description", utilities.redactorConfig);

const PDFDatatable = $("#remaining-pdf-datatable").DataTable({
	order: [[ 1, "desc" ]],
	searchDelay: "1000",
    processing: true,
    serverSide: true,
    ajax: {
        url: "/materials/remaining-pdf-files",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "post",
        data: {
			materialId
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
		
		axios.patch(`/material/${materialId}/change-pdf`, {
			materialId,
			pdfId: this.dataset.pdfId
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
			utilities.toastAlert("success", "Κάποιο σφάλμα παρουσιάστηκε.");
		})
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