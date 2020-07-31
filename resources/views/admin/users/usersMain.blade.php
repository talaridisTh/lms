@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />	
@endsection

@section('content')
	<h1>Users</h1>

	<table id="scroll-horizontal-datatable" class="table w-100 nowrap">
		<thead>
			<tr>
				<th class="text-center">Όνομα</th>
				<th class="text-center">Επώνυμο</th>
				<th class="text-center">Email</th>
				<th class="text-center">Ενεργός</th>
				<th class="text-center">Ημ. Εγγραφής</th>
			</tr>
		</thead>
		<tbody>

			@foreach ($users as $user)
				<tr>
					<td>{{ $user['first_name'] }}</td>
					<td>{{ $user['last_name'] }}</td>
					<td>{{ $user['email'] }}</td>
					<td>{{ $user['active'] }}</td>
					<td>{{ $user['created_at'] }}</td>
				</tr>
			@endforeach
			
		</tbody>
		<tfoot>
			<tr>
				<th class="text-center">Όνομα</th>
				<th class="text-center">Επώνυμο</th>
				<th class="text-center">Email</th>
				<th class="text-center">Ενεργός</th>
				<th class="text-center">Ημ. Εγγραφής</th>
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