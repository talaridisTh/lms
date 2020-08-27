@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

	<div id="new-course-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="new-course-modalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header modal-colored-header bg-primary">
					<h4 class="modal-title" id="new-course-modalLabel">Νέο Course</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body table-cnt">
					<form id="new-course-form" class="px-3" action="courses/store" method="POST" enctype="multipart/form-data" autocomplete="off">
						
						@csrf
						
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="title">Τίτλος</label>
									<input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="Εισάγετε τίτλο...">
									@error('title')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="subtitle">Υπότιτλος</label>
									<input type="text" class="form-control @error('subtitle') is-invalid @enderror" id="subtitle" name="subtitle" value="{{ old('subtitle') }}" placeholder="Εισάγετε υπότιτλο...">
									@error('subtitle')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="course-cover">Cover</label>
									<div class="input-group">
										<div class="custom-file">
											<input id="cover-input" type="file" class="custom-file-input @error('cover') is-invalid @enderror" name="cover">
											<label id="cover-input-label" class="custom-file-label file-search-label-primary" for="cover-input">"Εισάγετε αρχείο"</label>
										</div>
										@error('cover')
											<span class="invalid-feedback d-block" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="example-select">Κατάσταση</label>
									<select class="form-control @error('active') is-invalid @enderror" id="active" name="active">
										<option value="1" {{ old('active') == 1 ? "selected" : "" }}>Ενεργό</option>
										<option value="0" {{ old('active') == 0 ? "selected" : "" }}>Ανενεργό</option>
									</select>
									@error('active')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="summary">Σύνοψη</label>
							<textarea class="form-control @error('summary') is-invalid @enderror" id="summary" name="summary" rows="4" placeholder="Σύνοψη Course...">{{ old('summary') }}</textarea>
							@error('summary')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>

						<div class="form-group">
							<label for="description">Περιγραφή</label>
							<textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Περιγραφή Course...">{{ old('description') }}</textarea>
							@error('description')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button id="submit-form-btn" class="btn btn-primary"><i class="mdi mdi-content-save mr-1"></i>Αποθήκευση</button>
					<button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div class="container table-cnt" style="max-width:1370px">
		<div class="row mb-2">
			<div class="col-sm-4"></div>
			<div class="col-sm-8">
				<div class="text-sm-right">
					<a href="courses/create" class="btn btn-primary mb-2" data-toggle="modal" data-target="#new-course-modal"><i class="mdi mdi-plus-circle mr-2"></i>
						Νέο Course
					</a>
					<div class="btn-group mb-2">
						<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Επιλογές</button>
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
					<th class="text-center">Επιλογή</th>
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
		$('#new-course-modal').modal('show')
	</script>
@endif

@endsection
