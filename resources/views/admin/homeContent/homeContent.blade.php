@extends('layouts.dashboard')

@section('css')
	
@endsection

@section('content')

	{{-- @dd($primaryAdvertisement) --}}
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

					<div class="tab-content">
						<div id="first-section" class="tab-pane show active">
							<div class="form-group">
								<div class="d-flex justify-content-between">
									<label class="mb-0" for="first-section-textarea">Section 1</label>
									<div class="d-flex mb-1">
										<div class="custom-control custom-radio custom-control-inline">
											<input id="first-section-default" class="custom-control-input"
												type="radio" name="firstSection"{{ $statuses->first_section->content == 0 ? " checked" : "" }}/>
											<label class="custom-control-label" for="first-section-default">Default</label>
										</div>
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="first-section-custom" name="firstSection"
												class="custom-control-input"{{ $statuses->first_section->content == 1 ? " checked" : "" }}>
											<label class="custom-control-label" for="first-section-custom">Custom</label>
										</div>
										<input type="checkbox" id="switch1" data-switch="bool"{{ $statuses->first_section->status == 1 ? " checked" : ""}}/>
										<label class="mb-0" for="switch1" data-on-label="On" data-off-label="Off"></label>
									</div>
								</div>
							    <textarea class="form-control" id="first-section-textarea" rows="5">{{ $page->first_section }}</textarea>
							</div>
						</div>
						<div id="second-section" class="tab-pane">
							<div class="form-group">
								<div class="d-flex justify-content-between">
									<label class="mb-0" for="second-section-textarea">Section 2</label>
									<div class="d-flex mb-1">
										<div class="custom-control custom-radio custom-control-inline">
											<input id="second-section-default" class="custom-control-input"
												type="radio" name="secondSection"{{ $statuses->second_section->content == 0 ? " checked" : "" }}/>
											<label class="custom-control-label" for="second-section-default">Default</label>
										</div>
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="second-section-custom"
												name="secondSection" class="custom-control-input"{{ $statuses->second_section->content == 1 ? " checked" : "" }}>
											<label class="custom-control-label" for="second-section-custom">Custom</label>
										</div>
										<input type="checkbox" id="switch1" data-switch="bool"
											{{ $statuses->second_section->status == 1 ? " checked" : ""}}/>
										<label class="mb-0" for="switch1" data-on-label="On" data-off-label="Off"></label>
									</div>
								</div>
							    <textarea class="form-control" id="second-section-textarea" rows="5">{{ $page->second_section }}</textarea>
							</div>
						</div>
						<div id="third-section" class="tab-pane">
							<div class="form-group">
								<div class="d-flex justify-content-between">
									<label class="mb-0" for="third-section-textarea">Section 3</label>
									<div class="d-flex mb-1">
										<div class="custom-control custom-radio custom-control-inline">
											<input id="third-section-default" class="custom-control-input"
												type="radio" name="thirdSection"{{ $statuses->third_section->content == 0 ? " checked" : "" }}/>
											<label class="custom-control-label" for="third-section-default">Default</label>
										</div>
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="third-section-custom"
												name="thirdSection" class="custom-control-input"{{ $statuses->third_section->content == 1 ? " checked" : "" }}>
											<label class="custom-control-label" for="third-section-custom">Custom</label>
										</div>
										<input type="checkbox" id="switch1" data-switch="bool"
											{{ $statuses->third_section->status == 1 ? " checked" : "" }}/>
										<label class="mb-0" for="switch1" data-on-label="On" data-off-label="Off"></label>
									</div>
								</div>
    							<textarea class="form-control" id="third-section-textarea" rows="5">{{ $page->third_section }}</textarea>
							</div>
						</div>
						<div id="fourth-section" class="tab-pane">
							<div class="form-group">
								<div class="d-flex justify-content-between">
									<label class="mb-0" for="fourth-section-textarea">Section 4</label>
									<div class="d-flex mb-1">
										<div class="custom-control custom-radio custom-control-inline">
											<input id="fourth-section-default" class="custom-control-input"
												type="radio" name="fourthSection"{{ $statuses->fourth_section->content == 0 ? " checked" : "" }}/>
											<label class="custom-control-label" for="fourth-section-default">Default</label>
										</div>
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="fourth-section-custom" name="fourthSection"
												class="custom-control-input"{{ $statuses->fourth_section->content == 1 ? " checked" : "" }}>
											<label class="custom-control-label" for="fourth-section-custom">Custom</label>
										</div>
										<input type="checkbox" id="switch1" data-switch="bool"
											{{ $statuses->fourth_section->status == 1 ? " checked" : "" }}/>
										<label class="mb-0" for="switch1" data-on-label="On" data-off-label="Off"></label>
									</div>
								</div>
    							<textarea class="form-control" id="fourth-section-textarea" rows="5">{{ $page->fourth_section }}</textarea>
							</div>
						</div>
						<div id="fifth-section" class="tab-pane">
							<div class="form-group">
								<div class="d-flex justify-content-between">
									<label class="mb-0" for="fifth-section-textarea">Section 5</label>
									<div class="d-flex mb-1">
										<div class="custom-control custom-radio custom-control-inline">
											<input id="fifth-section-default" class="custom-control-input"
												type="radio" name="fifthSection"{{ $statuses->fifth_section->content == 0 ? " checked" : "" }}/>
											<label class="custom-control-label" for="fifth-section-default">Default</label>
										</div>
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="fifth-section-custom" name="fifthSection"
												class="custom-control-input"{{ $statuses->fifth_section->content == 1 ? " checked" : "" }}>
											<label class="custom-control-label" for="fifth-section-custom">Custom</label>
										</div>
										<input type="checkbox" id="switch1" data-switch="bool"
											{{ $statuses->fifth_section->status == 1 ? " checked" : "" }}/>
										<label class="mb-0" for="switch1" data-on-label="On" data-off-label="Off"></label>
									</div>
								</div>
    							<textarea class="form-control" id="fifth-section-textarea" rows="5">{{ $page->fifth_section }}</textarea>
							</div>
						</div>
					
					</div><!-- ./tab-content -->

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
											<img class="card-img-top" src="{{ $model->cover }}" alt="Card image cap">
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
											<img class="card-img-top" src="{{ $model->cover }}" alt="Card image cap">
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
											<img class="card-img-top" src="{{ $model->cover }}" alt="Card image cap">
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
	
@endsection