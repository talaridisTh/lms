@extends('layouts.dashboard')

@section('css')
<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
@endsection

@php
	$materialsActive = count( $errors ) > 0 ? "" : "active";
	$settingsActive = count( $errors ) > 0 ? "active" : "";
@endphp

@section('content')
	<div class="modal fade" id="add-material-modal" tabindex="-1" aria-labelledby="add-material-modalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
		  	<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="add-material-modalLabel">Προσθήκη Υλικού</h5>
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
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header modal-colored-header bg-primary">
					<h4 class="modal-title" id="add-user-modalLabel">Προσθήκη Χρηστών</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body table-cnt">
					<table id="add-users-list" class="js-table table w-100 nowrap modal-table custom-center-table center-not-second js-remove-table-classes">
						<thead>
							<tr>
								<th class="select-all w-5">
									<div class='icheck-primary d-inline'>
										<input class='js-course-checkbox' type='checkbox' id='add-user-checkbox' autocomplete='off'>
										<label for='add-user-checkbox'></label>
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
								<th class="text-center">Επιλογή</th>
								<th class="text-center">Όνομα</th>
								<th class="text-center">Επώνυμο</th>
								<th class="text-center">Ιδιότητα</th>
								<th class="text-center"></th>
							</tr>
						</tfoot>
					</table>
				</div>
				<div class="modal-footer">
					<button id="add-multiple-users-btn" type="button" class="btn btn-primary">Προσθήκη Επιλογών</button>
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
								<th class="select-all w-5">
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
	                <button id="add-remaingings-btn" type="button" class="btn btn-primary">Προσθήκη Επιλογών</button>
	                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
	            </div>
	        </div><!-- /.modal-content -->
	    </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div class="row">
		<div class="col-xl-3 col-lg-5">

			<div class="card text-center">
				<div class="card-body">
					{{-- <img src='{{ asset("storage/courses/$course->id/cover/$course->cover") }}' class="img-fluid" --}}
					<img src="https://placehold.co/600x400" class="img-fluid"
					alt="profile-image">
	
					<h4 class="mb-0 mt-2">{{ $course['title'] }}</h4>
					<p class="text-muted font-14">Course</p>
	
					<div class="text-left mt-3">
						<p class="text-muted mb-2 font-13">
							<strong>
								Σύνολο Μαθημάτων :
							</strong>
							<span id="total-lessons" class="ml-2">
								{{ $course->materials->where( 'type', 'Lesson')->count() }}
							</span>
						</p>
						<p class="text-muted mb-2 font-13">
							<strong>
								Σύνολο Extra Υλικού :
							</strong>
							<span id="total-additions" class="ml-2">
								{{ $course->materials->where( 'type', '!=', 'Lesson')->count() }}
							</span>
						</p>
						<p class="text-muted mb-2 font-13">
							<strong>
								Τελευταία Ανανέωση :
							</strong>
							<span id="last-update-cnt" class="ml-2">
								{{ $course['updated_at'] }}
							</span>
						</p>
						<p class="text-muted mb-2 font-13">
							<strong>
								Ημ. Δημιουργίας :
							</strong>
							<span class="ml-2">
								{{ $course['created_at'] }}
							</span>
						</p>
					</div>
	
				</div> <!-- end card-body -->
			</div> <!-- end course info card -->
		</div> <!-- end col-->

		<div class="col-xl-9 col-lg-7">
			<div class="card">
				<div class="card-body">

					<!-- Tab Buttons -->
					<ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
						<li class="nav-item">
						<a href="#materials" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 {{ $materialsActive }}">
								Μαθήματα
							</a>
						</li>
						<li class="nav-item">
							<a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 {{ $settingsActive }}">
								Επεξεργασία
							</a>
						</li>
						<li class="nav-item">
							<a href="#users" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
								Χρήστες
							</a>
						</li>
					</ul><!-- /.End Tab Buttons -->

					<div class="tab-content">
						<!-- Materials table tab-->
						<div class="tab-pane {{ $materialsActive }} table-cnt" id="materials">

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
										<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Επιλογές
										</button>
										<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
											<a id="remove-selection-btn" class="dropdown-item" href="#">Αφαίρεση επιλογών</a>
										</div>
									</div>
								</div>
							</div>
						</div><!-- end material tab-pane -->
						<!-- end about me section content -->

						<!-- Course edit form tab-pane -->
						<div class="tab-pane {{ $settingsActive }}" id="settings">
							<form id="edit-course-form" action="{{ route('course.update', $course->id) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
								
								@csrf
								@method('PATCH')

								<div class="form-row">
							        <div class="col-xl-6">
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
							        </div>
							        <div class="col-xl-6">
							            <div class="form-group">
							                <label for="course-cover">Cover</label>
											<div class="input-group">
											    <div class="custom-file">
													<input id="course-cover-input" type="file" class="custom-file-input @error('cover') is-invalid @enderror" name="cover">
													<label id="course-cover-label" class="custom-file-label file-search-label-primary" for="course-cover-input">{{ $course->cover }}</label>
												</div>
												@error('cover')
													<span class="invalid-feedback d-block" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
							            </div>
							        </div> <!-- end col -->
								</div> <!-- end row -->
								

								<div class="form-row">
							        <div class="col-xl-6">
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
							        </div>
							        <div class="col-xl-6">

										<div class="form-group">
											<label for="example-select">Κατάσταση</label>
											<select id="active" class="form-control @error('active') is-invalid @enderror" name="active">
												<option value="1" {{ $course['active'] == 1 ? "selected" : "" }}>Ενεργό</option>
												<option value="0" {{ $course['active'] == 0 ? "selected" : "" }}>Ανενεργό</option>
											</select>
											@error('active')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>

									</div> <!-- end col -->
							    </div> <!-- end row -->

								<div class="form-row">
									<div class="col-12">
										<div class="form-group">
											<label for="summary">Σύνοψη</label>
											<textarea class="form-control @error('summary') is-invalid @enderror" id="summary" name="summary" rows="4" placeholder="Εισάγετε σύνοψη...">{{ old('summary') != "" ? old('summary') : $course['summary'] }}</textarea>
											@error('summary')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
									</div> <!-- end col -->
								</div> <!-- end row -->

								<div class="form-row">
									<div class="col-12">
										<div class="form-group">
											<label for="description">Περιγραφή</label>
											<textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Εισάγετε περιγραφή...">{{ old('description') != "" ? old('description') : $course['description'] }}</textarea>
											@error('description')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
									</div> <!-- end col -->
								</div> <!-- end row -->

							    <button id="delete-course-btn" type="submit" class="btn btn-danger" name="delete" disabled><i class="mdi mdi-file-remove mr-1"></i>Διαγραφή</button>
								<div class="float-right">	
									<button type="submit" class="btn btn-primary" name="save"><i class="mdi mdi-content-save mr-1"></i>Αποθήκευση</button>
							        <button id="edit-course-reset-btn" type="reset" class="btn btn-secondary"><i class="mdi mdi-refresh-circle mr-1"></i>Επαναφορά</button>
								</div>
									{{-- </div> --}}
							</form>
						</div><!-- end tab-pane -->
						<!-- end settings content-->

						<div class="tab-pane table-cnt" id="users">

							<table id="active-users-list" class="js-table table w-100 nowrap js-remove-table-classes">
								<thead>
									<tr>
										<th class="text-center">
											<div class='icheck-primary d-inline'>
												<input type='checkbox' id='all-active-users-checkbox' autocomplete='off'>
												<label for='all-active-users-checkbox'></label>
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
										<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Επιλογές
										</button>
										<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
											<a id="remove-selected-users-btn" class="dropdown-item" href="#">Αφαίρεση επιλογών</a>
										</div>
									</div>
								</div>
							</div>
						</div><!-- end users tab-pane -->


					</div> <!-- end tab-content -->
					
				</div> <!-- end card body -->
			</div> <!-- end card -->
		</div> <!-- end col -->

	</div>
@endsection

@section('scripts')
<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>
<script src="/assets/js/vendor/dataTables.buttons.min.js"></script>


<script src="{{ mix('js/dashboard/courses/courseProfile.js') }}"></script>
@endsection