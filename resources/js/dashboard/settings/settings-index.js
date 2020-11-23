import utilities from "../main"

const optionsDataTable = $("#options-datatable").DataTable({
	// order: [6, "desc"],
	processing: true,
	serverSide: true,
	ajax: {
		url: "/options/main-datatable",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		type: "post",
	},
	columns: [
		{ data: 'id', name: 'id', className: "align-middle text-center" },
		{ data: 'name', name: 'name', className: "align-middle" },
		{
			data: 'updated_at',
			name: 'updated_at',
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
		// { data: 'action', name: 'action', className: "align-middle text-center", width: "5%", orderable: false },
	],
	language: utilities.tableLocale,
	fnInitComplete: function( oSettings, json ) {
		let lenthSelection = $("select[name='options-datatable_length']");
		lenthSelection.addClass("select2");

		lenthSelection.select2({
			minimumResultsForSearch: -1,
		});

		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
	},
	drawCallback:function(){
		$(".js-remove-table-classes > thead > tr > th").removeClass("cursor-pointer");

		quickEditBtnInit();
	}
});

function quickEditBtnInit() {
	
	$(".js-quick-edit").on("click", function() {	
		classToggler(this, 2);
	});
	
	$(".js-cancel").on("click", function() {
		classToggler(this, 3);
	});

	$(".js-save").on("click", function() {
		const td = this.findParent(2);
		const id = this.dataset.optionId;
		const name = td.getElementsByClassName("js-option-name")[0].value;
		const value = td.getElementsByClassName("js-option-value")[0].value;

		saveOption(id, name, value)
	});
}

function classToggler(button, parent) {
	const td = button.findParent(parent);
	const title = td.getElementsByClassName("js-title")[0];
	const inputCnt = td.getElementsByClassName("js-edit-cnt")[0];

	title.classList.toggle("d-none");
    inputCnt.classList.toggle("d-none");
}

function saveOption(id, name, value) {

	axios.post(`/option/${id}/update`, {name, value})
	.then( res => {

		optionsDataTable.ajax.reload(null, false);
		utilities.toastAlert("success", "Αποθηκεύτηκε!");
	})
	.catch( err => {
		console.log(err);
		utilities.toastAlert("error", "Ooops!");
	})
}