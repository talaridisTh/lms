import utilities from '../main';

//! 			Datatables Initialization
//!##################################################
const tables = $("#scroll-horizontal-datatable").DataTable({
	order: [8, "desc"],
	searchDelay: "1000",
    processing: true,
	serverSide: true,
	autoWidth: false,
	columnDefs: [
		{ targets: 0, width: "30px"},
		{ targets: 6, width: "102px"},
		{ targets: 4, width: "122px"},
		{ targets: [8, 9], width: "180px"}
	],
    ajax: {
        url: "/users/view-users",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "post",
        data: function (d) {
            return $.extend({}, d, {
                fromDate: fromDay($(".date")[0]),
                toDate: toDay($(".date")[0])
            })
        }
    },
    columns: [
        { data: "checkbox", className: "align-middle text-center", orderable: false, searchable: false },
        { data: "last_name", name: "last_name" }, // 1
        { data: 'courses', name: 'courses.title', className: 'align-middle text-wrap min-width-test max-width-250', visible: false }, // 2
        { data: "first_name", name: "first_name", visible: false },// 3
		{ data: "roles", name: "roles.name", className: "align-middle text-center role-user" }, // 4
		{ data: "phone", name: "phone", className: "align-middle text-center" }, //5
        { data: "email", name: "email", visible: false }, // 6
        { data: 'status', name: 'status', className: "align-middle text-center" }, // 7
        { data: 'edit_created_at', name: 'users.created_at', className: "text-center align-middle" }, // 8
        { data: 'date', className: "text-center align-middle", orderable: false }, // 9
        // { data: 'date', name: 'users.created_at', className: "text-center align-middle" }, // 8
    ],
    language: utilities.tableLocale,
    drawCallback: () => {
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded")
		$(".table.dataTable").removeClass("nowrap");
		$(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
		$(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
       
        utilities.resetBulk($("#course-bulk-action-btn"), $("#select-all-courses"));
        utilities.resetBulk($("#course-bulk-action-btn"), $(".js-user-checkbox"));

		$(".js-delete-user").on("click", deleteUserHandler);

        toogleInput();
        checkeBoxesEventListener();
    },
})

//! GLOBAL FUNCTION Filter
//!============================================================
utilities.filterButton('#activeFilter', 7, tables, "#scroll-horizontal-datatable_length label")
utilities.filterButton('#rolesFilter', 4, tables, "#scroll-horizontal-datatable_length label")
utilities.filterButton('#course-filter', 2, tables, "#scroll-horizontal-datatable_length label")

//! EVENT LISTENER
//!============================================================
$("#course-filter").on("change", function () {
    let label = $("#select2-course-filter-container")[0];

    utilities.filterStyle(label, this.value);
});
$("#rolesFilter").on("change", function () {
    let label = $("#select2-rolesFilter-container")[0];

    utilities.filterStyle(label, this.value);
});
$("#activeFilter").on("change", function () {
    let label = $("#select2-activeFilter-container")[0];

    utilities.filterStyle(label, this.value);
});


//! DATAPICKER METHOD
//!============================================================

function fromDay(input) {
    let dateInput = input;


    if (!dateInput || dateInput.value == "") {
        return "";
    }

    let dateInputValue = dateInput.value.split(" - ");
    let firstDate = dateInputValue[0].split("/").reverse().join("-");

    return firstDate;
}

function toDay(input) {
    let dateInput = input;

    if (!dateInput || dateInput.value == "") {
        return "";
    }

    let dateInputValue = dateInput.value.split(" - ");
    let secondDate = dateInputValue[1].split("/").reverse().join("-");

    return secondDate.trim();
}

const searchField = $('#scroll-horizontal-datatable_filter > label ')[0];
const dateInput = createDateElm("users-date-picker");

dateInput.appendBefore( searchField );

$(dateInput).daterangepicker(utilities.datePickerConfig);

$(dateInput).on("apply.daterangepicker", function (event, picker) {
    let startDate = picker.startDate.format('DD/MM/YYYY');
	let endDate = picker.endDate.format('DD/MM/YYYY');

    this.value = `${startDate} - ${endDate}`;
    this.classList.add("select2-selected");

    tables.ajax.reload();
});

$(dateInput).on('cancel.daterangepicker', function (event, picker) {
    this.classList.remove("select2-selected");
    this.value = "";
    tables.ajax.reload();
})

$("#delete-users-btn").on("click", function() {
    let checkboxes = $(".js-user-checkbox:checked");
	let ids = [];

    for (let i = 0; i < checkboxes.length; i++) {
        ids.push(checkboxes[i].dataset.userId);
    }

    axiosMultipleDelete(ids);

});

function deleteUserHandler() {
	axiosMultipleDelete([this.dataset.userId]);
}

const axiosMultipleDelete = async (ids) => {

    try {
        const {value} = await utilities.toastAlertDelete(`Η ενέργεια θα είναι μη αναστρέψιμη`);
        if (value) {
            await axios.delete("/user/multiple/users/delete", {
                data: {
                    'user_id': ids,
                }
            })

			const message = ids.length === 1 ? "Διαγράφηκε" : "Διαγράφηκαν";

            utilities.toastAlert("info", message);
            tables.ajax.reload(null, false);
        }
    } catch (e) {
        utilities.toastAlert('error', "Παρουσιάστηκε κάποιο πρόβλημα")
    }
}

$(".js-multiple-change").on("click", function () {
    let checkboxes = $(".js-user-checkbox:checked")
	let ids = [];
	
    for (let i = 0; i < checkboxes.length; i++) {
        ids.push(checkboxes[i].dataset.userId);
	}
	
    changeStatusMultiple(ids, this.dataset.coursesChange)
});

function changeStatusMultiple (ids, stat) {

    axios.patch("/user/multiple/changeStatus", {
        "user_id": ids,
        "status": stat,
    })
	.then( res => {
		tables.ajax.reload(null, false);
	})
	.catch(err => {
        console.log(err)
        utilities.toastAlert('error', " Κάποιο σφάλμα παρουσιάστηκε...");
    })
}

function checkeBoxesEventListener() {
    let minorCheckboxes = $(".js-user-checkbox");
    let mainCheckbox = $("#select-all-courses")[0];
    let bulkBtn = $("#course-bulk-action-btn")[0];

    minorCheckboxes.on("change", function () {

        utilities.mainCheckboxSwitcher(mainCheckbox, minorCheckboxes, bulkBtn)
    });
}

$("#select-all-courses").on("change", function () {
    let minorCheckboxes = $(".js-user-checkbox");
    let bulkBtn = $("#course-bulk-action-btn")[0];

    utilities.minorCheckboxSwitcher(this, minorCheckboxes, bulkBtn);
})

//! EXPORT
//!============================================================

$('#excel-btn').on('click', function () {
    let checkboxes = $(".js-user-checkbox:checked");
    let ids = [];

    for (var i = 0; i < checkboxes.length; i++) {

        ids.push(checkboxes[i].dataset.userId)

	}
	
    var arrayOfNumbers = ids.map(parseFloat)
    axiosExportUser(arrayOfNumbers, this)
});

const axiosExportUser = async (id, that) => {

    try {

		const result = await utilities.passwordValidation();

		if ( !result.isConfirmed ) return;
		
        window.location.href = `/export/users/${id}`;

    } catch (e) {
        utilities.toastAlert('error', "Παρουσιάστηκε κάποιο πρόβλημα")
    }
}

//! METHOD FIRST TABLE
//!============================================================
const toogleInput = () => {
    $('.toggle-class').on("change", function () {
        const status = this.checked == true ? 1 : 0;
        const user_id = this.dataset.id;

        axios.patch(config.routes.changeStatusDatatable, {
            'status': status,
            'id': user_id
		})
		.then ( res => {
			const icon = this.checked ? "success" : "info";
			const message = this.checked ? "Ενεργοποιήθηκε" : "Απενεργοποιήθηκε";

			utilities.toastAlert(icon, message);
		})
        .catch (err => {
            utilities.toastAlert('error', "Παρουσιάστηκε κάποιο πρόβλημα")
        })
    })
}

//!METHOD SUB-TABLE
//!============================================================

function createDateElm(id) {

	let input = document.createElement("input");

	input.classList.add("form-control", "date", "d-inline-block", "ml-1");
	input.id = id;
	input.dataset.toggle = "date-picker";
	input.dataset.cancelClass = "btn-secondary";
	input.style.height = "31.96px";
	input.style.width = "195px";
	input.placeholder = "Επιλέξτε ημερομηνίες...";

	return input;
}