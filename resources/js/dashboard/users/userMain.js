import utilities from '../main';
//! GLOBAL VARIABLES
//!============================================================



//! 			Datatables Initialization
//!##################################################
const tables = $("#scroll-horizontal-datatable").DataTable({
    // caseInsensitive: false,
    order: [3, "asc"],
    processing: true,
    serverSide: true,
    ajax: {
        url: config.routes.indexDatatable,
        headers: config.headers.csrf,
        type: "post",
        data: function (d) {
            return $.extend({}, d, {
                from_date: fromDay,
                to_date: toDay
            })
        }
    },
    columns: [
        {
            data: null,
            name: "extra",
            orderable: false,
            className: 'details-control cursor-pointer',
            defaultContent: `<i class="mdi h4 mdi-plus-circle-outline text-success"></i>`
        },
        {data: "chexbox", name: "chexbox", orderable: false,},
        {data: "avatar", name: "avatar", orderable: false, visible: false, className: " "},
        {data: "first_name", name: "first_name", className: ""},
        {data: "last_name", name: "last_name", className: "js-link cursor-pointer"},
        {data: "action", name: "action", className: "js-link cursor-pointer"},
        {data: "email", name: "email", className: "js-link cursor-pointer"},
        {data: 'status', name: 'status', orderable: false},
        {data: 'created_at', name: 'created_at', className: "js-link cursor-pointer", visible: false},
        {data: 'activeNum', name: 'activeNum', visible: false},
        {data: 'dateChange', name: 'dateChange'},
        {data: 'allcourse', name: 'allcourse', visible: false},
    ],
    language: config.datatable.language,


    drawCallback: () => {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        $(".dataTables_scrollHeadInner table > thead > tr > th").removeClass("js-link cursor-pointer");
        $("thead >tr> th").removeClass("js-link cursor-pointer  text-primary");
        $("tfoot > tr > th").removeClass("js-link cursor-pointer");
        $("#scroll-horizontal-datatable_wrapper > .row:first-child > div:first-child").removeClass(" col-md-6");
        $("#scroll-horizontal-datatable_wrapper > .row:first-child > div:last-child").removeClass(" col-md-6");
        $("#scroll-horizontal-datatable_wrapper > .row:first-child > div:first-child").addClass("col-md-8");
        $("#scroll-horizontal-datatable_wrapper > .row:first-child > div:last-child").addClass("col-md-4");
        toogleInput();
        routeLink();
        selectMultipleCheckboxDelete();
        selectMultipleCheckboxUpdate();
        collapse();
        buttonEx();
        editColapse()
        hoverOnSelect()
        selectStatusMultiple()

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
            {data: 'title', name: 'title', className: "js-link-course cursor-pointer"},
            // {data: 'status', name: 'status', orderable: false},
            {data: 'updated_at', name: 'updated_at', className: "js-link-course cursor-pointer"},
            {data: 'created_at', name: 'created_at', className: "js-link-course cursor-pointer"},
        ],
        language: config.datatable.language,


        drawCallback: () => {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
            $(".dataTables_scrollHeadInner table > thead > tr > th").removeClass("js-link cursor-pointer");
            $("thead >tr> th").removeClass("js-link cursor-pointer");
            $("tfoot > tr > th").removeClass("js-link cursor-pointer");

            selectAlljscheckboxSubTable()
            selectDetachCourses();
            routeLinkCourse();
            hoverOnSelectSub()

        },


    })

}




//! GLOBAL FUNCTION
//!============================================================
utilities.selectAndDeselectCheckbox(".js-user-checkbox")
utilities.filterButton('#activeFilter', 9, tables)
utilities.filterButton('#rolesFilter', 5, tables)
utilities.filterButton('#fullNameFilter', 11, tables)





//! DATAPICKER METHOD
//!============================================================
let dataRange = $("#daterange")

dataRange[0].value = ""

const fromDay = () => {
    let date = $('.drp-selected').text();

    let dateSepareted = date.split("-")
    let from_date = dateSepareted[0]
    if (dataRange[0].value == "cancel") {
        dataRange[0].value = ""
        return
    }
    if (from_date) {

        console.log(from_date)
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

$(".ragneButton").detach().appendTo('.dataTables_length label')

dataRange.on("apply.daterangepicker", function (event, picker) {

    let startDate = picker.startDate.format('DD/MM/YYYY');
    let endDate = picker.endDate.format('DD/MM/YYYY');
    this.value = `${startDate} - ${endDate}`;

    tables.ajax.reload();

})

$(".cancelBtn ").click(function (event, picker) {
    dataRange[0].value = "cancel"
    tables.ajax.reload();
})




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
        const {value} = await utilities.toastAlertDelete(`Θέλετε να αφαιρέσετε το ${ids.length} απο τον χρήστη `)
        if (value) {
            const {status} = await axios.delete(config.routes.destroyMultipleUsersDatatable, {
                data: {
                    'user_id': ids,
                }

            })
            if (status == 200) {
                utilities.toastAlert("success", `${ids.length} Διαγράφικαν`)
                tables.ajax.reload()
            }
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

const detachCoursesFromUser = async (courseId, userID) => {

    const datatableId = $(".js-user-multipleChexbox-sub")[0].parentElement.parentElement.parentElement

    try {
        const {value} = await utilities.toastAlertDelete(`Θέλετε να αφαιρέσετε  απο τον χρήστη `)
        if (value) {
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

        let checkboxes = document.querySelectorAll(".js-user-checkbox-sub:checked").length
        if (checkboxes) {
            $(".bulk-action")[0].disabled = false
            $(".bulk-action")[0].innerText = ` Επιλογές ${checkboxes == 0 ? "" : `( ${checkboxes} ) `} `

            this.innerHTML = '<i class=" h3 mdi mdi-checkbox-multiple-blank-outline"></i>'
            $(".bulk-action")[0].classList.add("bg-warning")
            $(".bulk-action")[0].classList.remove("bg-secontary")
        } else {
            $(".bulk-action")[0].innerText = ` Επιλογές  `
            $(".bulk-action")[0].disabled = true
            this.innerHTML = '<i class="h3 mdi mdi-checkbox-marked-outline"></i>\n'
            $(".bulk-action")[0].classList.remove("bg-warning")
            $(".bulk-action")[0].classList.add("bg-secontary")
        }
    })
}

const selectDetachCourses = () => {
    $('.js-detach-delete').unbind();
    $(".js-detach-delete").click(function () {
        let checkboxes = $(".js-user-checkbox-sub:checked")

        let ids = [];

        for (let i = 0; i < checkboxes.length; i++) {
            ids.push(checkboxes[i].dataset.courseId);
        }


        detachCoursesFromUser(ids, checkboxes[0].dataset.userId)

    })
}

const selectStatusMultiple = () => {
    $('.js-multiple-change').unbind();
    $(".js-multiple-change").click(function () {
        let checkboxes = $(".js-user-checkbox:checked")

        let ids = [];

        for (let i = 0; i < checkboxes.length; i++) {
            ids.push(checkboxes[i].parentElement.parentElement.parentElement.dataset.userId);
        }


        changeStatusMultiple(ids,this.dataset.coursesChange)

    })
}

const changeStatusMultiple =async (ids,stat) => {

    try{
        let {status} = await axios.patch(config.routes.changeStatusMultipleDatatable,{
            "user_id":ids,
            "status":stat,
        })

        if (status == 200) {
            utilities.toastAlert("success", `${ids.length} μαθητές προστέθηκαν`)
            tables.ajax.reload();
        }
    } catch (e) {
        console.log(e)
        utilities.toastAlert('error', "Παρουσιάστηκε κάποιο πρόβλημα")
    }
}



//! EXPORT
//!============================================================
function buttonEx() {
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
                'status': status,
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

        let slug = this.parentElement.dataset.userSlug;
        console.log(this.parentElement.dataset)


        window.location = `/dashboard/users/${slug}`;
    });
}

const hoverOnSelect = () => {
    $(".js-user-checkbox").change(function () {
        $(".bulk-action")[0].disabled = false
        $(".bulk-action")[0].classList.add("bg-warning")
        $(".bulk-action")[0].classList.remove("bg-secontary")

        let checkboxes = $(".js-user-checkbox:checked").length

        if (!checkboxes) {
            $(".bulk-action")[0].disabled = true
            $(".bulk-action")[0].classList.remove("bg-warning")
            $(".bulk-action")[0].classList.add("bg-secontary")
        }

        $(".bulk-action")[0].innerText = ` Επιλογές ${checkboxes == 0 ? "" : `( ${checkboxes} ) `} `
        if (this.checked) {
            this.parentElement.parentElement.parentElement.classList.add("trHover")
        } else {
            this.parentElement.parentElement.parentElement.classList.remove("trHover")
        }
    })

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

const EditSubtable = () => {
    return `

<form>
  <div class="form-group row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
    <div class="col-sm-10">
      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="email@example.com">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="inputPassword" placeholder="Password">
    </div>
  </div>
</form>

        `

}

const editColapse = () => {
    $('#scroll-horizontal-datatable tbody').off('click', '.extraContentEdit .edit');
    $('#scroll-horizontal-datatable tbody').on('click', '.extraContentEdit .edit', function () {


        let tr = $(this).closest('tr');
        let row = tables.row(tr);


        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');


        } else {
            let virtual_task_id = row.data().id;
            let subId = "subtable-" + virtual_task_id;
            tr.addClass('shown');
            row.child(EditSubtable()).show();

        }
    });
}

const collapse = () => {
    $('#scroll-horizontal-datatable tbody').off('click', 'td.details-control');
    $('#scroll-horizontal-datatable tbody').on('click', 'td.details-control', function () {
        let tr = $(this).closest('tr');
        let row = tables.row(tr);


        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown trHover');
            this.firstChild.classList.remove("text-danger")
            this.firstChild.classList.add("text-success")


        } else {
            let virtual_task_id = row.data().id;
            let subId = "subtable-" + virtual_task_id;
            tr.addClass("trHover shown");
            row.child(formatSubTable(subId)).show();
            this.firstChild.classList.add("text-danger")
            this.firstChild.classList.remove("text-success")
            sub_DataTable(virtual_task_id, subId, this);
            ;


        }
    });
}

const routeLinkCourse = () => {
    $('.js-link-course').click(function () {
        $('.js-link-course').unbind();

        let user = this.parentElement.dataset.courseId;

        window.open(`/dashboard/course/${user}`, '_blank');
        // window.location = `/dashboard/course/${user}`;
    });
}

const hoverOnSelectSub = () => {

    $(".js-user-checkbox-sub").change(function () {
        $(".bulk-action")[0].disabled = false
        $(".bulk-action")[0].classList.add("bg-warning")
        $(".bulk-action")[0].classList.remove("bg-secontary")
        let checkboxes = $(".js-user-checkbox-sub:checked").length

        if (!checkboxes) {
            $(".bulk-action")[0].disabled = true
            $(".bulk-action")[0].classList.remove("bg-warning")
            $(".bulk-action")[0].classList.add("bg-secontary")
        }

        $(".bulk-action")[0].innerText = ` Επιλογές ${checkboxes == 0 ? "" : `( ${checkboxes} ) `} `
        if (this.checked) {
            this.parentElement.parentElement.parentElement.classList.add("trHover")
        } else {
            this.parentElement.parentElement.parentElement.classList.remove("trHover")
        }
    })

}





