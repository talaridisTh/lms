@extends('layouts.dashboard')

@section('css')
	
@endsection

@section('content')

	<div class="wrapper">
		<div class="content">

			<h3 class="my-3">Αποτελέσματα για "{{ $search }}"</h3>

			<!-- tabs -->
			<ul class="nav nav-tabs nav-bordered mb-3">
				@php $assignActive = true @endphp
				@foreach (get_defined_vars() as $key => $variable)
					@php
						$allowed = ["users", "materials", "courses", "bundles"]
					@endphp
					@if ( in_array($key, $allowed) && !$variable->isEmpty() )
						<li class="nav-item">
							<a id="{{ $key }}-tab-btn" class="nav-link{{ $assignActive ? " active" : "" }}"
								href="#{{ $key }}" data-toggle="tab" aria-expanded="false">
								@if ($key == "users" || $key == "materials")
									{{ $key == "users" ? "Χρήστες" : "Μαθήματα"}}
								@else
									{{ ucfirst( $key ) }}
								@endif
							</a>
						</li>
						@php $assignActive = false @endphp
					@endif
				@endforeach
			</ul><!-- ./tabs -->

			<div class="tab-content">
				@php $assignActive = true @endphp
				@foreach (get_defined_vars() as $keys => $variable)
					@php
						$allowed = ["users", "materials", "courses", "bundles"]
					@endphp
					@if ( in_array($keys, $allowed) && !$variable->isEmpty() )
						@if ($keys == "users")
							<div id="users" class="tab-pane show active">
								<div class="row">
									@foreach ($users as $user)
										<div class="col-lg-6 col-xl-4">
											<div class="card">
												<div class="row no-gutters align-items-center">
													<div class="col-md-4 text-center">
														<img class="img-fluid" src="{{ $user->cover }}" />
													</div>
													<div class="col-md-8">
														<div class="card-body">
															<div class="d-flex justify-content-between">
																<h5 class="card-title overflow-ellipsis mb-1" data-toggle="tooltip"
																	title="{{ $user->last_name }} {{ $user->first_name }}"
																	data-original-title="{{ $user->last_name }} {{ $user->first_name }}">
																	{{ $user->last_name }} {{ $user->first_name }}
																</h5>
																<div>
																	<span class="badge {{ $user->status == 1 ? "badge-success-lighten" : "badge-danger-lighten" }} badge-pill">
																		{{ $user->status == 1 ? "Active" : "Inactive" }}
																	</span>
																</div>
															</div>
															<p class="card-text mb-3">{{ $user->roles[0]->name }}</p>
															<p class="card-text mb-1 overflow-ellipsis" data-toggle="tooltip"
																data-original-title="{{ $user->email }}" title="{{ $user->email }}">
																{{ $user->email }}
															</p>
															<p class="card-text">{{ $user->phone }}</p>
															<a class="custom-link-primary font-16" href="/dashboard/users/{{ $user->slug }}">Edit</a>
														</div> <!-- end card-body-->
													</div> <!-- end col -->
												</div> <!-- end row-->
											</div> <!-- end card-->
										</div> <!-- end col-->
									@endforeach
								</div><!-- end row -->
							</div><!-- end tab -->
						@else
							<div id="{{ $keys }}" class="tab-pane{{ $assignActive ? " show active" : "" }}">
								<div class="row">
									@foreach ($variable as $model)
										<div class="col-md-6 col-lg-3">
											<div class="card d-block">
												<img class="card-img-top" src="{{ $model->cover }}" alt="{{ $model->title }}">
												<div class="card-body">
													<h5 class="card-title">{{ $model->title }}</h5>
													<p class="card-text">{{ $model->subtitle }}</p>
												</div>
												<div class="card-body">
													<a href="/dashboard/{{ substr($keys, 0, -1) }}/{{ $model->slug }}" class="custom-link-primary card-link text-custom">Edit</a>
													<a href="/{{ substr($keys, 0, -1) }}/{{ $model->slug }}" class="custom-link-primary card-link text-custom">View</a>
												</div> <!-- end card-body-->
											</div> <!-- end card-->
										</div><!-- end col -->
									@endforeach
								</div><!-- end row -->
							</div><!-- end tab -->
						@endif
						@php $assignActive = false @endphp
					@endif
				@endforeach

			</div><!-- end tab-content -->
		</div><!-- end content -->
	</div><!-- end wrapper -->
	
@endsection

@section('scripts')
	
@endsection