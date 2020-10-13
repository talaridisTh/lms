@extends('layouts.dashboard')

@section('css')
	
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
							<div id="gallery-content" data-model="App\Course" data-id={{ isset($course) ? $course->id : "" }}>
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

			{{-- <div class="card"><!-- ./card-editors --> --}}
				{{-- <div class="card-body"> --}}

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
						<li class="nav-item">
							<a href="#third-section" id="third-section-tab-btn"
								data-toggle="tab" aria-expanded="true" class="nav-link">
								Section 3
							</a>
						</li>
						<li class="nav-item">
							<a href="#fourth-section" id="fourth-section-tab-btn"
								data-toggle="tab" aria-expanded="true" class="nav-link">
								Section 4
							</a>
						</li>
						<li class="nav-item">
							<a href="#fifth-section" id="fifth-section-tab-btn"
								data-toggle="tab" aria-expanded="true" class="nav-link">
								Section 5
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
													{{ $statuses->first_section->content == 0 ? " checked" : "" }}/>
												<label class="custom-control-label" for="first-section-default">Default</label>
											</div>
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" id="first-section-custom" name="firstSection"
													class="custom-control-input" value="1"
													{{ $statuses->first_section->content == 1 ? " checked" : "" }}>
												<label class="custom-control-label" for="first-section-custom">Custom</label>
											</div>
											<input type="checkbox" id="first-section-switch" data-switch="bool" name="firstSectionStatus"
												{{ $statuses->first_section->status == 1 ? " checked" : ""}}/>
											<label class="mb-0" for="first-section-switch" data-on-label="On" data-off-label="Off"></label>
										</div>
									</div>
									<textarea class="form-control" id="first-section-textarea"
										name="firstSectionContent" rows="5">{{ $page->first_section }}</textarea>
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
													{{ $statuses->second_section->content == 0 ? " checked" : "" }}/>
												<label class="custom-control-label" for="second-section-default">Default</label>
											</div>
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" id="second-section-custom"
													name="secondSection" class="custom-control-input" value="1"
													{{ $statuses->second_section->content == 1 ? " checked" : "" }}>
												<label class="custom-control-label" for="second-section-custom">Custom</label>
											</div>
											<input type="checkbox" id="second-section-switch" data-switch="bool" name="secondSectionStatus"
												{{ $statuses->second_section->status == 1 ? " checked" : ""}}/>
											<label class="mb-0" for="second-section-switch" data-on-label="On" data-off-label="Off"></label>
										</div>
									</div>
									<textarea class="form-control" id="second-section-textarea"
										name="secondSectionContent" rows="5">{{ $page->second_section }}</textarea>
								</div>
							</div>
							<div id="third-section" class="tab-pane">
								<div class="form-group">
									<div class="d-flex justify-content-between">
										<label class="mb-0" for="third-section-textarea">Section 3</label>
										<div class="d-flex mb-1">
											<div class="custom-control custom-radio custom-control-inline">
												<input id="third-section-default" class="custom-control-input"
													type="radio" name="thirdSection" value="0"
													{{ $statuses->third_section->content == 0 ? " checked" : "" }}/>
												<label class="custom-control-label" for="third-section-default">Default</label>
											</div>
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" id="third-section-custom" value="1"
													name="thirdSection" class="custom-control-input" 
													{{ $statuses->third_section->content == 1 ? " checked" : "" }}>
												<label class="custom-control-label" for="third-section-custom">Custom</label>
											</div>
											<input type="checkbox" id="thitrd-section-switch" data-switch="bool" name="thirdSectionStatus"
												{{ $statuses->third_section->status == 1 ? " checked" : "" }}/>
											<label class="mb-0" for="thitrd-section-switch" data-on-label="On" data-off-label="Off"></label>
										</div>
									</div>
									<textarea class="form-control" id="third-section-textarea"
										name="thirdSectionContent" rows="5">{{ $page->third_section }}</textarea>
								</div>
							</div>
							<div id="fourth-section" class="tab-pane">
								<div class="form-group">
									<div class="d-flex justify-content-between">
										<label class="mb-0" for="fourth-section-textarea">Section 4</label>
										<div class="d-flex mb-1">
											<div class="custom-control custom-radio custom-control-inline">
												<input id="fourth-section-default" class="custom-control-input"
													type="radio" name="fourthSection" value="0"
													{{ $statuses->fourth_section->content == 0 ? " checked" : "" }}/>
												<label class="custom-control-label" for="fourth-section-default">Default</label>
											</div>
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" id="fourth-section-custom" name="fourthSection"
													class="custom-control-input" value="1"
													{{ $statuses->fourth_section->content == 1 ? " checked" : "" }}>
												<label class="custom-control-label" for="fourth-section-custom">Custom</label>
											</div>
											<input type="checkbox" id="fourth-section-switch" data-switch="bool"  name="fourthSectionStatus"
												{{ $statuses->fourth_section->status == 1 ? " checked" : "" }}/>
											<label class="mb-0" for="fourth-section-switch" data-on-label="On" data-off-label="Off"></label>
										</div>
									</div>
									<textarea class="form-control" id="fourth-section-textarea"
										name="fourthSectionContent" rows="5">{{ $page->fourth_section }}</textarea>
								</div>
							</div>
							<div id="fifth-section" class="tab-pane">
								<div class="form-group">
									<div class="d-flex justify-content-between">
										<label class="mb-0" for="fifth-section-textarea">Section 5</label>
										<div class="d-flex mb-1">
											<div class="custom-control custom-radio custom-control-inline">
												<input id="fifth-section-default" class="custom-control-input"
													type="radio" name="fifthSection" value="0"
													{{ $statuses->fifth_section->content == 0 ? " checked" : "" }}/>
												<label class="custom-control-label" for="fifth-section-default">Default</label>
											</div>
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" id="fifth-section-custom" name="fifthSection"
													class="custom-control-input" value="1"
													{{ $statuses->fifth_section->content == 1 ? " checked" : "" }}>
												<label class="custom-control-label" for="fifth-section-custom">Custom</label>
											</div>
											<input type="checkbox" id="fifth-section-switch" data-switch="bool" name="fifthSectionStatus"
												{{ $statuses->fifth_section->status == 1 ? " checked" : "" }}/>
											<label class="mb-0" for="fifth-section-switch" data-on-label="On" data-off-label="Off"></label>
										</div>
									</div>
									<textarea class="form-control" id="fifth-section-textarea"
										name="fifthSectionContent" rows="5">{{ $page->fifth_section }}</textarea>
								</div>
							</div>

						</div><!-- ./tab-content -->
					</form>

					<div class="mb-3 d-flex justify-content-end">
						<button form="home-form" type="submit" class="btn btn-primary">Αποθήκευση</button>
					</div>
				{{-- </div><!-- ./card-body --> --}}
			{{-- </div><!-- ./card-editors --> --}}

					
			{{-- <div class="card"> --}}
				{{-- <div class="card-body"> --}}

				
					<ul class="nav nav-tabs nav-bordered my-3">
						<li class="nav-item">
							<a href="#primary-content" id="primary-content-tab-btn"
								data-toggle="tab" aria-expanded="false" class="nav-link active">
								Carousel 1
							</a>
						</li>
						<li class="nav-item">
							<a href="#secondary-content" id="secondary-content-tab-btn"
								data-toggle="tab" aria-expanded="true" class="nav-link">
								Carousel 2
							</a>
						</li>
						<li class="nav-item">
							<a href="#tertiary-content" id="tertiary-content-tab-btn"
								data-toggle="tab" aria-expanded="true" class="nav-link">
								Carousel 3
							</a>
						</li>
					</ul><!-- ./tabs -->
				
					<div class="tab-content">
						<div id="primary-content" class="tab-pane show active">
							<div class="row">
								@foreach ($sixthSection as $model)
									<div class="col-md-6 col-lg-4">
										<!-- Simple card -->
										<div class="card d-block">
											<div class="embed-responsive embed-responsive-16by9">
												<img class="card-img-top embed-responsive-item" src="{{ $model->cover }}" alt="Card image cap">
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
						</div>
						<div id="secondary-content" class="tab-pane">
							<div class="row">
								@foreach ($seventhSection as $model)
									<div class="col-md-6 col-lg-4">
										<!-- Simple card -->
										<div class="card d-block">
											<div class="embed-responsive embed-responsive-16by9">
												<img class="card-img-top embed-responsive-item" src="{{ $model->cover }}" alt="Card image cap">
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
						</div>
						<div id="tertiary-content" class="tab-pane">
							<div class="row">
								@foreach ($eighthSection as $model)
									<div class="col-md-6 col-lg-4">
										<!-- Simple card -->
										<div class="card d-block">
											<div class="embed-responsive embed-responsive-16by9">
												<img class="card-img-top embed-responsive-item" src="{{ $model->cover }}" alt="Card image cap">
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
						</div>
					</div>

				{{-- </div><!-- ./card-body --> --}}
			{{-- </div><!-- ./card --> --}}

		</div>
	</div>
@endsection

@section('scripts')

	<script src="{{ mix("js/dashboard/settings/home-page.js") }}"></script>
	
@endsection