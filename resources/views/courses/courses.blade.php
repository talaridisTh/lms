@extends("layouts.app")

@section("style")
@endsection

@section("content")

	<div class="content-page pt-3 mt-1">
		<div class="content">

			<div class="row">

				@foreach ($user->courses as $key => $course)

				@if ( $key % 4 == 0 )
					</div><div class="row">
				@endif

				<div class="col-md-6 col-xl-3">
					<!-- project card -->
					<div class="card d-block">
						<!-- project-thumbnail -->
						<img class="card-img-top" src='https://placehold.co/600x400' alt="project image cap">
						{{-- <div class="card-img-overlay">
							<div class="badge badge-secondary p-1">Ongoing</div>
						</div> --}}

						<div class="card-body position-relative">
							<!-- project title-->
							<h4 class="mt-0">
								<a href="/courses/course/{{ $course->id }}" class="text-title">{{ $course->title }}</a>
							</h4>

							<!-- project detail-->
							<p class="mb-3">
								<span class="pr-2 text-nowrap">
									<i class="mdi mdi-format-list-bulleted-type"></i>
									<b>{{ $course->materials->where('type', 'Lesson')->count() }}</b> Μαθήματα
								</span>
								<span class="text-nowrap">
									<i class="mdi mdi-comment-multiple-outline"></i>
									<b>{{ $course->materials->where('type', '!=', 'Lesson')->count() }}</b> Extras
								</span>
							</p>
							<div class="mb-3">
								{{ $course->description }}
							</div>

							<!-- project progress-->
							{{-- <p class="mb-2 font-weight-bold">Progress <span class="float-right">45%</span></p>
							<div class="progress progress-sm">
								<div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%;">
								</div><!-- /.progress-bar -->
							</div><!-- /.progress --> --}}
						</div> <!-- end card-body-->
					</div> <!-- end card-->
				</div> <!-- end col -->

				@endforeach

				{{-- <div class="col-md-6 col-xl-3">
					<!-- project card -->
					<div class="card d-block">
						<!-- project-thumbnail -->
						<img class="card-img-top" src="assets/images/projects/project-2.jpg" alt="project image cap">
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
						<img class="card-img-top" src="assets/images/projects/project-3.jpg" alt="project image cap">
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
						<img class="card-img-top" src="assets/images/projects/project-4.jpg" alt="project image cap">
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
				</div> <!-- end col --> --}}
			</div>
			<!-- end row-->


		</div>
	</div>



@endsection


@section("script")
@endsection


