@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
	<div id="remaining-courses-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="remaining-courses-modalLabel" aria-hidden="true">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header modal-colored-header bg-primary">
	                <h4 class="modal-title" id="remaining-courses-modalLabel">Προσθήκη Μαθημάτων</h4>
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	            </div>
	            <div class="modal-body table-cnt">
	                <table id="remaining-courses-table" class="table w-100 nowrap modal-table px-3 custom-center-table js-remove-table-classes">
						<thead>
							<tr>
								<th class="select-all w-5">
									<div class='icheck-primary d-inline'>
										<input class='js-courses-checkbox' type='checkbox' id='all-courses-checkbox' autocomplete='off'>
										<label for='all-courses-checkbox'></label>
									</div>
								</th>
								<th>Όνομα</th>
								<th class="text-center w-5"></th>
							</tr>
						</thead>
						<tbody class="tables-hover-effect"></tbody>
						<tfoot>
							<tr>
								<th class="text-center"></th>
								<th>Όνομα</th>
								<th class="text-center"></th>
							</tr>
						</tfoot>
					</table>
	            </div>
	            <div class="modal-footer">
	                <button id="add-courses-btn" type="button" class="btn btn-primary">Προσθήκη Επιλογών</button>
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

					<h4 class="mb-0 mt-2">{{ $bundle['name'] }}</h4>
					<p class="text-muted font-14">Course</p>

					<div class="text-left mt-3">
						<h4 class="font-13 text-uppercase">About Course :</h4>
						<p class="text-muted font-13 mb-3">
							{{ $bundle['description'] }}
						</p>
						<p class="text-muted mb-2 font-13">
							<strong>
								Σύνολο Μαθημάτων :
							</strong>
							<span class="ml-2">
								{{-- {{ $course->materials->where( 'type', 'Lesson')->count() }} --}}
							</span>
						</p>

						<p class="text-muted mb-2 font-13">
							<strong>
								Σύνολο Extra Υλικού :
							</strong>
							<span class="ml-2">
								{{-- {{ $course->materials->where( 'type', '!=', 'Lesson')->count() }} --}}
							</span>
						</p>
						<h4 class="font-13 text-uppercase mt-4">Εισηγητές μαθημάτων :</h4>
							<ul id="authors-list">
								{{-- @foreach ($authors as $key => $author)
										<li class="js-authors">{{$author['first_name']}} {{$author['last_name']}}</li>
								@endforeach --}}
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
								{{ $bundle['updated_at'] }}
							</span>
						</p>

						<p class="text-muted mb-1 font-13">
							<strong>
								Ημ. Δημιουργίας :
							</strong>
							<span class="ml-2">
								{{ $bundle['created_at'] }}
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
							<a href="#courses" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
								Courses
							</a>
						</li>
						<li class="nav-item">
							<a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
								Επεξεργασία
							</a>
						</li>
					</ul><!-- /.End Tab Buttons -->

					<div class="tab-content">
						<!-- Courses table tab-->
						<div class="tab-pane show active table-cnt" id="courses">

							<table id="bundle-courses-list" data-bundle-id="{{ $bundle['id'] }}" class="table w-100 nowrap custom-center-table center-not-second js-remove-table-classes">
								<thead>
									<tr>
										<th class="text-center">
											<div class='icheck-primary d-inline'>
												<input type='checkbox' id='main-active-courses-checkbox' autocomplete='off'>
												<label for='main-active-courses-checkbox'></label>
											</div>
										</th>
										<th class="text-center">Όνομα</th>
										<th class="text-center">Τελ. Ανανέωση</th>
										<th class="text-center">Ημ. Δημιουργίας</th>
									</tr>
								</thead>
								<tbody class="tables-hover-effect"></tbody>
								<tfoot>
									<tr>
										<th class="text-center"></th>
										<th class="text-center">Όνομα</th>
										<th class="text-center">Τελ. Ανανέωση</th>
										<th class="text-center">Ημ. Δημιουργίας</th>
									</tr>
								</tfoot>
							</table>

							<div class="row mt-3">
								<div class="col-sm-1">
								</div>
								<div class="col-sm-11 d-flex justify-content-end">
									<button id="course-modal-shown-btn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#remaining-courses-modal">
										<i class="mdi mdi-plus-circle mr-2"></i>
										Προσθήκη Μαθημάτων
									</button>
									<div class="dropdown ml-2">
										<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Επιλογές
										</button>
										<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
											<a id="remove-selected-courses-btn" class="dropdown-item" href="#">Αφαίρεση επιλογών</a>
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
											<input type="text" class="form-control" id="name" name="name" value="{{ $bundle['name'] }}" placeholder="Δώστε όνομα">
							            </div>
							        </div>
							        <div class="col-xl-6">
							            <div class="form-group">
							                <label for="course-cover">Cover Εικόνα</label>
											<div class="input-group">
											    <div class="custom-file">
											        <input type="file" class="custom-file-input" name="cover" value="{{ $bundle['cover'] }}" id="cover-input">
											        <label class="custom-file-label" for="cover-input">"{{ $bundle['cover'] }}"</label>
											    </div>
											</div>
							            </div>
							        </div> <!-- end col -->
							    </div> <!-- end row -->

							    <div class="row">
							        <div class="col-12">
							            <div class="form-group">
							                <label for="description">Περιγραφή</label>
										<textarea class="form-control" id="description" name="description" rows="4" placeholder="Write something...">{{ $bundle['description'] }}</textarea>
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

	<script>
		//! GLOBAL VARIABLES
		const bundleId = $("#bundle-courses-list")[0].dataset.bundleId
		const updatedAt = $("#last-update-cnt")[0];

		//! EventListerners

		$('#main-active-courses-checkbox').click( function() {
			let checkboxes = $('.js-course-checkbox');
			minorCheckboxSwitcher( this, checkboxes );
		});

		$('#all-courses-checkbox').change( function() {
			let checkboxes = $('.js-remainings-checkbox');
			minorCheckboxSwitcher( this, checkboxes );
		});

		$('#add-courses-btn').click( function() {
			let checkboxes = $('.js-remainings-checkbox:checked');
			let ids = [];

			if ( checkboxes.length == 0 ) {
				toastAlert( 'info', "Δεν υπάρχουν επιλεγμένα μαθήματα..." );
				return;
			}
			else {
				for ( let i = 0; i < checkboxes.length; i++) {
					ids.push(checkboxes[i].dataset.courseId);
				}
				postCourseIds( ids );
			}
		});

		$('#remove-selected-courses-btn').click( function() {
			let checkboxes = $('.js-course-checkbox:checked');
			let ids = []

			if ( checkboxes.length == 0 ) {
				
				toastAlert( 'info', "Δεν υπάρχουν επιλεγμένα μαθήματα..." );
				return;
			}
			else {
				for ( let i = 0; i < checkboxes.length; i++ ) {
					ids.push( checkboxes[i].dataset.courseId );
				}
				removeCourses(ids);
			}
		});

		// $("#all-active-materials-checkbox").change( function() {

		// 	let checkboxes = $(".js-course-material-checkbox");

		// 	if ( this.checked ) {
		// 		for ( let i = 0; i < checkboxes.length; i++ ) {
		// 			checkboxes[i].checked = true;
		// 		}
		// 	}
		// 	else {
		// 		for ( let i = 0; i < checkboxes.length; i++ ) {
		// 			checkboxes[i].checked = false;
		// 		}
		// 	}
		// });
		//! EventListerners /end

		//! Datatables
		const bundleCoursesTable = $("#bundle-courses-list").DataTable({
			order: [1, "asc"],
			processing: true,
			serverSide: true,
			ajax: {
				url: "/bundles/bundle-courses-datatable",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				type: "post",
				data: {
					bundleId: bundleId
				}
			},
			columns: [
				{ data: 'action', name: 'action', orderable: false, width: "5%" },
				{ data: 'name', name: 'name', className: "js-link cursor-pointer" },
				{ data: 'updated_at', name: 'updated_at',  className: "js-link cursor-pointer" },
				{ data: 'created_at', name: 'created_at', className: "js-link cursor-pointer" },
			],
			language:{
				emptyTable: 		"Δεν υπάρχουν εγγραφές",
				info: 				"_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα",
				infoEmpty:      	"0 απο 0 τα 0 αποτελέσματα",
				lengthMenu: 		"Αποτελέσματα ανα σελίδα: _MENU_",
				loadingRecords: 	"Φόρτωση ...",
				processing: 		"Επεξεργασία ...",
				search: 			"Αναζήτηση: ",
				zeroRecords: 		"Δεν βρέθηκαν αποτελέσματα",
				paginate:{
					previous:"<i class='mdi mdi-chevron-left'>",
					next:"<i class='mdi mdi-chevron-right'>"}
			},
			drawCallback:function(){
				$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
				$(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
				$(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
				$(".js-remove-table-classes > thead > tr > th").removeClass("js-link cursor-pointer");

				jsLinkEventListener();
				activeCoursesCheckboxToggle();
			},
			
		});

		function activeCoursesCheckboxToggle() {

			let mainCheckbox = $('#main-active-courses-checkbox')[0];
			let minorCheckbox = $('.js-course-checkbox');

			minorCheckbox.unbind();
			minorCheckbox.change( function() {
				mainCheckboxSwitcher(mainCheckbox, minorCheckbox);
			});
		}

		const remainingCoursesTable = $("#remaining-courses-table").DataTable({
			order: [1, "asc"],
			processing: true,
			serverSide: true,
			ajax: {
				url: "/bundles/remaining-courses-datatable",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				type: "post",
				data: {
					bundleId: bundleId
				}
			},
			columns: [
				{data: 'action', name:'action', orderable: false, searchable: false, className: "text-center"},
				{data: 'name', name: 'name', className: "cursor-default"},
				{data: 'addBtn', name: 'addBtn', orderable: false, searchable: false, className: "text-center"}
			],
			language:{
				emptyTable: 		"Δεν υπάρχουν εγγραφές",
				info: 				"_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα",
				infoEmpty:      	"0 απο 0 τα 0 αποτελέσματα",
				lengthMenu: 		"Αποτελέσματα ανα σελίδα: _MENU_",
				loadingRecords: 	"Φόρτωση ...",
				processing: 		"Επεξεργασία ...",
				search: 			"Αναζήτηση: ",
				zeroRecords: 		"Δεν βρέθηκαν αποτελέσματα",
				paginate:{
					previous:"<i class='mdi mdi-chevron-left'>",
					next:"<i class='mdi mdi-chevron-right'>"}
			},
			drawCallback:function(){
				$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
				$(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
				$(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
				$(".js-remove-table-classes > thead > tr > th").removeClass("cursor-pointer");
				$(".js-remove-table-classes > tfoot > tr > th").removeClass("cursor-pointer");

				addcourse();
				remainingsCheckboxes();
			},
			
		});
		//! DataTables /end

		//! DataTables function / EventListener

		function addcourse() {
			$('.js-add-course-btn').click( function() {

				const courseId = [this.dataset.courseId];

				postCourseIds( courseId );
			});
		}

		function remainingsCheckboxes() {

			let mainCheckbox = $('#all-courses-checkbox')[0];
			let minorCheckbox = $('.js-remainings-checkbox');

			minorCheckbox.unbind();
			minorCheckbox.change( function() {
				mainCheckboxSwitcher(mainCheckbox, minorCheckbox);
			});
		}

		function jsLinkEventListener() {

			let links = $(".js-link");

			links.unbind();
			links.click( function() {
				
				let id = this.parentElement.dataset.courseId;

				window.location = `/dashboard/course/${id}`;
			});
		}

		// DataTables function / EventListener End


		function mainCheckboxSwitcher( main, minor) {

			for ( let i = 0; i < minor.length; i++ ) {
				if ( !minor[i].checked ) {
					main.checked = false;
					break;
				}
				else {
					main.checked = true;
				}
			}

		}

		function minorCheckboxSwitcher( main, minor ) {

			if ( main.checked ) {
				for ( let i = 0; i < minor.length; i++ ) {
					minor[i].checked = true;
				}
			}
			else {
				for ( let i = 0; i < minor.length; i++ ) {
					minor[i].checked = false;
				}
			}

		}

		function postCourseIds( courseIds ) {
			axios.patch( "/bundles/add-courses", {
				bundleId,
				courseIds
			})
			.then( (res) => {
				let message = courseIds.length == 1 ? "1 προστέθηκε" : `${courseIds.length} προστέθηκαν`;
				toastAlert( 'success', message );

				bundleCoursesTable.ajax.reload();
				remainingCoursesTable.ajax.reload();
				updatedAt.textContent = "Μόλις τώρα";
			})
			.catch( (err) => {
				toastAlert( 'error', "Παρουσιάστηκε κάποιο πρόβλημα ..." );
			})
		}

		function removeCourses( courseIds ) {
			
			axios.patch( "/bundles/remove-courses", {
				bundleId,
				courseIds
			})
			.then( (res) => {

				let message = courseIds.length == 1 ? "1 course Αφαιρέθηκε" : `${courseIds.length} courses αφαιρέθηκαν`;
				toastAlert( 'success', message );

				bundleCoursesTable.ajax.reload();
				remainingCoursesTable.ajax.reload();
				updatedAt.textContent = "Μόλις τώρα";
			})
			.catch( (err) => {
				toastAlert( 'error', "Παρουσιάστηκε κάποιο πρόβλημα ..." );
			})
		}

		function toastAlert( icon, message ) {
			Swal.fire({
					toast: 'true',
					position: 'top-end',
					icon: icon,
					title: message,
					showConfirmButton: false,
					timer: 3000,
  					timerProgressBar: true
				});
		}
	</script>
@endsection