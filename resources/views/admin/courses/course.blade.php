@extends('layouts.dashboard')

@section('css')
<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
@endsection

@php
	$materialsActive = count( $errors ) > 0 ? "" : "active";
	$settingsActive = count( $errors ) > 0 ? "active" : "";
@endphp

@section('content')

	<div id="add-students-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="add-students-modalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header modal-colored-header bg-primary">
					<h4 class="modal-title" id="add-students-modalLabel">Προσθήκη Μαθημάτων</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body table-cnt">
					<table id="add-students-list" class="table w-100 nowrap modal-table custom-center-table center-not-second js-remove-table-classes">
						<thead>
							<tr>
								<th class="select-all w-5">
									<div class='icheck-primary d-inline'>
										<input class='js-course-checkbox' type='checkbox' id='all-remainings-checkbox' autocomplete='off'>
										<label for='all-remainings-checkbox'></label>
									</div>
								</th>
								<th class="text-center">Όνομα</th>
								<th class="text-center">Επώνυμο</th>
								<th class="text-center"></th>
							</tr>
						</thead>
						<tbody class="tables-hover-effect"></tbody>
						<tfoot>
							<tr>
								<th class="text-center">Επιλογή</th>
								<th class="text-center">Όνομα</th>
								<th class="text-center">Επώνυμο</th>
								<th class="text-center"></th>
							</tr>
						</tfoot>
					</table>
				</div>
				<div class="modal-footer">
					<button id="add-multiple-students-btn" type="button" class="btn btn-primary">Προσθήκη Επιλογών</button>
					<button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div id="add-materials-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="add-materials-modalLabel" aria-hidden="true">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header modal-colored-header bg-primary">
	                <h4 class="modal-title" id="add-materials-modalLabel">Προσθήκη Μαθημάτων</h4>
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	            </div>
	            <div class="modal-body table-cnt">
	                <table id="remaining-materials-table" class="table w-100 nowrap modal-table custom-center-table center-not-second js-remove-table-classes">
						<thead>
							<tr>
								<th class="select-all w-5">
									<div class='icheck-primary d-inline'>
										<input class='js-course-checkbox' type='checkbox' id='all-remainings-checkbox' autocomplete='off'>
										<label for='all-remainings-checkbox'></label>
									</div>
								</th>
								<th class="text-center">Όνομα</th>
								<th class="text-center">Topic</th>
								<th class="text-center">Τύπος</th>
								<th class="text-center"></th>
							</tr>
						</thead>
						<tbody class="tables-hover-effect"></tbody>
						<tfoot>
							<tr>
								<th class="text-center">Επιλογή</th>
								<th class="text-center">Όνομα</th>
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


	{{-- <div class="card">

		<h5 class="card-header text-uppercase">
			<i class="mdi mdi-briefcase mr-1"></i>
			Experience
		</h5>

		<div class="card-body">
			<div class="timeline-alt pb-0">
				<div class="timeline-item">
					<i class="mdi mdi-circle bg-primary-lighten text-primary timeline-icon"></i>
					<div class="timeline-item-info">
						<h5 class="mt-0 mb-1">Lead designer / Developer</h5>
						<p class="font-14">websitename.com <span class="ml-2 font-12">Year: 2015 - 18</span></p>
						<p class="text-muted mt-2 mb-0 pb-3">Everyone realizes why a new common language
							would be desirable: one could refuse to pay expensive translators.
							To achieve this, it would be necessary to have uniform grammar,
							pronunciation and more common words.</p>
					</div>
				</div>

				<div class="timeline-item">
					<i class="mdi mdi-circle bg-info-lighten text-info timeline-icon"></i>
					<div class="timeline-item-info">
						<h5 class="mt-0 mb-1">Senior Graphic Designer</h5>
						<p class="font-14">Software Inc. <span class="ml-2 font-12">Year: 2012 - 15</span></p>
						<p class="text-muted mt-2 mb-0 pb-3">If several languages coalesce, the grammar
							of the resulting language is more simple and regular than that of
							the individual languages. The new common language will be more
							simple and regular than the existing European languages.</p>

					</div>
				</div>

				<div class="timeline-item">
					<i class="mdi mdi-circle bg-primary-lighten text-primary timeline-icon"></i>
					<div class="timeline-item-info">
						<h5 class="mt-0 mb-1">Graphic Designer</h5>
						<p class="font-14">Coderthemes Design LLP <span class="ml-2 font-12">Year: 2010 - 12</span></p>
						<p class="text-muted mt-2 mb-0 pb-2">The European languages are members of
							the same family. Their separate existence is a myth. For science
							music sport etc, Europe uses the same vocabulary. The languages
							only differ in their grammar their pronunciation.</p>
					</div>
				</div>

			</div>
			<!-- end timeline -->  
		</div>
	</div> --}}

			<div class="card text-center">
				<div class="card-body">
					<img src="{{ asset('storage/courses/'.$course->id.'/cover/'.$course->cover) }}" class="img-fluid"
					alt="profile-image">
	
					<h4 class="mb-0 mt-2">{{ $course['name'] }}</h4>
					<p class="text-muted font-14">Course</p>
	
					<div class="text-left mt-3">
						<h4 class="font-13 text-uppercase">About Course :</h4>
						<p class="text-muted font-13 mb-3">
							{{ $course['description'] }}
						</p>
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
							<a href="#students" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
								Μαθητές
							</a>
						</li>
					</ul><!-- /.End Tab Buttons -->

					<div class="tab-content">
						<!-- Materials table tab-->
						<div class="tab-pane {{ $materialsActive }} table-cnt" id="materials">

							<table id="course-materials-list" data-course-id="{{ $course['id'] }}" class="table w-100 nowrap custom-center-table center-not-second js-remove-table-classes">
								<thead>
									<tr>
										<th class="text-center">
											<div class='icheck-primary d-inline'>
												<input type='checkbox' id='all-active-materials-checkbox' autocomplete='off'>
												<label for='all-active-materials-checkbox'></label>
											</div>
										</th>
										<th class="text-center">Όνομα</th>
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
										<th class="text-center">Όνομα</th>
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
										Προσθήκη Μαθημάτων
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
							<form action="{{ route('course.update', $course->id) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
								
								@csrf
								@method('PATCH')

								<div class="row">
							        <div class="col-xl-6">
							            <div class="form-group">
							                <label for="name">Όνομα Course</label>
											<input id="name" type="text" 
												class="form-control @error('name') is-invalid @enderror" 
												id="name" name="name" 
												value="{{ old('name') != "" ? old('name') : $course['name'] }}" 
												placeholder="Δώστε όνομα">
											@error('name')
                            				    <span class="invalid-feedback" role="alert">
                            				        <strong>{{ $message }}</strong>
                            				    </span>
                            				@enderror
										</div>
							        </div>
							        <div class="col-xl-6">
							            <div class="form-group">
							                <label for="course-cover">Cover Εικόνα</label>
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

							    <div class="row">
							        <div class="col-12">
							            <div class="form-group">
							                <label for="description">Περιγραφή</label>
											<textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"rows="4" placeholder="Περιγραφή Course...">{{ old('description') != "" ? old('description') : $course['description'] }}</textarea>
											@error('description')
                            				    <span class="invalid-feedback" role="alert">
                            				        <strong>{{ $message }}</strong>
                            				    </span>
                            				@enderror
										</div>
							        </div> <!-- end col -->
							    </div> <!-- end row -->

							    <div class="row">
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
							        </div>
							        <div class="col-xl-6">
									</div> <!-- end col -->
							    </div> <!-- end row -->

							    <div class="text-right">
							        <button type="submit" class="btn btn-primary mt-2 w-100"><i class="mdi mdi-content-save mr-1"></i>Αποθήκευση</button>
							    </div>
							</form>
						</div><!-- end tab-pane -->
						<!-- end settings content-->

						<div class="tab-pane table-cnt" id="students">

							<table id="students-list" class="table w-100 nowrap js-remove-table-classes">
								<thead>
									<tr>
										<th class="text-center">
											<div class='icheck-primary d-inline'>
												<input type='checkbox' id='all-active-materials-checkbox' autocomplete='off'>
												<label for='all-active-materials-checkbox'></label>
											</div>
										</th>
										<th class="text-center">Όνομα</th>
										<th class="text-center">Επώνυμο</th>
										<th class="text-center"></th>
									</tr>
								</thead>
								<tbody class="tables-hover-effect"></tbody>
								<tfoot>
									<tr>
										<th class="text-center"></th>
										<th class="text-center">Όνομα</th>
										<th class="text-center">Επώνυμο</th>
										<th class="text-center"></th>
									</tr>
								</tfoot>
							</table>

							<div class="row mt-3">
								<div class="col-sm-1">
								</div>
								<div class="col-sm-11 d-flex justify-content-end">
									<button id="material-modal-shown-btn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-students-modal">
										<i class="mdi mdi-account-multiple-plus mr-2"></i>
										Προσθήκη Μαθητών
									</button>
									<div class="dropdown ml-2">
										<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Επιλογές
										</button>
										<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
											<a id="remove-selected-students-btn" class="dropdown-item" href="#">Αφαίρεση επιλογών</a>
										</div>
									</div>
								</div>
							</div>
						</div><!-- end students tab-pane -->


					</div> <!-- end tab-content -->
					
				</div> <!-- end card body -->
			</div> <!-- end card -->
		</div> <!-- end col -->




	</div>
@endsection

@section('scripts')
<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>

<script src="{{ asset('js/dashboard/courses/courseProfile.js') }}"></script>
@endsection