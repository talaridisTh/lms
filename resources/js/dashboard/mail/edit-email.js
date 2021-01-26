import utilities from '../main';

$("#history-datatable").DataTable({
	language: utilities.tableLocale,
	fnInitComplete: function( oSettings, json ) {
		let lenthSelection = $("select[name='history-datatable_length']");

		lenthSelection.select2({
			minimumResultsForSearch: -1,
		});
	},
	drawCallback:function(){
		$(".dataTables_paginate > .pagination").addClass("pagination-rounded");

	}
});

$("#delete-btn").on("click", function() {
	Swal.fire({
		title: 'Διαγραφή;',
		text: "Η ενέργεια θα είναι μη αναστρέψιμη",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#ff5b5b',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ναι, διαγραφή!',
		cancelButtonText: 'Άκυρο'
	}).then((result) => {
		if (result.isConfirmed) {
			$("#delete-mail-form")[0].submit()
		}
	})
});