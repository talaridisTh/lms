
@extends("layouts.app")

@section("style")
@endsection

@section("content")

<div class="content-page">
	<div class="content">


	<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box">
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
						<li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
						<li class="breadcrumb-item active">Profile</li>
					</ol>
				</div>
				<h4 class="page-title">Profile</h4>
			</div>
		</div>
	</div>
	<!-- end page title -->





	<div class="row">
		<div class="col-sm-12">
			<!-- Profile -->
			<div class="card bg-primary">
				<div class="card-body profile-user-box">

					<div class="row">
						<div class="col-sm-8">
							<div class="media">
								<span class="float-left m-2 mr-4"><img src='{{ asset("storage/courses/$course->id/cover/$course->cover" )}}' style="height: 100px;" alt="" class="rounded-circle img-thumbnail"></span>
								<div class="media-body">

									<h4 class="mt-1 mb-1 text-white">{{ $course->name }}</h4>
									<p class="font-13 text-white-50">{{ $course->description }}</p>

									<ul class="mb-0 list-inline text-light">
										<li class="list-inline-item mr-3">
											<h5 class="mb-1">{{ $course->materials->where("type", "Lesson")->count() }}</h5>
											<p class="mb-0 font-13 text-white-50">Σύνολο Μαθημάτων</p>
										</li>
										<li class="list-inline-item">
											<h5 class="mb-1">{{ $course->materials->where("type", "!=", "Lesson")->count() }}</h5>
											<p class="mb-0 font-13 text-white-50">Extra Υλικό</p>
										</li>
									</ul>
								</div> <!-- end media-body-->
							</div>
						</div> <!-- end col-->

						<div class="col-sm-4">
							<div class="text-center mt-sm-0 mt-3 text-sm-right">
								<button type="button" class="btn btn-light">
									<i class="mdi mdi-account-edit mr-1"></i> Edit Profile
								</button>
							</div>
						</div> <!-- end col-->
					</div> <!-- end row -->

				</div> <!-- end card-body/ profile-user-box-->
			</div><!--end profile/ card -->
		</div> <!-- end col-->
	</div>
	<!-- end row -->

















	<div class="row">
		<div class="col-lg-4">
			<!-- Personal-Information -->
			<div class="card">
				<div class="card-body">
					<h4 class="header-title mt-0 mb-3">Εισηγητές</h4>

					<ul>
						@foreach ( $authors as $author )
							<li class="js-authors">{{ $author->first_name }} {{ $author->last_name }}</li>
                            @endforeach

						<li id="more-authors"
							data-shown="false"
							class="d-none mt-1 list-unstyled font-weight-bold cursor-pointer text-hover-underline">
							Περισσότερα...
						</li>
					</ul>
				</div>
			</div>
			<!-- Personal-Information -->

		</div> <!-- end col-->

		<div class="col-lg-8">

			<!-- Chart-->
			<div class="card">
				<div class="card-body">
					<h4 class="header-title">Μαθήματα</h4>
					<div class="card-body">
						<table class="table table-centered mb-0">
							<tbody>
								@foreach ($materials as $material)
									<tr>
										<td><a href="{{route('index.material.show',$material->slug)}}">{{ $material->title}}</a></td>
										<td>{!! $material->subtitle !!} </td>
									</tr>
								@endforeach
							</tbody>
						</table>

					</div>
				</div>
			</div>
			<!-- End Chart-->



		</div>
		<!-- end col -->

	</div>
	<!-- end row -->




















	</div>
</div>

@endsection


@section("script")

<script>

	const authors = $('.js-authors');

	if ( authors.length > 3 ) {
		for ( let i = 3; i < authors.length; i++ ) {
			authors[i].classList.add('d-none');
		}
		const moreAuthors = $('#more-authors')[0];
		moreAuthors.classList.remove("d-none");
	}

	$('#more-authors').click( function() {
		if ( this.dataset.shown == "true") {
			this.dataset.shown = "false";
			for ( let i = 3; i < authors.length; i++ ) {
				authors[i].classList.add('d-none');
			}
			this.textContent = "Περισσότερα ..."
		}
		else {
			this.textContent = "Λιγότερα ..."
			this.dataset.shown = "true";
			for ( let i = 3; i < authors.length; i++ ) {
				authors[i].classList.remove('d-none');
			}
		}
	});

</script>
@endsection
