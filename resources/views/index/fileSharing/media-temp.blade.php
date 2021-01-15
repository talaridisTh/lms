@extends("layouts.app")

@section("style")
<style>
	.max-width-1400 {
		max-width: 1400px;
	}
</style>
@endsection

@section("content")
<div class="max-width-1400 m-auto text-gray-800">
	
	<div class="flex flex-wrap mt-4">
		<div class="w-full lg:w-4/12 text-center">
			@if ($media->type == 0)
				<figure class="figure">
					<img src="{{ $media->rel_path }}" class="w-full h-auto" alt="{{ $title }}">
					<figcaption class="figure-caption">{{ $caption }}</figcaption>
				</figure>
			@else
				@foreach ($icons as $key => $icon)

					@if (fnmatch("$key*", $media->ext ))
						<i class="mdi {{ $icon }}" style="font-size: 200px"></i>
					@endif
					
				@endforeach
			@endif
		</div>
		<div class="w-full lg:w-8/12 px-4">
			<h3 class="text-2xl font-semibold">{{ $title }}</h3>
			@if ( isset($media->mediaDetails) )
				<h5 class="mb-2">{{ $media->mediaDetails->subtitle }}</h5>
				<p >{!! $media->mediaDetails->description !!}</p>
			@endif

			<div class="text-right">
				<a class="inline-block mt-4 bg-login text-white rounded-full px-4 py-2 focus:outline-none" href="{{ $media->rel_path }}" class="btn btn-info" download>Download</a>
			</div>

		</div>
	</div>

</div>

@endsection

@section("script")
@endsection
