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
			
			<div class="row">
				<div class="col-lg-6 col-xl-4">
					<h4 class="page-title text-center">Δημοφιλέστερα Courses</h4>
					<canvas id="top-courses" width="400" height="300"></canvas>

					@foreach ($topCourses as $course)
						<span class="js-top-courses" data-title="{{ $course->title }}"
							data-students="{{ $course->students }}"></span>
					@endforeach
				</div>
				<div class="col-lg-6 col-xl-4">
					<h4 class="page-title text-center">Δημοφιλέστερα Bundles</h4>
					<canvas id="top-bundles" width="400" height="300"></canvas>

					@foreach ($topBundles as $bundle)
						<span class="js-top-bundles" data-title="{{ $bundle->title }}"
							data-students="{{ $bundle->students }}"></span>
					@endforeach
					
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6 col-xl-4">

				</div>
				<div class="col-lg-6 col-xl-4">

				</div>
			</div>






		</div>
	</div>

@endsection

@section('scripts')
	<script src="{{ mix("js/dashboard/overview/overview.js") }}"></script>

	<script>
		
	</script>
@endsection