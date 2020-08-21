import utilities from '../main';
//! GLOBAL VARIABLES
//!============================================================
$("#singledaterange").datepicker({dateFormat: 'dd-mm-yy'});
load_data();


function load_data(from_date = '', to_date = '') {


//! 			Datatables Initialization
//!##################################################
    const tables = $("#scroll-horizontal-datatable").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: config.routes.indexDatatable,
            headers: config.headers.csrf,
            type: "post",
            data: {from_date: from_date, to_date: to_date}
        },
        columns: [
            {
                data: null,
                name: "extra",
                orderable: false,
                className: 'details-control cursor-pointer',
                defaultContent: `<i class="mdi text-success h4 mdi-plus-thick"></i>`
            },
            {data: "chexbox", name: "chexbox", orderable: false,},
            {data: "avatar", name: "avatar", orderable: false, className: "js-link cursor-pointer"},
            {data: "first_name", name: "first_name", className: "js-link cursor-pointer"},
            {data: "last_name", name: "last_name", className: "js-link cursor-pointer"},
            {data: "action", name: "action", className: "js-link cursor-pointer"},
            {data: "email", name: "email", className: "js-link cursor-pointer"},
            {data: 'active', name: 'active', orderable: false},
            {data: 'created_at', name: 'created_at', className: "js-link cursor-pointer",visible: false},
            {data: 'activeNum', name: 'activeNum', visible: false},
            {data: 'dateChange', name: 'dateChange'},
            {data: 'allcourse', name: 'allcourse', visible: false},
        ],
        language: config.datatable.language,


        drawCallback: () => {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
            $(".dataTables_scrollHeadInner table > thead > tr > th").removeClass("js-link cursor-pointer");
            $("thead >tr> th").removeClass("js-link cursor-pointer");
            $("tfoot > tr > th").removeClass("js-link cursor-pointer");
            // filter();
            // refresh();
            toogleInput();
            routeLink();
            selectMultipleCheckboxDelete();
            selectMultipleCheckboxUpdate();
            pickDay();
            collapse();
            buttonEx()
        },


    })

    const sub_DataTable = (vtask_id, table_id, attr) => {

        window.subtabletable_id = $('#' + table_id).DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            pageLength: 5,
            bInfo: false,
            lengthChange: false,
            ajax: {
                url: config.routes.coursesInsideUsersDatatable,
                headers: config.headers.csrf,
                type: "post",
                data: {
                    'user_id': attr.parentElement.dataset.userId
                }
            },
            columns: [
                {data: 'action', name: 'action', orderable: false},
                {data: 'name', name: 'name',},
                // {data: 'active', name: 'active', orderable: false},
                {data: 'updated_at', name: 'updated_at',},
                {data: 'created_at', name: 'created_at',},
            ],
            language: config.datatable.language,


            drawCallback: () => {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                $(".dataTables_scrollHeadInner table > thead > tr > th").removeClass("js-link cursor-pointer");
                $("thead >tr> th").removeClass("js-link cursor-pointer");
                $("tfoot > tr > th").removeClass("js-link cursor-pointer");

                selectAlljscheckboxSubTable()
                selectDetachCourses();
            },


        })

    }


//! GLOBAL FUNCTION
//!============================================================
    utilities.selectAndDeselectCheckbox(".js-user-checkbox")
    utilities.filterButton('#fullNameFilter', 11, tables)
    utilities.filterButton('#rolesFilter', 5, tables)
    utilities.filterButton('#activeFilter', 9, tables)

//! FILTER DATATABLE
//!============================================================

    const pickDay = () => {
        $('.drp-buttons .applyBtn').click(function () {
            $('.drp-buttons .applyBtn').unbind();
            let date = $('.drp-selected').text();
            console.log(date)

            let dateSepareted = date.split("-")

            let from_date = dateSepareted[0]
            let to_date = dateSepareted[1]


            filter(from_date.replace(/\//g, "-").trim(), to_date.replace(/\//g, "-").trim())
        });

    }

    const filter = (from_date, to_date) => {
        if (from_date != '' && to_date != '') {
            $('#scroll-horizontal-datatable').DataTable().destroy();
            load_data(from_date, to_date);
        }

        console.log(from_date)
        console.log(to_date)


    }
    //
    // const refresh = () => {
    //     $('.drp-buttons .cancelBtn').click(function () {
    //         $('.drp-button .cancelBtn').unbind();
    //         $('.daterangepicker .left').val('');
    //         $('.daterangepicker .right').val('');
    //         $('#scroll-horizontal-datatable').DataTable().destroy();
    //         load_data();
    //     });
    // }


//! BULK ACTION
//!============================================================

    const selectMultipleCheckboxDelete = () => {
        $('.js-multiple-delete').unbind();
        $(".js-multiple-delete").click(() => {
            let checkboxes = $(".js-user-checkbox:checked")

            let ids = [];

            for (let i = 0; i < checkboxes.length; i++) {
                ids.push(checkboxes[i].parentElement.parentElement.parentElement.dataset.userId);
            }

            axiosMultipleDelete(ids)

        })
    }

    const axiosMultipleDelete = async (ids) => {

        try {
            const {status} = await axios.delete(config.routes.destroyMultipleUsersDatatable, {
                data: {
                    'user_id': ids,
                }

            })
            if (status == 200) {
                utilities.toastAlert("success", `${ids.length} Διαγράφικαν`)
                tables.ajax.reload()
            }
        } catch (e) {
            utilities.toastAlert('error', "Παρουσιάστηκε κάποιο πρόβλημα")
        }
    }

    const selectMultipleCheckboxUpdate = () => {
        $('.js-multiple-update').unbind();
        $(".js-multiple-update").click(function () {
            let checkboxes = $(".js-user-checkbox:checked")

            let ids = [];

            for (let i = 0; i < checkboxes.length; i++) {
                ids.push(checkboxes[i].parentElement.parentElement.parentElement.dataset.userId);
            }

            axiosMultipleUpdate(ids, this.dataset.coursesId)

        })
    }

    const axiosMultipleUpdate = async (ids, courseId) => {

        try {
            const {status} = await axios.patch(config.routes.addCoursesMultipleUsersDatatable, {
                'user_id': ids,
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

    const selectAlljscheckboxSubTable = () => {
        $(".js-user-multipleChexbox-sub").click(function () {
            let checkbox = $(".js-user-checkbox-sub")


            for (let i = 0; i < checkbox.length; i++) {
                checkbox[i].checked = !checkbox[i].checked
            }

            if (this.checked) {
                this.innerHTML = '<i class=" h3 mdi mdi-checkbox-multiple-blank-outline"></i>'
            } else {
                this.innerHTML = '<i class="h3 mdi mdi-checkbox-marked-outline"></i>\n'
            }
        })



    }

    const selectDetachCourses = ()=>{
        $('.js-detach-delete').unbind();
        $(".js-detach-delete").click(function () {
            let checkboxes = $(".js-user-checkbox-sub:checked")

            let ids = [];

            for (let i = 0; i < checkboxes.length; i++) {
                ids.push(checkboxes[i].dataset.courseId);
            }




            detachCoursesFromUser(ids,checkboxes[0].dataset.userId)

        })
    }

    const detachCoursesFromUser = async (courseId,userID)=>{

        const datatableId = $(".js-user-multipleChexbox-sub")[0].parentElement.parentElement.parentElement

        try {
            let {status} = await axios.delete(config.routes.destroyMultipleCoursesDatatable, {
                data: {
                    'course_id': courseId,
                    'user_id': userID
                }

            })
            if (status == 200) {
                utilities.toastAlert('error', `${courseId.length}  Aφαιρέθηκαν `)
                subtabletable_id.ajax.reload();

            }

        } catch (e) {
            console.log(e)
            utilities.toastAlert('error', "Παρουσιάστηκε κάποιο πρόβλημα")
        }
    }

    function buttonEx (){
        $('.button-Excel').unbind();
        $('.button-Excel').on('click', function (e, dt, node, config) {
            console.log(e)
            console.log(node)
        });
    }





//! METHOD FIRST TABLE
//!============================================================
    const toogleInput = () => {
        $('.toggle-class').unbind();

        $('.toggle-class').change(async function () {
            const status = $(this).prop('checked') == true ? 1 : 0;
            const user_id = $(this).data('id');
            try {
                const {data} = await axios.patch(config.routes.changeStatusDatatable, {
                    'active': status,
                    'id': user_id
                })
                tables.ajax.reload()
                utilities.toastAlert('success', this.checked ? "Ενεργοποιήθηκε" : "Απενεργοποιήθηκε")
            } catch (err) {
                utilities.toastAlert('error', "Παρουσιάστηκε κάποιο πρόβλημα")
            }
        })
    }

    const routeLink = () => {
        $('.js-link').click(function () {
            $('.js-link').unbind();

            let user = this.parentElement.dataset.userId;


            window.location = `/dashboard/users/${user}`;
        });
    }


//!METHOD SUB-TABLE
//!============================================================
    const formatSubTable = (table_id) => {
        return `

   <table id="${table_id}" class="table sub-table">
      <thead>
           <tr class="sub-table-tr">
                 <th id='all-user-checkbox' onclick="" class="text-left js-user-multipleChexbox-sub">
                    <i class="h3 mdi mdi-checkbox-marked-outline"></i>
                </th>
               <th class="text-left">Όνομα</th>
<!--               <th class="text-center">Ενεργό</th>-->
               <th class="text-left">Τελ. Ενημέρωση</th>
               <th class="text-left">Ημ. Δημιουργίας</th>
           </tr>
            </thead>
            <tbody class="tables-hover-effect"></tbody>
    </table>

        `

    }

    const collapse = () => {
        $('#scroll-horizontal-datatable tbody').off('click', 'td.details-control');
        $('#scroll-horizontal-datatable tbody').on('click', 'td.details-control', function () {
            let tr = $(this).closest('tr');
            let row = tables.row(tr);


            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
                this.firstChild.classList.remove("text-danger")
                this.firstChild.classList.add("text-success")


            }
            else {
                let virtual_task_id = row.data().id;
                let subId = "subtable-" + virtual_task_id;
                tr.addClass('shown');
                row.child(formatSubTable(subId)).show();
                this.firstChild.classList.add("text-danger")
                this.firstChild.classList.remove("text-success")
                sub_DataTable(virtual_task_id, subId, this);
;


            }
        });
    }


}



