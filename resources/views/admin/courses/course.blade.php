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
	.sticky {
		background-color: #333a3f;
		position: sticky;
		top: 70px;
		z-index: 1010;
	}
</style>
@endsection

@section('content')
	<div class="modal fade" id="add-additions-modal" tabindex="-1" aria-labelledby="add-additions-modalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			  <div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="add-additions-modalLabel">Προσθήκη Υλικού</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row px-3">

						<div class="col-6">
							<div class="card cursor-pointer">
								<div class="card-body card-hover d-flex flex-column align-items-center">
									<i class="mdi mdi-file-document-outline	display-3"></i>
									<h5 class="card-title mt-2">Μάθημα</h5>
								</div>
							</div>
							<div class="card cursor-pointer js-material" data-type="Video">
								<div class="card-body card-hover d-flex flex-column align-items-center">
									<i class="mdi mdi-camcorder	display-3"></i>
									<h5 class="card-title mt-2">Video</h5>
								</div>
							</div>
						</div>
					
						<div class="col-6">
							<div class="card cursor-pointer js-material" data-type="Announcement">
								<div class="card-body card-hover d-flex flex-column align-items-center">
									<i class="mdi mdi-comment-quote-outline display-3"></i>
									<h5 class="card-title mt-2">Ανακοίνωση</h5>
								</div>
							</div>
							<div class="card cursor-pointer js-material" data-type="Link">
								<div class="card-body card-hover d-flex flex-column align-items-center">
									<i class="mdi mdi-link-variant-plus	display-3"></i>
									<h5 class="card-title mt-2">Link</h5>
								</div>
							</div>
						</div>
					</div>
				</div>
				<input id="store-material-id" type="text" value="" hidden>
				<input id="store-material-priority" type="text" value="" hidden>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<div id="add-user-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="add-user-modalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header modal-colored-header bg-primary">
					<h4 class="modal-title" id="add-user-modalLabel">Προσθήκη Χρηστών</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body table-cnt">
					<table id="add-users-list" class="js-table table w-100 nowrap modal-table js-remove-table-classes">
						<thead>
							<tr>
								<th class="text-center">
									<div class='icheck-primary d-inline'>
										<input id='add-user-checkbox' type='checkbox' autocomplete='off'>
										<label for='add-user-checkbox'></label>
									</div>
								</th>
								<th class="text-center">Όνομα</th>
								<th class="text-center">Επώνυμο</th>
								<th class="text-center">Ιδιότητα</th>
								<th class="text-center"></th>
							</tr>
						</thead>
						<tbody class="tables-hover-effect table-text-center table-vertical-align-middle"></tbody>
						<tfoot>
							<tr>
								<th class="text-center"></th>
								<th class="text-center">Όνομα</th>
								<th class="text-center">Επώνυμο</th>
								<th class="text-center">Ιδιότητα</th>
								<th class="text-center"></th>
							</tr>
						</tfoot>
					</table>
				</div>
				<div class="modal-footer">
					<button id="add-multiple-users-btn" type="button"
						class="btn btn-primary" data-text="Προσθήκη Επιλογών"
						data-enabled-color="btn-primary" data-disabled-color="btn-secondary">
						Προσθήκη Επιλογών (0)
					</button>
					<button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div id="add-materials-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="add-materials-modalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header modal-colored-header bg-primary">
					<h4 class="modal-title" id="add-materials-modalLabel">Προσθήκη Υλικού</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body table-cnt">
					<table id="remaining-materials-table" class="js-table table w-100 nowrap modal-table custom-center-table center-not-second js-remove-table-classes">
						<thead>
							<tr>
								<th class="text-center">
									<div class='icheck-primary d-inline'>
										<input class='js-course-checkbox' type='checkbox' id='all-remainings-checkbox' autocomplete='off'>
										<label for='all-remainings-checkbox'></label>
									</div>
								</th>
								<th class="text-center">Τίτλος</th>
								<th class="text-center">Topic</th>
								<th class="text-center">Τύπος</th>
								<th class="text-center"></th>
							</tr>
						</thead>
						<tbody class="tables-hover-effect"></tbody>
						<tfoot>
							<tr>
								<th class="text-center">Επιλογή</th>
								<th class="text-center">Τίτλος</th>
								<th class="text-center">Topic</th>
								<th class="text-center">Τύπος</th>
								<th class="text-center"></th>
							</tr>
						</tfoot>
					</table>
				</div>
				<div class="modal-footer">
					<button id="add-remaingings-btn" 
						data-text="Προσθήκη Επιλογών" data-enabled-color="btn-primary" 
						data-disabled-color="btn-secondary" class="btn btn-secondary" disabled>
						Προσθήκη Επιλογών (0)
					</button>
					<button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div class="wrapper">
		<div class="content">

			<div class="row">
				<div class="col-xl-9 col-lg-7 col-md-12">

					<ul class="nav nav-tabs nav-bordered mb-3">
						<li class="nav-item">
							<a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link active">
								Περιεχόμενο
							</a>
						</li>
						<li class="nav-item">
							<a href="#materials" data-toggle="tab" aria-expanded="true" class="nav-link">
								Υλικό
							</a>
						</li>
						<li class="nav-item">
							<a href="#users" data-toggle="tab" aria-expanded="true" class="nav-link">
								Χρήστες
							</a>
						</li>
					</ul> <!-- end nav-->

					<div class="tab-content">

						<div id="settings" class="tab-pane show active">


							<form id="edit-course-form" action="{{ route('course.update', $course->id) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
								
								@csrf
								@method('PATCH')


								<div class="form-group">
									<label for="title">Τίτλος</label>
									<input id="title" type="text" 
										class="form-control @error('title') is-invalid @enderror" 
										id="title" name="title" 
										value="{{ old('title') != "" ? old('title') : $course['title'] }}" 
										placeholder="Εισάγετε τίτλο...">
									@error('title')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>

								<div class="form-group">
									<label for="subtitle">Υπότιτλος</label>
									<input id="subtitle" type="text" 
										class="form-control @error('subtitle') is-invalid @enderror" 
										name="subtitle" 
										value="{{ old('subtitle') != "" ? old('subtitle') : $course['subtitle'] }}" 
										placeholder="Εισάγετε υπότιτλο...">
									@error('subtitle')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>

								<div class="form-group">
									<label for="summary">Σύνοψη</label>
									<textarea class="form-control @error('summary') is-invalid @enderror" id="summary" name="summary" rows="4" placeholder="Εισάγετε σύνοψη...">{{ old('summary') != "" ? old('summary') : $course['summary'] }}</textarea>
									@error('summary')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>

								<div class="form-group">
									<label for="description">Περιγραφή</label>
									<textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Εισάγετε περιγραφή...">{{ old('description') != "" ? old('description') : $course['description'] }}</textarea>
									@error('description')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</form>
						</div><!-- settings tab-pane -->

						<div id="materials" class="tab-pane table-cnt mb-3">
							<table id="course-materials-list" data-course-id="{{ $course['id'] }}" class="table w-100 nowrap center-not-second js-remove-table-classes js-table">
								<thead>
									<tr>
										<th class="text-center">
											<div class='icheck-primary d-inline'>
												<input type='checkbox' id='all-active-materials-checkbox' autocomplete='off'>
												<label for='all-active-materials-checkbox'></label>
											</div>
										</th>
										<th class="text-center">Τίτλος</th>
										<th class="text-center">Ενεργό</th>
										<th class="text-center">Κατάταξη</th>
										<th class="text-center">Τύπος</th>
										<th class="text-center">Τελ. Ανανέωση</th>
										<th class="text-center">Ημ. Δημιουργίας</th>
									</tr>
								</thead>
								<tbody class="tables-hover-effect"></tbody>
								<tfoot>
									<tr>
										<th class="text-center"></th>
										<th class="text-center">Τίτλος</th>
										<th class="text-center">Ενεργό</th>
										<th class="text-center">Κατάταξη</th>
										<th class="text-center">Τύπος</th>
										<th class="text-center">Τελ. Ανανέωση</th>
										<th class="text-center">Ημ. Δημιουργίας</th>
									</tr>
								</tfoot>
							</table>

							<div class="row mt-3">
								<div class="col-sm-1">
								</div>
								<div class="col-sm-11 d-flex justify-content-end">
									<button id="material-modal-shown-btn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-materials-modal">
										<i class="mdi mdi-plus-circle mr-2"></i>
										Προσθήκη Υλικού
									</button>
									<div class="dropdown ml-2">
										<button id="active-material-bulk" class="btn btn-secondary dropdown-toggle"
											type="button" data-toggle="dropdown" data-text="Επιλογές"
											aria-haspopup="true" aria-expanded="false" disabled>
											Επιλογές (0)
										</button>
										<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
											<a id="remove-selection-btn" class="dropdown-item" href="#">Αφαίρεση επιλογών</a>
										</div>
									</div>
								</div>
							</div>
						</div><!-- materials tab-pane -->

						<div id="users" class="tab-pane table-cnt">
							<table id="active-users-list" class="js-table table w-100 nowrap js-remove-table-classes">
								<thead>
									<tr>
										<th class="text-center">
											<div class='icheck-primary d-inline'>
												<input type='checkbox' id='select-all-active-users' autocomplete='off'>
												<label for='select-all-active-users'></label>
											</div>
										</th>
										<th class="text-center">Όνομα</th>
										<th class="text-center">Επώνυμο</th>
										<th class="text-center">Ιδιότητα</th>
										<th class="text-center"></th>
									</tr>
								</thead>
								<tbody class="tables-hover-effect"></tbody>
								<tfoot>
									<tr>
										<th class="text-center"></th>
										<th class="text-center">Όνομα</th>
										<th class="text-center">Επώνυμο</th>
										<th class="text-center">Ιδιότητα</th>
										<th class="text-center"></th>
									</tr>
								</tfoot>
							</table>



							<div class="row mt-3">
								<div class="col-sm-1">
								</div>
								<div class="col-sm-11 d-flex justify-content-end">
									<button id="material-modal-shown-btn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-user-modal">
										<i class="mdi mdi-account-multiple-plus mr-2"></i>
										Προσθήκη Χρηστών
									</button>
									<div class="dropdown ml-2">
										<button class="btn btn-secondary dropdown-toggle"
											type="button" id="active-users-bulk" data-toggle="dropdown" 
											aria-haspopup="true" aria-expanded="false" disabled>
											Επιλογές (0)
										</button>
										<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
											<a id="remove-selected-users-btn" class="dropdown-item" href="#">Αφαίρεση επιλογών</a>
										</div>
									</div>
								</div>
							</div>
						</div><!-- users tab-pane -->
					
					</div><!-- tab-content -->
				</div>
				<div class="col-xl-3 col-lg-5 col-md-12">

					<div class="sticky pb-3 px-2">
						<button id="update-btn" class="btn btn-primary">Ενημέρωση</button>
						<button id="preview-btn" class="under-development btn btn-warning"><i class="mdi mdi-eye"></i> </button>
						<button id="delete-btn" class="under-development btn btn-danger float-right">Διαγραφή</button>
					</div>

					<div class="card">
						<div class="card-body">
							<hr>
							<div class="d-flex justify-content-between">
								<span><strong>Κατάσταση</strong></span>
								<input type="checkbox" id="active-switch" {{ $course['active'] == 1 ? "checked" : "" }} data-switch="bool"/>
								<label class="mb-0" for="active-switch" data-on-label="On" data-off-label="Off"></label>
							</div>
							<hr>
						</div>
					</div>

					<!-- Cover Preview -->
					<div class="card">
						<div class="card-header">
							<h4 class="card-title mb-0">Cover</h4>

						</div>
						<div class="card-body">
							{{-- <img src='{{ asset("storage/courses/$course->id/cover/$course->cover") }}' class="img-fluid" --}}
							<img src="https://placehold.co/600x400" class="img-fluid"
							alt="profile-image">
						
						</div> <!-- end card-body -->
					</div> <!-- end course info card -->
				
					<!-- Dropzone -->
					<div class="card">
						<div class="card-body">

							<form id="cover-dropzone" action="/" method="post" class="image-dropzone" enctype="multipart/form-data">
								<div class="fallback">
									<input name="file" type="file" multiple />
								</div>

								<div class="dz-message needsclick">
									<i class="h1 text-muted dripicons-cloud-upload"></i>
									<h3>Drop files here or click to upload.</h3>
									<span class="text-muted font-13">(This is just a demo dropzone. Selected files are
										<strong>not</strong> actually uploaded.)</span>
								</div>
							</form>

							<!-- Preview -->
							<div class="dropzone-previews mt-3" id="file-previews"></div>  
						
							<div class="d-none" id="uploadPreviewTemplate">
								<div class="card mt-1 mb-0 shadow-none border">
									<div class="p-2">
										<div class="row align-items-center">
											<div class="col-auto">
												<img data-dz-thumbnail src="#" class="avatar-sm rounded bg-light" alt="">
											</div>
											<div class="col pl-0">
												<a href="javascript:void(0);" class="text-muted font-weight-bold" data-dz-name></a>
												<p class="mb-0" data-dz-size></p>
											</div>
											<div class="col-auto">
												<!-- Button -->
												<a href="" class="btn btn-link btn-lg text-muted" data-dz-remove>
													<i class="dripicons-cross"></i>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div> <!-- end card-body -->
					</div> <!-- end course info card -->


				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>
<script src="/assets/js/vendor/dataTables.buttons.min.js"></script>


<script src="{{ mix('js/dashboard/courses/courseProfile.js') }}"></script>

@endsection