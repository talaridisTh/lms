@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
	<!-- start page title -->
	<div class="container content-width">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="/" class="custom-link-primary">Home</a></li>
							<li class="breadcrumb-item"><a href="/dashboard" class="custom-link-primary">Dashboard</a></li>
							<li class="breadcrumb-item active">Υλικό</li>
						</ol>
					</div>
					<h4 class="page-title">Υλικό</h4>
				</div>
			</div>
		</div>
	</div>
	<!-- end page title -->

    <x-alertMsg :msg="'create'"></x-alertMsg>
    <div class="container table-cnt content-width">

		<div class="row mb-2">
            <div class="col-sm-4"></div>
            <div class="col-sm-8">
                <div class="text-sm-right">
					<a href="/dashboard/create-pdf" class="btn btn-primary mb-2">
						<i class="mdi mdi-plus-circle mr-1"></i>
						Νέο PDF
					</a>
					<a href="/dashboard/materials/create" class="btn btn-primary mb-2">
						<i class="mdi mdi-plus-circle mr-1"></i>
						Νέο μάθημα
					</a>
					@include("components.bulkActionMaterial")
				</div>
            </div>
        </div>
        
		<table id="materials-datatable" class="table w-100 nowrap center-not-second js-remove-table-classes">
			<thead>
				<tr>
                    <th id='all-user-checkbox' class="text-left">
                        <div class='icheck-primary d-inline'>
                            <input type='checkbox' id='select-all-courses' autocomplete='off'>
                            <label for='select-all-courses'></label>
                        </div>
                    </th>
					<th class="text-center">Μάθημα</th>
					<th class="text-center">Ενεργό</th>
					<th class="text-center">Τύπος</th>
					<th class="text-center">Τελ. Ανανέωση</th>
					<th class="text-center">Ημ. Δημιουργίας</th>
					<th class="text-center">create</th>
					<th class="text-center">id</th>
				</tr>
			</thead>
			<tbody  class="tables-hover-effect"></tbody>
			<tfoot>
				<tr>
                    <th id='all-user-checkbox' class="text-left">
                        <div class='icheck-primary d-inline'>
                            <input type='checkbox' id='select-all-courses' autocomplete='off'>
                            <label for='select-all-courses'></label>
                        </div>
                    </th>
                    <th class="text-center">Μάθημα</th>
					<th class="text-center">Ενεργό</th>
					<th class="text-center">Τύπος</th>
					<th class="text-center">Τελ. Ανανέωση</th>
                    <th class="text-center">Ημ. Δημιουργίας</th>
                    <th class="text-center">create</th>
                    <th class="text-center">id</th>

            </tfoot>
		</table>
    </div>

	@include("components.filterDatatableMaterial")
@endsection

@section('scripts')
	<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
	<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>
	<script src="/assets/js/vendor/dataTables.buttons.min.js"></script>

	<script src="{{ mix('js/dashboard/materials/materialsMain.js') }}"></script>
@endsection
