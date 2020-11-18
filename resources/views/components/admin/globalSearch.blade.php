@php
	$count = count($users) + count($courses) + count($materials) + count($bundles);
@endphp

<div class="row mx-0">
	@if (count($users) > 0)
		<div class="col-auto">
			<h3 class="pl-3">
				<i class="mdi mdi-account-multiple mr-1"></i>
				<strong><u>Users</u></strong>
			</h3>
			@foreach ($users as $user)
				<a href="/dashboard/users/{{ $user->slug }}" class="dropdown-item notify-item">
					<div class="media">
						<img class="d-flex mr-2 rounded-circle" src="{{ $user->thumbnailUrl("avatar") }}" alt="User avatar" width="32" height="32">
						<div class="media-body">
							<h5 class="m-0 font-14">{{ $user->last_name }} {{ $user->first_name }}</h5>
							<span class="search-text-ellipsis font-12 mb-0">{{ $user->email }}</span>
						</div>
					</div>
				</a>
			@endforeach
		</div>
	@endif
	@if (count($courses) > 0)
		<div class="col-auto">
			<h3 class="pl-3">
				<i class="mdi mdi-label-multiple mr-1"></i>
				<strong><u>Courses</u></strong>
			</h3>
			@foreach ($courses as $course)
				<a href="/dashboard/course/{{ $course->slug }}" class="dropdown-item notify-item">
					<div class="media">
						<img class="d-flex mr-2 rounded-circle" src="{{ $course->thumbnailUrl() }}" alt="Course Cover" width="32" height="32">
						<div class="media-body">
							<h5 class="m-0 font-14">{{ $course->title }}</h5>
							<span class="search-text-ellipsis font-12 mb-0">{{ $course->slug }}</span>
						</div>
					</div>
				</a>
			@endforeach
		</div>
	@endif
	@if (count($materials) > 0)
		<div class="col-auto">
			<h3 class="pl-3">
				<i class="mdi mdi-book-open-page-variant mr-1"></i>
				<strong><u>Materials</u></strong>
			</h3>
			@foreach ($materials as $material)
				<a href="/dashboard/material/{{ $material->slug }}" class="dropdown-item notify-item">
					<div class="media">
						<img class="d-flex mr-2 rounded-circle" src="{{ $material->thumbnailUrl() }}" alt="Material Cover" width="32" height="32">
						<div class="media-body">
							<h5 class="m-0 font-14">{{ $material->title }}</h5>
							<span class="search-text-ellipsis font-12 mb-0">{{ $material->slug }}</span>
						</div>
					</div>
				</a>
			@endforeach
		</div>
	@endif
	@if (count($bundles) > 0)
		<div class="col-auto">
			<h3 class="pl-3">
				<i class="mdi mdi-package-variant mr-1"></i>
				<strong><u>Bundles</u></strong>
			</h3>
			@foreach ($bundles as $bundle)
				<a href="/dashboard/bundle/{{ $bundle->slug }}" class="dropdown-item notify-item">
					<div class="media">
						<img class="d-flex mr-2 rounded-circle" src="{{ $bundle->thumbnailUrl() }}" alt="Bundle Cover" width="32" height="32">
						<div class="media-body">
							<h5 class="m-0 font-14">{{ $bundle->title }}</h5>
							<span class="search-text-ellipsis font-12 mb-0">{{ $bundle->slug }}</span>
						</div>
					</div>
				</a>
			@endforeach
		</div>
	@endif
	{{-- <div class="col-6"></div> --}}
</div>
@if ( $count > 0 )
	<div class="row mx-0">
		<span class="py-2 d-block text-center mx-auto font-16">
			<i class="mdi mdi-magnify mr-1"></i>
			{{ $count }} απο τα {{ $totalCount }} αποτελέσματα
		</span>
	</div>
@else
<div class="row mx-0">
	<span class="py-2 d-block text-center mx-auto font-16">
		<i class="mdi mdi-magnify mr-1"></i>
		Δεν βρέθηκαν αποτελέσματα
	</span>
</div>
@endif
