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
	            <div class="modal-body">
	                <table id="remaining-materials-table" class="table w-100 nowrap modal-table">
						<thead>
							<tr>
								<th>Όνομα</th>
								<th style="display: none;"></th>
							</tr>
						</thead>
						<tbody class="tables-hover-effect">
							@foreach ($allRemainingMaterials as $material)
								<tr>
									<td>{{ $material['name'] }}</td>
									<td class="d-flex">
										<button type="button" class="btn btn-primary ml-auto">Προσθήκη</button>
									</td>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>Όνομα</th>
								<th></th>
							</tr>
						</tfoot>
					</table>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
	                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
	            </div>
	        </div><!-- /.modal-content -->
	    </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div class="row">
		<div class="col-xl-4 col-lg-5">
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
							<span class="ml-2 ">
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

			<!-- Material Timeline -->
			<div class="card">
				<div class="card-body">
					<h5 class="text-uppercase"><i class="mdi mdi-briefcase mr-1"></i>Μαθήματα</h5>
					<div class="timeline-alt pb-0">

						@foreach ($materials as $material)
							<div class="timeline-item">
								<i class="mdi mdi-circle bg-primary-lighten text-primary timeline-icon"></i>
								<div class="timeline-item-info">
								<h5 class="mt-0 mb-1">{{ $material['name'] }}</h5>
									<p class="font-14">
										Τελευταία Ανανέωση
										<span class="ml-2 font-12">
											{{ $material['updated_at'] }}
										</span>
									</p>
									<p class="text-muted mt-2 mb-0 pb-3">
										{{ $material['small_description'] }}
									</p>
								</div>
							</div>
							<div class="timeline-item pb-4">
								<i class="mdi mdi-circle bg-info-lighten text-info timeline-icon"></i>
								<div class="timeline-item-info">
									<h5 class="mt-0 mb-1">Προσθήκη Υλικού</h5>
								</div>
							</div>
						@endforeach

					</div><!-- end timeline -->
				</div> <!-- end card-body-->
			</div> <!-- end material timeline -->
		</div> <!-- end col-->

		<div class="col-xl-8 col-lg-7">
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
						<div class="tab-pane show active" id="materials">

							<table id="course-materials-list" data-course-id="{{ $course['id'] }}" class="table w-100 nowrap custom-center-table center-not-second js-remove-table-classes">
								<thead>
									<tr>
										<th class="text-center">Επιλογή</th>
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
										<th>Επιλογή</th>
										<th>Όνομα</th>
										<th>Ενεργό</th>
										<th>Κατάταξη</th>
										<th>Τύπος</th>
										<th>Τελ. Ανανέωση</th>
										<th>Ημ. Δημιουργίας</th>
									</tr>
								</tfoot>
							</table>

							<div class="row mt-3">
								<div class="col-sm-4">
								</div>
								<div class="col-sm-8">
									<div class="text-sm-right">
										<button id="material-modal-shown-btn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#primary-header-modal">
											<i class="mdi mdi-plus-circle mr-2"></i>
											Προσθήκη Μαθημάτων
										</button>
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

	<script>
		//! GLOBAL VARIABLES
		const courseId = $("#course-materials-list")[0].dataset.courseId
		const authors = $('.js-authors');

		if ( authors.length > 3 ) {
			for ( let i = 3; i < authors.length; i++ ) {
				authors[i].classList.add('d-none');
			}

			const moreAuthors = $('#more-authors')[0];
			moreAuthors.classList.remove("d-none");
		}

		$('#more-authors').click( function() {

			if ( this.dataset.shown == "true") {
				this.dataset.shown = "false";
				for ( let i = 3; i < authors.length; i++ ) {
					authors[i].classList.add('d-none');
				}
				this.textContent = "Περισσότερα ..."
			}
			else {
				this.textContent = "Λιγότερα ..."
				this.dataset.shown = "true";
				for ( let i = 3; i < authors.length; i++ ) {
					authors[i].classList.remove('d-none');
				}
			}
		});

		const courseMaterialsTable = $("#course-materials-list").DataTable({
			scrollX:!0,
			columnDefs: [
				{ width: "5%", "targets": 0 },
				{ className: "js-link cursor-pointer", targets: [ 1, 4, 6 ] },
				{ className: "js-link cursor-pointer", targets: 5 },
				{ width: "5%", targets: 3 }
			],
			order: [3, "asc"],
			processing: true,
			serverSide: true,
			ajax: {
				url: "/api/courses/course-materials-datatable",
				type: "post",
				data: {
					courseId: courseId
				}
			},
			columns: [
				{data: 'action', name: 'action', orderable: false},
				{data: 'name', name: 'name'},
				{data: 'active', name: 'active'},
				{data: 'priority', name: 'priority', searchable: false},
				{data: 'type', name: 'type'},
				{data: 'updated_at', name: 'updated_at'},
				{data: 'created_at', name: 'created_at'},
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

				toggleCourseMaterial()
				sortInputsInit();
			},
			
		});
		const remainingMaterialsTables = $("#remaining-materials-table").DataTable({
			scrollX:!0,
			columnDefs: [
				{ "width": "5%", "targets": 1 }
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
			},
			
		});

		/* $('#material-modal-shown-btn').click( function() {
			setTimeout( function() { remainingMaterialsTables.columns.adjust(); }, 200)
		}); */

		function sortInputsInit() {

			$('.js-sort-input').unbind();

			$('.js-sort-input').on( "input", function() {

				let inputValue = this.value;

				if ( isNaN( inputValue ) ) {
					return this.value = inputValue.replace(/[^0-9]/g, '');
				}

			});

			$('.js-sort-input').on('keyup', function() {

				if ( event.keyCode == 13 && !isNaN( this.value) ) {
					axios.patch('/api/courses/priority', {
						courseId: $('#course-materials-list')[0].dataset.courseId,
						materialId: this.dataset.materialId,
						priority: { 
							new: this.value, 
							old: this.dataset.currentPriority
						},
					})
					.then( (res) => {
						courseMaterialsTable.ajax.reload();
					})
				}

			})
		}

		function toggleCourseMaterial() {
		$('.js-toggle').unbind();

		$('.js-toggle').on('change', function() {
			let courseCnt = this.parentElement.parentElement;
			let updatedAtElm = courseCnt.getElementsByClassName("js-updated-at")[0];

			axios.patch('/api/courses/toggle-materials', {
				courseId: this.dataset.courseId,
				materialId: this.dataset.materialId,
				state: this.checked
			})
			.then( (res) => {
				Swal.fire({
					toast: 'true',
					position: 'top-end',
					icon: 'success',
					title: this.checked ? "Ενεργοποιήθηκε" : "Απενεργοποιήθηκε",
					showConfirmButton: false,
					timer: 3000,
  					timerProgressBar: true
				});
				// updatedAtElm.textContent = "Μόλις τώρα";
			})
			.catch( (err) => {
				Swal.fire({
					toast: 'true',
					position: 'top-end',
					icon: 'error',
					title: "Παρουσιάστηκε κάποιο πρόβλημα ...",
					showConfirmButton: false,
					timer: 3000,
  					timerProgressBar: true
				});
			});
		});
	}

	</script>
@endsection