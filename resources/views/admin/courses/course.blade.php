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
		z-index: 1000;
	}
	.circle-icon {
		padding: 0.2rem 0.2rem;
	}
	.custom-accordion-title {
		color:#b2bcc5;
	}

	#course-materials-list_length > label > span:last-child {
		margin-right: 2px;
	}

</style>
@endsection

@section('content')

	<!-- sections additionnal content modal -->
	<div class="modal fade" id="sections-additions-modal" tabindex="-1" aria-labelledby="sections-additions-modalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			  <div class="modal-content">
				<div class="modal-header modal-colored-header bg-primary">
					<h5 class="modal-title" id="sections-additions-modalLabel">Προσθήκη Υλικού</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row px-3">
						<div class="col-4">
							<div class="js-section-material card cursor-pointer" data-type="Announcement">
								<div class="card-body card-hover d-flex flex-column align-items-center">
									<i class="mdi mdi-comment-quote-outline display-3"></i>
									<h5 class="card-title mt-2">Ανακοίνωση</h5>
								</div>
							</div>
						</div>
						<div class="col-4">
							<div class="js-section-material card cursor-pointer" data-type="Link">
								<div class="card-body card-hover d-flex flex-column align-items-center">
									<i class="mdi mdi-link-variant-plus	display-3"></i>
									<h5 class="card-title mt-2">Link</h5>
								</div>
							</div>
						</div>
						<div class="col-4">
							<div class="js-section-material card cursor-pointer" data-type="Video">
								<div class="card-body card-hover d-flex flex-column align-items-center">
									<i class="uil uil-film display-3"></i>
									<h5 class="card-title mt-2">Video</h5>
								</div>
							</div>
						</div>
					</div>
					<div class="row px-3">
						<div class="col-6">
							<div id="section-new-pdf-material" class="card cursor-pointer">
								<div class="card-body card-hover d-flex flex-column align-items-center">
									<i class="mdi mdi-file-pdf-outline	display-3"></i>
									<h5 class="card-title mt-2">PDF</h5>
								</div>
							</div>
						</div>
						<div class="col-6">
							<div id="section-chapter-btn" class="card cursor-pointer">
								<div class="card-body card-hover d-flex flex-column align-items-center">
									<i class="mdi mdi-file-document-outline	display-3"></i>
									<h5 class="card-title mt-2">Μάθημα</h5>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">Έξοδος</button>
				</div>
			</div>
		</div>
	</div><!-- ./additionnal content modal -->

	<div class="modal fade" id="remainings-files-modal" tabindex="-1" role="dialog"
		 aria-labelledby="remainings-files-modalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header modal-colored-header bg-primary">
					<h5 class="modal-title" id="remainings-files-modalLabel">File Library</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<table id="remaining-files-datatable"
						   class="table w-100 nowrap center-not-second modal-table js-remove-table-classes">
						<thead>
						<tr>
							<th class="text-center">Όνομα</th>
							<th class="text-center">Μέγεθος</th>
							<th class="text-center w-5"></th>
						</tr>
						</thead>
						<tbody class="tables-hover-effect"></tbody>
						<tfoot>
						<tr>
							<th class="text-center">Όνομα</th>
							<th class="text-center">Μέγεθος</th>
							<th class="text-center"></th>
						</tr>
						</tfoot>
					</table>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">Έξοδος</button>
				</div>
			</div>
		</div>
	</div>

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
							<div id="gallery-content" data-model="App\Models\Course" data-id={{ isset($course) ? $course->id : "" }}>
								@include('components.admin.imageGallery', ['media' => $media])
							</div>
						</div>

						<div id="upload" class="tab-pane">

							<input id="file-pond" class="js-filepond-file-dragging mb-0" type="file[]"/>
							<p class="text-right mb-2">
								<small>
									<strong>
										Το πεδίο δέχεται αρχεία: .jpg, .png.
									</strong>
								</small>
							</p>

						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">Έξοδος</button>
				</div>
			</div>
		</div>
	</div>

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

	<!-- additionnal content modal -->
	<div class="modal fade" id="add-additions-modal" tabindex="-1" aria-labelledby="add-additions-modalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			  <div class="modal-content">
				<div class="modal-header modal-colored-header bg-primary">
					<h5 class="modal-title" id="add-additions-modalLabel">Προσθήκη Υλικού</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<div class="row px-3">
						<div class="col-4">
							<div class="card cursor-pointer js-material" data-type="Announcement">
								<div class="card-body card-hover d-flex flex-column align-items-center">
									<i class="mdi mdi-comment-quote-outline display-3"></i>
									<h5 class="card-title mt-2">Ανακοίνωση</h5>
								</div>
							</div>
						</div>
						<div class="col-4">
							<div class="card cursor-pointer js-material" data-type="Link">
								<div class="card-body card-hover d-flex flex-column align-items-center">
									<i class="mdi mdi-link-variant-plus	display-3"></i>
									<h5 class="card-title mt-2">Link</h5>
								</div>
							</div>
						</div>
						<div class="col-4">
							<div class="card cursor-pointer js-material" data-type="Video">
								<div class="card-body card-hover d-flex flex-column align-items-center">
									<i class="uil uil-film display-3"></i>
									<h5 class="card-title mt-2">Video</h5>
								</div>
							</div>
						</div>
					</div>

					<div class="row px-3">

						<div class="col-4">
							<div class="card cursor-pointer js-material" data-type="Section">
								<div class="card-body card-hover d-flex flex-column align-items-center">
									<i class="mdi mdi-puzzle-outline display-3"></i>
									<h5 class="card-title mt-2">Section</h5>
								</div>
							</div>
						</div>
						<div class="col-4">
							<div id="add-new-material-btn" class="card cursor-pointer">
								<div class="card-body card-hover d-flex flex-column align-items-center">
									<i class="mdi mdi-file-document-outline	display-3"></i>
									<h5 class="card-title mt-2">Μάθημα</h5>
								</div>
							</div>
						</div>
						<div class="col-4">
							<div id="add-new-pdf-material-main" class="card cursor-pointer">
								<div class="card-body card-hover d-flex flex-column align-items-center">
									<i class="mdi mdi-file-pdf-outline display-3"></i>
									<h5 class="card-title mt-2">PDF</h5>
								</div>
							</div>
						</div>

					</div>


				</div>
				<input id="store-material-id" type="text" value="" hidden autocomplete="off"/>
				<input id="store-material-priority" type="text" value="" hidden autocomplete="off"/>
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">Έξοδος</button>
				</div>
			</div>
		</div>
	</div><!-- ./additionnal content modal -->

	@can('create', App\Models\Course::class)
		<!-- add users modal -->
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
									<th class="text-center">Ονοματεπώνυμο</th>
									<th class="text-center">Email</th>
									<th class="text-center">Τηλεφωνο</th>
									<th class="text-center">Ιδιότητα</th>
									<th class="text-center"></th>
								</tr>
							</thead>
							<tbody class="tables-hover-effect table-text-center table-vertical-align-middle"></tbody>
							<tfoot>
								<tr>
									<th class="text-center"></th>
									<th class="text-center">Ονοματεπώνυμο</th>
									<th class="text-center">Email</th>
									<th class="text-center">Τηλεφωνο</th>
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
						<button type="button" class="btn btn-light" data-dismiss="modal">Έξοδος</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- ./add users modal -->
	@endcan
	<!-- add materials modal -->
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
								<th class="text-center">Τύπος</th>
								<th class="text-center"></th>
							</tr>
						</thead>
						<tbody class="tables-hover-effect"></tbody>
						<tfoot>
							<tr>
								<th class="text-center">Επιλογή</th>
								<th class="text-center">Τίτλος</th>
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
	</div><!-- ./add materials modal -->

	<div class="wrapper">
		<div class="content">

			<!-- tabs -->
			<ul class="nav nav-tabs nav-bordered mb-3">
				<li class="nav-item">
					<a href="#settings" id="setting-tab-btn"
						data-toggle="tab" aria-expanded="false"
						class="nav-link active">
						Γενικά
					</a>
				</li>
				<li class="nav-item">
					<a href="#materials" id="materials-tab-btn" class="nav-link"
						data-toggle="tab" aria-expanded="true">
						Υλικό
					</a>
				</li>
				@can('create', App\Models\Course::class)
					<li class="nav-item">
						<a href="#users" id="users-tab-btn" class="nav-link"
							data-toggle="tab" aria-expanded="true"
							>
							Χρήστες
						</a>
					</li>
				@endcan
				<li class="nav-item">
					<a href="#sections" id="sections-tab-btn" class="nav-link"
						data-toggle="tab" aria-expanded="true">
						Sections
					</a>
				</li>
				<li class="nav-item">
					<a href="#media-tab" id="sections-tab-btn" class="nav-link"
						data-toggle="tab" aria-expanded="true">
						Media
					</a>
				</li>
			</ul><!-- ./tabs -->

			<div class="tab-content">

				<div id="settings" class="tab-pane mb-3 show active">
					<div class="row">
						<div class="col-xl-9 col-lg-7 col-md-12">
							<form id="edit-course-form" action="{{ "/dashboard/courses/$course->slug" }}"
								method="POST" enctype="multipart/form-data" autocomplete="off">

								@csrf

								@method('PATCH')

								<div class="form-row">
									<div class="form-group col-lg-6">
										<label for="title">Τίτλος <span class="text-danger">*</span></label>
										<input id="title" type="text" name="title"
											class="form-control @error('title') is-invalid @enderror"
											value="{{ old('title', $course->title) }}"
											placeholder="Εισάγετε τίτλο...">
										@error('title')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>
									<div class="form-group col-lg-6">
										<label for="subtitle">Υπότιτλος</label>
										<input id="subtitle" class="form-control @error('subtitle') is-invalid @enderror"
											name="subtitle" type="text" value="{{ old('subtitle', $course->subtitle) }}"
											placeholder="Εισάγετε υπότιτλο...">
										@error('subtitle')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>
								</div>

								<div class="form-group">
									<div class="d-flex justify-content-between">
										<label for="summary-toggle">Σύνοψη</label>
										<input id="summary-toggle" class="js-editors-toggle"
											data-field="summary" type="checkbox" data-switch="success"
											@if ( isset($fields->summary) && $fields->summary == 1)
												checked
											@endif
										/>
										<label class="mb-0" for="summary-toggle" data-on-label="On" data-off-label="Off"></label>
									</div>

									<textarea class="form-control @error('summary') is-invalid @enderror"
										id="summary" name="summary" rows="4"
										placeholder="Εισάγετε σύνοψη..."
										>{{ old('summary', $course->summary) }}</textarea>
									@error('summary')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>

								<div class="form-group">
									<div class="d-flex justify-content-between">

										<label for="description">Περιγραφή</label>
										<input id="description-toggle" class="js-editors-toggle"
											data-field="description" type="checkbox" data-switch="success"
											@if ( isset($fields->description) && $fields->description == 1)
												checked
											@endif
										/>
										<label class="mb-0" for="description-toggle" data-on-label="On" data-off-label="Off"></label>

									</div>
									<textarea class="form-control @error('description') is-invalid @enderror"
										id="description" name="description" rows="4" placeholder="Εισάγετε περιγραφή..."
										>{{ old('description', $course->description) }}</textarea>
									@error('description')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
								<textarea id="script-area" name="script" hidden>{{ old("script", $course->script) }}</textarea>
							</form>

							<div class="d-flex justify-content-between">
								<label>Script</label>
								<input id="script-toggle" class="js-editors-toggle"
									data-field="script" type="checkbox" data-switch="success"
									@if ( isset($fields->script) && $fields->script == 1)
										checked
									@endif
								/>
								<label class="mb-0" for="script-toggle" data-on-label="On" data-off-label="Off"></label>
							</div>
							<div id="editor"></div>

						</div>
						<div class="col-xl-3 col-lg-5 col-md-12 pt-1">

							<div class="sticky py-3">
								@php
									if ( $course->status == 1 ) {
										if ( time() > strtotime($course->publish_at) && !is_null($course->publish_at) ) {
											$tooltip = [
												"color" => "bg-success",
												"icon" => "<i class='h2 mdi mdi-cloud'></i>",
												"text" => "Published"
											];
											$storeBtn = [ "color" => "btn-info", "text" => "Update"];
										}
										else {
											$tooltip = [
												"color" => "bg-info",
												"icon" => "<i class='mdi mdi-24px mdi-clock-outline'></i>",
												"text" => "Scheduled"
											];
											$storeBtn = [ "color" => "btn-primary", "text" => "Save"];
										}
										$publishBtn = [
											"color" => "btn-light",
											"text" => "Set Draft",
											"value" => 0
										];
									}
									else {
										$tooltip = [
											"color" => "bg-light",
											"icon" => "<i class='h2 mdi mdi-cloud'></i>",
											"text" => "Draft"
										];
										$storeBtn = [ "color" => "btn-primary", "text" => "Save"];
										$publishBtn = [
											"color" => "btn-danger",
											"text" => "Publish",
											"value" => 1
										];
									}
								@endphp

								<span id="status-icon"
									class=" px-1 pointer-default circle-icon btn-sm btn {{ $tooltip['color'] }} text-white rounded-circle"
									data-toggle="tooltip" data-placement="bottom" title="{{ $tooltip['text'] }}">
									{!! $tooltip['icon'] !!}
								</span>

								<button form="edit-course-form" type="submit"
									class="btn {{ $storeBtn['color'] }}" name="save" value="save">
									{{ $storeBtn['text'] }}
								</button>

								<button form="edit-course-form" type="submit" class="btn {{ $publishBtn['color'] }}"
									name="publish" value="{{ $publishBtn['value'] }}">
									{{ $publishBtn['text'] }}
								</button>

								<a id="preview-btn"
									href="/home/course/{{ $course->slug }}"
									class="btn btn-warning" target="_blank">
									<i class="mdi mdi-eye"></i>
								</a>

							</div>

							<div class="card">
								<div class="card-body">
									<div class="form-group">

										<label for="version-select">Έκδοση <span class="text-danger">*</span></label>
										<select form="edit-course-form" id="version-select" name="version"
											class="custom-select2-warning select2 form-control
											@error('version') is-invalid @enderror">

											<option value="Normal" {{ old('version', $course->version) === "Normal" ? "selected" : ""}}>Normal</option>
											<option value="Trial" {{ old('version', $course->version) === "Trial" ? "selected" : ""}}>Trial</option>

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
										<select form="edit-course-form" id="topics-select"
											class="form-control" name="topics[]" multiple="multiple"
											placeholder="Επιλέξτε Topics...">

											@foreach ($topics as $topic)

												@if ( old("topics") != "" && in_array($topic->id, old("topics")) )
													<option value="{{ $topic->id }}" selected>
														{{ $topic->title }}
													</option>
												@elseif ( old("topics") == "" && in_array($topic->id, $courseTopics) )
													<option value="{{ $topic->id }}" selected>
														{{ $topic->title }}
													</option>
												@else
													<option value="{{ $topic->id }}">
														{{ $topic->title }}
													</option>
												@endif

											@endforeach

										</select>
									</div>

									<hr>
									<label for="curator">Κύριος Εισηγητής</label>
									<select id="curator" form="edit-course-form"
										class="form-control" name="curator" data-width="100%"
										data-toggle="select2" data-placeholder="Επιλέξτε Εισηγητή...">
										@foreach ($instructors as $instructor)

											@if ( old("curator") != "" && old("curator") == $instructor->id )
												<option value="{{ $instructor->id }}" selected>
													{{ $instructor->fullName }}
												</option>
											@elseif ( old("curator", $course->user_id) == $instructor->id )
												<option value="{{ $instructor->id }}" selected>
													{{ $instructor->fullName }}
												</option>
											@else
												<option value="{{ $instructor->id }}">
													{{ $instructor->fullName }}
												</option>
											@endif

										@endforeach
									</select>
									<hr>

									<div class="form-group mb-0">
										<label for="publish-date-select">Published</label>
										<input form="edit-course-form" type="text" class="form-control"
											id="publish-date-select" name="publishDate"
											value="{{ old("publishDate", $publish) }}"
											placeholder="Εισάγετε ημερομηνία..." data-toggle="input-mask"
											data-mask-format="00-00-0000 00:00:00" autocomplete="off" />
									</div>
									<hr>
									<div class="form-group mb-0">
										<label for="version-select">Template</label>
										<select form="edit-course-form" id="template-select" name="template" data-toggle="select2"
											class="custom-select2-warning form-control @error('template') is-invalid @enderror"
											data-minimum-results-for-search="-1" data-width="100%" autocomplete="off">
											@foreach ($templates as $key => $template)
												<option value="{{ $template->views->frontend }}"
												{{ old("template", $course->template) === $template->views->frontend ? "selected" : ""}}>{{ $template->title }}</option>
											@endforeach
										</select>
									</div>

								</div>
							</div>



						</div>
					</div>
				</div><!-- settings tab-pane -->

				<div id="materials" class="tab-pane table-cnt mb-3">

					<div class="row my-3">
						<div class="col-sm-1">
						</div>
						<div class="col-sm-11 d-flex justify-content-end">

							<div class="dropdown">
								<button type="button" class="btn btn-primary dropdown-toggle"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="mdi mdi-plus-circle mr-2"></i>
									Προσθήκη
								</button>

								<div class="dropdown-menu dropdown-menu-animated dropdown-menu-right py-0">
									<div class="dropdown-divider my-0"></div>
									<a id="material-modal-shown-btn" href="#" class="dropdown-item py-2"
										data-toggle="modal" data-target="#add-materials-modal"
										data-chapter="main">
										<i class="mdi mdi-archive mr-2"></i>
											Απο το αρχείο
										</a>
									<div class="dropdown-divider my-0"></div>
									<a id="new-content-btn" href="#" class="dropdown-item py-2"
										data-toggle="modal" data-target="#add-additions-modal">
										<i class="mdi mdi-content-save mr-2"></i>
										Νέο Υλικό
									</a>
								</div>
							</div>

							<div id="active-material-bulk-cnt" class="dropdown ml-2">
								<button id="active-material-bulk" class="btn btn-secondary dropdown-toggle"
									data-toggle="dropdown" data-text="Επιλογές"
									aria-haspopup="true" aria-expanded="false" disabled>
									Επιλογές (0)
								</button>
								<div class="dropdown-menu dropdown-menu-animated dropdown-menu-right py-0" aria-labelledby="dropdownMenuButton">

									<a id="remove-selection-btn" class="dropdown-item py-2" href="#">Αφαίρεση επιλογών</a>

									<div class="dropdown-divider my-0"></div>

									<div class="btn-group dropleft dropleft-hover w-100">
										<a class="dropdown-toggle dropdown-item py-2 cursor-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Αλλαγή κατάστασης
										</a>
										<div class="dropdown-menu py-0">
											<a id="activate-selection" class="dropdown-item py-2" href="#">Ενεργοποιήση</a>
											<div class="dropdown-divider my-0"></div>
											<a id="deactivate-selection" class="dropdown-item py-2" href="#">Απενεργοποίηση</a>
										</div>
									</div>

									<div class="btn-group dropleft dropleft-hover w-100">
										<a class="dropdown-toggle dropdown-item py-2 cursor-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Μεταφορά σε Section
										</a>
										<div id="section-selection-dropdown" class="dropdown-menu py-0">

											<!-- content builds with ajax -->

										</div>
									</div>

								</div>
							</div>
						</div>
					</div>

					<table id="course-materials-list" data-course-id="{{ $course->id }}" data-course-slug="{{ $course->slug }}"
						class="table w-100 nowrap js-remove-table-classes js-table">
						<thead>
							<tr>
								<th class="text-center">
									<div class='icheck-primary d-inline'>
										<input type='checkbox' id='all-active-materials-checkbox' autocomplete='off'>
										<label for='all-active-materials-checkbox'></label>
									</div>
								</th>
								<th class="text-center">Τίτλος</th>
								<th class="text-center">Highlight</th>
								<th class="text-center">Κατάσταση</th>
								<th class="text-center">Κατάταξη</th>
								<th class="text-center">Τύπος</th>
								<th class="text-center">Publish</th>
								{{-- <th class="text-center">Ημ. Δημιουργίας</th>
								<th class="text-center">Ημ. Δημιουργίας</th> --}}
							</tr>
						</thead>
						<tbody></tbody>
						<tfoot>
							<tr>
								<th class="text-center"></th>
								<th class="text-center">Τίτλος</th>
								<th class="text-center">Highlight</th>
								<th class="text-center">Κατάσταση</th>
								<th class="text-center">Κατάταξη</th>
								<th class="text-center">Τύπος</th>
								<th class="text-center">Publish</th>
								{{-- <th class="text-center">Ημ. Δημιουργίας</th>
								<th class="text-center">Ημ. Δημιουργίας</th> --}}
							</tr>
						</tfoot>
					</table>

				</div><!-- materials tab-pane -->

				@can('create', App\Models\Course::class)
					<div id="users" class="tab-pane table-cnt mb-3">
						<div class="row my-3">
							<div class="col-sm-1">
							</div>
							<div class="col-sm-11 d-flex justify-content-end">
								<button id="material-modal-shown-btn" type="button"
									class="btn btn-primary" data-toggle="modal"
									data-target="#add-user-modal">
									<i class="mdi mdi-account-multiple-plus mr-2"></i>
									Προσθήκη Χρηστών
								</button>
								<div class="dropdown ml-2">
									<button class="btn btn-secondary dropdown-toggle"
										type="button" id="active-users-bulk" data-toggle="dropdown"
										aria-haspopup="true" aria-expanded="false" disabled>
										Επιλογές (0)
									</button>
									<div class="dropdown-menu dropdown-menu-animated dropdown-menu-right py-0" aria-labelledby="dropdownMenuButton">
										<a id="remove-selected-users-btn" class="dropdown-item py-2" href="#">Αφαίρεση επιλογών</a>
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
									<th class="text-center">Ονοματεπώνυμο</th>
									<th class="text-center">Ιδιότητα</th>
									<th class="text-center">Τηλεφωνο</th>
									<th class="text-center">Ημ. Εγγραφής</th>
								</tr>
							</thead>
							<tbody class="tables-hover-effect table-text-center"></tbody>
							<tfoot>
								<tr>
									<th class="text-center"></th>
									<th class="text-center">Ονοματεπώνυμο</th>
									<th class="text-center">Ιδιότητα</th>
									<th class="text-center">Τηλεφωνο</th>
									<th class="text-center">Ημ. Εγγραφής</th>
								</tr>
							</tfoot>
						</table>
					</div><!-- users tab-pane -->
				@endcan

				<div id="sections" class="tab-pane mb-3">
					<div class="accordion" id="section-accordion">

						@include('components/admin/courses/sectionBuilder', ["sections" => $sections])

					</div>
				</div><!-- section-content -->

				<div id="media-tab" class="tab-pane mb-3">

					{{-- <div class="text-right mb-3">
						<button class="btn btn-primary" form="edit-course-form" type="submit" value="save">Save</button>
					</div> --}}
					<div class="row">
						<div class="col-xl-9 col-lg-7 col-md-12">
							<h5>Gallery</h5>
							<div class="bg-light">
								<div class="pt-2 px-2">
									<button id="add-gallery-images-btn" class="btn btn-primary m-1">
										Media Library
									</button>
									<button id="remove-all-images-btn"
										class="btn btn-danger m-1 {{ $gallery->isEmpty() ? 'd-none' : "" }}">
										Remove all
									</button>
								</div>
								<div id="active-gallery-loading" class="row d-none my-3">
									<div class="spinner-border avatar-md text-primary mx-auto" role="status"></div>
								</div>
								<div id="gallery-cnt" class="row" style="padding: 0 1.1rem;" data-namespace="App\Models\Course"
									data-model-id="{{ $course->id }}">
									@include('components/admin/modelGallery', ["gallery" => $gallery])
								</div>
								<input id="course-img-upload" class="js-filepond-file-dragging mb-0" type="text">
							</div>
							<p class="text-right mb-2">
								<small>
									<strong>
										Το πεδίο δέχεται αρχεία: .jpg, .png.
									</strong>
								</small>
							</p>

							<h5>Βοηθητικά Αρχεία</h5>
							<div class="bg-light mb-0">
								<div class="pt-2 px-2">
									<button id="file-library-btn" class="btn btn-primary m-1"
										data-toggle="modal" data-target="#remainings-files-modal">
										File Library
									</button>
									<button id="remove-all-files-btn"
											class="btn btn-danger m-1 {{ $files->isEmpty() ? 'd-none' : "" }}">
										Remove all
									</button>
								</div>
								<div id="active-files-loading" class="row d-none my-3">
									<div class="spinner-border avatar-md text-primary mx-auto" role="status"></div>
								</div>
								<div id="files-cnt" class="row" style="padding: 0 1.1rem;">
									@include('components/admin/filesTable', ["files" => $files])
								</div>
								<!-- FilePond -->
								<input id="course-file-upload" class="js-filepond-file-dragging mb-0" type="text">
							</div>
							<p class="text-right mb-2">
								<small>
									<strong>
										Το πεδίο δέχεται αρχεία: .doc, .odt, .rtf, .xls, .odp, .zip, .rar., .mp3, .pdf, .ev3, .sb3, .html.
									</strong>
								</small>
							</p>
						</div>
						<div class="col-xl-3 col-lg-5 col-md-12 mt-4">
							<!-- Cover Preview -->
							<div class="card">
								<div class="card-header">
									<h4 class="card-title mb-0">Cover</h4>
								</div>
								<div class="card-body">
									<img id="cover-image" src="{{ $course->cardMediumUrl() }}"
										class="img-fluid{{ is_null($course->cover) ? " d-none" : "" }}"
										alt="Cover Image" />
									<p id="cover-status" class="text-center{{ !is_null($course->cover) ? " d-none" : "" }}"
										><strong>Δεν βρέθηκε εικόνα</strong></p>

									<div class="form-row mt-2">
										<div class="col-md-6 d-flex justify-content-center">
											<button id="change-cover-btn" class="btn btn-primary btn-block text-nowrap">
												{{ !is_null($course->cover) ? "Αλλαγή" : "Προσθηκη" }}
											</button>
										</div>

										<div class="{{ !is_null($course->cover) ? "d-flex " : "d-none " }}col-md-6 justify-content-center">
											<button id="remove-cover-btn" class="btn btn-danger btn-block text-nowrap">
												Αφαίρεση
											</button>
										</div>
									</div>

								</div> <!-- end card-body -->
							</div> <!-- end course info card -->
						</div>
					</div>




				</div>
			</div><!-- tab-content -->

		</div>
	</div>

	{{-- <form id="delete-course-form" action="{{ $course->slug }}" method="POST">
		@csrf
		@method('DELETE')
	</form> --}}

@endsection

@section('scripts')
<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>
<script src="/assets/js/vendor/dataTables.buttons.min.js"></script>
<script src="/assets/js/vendor/dragula.min.js"></script>
<script src="/assets/js/ui/component.dragula.js"></script>

<script src="{{ mix('js/dashboard/courses/courseProfile.js') }}"></script>
@endsection
