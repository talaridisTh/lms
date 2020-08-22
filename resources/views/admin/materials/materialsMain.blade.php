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
					<a href="{{route('material.create')}}" class="btn btn-secondary mb-2">
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

		<table id="materials-datatable" class="table w-100 nowrap custom-center-table center-not-second js-remove-table-classes">
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
	<script src="/assets/js/vendor/dataTables.buttons.min.js"></script>

	<script src="{{ asset('js/dashboard/materials/materialsMain.js') }}"></script>
@endsection
