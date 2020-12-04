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
	}
	.circle-icon {
		padding: 0.2rem 0.2rem;
	}
	.custom-accordion-title {
		color:#b2bcc5;
	}

	/* #settings .cm-s-shadowfox.CodeMirror{
		background: #404954;
	}

	#settings .cm-s-shadowfox .CodeMirror-gutters{
		background: #1d1d20;
	} */


	.CodeMirror {
	  border: 1px solid #47515d;
	  border-radius: 4px;
	  height: auto !important;
	  min-height: 300px !important;
	}

	.CodeMirror-scroll {
	  min-height: 300px !important;
	  overflow-y: auto;
	  overflow-x: auto;
	}
</style>
@endsection

@section('content')

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
							<div id="gallery-content">
								@include('components.admin.imageGallery', ['media' => $media])
							</div>
						</div>

						<div id="upload" class="tab-pane">

							<input id="file-pond" class="js-filepond-file-dragging" type="file[]"/>

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

	<div class="wrapper">
		<div class="content">

			<!-- tabs -->
			<ul class="nav nav-tabs nav-bordered mb-3">
				<li class="nav-item">
					<a href="#settings" id="setting-tab-btn"
						data-toggle="tab" aria-expanded="false"
						class="nav-link active">
						Ρυθμίσεις
					</a>
				</li>
				<li class="nav-item">
					<a href="#"
						data-toggle="tab" aria-expanded="true"
						class="nav-link tab-link text-muted">
						Υλικό
					</a>
				</li>
				<li class="nav-item">
					<a href="#"
						data-toggle="tab" aria-expanded="true"
						class="nav-link tab-link text-muted">
						Χρήστες
					</a>
				</li>
				<li class="nav-item">
					<a href="#"
						data-toggle="tab" aria-expanded="true"
						class="nav-link tab-link text-muted">
						Sections
					</a>
				</li>
				<li class="nav-item">
					<a href="#"
						data-toggle="tab" aria-expanded="true"
						class="nav-link tab-link text-muted">
						Αρχεία
					</a>
				</li>
			</ul><!-- ./tabs -->

			<div class="tab-content">

				<div id="settings" class="tab-pane show active mb-3">
					<div class="row">
						<div class="col-xl-9 col-lg-7 col-md-12">
							<form id="create-course-form" action="/dashboard/courses/store"
								method="POST" enctype="multipart/form-data" autocomplete="off">

								@csrf

								<div class="form-row">
									<div class="form-group col-lg-6">
										<label for="title">Τίτλος <span class="text-danger">*</span></label>
										<input id="title" type="text" name="title"
											class="form-control @error('title') is-invalid @enderror"
											value="{{ old('title') }}"placeholder="Εισάγετε τίτλο...">
										@error('title')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>
									<div class="form-group col-lg-6">
										<label for="subtitle">Υπότιτλος</label>
										<input id="subtitle" type="text"
											class="form-control @error('subtitle') is-invalid @enderror"
											name="subtitle"
											value="{{ old('subtitle') }}"
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
										<label for="summary">Σύνοψη</label>
										<input id="summary-toggle" class="js-editors-toggle"
											data-field="summary" type="checkbox" data-switch="success"
											name="summaryEditor"/>
										<label class="mb-0" for="summary-toggle" data-on-label="On" data-off-label="Off"></label>
									</div>
									<textarea class="form-control @error('summary') is-invalid @enderror"
										id="summary" name="summary" rows="4"
										placeholder="Εισάγετε σύνοψη..."
										>{{ old('summary') }}</textarea>
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
											name="descriptionEditor"/>
										<label class="mb-0" for="description-toggle" data-on-label="On" data-off-label="Off"></label>
									</div>
									<textarea class="form-control @error('description') is-invalid @enderror"
										id="description" name="description" rows="4"
										placeholder="Εισάγετε περιγραφή..."
										>{{ old('description') }}</textarea>
									@error('description')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
								<textarea id="script-area" name="script" hidden>{{ old("script") }}</textarea>
							</form>

							<label>Script</label>
							<div id="editor"></div>

						</div>
						<div class="col-xl-3 col-lg-5 col-md-12 pt-1">

							<div class="sticky py-3">

								<button form="create-course-form" type="submit"
									class="btn btn-primary btn-block" name="save" value="save">
									Save
								</button>

							</div>

							<div class="card">
								<div class="card-body">
									<div class="form-group">

										<label for="version-select">Έκδοση</label>
										<select form="create-course-form" id="version-select"
											name="version"  data-toggle="select2" data-minimum-results-for-search="-1"
											class="custom-select2-warning select2 form-control">
											<option value="Trial" {{ old("version") === "Trial" ? "selected" : ""}}>Trial</option>
											<option value="Normal" {{ old("version") === "Normal" ? "selected" : ""}}>Normal</option>
										</select>
									</div>

									<hr>

									<div class="form-group">
										<label for="topic">Topic</label>
										<select form="create-course-form" id="topics-select"
											class="select2 form-control select2-multiple"
											name="topics[]" multiple="multiple"
											data-toggle="select2" data-placeholder="Επιλέξτε Topics ...">

											@foreach ($topics as $topic)

												@if ( old("topics") != "" && in_array($topic->id, old("topics")) )
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
									<select id="curator" form="create-course-form"
										class="select2 form-control" name="curator"
										data-toggle="select2" data-placeholder="Επιλέξτε Εισηγητή...">
										@foreach ($instructors as $instructor)

											@if ( old("curator") != "" && old("curator") == $instructor->id )
												<option value="{{ $instructor->id }}"
													selected>
													{{ $instructor->first_name }} {{ $instructor->last_name }}
												</option>
											@else
												<option value="{{ $instructor->id }}">
													{{ $instructor->first_name }} {{ $instructor->last_name }}
												</option>
											@endif

										@endforeach
									</select>
									<hr>

									<div class="form-group mb-0">
										<label for="publish-date-select">Published</label>
										<input form="create-course-form" type="text" class="form-control"
											id="publish-date-select" name="publishDate"
											value="{{ old("publishDate") }}"
											placeholder="Εισάγετε ημερομηνία..." data-toggle="input-mask"
											data-mask-format="00-00-0000 00:00:00" autocomplete="off" />
									</div>
									<hr>

									<div class="form-group mb-0">
										<label for="version-select">Template</label>
										<select form="create-course-form" id="template-select" name="template" data-toggle="select2"
											class="custom-select2-warning select2 form-control @error('template') is-invalid @enderror"
											data-minimum-results-for-search="-1" autocomplete="off">
											@foreach ($templates as $key => $template)
												<option value="{{ $template->views->frontend }}"
												{{ old("template") == $template->views->frontend ? "selected" : ""}}>{{ $template->title }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div><!-- settings tab-pane -->

			</div><!-- tab-content -->
		</div>
	</div>

@endsection

@section('scripts')

<script src="{{ mix("/js/dashboard/newContent.js") }}"></script>

@endsection
