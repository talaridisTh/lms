@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <div class="container table-cnt" style="max-width:1370px">

		<div class="row mb-2">
            <div class="col-sm-4"></div>
            <div class="col-sm-8">
                <div class="text-sm-right">
					<a href="materials/new" class="btn btn-secondary mb-2">
						<i class="mdi mdi-plus-circle mr-2"></i>
						Δημιουργία
					</a>
					<div class="btn-group mb-2">
						<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Επιλογές</button>
						<div class="dropdown-menu">
							<a id="delete-courses-btn" class="dropdown-item" href="#">Διαγραφή</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="#">Προσθήκη σε Course</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="#">Export</a>
						</div>
					</div>
				</div>
            </div>
        </div>

		<table id="materials-datatable" class="table w-100 nowrap  custom-center-table center-not-second js-remove-table-classes">
			<thead>
				<tr>
					<th class="text-center">Επιλογή</th>
					<th class="text-center">Μάθημα</th>
					<th class="text-center">Ενεργό</th>
					<th class="text-center">Τύπος</th>
					<th class="text-center">Τελ. Ανανέωση</th>
					<th class="text-center">Ημ. Δημιουργίας</th>
				</tr>
			</thead>
			<tbody  class="tables-hover-effect"></tbody>
			<tfoot>
				<tr>
					<th class="text-center">Επιλογή</th>
					<th class="text-center">Μάθημα</th>
					<th class="text-center">Ενεργό</th>
					<th class="text-center">Τύπος</th>
					<th class="text-center">Τελ. Ανανέωση</th>
					<th class="text-center">Ημ. Δημιουργίας</th>
				</tr>
			</tfoot>
		</table>
    </div>


@endsection

@section('scripts')
	<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
	<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>

	<script>
		$("#materials-datatable").DataTable({
		order: [1, "asc"],
		processing: true,
		serverSide: true,
		ajax: {
			url: "/materials/materials-datatable",
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			type: "post"
		},
		columns: [
			{ data: "action", name: "action", width: "5%", searchable: false, orderable: false },
			{ data: "name", name: "name", className: "js-link cursor-pointer" },
			{ data: "active", name: "active", width: "5%", searchable: false },
			{ data: "type", name: "type", className: "js-link cursor-pointer" },
			{ data: "updated_at", name: "updated_at",  className: "js-link cursor-pointer" },
			{ data: "created_at", name: "created_at",  className: "js-link cursor-pointer" },
		],
		language:{
			emptyTable: 		"Δεν υπάρχουν εγγραφές",
			info: 				"_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα",
			infoEmpty:      	"0 απο 0 τα 0 αποτελέσματα",
			lengthMenu: 		"_MENU_ Αποτελέσματα ανα σελίδα",
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
			$(".js-remove-table-classes > thead > tr > th").removeClass("js-link cursor-pointer");
			atLinkEventListener();
		}
	})

	function atLinkEventListener() {
		$('.js-link').click( function() {
			let materialId = this.parentElement.dataset.materialId;

			window.location = `material/${materialId}`;
		});
	}
	</script>
@endsection
