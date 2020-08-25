@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <x-alertMsg :msg="'update'"></x-alertMsg>
    <x-alertMsg :msg="'create'"></x-alertMsg>
    <div class="container table-cnt" style="max-width:1370px">

		<div class="row mb-2">
            <div class="col-sm-4"></div>
            <div class="col-sm-8">
                <div class="text-sm-right">
					<a href="{{route('material.create')}}" class="btn btn-primary mb-2">
						<i class="mdi mdi-plus-circle mr-2"></i>
						Δημιουργία
					</a>
					@include("components.bulkActionMaterial")
				</div>
            </div>
        </div>
        @include("components.filterDatatableMaterial")
		<table id="materials-datatable" class="table w-100 nowrap custom-center-table center-not-second js-remove-table-classes">
			<thead>
				<tr>
                    <th id='all-user-checkbox' class="text-left js-user-checkbox">
                        <i class="h3 mdi mdi-checkbox-marked-outline"></i>
                    </th>
					<th class="text-left">Μάθημα</th>
					<th class="text-left">Ενεργό</th>
					<th class="text-left">Τύπος</th>
					<th class="text-left">Τελ. Ανανέωση</th>
					<th class="text-left">Ημ. Δημιουργίαςhide</th>
					<th class="text-left">Ημ. Δημιουργίας</th>
					<th class="text-left">create</th>
					<th class="text-left">activeHidden</th>
				</tr>
			</thead>
			<tbody  class="tables-hover-effect"></tbody>
			<tfoot>
				<tr>
                    <th id='all-user-checkbox' class="text-left js-user-checkbox">
                        <i class="h3 mdi mdi-checkbox-marked-outline"></i>
                    </th>
                    <th class="text-left">Μάθημα</th>
					<th class="text-left">Ενεργό</th>
					<th class="text-left">Τύπος</th>
					<th class="text-left">Τελ. Ανανέωση</th>
					<th class="text-left">Ημ. Δημιουργίαςhide</th>
                    <th class="text-left">Ημ. Δημιουργίας</th>
                    <th class="text-left">create</th>
                    <th class="text-left">activeHidden</th>
				</tr>
			</tfoot>
		</table>
    </div>


@endsection

@section('scripts')
	<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
	<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>
	<script src="/assets/js/vendor/dataTables.buttons.min.js"></script>
    <x-routes></x-routes>
	<script src="{{ asset('js/dashboard/materials/materialsMain.js') }}"></script>



    <script>


        $(".ragneButton").detach().appendTo('.dataTables_length label')
    </script>
@endsection
