@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
	<style>
		.table td {
			padding: 1.30rem 0.95rem 0.3rem;
		}
		.table > tbody > tr:hover {
			background-color: #3a444e;
		}

		.option::after, .option::before {
			display: none !important;
		}
	</style>
@endsection

@section('content')
    <div class="container" style="max-width:1370px">
        <div class="row mb-2">
            <div class="col-sm-4">
                <a href="javascript:void(0);" class="btn btn-primary mb-2"><i class="mdi mdi-plus-circle mr-2"></i>
					Δημιουργία χρηστη
				</a>
            </div>
            <div class="col-sm-8">
                <div class="text-sm-right">
                    {{--                    <button type="button" class="btn btn-success mb-2 mr-1"><i class="mdi mdi-settings"></i></button>--}}
                    {{--                    <button type="button" class="btn btn-light mb-2 mr-1">Import</button>--}}
                    <button type="button" class="btn btn-secondary mb-2">Export</button>
                </div>
            </div>
        </div>

        <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
            <thead>
            <tr>
                <th class="text-left option">Επιλογή</th>
                <th class="text-left">Όνομα</th>
                <th class="text-left">Ενεργό</th>
                <th class="text-left">Τελ. Ενημέρωση</th>
                <th class="text-left">Ημ. Δημιουργίας</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($courses as $course)
                <tr>
                    <td class="pl-4">
						<div class="icheck-primary d-inline">
							<input type="checkbox" id="{{ $course['slug'] }}">
							<label for="{{ $course['slug'] }}"></label>
						  </div>
					</td>
                    <td>{{ $course['name'] }}</td>
                    <td class="">
						<input type="checkbox" id="{{ $course['slug'] }}-toggle-checkbox" {{ $course['active'] == 0 ? '' : 'checked' }} data-switch="bool"/>
						<label for="{{ $course['slug'] }}-toggle-checkbox" data-on-label="On" data-off-label="Off"></label>{{-- {{ $course['active'] }} --}}
					</td>
                    <td>{{ $course['updated_at'] }}</td>
                    <td>{{ $course['created_at']}}</td>
                </tr>
            @endforeach

            </tbody>
            <tfoot>
            	<tr>
					<th class="text-left">Επιλογή</th>
            	    <th class="text-left">Όνομα</th>
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
	$("#scroll-horizontal-datatable").DataTable({
		scrollX:!0,
		"columnDefs": [
			{ "width": "5%", "targets": 0 }
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
			$(".dataTables_paginate > .pagination").addClass("pagination-rounded")
		}
	})
</script>
@endsection
