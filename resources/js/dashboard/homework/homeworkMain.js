import utilities from "../main";

const homeworksDatatable = $("#homeworks-datatable").DataTable({
	order: [2, "desc"],
	searchDelay: "1000",
	processing: true,
	serverSide: true,
	autoWidth: false,
	columnDefs: [
		{ targets: 1, width: "250px"},
		{ targets: 2, width: "180px"}
	],
	ajax: {
		url: "/homeworks-datatable/main",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		type: "post",
		data: function( d ) {
			return $.extend( {}, d, {
				startDate: startDate( $("#homework-date-range")[0] ),
				endDate: endDate( $("#homework-date-range")[0] ),
			})
		}
	},
	columns: [
		{ data: 'student', name: 'student.last_name' },
		{ data: 'course', name: 'course.title', className: "align-middle text-center",},
		{
			data: 'created_at',
			name: 'homeworks.created_at',
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
	],
	language: utilities.tableLocale,
	fnInitComplete: function( oSettings, json ) {
		let lenthSelection = $("select[name='homeworks-datatable_length']");
		lenthSelection.addClass("select2");

		lenthSelection.select2({
			minimumResultsForSearch: -1,
		});
	},
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		$(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
		$(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
		$(".js-remove-table-classes > thead > tr > th").removeClass("cursor-pointer");

	}
});

let searchFieldLabel = $("#homeworks-datatable_filter > label > input")[0];
let dateInput = createDateElm();

dateInput.appendBefore( searchFieldLabel );
let dateRange = $("#homework-date-range");

dateRange.daterangepicker( utilities.datePickerConfig );

dateRange.on( "apply.daterangepicker", function(event, picker) {

	let startDate = picker.startDate.format('DD/MM/YYYY');
	let endDate = picker.endDate.format('DD/MM/YYYY');

	this.classList.add("select2-selected");
	this.value = `${ startDate } - ${ endDate }`;

	homeworksDatatable.ajax.reload();

})

dateRange.on( 'cancel.daterangepicker', function(event, picker) {

	this.classList.remove("select2-selected");
	dateInput.value = "";
	homeworksDatatable.ajax.reload();
})

function startDate( input ) {

	let dateInput = input;

	if ( !dateInput || dateInput.value == "" ) {
		return "";
	}

	let dateInputValue = dateInput.value.split(" - ");
	let firstDate = dateInputValue[0].split("/").reverse().join("-");

	return firstDate;
}

function endDate( input ) {

	let dateInput = input;

	if ( !dateInput || dateInput.value == "" ) {
		return "";
	}

	let dateInputValue = dateInput.value.split(" - ");
	let secondDate = dateInputValue[1].split("/").reverse().join("-");

	return secondDate;
}

function createDateElm() {

	let input = document.createElement("input");

	input.classList.add("form-control", "date", "d-inline-block", "ml-1");
	input.id = "homework-date-range";
	input.dataset.toggle = "date-picker";
	input.dataset.cancelClass = "btn-secondary";
	input.style.height = "31.96px";
	input.style.width = "195px";
	input.placeholder = "Επιλέξτε ημερομηνίες...";

	return input;
}

function createSelect(id) {
    const selectElm = document.createElement("select");
    selectElm.classList.add("ml-1", "select2");
    selectElm.id = id;

    return selectElm;
}

const tablesLengthLabel = $("#homeworks-datatable_length")[0];
const courseFilter = createSelect("course-select");
tablesLengthLabel.append( courseFilter );

$("#course-select").select2({
	placeholder: "Όλα τα Courses",
	width: "150px",
	ajax: {
		url: "/courses/json-search",
		delay: 1000,
		dataType: "json",
		data: function(params) {
			return {
				search: params.term,
				page: params.page || 1
			}
		}
	}
});

$("#course-select").on("change", function () {

	const label = $("#select2-course-select-container")[0];

	utilities.filterStyle( label, this.value.trim() );
	homeworksDatatable.column(1).search( this.value ).draw();
});

$("#view-homework-modal").on("show.bs.modal", function(event) {
	
	const button = $(event.relatedTarget);
	const id = button.data("id");

	axios.get(`/homework-ajax/${id}`)
		.then( res => {
			$(this).find("#homework-content").html(res.data);
		})
		.catch( err => {
			console.log(err);
			utilities.toastAlert("error", "Κάποιο σφάλμα παρουσιάστηκε...")
		})
});

$("#view-homework-modal").on("hidden.bs.modal", function() {

	const placeholder = `<div class="d-flex justify-content-center py-4">
		<div class="spinner-border avatar-md text-primary" role="status"></div>
	</div>`

	$(this).find("#homework-content").html(placeholder);
});