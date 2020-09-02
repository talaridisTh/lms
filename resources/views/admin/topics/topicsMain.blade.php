@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

	<!-- Modal -->
	<div class="modal fade" id="add-topic-modal" tabindex="-1" role="dialog" aria-labelledby="add-topic-modalLabel" aria-hidden="true">
		<div class="modal-dialog  modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header modal-colored-header bg-primary">
					<h5 class="modal-title" id="add-topic-modalLabel">Προσθήκη Topic</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="add-topic-form" action="topics/store" method="POST">
						
						@csrf

						<div class="form-group">
							<label for="new-title">Τίτλος</label>
							<input type="text" class="form-control @error('title') is-invalid @enderror" id="new-title" name="title" value="{{ old('title') }}" placeholder="Εισάγετε τίτλο...">
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
					<button form="add-topic-form" type="submit" class="btn btn-primary">
						<i class="mdi mdi-content-save mr-1"></i>
						Αποθήκευση
					</button>
					<button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<div class="container table-cnt" style="max-width:1370px">
		<div class="row mb-2">
			<div class="col-sm-4"></div>
			<div class="col-sm-8">
				<div class="text-sm-right">
					<a href="#" class="btn btn-primary mb-2" data-toggle="modal" data-target="#add-topic-modal"><i class="mdi mdi-plus-circle mr-2"></i>
						Νέο Topic
					</a>
					<div class="btn-group mb-2">
						<button id="topic-bulk-action-btn" disabled type="button" 
							class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
							aria-haspopup="true" aria-expanded="false">
							Επιλογές (0)
						</button>
						<div class="dropdown-menu">
							<a id="delete-topics-btn" class="dropdown-item" href="#">Διαγραφή</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<table id="topics-datatable" class="table w-100 nowrap center-not-second js-remove-table-classes">
			<thead>
				<tr>
					<th class="text-center">
						<div class='icheck-primary d-inline'>
							<input type='checkbox' id='select-all-topics' autocomplete='off'>
							<label for='select-all-topics'></label>
						</div>
					</th>
					<th class="text-center">Τίτλος</th>
					<th class="text-center">Τελ. Ενημέρωση</th>
					<th class="text-center">Ημ. Δημιουργίας</th>
				</tr>
			</thead>
			<tbody class="tables-hover-effect"></tbody>
			<tfoot>
				<tr>
					<th class="text-center"></th>
					<th class="text-center">Τίτλος</th>
					<th class="text-center">Τελ. Ενημέρωση</th>
					<th class="text-center">Ημ. Δημιουργίας</th>
				</tr>
			</tfoot>
		</table>
	</div>

@endsection

@section('scripts')
<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>

<script src="{{ mix('js/dashboard/topics/topicsMain.js') }}"></script>

@error('title')
	<script>
		$('#add-topic-modal').modal('show')
	</script>
@enderror

@endsection
