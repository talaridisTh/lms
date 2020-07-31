@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
	<h1>courses</h1>

	<table id="scroll-horizontal-datatable" class="table w-100 nowrap">
		<thead>
			<tr>
				<th class="text-center">Όνομα</th>
				<th class="text-center">Ενεργό</th>
				<th class="text-center">Τελ. Ενημέρωση</th>
				<th class="text-center">Ημ. Δημιουργίας</th>
			</tr>
		</thead>
		<tbody>

			@foreach ($courses as $course)
				<tr>
					<td>{{ $course['name'] }}</td>
					<td>{{ $course['active'] }}</td>
					<td>{{ $course['updated_at'] }}</td>
					<td>{{ $course['created_at']}}</td>
				</tr>
			@endforeach

		</tbody>
		<tfoot>
			<tr>
				<th class="text-center">Όνομα</th>
				<th class="text-center">Ενεργό</th>
				<th class="text-center">Τελ. Ενημέρωση</th>
				<th class="text-center">Ημ. Δημιουργίας</th>
			</tr>
		</tfoot>
	</table>
@endsection

@section('scripts')
<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>

<script>
	$("#scroll-horizontal-datatable").DataTable({
		scrollX:!0,
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
			$(".dataTables_paginate > .pagination").addClass("pagination-rounded")
		}
	})
</script>
@endsection
