import utilities from '../main';


//! INIT DATATABLE
//!============================================================
const materialsDatatable = $("#materials-datatable").DataTable({
    order: [1, "asc"],
    processing: true,
    serverSide: true,
    ajax: {
        url: "/materials/materials-datatable",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "post",
        data: function (d) {
            return $.extend({}, d, {
                from_date: fromDay,
                to_date: toDay
            })
        }
    },
    columns: [
        {data: "action", name: "action", searchable: false, orderable: false, className: "text-left"},
        {data: "title", name: "title", className: "js-link cursor-pointer text-left"},
        {data: "status", name: "status", className: "text-left"},
        {data: "type", name: "type", className: "js-link cursor-pointer text-left"},
        {data: "updated_at", name: "updated_at", className: "js-link cursor-pointer text-left js-updated-at"},
        {data: "created_at", name: "created_at", className: "js-link cursor-pointer text-left", visible: false},
        {data: "humans", name: "humans", className: "js-link cursor-pointer text-left"},
        {data: "courses", name: "courses", className: "js-link cursor-pointer text-left", visible: false},
        {data: "activeHidden", name: "activeHidden", visible: false},
    ],
    language: {
        emptyTable: "Δεν υπάρχουν εγγραφές",
        info: "_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα",
        infoEmpty: "0 απο 0 τα 0 αποτελέσματα",
        lengthMenu: "_MENU_",
        loadingRecords: "Φόρτωση ...",
        processing: "Επεξεργασία ...",
        search: "Αναζήτηση: ",
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
        atLinkEventListener();
        toggleInit();
        selectMultipleCheckboxDelete()
        selectMultipleCheckboxUpdate()
        hoverOnSelect()
        selectStatusMultiple()
    }
});



//! FILTER DATATABLE
//!============================================================
utilities.selectAndDeselectCheckbox(".js-user-checkbox");
utilities.filterButton('#activeFilterMaterial', 8, materialsDatatable);
utilities.filterButton('#typeFilterMaterial', 3, materialsDatatable);
utilities.filterButton('#courseFilterMaterial', 7, materialsDatatable);

const fromDay = () => {
    let date = $('.drp-selected').text();
    let dateSepareted = date.split("-")
    let from_date = dateSepareted[0]
    if (dataRange[0].value == "cancel") {
        dataRange[0].value = ""
        return
    }
    if (from_date) {

        return from_date.replace(/\//g, "-").trim();
    }


}

const toDay = () => {
    let date = $('.drp-selected').text();
    let dateSepareted = date.split("-")
    let to_date = dateSepareted[1]
    if (dataRange[0].value == "cancel") {
        dataRange[0].value = ""
        return
    }
    if (to_date) {
        return to_date.replace(/\//g, "-").trim()
    }


}


//! DATAPICKER FUNCTION
//!============================================================
let dataRange = $("#daterange")

dataRange[0].value = ""

dataRange.daterangepicker({
    locale: {
        format: 'YY/MM/DD '
    },
    startDate: moment().startOf('hour'),
    // ranges: {
    //     'Today': [moment(), moment()],
    //     'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
    //     'Last 7 Days': [moment().subtract(6, 'days'), moment()],
    //     'Last 30 Days': [moment().subtract(29, 'days'), moment()],
    //     'This Month': [moment().startOf('month'), moment().endOf('month')],
    //     'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    // },
    alwaysShowCalendars: true,
    showCustomRangeLabel: false,
    drops: "auto",
    autoUpdateInput: false,
    opens: "center",
});

dataRange.on("apply.daterangepicker", function (event, picker) {

    let startDate = picker.startDate.format('DD/MM/YYYY');
    let endDate = picker.endDate.format('DD/MM/YYYY');
    this.value = `${startDate} - ${endDate}`;


    materialsDatatable.ajax.reload();

})

$(".cancelBtn ").click(function (event, picker) {
    dataRange[0].value = "cancel"
    materialsDatatable.ajax.reload();
})



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

const hoverOnSelect = () => {

    $(".js-user-checkbox").change(function () {

        let checkboxes = $(".js-user-checkbox:checked").length

        $(".bulk-action")[0].disabled = false

        if (!checkboxes) {
            $(".bulk-action")[0].disabled = true
        }
        $(".bulk-action")[0].innerText = ` Επιλογές ${checkboxes == 0 ? "" : `( ${checkboxes} ) `} `

        if (this.checked) {
            this.parentElement.parentElement.parentElement.classList.add("trHover")
            $(".bulk-action")[0].classList.add("bg-warning")
            $(".bulk-action")[0].classList.remove("bg-secontary")

        } else {
            $(".bulk-action")[0].classList.remove("bg-warning")
            $(".bulk-action")[0].classList.add("bg-secontary")
            this.parentElement.parentElement.parentElement.classList.remove("trHover")
        }
    })
}


//! SELECT
//!============================================================
$("#courseFilterMaterial").select2({
    text: '',
    placeholder: "Ολα τα Courses",
    allowClear: true,
    // minimumInputLength: 2,
});

$("#typeFilterMaterial").select2({
    placeholder: "Ολοι οι Τύποι",
    minimumResultsForSearch: -1,
    allowClear: true,
});

$("#activeFilterMaterial").select2({
    minimumResultsForSearch: -1,
    placeholder: "Kατάσταση ",
    allowClear: true,
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
            const {status} = await axios.delete(config.routes.destroyMultipleMaterialDatatable, {
                data: {
                    'material_id': ids,
                }

            })
            if (status == 200) {
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



