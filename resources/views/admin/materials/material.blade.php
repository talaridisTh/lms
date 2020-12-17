@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<div class="modal fade" id="gallery-modal" tabindex="-1" role="dialog" aria-labelledby="gallery-modalLabel"
	aria-hidden="true">
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
						<a href="#media-library" id="media-library-tab-btn" data-toggle="tab" aria-expanded="false"
							class="nav-link active">
							Media Library
						</a>
					</li>
					<li class="nav-item">
						<a href="#upload" id="upload-tab-btn" data-toggle="tab" aria-expanded="true" class="nav-link">
							Upload
						</a>
					</li>
				</ul> <!-- end nav-->
				<div class="tab-content">
					<div id="media-library" class="tab-pane show active">
						<!-- Search -->
						<div class="row">
							<div class="col-4 mx-auto">
								<div class="form-group">
									<input id="image-search" class="form-control text-center" type="text"
										placeholder="Αναζήτηση..." />
								</div>
							</div>
						</div>
						<div id="gallery-content" data-model="App\Models\Material"
							data-id={{ $material->id }}>
							@include('components.admin.imageGallery', ['media' => $media])
						</div>
					</div>
					<div id="upload" class="tab-pane">
						<input id="file-pond" class="js-filepond-file-dragging mb-0" type="file[]" />
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

<!-- Title - Breadcrumb -->
<div class="row">
	<div class="col-12">
		<div class="page-title-box">
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item">
						<a href="/" class="custom-link-primary">Home</a>
					</li>
					<li class="breadcrumb-item">
						<a href="/dashboard" class="custom-link-primary">Dashboard</a>
					</li>
					<li class="breadcrumb-item">
						<a href="/dashboard/materials" class="custom-link-primary">Υλικό</a>
					</li>
					<li class="breadcrumb-item active">
						{{ $material->title }}
					</li>
				</ol>
			</div>
			<h4 id="material-title" class="page-title"
				data-material-slug="{{ $material->slug }}">
				{{ $material->title }}
			</h4>
		</div>
	</div>
</div><!-- ./Title - Breadcrumb -->

<div class="wrapper">
	<div class="content">
		<!-- Tab Links -->
		<ul class="nav nav-tabs nav-bordered mb-3">
			<li class="nav-item">
				<a href="#content" data-toggle="tab" aria-expanded="false" class="nav-link active">
					<i class="mdi mdi-home-variant d-md-none d-block"></i>
					<span class="d-none d-md-block">Γενικά</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="#courses-tabs" data-toggle="tab" aria-expanded="true" class="nav-link">
					<i class="mdi mdi-account-circle d-md-none d-block"></i>
					<span class="d-none d-md-block">Courses</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="#media-tab" data-toggle="tab" aria-expanded="true" class="nav-link">
					<i class="mdi mdi-account-circle d-md-none d-block"></i>
					<span class="d-none d-md-block">Media</span>
				</a>
			</li>
		</ul><!-- ./Tab Links -->

		<div class="tab-content mb-3">
			<div class="tab-pane show active" id="content">
				<div class="row">

					<!-- form inputs -->
					<div class="col-xl-9 col-lg-8 col-md-12">

						<form id="material-create" method="post" enctype="multipart/form-data"
							action="{{ "/dashboard/materials/$material->slug" }}" autocomplete="off">

							@csrf

							@method('PATCH')

							<div class="form-row">

								<div class="form-group col-lg-6">
									<label for="titleMaterial">Τίτλος <span class="text-danger"> *</span></label>
									<input name="title" id="titleMaterial" type="text" 
										class="form-control @error("title") is-invalid @enderror"
										placeholder="Εισάγετε τίτλο..." value="{{ old('title', $material->title) }}" />
									@error("title")
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>

								<div class="form-group col-lg-6">
									<label for="subtitleMaterial">Υποτίτλος</label>
									<input id="subtitleMaterial" name="subtitle" type="text" class="form-control"
										placeholder="Εισάγετε υποτίτλο..." value="{{ old('subtitle', $material->subtitle) }}" />
								</div>

							</div>

							<div class="form-group">
								<div class="d-flex justify-content-between align-items-center">
									<label for="toggle">Σύνοψη</label>
									<input id="summary-toggle" class="js-editors-toggle"
										data-field="summary" type="checkbox" data-switch="success"
										@if ( isset($fields->summary) && $fields->summary == 1)
											checked
										@endif
									/>
									<label for="summary-toggle" data-on-label="On" data-off-label="Off"></label>
								</div>

								<textarea id="summary" name="summary" class="form-control" rows="5"
									placeholder="Εισάγετε σύνοψη..." >{{ old('summary', $material->summary) }}</textarea>
							</div>

							<div class="form-group">
								<div class="d-flex justify-content-between align-items-center">
									<label for="description-material">Περιγραφή</label>
									<input id="description-toggle" class="js-editors-toggle"
										data-field="description" type="checkbox" data-switch="success"
										@if ( isset($fields->description) && $fields->description == 1)
											checked
										@endif
									/>
									<label for="description-toggle" data-on-label="On" data-off-label="Off"></label>
								</div>
								<textarea id="description-material" name="description" class="form-control" rows="5"
									placeholder="Εισάγετε περιγραφή...">{{ old('description', $material->description) }}</textarea>
							</div>

							<div class="form-group">
								<div class="d-flex justify-content-between align-items-center">
									<label for="content-material">Περιεχόμενο</label>
									<input id="content-toggle" class="js-editors-toggle"
										data-field="content" type="checkbox" data-switch="success"
										@if ( isset($fields->content) && $fields->content == 1)
											checked
										@endif
									/>
									<label for="content-toggle" data-on-label="On" data-off-label="Off"></label>
								</div>
								<textarea id="content-material" name="content" class="form-control" rows="5"
									placeholder="Εισάγετε περιεχόμενο μαθήματος...">{{ old('content', $material->content) }}</textarea>
								</div>
								@error("content")
									<span>
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							<textarea name="script" id="script-area" hidden>{{ $material->script }}</textarea>
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

					</div><!-- ./form inputs -->

					<div class="col-xl-3 col-lg-4 col-md-12 pt-1">

						<!-- Βuttons -->
						<div class="sticky py-3">

							<button form="material-create" id="store-material-btn" class="btn btn-info" type="submit">
								Update
							</button>
							
							@if( count($material->courses) > 0 && $material->type != "Link" && $material->type != "Announcement" )
								<a target="_blank" href="{{route('index.material.show',[$material->courses->first()->slug,$material->slug])}}"
									id="preview-btn" class="btn btn-warning">
									<i class="mdi mdi-eye"></i>
								</a>
							@endif

						</div><!-- ./Βuttons -->

						<div class="card">
							<div class="card-body">

								<div class="form-group mb-1">
									<div class="d-flex justify-content-between">
										<label for="activeMaterial">Κατάσταση</label>
										<input form="material-create" name="status" type="checkbox" id="activeMaterial"
											data-switch="success" {{ $material->status == 1 ? 'checked' : "" }}/>
										<label for="activeMaterial" data-on-label="On" class="mb-0"
											data-off-label="Off"></label>
									</div>
								</div>
								<hr>

								<div class="form-group mb-3">

									{{-- <label for="video-id-input">Vimeo id</label>
    								<div class="input-group">
    								    <div class="input-group-prepend">
    								        <span class="input-group-text" id="vimeo-url-label">https://vimeo.com/</span>
    								    </div>
										<input form="material-create" id="video-id-input" type="text" class="form-control"
											name="video_link" placeholder="vimeo-id" aria-label="vimeo-id"
											aria-label="vimeo-id" aria-describedby="vimeo-url-label">
									</div> --}}
									
									<label for="video-id-input">Video id</label>
									<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text" id="prepented-vimeo-url">https://vimeo.com/</span>
											</div>
											<input   form="material-create" name="video_link" type="text"
												class="form-control @error("video_link") is-invalid @enderror"
												id="video-id-input" placeholder="vimeo-id..." value="{{ old('video_link', $material->video_link) }}"
												aria-label="vimeo-id" aria-describedby="vimeo-url-label"/>
											@error("video_link")
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
									</div>

								</div>
								<hr>

								<div class="form-group mb-3">
									<label for="link-input">Link url</label>
									<input   form="material-create" name="link" type="text"
										class="form-control @error("link") is-invalid @enderror"
										id="link-input" placeholder="Εισάγετε link..." value="{{ old('link', $material->link) }}" />
									@error("link")
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
								
								<hr>

								<div class="form-group mb-3">
									<label for="typeMaterial">Τύπος</label>
									<select data-placeholder="Επιλέξτε Topics..." id="typeMaterial" class="form-control"
										name="type" data-toggle="select2" form="material-create">

										@foreach ($types as $value => $title)
											@php
												if ( old("type") == $value ) {
													$selected = "selected";
												}
												elseif (old("type") == "" && isset($material) && $material->type == $value) {
													$selected = "selected";
												}
												else {
													$selected = "";
												}
											@endphp

											<option value="{{ $value }}" {{ $selected }}>{{ $title }}</option>

										@endforeach
									</select>
								</div>

								<hr>
								<div class="form-group mb-0">
									<label for="instructorMaterial">
										Εισηγητές
									</label>
									<select form="material-create" name="instructors[]" multiple id="instructorMaterial"
										class="form-control" data-toggle="select2"
										data-placeholder="Επιλέξτε instructor...">
										@php
										foreach ( $instructors as $instructor ) {
										if ( old("instructors") != "" && in_array($instructor->id, old("instructors")) )
										{

										echo "<option value='$instructor->id' selected>$instructor->last_name $instructor->first_name</option>";
										continue;

										}
										elseif ( old("instructors") == "" && isset($material) &&
										in_array($instructor->id, $activeInstructors) ) {

										echo "<option value='$instructor->id' selected>$instructor->last_name $instructor->first_name</option>";
										continue;

										}
										echo "<option value='$instructor->id'>$instructor->last_name $instructor->first_name</option>";
										}
										@endphp
									</select>
								</div>

							</div>
						</div>

					</div>
				</div>
			</div>

			<div class="tab-pane" id="courses-tabs">
				@include("components.admin.materials.tabsCourses")
			</div>
			
			<div id="media-tab" class="tab-pane">
				<div class="row">
					<div class="col-xl-9 col-lg-8 col-md-12">
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


							<div id="gallery-cnt" class="row" style="padding: 0 1.1rem;" data-namespace="App\Models\Material"
								data-model-id="{{ $material->id }}">
								@include('components/admin/modelGallery', ["gallery" => $gallery])
							</div>
							<input id="material-img-upload" class="js-filepond-file-dragging mb-0" type="text">

						</div>
						<p class="text-right mb-2">
							<small>
								<strong>
									Το πεδίο δέχεται αρχεία: .jpg, .png.
								</strong>
							</small>
						</p>

						<h5>Βοηθητικά Αρχεία</h5>
						<div class="bg-light">
							<div class="pt-2 px-2">
								<button id="file-library-btn" class="btn btn-primary m-1" data-toggle="modal"
									data-target="#remainings-files-modal">
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
							<input id="material-file-upload" class="js-filepond-file-dragging mb-0" type="text">
						</div>
						<p class="text-right mb-3">
							<small>
								<strong>
									Το πεδίο δέχεται αρχεία: .doc, .odt, .rtf, .xls, .odp, .zip, .rar., .mp3, .pdf, .ev3, .sb3, .html.
								</strong>
							</small>
						</p>
					</div>
					<div class="col-xl-3 col-lg-4 col-md-12 mt-4">
						<!-- Cover Preview -->
						<div class="card">
							<div class="card-header">
								<h4 class="card-title mb-0">Cover</h4>
							</div>
							<div class="card-body">

								<img id="cover-image" src="{{ $material->cardMediumUrl() }}"
									class="img-fluid{{ is_null($material->cover) ? " d-none" : "" }}"
									alt="Cover Image" />
								<p id="cover-status"
									class="text-center{{ !is_null($material->cover) ? " d-none" : "" }}">
									<strong>Δεν βρέθηκε εικόνα</strong></p>

								<div class="form-row mt-2">
									<div class="col-md-6 d-flex justify-content-center">
										<button id="change-cover-btn" class="btn btn-primary btn-block text-nowrap">
											{{ !is_null($material->cover) ? "Αλλαγή" : "Προσθήκη" }}
										</button>

									</div>
									<div
										class="{{ !is_null($material->cover) ? "d-flex " : "d-none " }}col-md-6 justify-content-center">
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
		</div>

	</div>
</div>

@endsection

@section('scripts')

<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>
<script src="/assets/js/vendor/dataTables.buttons.min.js"></script>
<script src="/assets/js/vendor/dragula.min.js"></script>
<script src="/assets/js/ui/component.dragula.js"></script>


<x-routes></x-routes>
<script src="{{ mix('js/dashboard/materials/material.js') }}"></script>


@endsection
