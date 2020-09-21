import utilities from '../main';

let trash = 0;
let dataRange = $("#daterange")

//! INIT DATATABLE
//!============================================================
const materialsDatatable = $("#materials-datatable").DataTable({
    order: [[ 7, "desc" ]],
    processing: true,
    serverSide: true,
    ajax: {
        url: "/materials/materials-datatable",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "post",
        data: function (d) {
            return $.extend({}, d, {
                from_date: fromDay($(".date")[0]),
                to_date: toDay($(".date")[0]),
                trash
            })
        }
    },
    columns: [
        {data: "action", name: "action", searchable: false, orderable: false, className: "text-left"},
        {data: "title", name: "title", className: "js-link cursor-pointer text-left"},
        {data: "status", name: "status", className: "text-left",orderable: false,},
        {data: "type", name: "type", className: "js-link cursor-pointer text-left"},
        {data: "updated_at", name: "updated_at", className: "js-link cursor-pointer text-left js-updated-at"},
        {data: "created_at", name: "created_at", className: "js-link cursor-pointer text-left",  orderData: [ 7]},
        {data: "courses", name: "courses", className: "js-link cursor-pointer text-left",orderable: false,visible:false},
        {data: "id", name: "id",visible: false},
    ],
    language: {
        emptyTable: "Δεν υπάρχουν εγγραφές",
        info: "_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα",
        infoEmpty: "0 απο 0 τα 0 αποτελέσματα",
        lengthMenu: "_MENU_",
        loadingRecords: "Φόρτωση ...",
        processing: "Επεξεργασία ...",
        search: "",
        zeroRecords: "Δεν βρέθηκαν αποτελέσματα",
        paginate: {
            previous: "<i class='mdi mdi-chevron-left'>",
            next: "<i class='mdi mdi-chevron-right'>"
        }
    },
    drawCallback: function () {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        $(".js-remove-table-classes > thead > tr > th").removeClass("js-link cursor-pointer js-updated-at");
        $("#materials-datatable_wrapper > .row:first-child > div:first-child").removeClass(" col-md-6");
        $("#materials-datatable_wrapper > .row:first-child > div:last-child").removeClass(" col-md-6");
        $("#materials-datatable_wrapper > .row:first-child > div:first-child").addClass("col-md-8");
        $("#materials-datatable_wrapper > .row:first-child > div:last-child").addClass("col-md-4");
        utilities.resetBulk($("#course-bulk-action-btn"), $("#select-all-courses"));
        utilities.resetBulk($("#course-bulk-action-btn"), $(".js-material-checkbox"));
        atLinkEventListener();
        toggleInit();
        selectMultipleCheckboxDelete()
        selectMultipleCheckboxUpdate()
        selectStatusMultiple()
        checkeBoxesEventListener()
    }
});


//! FILTER DATATABLE
//!============================================================
utilities.filterButton('#activeFilterMaterial', 2, materialsDatatable,"#materials-datatable_length label");
utilities.filterButton('#typeFilterMaterial', 3, materialsDatatable,"#materials-datatable_length label");
utilities.filterButton('#courseFilterMaterial', 6, materialsDatatable,"#materials-datatable_length label");

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


$(".trash-model").click( function () {


    trash = 1
    materialsDatatable.draw();


});


$(".all-model").click( function () {
    console.log("s")
    trash = 0
    materialsDatatable.draw();

});



//! DATAPICKER FUNCTION
//!============================================================
dataRange.daterangepicker( utilities.datePickerConfig );
dataRange.on("apply.daterangepicker", function (event, picker) {

    let startDate = picker.startDate.format('DD/MM/YYYY');
    let endDate = picker.endDate.format('DD/MM/YYYY');
    this.value = `${ startDate } - ${ endDate }`;
    this.classList.add("select2-selected");


    materialsDatatable.ajax.reload();

})
dataRange.on( 'cancel.daterangepicker', function(event, picker) {
    this.classList.remove("select2-selected");

    $(".date")[0].value = "";
    materialsDatatable.ajax.reload();
})
$("#daterange").detach().insertBefore('#materials-datatable_filter > label ')


//! METHOD FIRST TABLE
//!============================================================
function toggleInit() {
    $(".js-toggle").change(function () {

        let materialSlug = this.parentElement.parentElement.dataset.materialSlug
        let updatedAtCnt = this.parentElement.parentElement.getElementsByClassName("js-updated-at")[0];

        axios.patch(`/materials/toggle-status/${materialSlug}`, {
            state: this.checked ? 1 : 0
        })
            .then((res) => {
                let icon = this.checked ? "success" : "info";
                let message = this.checked ? "Ενεργοποιήθηκε" : "Απενεργοποιήθηκε";
                utilities.toastAlert(icon, message);
                updatedAtCnt.textContent = "Μόλις τώρα";
            })
            .catch((err) => {
                console.log(err)
                utilities.toastAlert("error", "Παρουσιάστηκε κάποιο πρόβλημα ...");
            })
    });
}

function atLinkEventListener() {
    $('.js-link').click(function () {
        let materialSlug = this.parentElement.dataset.materialSlug;
        // let materialSlug = this.parentElement.dataset.materialSlug;

        window.location = `material/${materialSlug}`;
    });
}

$("#courseFilterMaterial").change( function () {

    let label = $("#select2-courseFilterMaterial-container")[0];

    utilities.filterStyle( label, this.value );

});
$("#typeFilterMaterial").change( function () {

    let label = $("#select2-typeFilterMaterial-container")[0];

    utilities.filterStyle( label, this.value );

});
$("#activeFilterMaterial").change( function () {

    let label = $("#select2-activeFilterMaterial-container")[0];

    utilities.filterStyle( label, this.value );

});





//! SELECT
//!============================================================
$("#courseFilterMaterial").select2({
    text: '',
    // minimumInputLength: 2,
});

$("#typeFilterMaterial").select2({
    minimumResultsForSearch: -1,
});

$("#activeFilterMaterial").select2({
    minimumResultsForSearch: -1,

});

//! BULK ACTION
//!============================================================

const selectMultipleCheckboxDelete = () => {
    $('.js-multiple-delete').unbind();
    $(".js-multiple-delete").click(() => {
        let checkboxes = $(".js-user-checkbox:checked")

        let ids = [];

        for (let i = 0; i < checkboxes.length; i++) {
            ids.push(checkboxes[i].parentElement.parentElement.parentElement.dataset.materialId);
        }


        axiosMultipleDelete(ids)

    })
}

const axiosMultipleDelete = async (ids) => {

    try {
        const {value} = await utilities.toastAlertDelete(`Θέλετε να αφαιρέσετε το ${ids.length} απο τον χρήστη `)
        if (value) {
            const res = await axios.delete(config.routes.destroyMultipleMaterialDatatable, {
                data: {
                    'material_id': ids,
                }

            })
            if (res.status == 200) {
                $(".all-model")[0].textContent = `Ολα (${res.data.success.all})`
                $(".trash-model")[0].textContent = `Διεγραμενα (${res.data.success.trashMaterial})`
                utilities.toastAlert("success", `${ids.length} Διαγράφικαν`)
                materialsDatatable.ajax.reload()
            }
        }
    } catch (e) {
        console.log(e)
        utilities.toastAlert('error', "Παρουσιάστηκε κάποιο πρόβλημα")
    }
}

const selectMultipleCheckboxUpdate = () => {
    $('.js-multiple-update').unbind();
    $(".js-multiple-update").click(function () {
        let checkboxes = $(".js-user-checkbox:checked")

        let ids = [];

        for (let i = 0; i < checkboxes.length; i++) {
            ids.push(checkboxes[i].parentElement.parentElement.parentElement.dataset.materialId);
        }

        axiosMultipleUpdate(ids, this.dataset.coursesId)

    })
}

const axiosMultipleUpdate = async (ids, courseId) => {

    try {
        const {status} = await axios.patch(config.routes.addMaterialMultipleDatatable, {
            'material_id': ids,
            "course_id": courseId
        })

        if (status == 200) {
            utilities.toastAlert("success", `${ids.length} μαθητές προστέθηκαν`)
            console.log(status)
        }
    } catch (e) {
        console.log(e)
        utilities.toastAlert('error', "Παρουσιάστηκε κάποιο πρόβλημα")
    }
}

const selectStatusMultiple = () => {
    $('.js-multiple-change').unbind();
    $(".js-multiple-change").click(function () {
        let checkboxes = $(".js-material-checkbox:checked")

        let ids = [];

        for (let i = 0; i < checkboxes.length; i++) {
            ids.push(checkboxes[i].parentElement.parentElement.parentElement.dataset.materialId);
        }


        console.log("S")
        changeStatusMultiple(ids, this.dataset.coursesChange)

    })
}

const changeStatusMultiple = async (ids, stat) => {

    try {
        let {status} = await axios.patch(config.routes.changeStatusMultipleMaterialDatatable, {
            "material_id": ids,
            "status": stat,
        })

        if (status == 200) {
            utilities.toastAlert("success", `${ids.length} μαθητές προστέθηκαν`)
            materialsDatatable.ajax.reload();
        }
    } catch (e) {
        console.log(e)
        utilities.toastAlert('error', "Παρουσιάστηκε κάποιο πρόβλημα")
    }
}

function checkeBoxesEventListener() {

    let minorCheckboxes = $(".js-user-checkbox");
    let mainCheckbox = $("#select-all-courses")[0];
    let bulkBtn = $("#course-bulk-action-btn")[0];


    minorCheckboxes.unbind();

    minorCheckboxes.change(function () {
        utilities.mainCheckboxSwitcher(mainCheckbox, minorCheckboxes, bulkBtn)
    })

}

$("#select-all-courses").change(function () {
    let minorCheckboxes = $(".js-user-checkbox");
    let bulkBtn = $("#course-bulk-action-btn")[0];

    utilities.minorCheckboxSwitcher(this, minorCheckboxes, bulkBtn);

})








