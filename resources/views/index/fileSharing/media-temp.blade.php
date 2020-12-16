@extends("layouts.app")

@section("style")
<style>
	.max-width-1400 {
		max-width: 1400px;
	}
</style>
@endsection

@section("content")
<div class="max-width-1400 m-auto">
	
	<div class="row mt-4">
		<div class="col-4 text-center">
			@if ($media->type == 0)
				<figure class="figure">
					<img src="{{ $media->rel_path }}" class="figure-img img-fluid rounded" alt="{{ $media->mediaDetails->title }}">
					<figcaption class="figure-caption">{{ $media->mediaDetails->caption }}</figcaption>
				</figure>
			@else
				@foreach ($icons as $key => $icon)

					@if ($key === $media->ext)
						<i class="mdi {{ $icon }}" style="font-size: 200px"></i>
					@endif
					
				@endforeach
			@endif
		</div>
		<div class="col-8 px-4">
			@if ( isset($media->mediaDetails) )
				<h3 class="mb-3">{{ $media->mediaDetails->title }}</h3>
				<h5 class="mb-2">{{ $media->mediaDetails->subtitle }}</h5>
				<p>{!! $media->mediaDetails->description !!}</p>
			@endif
			@if ($media->type != 0 )
				<a href="{{ $media->rel_path }}" class="btn btn-info" download>Download</a>
			@endif
		</div>
	</div>


</div>

@endsection

@section("script")
@endsection
