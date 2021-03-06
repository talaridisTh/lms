//!######################################
//! 				Imports				#
//!######################################
import utilities from '../main';

//! EventListeners
//!==================

$("#select-all-bundles").on("change", function() {
	const minorCheckboxes = $(".js-bundle-checkbox");
	const bulkBtn = $("#bundle-bult-btn")[0];

	utilities.minorCheckboxSwitcher(this, minorCheckboxes, bulkBtn);
})

$("#submit-form-btn").on("click", function() {
	
	$("#new-bundle-form").submit()

});

$("#delete-bundles-btn").on("click", function() {
	let checkedBoxes = $(".js-bundle-checkbox:checked");
	let ids = [];

	for ( let i = 0; i < checkedBoxes.length; i++ ) {
		ids.push( checkedBoxes[i].dataset.bundleId );
	}

	Swal.fire({
		title: 'Είστε σίγουρος;',
		html: checkedBoxes.length == 1 
			? "<p class='mb-0'>Το Bundle θα διαγραφεί.</p>Η ενέργεια θα είναι μη αναστρέψιμη!"
			: `<p class="mb-0">${ids.length} Bundles θα διαγραφούν.</p>Η ενέργεια θα είναι μη αναστρέψιμη!`,
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#ff5b5b',
		confirmButtonText: 'Ναι, διαγραφή!',
		cancelButtonText: 'Άκυρο'
	}).then( (result) => {

		if (result.value) {

			axios.delete(`/bundle-ajax/destroy/${ids}`)
			.then(function (response) {

				let message = checkedBoxes.length == 1 ? "Διεγράφη" : "Διαγράφηκαν"

				utilities.toastAlert( "info", message );

				bundlesDatatable.ajax.reload();
			})
			.catch(function (error) {
				
				utilities.toastAlert( "error", "Παρουσιάστηκε κάποιο πρόβλημα ..." );

			});
			
		}
	})
});

const bundlesDatatable = $("#bundle-table").DataTable({
	order: [ 3, "desc" ],
	searchDelay: "1000",
	columns: [
		{ data: "action", name: "action", className: "align-middle text-center", width: "5%", orderable: false, searchable: false },
		{ data: "title", name: "title", className: "cursor-default"},
		{ data: "toggle", name: "status", className: "align-middle text-center", width: "5%", searchable: false },
		{ 
			data: "updated_at", 
			name: "updated_at", 
			className: "align-middle text-center cursor-default",
			render: function(data) {
				let date = new Date(data);
				let day = date.toLocaleDateString().replace( /[/]/g, "-");
				let hours = `${date.getHours()}`.padStart(2, "0");
				let minutes = `${date.getMinutes()}`.padStart(2, "0");

				let time = `${hours}:${minutes}`;
				return `<p class="mb-0">${day}</p><p class="mb-0">${time}</p>`;
			}
		},
		{ data: "publish", name: "publish_at", className: "align-middle text-center cursor-default"},
		{ data: "status", name: "status", className: "align-middle text-center cursor-default", visible: false },
	],
	processing: true,
	serverSide: true,
	ajax: {
		url: "/bundle-datatables/main",
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
		let lenthSelection = $("select[name='bundle-table_length']");
		lenthSelection.addClass("select2");

		lenthSelection.select2({
			minimumResultsForSearch: -1,
		});
	},
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		$(".js-remove-table-classes > thead > tr > th").removeClass("cursor-default");
		$(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
		$(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");

		activeToggleInit();
		checkboxChangeInit();
		utilities.resetBulk($("#bundle-bult-btn"), $("#select-all-bundles"));
	}
})

function checkboxChangeInit(){

	let minorCheckboxes = $(".js-bundle-checkbox");
	let mainCheckbox = $("#select-all-bundles")[0];
	let bulkBtn = $("#bundle-bult-btn")[0];

	minorCheckboxes.on("change", function() {
		utilities.mainCheckboxSwitcher( mainCheckbox, minorCheckboxes, bulkBtn);
	})
}

function activeToggleInit() {

	let toggle = $(".js-toggle");

	toggle.on( "change", function() {

		const id = this.dataset.bundleId;

		axios.patch( `/bundle-ajax/${id}/status`, {
			status: this.checked ? 1 : 0
		})
		.then( (res) => {
			let row = this.findParent(2);
			let dateElm = row.getElementsByClassName("js-date")[0];
			let timeElm = row.getElementsByClassName("js-time")[0];
			let badge = row.getElementsByClassName("js-badge")[0];
			let date = res.data.date.split("-").reverse().join("-");
			let time = res.data.time;
			let now = new Date();

			date = new Date( `${date} ${time}` );

			if ( this.checked ) {
				if ( now > date ) {
					badge.classList.remove("badge-outline-dark", "badge-outline-danger");
					badge.classList.add("badge-outline-success");
					badge.textContent = "Published";
				}
				else {
					badge.classList.remove("badge-outline-primary", "badge-outline-danger");
					badge.classList.add("badge-outline-primary");
					badge.textContent = "Scheduled";
				}
			}
			else {
				badge.classList.remove("badge-outline-primary", "badge-outline-dark");
				badge.classList.add("badge-outline-danger");
				badge.textContent = "Draft";
			}

			dateElm.textContent = res.data.date;
			timeElm.textContent = res.data.time;

			let icon = this.checked ? "success" : "info";
			let message = this.checked ? "Ενεργοποιήθηκε" : "Απενεργοποιήθηκε";

			utilities.toastAlert( icon, message );
		})
		.catch( (err) => {
			utilities.toastAlert( "error", "Παρουσιάστηκε κάποιο πρόβλημα ..." );
		})
	});
}

//!##############################################
//!				Datatable Filters				#
//!##############################################

let tablesLengthLabel = $("#bundle-table_length > label")[0];

let activeBundleFilter = utilities.createStateSelect("bundle-state-select");
tablesLengthLabel.append( activeBundleFilter );

$("#bundle-state-select").select2({
	minimumResultsForSearch: -1,
})

$("#bundle-state-select").on("change", function () {

	let label = $("#select2-bundle-state-select-container")[0];

	utilities.filterStyle( label, this.value );

	bundlesDatatable.column(5).search( this.value ).draw();

});

let searchFieldLabel = $("#bundle-table_filter > label > input")[0];
let dateInput = utilities.createDateElm( "bundle-date-range" );

dateInput.appendBefore( searchFieldLabel );
dateInput.addEventListener("input", function() {

	this.value = this.value.replace( /[^0-9]/g, "" )
		.replace(/^(\d{2})?(\d{2})?(\d{4})?(\d{2})?(\d{2})?(\d{4})?/g, '$1/$2/$3 - $4/$5/$6')
		.substr(0, 23)

});

let dateRange = $("#bundle-date-range");

dateRange.daterangepicker( utilities.datePickerConfig );

dateRange.on( "apply.daterangepicker", function(event, picker) {
		
	let startDate = picker.startDate.format('DD/MM/YYYY');
	let endDate = picker.endDate.format('DD/MM/YYYY');

	this.classList.add("select2-selected");
	this.value = `${ startDate } - ${ endDate }`;

	bundlesDatatable.ajax.reload();

});

dateRange.on( 'cancel.daterangepicker', function(event, picker) {

	this.classList.remove("select2-selected");
	dateInput.value = "";
	bundlesDatatable.ajax.reload();

});