@extends('layouts.dashboard')

@section('css')
	<style>
		.content-page {
			overflow: initial;
		}
		.wrapper {
			overflow: initial;
		}
		.sticky {
			background-color: #343a40;
			position: sticky;
			top: 70px;
		}
	</style>
@endsection

@section('content')

	<!-- Modal -->
	<div class="modal fade" id="gallery-modal" tabindex="-1" role="dialog" aria-labelledby="gallery-modalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" style="max-width: 1100px" role="document">
			<div class="modal-content">
				<div class="modal-header modal-colored-header bg-primary">
					<h5 class="modal-title" id="gallery-modalLabel">Media Library</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<ul class="nav nav-tabs nav-bordered mb-3">
						<li class="nav-item">
							<a href="#media-library" id="media-library-tab-btn"
								data-toggle="tab" aria-expanded="false"
								class="nav-link active"
							>
								Media Library
							</a>
						</li>
						<li class="nav-item">
							<a href="#upload" id="upload-tab-btn"
								data-toggle="tab" aria-expanded="true"
								class="nav-link"
							>
								Upload
							</a>
						</li>
					</ul> <!-- end nav-->

					<div class="tab-content">
						<div id="media-library" class="tab-pane show active">
							<!-- Search -->
							<div class="row">
								<div class="mx-auto col-4">
									<div class="form-group">
										<input id="image-search" class="form-control text-center" type="text" placeholder="Αναζήτηση..." />
									</div>
								</div>
							</div>
							<div id="gallery-content">
								@include('components.admin.imageGallery', ['media' => $media])
							</div>
						</div>

						<div id="upload" class="tab-pane">

							<input id="file-pond" class="js-filepond-file-dragging" type="file[]"/>

						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">Έξοδος</button>
				</div>
			</div>
		</div>
	</div>

	<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box">
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="/" class="custom-link-primary">Home</a></li>
						<li class="breadcrumb-item"><a href="/dashboard" class="custom-link-primary">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="/dashboard/bundles" class="custom-link-primary">Bundles</a></li>
						<li class="breadcrumb-item active">Νέο Bundle</li>
					</ol>
				</div>
				<h4 id="bundle-title" class="page-title">Νέο Bundle</h4>
			</div>
		</div>
	</div>
	<!-- end page title -->

	<div class="wrapper">
		<div class="content">

			<ul class="nav nav-tabs nav-bordered mb-3">
				<li class="nav-item">
					<a href="#settings" data-toggle="tab" aria-expanded="false"
						 class="nav-link active">
						Γενικά
					</a>
				</li>
				<li class="nav-item">
					<a href="#courses" data-toggle="tab" aria-expanded="true"
						class="nav-link tab-link text-muted">
						Courses
					</a>
				</li>
				<li class="nav-item">
					<a href="#users" data-toggle="tab" aria-expanded="true"
						class="nav-link tab-link text-muted">
						Χρήστες
					</a>
				</li>
			</ul> <!-- end nav-->

			<div class="tab-content">
				<div id="settings" class="tab-pane show active">
					<div class="row">
						<div class="col-xl-9 col-lg-7 col-md-12">
							<form id="bundle-edit-form" action="/dashboard/bundles"
								method="POST" enctype="multipart/form-data" autocomplete="off">
								@csrf
								<div class="form-row">
									<div class="form-group col-md-6">
										<label for="name">Τίτλος <span class="text-danger">*</span></label>
										<input type="text" class="form-control @error('title') is-invalid @enderror"
											id="name" name="title"
											value="{{ old('title') != "" ? old('title') : "" }}"
											placeholder="Εισάγετε τίτλο...">
										@error('title')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>
									<div class="form-group col-md-6">
										<label for="subtitle-input">Υπότιτλος</label>
										<div class="input-group">
											<div class="custom-file">
												<input class="form-control @error('subtitle') is-invalid @enderror"
													name="subtitle" id="subtitle-input" type="text" placeholder="Εισάγετε υπότιτλο..."
													value="{{ old('subtitle') != "" ? old('subtitle') : "" }}"/>
											</div>
											@error('subtitle')
												<span class="invalid-feedback d-block" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="d-flex justify-content-between">
										<label for="summary">Σύνοψη</label>
										<input id="summary-toggle" class="js-editors-toggle"
											data-field="summary" type="checkbox" data-switch="success"
											name="summaryEditor"/>
										<label class="mb-0" for="summary-toggle" data-on-label="On" data-off-label="Off"></label>
									</div>
									<textarea class="form-control @error('summary') is-invalid @enderror"
										id="summary" name="summary" rows="4"
										placeholder="Εισάγετε σύνοψη..."
										>{{ old('summary') != "" ? old('summary') : ( isset($course) ? $course['summary'] : "" ) }}</textarea>
									@error('summary')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
								<div class="form-group">
									<div class="d-flex justify-content-between">
										<label for="description">Περιγραφή</label>
										<input id="description-toggle" class="js-editors-toggle"
											data-field="description" type="checkbox" data-switch="success"
											name="descriptionEditor"/>
										<label class="mb-0" for="description-toggle" data-on-label="On" data-off-label="Off"></label>
									</div>
									<textarea class="form-control @error('description') is-invalid @enderror"
										id="description" name="description" rows="4"
										placeholder="Εισάγετε περιγραφή..."
										>{{ old('description') != "" ? old('description') : ( isset($course) ? $course['description'] : "" ) }}</textarea>
									@error('description')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</form>
						</div>
						<div class="col-xl-3 col-lg-5 col-md-12 pt-1">
							<div class="sticky py-3">
								<button form="bundle-edit-form" type="submit" class="btn btn-primary btn-block">
									Save
								</button>
							</div>
							<div class="card">
								<div class="card-body">
									<hr class="mt-0" />
									<div class="form-group">
										<label for="publish-date-select">Published</label>
										<input form="bundle-edit-form" type="text" class="form-control" id="publish-date-select" name="publishDate" placeholder="Εισάγετε ημερομηνία..." data-toggle="input-mask" data-mask-format="00-00-0000 00:00:00" autocomplete="off">
									</div>
									<hr class="mb-0" />
								</div>
							</div>
						</div><!-- ./col -->
					</div><!-- Settings Row -->
				</div><!-- settings tab-pane -->

			</div><!-- ./tab content -->

		</div><!-- ./content -->
	</div><!-- wrapper -->

@endsection

@section('scripts')

	<script src="{{ mix("/js/dashboard/newContent.js") }}"></script>

@endsection
