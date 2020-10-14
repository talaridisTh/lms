import utilities from '../main';
//! GLOBAL VARIABLES
//!============================================================
let dataRange = $("#daterange")


//! 			Datatables Initialization
//!##################################################
const tables = $("#scroll-horizontal-datatable").DataTable({
    // caseInsensitive: false,
    order: [9, "desc"],
    processing: true,
    serverSide: true,
    ajax: {
        url: config.routes.indexDatatable,
        headers: config.headers.csrf,
        type: "post",
        data: function (d) {
            return $.extend({}, d, {
                from_date: fromDay($(".date")[0]),
                to_date: toDay($(".date")[0])
            })
        }
    },
    columns: [
        {
            data: null,
            searchable: false,
            name: "extra",
            orderable: false,
            className: 'details-control cursor-pointer',
            defaultContent: `<i class="mdi h4 mdi-plus-circle-outline text-success"></i>`
        },
        {data: "chexbox", name: "chexbox", orderable: false,},
        {data: "last_name", name: "last_name", className: "js-link cursor-pointer"},
        {data: "first_name", name: "first_name"},
        {data: "roles", name: "roles", className: "js-link cursor-pointer role-user"},
        {data: "email", name: "email", className: "js-link cursor-pointer"},
        {data: 'status', name: 'status', orderable: false},
        // {data: 'created', name: 'created',orderData: [ 10],visible:false},
        {data: 'created_at', name: 'users.created_at', orderData: [9]},
        {data: 'courses', name: 'courses', orderable: false, visible: false},
        {data: 'id', name: 'id',visible: false},
    ],
    language: config.datatable.language,


    drawCallback: () => {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        $(".dataTables_scrollHeadInner table > thead > tr > th").removeClass("js-link cursor-pointer");
        $("thead >tr> th").removeClass("js-link cursor-pointer role-user  text-primary");
        $("tfoot > tr > th").removeClass("js-link cursor-pointer");
        $("#scroll-horizontal-datatable_wrapper > .row:first-child > div:first-child").removeClass(" col-md-6");
        $("#scroll-horizontal-datatable_wrapper > .row:first-child > div:last-child").removeClass(" col-md-6");
        $("#scroll-horizontal-datatable_wrapper > .row:first-child > div:first-child").addClass("col-md-8");
        $("#scroll-horizontal-datatable_wrapper > .row:first-child > div:last-child").addClass("col-md-4");
        $("#scroll-horizontal-datatable_filter").addClass("d-flex justify-content-around");
        utilities.resetBulk($("#course-bulk-action-btn"), $("#select-all-courses"));
        utilities.resetBulk($("#course-bulk-action-btn"), $(".js-user-checkbox"));

        toogleInput();
        routeLink();
        selectMultipleCheckboxDelete();
        selectMultipleCheckboxUpdate();
        collapse();
        buttonEx();
        editColapse()
        selectStatusMultiple()
        checkeBoxesEventListener()

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
            utilities.resetBulk($("#course-bulk-action-btn"), $(".js-user-checkbox-sub"));

            selectDetachCourses();
            routeLinkCourse();
            checkeBoxesEventListenerSub()

        },


    })

}


//! GLOBAL FUNCTION Filter
//!============================================================
utilities.filterButton('#activeFilter', 6, tables, "#scroll-horizontal-datatable_length label")
utilities.filterButton('#rolesFilter', 4, tables, "#scroll-horizontal-datatable_length label")
utilities.filterButton('#fullNameFilter', 8, tables, "#scroll-horizontal-datatable_length label")

//! EVENT LISTENER
//!============================================================
$("#fullNameFilter").change(function () {

    let label = $("#select2-fullNameFilter-container")[0];

    utilities.filterStyle(label, this.value);

});
$("#rolesFilter").change(function () {

    let label = $("#select2-rolesFilter-container")[0];

    utilities.filterStyle(label, this.value);

});
$("#activeFilter").change(function () {

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

dataRange.daterangepicker(utilities.datePickerConfig);

$(".ragneButton").detach().insertBefore('#scroll-horizontal-datatable_filter > label ')

dataRange.on("apply.daterangepicker", function (event, picker) {

    let startDate = picker.startDate.format('DD/MM/YYYY');
    let endDate = picker.endDate.format('DD/MM/YYYY');
    this.value = `${startDate} - ${endDate}`;
    this.classList.add("select2-selected");

    tables.ajax.reload();

})

dataRange.on('cancel.daterangepicker', function (event, picker) {
    this.classList.remove("select2-selected");
    $(".date")[0].value = "";
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

const selectStatusMultiple = () => {
    $('.js-multiple-change').unbind();
    $(".js-multiple-change").click(function () {
        let checkboxes = $(".js-user-checkbox:checked")

        let ids = [];

        for (let i = 0; i < checkboxes.length; i++) {
            ids.push(checkboxes[i].parentElement.parentElement.parentElement.dataset.userId);
        }


        changeStatusMultiple(ids, this.dataset.coursesChange)

    })
}

const changeStatusMultiple = async (ids, stat) => {

    try {
        let {status} = await axios.patch(config.routes.changeStatusMultipleDatatable, {
            "user_id": ids,
            "status": stat,
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
        const {status} = await axios.patch(config.routes.AddMultipleUserCourseDatatable, {
            'user_id': ids,
            "course_id": courseId
        })

        if (status == 200) {
            utilities.resetBulk($("#course-bulk-action-btn"), $("#select-all-courses"));
            utilities.resetBulk($("#course-bulk-action-btn"), $(".js-user-checkbox"));
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

function checkeBoxesEventListener() {

    let minorCheckboxes = $(".js-user-checkbox");
    let mainCheckbox = $("#select-all-courses")[0];
    let bulkBtn = $("#course-bulk-action-btn")[0];

    console.log("s")
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

$("#course-bulk-action-btn").click(function () {
    const elements = document.querySelectorAll('.role-user');
    let trialUser = ""

    elements.forEach(function el() {


    })
    // console.log($(".role-user")[0].textContent))
})


//! EXPORT
//!============================================================
function buttonEx() {
    $('.button-Excel').unbind();
    $('.button-Excel').on('click', function () {
        let checkboxes = $(".js-user-checkbox:checked")


        let test = []

        for (var i = 0; i < checkboxes.length; i++) {

            test.push(checkboxes[i].dataset.userId)

        }
        var arrayOfNumbers = test.map(parseFloat)
        axiosExportUser(arrayOfNumbers, this)

    });
}

const axiosExportUser = async (id, that) => {

    try {
        const res = await axios.get(`/export/users/${id}`)


        if (res.status == 200) {
            window.location.href = `/export/users/${id}`;
            utilities.toastAlert('success',"")
        }


    } catch (e) {
        utilities.toastAlert('error', "Παρουσιάστηκε κάποιο πρόβλημα")
    }
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

function checkeBoxesEventListenerSub() {

    let minorCheckboxes = $(".js-user-checkbox-sub");
    let mainCheckbox = $("#select-all-courses")[0];
    let bulkBtn = $("#course-bulk-action-btn")[0];


    minorCheckboxes.unbind();

    minorCheckboxes.change(function () {
        utilities.mainCheckboxSwitcher(mainCheckbox, minorCheckboxes, bulkBtn)
    })

}





