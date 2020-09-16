@extends('layouts.dashboard')

@section('css')
<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">

<style>
	.content-page {
		overflow: initial;
	}
	.wrapper {
		overflow: initial;
	}
	.sticky {
		background-color: #343a40;
		position: sticky;
		top: 70px;
		z-index: 1010;
	}
</style>
@endsection

@section('content')

	@isset($course)
		<!-- Modal -->
		<div class="modal fade" id="gallery-modal" tabindex="-1" role="dialog" aria-labelledby="gallery-modalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" style="max-width: 1100px" role="document">
				<div class="modal-content">
					<div class="modal-header modal-colored-header bg-primary">
						<h5 class="modal-title" id="gallery-modalLabel">Media Library</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					
						<ul class="nav nav-tabs nav-bordered mb-3">
							<li class="nav-item">
								<a href="#media-library" id="media-library-tab-btn"
									data-toggle="tab" aria-expanded="false"
									class="nav-link active"
								>
									Media Library
								</a>
							</li>
							<li class="nav-item">
								<a href="#upload" id="upload-tab-btn"
									data-toggle="tab" aria-expanded="true"
									class="nav-link"
								>
									Upload
								</a>
							</li>
						</ul> <!-- end nav-->
					
						<div class="tab-content">
						
							<div id="media-library" class="tab-pane show active">
								<!-- Search -->
								<div class="row">
									<div class="mx-auto col-4">
										<div class="form-group">
											<input id="image-search" class="form-control text-center" type="text" placeholder="Αναζήτηση..." />
										</div>
									</div>
								</div>
								<div id="gallery-content" data-model="App\Course" data-id={{ $course->id }}>	
									@include('components.admin.imageGallery', ['media' => $media])
								</div>
							</div>
						
							<div id="upload" class="tab-pane">
							
								<input id="file-pond" type="file[]"/>
								
							</div>			
						</div>
						
					</div>
				
					<div class="modal-footer">
						<button type="button" class="btn btn-light" data-dismiss="modal">Έξοδος</button>
					</div>
				</div>
			</div>
		</div>
	@endisset

	<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box">
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="/" class="custom-link-primary">Home</a></li>
						<li class="breadcrumb-item"><a href="/dashboard" class="custom-link-primary">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="/dashboard/courses" class="custom-link-primary">Courses</a></li>
						<li class="breadcrumb-item active">{{ isset($course) ? $course->title : "Νέο Course" }}</li>
					</ol>
				</div>
				<h4 class="page-title">{{ isset($course) ? $course->title : "Νέο Course" }}</h4>
			</div>
		</div>
	</div>     
	<!-- end page title -->

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
						class="btn btn-secondary" data-text="Προσθήκη Επιλογών"
						data-enabled-color="btn-primary" data-disabled-color="btn-secondary" disabled>
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
							<a href="#settings" id="setting-tab-btn"
								data-toggle="tab" aria-expanded="false"
								class="nav-link active"
							>
								Ρυθμίσεις
							</a>
						</li>
						<li class="nav-item">
							<a href="#materials" id="materials-tab-btn"
								data-toggle="tab" aria-expanded="true"
								class="nav-link {{ !isset($course) ? 'tab-link text-muted' : '' }}"
							>
								Υλικό
							</a>
						</li>
						<li class="nav-item">
							<a href="#users" id="users-tab-btn"
								data-toggle="tab" aria-expanded="true"
								class="nav-link {{ !isset($course) ? 'tab-link text-muted' : '' }}"
							>
								Χρήστες
							</a>
						</li>
					</ul> <!-- end nav-->

					<div class="tab-content">

						<div id="settings" class="tab-pane show active">
							<form id="edit-course-form"
								action="{{ isset($course) ? route('course.update', $course->slug) : "/dashboard/courses/store" }}"
								method="POST" enctype="multipart/form-data" autocomplete="off"
							>
								
								@csrf
								@if ( isset($course) )
									@method('PATCH')
								@endif

								<div class="form-group">
									<label for="title">Τίτλος</label>
									<input id="title" type="text" 
										class="form-control @error('title') is-invalid @enderror" 
										id="title" name="title" 
										value="{{ old('title') != "" ? old('title') : ( isset($course) ? $course['title'] : "" ) }}" 
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
										value="{{ old('subtitle') != "" ? old('subtitle') : ( isset($course) ? $course['subtitle'] : "" ) }}" 
										placeholder="Εισάγετε υπότιτλο...">
									@error('subtitle')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>

								@isset($course)
									<div class="form-group">
										<label for="summary">Σύνοψη</label>
										<textarea class="form-control @error('summary') is-invalid @enderror"
											id="summary" name="summary" rows="4" 
											placeholder="Εισάγετε σύνοψη..."
										>{{ old('summary') != "" ? old('summary') : ( isset($course) ? $course['summary'] : "" ) }}</textarea>
										@error('summary')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>
								
									<div class="form-group">
										<label for="description">Περιγραφή</label>
										<textarea class="form-control @error('description') is-invalid @enderror"
											id="description" name="description" rows="4"
											placeholder="Εισάγετε περιγραφή..."
										>{{ old('description') != "" ? old('description') : ( isset($course) ? $course['description'] : "" ) }}</textarea>
										@error('description')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>
								@endisset

							</form>
						</div><!-- settings tab-pane -->

						<div id="materials" class="tab-pane table-cnt mb-3">

							<div class="row my-3">
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
											<div class="btn-group dropleft w-100">
												<a class="dropdown-toggle dropdown-item" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													Αλλαγή κατάστασης
												</a>
												<div class="dropdown-menu">
													<a id="activate-selection" class="dropdown-item" href="#">Ενεργοποιήση</a>
													<a id="deactivate-selection" class="dropdown-item" href="#">Απενεργοποίηση</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<table id="course-materials-list" data-course-id="{{  isset($course) ? $course['id'] : 1 }}" class="table w-100 nowrap center-not-second js-remove-table-classes js-table">
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
										<th class="text-center"></th>
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
										<th class="text-center"></th>
									</tr>
								</tfoot>
							</table>

							
						</div><!-- materials tab-pane -->

						<div id="users" class="tab-pane table-cnt">

							<div class="row my-3">
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
								<tbody class="tables-hover-effect table-text-center"></tbody>
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

						</div><!-- users tab-pane -->
					
					</div><!-- tab-content -->
				</div>
				<div class="col-xl-3 col-lg-5 col-md-12">

					<div class="sticky py-3">
						<button form="edit-course-form" type="submit"
							id="update-btn" class="btn btn-primary"
						>
							{{ isset($course) ? "Ενημέρωση" : "Αποθήκευση" }}
						</button>
						@if ( isset($course) )
							<a id="preview-btn"
								href="/courses/course/{{ $course->slug }}"
								class="btn btn-warning"
							>
								<i class="mdi mdi-eye"></i>
							</a>
							<button id="course-delete-btn" class="btn btn-danger float-right">Διαγραφή</button>
						@endif
					</div>

					<div class="card">
						<div class="card-body">
							<div class="form-group">


								@if ( old('verison') != "" )
									$normalSelected = old('verison') == "Normal" ? "selected" : ""
									$trialSelected = old('verison') == "Trial" ? "selected" : ""
								@endif

								<label for="version-select">Έκδοση</label>
								<select form="edit-course-form" id="version-select" name="version"
									class="select2 form-control @error('version') is-invalid @enderror"
								>
									@if ( !isset($course) )
										<option value="" selected>Επιλέξτε έκδοση</option>
									@endif

									<option value="Normal" {{
										isset($normalSelected) ? $normalSelected
											: ( isset($course) && $course->version == "Normal" ? "selected" : "" )
										}}
									>Normal</option>
									<option value="Trial" {{
										isset($trialSelected) ? $trialSelected
											: ( isset($course) && $course->version == "Trial" ? "selected" : "" )
										}}
									>Trial</option>
								</select>
								@error('version')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>

							<hr>

							<div class="form-group">
								<label for="topic">Topic</label>
								<select form="edit-course-form" 
									class="select2 form-control select2-multiple"
									name="topics[]" data-toggle="select2"
									multiple="multiple" data-placeholder="Επιλέξτε Topics..."
								>
										
									@foreach ($topics as $topic)
										<option value="{{ $topic->id }}"
											@if ( isset($course) )
												@foreach ( $course->topics as $courseTopic )
													@if ( $courseTopic->id == $topic->id )
														selected
														@break
													@endif
												@endforeach
											@endif
										>{{ $topic->title }}</option>
									@endforeach

								</select>
							</div>
							<hr>
							<label for="curator">Κύριος Εισηγητής</label>
							<select id="curator" form="edit-course-form"
								class="select2 form-control" name="curator"
								data-toggle="select2" data-placeholder="Επιλέξτε Εισηγητή..."
							>
								@foreach ($instructors as $instructor)
									@if (  isset($course) && $course->user_id == $instructor->id )
										<option value="{{ $instructor->id }}" selected>{{ $instructor->first_name }} {{ $instructor->last_name }}</option>	
										@continue
									@endif
									<option value="{{ $instructor->id }}">{{ $instructor->first_name }} {{ $instructor->last_name }}</option>
								@endforeach

							</select>
							<hr>
							<div class="form-group">
								<label for="publish-date-select">Δημοσίευση απο:</label>
								<input form="edit-course-form" type="text" class="form-control"
									id="publish-date-select" name="publishDate"
									value="{{ $publish }}"
									placeholder="Εισάγετε ημερομηνία..." data-toggle="input-mask"
									data-mask-format="00-00-0000 00:00:00" autocomplete="off"
								/>
							</div>
							<hr>
						</div>
					</div>

					@if ( isset($course) )
						<!-- Cover Preview -->
						<div class="card">
							<div class="card-header">
								<h4 class="card-title mb-0">Cover</h4>
								
							</div>
							<div class="card-body">
								<img id="cover-image" src="{{ url($course->cover) }}" class="img-fluid"
									alt="Cover Image">
								
								<button id="change-cover-btn" class="btn btn-primary btn-block mt-3">Αλλαγή Cover</button>

							</div> <!-- end card-body -->
						</div> <!-- end course info card -->
					@endif

				</div>
			</div>
		</div>
	</div>
	@if ( isset($course) )
		<form id="delete-course-form" action="{{ $course->slug }}" method="POST">

			@csrf
			@method('DELETE')

		</form>
	@endif

@endsection

@section('scripts')
<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>
<script src="/assets/js/vendor/dataTables.buttons.min.js"></script>

<script src="{{ mix('js/dashboard/courses/courseProfile.js') }}"></script>

@endsection