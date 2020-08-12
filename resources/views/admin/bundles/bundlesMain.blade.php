@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

<div id="primary-header-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="primary-header-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header modal-colored-header bg-primary">
				<h4 class="modal-title" id="primary-header-modalLabel">Νέο Bundle</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body table-cnt">
				<form class="px-3">
					<div class="form-group">
						<label for="name">Όνομα</label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Δώστε όνομα">
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="course-cover">Cover</label>
								<div class="input-group">
									<div class="custom-file">
										<input type="file" class="custom-file-input" name="cover" id="course-cover">
										<label class="custom-file-label file-search-label-primary" for="course-cover">"Εισάγετε αρχείο"</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="example-select">Κατάσταση</label>
								<select class="form-control" id="active">
									<option value="1">Ενεργό</option>
									<option value="0" selected>Ανενεργό</option>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="description">Περιγραφή</label>
						<textarea class="form-control" id="description" name="description" rows="4" placeholder="Write something..."></textarea>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				{{-- <button id="add-remaingings-btn" type="button" class="btn btn-primary">Προσθήκη Επιλογών</button> --}}
				<button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save mr-1"></i>Αποθήκευση</button>
				<button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<div class="container table-cnt" style="max-width:1370px">
	<div class="row mb-2">
		<div class="col-sm-4">
			{{-- <a href="javascript:void(0);" class="btn btn-danger mb-2"><i class="mdi mdi-plus-circle mr-2"></i> Δημιουργία  χρηστη</a> --}}
		</div>
		<div class="col-sm-8">
			<div class="text-sm-right">
				<a href="courses/create" class="btn btn-secondary mb-2" data-toggle="modal" data-target="#primary-header-modal">
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

	<table id="bundle-table" class="table w-100 nowrap js-remove-table-classes custom-center-table center-not-second">
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
				{ data: "action", name: "action", width: "5%", orderable: false, searchable: false },
				{ data: "name", name: "name", className: "js-link cursor-pointer"},
				{ data: "active", name: "active", width: "5%", searchable: false },
				{ data: "updated_at", name: "updated_at", className: "js-link cursor-pointer"},
				{ data: "created_at", name: "created_at", className: "js-link cursor-pointer"},
			],
			processing: true,
			serverSide: true,
			ajax: {
				url: "/bundles/bundles-datatable",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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
				$(".js-remove-table-classes > thead > tr > th").removeClass("js-link cursor-pointer");

				jsLinkInit();
				activeToggleInit();
			}
		})

		function activeToggleInit() {

			let toggle = $(".js-toggle");

			toggle.change( function() {

				// console.log(this.checked);

				axios.patch( `/bundles/bundles-toggle-active/${this.dataset.bundleId}`, {
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

		function jsLinkInit() {

			$('.js-link').click( function() {
				let bundleId = this.parentElement.dataset.bundleId;

				window.location = `bundle/${bundleId}`;
			});

		}

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