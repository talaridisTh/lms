//!######################################
//! 				Imports				#
//!######################################
import utilities from '../main';

//!##########################################
//!				EventListeners				#
//!##########################################

// $("#new-gradient-checkbox").on("change", function() {
// 	let modal = $("#add-topic-modal");
// 	let gpicker = modal.find(".gpickr");
// 	let gInput = $("#gradient-input");

// 	if ( this.checked ) {
// 		gpicker.css("display", "inline-flex");
// 		gInput.prop("disabled", false);
// 	}
// 	else {
// 		gpicker.css("display", "none");
// 		gInput.prop("disabled", true);
// 	}
// })

$("#save-edit-gradient").on( "click", function() {
	let topicId = $("#topic-id").val();
	let color = $("#topic-gradient").val();

	axios.patch( "/topics/change/color", {
		topicId, color
	})
	.then( res => {
		utilities.toastAlert("success", "Το Gradient άλλαξε!")
		topicsDatatable.ajax.reload( null, false );
		$("#color-modal").modal('hide');
	})
	.catch( err => {
		utilities.toastAlert( "error", "Παρουσιάστηκε κάποιο πρόβλημα ..." );
	})
});

$("#add-topic-modal").on("show.bs.modal", function() {
	gpickr.setGradient("linear-gradient(315deg, #ff4e00 0%, #ec8505 74%)");
})

$("#color-modal").on("show.bs.modal", function(event) {
	let button = $(event.relatedTarget);
	let id = button.data('topic-id');
	let title = button.data('topic-title');
	let gradient = button.data('gradient');

	gpickrEdit.setGradient(`${gradient}`);

	let modal = $(this);
	modal.find("#topic-id").val( id );
	modal.find("#topic-gradient").val(`${gradient}`);
	modal.find("#color-modal-title").text(`Edit ${title}`);
});

$("#select-all-topics").on( "change", function () {

    let checkbox = $(".js-topic-checkbox");
    let bulk = $("#topic-bulk-action-btn")[0];

    utilities.minorCheckboxSwitcher(this, checkbox, bulk);

});

$("#delete-topics-btn").on( "click", function () {

    let checkedBoxes = $(".js-topic-checkbox:checked");
    let ids = [];

    if (checkedBoxes.length == 0) {
        Swal.fire('Δεν έχετε επιλέξει τίποτα');
        return;
    }

    for (let i = 0; i < checkedBoxes.length; i++) {
        ids.push(checkedBoxes[i].dataset.topicId);
    }

    Swal.fire({
        title: 'Είστε σίγουρος;',
        text: `${checkedBoxes.length} ${checkedBoxes.length == 1 ? "αρχείο θα διαγραφεί" : " αρχεία θα διαγραφούν"}`,
        icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#ff5b5b',
        confirmButtonText: 'Ναι, διαγραφή!',
        cancelButtonText: 'Άκυρο'
    }).then((result) => {

        if (result.value) {

            axios.delete(`/topics/destroy/${ids}`)
                .then(function (response) {

                    let message = checkedBoxes.length == 1 ? "Διεγράφη" : "Διαγράφηκαν"

                    utilities.toastAlert("success", message);

                    topicsDatatable.ajax.reload();
                    resetBulk($("#topic-bulk-action-btn"), $("#select-all-topics"));
                })
                .catch(function (error) {

                    utilities.toastAlert("error", "Παρουσιάστηκε κάποιο πρόβλημα ...");

                });

        }
    })

})

//!##########################################
//! 				Datatables				#
//!##########################################
const topicsDatatable = $("#topics-datatable").DataTable({
	order: [1, "desc"],
	searchDelay: "1000",
    processing: true,
    serverSide: true,
    ajax: {
        url: "/topics/topics-datatable",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "post",
        data: function (d) {
            return $.extend({}, d, {
                startDate: utilities.startDate($("#topic-date-range")[0]),
                endDate: utilities.endDate($("#topic-date-range")[0]),
            })
        }
    },
    columns: [
        {data: 'action', name: 'action', className: "align-middle text-center", width: "5%", orderable: false},
        {data: 'title', name: 'title'},
        {data: 'gradient'},
    ],
    language: utilities.tableLocale,
    fnInitComplete: function (oSettings, json) {
        let lenthSelection = $("select[name='topics-datatable_length']");
        lenthSelection.addClass("select2");

        lenthSelection.select2({
            minimumResultsForSearch: -1,
        });
    },
    drawCallback: function () {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        $(".js-remove-table-classes > thead > tr > th").removeClass("d-none cursor-pointer js-updated-at js-colspan");
		$(".js-colspan").attr("colspan", 2);

        showEditInit();
        editButtonsInit();
        topicCheckboxesInit();
    }
});


//!##############################################
//!				Datatable Filters				#
//!##############################################

let searchFieldLabel = $("#topics-datatable_filter > label > input")[0];
let dateInput = utilities.createDateElm("topic-date-range");

dateInput.appendBefore(searchFieldLabel);
dateInput.addEventListener("input", function () {

    this.value = this.value.replace(/[^0-9]/g, "")
        .replace(/^(\d{2})?(\d{2})?(\d{4})?(\d{2})?(\d{2})?(\d{4})?/g, '$1/$2/$3 - $4/$5/$6')
        .substr(0, 23)

});

let dateRange = $("#topic-date-range");

dateRange.daterangepicker(utilities.datePickerConfig);

dateRange.on("apply.daterangepicker", function (event, picker) {

    let startDate = picker.startDate.format('DD/MM/YYYY');
    let endDate = picker.endDate.format('DD/MM/YYYY');

    this.classList.add("select2-selected");
    this.value = `${startDate} - ${endDate}`;

    topicsDatatable.ajax.reload();

});

dateRange.on('cancel.daterangepicker', function (event, picker) {

    this.classList.remove("select2-selected");
    dateInput.value = "";
    topicsDatatable.ajax.reload();

});

//!##############################################
//!				EventListeners Init				#
//!##############################################

function topicCheckboxesInit() {

    let primaryCheckbox = $("#select-all-topics")[0];
    let topicCheckbox = $(".js-topic-checkbox");
    let bulk = $("#topic-bulk-action-btn")[0];

    topicCheckbox.on( "change", function () {
        utilities.mainCheckboxSwitcher(primaryCheckbox, topicCheckbox, bulk);
    });

}

function showEditInit() {
    let editBtns = $(".js-quick-edit");

    editBtns.on( "click", function () {
		const row = this.parentElement;
		const title = row.getElementsByClassName("js-title")[0];
		const inputContainer = row.getElementsByClassName("js-edit")[0];
		const input = inputContainer.getElementsByTagName("input")[0]
		const valueLen = input.value.length;

        title.classList.add("d-none");
        inputContainer.classList.remove("d-none");
        input.focus();
        input.setSelectionRange(valueLen, valueLen);
    });
}

function editButtonsInit() {

	const input = $(".js-edit input");
	const save = $(".js-save");
	const cancel = $(".js-cancel");

	save.on("click", function() {
		const td = this.findParent(4);
		const input = td.getElementsByTagName("input")[0];

		updateTopic(input);
	})

    cancel.on('click', function () {
		const td = this.findParent(4);
        const title = td.getElementsByClassName("js-title")[0];
		const inputCnt = td.getElementsByClassName("js-edit")[0];
		const input = inputCnt.getElementsByTagName("input")[0];

        title.classList.remove("d-none");
        inputCnt.classList.add("d-none");
        input.classList.remove("is-invalid");
        input.value = input.defaultValue;
    });

    input.on("keyup", function () {
        if (event.keyCode == 13) {
            if (this.value == "") {
                this.classList.add("is-invalid");
                return
            }
            const td = this.findParent(3);
			const title = td.getElementsByClassName("js-title")[0];
			const inputCnt = this.findParent(2);

            title.classList.remove("d-none");
            inputCnt.classList.add("d-none");

            updateTopic(this);
        }

        this.classList.remove("is-invalid");

    })
}

function updateTopic(input) {
    let id = input.dataset.topicId;
    let title = input.value;

    axios.patch(`/topics/update/${id}`, {
        title
    })
        .then(res => {
            topicsDatatable.ajax.reload();
            utilities.toastAlert("success", "Το topic ενημερώθηκε.");
        })
        .catch(err => {
            if (err.response.status == 422) {
                utilities.toastAlert("info", "Πρέπει να δώσετε τίτλο...");
                input.value = input.defaultValue;
            } else {

                console.log(err.response.status);
                utilities.toastAlert("error", "Παρουσιάστηκε κάποιο πρόβλημα ...");
            }
        })

}

//!##########################################
//!					Functions				#
//!##########################################

function resetBulk(bulkBtn, checkbox) {

    bulkBtn.text("Επιλογές  (0)");
    bulkBtn.addClass("btn-secondary");
    bulkBtn.removeClass("btn-warning");
    bulkBtn.prop("disabled", true);
    checkbox.prop("checked", false);
}

//!##############################################
//!					Initializers	            #
//!##############################################

const gpickr = new GPickr({
	el: '#new-topic-gradient',
	stops: []
})

gpickr.on('change', instance => {

	$("#gradient-input").val( instance.getGradient() )

});

const gpickrEdit = new GPickr({
	el: '#select-edit-gradient',
	stops: []	//! na min sbisti gia kanena logo!!!!
	
})

gpickrEdit.on('change', instance => {

	$("#topic-gradient").val( instance.getGradient() )

});