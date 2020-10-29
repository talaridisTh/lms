@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
	
@endsection

@section('content')

	<div id="edit-banners-modal" class="modal fade" tabindex="-1"
		role="dialog" aria-labelledby="edit-banners-modalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl" role="document">
				<div class="modal-content">
					<div class="modal-header">
					  	<h5 class="modal-title" id="edit-banners-modalLabel">Modal title</h5>
					  	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
					  	</button>
					</div>
				<div class="modal-body">

					<div class="row">
						<div class="col-md-6">
							<h4 id="table-title" class="text-center">Courses</h4>
						</div>
						<div class="col-md-6">
							<div id="type-select-cnt" class="row">
								<label class="col-3 text-right align-self-center" for="type-select">Κατηγορία</label>
								<div class="col-9 mb-1">
									<select id="type-select" data-toggle="select2"
										class="select2 form-control" autocomplete="off"
										data-minimum-results-for-search="-1">
										<option value="courses" selected>Courses</option>
										<option value="materials">Μαθήματα</option>
										<option value="bundles">Bundles</option>
									</select>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">

							<div id="courses-card" class="js-category-table-cnt card h-100">
								<div class="card-body">
									<table id="courses-datatable" class="table w-100 js-remove-table-classes">
										<thead>
											<tr>
												<th class="text-center">Τίτλος</th>
												<th class="text-center">Topics</th>
												<th class="text-center w-5"></th>
											</tr>
										</thead>
										<tbody class="tables-hover-effect"></tbody>
										<tfoot>
											<tr>
												<th class="text-center">Τίτλος</th>
												<th class="text-center">Topics</th>
												<th class="text-center"></th>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>

							<div id="bundles-card" class="js-category-table-cnt card h-100 d-none">
								<div class="card-body">
									<table id="bundles-datatable" class="table w-100 js-remove-table-classes">
										<thead>
											<tr>
												<th class="text-center">Τίτλος</th>
												<th class="text-center w-5"></th>
											</tr>
										</thead>
										<tbody class="tables-hover-effect"></tbody>
										<tfoot>
											<tr>
												<th class="text-center">Τίτλος</th>
												<th class="text-center"></th>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>

							<div id="materials-card" class="js-category-table-cnt card h-100 d-none">
								<div class="card-body">
									<table id="materials-datatable" class="table w-100 js-remove-table-classes">
										<thead>
											<tr>
												<th class="text-center">Τίτλος</th>
												<th class="text-center w-5"></th>
											</tr>
										</thead>
										<tbody class="tables-hover-effect"></tbody>
										<tfoot>
											<tr>
												<th class="text-center">Τίτλος</th>
												<th class="text-center"></th>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
							
						</div><!-- ./left col -->

						<div class="col-md-6">
							{{-- @dd($banners) --}}
							@foreach ($banners as $section => $values)
								<div id="{{ $section }}-banner-selection" class="js-banner-selection-cnt card h-100">
									<div class="card-body height-883px overflow-y-auto">
										@if ( !empty($values->models) )
											@foreach ($values->models as $model)
												<div class="js-active-banner callout callout-success"
													data-model-id="{{ $model->id }}" data-namespace="{{ get_class($model) }}">
													<div class="d-flex justify-content-between mb-1">
														<h5>{{ $model->title }}</h5>
														<button class="js-remove-callout close"><span>×</span></button>
													</div>
													<p>{{ $model->subtitle }}</p>
												</div>
											@endforeach
										@endif
										<div class="js-empty-callout callout callout-danger{{ !empty($values->models) ? " d-none" : "" }}">
											<div class="d-flex justify-content-center mb-1">
												<h5>Δεν επιλέχθηκαν Banners</h5>
											</div>
										</div>
									</div>
								</div>
							@endforeach

						</div><!-- ./right col -->
					</div>

				</div>
				<div class="modal-footer">
				  	<button id="save-banners-btn" type="button" class="btn btn-primary">Αποθήκευση</button>
				  	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Gallery Modal -->
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
								class="nav-link active">
								Media Library
							</a>
						</li>
						<li class="nav-item">
							<a href="#upload" id="upload-tab-btn"
								data-toggle="tab" aria-expanded="true"
								class="nav-link">
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

	<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box">
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="/" class="custom-link-primary">Home</a></li>
						<li class="breadcrumb-item"><a href="/dashboard" class="custom-link-primary">Dashboard</a></li>
						<li class="breadcrumb-item active">Home Page</li>
					</ol>
				</div>
				<h4 class="page-title">Home Page</h4>
			</div>
		</div>
	</div><!-- end page title -->

	<div class="wrapper">
		<div class="content">

			<ul class="nav nav-tabs nav-bordered mb-3">
				<li class="nav-item">
					<a href="#carousel-section" id="carousel-section-tab-btn"
						data-toggle="tab" aria-expanded="true" class="nav-link active">
						Carousel
					</a>
				</li>
				<li class="nav-item">
					<a href="#editor-section" id="editor-section-tab-btn"
						data-toggle="tab" aria-expanded="false" class="nav-link">
						Editors
					</a>
				</li>
			</ul><!-- ./tabs -->

			<div class="tab-content">

				<div id="carousel-section" class="tab-pane show active">
					<div class="accordion" id="carousel-accordion">
						@php
							$counter = 1;
						@endphp
						@foreach ($banners as $section => $values)
							<div class="mb-0">
								<div class="card-header d-flex justify-content-between align-items-center" id="{{ $section }}-heading">
									
									<h5 class="m-0 flex-grow-1">
										<a class="custom-accordion-title d-block pt-2 pb-2"
											data-toggle="collapse" href="#{{ $section }}-collapse"
											aria-expanded="true" aria-controls="{{ $section }}-collapse">
											{{ ucfirst($section) }}
										</a>
									</h5>
									
									<div class="tools-cnt pl-4 pr-1 h3 d-flex align-items-center">
										<i class="px-1 mr-2 mdi mdi-square-edit-outline custom-muted cursor-pointer"
											data-toggle="modal" data-target="#edit-banners-modal" data-importance="{{ $section }}"
											data-modal-title="Carousel {{ $counter }}" title="Edit carousel"></i>

										<input type="checkbox" id="{{ $section }}-banners-switch" autocomplete="off"
											{{ !empty($values->status) && $values->status == 1 ? "checked" : ""}}
											class="js-carousel-switch" data-switch="bool"/>
										<label for="{{ $section }}-banners-switch" class="mb-0" data-on-label="On" data-off-label="Off"></label>
									</div>

								</div>
								<div id="{{ $section }}-collapse" class="collapse{{ $counter++ == 1 ? " show" : "" }}"
									aria-labelledby="{{ $section }}-heading" data-parent="#carousel-accordion">
									
									<div id="{{ $section }}-banners-row" class="js-banner-cnt row pt-3"
										data-plugin="dragula" data-importance="{{ $section }}">
										@if ( !empty($values->models) )
											@foreach ($values->models as $model)

												@php
													$modelType = substr($model->getTable(), 0, -1);
													$previewURL = "#";

													if ( $modelType == "course" ) {
														$previewURL = "/courses/course/$model->slug";
													}
													elseif ( $modelType == "material" ) {
														$previewURL = "/material/$model->slug";
													}
												@endphp

												<div class="col-md-6 col-lg-4 col-xl-3">
													<!-- Simple card -->
													<div class="js-banner card d-block" data-model-id="{{ $model->id }}"
														data-namespace="{{ get_class($model) }}">
														<div class="embed-responsive embed-responsive-16by9">
															<img class="card-img-top embed-responsive-item" src="{{ $model->cover }}" alt="{{ $model->title }}">
														</div>
														<div class="card-body">
															<h5 class="card-title">{{ $model->title }}</h5>
															<p class="js-overflow-check card-text height-65px overflow-y-hidden mb-0">{{ $model->subtitle }}</p>
															<div class="d-flex justify-content-end mt-1 mb-2">
																<a href="#" class="js-show-more invisible custom-muted font-weight-700">Περισσότερα...</a>
															</div>
															<a href="/dashboard/{{ $modelType }}/{{ $model->slug }}"
																class="custom-link-primary mr-3" target="_blank">Edit</a>
															<a href="{{ $previewURL }}" class="custom-link-primary" target="_blank">View</a>
														</div> <!-- end card-body-->
													</div> <!-- end card-->
												</div><!-- end col -->
											@endforeach
										@else
											<div class="callout callout-danger mx-auto w-75">
												<div class="d-flex justify-content-center mb-1">
													<h5>Δεν επιλέχθηκαν Banners</h5>
												</div>
											</div>
										@endif
										
									</div>

								</div>
							</div>
						@endforeach
					</div>
				</div>
				<div id="editor-section" class="tab-pane">
					<form id="home-form" action="/dashboard/home-content/update" method="post" autocomplete="off">
						@csrf
						<input type="text" name="title" value="Home page" hidden />

						<div class="form-group">
							<div class="d-flex justify-content-between">
								<label class="mb-0" for="first-section-textarea">Primary</label>
								<div class="d-flex mb-1">

									<div class="custom-control custom-radio custom-control-inline">
										<input id="first-section-default" class="custom-control-input"
											type="radio" name="primaryContent" value="0"
											{{ $statuses->primary_editor->content == 0 ? " checked" : "" }}/>
										<label class="custom-control-label" for="first-section-default">Default</label>
									</div>

									<div class="custom-control custom-radio custom-control-inline">
										<input type="radio" id="first-section-custom" name="primaryContent"
											class="custom-control-input" value="1"
											{{ $statuses->primary_editor->content == 1 ? " checked" : "" }}>
										<label class="custom-control-label" for="first-section-custom">Custom</label>
									</div>

									<input type="checkbox" id="first-section-switch" data-switch="bool" name="primaryContentStatus"
										{{ $statuses->primary_editor->status == 1 ? " checked" : ""}}/>
									<label class="mb-0" for="first-section-switch" data-on-label="On" data-off-label="Off"></label>
								</div>
							</div>
							<textarea class="form-control" id="first-section-textarea"
								name="primaryEditor" rows="5">{{ !empty($page->primary_editor) ? $page->primary_editor : "" }}</textarea>
						</div>

						<div class="form-group">
							<div class="d-flex justify-content-between">
								<label class="mb-0" for="second-section-textarea">Secondary</label>
								<div class="d-flex mb-1">
									<div class="custom-control custom-radio custom-control-inline">
										<input id="second-section-default" class="custom-control-input"
											type="radio" name="secondaryContent" value="0"
											{{ $statuses->secondary_editor->content == 0 ? " checked" : "" }}/>
										<label class="custom-control-label" for="second-section-default">Default</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline">
										<input type="radio" id="second-section-custom"
											name="secondaryContent" class="custom-control-input" value="1"
											{{ $statuses->secondary_editor->content == 1 ? " checked" : "" }}>
										<label class="custom-control-label" for="second-section-custom">Custom</label>
									</div>
									<input type="checkbox" id="second-section-switch" data-switch="bool" name="secondaryContentStatus"
										{{ $statuses->secondary_editor->status == 1 ? " checked" : ""}}/>
									<label class="mb-0" for="second-section-switch" data-on-label="On" data-off-label="Off"></label>
								</div>
							</div>
							<textarea class="form-control" id="second-section-textarea"
								name="secondaryEditor" rows="5">{{  !empty($page->secondary_editor) ? $page->secondary_editor : ""}}</textarea>
						</div>
					</form>

					<div class="mb-3 d-flex justify-content-end">
						<button form="home-form" type="submit" class="btn btn-primary">Αποθήκευση</button>
					</div>
				</div>
			</div><!-- ./tab-content -->
		</div>
	</div>
@endsection

@section('scripts')
	<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
	<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>
	{{-- <script src="/assets/js/dragula.js"></script> --}}

	<script src="{{ mix("js/dashboard/settings/home-page.js") }}"></script>
	
@endsection