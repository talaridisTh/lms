//! GLOBAL VARIABLES
const bundleId = $("#bundle-courses-list")[0].dataset.bundleId
const totalCourses = $('#total-courses-cnt')[0];
const updatedAt = $("#last-update-cnt")[0];

//! EventListerners

$('#main-active-courses-checkbox').click( function() {
	let checkboxes = $('.js-course-checkbox');
	minorCheckboxSwitcher( this, checkboxes );
});

$('#all-courses-checkbox').change( function() {
	let checkboxes = $('.js-remainings-checkbox');
	minorCheckboxSwitcher( this, checkboxes );
});

$('#add-courses-btn').click( function() {
	let checkboxes = $('.js-remainings-checkbox:checked');
	let ids = [];

	if ( checkboxes.length == 0 ) {
		toastAlert( 'info', "Δεν υπάρχουν επιλεγμένα μαθήματα..." );
		return;
	}
	else {
		for ( let i = 0; i < checkboxes.length; i++) {
			ids.push(checkboxes[i].dataset.courseId);
		}
		postCourseIds( ids );
	}
});

$('#remove-selected-courses-btn').click( function() {
	let checkboxes = $('.js-course-checkbox:checked');
	let ids = [];

	if ( checkboxes.length == 0 ) {
		
		toastAlert( 'info', "Δεν υπάρχουν επιλεγμένα μαθήματα..." );
		return;
	}
	else {
		for ( let i = 0; i < checkboxes.length; i++ ) {
			ids.push( checkboxes[i].dataset.courseId );
		}
		removeCourses(ids);
	}
});

//! EventListerners /end

//! Datatables
const bundleCoursesTable = $("#bundle-courses-list").DataTable({
	order: [1, "asc"],
	processing: true,
	serverSide: true,
	ajax: {
		url: "/bundles/bundle-courses-datatable",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		type: "post",
		data: {
			bundleId: bundleId
		}
	},
	columns: [
		{ data: 'action', name: 'action', orderable: false, width: "5%" },
		{ data: 'name', name: 'name', className: "js-link cursor-pointer" },
		{ data: 'updated_at', name: 'updated_at',  className: "js-link cursor-pointer" },
		{ data: 'created_at', name: 'created_at', className: "js-link cursor-pointer" },
	],
	language:{
		emptyTable: 		"Δεν υπάρχουν εγγραφές",
		info: 				"_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα",
		infoEmpty:      	"0 απο 0 τα 0 αποτελέσματα",
		lengthMenu: 		"Αποτελέσματα ανα σελίδα: _MENU_",
		loadingRecords: 	"Φόρτωση ...",
		processing: 		"Επεξεργασία ...",
		search: 			"Αναζήτηση: ",
		zeroRecords: 		"Δεν βρέθηκαν αποτελέσματα",
		paginate:{
			previous:"<i class='mdi mdi-chevron-left'>",
			next:"<i class='mdi mdi-chevron-right'>"}
	},
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		$(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
		$(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
		$(".js-remove-table-classes > thead > tr > th").removeClass("js-link cursor-pointer");

		jsLinkEventListener();
		activeCoursesCheckboxToggle();
	},
	
});

function activeCoursesCheckboxToggle() {

	let mainCheckbox = $('#main-active-courses-checkbox')[0];
	let minorCheckbox = $('.js-course-checkbox');

	minorCheckbox.unbind();
	minorCheckbox.change( function() {
		mainCheckboxSwitcher(mainCheckbox, minorCheckbox);
	});
}

const remainingCoursesTable = $("#remaining-courses-table").DataTable({
	order: [1, "asc"],
	processing: true,
	serverSide: true,
	ajax: {
		url: "/bundles/remaining-courses-datatable",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		type: "post",
		data: {
			bundleId: bundleId
		}
	},
	columns: [
		{data: 'action', name:'action', orderable: false, searchable: false, className: "text-center"},
		{data: 'name', name: 'name', className: "cursor-default"},
		{data: 'addBtn', name: 'addBtn', orderable: false, searchable: false, className: "text-center"}
	],
	language:{
		emptyTable: 		"Δεν υπάρχουν εγγραφές",
		info: 				"_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα",
		infoEmpty:      	"0 απο 0 τα 0 αποτελέσματα",
		lengthMenu: 		"Αποτελέσματα ανα σελίδα: _MENU_",
		loadingRecords: 	"Φόρτωση ...",
		processing: 		"Επεξεργασία ...",
		search: 			"Αναζήτηση: ",
		zeroRecords: 		"Δεν βρέθηκαν αποτελέσματα",
		paginate:{
			previous:"<i class='mdi mdi-chevron-left'>",
			next:"<i class='mdi mdi-chevron-right'>"}
	},
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		$(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
		$(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
		$(".js-remove-table-classes > thead > tr > th").removeClass("cursor-pointer");
		$(".js-remove-table-classes > tfoot > tr > th").removeClass("cursor-pointer");

		addcourse();
		remainingsCheckboxes();
	},
	
});
//! DataTables /end

//! DataTables function / EventListener

function addcourse() {
	$('.js-add-course-btn').click( function() {

		const courseId = [this.dataset.courseId];

		postCourseIds( courseId );
	});
}

function remainingsCheckboxes() {

	let mainCheckbox = $('#all-courses-checkbox')[0];
	let minorCheckbox = $('.js-remainings-checkbox');

	minorCheckbox.unbind();
	minorCheckbox.change( function() {
		mainCheckboxSwitcher(mainCheckbox, minorCheckbox);
	});
}

function jsLinkEventListener() {

	let links = $(".js-link");

	links.unbind();
	links.click( function() {
				
		let id = this.parentElement.dataset.courseId;

		window.location = `/dashboard/course/${id}`;
	});
}

// DataTables function / EventListener End

function postCourseIds( courseIds ) {
	axios.patch( "/bundles/add-courses", {
		bundleId,
		courseIds
	})
	.then( (res) => {
		let message = courseIds.length == 1 ? "1 προστέθηκε" : `${courseIds.length} προστέθηκαν`;
		toastAlert( 'success', message );
		
		bundleCoursesTable.ajax.reload();
		remainingCoursesTable.ajax.reload();
		totalCourses.textContent = parseInt(totalCourses.textContent) + courseIds.length;
		updatedAt.textContent = "Μόλις τώρα";
	})
	.catch( (err) => {
		toastAlert( 'error', "Παρουσιάστηκε κάποιο πρόβλημα ..." );
	})
}

function removeCourses( courseIds ) {
			
	axios.patch( "/bundles/remove-courses", {
		bundleId,
		courseIds
	})
	.then( (res) => {

		let message = courseIds.length == 1 ? "1 course Αφαιρέθηκε" : `${courseIds.length} courses αφαιρέθηκαν`;
		toastAlert( 'success', message );

		bundleCoursesTable.ajax.reload();
		remainingCoursesTable.ajax.reload();
		totalCourses.textContent = parseInt(totalCourses.textContent) - courseIds.length;
		updatedAt.textContent = "Μόλις τώρα";
	})
	.catch( (err) => {
		toastAlert( 'error', "Παρουσιάστηκε κάποιο πρόβλημα ..." );
	})
}

function toastAlert(icon, message) {
    Swal.fire({
        toast: 'true',
        position: 'top-end',
        icon: icon,
        title: message,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
}

function mainCheckboxSwitcher(main, minor) {

    for (let i = 0; i < minor.length; i++) {
        if (!minor[i].checked) {
            main.checked = false;
            break;
        } else {
            main.checked = true;
        }
    }

}

function minorCheckboxSwitcher(main, minor) {

    if (main.checked) {
        for (let i = 0; i < minor.length; i++) {
            minor[i].checked = true;
        }
    } else {
        for (let i = 0; i < minor.length; i++) {
            minor[i].checked = false;
        }
    }

}