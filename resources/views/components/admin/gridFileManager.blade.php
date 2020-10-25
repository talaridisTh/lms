<div class="row">
	@forelse ($files as $file)
		<div class="col-xl-2 col-lg-3 col-md-3 p-2
			position-relative css-img-cnt d-flex flex-column justify-content-center align-items-center">
			@if ( is_null($file->thumbnail_path) )
				{{-- <div class="position-relative"> --}}
					<div class="dropdown position-absolute" style="right: 20px; top: 20px;">
						<i class="h3 ml-2 mdi mdi-dots-vertical cursor-pointer image-overlay" data-toggle="dropdown"></i>
						<div class="dropdown-menu dropdown-menu-right dropdown-menu-animated py-0">
							<a href="#" class="dropdown-item">Details</a>
							<div class="dropdown-divider my-0"></div>
							<a href="#" class="dropdown-item">Download</a>
						</div>
					</div>
					@foreach ($icons as $type => $icon)
						@if ( fnmatch("$type*", $file->ext ) )
							<i class='font-120 fade-image mdi {{ $icon }}'></i>
							@break
						@endif
					@endforeach
					<p class="h5 text-center">{{ $file->name }}</p>
				{{-- </div> --}}
			@else
				<div class="position-relative">
					<div class="position-absolute" style="right: 20px; top: 20px; z-index: 1000">
						{{-- <i class="h3 ml-2 mdi mdi-dots-vertical cursor-pointer image-overlay" data-toggle="dropdown"></i> --}}
						{{-- <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated py-0"> --}}
							<a href="#" class="h5 custom-link-primary d-block">Details</a>
							{{-- <div class="dropdown-divider my-0"></div> --}}
							<a href="#" class="h5 custom-link-primary d-block">View</a>
							{{-- <div class="dropdown-divider my-0"></div> --}}
							<a href="#" class="h5 custom-link-primary d-block">Download</a>
						{{-- </div> --}}
					</div>
					<img class="fade-image img-fluid" src="{{ url($file->thumbnail_path) }}" alt="{{ $file->name }}">
				</div>
			@endif
		</div>
	@empty
		<h3 class="w-100 text-center">Δεν βρέθηκαν εικόνες</h3>
	@endforelse

</div>

{{ $files->links() }}