import utilities from '../main';
import * as FilePond from "filepond";
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import 'filepond/dist/filepond.min.css';

let materialId = $("#material-course-table")[0].dataset.materialId;
let materialSlug = $("#material-title")[0].dataset.materialSlug;
const namespace = "App\\Material";
const baseUrl = window.location.origin;

//!##################################################
//!					EventListeners					#
//!##################################################

$(".js-editors-toggle").on("change", function() {
	let editorToggles = $(".js-editors-toggle");
	let field = {};

	for ( let i = 0; i < editorToggles.length; i++) {

		field[`${editorToggles[i].dataset.field}`] = editorToggles[i].checked ? 1 : 0;
	}

	let fields = JSON.stringify(field);

	axios.patch(`/material/${materialSlug}/toggle-editors`, {
		fields
	})
	.then( res => {
		let icon = this.checked ? "success" : "info";
		let message = this.checked ? "Ενεργοποιήθηκε" : "Απενεργοποιήθηκε";

		utilities.toastAlert( icon, message );
	})
	.catch( err => {
		console.log(err);
		utilities.toastAlert( "error", "Παρουσιάστηκε κάποιο πρόβλημα ..." );
	})

})

$("#remove-cover-btn").on("click", function() {
	
	axios.patch( "/media/remove-cover", {
		namespace,
		id: materialId
	})
	.then( res => {

		let cnt = this.parentElement;

		$("#cover-image").addClass("d-none");
		$("#cover-status").removeClass("d-none");
		$("#change-cover-btn").text("Προσθήκη")

		cnt.classList.remove("d-flex");
		cnt.classList.add("d-none");

	})
	.catch( err => {
		console.log(err);
	})
});

$("#remove-all-files-btn").on("click", function() {

	let fileRow = $(".js-file-row")
	let ids = [];

	for (let i = 0; i < fileRow.length; i++) {
		ids.push(fileRow[i].dataset.fileId);
	}

	Swal.fire({
		icon: 'info',
		title: 'Προσοχή!',
		text: 'Αφαίρεση όλων των αρχείων;',
		showCancelButton: true,
		confirmButtonText: `Ναι, αφαίρεση!`,
		cancelButtonText: `Ακύρωση`,
	}).then((result) => {
		if (result.isConfirmed) {
			removeFiles(ids);
		}
	})
})

$(".js-audio-btn").on("click", audioPlayerHandler);

$(".js-remove-file").on("click", function() {
	removeFiles( [this.dataset.fileId] );
})

$("#remove-all-images-btn").on("click", function() {

	let images = $(".js-active-image")
	let ids = [];

	for (let i = 0; i < images.length; i++) {
		ids.push(images[i].dataset.fileId);
	}

	Swal.fire({
		icon: 'info',
		title: 'Προσοχή!',
		text: 'Αφαίρεση όλων των εικόνων;',
		showCancelButton: true,
		confirmButtonText: `Ναι, αφαίρεση!`,
		cancelButtonText: `Ακύρωση`,
	  }).then((result) => {
		if (result.isConfirmed) {
			utilities.removeImages(ids);
			utilities.toastAlert("info", "Οι εικόνες αφαιρέθηκαν");
			this.classList.add("d-none");
		}
	  })

});

$(".js-remove-image").on("click", utilities.removeImageHandler)

$("#add-gallery-images-btn").on("click", function() {
	$("#gallery-content")[0].dataset.type = "gallery";

	$("#gallery-modal").modal('show');
})

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
    },
    columns: [
        {data: "checkbox", name: "checkbox", searchable: false, orderable: false, className: "text-left"},
        {data: "title", name: "title"},
        {data: "curator", name: "curator"},
        {data: "updated_at", name: "updated_at"},
        {data: "created_at", name: "created_at", visible: false},

    ],
    language: utilities.tableLocale,
    drawCallback: function () {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        $(".js-remove-table-classes > thead > tr > th").removeClass("js-link cursor-pointer js-updated-at");

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
    },
    columns: [
        {data: "checkbox", name: "checkbox", searchable: false, orderable: false, className: "text-left"},
        {data: "title", name: "title"},
        {data: "curator", name: "curator"},
        {data: "version", name: "version"},
        {data: "action", name: "action"},

    ],
    language: utilities.tableLocale,
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

const remainingFilesTable = $("#remaining-files-datatable").DataTable({
    order: [ 0, "asc" ],
    processing: true,
    serverSide: true,
    ajax: {
        url: '/media/remaining-files',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "post",
        data: {
			namespace,
			id: materialId
        }
    },
    columns: [
        {data: "original_name", name: "original_name"},
        {data: "ext", name: "ext", className:"text-center"},
        {data: "size", name: "size", className:"text-center"},
        {data: "action", className:"text-center", searchable: false, orderable: false},
    ],
    language: utilities.tableLocale,
    drawCallback: function () {
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");

		addFilesBtnInit();
    }
})

function addFilesBtnInit() {
	let btns = $(".js-add-file-btn");

	btns.on("click", function() {
		addMaterialFiles( [this.dataset.fileId] );
	})
}

function addMaterialFiles(ids) {

	axios.post("/media/add-files", {
		namespace, 
		modelId: materialId,
		ids
	})
	.then( res => {
		let container = $("#files-cnt");
		container.html(res.data);

		let audioBtns = $(".js-audio-btn");
		audioBtns.on("click", audioPlayerHandler);

		let removeBtns = container.find(".js-remove-file");
		removeBtns.on("click", function() {
			removeFiles( [this.dataset.fileId] );
		});

		$("#remove-all-files-btn").removeClass("d-none");

		$("#remainings-files-modal").modal("hide");
		remainingFilesTable.ajax.reload(null, false);
	})
	.catch( err => {
		console.log(err);
	})

}

function removeFiles(ids) {

	axios.post("/media/remove-files", {
		namespace, 
		modelId: materialId,
		ids
	})
	.then( res => {
		let container = $("#files-cnt");
		container.html(res.data);

		let audioBtns = $(".js-audio-btn");
		audioBtns.on("click", audioPlayerHandler);

		let btns = container.find(".js-remove-file");
		btns.on("click", function() {
			removeFiles( [this.dataset.fileId] );
		});

		if ( btns.length == 0 ) {
			$("#remove-all-files-btn").addClass("d-none");
		}
		else {
			$("#remove-all-files-btn").removeClass("d-none");
		}

		remainingFilesTable.ajax.reload(null, false);
		utilities.toastAlert("info", "Τα αρχεία αφαιρέθηκαν");
	})
	.catch( err => {
		console.log(err);
		utilities.toastAlert( 'error', "Παρουσιάστηκε κάποιο πρόβλημα ..." );
	})
}

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
        $('#gallery-content')[0].dataset.editorId = "#summary"
        $('#gallery-content')[0].dataset.type = "redactor"
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
		$('#gallery-content')[0].dataset.editorId = "#description-material"
        $('#gallery-content')[0].dataset.type = "redactor"
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
		$('#gallery-content')[0].dataset.editorId = "#content-material"
        $('#gallery-content')[0].dataset.type = "redactor"
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


    $("#gallery-content")[0].dataset.type = "cover";

    $("#gallery-modal").modal('show');
})

FilePond.registerPlugin(FilePondPluginFileValidateType);
FilePond.setOptions({
    name: 'file[]',
    allowMultiple: true,
});

let dropzone = document.getElementById("file-pond");
const pond = FilePond.create(dropzone, {
    server: {
        url: baseUrl,
        process: {
            url: '/media/upload-images',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
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
	acceptedFileTypes: ['image/png', 'image/jpeg'],
});

const materialImgUpload = $("#material-img-upload")[0];
const materialPond = FilePond.create(materialImgUpload, {
    server: {
        url: baseUrl,
        process: {
            url: '/materials/gallery-upload',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
			},

			onload: function(data) {

				let container = $("#gallery-cnt")
				container.html(data);

				let removeBtns = container.find(".js-remove-image");
				removeBtns.on("click", utilities.removeImageHandler);

				$("#remove-all-images-btn").removeClass("d-none");
				utilities.paginationRequest( 1, "");

			},
			ondata: function(formData) {
				formData.append("id", materialId);
				return formData
			}
		},
	},
    onprocessfile: function (error, data) {

		// setTimeout(function() {
		// 	materialPond.removeFile(data.file);
		// }, 2000);

		$("#gallery-cnt").removeClass("d-none");
		$("#active-gallery-loading").addClass("d-none");
	},
	onprocessfileabort: function() {
		$("#gallery-cnt").removeClass("d-none");
		$("#active-gallery-loading").addClass("d-none");
	},
	onprocessfiles: function() {

		// let instance = materialPond.getFiles()

		// for (let i = 0; i < instance.length; i++ ) {

		// 	setTimeout(function() {
		// 		materialPond.removeFile(instance[i].file);

		// 	}, i * 1000);

		// }

	},
	oninitfile: function(file) {
		$("#gallery-cnt").addClass("d-none");
		$("#active-gallery-loading").removeClass("d-none");
	},
    acceptedFileTypes: ['image/png', 'image/jpeg'],
});

const materialFileUpload = $("#material-file-upload")[0];
const materialFilePond = FilePond.create(materialFileUpload, {
	name: "file",
    server: {
        url: baseUrl,
        process: {
            url: '/media/files-upload',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
			},

			onload: function(data) {

				let container = $("#files-cnt")
				container.html(data)

				let removeBtns = container.find(".js-remove-file");
				removeBtns.on("click", function() {
					removeFiles( [this.dataset.fileId] );
				});

				let audioPlayerBtns = container.find(".js-audio-btn");
				audioPlayerBtns.on("click", audioPlayerHandler)

				$("#remove-all-files-btn").removeClass("d-none");
				remainingFilesTable.ajax.reload(null, false);

			},
			ondata: function(formData) {
				formData.append("namespace", "App\\Material");
				formData.append("id", materialId);
				return formData
			}
		},
	},
    onprocessfile: function (error, data) {

		// setTimeout(function() {
		// 	materialFilePond.removeFile(data.file);
		// }, 2000);

		$("#files-cnt").removeClass("d-none");
		$("#active-files-loading").addClass("d-none");
	},
	onprocessfileabort: function() {
		$("#files-cnt").removeClass("d-none");
		$("#active-files-loading").addClass("d-none");
	},
	onprocessfiles: function() {

		// let instance = materialFilePond.getFiles()

		// for (let i = 0; i < instance.length; i++ ) {

		// 	setTimeout(function() {
		// 		materialFilePond.removeFile(instance[i].file);

		// 	}, i * 1000);

		// }

	},
	oninitfile: function(file) {
		$("#files-cnt").addClass("d-none");
		$("#active-files-loading").removeClass("d-none");
	},
    acceptedFileTypes: [
		"application/octet-stream", "application/x-zip-compressed", "application/pdf",
		"application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
		"application/vnd.openxmlformats-officedocument.wordprocessingml.template", "application/vnd.ms-word.document.macroEnabled.12",
		"application/vnd.ms-word.template.macroEnabled.12", "application/vnd.ms-excel", "application/vnd.ms-excel", "application/vnd.ms-excel",
		"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/vnd.openxmlformats-officedocument.spreadsheetml.template",
		"application/vnd.ms-excel.sheet.macroEnabled.12", "application/vnd.ms-excel.template.macroEnabled.12",
		"application/vnd.ms-excel.addin.macroEnabled.12", "application/vnd.ms-excel.sheet.binary.macroEnabled.12",
		"application/vnd.ms-powerpoint", "application/vnd.openxmlformats-officedocument.presentationml.presentation",
		"application/vnd.openxmlformats-officedocument.presentationml.template", "application/vnd.openxmlformats-officedocument.presentationml.slideshow",
		"application/vnd.ms-powerpoint.addin.macroEnabled.12", "application/vnd.ms-powerpoint.presentation.macroEnabled.12",
		"application/vnd.ms-powerpoint.template.macroEnabled.12", "application/vnd.ms-powerpoint.slideshow.macroEnabled.12",
		"application/vnd.ms-access", "audio/mpeg", "application/vnd.oasis.opendocument.presentation",
		"application/vnd.oasis.opendocument.spreadsheet", "application/vnd.oasis.opendocument.text",
		"application/rtf", "application/vnd.oasis.opendocument.graphics"
	],
});

function audioPlayerHandler() {

	let cnt = this.parentElement;
	let audio = cnt.getElementsByClassName("js-audio")[0];

	if ( this.dataset.audioStatus == "paused" ) {
		this.classList.remove("mdi-play-circle-outline");
		this.classList.add("mdi-pause-circle-outline");
		this.dataset.audioStatus = "playing";

		audio.currentTime = 0;
		audio.play();
	}
	else {
		this.classList.remove("mdi-pause-circle-outline");
		this.classList.add("mdi-play-circle-outline");
		this.dataset.audioStatus = "paused";

		audio.pause();
	}
}

let dragArea = $("#gallery-cnt")[0];
dragula( [dragArea], {

})
.on("drop", function() {
	let images = $(".js-active-image");
	let imagesPriority = [];
	images.splice( -1, 1 );

	for ( let i = 0; i < images.length; i++) {
		imagesPriority.push(images[i].dataset.imageId)
	}

	axios.patch("/material/images-sort", {
		materialId, imagesPriority
	})
	.then( res => {

	})
	.catch( err => {

	})
})
