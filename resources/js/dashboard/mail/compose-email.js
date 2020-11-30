import utilities from '../main';

utilities.redactorConfig.minHeight = "300px"

$R("#editor", utilities.redactorConfig);
sessionStorage.removeItem("recipients");

// const recipientsSelect = $('#recipients-selection').select2({
// 	placeholder: "Επιλέξτε παραλήπτες...",
// 	width: "100%",
// 	// allowClear: true,
// 	ajax: {
// 		url: "/email/users",
// 		delay: 1000,
// 		dataType: "json",
// 		data: function(params) {
// 			return {
// 				search: params.term,
// 				page: params.page || 1
// 			}
// 		}
// 	}
// });

// $(".js-recipients").on("change", function() {
// 	const select = $('#recipients-selection');
// 	const recipients = $(".js-recipients:checked");
	
// 	select.html("");
	
// 	if (recipients.length === 0) {
// 		select.prop("disabled", false);
// 		return;
// 	}
	
// 	let newOption;

// 	for (let i = 0; i < recipients.length; i++) {
// 		newOption = new Option(recipients[i].dataset.recipients, i, false, true);
// 		select.append(newOption).trigger('change');
// 	}

// 	select.prop("disabled", true);
// });

utilities.tableLocale.emptyTable = "Δεν ορίστικαν παραλήπτες";
utilities.tableLocale.zeroRecords = "Δεν βρέθηκαν παραλήπτες";

const usersDatatable = $("#users-datatable").DataTable({
	order: [1, "asc"],
	processing: true,
	serverSide: true,
	ajax: {
		url: "/email/select-users",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		type: "post",
		data: function( d ) {
			return $.extend( {}, d, {
				recipients: sessionStorage.getItem("recipients")
			})
		}
	},
	columns: [
		{ data: 'action', name: 'action', className: "align-middle text-center", orderable: false },
		{ data: 'name', name: 'users.last_name', className: "align-middle" },
		{ data: 'courses', name: 'courses.title', className: "align-middle text-center text-wrap" },
		{ data: 'bundles', name: 'bundles.title', className: "align-middle text-center text-wrap" },
		{ data: 'btn', className: "align-middle text-center text-wrap", orderable: false, searchable: false },

	],
	language: utilities.tableLocale,
	fnInitComplete: function( oSettings, json ) {
		let lenthSelection = $("select[name='users-datatable_length']");

		lenthSelection.select2({
			minimumResultsForSearch: -1,
		});
	},
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");

		$(".js-add-recipient").on("click", addRecipientHandler);
	}
});

const recipientsDatatable = $("#recipients-datatable").DataTable({
	order: [1, "asc"],
	processing: true,
	serverSide: true,
	ajax: {
		url: "/email/recipients-data-table",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		type: "post",
		data: function( d ) {
			return $.extend( {}, d, {
				recipients: sessionStorage.getItem("recipients")
			})
		}
	},
	columns: [
		{ data: 'action', name: 'action', className: "align-middle text-center", orderable: false },
		{ data: 'name', name: 'users.last_name', className: "align-middle" },
		{ data: 'courses', name: 'courses.title', className: "align-middle text-center text-wrap" },
		{ data: 'bundles', name: 'bundles.title', className: "align-middle text-center text-wrap" },
		{ data: 'btn', className: "align-middle text-center text-wrap", orderable: false, searchable: false },

	],
	language: utilities.tableLocale,
	fnInitComplete: function( oSettings, json ) {
		let lenthSelection = $("select[name='recipients-datatable_length']");

		lenthSelection.select2({
			minimumResultsForSearch: -1,
		});
	},
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");

		$(".js-remove-recipient").on("click", removeRecipientHandler);
	}
});

function addRecipientHandler() {

	$(".js-add-recipient").prop("disabled", true);

	const id = this.dataset.userId;
	let recipients = sessionStorage.getItem("recipients");
	
	if (recipients === null) {
		recipients = `${id}`;
	}
	else {
		recipients += `,${id}`;
	}
	
	userTablesUpdate(recipients);
}

function removeRecipientHandler() {
	const id = this.dataset.userId;
	const recipients = sessionStorage.getItem("recipients").split(",");
	const index = recipients.indexOf(id);

	recipients.splice(index, 1);
	
	userTablesUpdate(recipients);
}

function userTablesUpdate(recipients) {
	sessionStorage.removeItem("recipients");
	sessionStorage.setItem("recipients", recipients);

	usersDatatable.ajax.reload(null, false);
	recipientsDatatable.ajax.reload(null, false);
}