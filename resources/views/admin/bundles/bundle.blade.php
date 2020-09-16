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
			background-color: #343a40;
			position: sticky;
			top: 70px;
			z-index: 1010;
		}
	</style>
@endsection

@section('content')
	<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box">
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="/" class="custom-link-primary">Home</a></li>
						<li class="breadcrumb-item"><a href="/dashboard" class="custom-link-primary">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="/dashboard/bundles" class="custom-link-primary">Bundles</a></li>
						<li class="breadcrumb-item active">{{ isset($bundle) ? $bundle->title : "Νέο Bundle" }}</li>
					</ol>
				</div>
				<h4 id="bundle-title" class="page-title" data-bundle-id="{{ isset($bundle) ? $bundle['id'] : 1 }}">{{ isset($bundle) ? $bundle->title : "Νέο Bundle" }}</h4>
			</div>
		</div>
	</div>     
	<!-- end page title -->

	@isset($bundle)
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
								<div id="gallery-content" data-model="App\Bundle" data-id={{ $bundle->id }}>	
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

	<div id="remaining-courses-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="remaining-courses-modalLabel" aria-hidden="true">
	    <div class="modal-dialog modal-xl">
	        <div class="modal-content">
	            <div class="modal-header modal-colored-header bg-primary">
	                <h4 class="modal-title" id="remaining-courses-modalLabel">Προσθήκη Course</h4>
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	            </div>
	            <div class="modal-body table-cnt">
	                <table id="remaining-courses-table" class="table w-100 nowrap modal-table px-3 js-remove-table-classes">
						<thead>
							<tr>
								<th class="select-all w-5">
									<div class='icheck-primary d-inline'>
										<input class='js-courses-checkbox' type='checkbox' id='all-courses-checkbox' autocomplete='off'>
										<label for='all-courses-checkbox'></label>
									</div>
								</th>
								<th class="text-center">Όνομα</th>
								<th class="text-center">Εισηγητής</th>
								<th class="text-center">Topics</th>
								<th class="text-center">Έκδοση</th>
								<th class="text-center w-5"></th>
							</tr>
						</thead>
						<tbody class="tables-hover-effect"></tbody>
						<tfoot>
							<tr>
								<th class="text-center"></th>
								<th class="text-center">Όνομα</th>
								<th class="text-center">Εισηγητής</th>
								<th class="text-center">Topics</th>
								<th class="text-center">Έκδοση</th>
								<th class="text-center"></th>
							</tr>
						</tfoot>
					</table>
	            </div>
	            <div class="modal-footer">
	                <button id="add-courses-btn" type="button" data-text="Προσθήκη Επιλογών" data-enabled-color="btn-primary" class="btn btn-secondary" disabled>Προσθήκη Επιλογών (0)</button>
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
							<a href="#settings" data-toggle="tab" aria-expanded="false"
								 class="nav-link active">
								Ρυθμίσεις
							</a>
						</li>
						<li class="nav-item">
							<a href="#courses" data-toggle="tab"
								aria-expanded="true" class="nav-link {{ isset($bundle) ? "" : "tab-link text-muted" }}"
							>
								Courses
							</a>
						</li>
						<li class="nav-item">
							<a href="#users" data-toggle="tab" 
								aria-expanded="true" class="nav-link {{ isset($bundle) ? "" : "text-muted" }}"
							>
								Χρήστες
							</a>
						</li>
					</ul> <!-- end nav-->

					<div class="tab-content">

						<div id="settings" class="tab-pane show active">
							<form id="bundle-edit-form"
								action="{{ isset($bundle) ? route('bundle.update', $bundle->slug) : "/dashboard/bundle/store" }}"
								method="POST" enctype="multipart/form-data" autocomplete="off">
								
								@csrf

								@if ( isset($bundle) )
									@method('PATCH')
								@endif
								
								<div class="row">
							        <div class="col-xl-6">
							            <div class="form-group">
							                <label for="name">Τίτλος</label>
											<input type="text" class="form-control @error('title') is-invalid @enderror" 
												id="name" name="title" 
												value="{{ old('title') != "" ? old('title') : ( isset($bundle) ? $bundle['title'] : "" ) }}"
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
							                <label for="subtitle-input">Υπότιτλος</label>
											<div class="input-group">
											    <div class="custom-file">
													<input class="form-control @error('subtitle') is-invalid @enderror"
														name="subtitle" id="subtitle-input" type="text" placeholder="Εισάγετε υπότιτλο..."
														value="{{ old('subtitle') != "" ? old('subtitle') 
															: ( isset($bundle) ? $bundle['subtitle'] : "" )
														}}"
													>
												</div>
												@error('subtitle')
													<span class="invalid-feedback d-block" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
							            </div>
							        </div> <!-- end col -->
							    </div> <!-- end row -->

								@isset($bundle)
									<div class="row">
							    	    <div class="col-12">
							    	        <div class="form-group">
							    	            <label for="summary">Σύνοψη</label>
												<textarea class="form-control @error('summary') is-invalid @enderror"
													id="summary" name="summary" rows="4" placeholder="Σύνοψη Bundle..."
												>{{ old('summary') != "" ? old('summary') 
													: ( isset($bundle) ? $bundle['summary'] : "" )
												}}</textarea>
												@error('summary')
                            					    <span class="invalid-feedback" role="alert">
                            					        <strong>{{ $message }}</strong>
                            					    </span>
                            					@enderror
											</div>
							    	    </div> <!-- end col -->
							    	</div> <!-- end row -->

							    	<div class="row">
							    	    <div class="col-12">
							    	        <div class="form-group">
							    	            <label for="description">Περιγραφή</label>
												<textarea class="form-control @error('description') is-invalid @enderror"
													id="description" name="description" rows="4" placeholder="Περιγραφή Bundle..."
												>{{ old('description') != "" ? old('description')
													: ( isset($bundle) ? $bundle['description'] : "")
												}}</textarea>
												@error('description')
                            					    <span class="invalid-feedback" role="alert">
                            					        <strong>{{ $message }}</strong>
                            					    </span>
                            					@enderror
											</div>
							    	    </div> <!-- end col -->
									</div> <!-- end row -->
								@endisset


							</form>

						</div><!-- settings tab-pane -->

						<!-- Courses table tab -->
						<div class="tab-pane table-cnt" id="courses">

							<div class="row my-3">
								<div class="col-sm-1">
								</div>
								<div class="col-sm-11 d-flex justify-content-end">
									<button id="course-modal-shown-btn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#remaining-courses-modal">
										<i class="mdi mdi-plus-circle mr-2"></i>
										Προσθήκη Course
									</button>
									<div class="dropdown ml-2">
										<button id="courses-bulk" class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" disabled>
											Επιλογές (0)
										</button>
										<div class="dropdown-menu dropdown-menu-right" aria-labelledby="courses-bulk">
											<a id="remove-selected-courses-btn" class="dropdown-item" href="#">Αφαίρεση επιλογών</a>
										</div>
									</div>
								</div>
							</div>

							<table id="bundle-courses-list" class="table w-100 nowrap center-not-second js-remove-table-classes js-table">
								<thead>
									<tr>
										<th class="text-center">
											<div class='icheck-primary d-inline'>
												<input type='checkbox' id='main-active-courses-checkbox' autocomplete='off'>
												<label for='main-active-courses-checkbox'></label>
											</div>
										</th>
										<th class="text-center">Όνομα</th>
										<th class="text-center">Εισηγητής</th>
										<th class="text-center">Topics</th>
										<th class="text-center">Έκδοση</th>
										<th class="text-center">Τελ. Ανανέωση</th>
										<th class="text-center">Ημ. Δημιουργίας</th>
									</tr>
								</thead>
								<tbody class="tables-hover-effect"></tbody>
								<tfoot>
									<tr>
										<th class="text-center"></th>
										<th class="text-center">Όνομα</th>
										<th class="text-center">Εισηγητής</th>
										<th class="text-center">Topics</th>
										<th class="text-center">Έκδοση</th>
										<th class="text-center">Τελ. Ανανέωση</th>
										<th class="text-center">Ημ. Δημιουργίας</th>
									</tr>
								</tfoot>
							</table>

						</div><!-- end Courses tab-pane -->

						<!-- Users table tab -->
						<div id="users" class="tab-pane table-cnt">

							













							<div class="row my-3">
								<div class="col-sm-1">
								</div>
								<div class="col-sm-11 d-flex justify-content-end">
									<button id="users-modal-shown-btn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#remaining-users-modal">
										<i class="mdi mdi-plus-circle mr-2"></i>
										Προσθήκη Χρηστών
									</button>
									<div class="dropdown ml-2">
										<button id="users-bulk" class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" disabled>
											Επιλογές (0)
										</button>
										<div class="dropdown-menu dropdown-menu-right" aria-labelledby="users-bulk">
											<a id="remove-selected-users-btn" class="dropdown-item" href="#">Αφαίρεση επιλογών</a>
										</div>
									</div>
								</div>
							</div>

							<table id="bundle-users-table" class="table w-100 nowrap center-not-second js-remove-table-classes js-table">
								<thead>
									<tr>
										<th class="text-center">
											<div class='icheck-primary d-inline'>
												<input type='checkbox' id='main-active-users-checkbox' autocomplete='off'>
												<label for='main-active-users-checkbox'></label>
											</div>
										</th>
										<th class="text-center">Επώνυμο</th>
										<th class="text-center">Όνομα</th>
										<th class="text-center"></th>
									</tr>
								</thead>
								<tbody class="tables-hover-effect"></tbody>
								<tfoot>
									<tr>
										<th class="text-center"></th>
										<th class="text-center">Επώνυμο</th>
										<th class="text-center">Όνομα</th>
										<th class="text-center"></th>
									</tr>
								</tfoot>
							</table>
















						</div>
					</div>
					
				</div>
				
				<div class="col-xl-3 col-lg-5 col-md-12">

					<div class="sticky py-3">
					<button form="bundle-edit-form" type="submit"
						id="update-btn" class="btn btn-primary"
					>
						{{ isset($bunle) ? "Ενημέρωση" : "Αποθήκευση" }}
					</button>
						
						@if ( isset($bundle) )	
							<a id="preview-btn" href="#" class="under-development btn btn-warning"><i class="mdi mdi-eye"></i></a>
							<button id="bundle-delete-btn" class="btn btn-danger float-right">Διαγραφή</button>
						@endif
					</div>

					<div class="card">
						<div class="card-body">
							<hr>
							<div class="form-group">
								<label for="publish-date-select">Δημοσίευση απο:</label>
								<input form="bundle-edit-form" type="text" class="form-control" id="publish-date-select" name="publishDate" value="{{ $publish }}" placeholder="Εισάγετε ημερομηνία..." data-toggle="input-mask" data-mask-format="00-00-0000 00:00:00" autocomplete="off">
							</div>
							<hr>
						</div>
					</div>

					@if ( isset($bundle) )	
						<!-- Cover Preview -->
						<div class="card">
							<div class="card-header">
								<h4 class="card-title mb-0">Cover</h4>

							</div>
							<div class="card-body">
								<img id="cover-image" src="{{ url($bundle->cover) }}" class="img-fluid" alt="{{ $bundle->title }}">
							
								<button id="change-cover-btn" class="btn btn-primary btn-block mt-3">Αλλαγή Cover</button>
							</div> <!-- end card-body -->


						</div> <!-- end course info card -->

						<form id="delete-bundle-form" action="{{ $bundle->id }}" method="POST">
		
							@csrf
							@method('DELETE')
					
						</form>

					@endif

				</div><!-- ./col -->

			</div><!-- ./row -->
		</div><!-- ./content -->
	</div><!-- wrapper -->

	{{-- @isset($bundle) --}}
		<select id="add-course-topic-filter" class="ml-1 select2 form-control">
			<option value="" selected>Όλα τα Topic</option>
			@foreach ($topics as $topic)
				<option value="{{ $topic->title }}">{{ $topic->title }}</option>
			@endforeach
		</select>

		<select id="topic-filter" class="ml-1 select2 form-control">
			<option value="" selected>Όλα τα Topic</option>
			@foreach ($topics as $topic)
				<option value="{{ $topic->title }}">{{ $topic->title }}</option>
			@endforeach
		</select>
	{{-- @endisset --}}
	

@endsection

@section('scripts')
<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>

<script src="{{ mix('js/dashboard/bundles/bundleProfile.js') }}"></script>
@endsection