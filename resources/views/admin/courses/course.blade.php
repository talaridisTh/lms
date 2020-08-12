@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
	<div id="primary-header-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="primary-header-modalLabel" aria-hidden="true">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header modal-colored-header bg-primary">
	                <h4 class="modal-title" id="primary-header-modalLabel">Προσθήκη Μαθημάτων</h4>
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
			<div class="card text-center">
				<div class="card-body">
					<img src="https://via.placeholder.com/300x200" class="img-fluid"
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
							<span class="ml-2">
								{{ $course->materials->where( 'type', 'Lesson')->count() }}
							</span>
						</p>

						<p class="text-muted mb-2 font-13">
							<strong>
								Σύνολο Extra Υλικού :
							</strong>
							<span class="ml-2">
								{{ $course->materials->where( 'type', '!=', 'Lesson')->count() }}
							</span>
						</p>
						<h4 class="font-13 text-uppercase mt-4">Εισηγητές μαθημάτων :</h4>
							<ul id="authors-list">
								@foreach ($authors as $key => $author)
										<li class="js-authors">{{$author['first_name']}} {{$author['last_name']}}</li>
								@endforeach
								<li id="more-authors" 
									data-shown="false" 
									class="d-none mt-1 list-unstyled font-weight-bold cursor-pointer text-hover-underline">
									Περρισότερα...
								</li>
							</ul>

						<p class="text-muted mb-2 font-13 mt-4">
							<strong>
								Τελευταία Ανανέωση :
							</strong>
							<span id="last-update-cnt" class="ml-2">
								{{ $course['updated_at'] }}
							</span>
						</p>

						<p class="text-muted mb-1 font-13">
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
							<a href="#materials" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
								Μαθήματα
							</a>
						</li>
						<li class="nav-item">
							<a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
								Επεξεργασία
							</a>
						</li>
					</ul><!-- /.End Tab Buttons -->

					<div class="tab-content">
						<!-- Materials table tab-->
						<div class="tab-pane show active table-cnt" id="materials">

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
									<button id="material-modal-shown-btn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#primary-header-modal">
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
						<div class="tab-pane" id="settings">
							<form>
							    <div class="row">
							        <div class="col-xl-6">
							            <div class="form-group">
							                <label for="name">Όνομα Course</label>
											<input type="text" class="form-control" id="name" name="name" value="{{ $course['name'] }}" placeholder="Δώστε όνομα">
							            </div>
							        </div>
							        <div class="col-xl-6">
							            <div class="form-group">
							                <label for="course-cover">Cover Εικόνα</label>
											<div class="input-group">
											    <div class="custom-file">
											        <input type="file" class="custom-file-input" name="cover" value="{{ $course['cover'] }}" id="course-cover">
											        <label class="custom-file-label" for="course-cover">"{{ $course['cover'] }}"</label>
											    </div>
											</div>
							            </div>
							        </div> <!-- end col -->
							    </div> <!-- end row -->

							    <div class="row">
							        <div class="col-12">
							            <div class="form-group">
							                <label for="description">Περιγραφή</label>
										<textarea class="form-control" id="description" name="description" rows="4" placeholder="Write something...">{{ $course['description'] }}</textarea>
							            </div>
							        </div> <!-- end col -->
							    </div> <!-- end row -->

							    <div class="row">
							        <div class="col-xl-6">
							            <div class="form-group">
							                <label for="example-select">Κατάσταση</label>
											<select class="form-control" id="active">
											    <option value="1">Ενεργό</option>
											    <option value="0">Ανενεργό</option>
											</select>
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
					</div> <!-- end tab-content -->
					
				</div> <!-- end card body -->
			</div> <!-- end card -->
		</div> <!-- end col -->
	</div>
@endsection

@section('scripts')
<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>

<script src="{{ mix('js/dashboard/courses/courseProfile.js') }}"></script>
@endsection