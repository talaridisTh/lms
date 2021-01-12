@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>

	<style>
		.custom-border-bottom {
			border-bottom: 1px solid #515c69;
		}
	</style>
@endsection

@section('content')

	<div class="modal fade" id="view-homework-modal" tabindex="-1" role="dialog"
		aria-labelledby="view-homework-modalLabel" aria-hidden="true"><!-- View Homework Modal @s-->
		<div class="modal-dialog modal-dialog-centered " role="document">
			<div class="modal-content">
				<div id="homework-content" class="modal-body p-0"><!-- Modal-Body @s-->

					<div class="d-flex justify-content-center py-4">
						<div class="spinner-border avatar-md text-primary" role="status"></div>
					</div>

				</div><!-- ./Modal-Body @e-->
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">Έξοδος</button>
				</div>
			</div>
		</div>
	</div><!-- ./View Homework Modal @e-->
	
	<div class="container content-width">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="/" class="custom-link-primary">Home</a></li>
							<li class="breadcrumb-item"><a href="/dashboard" class="custom-link-primary">Dashboard</a></li>
							<li class="breadcrumb-item active">Εργασίες</li>
						</ol>
					</div>
					<h4 class="page-title">Εργασίες</h4>
				</div>
			</div>
		</div>
	</div>

	<table id="homeworks-datatable" class="table w-100 nowrap center-not-second js-remove-table-classes">
		<thead>
			<tr>
				<th class="text-center">
					<div class='icheck-primary d-inline'>
						<input type='checkbox' id='select-all-courses' autocomplete='off'>
						<label for='select-all-courses'></label>
					</div>
				</th>
				<th class="text-center">Μαθητής</th>
				{{-- <th class="text-center">Θέμα</th> --}}
				<th class="text-center">Courses</th>
				<th class="text-center">Ημ. Καταχώρισης</th>
			</tr>
		</thead>
		<tbody class="tables-hover-effect"></tbody>
		<tfoot>
			<tr>
				<th class="text-center"></th>
				<th class="text-center">Μαθητής</th>
				{{-- <th class="text-center">Θέμα</th> --}}
				<th class="text-center">Courses</th>
				<th class="text-center">Ημ. Καταχώρισης</th>
			</tr>
		</tfoot>
	</table>

@endsection

@section('scripts')
<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>

<script src="{{ mix("js/dashboard/homework/homeworkMain.js") }}"></script>

@endsection
