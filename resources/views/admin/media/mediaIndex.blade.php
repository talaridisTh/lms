
@extends('layouts.dashboard')

@section('css')

@endsection

@section('content')

	<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box">
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="/" class="custom-link-primary">Home</a></li>
						<li class="breadcrumb-item"><a href="/dashboard" class="custom-link-primary">Dashboard</a></li>
						<li class="breadcrumb-item active">File Manager</li>
					</ol>
				</div>
				<h4 class="page-title">File Manager</h4>
			</div>
		</div>
	</div>

	<!-- Button Row -->
	<div class="row mb-2">
		<div class="col-sm-4"></div>
		<div class="col-sm-8">
			<div class="text-sm-right sticky-btns">
				<a href="/dashboard/course/" class="btn btn-primary mb-2">
					<i class="mdi mdi-plus-circle mr-2"></i>
					Νέο Course
				</a>
				<div class="btn-group mb-2">
					<button id="course-bulk-action-btn" disabled type="button" 
						class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
						aria-haspopup="true" aria-expanded="false">
						Επιλογές (0)
					</button>
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
	</div><!-- ./Button Row -->



	{{-- <table id="file-manager-datatable" class="table w-100 nowrap center-not-second js-remove-table-classes">
		<thead>
			<tr>
				<th class="text-center">
					<div class='icheck-primary d-inline'>
						<input type='checkbox' id='select-all-files' autocomplete='off'>
						<label for='select-all-files'></label>
					</div>
				</th>
				<th class="text-center"></th>
				<th class="text-center">Τίτλος</th>
				<th class="text-center">Τύπος</th>
				<th class="text-center">Επέκταση</th>
				<th class="text-center">Μέγεθος</th>
				<th class="text-center"></th>
			</tr>
		</thead>
		<tbody class="tables-hover-effect"></tbody>
		<tfoot>
			<tr>
				<th class="text-center"></th>
				<th class="text-center"></th>
				<th class="text-center">Τίτλος</th>
				<th class="text-center">Τύπος</th>
				<th class="text-center">Επέκταση</th>
				<th class="text-center">Μέγεθος</th>
				<th class="text-center"></th>
			</tr>
		</tfoot>
	</table> --}}













@endsection

@section('scripts')
	<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
	<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>

	<script src="{{ mix('js/dashboard/fileManager/fileManager.js') }}"></script>
@endsection

