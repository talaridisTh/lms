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
						<li class="breadcrumb-item"><a href="/" class="custom-link-primary">Home</a></li>
						<li class="breadcrumb-item active">Dashboard</li>
					</ol>
				</div>
				<h4 class="page-title">Overview</h4>
			</div>
		</div>
	</div>
	<!-- end page title -->

	<div class="wrapper">
		<div class="content">

			<div class="row">
				<div class="col-12">
					<div class="card widget-inline">
						<div class="card-body p-0">
							<div class="row no-gutters">

								<div class="col-sm-6 col-xl-3">
									<div class="card shadow-none m-0 border-left">
										<div class="card-body text-center">
											<i class="dripicons-user-group text-muted" style="font-size: 24px;"></i>
											<h3><span>{{ $totalStudents }}</span></h3>
											<p class="text-muted font-15 mb-0">Ενεργοί Μαθητές</p>
										</div>
									</div>
								</div>

								<div class="col-sm-6 col-xl-3">
									<div class="card shadow-none m-0 border-left">
										<div class="card-body text-center">
											<i class="uil uil-books text-muted" style="font-size: 24px;"></i>
											<h3><span>{{ $totalCourses }}</span></h3>
											<p class="text-muted font-15 mb-0">Σύνολο Course</p>
										</div>
									</div>
								</div>
	
								<div class="col-sm-6 col-xl-3">
									<div class="card shadow-none m-0 border-left">
										<div class="card-body text-center">
											<i class="mdi mdi-book-open-page-variant text-muted" style="font-size: 24px;"></i>
											<h3><span>{{ $totalLessons }}</span></h3>
											<p class="text-muted font-15 mb-0">Σύνολο Μαθημάτων</p>
										</div>
									</div>
								</div>
	
								<div class="col-sm-6 col-xl-3">
									<div class="card shadow-none m-0 border-left">
										<div class="card-body text-center">
											<i class="mdi mdi-chart-bubble text-muted" style="font-size: 24px;"></i>
											<h3><span>{{ $totalBundles }}</span></h3>
											<p class="text-muted font-15 mb-0">Σύνολο Bundle</p>
										</div>
									</div>
								</div>
	
							</div> <!-- end row -->
						</div>
					</div> <!-- end card-box-->
				</div> <!-- end col-->
			</div><!-- end row-->
			
			<div class="card">
				<div class="pb-0 card-body">
					<h5 class="card-title text-center" style="margin-bottom: 1.79rem;">Νέοι μαθητές ανα μήνα</h5>
					<div>
						<canvas id="new-students-per-month" width="400" height="200" data-data="{{ $usersPerMonth }}"></canvas>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6 col-xl-4 mb-3">
					
					<div class="card h-100">
						<div class="pb-0 card-body {{ $topCourses->isEmpty() ? "d-none " : "" }}flex-column justify-content-start align-items-center">
							<h5 class="card-title text-center" style="margin-bottom: 1.79rem;">Δημοφιλέστερα Courses</h5>
					
							<div style="width:400px; height: 300px;">
								<canvas id="top-courses" width="400" height="300"></canvas>
							</div>
						</div>

						<div class="card-body{{ $topCourses->isEmpty() ? " d-flex " : " d-none " }}flex-column justify-content-start">
							<h5 class="card-title text-center" style="margin-bottom: 1.79rem;">Δημοφιλέστερα Courses</h5>
							<div class="callout callout-danger my-auto">
								<h5 class="text-center">Δεν υπάρχουν Courses</h5>
							</div>
						</div>
					</div>
					
					@foreach ($topCourses as $course)
						<span class="js-top-courses" data-title="{{ $course->title }}"
							data-students="{{ $course->students }}"></span>
					@endforeach
				</div>
				<div class="col-lg-6 col-xl-8 mb-3">

					<div class="card h-100">
						<div class="pb-0 card-body{{ $recentCourses->isEmpty() ? " d-none" : "" }}">
							<h5 class="card-title text-center mb-3">Πρόσφατα Courses</h5>
							<table class="table table-hover table-centered mb-0">
								<thead>
									<tr>
										<th class="text-center">Τίτλος</th>
										<th class="text-center">Εισηγητής</th>
									</tr>
								</thead>
								<tbody>
									@php
										$now = new DateTime("now");
									@endphp
										@foreach ($recentCourses as $course)
										<tr>
											@php
												$date2 = new DateTime($course->created_at);
												$interval = $now->diff($date2);

												if ($interval->d < 7 && $interval->m === 0) {
													$badgeStyle = "badge-success-lighten";
												}
												elseif ($interval->d > 7 && $interval->d < 31 && $interval->m === 0) {
													$badgeStyle = "badge-warning-lighten";
												}
												else {
													$badgeStyle = "badge-danger-lighten";
												}
											@endphp
											<td>
												{{ $course->title }}
												<span class="ml-2 badge {{ $badgeStyle }} badge-pill">
													{{ $course->created_at->diffForHumans() }}
												</span>
											</td>
											<td>
												@if ( is_null($course->user_id) )
													<p class="text-center mb-0">-</p>	
												@else
													{{ $course->curator->last_name }} {{ $course->curator->first_name }}
												@endif
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="card-body{{ $recentCourses->isEmpty() ? " d-flex " : " d-none " }}flex-column justify-content-start">
							<h5 class="card-title text-center" style="margin-bottom: 1.79rem;">Πρόσφατα Courses</h5>
							<div class="callout callout-danger my-auto">
								<h5 class="text-center">Δεν υπάρχουν Courses</h5>
							</div>
						</div>
					</div><!-- ./card -->
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6 col-xl-4 mb-3">
					<div class="card h-100">
						<div class="pb-0 card-body {{ $coursesPerTopic === "[]" ? "d-none " : "d-flex " }}flex-column justify-content-start align-items-center">
							<h5 class="card-title text-center" style="margin-bottom: 1.79rem;">Courses ανα topic</h5>
							<div style="height: 300px;">
								<canvas id="courses-per-topic" width="400" height="300" data-topic-stats="{{ $coursesPerTopic }}"></canvas>
							</div>
						</div>
						<div class="card-body{{ $coursesPerTopic === "[]" ? " d-flex " : " d-none " }}flex-column justify-content-start">
							<h5 class="card-title text-center" style="margin-bottom: 1.79rem;">Courses ανα topic</h5>
							<div class="callout callout-danger my-auto">
								<h5 class="text-center">Δεν υπάρχουν Courses</h5>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-6 col-xl-4 mb-3">
					<div class="card h-100">
						<div class="pb-0 card-body{{ $topInstructors->isEmpty() ? " d-none" : "" }}">
							<h5 class="card-title text-center mb-3">Δραστηριότητα Εισηγητών</h5>
							<table class="table table-hover table-centered mb-0">
								<thead>
									<tr>
										<th class="text-center">Ονοματεπώνυμο</th>
										<th class="text-center">Courses</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($topInstructors as $users)
										<tr>
											<td>{{ $users->last_name }} {{ $users->first_name }}</td>
											<td class="text-center">{{ $users->courses }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="card-body{{ $topInstructors->isEmpty() ? " d-flex " : " d-none " }}flex-column justify-content-start">
							<h5 class="card-title text-center mb-3">Δραστηριότητα Εισηγητών</h5>
							<div class="callout callout-danger my-auto">
								<h5 class="text-center">Δεν υπάρχουν Εισηγητές</h5>
							</div>
						</div><!-- ./card-body -->
					</div><!-- ./card -->
				</div>

				<div class="col-lg-6 col-xl-4 mb-3">
					<div class="card h-100">
						<div class="pb-0 card-body {{ $topBundles->isEmpty() ? "d-none " : "d-flex " }}flex-column justify-content-start align-items-center">
							<h5 class="card-title text-center" style="margin-bottom: 1.79rem;">Δημοφιλέστερα Bundles</h5>
							<div style="height: 300px;">
								<canvas id="top-bundles" width="400" height="300"></canvas>
							</div>
						</div><!-- ./card-body -->
						<div class="card-body{{ $topBundles->isEmpty() ? " d-flex " : " d-none " }}flex-column justify-content-start">
							<h5 class="card-title text-center" style="margin-bottom: 1.79rem;">Δημοφιλέστερα Bundles</h5>
							<div class="callout callout-danger my-auto">
								<h5 class="text-center">Δεν υπάρχουν Bundles</h5>
							</div>
						</div><!-- ./card-body -->
					</div><!-- ./card -->

					@foreach ($topBundles as $bundle)
						<span class="js-top-bundles" data-title="{{ $bundle->title }}"
							data-students="{{ $bundle->students }}"></span>
					@endforeach
				</div>				
			</div>

		</div>
	</div>

@endsection

@section('scripts')
	<script src="{{ mix("js/dashboard/overview/overview.js") }}"></script>
@endsection