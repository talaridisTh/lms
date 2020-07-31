@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />	
@endsection

@section('content')
	<h1>Materials</h1>

	<table id="scroll-horizontal-datatable" class="table w-100 nowrap">
		<thead>
			<tr>
				<th class="text-center">Μάθημα</th>
				<th class="text-center">Περιγραφή</th>
				<th class="text-center">Ενεργό</th>
				<th class="text-center">Τύπος</th>
			</tr>
		</thead>
		<tbody>

			@foreach ($materials as $material)
				<tr>
					<td>{{ $material['name'] }}</td>
					<td>{{ $material['small_description'] }}</td>
					<td>{{ $material['active'] }}</td>
					<td>{{ $material['type'] }}</td>
				</tr>
			@endforeach
			
		</tbody>
		<tfoot>
			<tr>
				<th class="text-center">Μάθημα</th>
				<th class="text-center">Περιγραφή</th>
				<th class="text-center">Ενεργό</th>
				<th class="text-center">Τύπος</th>
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