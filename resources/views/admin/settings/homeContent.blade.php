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
							<h4 id="table-title" class="text-center">Μαθήματα</h4>
						</div>
						<div class="col-md-6">
							<div id="type-select-cnt" class="row">
								<label class="col-3 text-right align-self-center" for="type-select">Κατηγορία</label>
								<div class="col-9 mb-1">
									<select id="type-select" data-toggle="select2"
										class="select2 form-control"
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

							<div id="courses-card" class="js-category-table-cnt card h-100 d-none">
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

							<div id="materials-card" class="js-category-table-cnt card h-100">
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
							@foreach ($banners as $section => $values)
								<div id="{{ $section }}-banner-selection" class="js-banner-selection-cnt card h-100">
									<div class="card-body">
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
					<a href="#first-section" id="first-section-tab-btn"
						data-toggle="tab" aria-expanded="false" class="nav-link active">
						Section 1
					</a>
				</li>
				<li class="nav-item">
					<a href="#second-section" id="second-section-tab-btn"
						data-toggle="tab" aria-expanded="true" class="nav-link">
						Section 2
					</a>
				</li>
			</ul><!-- ./tabs -->

			<form id="home-form" action="/dashboard/home-content/update" method="post" autocomplete="off">
				@csrf
				<input type="text" name="title" value="{{ $page->title }}" hidden />
				<div class="tab-content">
					<div id="first-section" class="tab-pane show active">
						<div class="form-group">
							<div class="d-flex justify-content-between">
								<label class="mb-0" for="first-section-textarea">Section 1</label>
								<div class="d-flex mb-1">
									<div class="custom-control custom-radio custom-control-inline">
										<input id="first-section-default" class="custom-control-input"
											type="radio" name="firstSection" value="0"
											{{ $statuses->primary_editor->content == 0 ? " checked" : "" }}/>
										<label class="custom-control-label" for="first-section-default">Default</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline">
										<input type="radio" id="first-section-custom" name="firstSection"
											class="custom-control-input" value="1"
											{{ $statuses->primary_editor->content == 1 ? " checked" : "" }}>
										<label class="custom-control-label" for="first-section-custom">Custom</label>
									</div>
									<input type="checkbox" id="first-section-switch" data-switch="bool" name="firstSectionStatus"
										{{ $statuses->primary_editor->status == 1 ? " checked" : ""}}/>
									<label class="mb-0" for="first-section-switch" data-on-label="On" data-off-label="Off"></label>
								</div>
							</div>
							<textarea class="form-control" id="first-section-textarea"
								name="firstSectionContent" rows="5">{{ $page->primary_editor }}</textarea>
						</div>
					</div>
					<div id="second-section" class="tab-pane">
						<div class="form-group">
							<div class="d-flex justify-content-between">
								<label class="mb-0" for="second-section-textarea">Section 2</label>
								<div class="d-flex mb-1">
									<div class="custom-control custom-radio custom-control-inline">
										<input id="second-section-default" class="custom-control-input"
											type="radio" name="secondSection" value="0"
											{{ $statuses->secondary_editor->content == 0 ? " checked" : "" }}/>
										<label class="custom-control-label" for="second-section-default">Default</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline">
										<input type="radio" id="second-section-custom"
											name="secondSection" class="custom-control-input" value="1"
											{{ $statuses->secondary_editor->content == 1 ? " checked" : "" }}>
										<label class="custom-control-label" for="second-section-custom">Custom</label>
									</div>
									<input type="checkbox" id="second-section-switch" data-switch="bool" name="secondSectionStatus"
										{{ $statuses->secondary_editor->status == 1 ? " checked" : ""}}/>
									<label class="mb-0" for="second-section-switch" data-on-label="On" data-off-label="Off"></label>
								</div>
							</div>
							<textarea class="form-control" id="second-section-textarea"
								name="secondSectionContent" rows="5">{{ $page->secondary_editor }}</textarea>
						</div>
					</div>

				</div><!-- ./tab-content -->
			</form>

			<div class="mb-3 d-flex justify-content-end">
				<button form="home-form" type="submit" class="btn btn-primary">Αποθήκευση</button>
			</div>
				
			@php
				$counter = 1;
			@endphp
			<ul class="nav nav-tabs nav-bordered my-3">
				@foreach ($banners as $section => $values)
					<li class="nav-item">
						<a href="#{{ $section }}-content" id="primary-content-tab-btn"
							data-toggle="tab" aria-expanded="false" class="nav-link{{ $counter == 1 ? " active" : "" }}">
							Carousel {{ $counter++ }}
						</a>
					</li>
				@endforeach
			</ul><!-- ./tabs -->
				
			<div class="tab-content">

				@php
					$counter = 1;
				@endphp
				@foreach ($banners as $section => $values)
					<div id="{{ $section }}-content" class="tab-pane{{ $counter === 1 ? " show active" : "" }}">
						<div class="mb-0 d-flex justify-content-end">
							<input type="checkbox" id="{{ $section }}-banners-switch" autocomplete="off"
								{{ $values->status == 1 ? "checked" : ""}}
								class="js-carousel-switch" data-switch="bool"/>
							<label for="{{ $section }}-banners-switch" data-on-label="On" data-off-label="Off"></label>
						</div>
						<div id="{{ $section }}-banners-row" class="js-banner-cnt row"
							data-importance="{{ $section }}">
							@foreach ($values->models as $model)
								<div class="col-md-6 col-lg-4">
									<!-- Simple card -->
									<div class="js-banner card d-block" data-model-id="{{ $model->id }}"
										data-namespace="{{ get_class($model) }}">
										<div class="embed-responsive embed-responsive-16by9">
											<img class="card-img-top embed-responsive-item" src="{{ $model->cover }}" alt="{{ $model->title }}">
										</div>
										<div class="card-body">
											<h5 class="card-title">{{ $model->title }}</h5>
											<p class="card-text">{{ $model->subtitle }}</p>
											<a href="javascript: void(0);" class="btn btn-primary">Button</a>
										</div> <!-- end card-body-->
									</div> <!-- end card-->
								</div><!-- end col -->
							@endforeach
						</div>
						<div class="mb-3 d-flex justify-content-end">
							<button class="btn btn-primary" data-toggle="modal"
								data-target="#edit-banners-modal" data-importance="{{ $section }}"
								data-modal-title="Carousel {{ $counter++ }}">Αλλαγή</button>
						</div>
					</div>
				@endforeach
			</div>

		</div>
	</div>
@endsection

@section('scripts')
	<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
	<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>

	<script src="{{ mix("js/dashboard/settings/home-page.js") }}"></script>
	
@endsection