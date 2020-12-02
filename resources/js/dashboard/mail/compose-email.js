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
	searchDelay: "1000",
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
		{ data: 'courses', name: 'courses.title', className: "align-middle text-center text-wrap", visible: false },
		{ data: 'bundles', name: 'bundles.title', className: "align-middle text-center text-wrap", visible: false },
		{ data: 'email', name: 'email', className: "align-middle text-center text-wrap" },
		{ data: 'role', name: 'roles.name', className: "align-middle text-center text-wrap" },
		{ data: 'btn', className: "align-middle text-center text-wrap", orderable: false, searchable: false },
		{ data: 'first_name', name: "first_name", visible: false },
		{ data: 'last_name', name: "last_name", visible: false },

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
		$(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
		$(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");

		$(".js-add-recipient").on("click", addRecipientHandler);
	}
});

const recipientsDatatable = $("#recipients-datatable").DataTable({
	order: [1, "asc"],
	searchDelay: "1000",
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

$(".js-submit-btn").on("click", function() {
	const form = document.getElementById("email-form");
	const name = this.name;
	const value = this.value;
	const recipients = sessionStorage.getItem("recipients");

	createInput(form, name, value);
	$("#recipients-input").val(recipients);

	form.submit();
});

function createInput(form, name, value) {
	const input = document.createElement("input");
	input.name = name;
	input.value = value;
	input.hidden = true;

	form.appendChild(input);
}

function createSelect(id) {
	const select = document.createElement("select");
	select.classList.add("select2", "form-control", "select2-multiple");
	select.id = id;

	return select;
}

(function coursesFilter() {
	const lengthCnt = document.getElementById("users-datatable_length");
	const select = createSelect("course-user-filter");

	lengthCnt.append(select);

	$(select).select2({
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
	})

	$(select).on("change", function() {
		usersDatatable.column(2).search( this.value ).draw();
	})
})();

(function bundlesFilter() {
	const lengthCnt = document.getElementById("users-datatable_length");
	const select = createSelect("bundle-user-filter");

	lengthCnt.append(select);

	$(select).select2({
		placeholder: "Όλα τα Bundles",
		width: "150px",
		ajax: {
			url: "/bundles/json-search",
			delay: 1000,
			dataType: "json",
			data: function(params) {
				return {
					search: params.term,
					page: params.page || 1
				}
			}
		}
	})

	$(select).on("change", function() {
		usersDatatable.column(3).search( this.value ).draw();
	})
})();

(function rolesFilter() {
	const lengthCnt = document.getElementById("users-datatable_length");
	const select = createSelect("user-role-filter");
	select.innerHTML = `
		<option value="">Όλοι οι Ρόλοι</option>
		<option value="admin">Admin</option>
		<option value="instructor">Εισηγητές</option>
		<option value="partner">Partners</option>
		<option value="student">Μαθητές</option>
	`;

	lengthCnt.append(select);

	$(select).select2({
		width: "150px",
	})

	$(select).on("change", function() {
		usersDatatable.column(4).search( this.value ).draw();
	})
})();