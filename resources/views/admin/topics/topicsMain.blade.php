@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
	<link href="/vendor/gpickr/gpickr.min.css" rel="stylesheet" type="text/css"/>

    <style>
		#topics-datatable td:nth-child(3){
			padding-bottom: 0px !important;

		}

		.gpickr {
			width: 100%;
			box-shadow: 0px 0px 0px !important;
			padding: 0.5em 0;
			overflow: initial;
		}


		.pcr-app {
			width: 50% !important;
			background: #464f5b;
		}
		.gpcr-interaction {
			width: 50% !important;
		}

		.pcr-result {
			background: #464f5b !important;
			color: #aab8c5 !important;
			text-align: center !important;
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
							<li class="breadcrumb-item active">Topics</li>
						</ol>
					</div>
					<h4 class="page-title">Topics</h4>
				</div>
			</div>
		</div>
	</div>
	<!-- end page title -->

    {{--color modal--}}
    <div class="modal fade" id="color-modal" tabindex="-1" role="dialog" aria-labelledby="color-modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="color-modal-title">Edit Gradient</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
					<input id="topic-id" type="text" name="id" hidden />
					<input id="topic-gradient" type="text" name="gradient" hidden />

					<div id="select-edit-gradient"></div>

				</div><!-- ./modal body -->

				<div class="modal-footer">
					<button id="save-edit-gradient" class="btn btn-primary">
						<i class="mdi mdi-content-save mr-1"></i>
						Αποθήκευση
					</button>
					<button type="button" class="btn btn-light" data-dismiss="modal">Έξοδος</button>
				</div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

 	<!-- add topic Modal -->
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
					<form id="add-topic-form" action="topics/store" method="POST" autocomplete="min-width:1857px;max-width: 1857px">

						@csrf

						<div class="form-group">
							<label for="new-title">Τίτλος</label>
							<input type="text" class="form-control @error('title') is-invalid @enderror" id="new-title" name="title" value="{{ old('title') }}" placeholder="Εισάγετε τίτλο..." />
							@error('title')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>

						<div class="form-group my-2">
							<div class="d-flex align-items-center">
								<!-- Bool Switch-->
								<label for="new-gradient-checkbox" class="mr-3 mb-0">Gradient: </label>
								<input type="checkbox" id="new-gradient-checkbox" checked data-switch="bool"/>
								<label for="new-gradient-checkbox" class="mb-0" data-on-label="On" data-off-label="Off"></label>

							</div>
						</div>

						<input id="gradient-input" class="form-control" type="text" name="gradient" value="radial-gradient(circle at right, rgba(66, 68, 90, 1) 0%,rgba(32, 182, 221, 1) 100%)" hidden />

					</form>
					<div id="new-topic-gradient"></div>
				</div>
				<div class="modal-footer">
					<button form="add-topic-form" type="submit" class="btn btn-primary">
						<i class="mdi mdi-content-save mr-1"></i>
						Αποθήκευση
					</button>
					<button type="button" class="btn btn-light" data-dismiss="modal">Έξοδος</button>
				</div>
			</div>
		</div>
	</div>

	<div class="container table-cnt content-width">

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
					{{-- <th class="text-center">Τελ. Ενημέρωση</th>
					<th class="text-center">Ημ. Δημιουργίας</th> --}}
                    <th class="text-center">Gradient</th>
				</tr>
			</thead>
			<tbody class="tables-hover-effect"></tbody>
			<tfoot>
				<tr>
					<th class="text-center"></th>
					<th class="text-center">Τίτλος</th>
					{{-- <th class="text-center">Τελ. Ενημέρωση</th>
					<th class="text-center">Ημ. Δημιουργίας</th> --}}
					<th class="text-center">Gradient</th>
				</tr>
			</tfoot>
		</table>
	</div>

@endsection

@section('scripts')
<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>
<script src="/vendor/gpickr/gpickr.min.js"></script>


<script src="{{ mix('js/dashboard/topics/topicsMain.js') }}"></script>

@error('title')
	<script>
		$('#add-topic-modal').modal('show')
	</script>
@enderror

@endsection
