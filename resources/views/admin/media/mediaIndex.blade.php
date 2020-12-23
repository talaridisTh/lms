
@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
	<style>

		.modal-content {
			display: block;
			width: auto;
		}

		#image-light-room img {
			width: 100%;
			height: auto;
		}

	</style>
@endsection


@section('content')

	<!-- Full Page Drag n Drop Overlay -->
	<div id="page-drag-drop-overlay" class="d-flex flex-column justify-content-center align-items-center">
		<div id="icons-cnt" class="mb-0">
			<i class="left-5 font-40 position-absolute mdi mdi-folder-zip-outline"></i>
			<i class="left-25 font-70 position-absolute mdi mdi-file-pdf-outline"></i>
			<i class="absolute-centered font-100 position-absolute mdi mdi-language-html5"></i>
			<i class="right-25 font-70 position-absolute mdi mdi-file-document-outline"></i>
			<i class="right-5 font-40 position-absolute mdi mdi-music"></i>
		</div>
		<p class="h1 mt-0">Drop to upload your files</p>
	</div>
	<!-- Upload Modal -->
	<div class="modal fade" id="upload-file-modal" tabindex="-1" role="dialog" aria-labelledby="upload-file-modalLabel" aria-hidden="true">
		<div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header modal-colored-header bg-primary">
					<h5 id="upload-file-modalLabel" class="modal-title">Upload</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input id="file-pond" class="js-filepond-file-dragging mb-0" type="file" name="file" />
					<p class="text-right mb-2 ">
						<small>
							<strong>
								Το πεδίο δέχεται αρχεία: .doc, .odt, .rtf, .xls, .odp, .zip, .rar., .mp3, .pdf, .ev3, .sb3, .html, .jpg, .png.
							</strong>
						</small>
					</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">Έξοδος</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="image-light-room" tabindex="-1" role="dialog" aria-labelledby="image-light-roomLabel" aria-hidden="true">
		<div class="modal-dialog  modal-xl modal-dialog-centered justify-content-center" role="document">
			<div class="modal-content">
				<img src="" alt="" draggable="false">
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="edit-file-modal" tabindex="-1" role="dialog" aria-labelledby="edit-file-modalLabel" aria-hidden="true">
		<div class="modal-dialog  modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header modal-colored-header bg-primary">
					<h5 class="modal-title" id="edit-file-modalLabel">Επεξεργασία Αρχείου</h5>
					<button type="button" class="close" data-dismiss="modal"
						aria-label="Close" draggable="false">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="store-file-details-form">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="title-input">Τίτλος</label>
								<input id="title-input" type="text" class="is-empty form-control" name="title" placeholder="Εισάγετε τίτλο..." />
									<span class="invalid-feedback" role="alert">
										<strong>Το πεδίο είναι υποχρεωτικό.</strong>
									</span>
							</div>

							<div class="form-group col-md-6">
								<label for="caption-input">Caption</label>
								<input id="caption-input" type="text" class="form-control" name="caption" value="{{ old('caption') }}" placeholder="Εισάγετε caption..." />
							</div>
						</div>

						<div class="form-group">
							<label for="subtitle-input">Υπότιτλος</label>
							<input id="subtitle-input" type="text" class="form-control" name="subtitle" value="{{ old('subtitle') }}" placeholder="Εισάγετε υπότιτλο..." />
						</div>

						<div class="form-group">
							<label for="file-description-area">Περιγραφή</label>
							<textarea id="file-description-area" class="is-empty form-control" rows="3" name="description" placeholder="Εισάγετε Περιγραφή"></textarea>
							<span class="invalid-feedback" role="alert">
								<strong>Το πεδίο είναι υποχρεωτικό.</strong>
							</span>
						</div>

						<input id="file-id" class="form-control" type="text" name="id" value="{{ old('id') }}" hidden />
					</form>

					<div class="form-group">
						<div class="d-flex justify-content-between">
							<label for="public-url">Public Url</label>
							<input id="url-toggle" class="js-url-toggle" type="checkbox" data-switch="success">
							<label class="mb-0" for="url-toggle" data-on-label="On" data-off-label="Off"></label>
						</div>
						<div class="input-group">
							<input id="public-url" readonly style="background-color: #404954;" type="text" class="form-control">
							<div class="input-group-append">
								<button id="copy-url-button" class="btn btn-primary" disabled style="padding: 0 0.7rem; line-height: 0.5;"
									data-toggle="tooltip" data-placement="bottom" title="Copy to clipboard">
									<i class="font-24 mdi mdi-clipboard-text-multiple-outline"></i>
								</button>
							</div>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button id="save-details-btn" class="btn btn-primary">
						<i class="mdi mdi-content-save mr-1"></i>
						Αποθήκευση
					</button>
					<button type="button" class="btn btn-light" data-dismiss="modal">Έξοδος</button>
				</div>
			</div>
		</div>
	</div>

	<div class="container table-cnt content-width mb-5">
		<!-- start page title -->
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="/" class="custom-link-primary" draggable="false">Home</a></li>
							<li class="breadcrumb-item"><a href="/dashboard" class="custom-link-primary" draggable="false">Dashboard</a></li>
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
				<div class="text-sm-right sticky-btns mb-2" draggable="false">
					<a href="#" class="btn btn-primary user-select-auto" data-toggle="modal"
						draggable="false" data-target="#upload-file-modal">
						<i class="mdi mdi-plus-circle mr-2" draggable="false"></i>
						Upload
					</a>
				</div>
			</div>
		</div><!-- ./Button Row -->

		<div id="list-view" class="tab-pane show active table-cnt">
			<table id="file-manager-datatable" class="table w-100 nowrap center-not-second js-remove-table-classes">
				<thead>
					<tr>
						<th class="text-center"></th>
						<th class="text-center">Όνομα</th>
						<th class="text-center">Τύπος</th>
						<th class="text-center">Μέγεθος</th>
						<th class="text-center">Ημ. Δημιουργίας</th>
						<th class="text-center">Details Title</th>
					</tr>
				</thead>
				<tbody class="tables-hover-effect"></tbody>
				<tfoot>
					<tr>
						<th class="text-center"></th>
						<th class="text-center">Όνομα</th>
						<th class="text-center">Τύπος</th>
						<th class="text-center">Μέγεθος</th>
						<th class="text-center">Ημ. Δημιουργίας</th>
						<th class="text-center">Details Title</th>
					</tr>
				</tfoot>
			</table>
		</div>

	</div>

	<select id="ext-table-filter" class="ml-1 select2 form-control">
		<option value="" selected>Όλοι οι Τύποι</option>

		@foreach ( $extensions as $extension )
			<option value="{{ $extension->ext }}">{{ $extension->ext }}</option>
		@endforeach
	</select>

@endsection

@section('scripts')
	<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
	<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>

	<script src="{{ mix('js/dashboard/fileManager/fileManager.js') }}"></script>
@endsection
