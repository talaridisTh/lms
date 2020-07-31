@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <div class="container" style="max-width:1370px">
        <div class="row mb-2">
            <div class="col-sm-4">
                <a href="javascript:void(0);" class="btn btn-danger mb-2"><i class="mdi mdi-plus-circle mr-2"></i> Δημιουργία  χρηστη</a>
            </div>
            <div class="col-sm-8">
                <div class="text-sm-right">
                    {{--                    <button type="button" class="btn btn-success mb-2 mr-1"><i class="mdi mdi-settings"></i></button>--}}
                    {{--                    <button type="button" class="btn btn-light mb-2 mr-1">Import</button>--}}
                    <button type="button" class="btn btn-light mb-2">Export</button>
                </div>
            </div>
        </div>
	<table id="scroll-horizontal-datatable" class="table w-100 nowrap">
		<thead>
			<tr>
				<th class="text-left">Μάθημα</th>
				<th class="text-left">Περιγραφή</th>
				<th class="text-left">Ενεργό</th>
				<th class="text-left">Τύπος</th>
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
				<th class="text-left">Μάθημα</th>
				<th class="text-left">Περιγραφή</th>
				<th class="text-left">Ενεργό</th>
				<th class="text-left">Τύπος</th>
			</tr>
		</tfoot>
	</table>
    </div>


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
