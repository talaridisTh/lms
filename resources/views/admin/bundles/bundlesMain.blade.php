@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
<div class="container" style="max-width:1370px">
	<div class="row mb-2">
		<div class="col-sm-4">
			{{-- <a href="javascript:void(0);" class="btn btn-danger mb-2"><i class="mdi mdi-plus-circle mr-2"></i> Δημιουργία  χρηστη</a> --}}
		</div>
		<div class="col-sm-8">
			<div class="text-sm-right">
					<a href="courses/create" class="btn btn-secondary mb-2"><i class="mdi mdi-plus-circle mr-2"></i>
						Νέο Bundle
					</a>
					<div class="btn-group mb-2">
						<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Επιλογές</button>
						<div class="dropdown-menu">
							<a id="delete-courses-btn" class="dropdown-item" href="#">Διαγραφή</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="#">Προσθήκη σε Bundle</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="#">Export</a>

						</div>
					</div>
			</div>
		</div>
	</div>

	<table id="bundle-table" class="table w-100 nowrap custom-center-table">
		<thead>
			<tr>
				<th class="text-left option-column">Επιλογή</th>
				<th class="text-left">Ονομασία</th>
				<th class="text-left">Ενεργό</th>
				<th class="text-left">Τελ. Ενημέρωση</th>
				<th class="text-left">Ημ. Δημιουργίας</th>
			</tr>
		</thead>
		<tbody class="tables-hover-effect">

			@foreach ($bundles as $bundle)
				<tr>
					<td class="pl-4">
						<div class="icheck-primary d-inline">
							<input class="js-course-checkbox" data-bundle-id="{{ $bundle['id'] }}" data-bundle-name="{{ $bundle['name'] }}" type="checkbox" id="{{ $bundle['slug'] }}" autocomplete="off">
							<label for="{{ $bundle['slug'] }}"></label>
						</div>
					</td>
					<td class="cursor-pointer js-link">{{ $bundle['name'] }}</td>
					<td>
						<input class="js-toggle" data-bundle-id="{{ $bundle['id'] }}" type="checkbox" id="{{ $bundle['slug'] }}-toggle-checkbox" {{ $bundle['active'] == 0 ? '' : 'checked' }} data-switch="bool" autocomplete="off"/>
						<label for="{{ $bundle['slug'] }}-toggle-checkbox" data-on-label="On" data-off-label="Off"></label>	
					</td>
					<td class="cursor-pointer js-link">{{ $bundle['updated_at'] }}</td>
					<td class="cursor-pointer js-link">{{ $bundle['created_at'] }}</td>
				</tr>
			@endforeach
			
		</tbody>
		<tfoot>
			<tr>
				<th class="text-left">Επιλογή</th>
				<th class="text-left">Ονομασία</th>
				<th class="text-left">Ενεργό</th>
				<th class="text-left">Τελ. Ενημέρωση</th>
				<th class="text-left">Ημ. Δημιουργίας</th>
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
			scrollX: !0,
			columnDefs: [
				{ "width": "5%", "targets": 0 }
			],
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
				$(".dataTables_paginate > .pagination").addClass("pagination-rounded")
			}
		})

		$('.js-link').click( function() {
			let bundleId = this.parentElement.dataset.bundleId;

			window.location = `bundle/${bundleId}`;
		});
	</script>
@endsection