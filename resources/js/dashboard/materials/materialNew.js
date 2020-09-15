import utilities from '../main';
import Dropzone from "../../../plugins/dropzone/js/dropzone";

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
        {data: "curator", name: "curator"},
        {data: "updated_at", name: "updated_at"},
        {data: "created_at", name: "created_at",visible:false},

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

const addCouseModal = $("#remaining-course-material-table").DataTable({
    // order: [[ 5, "desc" ]],
    processing: true,
    serverSide: true,
    ajax: {
        url: '/materials/add-course-inside-material',
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
        {data: "curator", name: "curator"},
        {data: "version", name: "version"},
        {data: "action", name: "action"},

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

        utilities.resetBulk($("#add-remaingings-btn"), $("#all-remainings-checkbox"));
        utilities.resetBulk($("#add-remaingings-btn"), $(".remainings-checkbox"));
        checkeBoxesEventListenerModal();
        addCourse();
        selectMultipleCheckboxUpdate();

    }
})

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
utilities.filterButton('#topicFilterMaterialCourses', 1, materialCourseDatatable,"#material-course-table_length label")
utilities.filterButton('#activeFilterMaterialCourses', 7, materialCourseDatatable,"#material-course-table_length label")
utilities.filterButton('#userFilterMaterialCourses', 2, materialCourseDatatable,"#material-course-table_length label")

//! SELECT2
//!============================================================
//contant

$("#typeMaterial").select2({
    minimumResultsForSearch: -1,
});

$("#instructorMaterial").select2({

    tags: true
});

$("#topicMaterial").select2({
    tags: true
});

//datatable
$("#topicFilterMaterialCourses").select2({});

$(".custom-select").select2({   minimumResultsForSearch: -1,});

$("#activeFilterMaterialCourses").select2({   minimumResultsForSearch: -1,});

$("#userFilterMaterialCourses").select2({   });

$("#topicFilterMaterialCourses").change(function () {

    let label = $("#select2-topicFilterMaterialCourses-container")[0];

    utilities.filterStyle(label, this.value);

});

$("#userFilterMaterialCourses").change(function () {

    let label = $("#select2-userFilterMaterialCourses-container")[0];

    utilities.filterStyle(label, this.value);

});

$("#activeFilterMaterialCourses").change(function () {

    let label = $("#select2-activeFilterMaterialCourses-container")[0];

    utilities.filterStyle(label, this.value);

});



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

$('#material-destroy').submit(async (e) => {
    e.preventDefault()
    let buttonDelete = $('#material-delete-btn');
    const material = buttonDelete[0].dataset.materialSlug;


    try {
        const {value} = await utilities.toastAlertDelete("Θέλετε να διαγράψετε αυτό το μάθημα ")
        if (value) {
            const res = await axios.post(`/dashboard/materials/delete/${material}`, {_method: 'DELETE'})
            utilities.toastAlert('success', "Διεγράφη")
            window.location = `http://127.0.0.1:8000/dashboard/materials`;
        }

    } catch (e) {
        console.log(e)
        utilities.toastAlert('error', "Παρουσιάστηκε κάποιο πρόβλημα")
    }


});


$(".tab-link").on("show.bs.tab", function(event) {

    event.preventDefault();
    Swal.fire(
        'Προσοχή',
        '<p>Θα πρέπει να αποθηκεύσετε </p>για να συνεχίσετε!',
        'info'
    );

})

//! BULK ACTIOON  materialCourseDatatable
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
                addCouseModal.ajax.reload()
                materialCourseDatatable.ajax.reload()

            }
        }
    } catch (e) {
        console.log(e)
        utilities.toastAlert('error', "Παρουσιάστηκε κάποιο πρόβλημα")
    }
}


//! BULK ACTIOON  addCouseModal
//!============================================================
function checkeBoxesEventListenerModal() {

    let minorCheckboxes = $(".remainings-checkbox");
    let mainCheckbox = $("#all-remainings-checkbox")[0];
    let bulkBtn = $("#add-remaingings-btn")[0];


    minorCheckboxes.unbind();

    minorCheckboxes.change(function () {
        utilities.mainCheckboxSwitcher(mainCheckbox, minorCheckboxes, bulkBtn)
    })

}

$("#all-remainings-checkbox").change(function () {
    let minorCheckboxes = $(".remainings-checkbox");
    let bulkBtn = $("#add-remaingings-btn")[0];

    utilities.minorCheckboxSwitcher(this, minorCheckboxes, bulkBtn);

})

const addCourse = ()=>{
    $(".js-add-courses").click(function(){
        addCourseAxios(this.findParent(2).dataset.courseId,materialId)
    })
}

const addCourseAxios = async(courseId,materialId)=>{
    try {
        const {status} = await axios.post("/materials/add-course/", {
            courseId,
            materialId

        })
        if (status == 200) {
            utilities.toastAlert("success", `1 course προστέθηκε`)
            addCouseModal.ajax.reload()
            materialCourseDatatable.ajax.reload()

        }
    }
    catch (e) {
        console.log(e)
        utilities.toastAlert('error', "Παρουσιάστηκε κάποιο πρόβλημα")
    }
}

const selectMultipleCheckboxUpdate = () => {
    $('#add-remaingings-btn').unbind();
    $("#add-remaingings-btn").click(function () {
        let checkboxes = $(".remainings-checkbox:checked")

        let ids = [];


        for (let i = 0; i < checkboxes.length; i++) {
            ids.push(checkboxes[i].dataset.courseId);
        }


        axiosMultipleUpdate(ids, materialId)

    })
}

const axiosMultipleUpdate = async (courseIds, materialId) => {


    try {
        const {status} = await axios.post('/materials/add-course/multiple', {
            courseIds,
            materialId
        })

        if (status == 200) {
            utilities.toastAlert("success", `${courseIds.length} courses προστέθηκαν`)
            addCouseModal.ajax.reload()
            materialCourseDatatable.ajax.reload()

        }
    } catch (e) {
        console.log(e)
        utilities.toastAlert('error', "Παρουσιάστηκε κάποιο πρόβλημα")
    }
}



//! DROPOZONE
//!============================================================


$(".js-add-image").on("click", utilities.imageHandler);

$("#change-cover-btn").on("click", function () {


    $("#gallery-content")[0].dataset.action = "cover";

    $("#gallery-modal").modal('show');
})




let dropzoneGalery = new Dropzone("#cover-dropzone", {
    thumbnailWidth: 80,
    thumbnailHeight: 80,
    previewTemplate: $("#uploadPreviewTemplate").html(),
    url: `/materials/cover/upload`,
    params: {materialId},
    maxFiles:10,
    acceptedFiles: 'image/*',
    headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function (file, response) {


        axios.get(`/media/images`, {})
            .then((res) => {
                // console.log(res.data)
                let gallery = $("#gallery-content")[0]
                gallery.innerHTML = res.data;


                let pagination = gallery.getElementsByClassName("js-gallery-page-btn");
                let addBtns = gallery.getElementsByClassName("js-add-image");

                for ( let i = 0; i < addBtns.length; i++ ) {
                    addBtns[i].removeEventListener("click", utilities.imageHandler);
                    addBtns[i].addEventListener("click", utilities.imageHandler);
                }

            })
        this.removeAllFiles();
        $("#upload-tab-btn").removeClass("active")
        $("#upload").removeClass("active")
        $("#media-library-tab-btn").addClass("active")
        $("#media-library").addClass("show active")




    },


})
dropzoneGalery.autoDiscover = false;
