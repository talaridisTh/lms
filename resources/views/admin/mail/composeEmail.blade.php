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
			top: 70px;
			z-index: 100;
			background-color: #343a40 !important;
		}
		.page-title {
			line-height: 55px !important;
		}

		.page-title-box .page-title-right {
			margin-top: 9px !important;
		}
		.redactor-toolbar-wrapper {
			position: sticky;
			top: 70px;
			background: #404954;
			z-index: 1000;
		}

		#users-datatable_length span.select2:nth-child(3) {
			margin-right: 6px;
		}

	</style>
@endsection

@section('content')

<div id="users-table-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="users-table-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-primary">
                <h4 class="modal-title" id="users-table-modalLabel">Χρήστες</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body table-cnt">
                <table id="users-datatable" class="table w-100 modal-table nowrap center-not-second js-remove-table-classes">
					<thead>
						<tr>
							<th class="text-center" style="width: 30px;">
								<div class='icheck-primary d-inline'>
									<input type='checkbox' id='select-all-users' autocomplete='off'>
									<label for='select-all-users'></label>
								</div>
							</th>
							<th class="text-center">Ονοματεπώνυμο</th>
							<th class="text-center min-width-200 w-300px">Courses</th>
							<th class="text-center min-width-200 w-300px">Bundles</th>
							<th class="text-center min-width-200 w-300px">Email</th>
							<th class="text-center min-width-200 w-300px">Ιδιότητα</th>
							<th class="text-center"></th>
						</tr>
					</thead>
					<tbody class="tables-hover-effect"></tbody>
					<tfoot>
						<tr>
							<th class="text-center"></th>
							<th class="text-center">Ονοματεπώνυμο</th>
							<th class="text-center">Courses</th>
							<th class="text-center">Bundles</th>
							<th class="text-center">Email</th>
							<th class="text-center">Ιδιότητα</th>
							<th class="text-center"></th>
						</tr>
					</tfoot>
				</table>
            </div>
            <div class="modal-footer">
				<button id="add-recipients-blk" type="button"
					class="btn btn-secondary" disabled data-text="Προσθήκη Επιλογών"
					data-enabled-color="btn-primary" data-disabled-color="btn-secondary">Προσθήκη Επιλογών (0)</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

	<!-- start page title -->
	<div class="container content-width mt-2">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
					<div class="page-title-right mb-0">
						<ol class="breadcrumb m-0 pb-0">
							<li class="breadcrumb-item"><a href="/" class="custom-link-primary">Home</a></li>
							<li class="breadcrumb-item"><a href="/dashboard" class="custom-link-primary">Dashboard</a></li>
							<li class="breadcrumb-item"><a href="/dashboard/email" class="custom-link-primary">E-Mail</a></li>
							<li class="breadcrumb-item active">Compose</li>
						</ol>
					</div>
					<h4 class="page-title">Compose E-mail</h4>
				</div>
			</div>
		</div>
	</div><!-- end page title -->
	
	
	<div class="container content-width">

		<div class="mt-1 mb-1 text-right">{{-- an figi to value den mporo na kano isset() sto controller --}}
			<button class="js-submit-btn btn btn-danger ml-1" name="button" value="send">
				Send
			</button>
			<button class="js-submit-btn btn btn-secondary" name="button" value="draft">
				Set Draft
			</button>
		</div>

		<ul class="nav nav-tabs nav-bordered mb-3">
			<li class="nav-item">
				<a href="#compose-mail-tab" class="nav-link active" data-toggle="tab" aria-expanded="false">
					Δημιουργία
				</a>
			</li>
			<li class="nav-item">
				<a href="#recipients-tab" class="nav-link" data-toggle="tab" aria-expanded="true">
					Παραλήπτες
				</a>
			</li>
		</ul>
		
		<div class="tab-content">
			<div class="tab-pane show active" id="compose-mail-tab">
				<form id="email-form" action="/dashboard/email" method="POST" autocomplete="off">
			
					@csrf
					
					<input id="recipients-input" type="text" name="recipients" hidden>
		
					<div class="form-group">
						<label for="subject">Θέμα</label>
						<input id="subject" class="form-control" type="text" value="{{ old("subject") }}" placeholder="Εισάγετε θέμα..." name="subject" />
						@error('subject')
							<span class="text-danger" role="alert">
								<small><strong>{{ $message }}</strong></small>
							</span>
						@enderror
					</div>
		
					<div class="form-group">
						<label for="editor">Περιεχόμενο</label>
						<textarea class="form-control @error('content') is-invalid @enderror" id="editor" placeholder="Εισάγετε περιεχόμενο..."
							name="content" rows="5">{{ old('content') }}</textarea>
							@error('content')
								<span class="text-danger" role="alert">
									<small><strong>{{ $message }}</strong></small>
								</span>
							@enderror
					</div>
				</form>
			</div>
			<div class="tab-pane" id="recipients-tab">

				<div class="text-right mb-3">
					<button class="btn btn-primary" data-toggle="modal" data-target="#users-table-modal">
						Προσθήκη
					</button>
					<button id="remove-recipients-btn" class="btn btn-secondary" disabled
						data-enabled-color="btn-secondary" data-disabled-color="btn-secondary" data-text="Αφαίρεση">
						Αφαίρεση (0)
					</button>
				</div>

				<table id="recipients-datatable" class="table w-100 nowrap center-not-second js-remove-table-classes">
					<thead>
						<tr>
							<th class="text-center" style="width: 35px">
								<div class='icheck-primary d-inline'>
									<input type='checkbox' id='select-all-recipients' autocomplete='off'>
									<label for='select-all-recipients'></label>
								</div>
							</th>
							<th class="text-center">Ονοματεπώνυμο</th>
							<th class="text-center min-width-200 w-300px">Courses</th>
							<th class="text-center min-width-200 w-300px">Bundles</th>
							<th class="text-center" style="width: 35px"></th>
						</tr>
					</thead>
					<tbody class="tables-hover-effect"></tbody>
					<tfoot>
						<tr>
							<th class="text-center"></th>
							<th class="text-center">Ονοματεπώνυμο</th>
							<th class="text-center">Courses</th>
							<th class="text-center">Bundles</th>
							<th class="text-center"></th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>

@endsection

@section('scripts')
<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>

<script src="{{ mix("js/dashboard/mail/compose-email.js") }}"></script>

	
@endsection