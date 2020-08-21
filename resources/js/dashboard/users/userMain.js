import utilities from '../main';

$("#singledaterange").datepicker({dateFormat: 'dd-mm-yy'});

load_data();

function load_data(from_date = '', to_date = '') {
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
                className: 'details-control',
                defaultContent: `<i class="mdi text-success h4 mdi-plus-thick"></i>`
            },
            {data: "chexbox", name: "chexbox", orderable: false},
            {data: "avatar", name: "avatar", orderable: false, className: "js-link cursor-pointer"},
            {data: "first_name", name: "first_name", className: "js-link cursor-pointer"},
            {data: "last_name", name: "last_name", className: "js-link cursor-pointer"},
            {data: "action", name: "action", className: "js-link cursor-pointer"},
            {data: "email", name: "email", className: "js-link cursor-pointer"},
            {data: 'active', name: 'active', orderable: false},
            {data: 'created_at', name: 'created_at', className: "js-link cursor-pointer"},
            {data: 'activeNum', name: 'activeNum', visible: false},
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
        },


    })

    utilities.selectAndDeselectCheckbox(".js-user-checkbox")
    utilities.filterButton('#fullNameFilter', 2, tables)
    utilities.filterButton('#rolesFilter', 4, tables)
    utilities.filterButton('#activeFilter', 8, tables)


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

    function format(table_id) {
        // `d` is the original data object for the row

        return `

   <table id="${table_id}" class="table">
      <thead>
           <tr>
<!--               <th class="text-center option-column">Επιλογή</th>-->
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


    function collapse() {
        $('#scroll-horizontal-datatable tbody').on('click', 'td.details-control', function () {
            let tr = $(this).closest('tr');
            let row = tables.row(tr);



            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
                this.firstChild.classList.remove("text-danger")
                this.firstChild.classList.add("text-success")

            } else {
                let virtual_task_id = row.data().id;
                let subId = "subtable-" + virtual_task_id;
                row.child(format(subId)).show();
                tr.addClass('shown');
                this.firstChild.classList.add("text-danger")
                this.firstChild.classList.remove("text-success")
                sub_DataTable(virtual_task_id, subId,this);


            }
        });
    }

    function sub_DataTable(vtask_id, table_id,attr) {

        let subtable = $('#' + table_id).DataTable({
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
                data:{
                    'user_id' : attr.parentElement.dataset.userId
                }
            },
            columns: [
                // {data: 'action', name: 'action', orderable: false},
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
            },


        })

    }


}



