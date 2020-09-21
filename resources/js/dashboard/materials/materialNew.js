import utilities from '../main';
import Dropzone from "../../../plugins/dropzone/js/dropzone";
import * as FilePond from "filepond";
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import 'filepond/dist/filepond.min.css';

let materialId = $("#material-course-table")[0].dataset.materialId;
const baseUrl = window.location.origin;

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
        {data: "created_at", name: "created_at", visible: false},

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
        $("#scroll-horizontal-datatable_filter").addClass("d-flex justify-content-around");
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
$R.add('plugin', 'mediaLibrary', {
    translations: {
        en: {
            "mediaLibrary": "Media Library"
        }
    },
    init: function (app) {
        this.app = app;
        this.lang = app.lang;
        this.toolbar = app.toolbar;
    },
    start: function () {
        var buttonData = {
            title: this.lang.get("mediaLibrary"),
            icon: "<i class='mdi mdi-book-open-page-variant'></i>",
            api: "plugin.mediaLibrary.toggle"
        };

        var $button = this.toolbar.addButton("mediaLibrary", buttonData);
    },
    toggle: function () {
        $('#gallery-content')[0].dataset.action = "summary"
        $('#gallery-modal').modal('show')
    }
});
$R("#summary", {
    buttons: [
        'html', 'undo', 'redo', 'format',
        'bold', 'underline', 'italic', 'deleted',
        'sup', 'sub', 'lists', 'file', 'link', 'image'
    ],
    buttonsAddBefore: {before: 'image', buttons: ['mediaLibrary']},
    style: false,
    plugins: ["mediaLibrary", 'alignment'],
    minHeight: '150px',
    imageResizable: true,
    imagePosition: {
        "left": "image-left",
        "right": "image-right",
        "center": "image-center text-center"
    },
    imageFloatMargin: '20px',
    imageUpload: "/media/upload-images",
    // imageData: {
    // 	// id: courseId,
    // 	// namespace: "App\\Course"
    // },
    callbacks: {
        upload: {
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            }
        }
    }
});

$R.add('plugin', 'mediaLibrary', {
    translations: {
        en: {
            "mediaLibrary": "Media Library"
        }
    },
    init: function (app) {
        this.app = app;
        this.lang = app.lang;
        this.toolbar = app.toolbar;
    },
    start: function () {
        var buttonData = {
            title: this.lang.get("mediaLibrary"),
            icon: "<i class='mdi mdi-book-open-page-variant'></i>",
            api: "plugin.mediaLibrary.toggle"
        };

        var $button = this.toolbar.addButton("mediaLibrary", buttonData);
    },
    toggle: function () {
        $('#gallery-content')[0].dataset.action = "description-material"
        $('#gallery-modal').modal('show')
    }
});
$R("#description-material", {
    buttons: [
        'html', 'undo', 'redo', 'format',
        'bold', 'underline', 'italic', 'deleted',
        'sup', 'sub', 'lists', 'file', 'link', 'image'
    ],
    buttonsAddBefore: {before: 'image', buttons: ['mediaLibrary']},
    style: false,
    plugins: ["mediaLibrary", 'alignment'],
    minHeight: '150px',
    imageResizable: true,
    imagePosition: {
        "left": "image-left",
        "right": "image-right",
        "center": "image-center text-center"
    },
    imageFloatMargin: '20px',
    imageUpload: "/media/upload-images",
    // imageData: {
    // 	// id: courseId,
    // 	// namespace: "App\\Course"
    // },
    callbacks: {
        upload: {
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            }
        }
    }
});

$R.add('plugin', 'mediaLibrary', {
    translations: {
        en: {
            "mediaLibrary": "Media Library"
        }
    },
    init: function (app) {
        this.app = app;
        this.lang = app.lang;
        this.toolbar = app.toolbar;
    },
    start: function () {
        var buttonData = {
            title: this.lang.get("mediaLibrary"),
            icon: "<i class='mdi mdi-book-open-page-variant'></i>",
            api: "plugin.mediaLibrary.toggle"
        };

        var $button = this.toolbar.addButton("mediaLibrary", buttonData);
    },
    toggle: function () {
        $('#gallery-content')[0].dataset.action = "content-material"
        $('#gallery-modal').modal('show')
    }
});
$R("#content-material", {
    buttons: [
        'html', 'undo', 'redo', 'format',
        'bold', 'underline', 'italic', 'deleted',
        'sup', 'sub', 'lists', 'file', 'link', 'image'
    ],
    buttonsAddBefore: {before: 'image', buttons: ['mediaLibrary']},
    style: false,
    plugins: ["mediaLibrary", 'alignment'],
    minHeight: '150px',
    imageResizable: true,
    imagePosition: {
        "left": "image-left",
        "right": "image-right",
        "center": "image-center text-center"
    },
    imageFloatMargin: '20px',
    imageUpload: "/media/upload-images",
    // imageData: {
    // 	// id: courseId,
    // 	// namespace: "App\\Course"
    // },
    callbacks: {
        upload: {
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            }
        }
    }
});



//! METHOD FORM HIDEN
//!============================================================

//! utilities.changeInputHidden('#coursesMaterial','#coursesMaterialHidden')

//! GLOBAL FUNCTION Filter
//!============================================================
utilities.filterButton('#topicFilterMaterialCourses', 1, materialCourseDatatable, "#material-course-table_length label")
utilities.filterButton('#activeFilterMaterialCourses', 7, materialCourseDatatable, "#material-course-table_length label")
utilities.filterButton('#userFilterMaterialCourses', 2, materialCourseDatatable, "#material-course-table_length label")
utilities.filterButton('#versionFilterMaterial', 3, addCouseModal, "#remaining-course-material-table_length label")

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

$("#versionFilterMaterial").select2({
    minimumResultsForSearch: -1,
});

//datatable
$("#topicFilterMaterialCourses").select2({});

$(".custom-select").select2({minimumResultsForSearch: -1,});

$("#activeFilterMaterialCourses").select2({minimumResultsForSearch: -1,});

$("#userFilterMaterialCourses").select2({});

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
$("#update-btn").click(function () {
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


$(".tab-link").on("show.bs.tab", function (event) {

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


        axiosMultipleDelete(ids, materialId)

    })
}

const axiosMultipleDelete = async (courseId, materialId) => {

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

const addCourse = () => {
    $(".js-add-courses").click(function () {
        addCourseAxios(this.findParent(2).dataset.courseId, materialId)
    })
}

const addCourseAxios = async (courseId, materialId) => {
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
    } catch (e) {
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

let dropzone = document.getElementById("file-pond");

FilePond.registerPlugin(FilePondPluginFileValidateType);
const pond = FilePond.create(dropzone);

FilePond.setOptions({
    name: 'file[]',
    server: {
        url: baseUrl,
        process: {
            url: '/media/upload-images',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
            },
            onload: function (data) {

            },

        },

    },
    onprocessfiles: function (data) {

        utilities.paginationRequest(1, "");
        $("#upload-tab-btn").removeClass("active")
        $("#upload").removeClass("active")
        $("#media-library-tab-btn").addClass("active")
        $("#media-library").addClass("show active")

    },

    onupdatefiles: function (file) {
        utilities.toastAlert("success", `${file.length} εικόνα ανέβηκαν`)

    },
    allowMultiple: true,
    allowRemove: false,
    allowRevert: false,
    acceptedFileTypes: ['image/png', 'image/jpeg'],

});
