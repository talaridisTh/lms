import utilities from '../main';

    let materialId = $("#material-course-table")[0].dataset.materialId;


//! DATATABLE INIT
//!============================================================
const materialCourseDatatable = $("#material-course-table").DataTable({
    // order: [[ 5, "desc" ]],
    processing: true,
    serverSide: true,
    ajax: {
        url: config.routes.materialCoursesDatatable,
        headers: config.headers.csrf,
        type: "post",
        data: {
            materialId
        }
        // data: function (d) {
        //     return $.extend({}, d, {
        //         from_date: fromDay($(".date")[0]),
        //         to_date: toDay($(".date")[0])
        //     })
        // }
    },
    columns: [
        {data: "checkbox", name: "checkbox", searchable: false, orderable: false, className: "text-left"},
        {data: "title", name: "title"},
        {data: "topics", name: "topics.title"},
        {data: "curator", name: "curator"},
        {data: "updated_at", name: "updated_at"},
        {data: "humans", name: "humans"},
        {data: "created_at", name: "created_at"},
        {data: "active", name: "active" ,visible:false},

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
        utilities.resetBulk($("#course-indside-material-bulk"), $("#select-all-courses"));
        utilities.resetBulk($("#course-indside-material-bulk"), $(".js-course-inside-material"));
        checkeBoxesEventListener();
        selectMultipleCheckboxDelete();
    }
});

//! EDITOR INIT
//!============================================================

$R('#summaryMaterial',{
    minHeight: '150px'
});
$R('#descriptionMaterial',{
    minHeight: '150px'
});
$R('#contentMaterial',{
    minHeight: '150px'
}); ``

//! METHOD FORM HIDEN
//!============================================================

//! utilities.changeInputHidden('#coursesMaterial','#coursesMaterialHidden')

//! GLOBAL FUNCTION Filter
//!============================================================
utilities.filterButton('#topicFilterMaterialCourses', 2, materialCourseDatatable)
utilities.filterButton('#activeFilterMaterialCourses', 7, materialCourseDatatable)
utilities.filterButton('#userFilterMaterialCourses', 3, materialCourseDatatable)

//! SELECT2
//!============================================================
$("#typeMaterial").select2({
    minimumResultsForSearch: -1,
});

$("#instructorMaterial").select2({

    tags: true
});

$("#topicMaterial").select2({
    tags: true
});


$("#topicFilterMaterialCourses").select2({});

$(".custom-select").select2({   minimumResultsForSearch: -1,});

$("#activeFilterMaterialCourses").select2({   minimumResultsForSearch: -1,});

$("#userFilterMaterialCourses").select2({   minimumResultsForSearch: -1,});


//sortable
$("ul.select2-selection__rendered").sortable({
    containment: 'parent'
});


//! DATARANGE
//!============================================================

let dataRange = $("#createAtMaterial")

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


//! EVENT listener
//!============================================================
$("#update-btn").click( function() {
    $(".formPrevent").submit();
});


$(".tab-link").on("show.bs.tab", function(event) {

    event.preventDefault();
    Swal.fire(
        'Προσοχή',
        '<p>Θα πρέπει να αποθηκεύσετε </p>για να συνεχίσετε!',
        'info'
    );

})

//! BULK ACTIOON
//!============================================================

function checkeBoxesEventListener() {

    let minorCheckboxes = $(".js-course-inside-material");
    let mainCheckbox = $("#select-all-courses")[0];
    let bulkBtn = $("#course-indside-material-bulk")[0];


    minorCheckboxes.unbind();

    minorCheckboxes.change(function () {
        utilities.mainCheckboxSwitcher(mainCheckbox, minorCheckboxes, bulkBtn)
    })

}

$("#select-all-courses").change(function () {
    let minorCheckboxes = $(".js-course-inside-material");
    let bulkBtn = $("#course-indside-material-bulk")[0];

    utilities.minorCheckboxSwitcher(this, minorCheckboxes, bulkBtn);

})


const selectMultipleCheckboxDelete = () => {
    $('#js-multiple-delete').unbind();
    $("#js-multiple-delete").click(() => {
        let checkboxes = $(".js-course-inside-material:checked")
        let materialId = $("#material-course-table")[0].dataset.materialId

        let ids = [];

        for (let i = 0; i < checkboxes.length; i++) {
            ids.push(checkboxes[i].findParent(3).dataset.courseId);
        }



        axiosMultipleDelete(ids,materialId)

    })
}

const axiosMultipleDelete = async (courseId,materialId) => {

    try {
        const {value} = await utilities.toastAlertDelete(`Θέλετε να αφαιρέσετε το ${courseId.length} απο τα μαθήματα `)
        if (value) {
            const {status} = await axios.delete("/materials/multiple/course/delete", {
                data: {
                    courseId,
                    materialId,
                }

            })
            if (status == 200) {
                utilities.toastAlert("success", `${courseId.length} αφερέθηκαν`)
                materialCourseDatatable.ajax.reload()
            }
        }
    } catch (e) {
        console.log(e)
        utilities.toastAlert('error', "Παρουσιάστηκε κάποιο πρόβλημα")
    }
}



