import utilities from '../main';

load_data();


function load_data(from_date = '', to_date = '') {

    const materialsDatatable = $("#materials-datatable").DataTable({
        order: [1, "asc"],
        processing: true,
        serverSide: true,
        ajax: {
            url: "/materials/materials-datatable",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "post",
            data: {from_date: from_date, to_date: to_date}
        },
        columns: [
            {data: "action", name: "action", searchable: false, orderable: false, className: "text-left"},
            {data: "title", name: "title", className: "js-link cursor-pointer text-left"},
            {data: "active", name: "active", className: "text-left"},
            {data: "type", name: "type", className: "js-link cursor-pointer text-left"},
            {data: "updated_at", name: "updated_at", className: "js-link cursor-pointer text-left js-updated-at"},
            {data: "created_at", name: "created_at", className: "js-link cursor-pointer text-left", visible: false},
            {data: "humans", name: "humans", className: "js-link cursor-pointer text-left"},
            {data: "courses", name: "courses", className: "js-link cursor-pointer text-left", visible: false},
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
            atLinkEventListener();
            toggleInit();
            pickDay();
            selectMultipleCheckboxDelete()
            selectMultipleCheckboxUpdate()
            NumOfCheckBox()
            hoverOnSelect()
        }
    });

//! FILTER DATATABLE
//!============================================================
    utilities.selectAndDeselectCheckbox(".js-user-checkbox");
    utilities.filterButton('#activeFilterMaterial', 2, materialsDatatable);
    utilities.filterButton('#typeFilterMaterial', 3, materialsDatatable);
    utilities.filterButton('#courseFilterMaterial', 7, materialsDatatable);

    const pickDay = () => {
        $('.drp-buttons .applyBtn').click(function () {
            $('.drp-buttons .applyBtn').unbind();
            let date = $('.drp-selected').text();


            let dateSepareted = date.split("-")

            let from_date = dateSepareted[0]
            let to_date = dateSepareted[1]


            filter(from_date.replace(/\//g, "-").trim(), to_date.replace(/\//g, "-").trim())
        });

    }

    const filter = (from_date, to_date) => {
        if (from_date != '' && to_date != '') {
            $('#materials-datatable').DataTable().destroy();
            load_data(from_date, to_date);
        }
    }

//! METHOD FIRST TABLE
//!============================================================
    function toggleInit() {
        $(".js-toggle").change(function () {

            let materialSlug = this.parentElement.parentElement.dataset.materialSlug
            let updatedAtCnt = this.parentElement.parentElement.getElementsByClassName("js-updated-at")[0];

            axios.patch(`/materials/toggle-active/${materialSlug}`, {
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

            window.location = `material/${materialSlug}`;
        });
    }




    const hoverOnSelect = () => {

        $(".js-user-checkbox").change(function () {

            $(".bulk-action")[0].hidden = false

            let checkboxes = $(".js-user-checkbox:checked").length
            if(!checkboxes) $(".bulk-action")[0].hidden = true
            $(".bulk-action")[0].innerText = ` Επιλογές ${checkboxes == 0 ? "" : `( ${checkboxes} ) `} `

            if (this.checked) {
                this.parentElement.parentElement.parentElement.classList.add("trHover")

            } else {
                this.parentElement.parentElement.parentElement.classList.remove("trHover")
            }
        })
    }


//! DATAPICKER
//!============================================================
    $(document).ready(function () {
        $("#courseFilterMaterial").select2({
            text: '',
            placeholder: "Courses",
            allowClear: true,
            // minimumInputLength: 2,
        });

        $("#typeFilterMaterial").select2({
            placeholder: "Type",
            minimumResultsForSearch: -1,
            allowClear: true,
        });

        $("#activeFilterMaterial").select2({
            minimumResultsForSearch: -1,
            placeholder: "Active",
            allowClear: true,
        });
    })

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
            const {status} = await axios.delete(config.routes.destroyMultipleMaterialDatatable, {
                data: {
                    'material_id': ids,
                }

            })
            if (status == 200) {
                utilities.toastAlert("success", `${ids.length} Διαγράφικαν`)
                materialsDatatable.ajax.reload()
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

    const NumOfCheckBox = () => {
        $(".dropdown-toggle").click(function () {
            let checkboxes = $(".js-user-checkbox:checked").length
            let checkboxesSub = $(".js-user-checkbox-sub:checked").length
            console.log(checkboxesSub)


            $("#dropdownMenuButton")[0].innerText = ` Προσθήκη σε Course ${checkboxes == 0 ? "" : `( ${checkboxes} ) `} `
            $(".js-multiple-delete")[0].innerText = ` Διαγραφη επιλεγμενων ${checkboxes == 0 ? "" : `( ${checkboxes} ) `} `


        })
    }

}
