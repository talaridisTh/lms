import utilities from '../main';

sessionStorage.removeItem("new_recipients");
sessionStorage.removeItem("recipients");

(function setOldRecipients() {
	const userRows = $(".js-old-recipients");
	const recipients = [];

	for (let i = 0; i < userRows.length; i++) {
		recipients.push(userRows[i].dataset.oldRecipientId);
	}

	sessionStorage.setItem("recipients", recipients.toString());
})();

const historyDatatable = $("#history-datatable").DataTable({
	language: utilities.tableLocale,
	fnInitComplete: function( oSettings, json ) {
		let lenthSelection = $("select[name='history-datatable_length']");

		lenthSelection.select2({
			minimumResultsForSearch: -1,
		});
	},
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");

	}
});

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
		$(".js-user-checkbox").on("change", addUserCheckboxHandler);

		utilities.resetAddButton( $("#add-recipients-blk"), $("#select-all-users") );
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
				recipients: sessionStorage.getItem("new_recipients")
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
		let lenthSelection = $("select[name='recipients-datatable_length']");

		lenthSelection.select2({
			minimumResultsForSearch: -1,
		});
	},
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");

		$(".js-remove-recipient").on("click", removeRecipientHandler);
		$(".js-recipient-checkbox").on("change", removeRecipientsCheckboxHandler);

		utilities.resetBulk( $("#remove-recipients-btn"), $("#select-all-recipients"), "Αφαίρεση (0)")
	}
});

function removeRecipientsCheckboxHandler() {
	let mainCheckbox = $("#select-all-recipients")[0];
	let minorCheckboxes = $(".js-recipient-checkbox");
	let bulkBtn = $("#remove-recipients-btn")[0]

	utilities.mainCheckboxSwitcher( mainCheckbox, minorCheckboxes, bulkBtn );
}

function removeRecipientHandler() {
	const id = this.dataset.userId;

	const recipients = sessionStorage.getItem("recipients").split(",");
	const recipientIndex = recipients.indexOf(id);
	
	const newRecipients = sessionStorage.getItem("new_recipients").split(",");
	const newRecipientIndex = newRecipients.indexOf(id);

	recipients.splice(recipientIndex, 1);
	newRecipients.splice(newRecipientIndex, 1);
	
	sessionStorage.setItem("recipients", recipients);
	sessionStorage.setItem("new_recipients", newRecipients);

	usersDatatable.ajax.reload(null, false);
	recipientsDatatable.ajax.reload(null, false);
}

function addUserCheckboxHandler() {
	let mainCheckbox = $("#select-all-users")[0];
	let minorCheckboxes = $(".js-user-checkbox");
	let bulkBtn = $("#add-recipients-blk")[0]

	utilities.mainCheckboxSwitcher( mainCheckbox, minorCheckboxes, bulkBtn );
}

function addRecipientHandler() {

	$(".js-add-recipient").prop("disabled", true);

	const id = this.dataset.userId;

	updateRecipients( [id] );
	updateNewRecipients( [id] );

	usersDatatable.ajax.reload(null, false);
	recipientsDatatable.ajax.reload(null, false);
}

function updateRecipients(ids) {
	let recipients = sessionStorage.getItem("recipients");

	if (recipients === "") {
		recipients = `${ids.toString()}`;
	}
	else {
		recipients += `,${ids.toString()}`;
	}

	sessionStorage.setItem("recipients", recipients);
}

function updateNewRecipients(ids) {
	let recipients = sessionStorage.getItem("new_recipients");

	if (recipients === null) {
		recipients = `${ids.toString()}`;
	}
	else {
		recipients += `,${ids.toString()}`;
	}

	sessionStorage.setItem("new_recipients", recipients);
}

$("#select-all-users").on("change", function() {
	let checkboxes = $('.js-user-checkbox');
	let bulkBtn = $("#add-recipients-blk")[0];

	utilities.minorCheckboxSwitcher( this, checkboxes, bulkBtn );
});

$("#select-all-recipients").on("change", function() {
	let checkboxes = $('.js-recipient-checkbox');
	let bulkBtn = $("#remove-recipients-btn")[0];

	utilities.minorCheckboxSwitcher( this, checkboxes, bulkBtn );
});

$("#mail-form").on("submit", function() {
	const recipients = sessionStorage.getItem("new_recipients");
	$("#recipients-input").val(recipients);
});

$("#add-recipients-blk").on("click", function() {
	const recipients = sessionStorage.getItem("recipients").split(",");
	const newRecipients = sessionStorage.getItem("new_recipients") === null
		? [] : sessionStorage.getItem("recipients").split(",");
	const users = $(".js-user-checkbox:checked");

	for ( let i = 0; i < users.length; i++ ) {
		recipients.push(users[i].dataset.userId);
		newRecipients.push(users[i].dataset.userId);
	}

	sessionStorage.setItem("recipients", recipients);
	sessionStorage.setItem("new_recipients", newRecipients);

	usersDatatable.ajax.reload(null, false);
	recipientsDatatable.ajax.reload(null, false);

	$("#users-table-modal").modal("hide");
});

$("#remove-recipients-btn").on("click", function() {
	const recipients = sessionStorage.getItem("recipients").split(",");
	const newRecipients = sessionStorage.getItem("new_recipients").split(",");
	const unwanted = $(".js-recipient-checkbox:checked");
	let index;

	for (let i = 0; i < unwanted.length; i++) {
		index = recipients.indexOf(unwanted[i].dataset.userId);
		recipients.splice(index, 1);
		
		index = newRecipients.indexOf(unwanted[i].dataset.userId);
		newRecipients.splice(index, 1);
	}

	sessionStorage.setItem("recipients", recipients);
	sessionStorage.setItem("new_recipients", newRecipients);

	usersDatatable.ajax.reload(null, false);
	recipientsDatatable.ajax.reload(null, false);
});

$("#delete-btn").on("click", function() {
	Swal.fire({
		title: 'Διαγραφή;',
		text: "Η ενέργεια θα είναι μη αναστρέψιμη",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#ff5b5b',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ναι, διαγραφή!',
		cancelButtonText: 'Άκυρο'
	}).then((result) => {
		if (result.isConfirmed) {
			$("#delete-mail-form")[0].submit()
		}
	})
});

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
		const label = $('#select2-course-user-filter-container')[0];

		utilities.filterStyle( label, this.value.trim() );
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
		const label = $('#select2-bundle-user-filter-container')[0];

		utilities.filterStyle( label, this.value.trim() );
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
		const label = $('#select2-user-role-filter-container')[0];

		utilities.filterStyle( label, this.value );
		usersDatatable.column(5).search( this.value ).draw();
	})
})();

//! Recipients table filters
(function coursesRecipientFilter() {
	const lengthCnt = document.getElementById("recipients-datatable_length");
	const select = createSelect("course-recipients-filter");

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
		const label = $('#select2-course-recipients-filter-container')[0];

		utilities.filterStyle( label, this.value.trim() );
		recipientsDatatable.column(2).search( this.value ).draw();
	})
})();

(function bundleRecipientsFilter() {
	const lengthCnt = document.getElementById("recipients-datatable_length");
	const select = createSelect("bundle-recipients-filter");

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
		const label = $('#select2-bundle-recipients-filter-container')[0];

		utilities.filterStyle( label, this.value.trim() );
		recipientsDatatable.column(3).search( this.value ).draw();
	})
})();

(function rolesFilter() {
	const lengthCnt = document.getElementById("recipients-datatable_length");
	const select = createSelect("recipient-role-filter");
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
		const label = $('#select2-recipient-role-filter-container')[0];

		utilities.filterStyle( label, this.value );
		recipientsDatatable.column(5).search( this.value ).draw();
	})
})();