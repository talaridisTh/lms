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

	<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box">
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="/" class="custom-link-primary">Home</a></li>
						<li class="breadcrumb-item"><a href="/dashboard" class="custom-link-primary">Dashboard</a></li>
						<li class="breadcrumb-item active">Carousels</li>
					</ol>
				</div>
				<h4 class="page-title">Carousels</h4>
			</div>
		</div>
	</div><!-- end page title -->

	<div class="wrapper">
		<div class="content">

			<ul class="nav nav-tabs nav-bordered mb-3">
				<li class="nav-item">
					<a href="#primary-carousel" class="nav-link active"
						data-toggle="tab" aria-expanded="true">
						Primary
					</a>
				</li>
				<li class="nav-item">
					<a href="#secondary-carousel" class="nav-link"
						data-toggle="tab" aria-expanded="false">
						Secondary
					</a>
				</li>
			</ul><!-- ./tabs -->

			<div class="tab-content">
				@php $counter = true; @endphp
				@foreach ($banners as $section => $values)
					<div id="{{ $section }}-carousel" class="tab-pane{{ $counter ? " show active" : "" }}">
						<div class="d-flex justify-content-end align-items-center mb-1">
							<button type="button" class="btn btn-primary btn-sm"
								data-toggle="modal" data-target="#edit-banners-modal" data-importance="{{ $section }}"
								data-modal-title="Carousel {{ $counter }}" >Αλλαγή</button>
							<input type="checkbox" id="{{ $section }}-banners-switch" autocomplete="off"
								{{ !empty($values->status) && $values->status == 1 ? "checked" : ""}}
								class="js-carousel-switch" data-switch="success"/>
							<label for="{{ $section }}-banners-switch" class="ml-1 mb-0" data-on-label="On" data-off-label="Off"></label>
						</div>
						<div id="{{ $section }}-banners-row" class="js-banner-cnt row" data-plugin="dragula"
							data-importance="{{ $section }}">
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
												<img class="card-img-top embed-responsive-item" src="{{ $model->cardMediumUrl() }}" alt="{{ $model->title }}">
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
					@php $counter = false @endphp
				@endforeach
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
	<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>
	{{-- <script src="/assets/js/dragula.js"></script> --}}

	<script src="{{ mix("js/dashboard/settings/home-page.js") }}"></script>
	
@endsection