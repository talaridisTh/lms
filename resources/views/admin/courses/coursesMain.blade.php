@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>

	<style>

		.content-page {
			overflow: initial;
		}
		.wrapper {
			overflow: initial;
		}
		.sticky-btns {
			position: sticky;
			bottom: 0px;
			z-index: 100;
			background-color: #343a40 !important;
		}

	</style>
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
							<li class="breadcrumb-item active">Courses</li>
						</ol>
					</div>
					<h4 class="page-title">Courses</h4>
				</div>
			</div>
		</div>
	</div>
	<!-- end page title -->

	<!-- Modal -->
	<div class="modal fade" id="clone-course-modal" tabindex="-1" role="dialog" aria-labelledby="clone-course-modalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header modal-colored-header bg-primary">
					<h5 class="modal-title" id="clone-course-modalLabel">Αντιγραφή Course</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="clone-form" action="/dashboard/courses/clone" method="POST">

						@csrf

						<div class="form-group">
							<label for="clone-title">Τίτλος</label>
							<input type="text" class="form-control @error('cloneTitle') is-invalid @enderror" id="clone-title" name="title" value="{{ old('title') }}" placeholder="Εισάγετε τίτλο...">
							@error('cloneTitle')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>
						<input id="cloning-course-id" class="form-control" type="text" name="id" value="{{ old('id') }}" hidden>
					</form>
				</div>
				<div class="modal-footer">
					<button form="clone-form" type="submit" class="btn btn-primary">
						<i class="mdi mdi-content-save mr-1"></i>
						Δημιουργία
					</button>
					<button type="button" class="btn btn-light" data-dismiss="modal">Έξοδος</button>
				</div>
			</div>
		</div>
	</div>

	<div class="container table-cnt content-width">

		<div class="row mb-2 sticky-btns">
			<div class="col-sm-4"></div>
			<div class="col-sm-8">

				<div class="text-sm-right">
					@can('create', App\Models\Course::class)
						<a href="/dashboard/courses/create" class="btn btn-primary mb-2">
							<i class="mdi mdi-plus-circle mr-2"></i>
							Νέο Course
						</a>
					@endcan
					<div class="btn-group mb-2">
						<button id="course-bulk-action-btn" disabled type="button"
							class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
							aria-haspopup="true" aria-expanded="false">
							Επιλογές (0)
						</button>
						<div class="dropdown-menu dropdown-menu-animated dropdown-menu-right py-0">
							<div class="btn-group dropleft dropleft-hover w-100">
								<button type="button" class="dropdown-item dropdown-toggle py-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Αλλαγή κατάστασης
								</button>
								<div class="dropdown-menu py-0">
									<a class="dropdown-item js-bulk-status cursor-pointer py-2" data-status="1">Ενεργοποιήση</a>
									<div class="dropdown-divider my-0"></div>
									<a class="dropdown-item js-bulk-status cursor-pointer py-2" data-status="0">Απενεργοποίηση</a>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>

		<table id="courses-datatable" class="table w-100 nowrap center-not-second js-remove-table-classes">
			<thead>
				<tr>
					<th class="text-center">
						<div class='icheck-primary d-inline'>
							<input type='checkbox' id='select-all-courses' autocomplete='off'>
							<label for='select-all-courses'></label>
						</div>
					</th>
					<th class="text-center">Τίτλος</th>
					<th class="text-center">Κατάσταση</th>
					<th class="text-center">Topics</th>
					<th class="text-center">Έκδοση</th>
					<th class="text-center">Ημ. Δημιουργίας</th>
					<th class="text-center">Ημ. Δημοσίευσης</th>
					<th class="text-center">Ενεργό</th>
				</tr>
			</thead>
			<tbody class="tables-hover-effect"></tbody>
			<tfoot>
				<tr>
					<th class="text-center">Επιλογή</th>
					<th class="text-center">Τίτλος</th>
					<th class="text-center">Κατάσταση</th>
					<th class="text-center">Topics</th>
					<th class="text-center">Έκδοση</th>
					<th class="text-center">Ημ. Δημιουργίας</th>
					<th class="text-center">Ημ. Δημοσίευσης</th>
					<th class="text-center">Ενεργό</th>
				</tr>
			</tfoot>
		</table>

	</div>


	<select id="topic-filter" class="ml-1 select2 form-control">
		<option value="" selected>Όλα τα Topic</option>
		@foreach ($topics as $topic)
			<option value="{{ $topic->title }}">{{ $topic->title }}</option>
		@endforeach
	</select>

@endsection

@section('scripts')
<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>

<script src="{{ mix('js/dashboard/courses/coursesMain.js') }}"></script>

@error('cloneTitle')
	<script>
		$('#clone-course-modal').modal('show')
	</script>
@enderror

@error('title')
	<script>
		$('#new-course-modal').modal('show');
	</script>
@enderror

@endsection
