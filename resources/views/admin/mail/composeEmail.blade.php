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

		#users-datatable_length span.select2:not(:last-child) {
			margin-right: 6px;
		}

		#recipients-datatable_length span.select2:not(:last-child) {
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
							<th class="text-center">Ιδιότητα</th>
							<th class="text-center"></th>
							<th class="text-center">Courses</th>
							<th>Όνομα</th>
							<th>Επώνυμο</th>
						</tr>
					</thead>
					<tbody class="tables-hover-effect"></tbody>
					<tfoot>
						<tr>
							<th class="text-center"></th>
							<th class="text-center">Ονοματεπώνυμο</th>
							<th class="text-center">Ιδιότητα</th>
							<th class="text-center"></th>
							<th class="text-center">Courses</th>
							<th>Όνομα</th>
							<th>Επώνυμο</th>
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
				Αποστολή
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
					Παραλήπτες  <span class="text-danger">*</span>
				</a>
			</li>
		</ul>
		
		<div class="tab-content mb-3">
			<div class="tab-pane show active" id="compose-mail-tab">
				<form id="email-form" action="/dashboard/email" method="POST" autocomplete="off">
			
					@csrf
					
					<input id="recipients-input" type="text" name="recipients" hidden>

					@if (!is_null($mail))
						<input type="text" name="id" value="{{ old("id", $mail->id) }}" hidden>
					@endif

					<div class="form-group mb-3">
						<label for="subject">Θέμα <span class="text-danger">*</span></label>
						<input id="subject" class="form-control" type="text"
							placeholder="Εισάγετε θέμα..." name="subject"
							value="{{ old("subject") != "" ? old("subject") : ( !is_null($mail) ? $mail->subject : "" ) }}"/>

						<span id="subject-error" class="text-danger{{ $errors->has('subject') ? "" : " d-none" }}" role="alert">
							<small><strong>Το πεδίο είναι υποχρεωτικό.</strong></small>
						</span>
					</div>

					<div class="form-group mb-3">
						<label for="editor">Περιεχόμενο <span class="text-danger">*</span></label>
						<textarea class="form-control"
							id="editor" placeholder="Εισάγετε περιεχόμενο..." name="content"
							rows="5">{{ old('content') != "" ? old('content') : ( !is_null($mail) ? $mail->content : "" )}}</textarea>

							<span id="content-error" class="text-danger{{ $errors->has('content') ? "" : " d-none" }}" role="alert">
								<small><strong>Το πεδίο είναι υποχρεωτικό.</strong></small>
							</span>
					</div>
				</form>

				<!-- File Upload -->
				<div class="custom-dropzone" id="my-awesome-dropzone">
					<div class="fallback">
						<input name="file" type="file" multiple />
					</div>
				
					<div class="dz-message needsclick">
						<i class="h1 text-muted dripicons-cloud-upload"></i>
						<h3>Drop files here or click to upload.</h3>
					</div>
				</div>

				<template id="file-preview-template">
					<div class="custom-file-details my-1">
						<div class="d-inline-block">

							<div class="dz-filename mb-1"><span data-dz-name></span></div>
							<div class="d-flex justify-content-between align-items-bottom">

								<div class="dz-size mr-4" data-dz-size></div>
								<a class="js-cancel-btn text-danger" href="javascript:void(0);">Αφαίρεση</a>
							</div>

						</div>
					</div>
				</template>

				<div class="custom-margin-left my-3" id="previews"></div>

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
							<th class="text-center">Ιδιότητα</th>
							<th class="text-center"></th>
							<th class="text-center">Courses</th>
							<th>Όνομα</th>
							<th>Επώνυμο</th>
						</tr>
					</thead>
					<tbody class="tables-hover-effect"></tbody>
					<tfoot>
						<tr>
							<th class="text-center"></th>
							<th class="text-center">Ονοματεπώνυμο</th>
							<th class="text-center">Ιδιότητα</th>
							<th class="text-center"></th>
							<th class="text-center">Courses</th>
							<th>Όνομα</th>
							<th>Επώνυμο</th>
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

@error('recipients')
	<script>
		Swal.fire({
			title: "Προσοχή!",
			text: 'Δεν ορίστηκαν παραλήπτες.',
			icon: 'warning',
			confirmButtonColor: '#536de6',
		});
	</script>
@enderror
	
@endsection