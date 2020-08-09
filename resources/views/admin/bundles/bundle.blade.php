@extends('layouts.dashboard')

@section('css')
	
@endsection

@section('content')
		
		<!-- start page title -->
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
							<li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
							<li class="breadcrumb-item active">Projects</li>
						</ol>
					</div>
					<h4 class="page-title">{{ $bundle->name }}</h4>
				</div>
			</div>
		</div>     
		<!-- end page title --> 

		<div class="row mb-2">
			<div class="col-sm-4">
				<a href="apps-projects-add.html" class="btn btn-danger btn-rounded mb-3"><i class="mdi mdi-plus"></i> Create Project</a>
			</div>
			<div class="col-sm-8">
				<div class="text-sm-right">
					<div class="btn-group mb-3">
						<button type="button" class="btn btn-primary">All</button>
					</div>
					<div class="btn-group mb-3 ml-1">
						<button type="button" class="btn btn-light">Active</button>
						<button type="button" class="btn btn-light">Inactive</button>
					</div>
					<div class="btn-group mb-3 ml-2 d-none d-sm-inline-block">
						<button type="button" class="btn btn-secondary"><i class="dripicons-view-apps"></i></button>
					</div>
					<div class="btn-group mb-3 d-none d-sm-inline-block">
						<button type="button" class="btn btn-link text-muted"><i class="dripicons-checklist"></i></button>
					</div>
				</div>
			</div><!-- end col-->
		</div> 
		<!-- end row-->

{{-- @dd($bundle->courses->materials) --}}


<div class="row">

	@foreach ($bundle->courses as $key => $course)

		@php $badge = $course->active ? "badge-success" : "badge-danger" @endphp
		@php $message = $course->active ? "Active" : "Inactive" @endphp
		@php $authorCount = 0 @endphp

		@foreach ( $course->materials->where('type', "Lesson") as $material )

			@php $authorCount += $material->users->count() @endphp

		@endforeach

		@if ( ($key / 4 == 0) && ($key != 4) )
			
			</div><div class="row">

		@endif
		<div class="col-md-6 col-xl-3">
			<!-- project card -->
			<div class="card d-block">
				<!-- project-thumbnail -->
				<img class="card-img-top" src="https://via.placeholder.com/500x260" alt="project image cap">
				<div class="card-img-overlay">
					<div class="badge {{ $badge }} p-1">{{ $message }}</div>
				</div>
	
				<div class="card-body position-relative">
					<!-- project title-->
					<h4 class="mt-0">
						<a href="apps-projects-details.html" class="text-title">{{ $course->name }}</a>
					</h4>
	
					<!-- project detail-->
					<p class="mb-3">
						<span class="pr-2 text-nowrap">
							<i class="mdi mdi-format-list-bulleted-type"></i>
						<b>{{ $course->materials->where('type', 'Lesson')->count() }}</b> Μαθήματα
						</span>
						<span class="text-nowrap">
							<i class="mdi mdi-comment-multiple-outline"></i>
						<b>{{ $authorCount }}</b> Εισηγητές
						</span>
					</p>
					<div class="mb-3">
						<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Mat Helme" class="d-inline-block">
							<img src="assets/images/users/avatar-3.jpg" class="rounded-circle avatar-xs" alt="friend">
						</a>
	
						<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Michael Zenaty" class="d-inline-block">
							<img src="assets/images/users/avatar-5.jpg" class="rounded-circle avatar-xs" alt="friend">
						</a>
	
						<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="James Anderson" class="d-inline-block">
							<img src="assets/images/users/avatar-9.jpg" class="rounded-circle avatar-xs" alt="friend">
						</a>
					</div>
	
					<!-- project progress-->
					<p class="mb-2 font-weight-bold">Progress <span class="float-right">45%</span></p>
					<div class="progress progress-sm">
						<div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%;">
						</div><!-- /.progress-bar -->
					</div><!-- /.progress -->
				</div> <!-- end card-body-->
			</div> <!-- end card-->
		</div> <!-- end col -->
		{{-- @dump($course->materials) --}}
	@endforeach


</div>
	

			{{-- <div class="col-md-6 col-xl-3">
				<!-- project card -->
				<div class="card d-block">
					<!-- project-thumbnail -->
					<img class="card-img-top" src="https://via.placeholder.com/500x260" alt="project image cap">
					<div class="card-img-overlay">
						<div class="badge badge-success p-1">Finished</div>
					</div>

					<div class="card-body position-relative">
						<!-- project title-->
						<h4 class="mt-0">
							<a href="apps-projects-details.html" class="text-title">Landing page design - Home</a>
						</h4>

						<!-- project detail-->
						<p class="mb-3">
							<span class="pr-2 text-nowrap">
								<i class="mdi mdi-format-list-bulleted-type"></i>
								<b>11</b> Tasks
							</span>
							<span class="text-nowrap">
								<i class="mdi mdi-comment-multiple-outline"></i>
								<b>254</b> Comments
							</span>
						</p>
						<div class="mb-3">
							<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Mat Helme" class="d-inline-block">
								<img src="assets/images/users/avatar-10.jpg" class="rounded-circle avatar-xs" alt="friend">
							</a>

							<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Michael Zenaty" class="d-inline-block">
								<img src="assets/images/users/avatar-5.jpg" class="rounded-circle avatar-xs" alt="friend">
							</a>

							<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="James Anderson" class="d-inline-block">
								<img src="assets/images/users/avatar-7.jpg" class="rounded-circle avatar-xs" alt="friend">
							</a>
							<a href="javascript:void(0);" class="d-inline-block text-muted font-weight-bold ml-2">
								+2 more
							</a>
						</div>

						<!-- project progress-->
						<p class="mb-2 font-weight-bold">Progress <span class="float-right">100%</span></p>
						<div class="progress progress-sm">
							<div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
							</div><!-- /.progress-bar -->
						</div><!-- /.progress -->
					</div> <!-- end card-body-->
				</div> <!-- end card-->
			</div> <!-- end col -->

			<div class="col-md-6 col-xl-3">
				<!-- project card -->
				<div class="card d-block">
					<!-- project-thumbnail -->
					<img class="card-img-top" src="https://via.placeholder.com/500x260" alt="project image cap">
					<div class="card-img-overlay">
						<div class="badge badge-secondary p-1">Ongoing</div>
					</div>

					<div class="card-body position-relative">
						<!-- project title-->
						<h4 class="mt-0">
							<a href="apps-projects-details.html" class="text-title">Product page redesign</a>
						</h4>

						<!-- project detail-->
						<p class="mb-3">
							<span class="pr-2 text-nowrap">
								<i class="mdi mdi-format-list-bulleted-type"></i>
								<b>21</b> Tasks
							</span>
							<span class="text-nowrap">
								<i class="mdi mdi-comment-multiple-outline"></i>
								<b>668</b> Comments
							</span>
						</p>
						<div class="mb-3">
							<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Mat Helme" class="d-inline-block">
								<img src="assets/images/users/avatar-6.jpg" class="rounded-circle avatar-xs" alt="friend">
							</a>

							<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Michael Zenaty" class="d-inline-block">
								<img src="assets/images/users/avatar-7.jpg" class="rounded-circle avatar-xs" alt="friend">
							</a>

							<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="James Anderson" class="d-inline-block">
								<img src="assets/images/users/avatar-8.jpg" class="rounded-circle avatar-xs" alt="friend">
							</a>
							<a href="javascript:void(0);" class="d-inline-block text-muted font-weight-bold ml-2">
								+5 more
							</a>
						</div>

						<!-- project progress-->
						<p class="mb-2 font-weight-bold">Progress <span class="float-right">71%</span></p>
						<div class="progress progress-sm">
							<div class="progress-bar" role="progressbar" aria-valuenow="71" aria-valuemin="0" aria-valuemax="100" style="width: 71%;">
							</div><!-- /.progress-bar -->
						</div><!-- /.progress -->
					</div> <!-- end card-body-->
				</div> <!-- end card-->
			</div> <!-- end col -->

			<div class="col-md-6 col-xl-3">
				<!-- project card -->
				<div class="card d-block">
					<!-- project-thumbnail -->
					<img class="card-img-top" src="https://via.placeholder.com/500x260" alt="project image cap">
					<div class="card-img-overlay">
						<div class="badge badge-secondary p-1">Ongoing</div>
					</div>

					<div class="card-body position-relative">
						<!-- project title-->
						<h4 class="mt-0">
							<a href="apps-projects-details.html" class="text-title">Coffee detail page - Main Page</a>
						</h4>

						<!-- project detail-->
						<p class="mb-3">
							<span class="pr-2 text-nowrap">
								<i class="mdi mdi-format-list-bulleted-type"></i>
								<b>18</b> Tasks
							</span>
							<span class="text-nowrap">
								<i class="mdi mdi-comment-multiple-outline"></i>
								<b>259</b> Comments
							</span>
						</p>
						<div class="mb-3">
							<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Mat Helme" class="d-inline-block">
								<img src="assets/images/users/avatar-2.jpg" class="rounded-circle avatar-xs" alt="friend">
							</a>

							<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Michael Zenaty" class="d-inline-block">
								<img src="assets/images/users/avatar-3.jpg" class="rounded-circle avatar-xs" alt="friend">
							</a>
						</div>

						<!-- project progress-->
						<p class="mb-2 font-weight-bold">Progress <span class="float-right">52%</span></p>
						<div class="progress progress-sm">
							<div class="progress-bar" role="progressbar" aria-valuenow="52" aria-valuemin="0" aria-valuemax="100" style="width: 52%;">
							</div><!-- /.progress-bar -->
						</div><!-- /.progress -->
					</div> <!-- end card-body-->
				</div> <!-- end card-->
			</div> <!-- end col -->
		</div> --}}
		<!-- end row-->
		

@endsection

@section('scripts')
	
@endsection