@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
<div class="container table-cnt" style="max-width:1370px">
	<div class="row mb-2">
		<div class="col-sm-4">
			{{-- <a href="javascript:void(0);" class="btn btn-danger mb-2"><i class="mdi mdi-plus-circle mr-2"></i> Δημιουργία  χρηστη</a> --}}
		</div>
		<div class="col-sm-8">
			<div class="text-sm-right">
				<a href="courses/create" class="btn btn-secondary mb-2">
					<i class="mdi mdi-plus-circle mr-2"></i>
					Νέο Bundle
				</a>
				<div class="btn-group mb-2">
					<button type="button" class="btn btn-primary dropdown-toggle" 
						data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Επιλογές
					</button>
					<div class="dropdown-menu">
						<a id="delete-bundles-btn" class="dropdown-item" href="#">Διαγραφή</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#">Export</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<table id="bundle-table" class="table w-100 nowrap custom-center-table center-not-second">
		<thead>
			<tr>
				<th class="text-center option-column">Επιλογή</th>
				<th class="text-center">Ονομασία</th>
				<th class="text-center">Ενεργό</th>
				<th class="text-center">Τελ. Ενημέρωση</th>
				<th class="text-center">Ημ. Δημιουργίας</th>
			</tr>
		</thead>
		<tbody class="tables-hover-effect"></tbody>
		<tfoot>
			<tr>
				<th class="text-center">Επιλογή</th>
				<th class="text-center">Ονομασία</th>
				<th class="text-center">Ενεργό</th>
				<th class="text-center">Τελ. Ενημέρωση</th>
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
		$("#bundle-table").DataTable({
			columns: [
				{ data: "action", name: "action", width: "5%" },
				{ data: "name", name: "name" },
				{ data: "active", name: "active", width: "5%" },
				{ data: "updated_at", name: "updated_at" },
				{ data: "created_at", name: "created_at" },
			],
			processing: true,
			serverSide: true,
			ajax: {
				url: "/api/bundles/bundles-datatable",
				type: "post"
			},
			language: {
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

				activeToggleInit();
			}
		})

		function activeToggleInit() {

			let toggle = $(".js-toggle");

			toggle.change( function() {

				// console.log(this.checked);

				axios.patch( `/api/bundles/bundles-toggle-active/${this.dataset.bundleId}`, {
					state: this.checked ? 1 : 0
				})
				.then( (res) => {
					let icon = this.checked ? "success" : "info";
					let message = this.checked ? "Ενεργοποιήθηκε!" : "Απενεργοποιήθηκε";
					toastAlert( icon, message );
				})
				.catch( (err) => {
					toastAlert( "error", "Παρουσιάστηκε κάποιο πρόβλημα ..." );
				})
			});
		}

		$('.js-link').click( function() {
			let bundleId = this.parentElement.dataset.bundleId;

			window.location = `bundle/${bundleId}`;
		});

		function toastAlert( icon, message ) {
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
	</script>
@endsection