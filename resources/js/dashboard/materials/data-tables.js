import utilities from '../main';

let materialId = $("#material-course-table")[0].dataset.materialId;

const pickerConfig = {
	singleDatePicker: true,
	drops: "auto",
    opens: "center",
	timePicker: true,
	autoUpdateInput: false,
	timePicker24Hour: true,
	cancelButtonClasses: "btn-secondary",
	locale: {
		format: "DD-MM-YYYY H:mm",
		cancelLabel: "Cancel"
    },
}

function datetime(date) {
	const temp = date.split(" ");

	return {
		day: temp[0],
		time: temp[1]
	}
}

function publishCoverUpdate(row, date, status) {
	let dateElm = row.getElementsByClassName("js-date")[0];
	let timeElm = row.getElementsByClassName("js-time")[0];
	let inputElm = row.getElementsByClassName("js-publish-picker")[0];
	let badge = row.getElementsByClassName("js-badge")[0];
	let day = date.day
	let time = date.time;
	let now = new Date();

	date = new Date( `${day} ${time}` );

	if ( status == 1 ) {
		if ( now > date ) {
			badge.classList.remove("badge-outline-primary", "badge-outline-danger");
			badge.classList.add("badge-outline-success");
			badge.textContent = "Published";
		}
		else {
			badge.classList.remove("badge-outline-success", "badge-outline-danger");
			badge.classList.add("badge-outline-primary");
			badge.textContent = "Scheduled";
		}
	}
	else {
		badge.classList.remove("badge-outline-primary", "badge-outline-success");
		badge.classList.add("badge-outline-danger");
		badge.textContent = "Draft";
	}
	day = day.split("-").reverse().join("-");
	dateElm.textContent = day;
	timeElm.textContent = time;
	inputElm.value = `${day} ${time}`;
}

function publishApplyHandler(ev, picker) {
	const date = picker.startDate.format('YYYY-MM-DD H:mm');
	const courseId = this.dataset.courseId;

	axios.patch(`/course-ajax/${courseId}/edit-publish`, {
		date: date
	})
	.then( res => {
		const row = this.findParent(2)
		const date = datetime(res.data.publish);

		publishCoverUpdate(row, date, res.data.status);
	})
	.catch( err => {
		console.log(err);
		utilities.toastAlert("error", "Κάποιο σφάλμα παρουσιάστηκε...")
	})
}

function publishHideHandler(cover, dateInput) {
	setTimeout(() => {
		cover.classList.remove("d-none");
		dateInput.classList.add("d-none");
		
		$(dateInput).data('daterangepicker').remove();
	}, 50);
}

function publishHandler() {
	const cover = this;
	const td = this.parentElement;
	const dateInput = td.getElementsByClassName("js-publish-picker")[0];

	this.classList.add("d-none");
	dateInput.classList.remove("d-none");

	$(dateInput).daterangepicker(pickerConfig);
	$(dateInput).on("apply.daterangepicker", publishApplyHandler);
	$(dateInput).on("hide.daterangepicker", publishHideHandler.bind(this, cover, dateInput));
	dateInput.focus();
}

function deleteBtnHandler() {

	const courseId = this.dataset.courseId;

	axiosMultipleDelete([courseId], materialId);
}

function startDate( input ) {

	let dateInput = input;

	if ( !dateInput || dateInput.value == "" ) {
		return "";
	}

	let dateInputValue = dateInput.value.split(" - ");
	let firstDate = dateInputValue[0].split("/").reverse().join("-");

	return firstDate;
}

function endDate( input ) {

	let dateInput = input;

	if ( !dateInput || dateInput.value == "" ) {
		return "";
	}

	let dateInputValue = dateInput.value.split(" - ");
	let secondDate = dateInputValue[1].split("/").reverse().join("-");

	return secondDate;
}

function createDateElm() {

	let input = document.createElement("input");

	input.classList.add("form-control", "date", "d-inline-block", "ml-1");
	input.id = "course-date-range";
	input.dataset.toggle = "date-picker";
	input.dataset.cancelClass = "btn-secondary";
	input.style.height = "31.96px";
	input.style.width = "195px";
	input.placeholder = "Επιλέξτε ημερομηνίες...";

	return input;
}

function toggleStatus() {

	$('.js-toggle').on('change', function() {

		const courseId = this.dataset.courseId

		axios.patch(`/course-ajax/${courseId}/status`, {
			status: this.checked
		})
		.then( (res) => {
			let row = this.findParent(2);
			let dateElm = row.getElementsByClassName("js-date")[0];
			let timeElm = row.getElementsByClassName("js-time")[0];
			let inputElm = row.getElementsByClassName("js-publish-picker")[0];
			let badge = row.getElementsByClassName("js-badge")[0];
			let date = res.data.date.split("-").reverse().join("-");
			let time = res.data.time;
			let now = new Date();

			date = new Date( `${date} ${time}` );

			if ( this.checked ) {
				if ( now > date ) {
					badge.classList.remove("badge-outline-dark", "badge-outline-danger");
					badge.classList.add("badge-outline-success");
					badge.textContent = "Published";
				}
				else {
					badge.classList.remove("badge-outline-primary", "badge-outline-danger");
					badge.classList.add("badge-outline-primary");
					badge.textContent = "Scheduled";
				}
			}
			else {
				badge.classList.remove("badge-outline-primary", "badge-outline-dark");
				badge.classList.add("badge-outline-danger");
				badge.textContent = "Draft";
			}

			dateElm.textContent = res.data.date;
			timeElm.textContent = res.data.time;
			inputElm.value = `${res.data.date} ${res.data.time}`;

			let icon = this.checked ? "success" : "info";
			let message = this.checked ? "Ενεργοποιήθηκε" : "Απενεργοποιήθηκε";

			utilities.toastAlert( icon, message );

		})
		.catch( (err) => {
			console.log(err);
			utilities.toastAlert( "error", "Παρουσιάστηκε κάποιο πρόβλημα ..." );

		});
	});
}

function checkeBoxesEventListener() {

    let minorCheckboxes = $(".js-course-inside-material");
    let mainCheckbox = $("#select-all-courses")[0];
    let bulkBtn = $("#course-indside-material-bulk")[0];


    minorCheckboxes.unbind();

    minorCheckboxes.change(function () {
        utilities.mainCheckboxSwitcher(mainCheckbox, minorCheckboxes, bulkBtn)
    })

}

function checkeBoxesEventListenerModal() {

    let minorCheckboxes = $(".remainings-checkbox");
    let mainCheckbox = $("#all-remainings-checkbox")[0];
    let bulkBtn = $("#add-remaingings-btn")[0];


    minorCheckboxes.unbind();

    minorCheckboxes.change(function () {
        utilities.mainCheckboxSwitcher(mainCheckbox, minorCheckboxes, bulkBtn)
    })

}

function addCourseAxios(courseIds, materialId) {

	axios.post("/materials/add-course", {
        courseIds, materialId
	})
	.then ( res => {
		let message = courseIds.length === 1
			? "1 Course προστέθηκε" : `${courseIds.length} Courses προστέθηκαν`;
		utilities.toastAlert("success", message);
		addCouseModal.ajax.reload();
		materialCourseDatatable.ajax.reload();
	})
    .catch ( err => {
        console.log(err);
        utilities.toastAlert('error', "Κάποιο σφάλμα παρουσιάστηκε...");
	})
}

function addCourse() {
    $(".js-add-courses").on("click", function () {
        addCourseAxios( [this.findParent(2).dataset.courseId], materialId )
    })
}

async function axiosMultipleDelete (courseId, materialId) {

    try {

		const {isConfirmed} = await utilities.removeAlert(`Θέλετε να αφαιρέσετε το υλικό απο ${courseId.length} course;`);
		
		if ( ! isConfirmed ) return;
		
        await axios.delete("/materials/multiple/course/delete", {
            data: {
                courseId,
                materialId,
            }
        });

        addCouseModal.ajax.reload(false, null);
        materialCourseDatatable.ajax.reload(false, null);
        
    } catch (e) {
        console.log(e)
        utilities.toastAlert('error', "Κάποιο σφάλμα παρουσιάστηκε...");
    }
}

const materialCourseDatatable = $("#material-course-table").DataTable({
	order: [[ 1, "desc" ]],
	autoWidth: false,
	columnDefs: [
		{ targets: 0, width: "50px"},
		{ targets: 2, width: "150px"},
		{ targets: 3, width: "250px"},
		{ targets: 4, width: "100px"},
		{ targets: 5, width: "170px"},
	],
	searchDelay: "1000",
    processing: true,
    serverSide: true,
    ajax: {
        url: "/material-datatables/material-courses",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "post",
        data: function( d ) {
			return $.extend( {}, d, {
				materialId: materialId,
				startDate: startDate( $("#course-date-range")[0] ),
				endDate: endDate( $("#course-date-range")[0] ),
			})
		}
    },
    columns: [
        {data: "checkbox", name: "checkbox", searchable: false, orderable: false, className: "text-center align-middle"},
        {data: "title", name: "courses.title"},
        {data: "toggle", name: "status", className: "text-center align-middle" },
        {data: "topics", name: "topics.title", className: "align-middle"},
        {data: "version", name: "version", className: "text-center align-middle" },
        {data: "publish", name: "publish_at", className: "text-center align-middle" },
        {data: "status", name: "status", visible: false},

    ],
    language: utilities.tableLocale,
    drawCallback: function () {
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		$(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
		$(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
        $(".js-remove-table-classes > thead > tr > th").removeClass("js-link cursor-pointer js-updated-at");

        utilities.resetBulk($("#course-indside-material-bulk"), $("#select-all-courses"));
        utilities.resetBulk($("#course-indside-material-bulk"), $(".js-course-inside-material"));
		
		$(".js-publish-cover").on("click", publishHandler);
		$(".js-remove-btn").on("click", deleteBtnHandler);
		
		checkeBoxesEventListener();
		toggleStatus();
    }
});

const addCouseModal = $("#remaining-course-material-table").DataTable({
	order: [[ 1, "desc" ]],
	autoWidth: false,
	columnDefs: [
		{ targets: 0, width: "50px"},
		{ targets: 2, width: "210px"},
		{ targets: 3, width: "100px"},
		{ targets: 4, width: "100px"},
	],
	searchDelay: "1000",
    processing: true,
    serverSide: true,
    ajax: {
        url: '/material-datatables/courses',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "post",
        data: {
            materialId
        }
    },
    columns: [
        {data: "checkbox", name: "checkbox", searchable: false, orderable: false, className: "text-center align-middle"},
        {data: "title", name: "courses.title", className: "align-middle"},
        {data: "topics", name: "topics.title", className: "align-middle"},
        {data: "version", name: "version", className: "text-center align-middle"},
        {data: "action", name: "action", className: "text-center align-middle", searchable: false, orderable: false},

    ],
    language: utilities.tableLocale,
    drawCallback: function () {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        $(".js-remove-table-classes > thead > tr > th").removeClass("js-link cursor-pointer js-updated-at");

        utilities.resetBulk($("#add-remaingings-btn"), $("#all-remainings-checkbox"));
        utilities.resetBulk($("#add-remaingings-btn"), $(".remainings-checkbox"));
        checkeBoxesEventListenerModal();
		addCourse();
		
    }
});

const materialCoursesTopicFilter = document.getElementById("topicFilterMaterialCourses");
const courseTopicsFilter = materialCoursesTopicFilter.cloneNode(true);
courseTopicsFilter.id = "course-topics-filter";

const coursesTableLengthSelect = document.querySelector("#remaining-course-material-table_length > label");
coursesTableLengthSelect.append(courseTopicsFilter);
$("#course-topics-filter").select2({
	minimumResultsForSearch: -1,
});

$("#course-topics-filter").on("change", function() {

	let label = $("#select2-course-topics-filter-container")[0];

	utilities.filterStyle( label, this.value );
	addCouseModal.column(2).search(this.value).draw();
});

utilities.filterButton('#activeFilterMaterialCourses', 6, materialCourseDatatable, "#material-course-table_length label");
utilities.filterButton('#topicFilterMaterialCourses', 3, materialCourseDatatable, "#material-course-table_length label");
// utilities.filterButton('#userFilterMaterialCourses', 2, materialCourseDatatable, "#material-course-table_length label")
utilities.filterButton('#versionFilterMaterial', 3, addCouseModal, "#remaining-course-material-table_length label");

let tablesLengthLabel = $("#material-course-table_length > label")[0];
let courseTypesSelect = utilities.createCourseTypeSelect("course-type-selection");
tablesLengthLabel.append(courseTypesSelect);

$("#course-type-selection").select2({
	minimumResultsForSearch: -1,
});

$("#course-type-selection").on("change", function() {

	let label = $("#select2-course-type-selection-container")[0];
	utilities.filterStyle( label, this.value );

	materialCourseDatatable.column(4).search( this.value ).draw();

});

let searchFieldLabel = $("#material-course-table_filter > label > input")[0];
let dateInput = createDateElm();

dateInput.appendBefore( searchFieldLabel );

let dateRange = $("#course-date-range");

dateRange.daterangepicker( utilities.datePickerConfig );

dateRange.on( "apply.daterangepicker", function(event, picker) {

	let startDate = picker.startDate.format('DD/MM/YYYY');
	let endDate = picker.endDate.format('DD/MM/YYYY');

	this.classList.add("select2-selected");
	this.value = `${ startDate } - ${ endDate }`;

	materialCourseDatatable.ajax.reload();

})

dateRange.on( 'cancel.daterangepicker', function(event, picker) {

	this.classList.remove("select2-selected");
	dateInput.value = "";
	materialCourseDatatable.ajax.reload();
})

$("#versionFilterMaterial").select2({
    minimumResultsForSearch: -1,
});

$("#versionFilterMaterial").on("change", function () {

    let label = $("#select2-versionFilterMaterial-container")[0];

    utilities.filterStyle(label, this.value);

});

//datatable
$("#topicFilterMaterialCourses").select2({});

$(".custom-select").select2({minimumResultsForSearch: -1,});

$("#activeFilterMaterialCourses").select2({minimumResultsForSearch: -1,});


$("#topicFilterMaterialCourses").change(function () {

    let label = $("#select2-topicFilterMaterialCourses-container")[0];

    utilities.filterStyle(label, this.value);

});

$("#activeFilterMaterialCourses").change(function () {

    let label = $("#select2-activeFilterMaterialCourses-container")[0];

    utilities.filterStyle(label, this.value);

});

$("#js-multiple-delete").on("click", function() {
    let checkboxes = $(".js-course-inside-material:checked")
    let materialId = $("#material-course-table")[0].dataset.materialId
	let ids = [];

    for (let i = 0; i < checkboxes.length; i++) {
        ids.push(checkboxes[i].findParent(3).dataset.courseId);
    }

    axiosMultipleDelete(ids, materialId)
});

$("#add-remaingings-btn").on("click", function () {
    let checkboxes = $(".remainings-checkbox:checked")
	let ids = [];

    for (let i = 0; i < checkboxes.length; i++) {
        ids.push(checkboxes[i].dataset.courseId);
    }

    addCourseAxios(ids, materialId)

})