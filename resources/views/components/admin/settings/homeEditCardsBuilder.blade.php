@foreach ($models as $model)
	@php
		$modelType = substr($model->getTable(), 0, -1);
		$previewURL = "#";

		if ( $modelType == "course" ) {
			$previewURL = "/courses/course/$model->slug";
		}
		elseif ( $modelType == "material" ) {
			$previewURL = "/material/$model->slug";
		}
	@endphp
	<div class="col-md-6 col-lg-4 col-xl-3">
		<!-- Simple card -->
		<div class="js-banner card d-block" data-model-id="{{ $model->id }}"
			data-namespace="{{ get_class($model) }}">
			<div class="embed-responsive embed-responsive-16by9">
				<img class="card-img-top embed-responsive-item" src="{{ $model->cover }}" alt="{{ $model->title }}">
			</div>
			<div class="card-body">
				<h5 class="card-title">{{ $model->title }}</h5>
				<p class="js-overflow-check card-text height-65px overflow-y-hidden mb-0">{{ $model->subtitle }}</p>
				<div class="d-flex justify-content-end mt-1 mb-2">
					<a href="#" class="js-show-more invisible custom-muted font-weight-700">Περισσότερα...</a>
				</div>
				<a href="/dashboard/{{ $modelType }}/{{ $model->slug }}"
					class="custom-link-primary mr-3" target="_blank">Edit</a>
				<a href="{{ $previewURL }}" class="custom-link-primary" target="_blank">View</a>
			</div> <!-- end card-body-->
		</div> <!-- end card-->
	</div><!-- end col -->
@endforeach