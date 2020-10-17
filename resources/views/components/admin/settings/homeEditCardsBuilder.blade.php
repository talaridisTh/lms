@foreach ($models as $model)
	<div class="col-md-6 col-lg-4">
		<!-- Simple card -->
		<div class="card d-block">
			<div class="embed-responsive embed-responsive-16by9">
				<img class="card-img-top embed-responsive-item" src="{{ $model->cover }}" alt="{{ $model->title }}">
			</div>
			<div class="card-body">
				<h5 class="card-title">{{ $model->title }}</h5>
				<p class="card-text">{{ $model->subtitle }}</p>
				<a href="javascript: void(0);" class="btn btn-primary">Button</a>
			</div> <!-- end card-body-->
		</div> <!-- end card-->
	</div><!-- end col -->
@endforeach