
@extends('layouts.dashboard')

@section('css')

@endsection

@section('content')

	<div class="container table-cnt content-width">
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
				<div class="text-sm-right sticky-btns mb-2">
					<a href="#" class="btn btn-primary">
						<i class="mdi mdi-plus-circle mr-2"></i>
						Upload
					</a>
					<button type="button" class="btn btn-dark"><i class="mdi mdi-view-grid-outline"></i></button>
					<button type="button" class="btn btn-dark"><i class="mdi mdi-format-list-bulleted-square"></i></button>
				</div>
			</div>
		</div><!-- ./Button Row -->


	
		<table id="file-manager-datatable" class="table w-100 nowrap center-not-second js-remove-table-classes">
			<thead>
				<tr>
					{{-- <th class="text-center">
						<div class='icheck-primary d-inline'>
							<input type='checkbox' id='select-all-files' autocomplete='off'>
							<label for='select-all-files'></label>
						</div>
					</th> --}}
					<th class="text-center"></th>
					<th class="text-center">Τίτλος</th>
					<th class="text-center">Τύπος</th>
					<th class="text-center">Επέκταση</th>
					<th class="text-center">Μέγεθος</th>
					{{-- <th class="text-center"></th> --}}
				</tr>
			</thead>
			<tbody class="tables-hover-effect"></tbody>
			<tfoot>
				<tr>
					{{-- <th class="text-center"></th> --}}
					<th class="text-center"></th>
					<th class="text-center">Τίτλος</th>
					<th class="text-center">Τύπος</th>
					<th class="text-center">Επέκταση</th>
					<th class="text-center">Μέγεθος</th>
					{{-- <th class="text-center"></th> --}}
				</tr>
			</tfoot>
		</table>
	</div>











@endsection

@section('scripts')
	<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
	<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>

	<script src="{{ mix('js/dashboard/fileManager/fileManager.js') }}"></script>
@endsection

