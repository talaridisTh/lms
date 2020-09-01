@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

	<!-- Modal -->
	<div class="modal fade" id="clone-course-modal" tabindex="-1" role="dialog" aria-labelledby="clone-course-modalLabel" aria-hidden="true">
		<div class="modal-dialog  modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="clone-course-modalLabel">Αντιγραφή Course</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="clone-form" action="courses/clone" method="POST">
						
						@csrf

						<div class="form-group">
							<label for="clone-title">Τίτλος</label>
							<input type="text" class="form-control @error('title') is-invalid @enderror" id="clone-title" name="title" value="{{ old('title') }}" placeholder="Εισάγετε τίτλο...">
							@error('title')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>
						<input id="cloning-course-id" class="form-control" type="text" name="id" value="{{ old('id') }}" hidden>
					</form>
				</div>
				<div class="modal-footer">
					<button form="clone-form" type="submit" class="btn btn-primary">Αποθήκευση</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<div class="container table-cnt" style="max-width:1370px">
		<div class="row mb-2">
			<div class="col-sm-4"></div>
			<div class="col-sm-8">
				<div class="text-sm-right">
					<a href="courses/create" class="btn btn-primary mb-2"{{--  data-toggle="modal" data-target="#new-course-modal --}}"><i class="mdi mdi-plus-circle mr-2"></i>
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
					<th class="text-center">Ενεργό</th>
					<th class="text-center">Εισηγητής</th>
					<th class="text-center">Topics</th>
					<th class="text-center">Τελ. Ενημέρωση</th>
					<th class="text-center">Ημ. Δημιουργίας</th>
				</tr>
			</thead>
			<tbody class="tables-hover-effect"></tbody>
			<tfoot>
				<tr>
					<th class="text-center">Επιλογή</th>
					<th class="text-center">Τίτλος</th>
					<th class="text-center">Ενεργό</th>
					<th class="text-center">Εισηγητής</th>
					<th class="text-center">Topics</th>
					<th class="text-center">Τελ. Ενημέρωση</th>
					<th class="text-center">Ημ. Δημιουργίας</th>
				</tr>
			</tfoot>
		</table>
	</div>

	<select id="topic-filter" class="ml-1 custom-select custom-select-sm form-control form-control-sm">
		<option value="" selected>Όλα τα Topic</option>
		@foreach ($topics as $topic)
			<option value="{{ $topic->id }}">{{ $topic->title }}</option>
		@endforeach
	</select>

@endsection

@section('scripts')
<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>

<script src="{{ mix('js/dashboard/courses/coursesMain.js') }}"></script>

@if ( count($errors) > 0 )
	<script>
		$('#clone-course-modal').modal('show')
	</script>
@endif

@endsection
