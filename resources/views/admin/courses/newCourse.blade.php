@extends('layouts.dashboard')

@section('css')
<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>

<style>
	.content-page {
		overflow: initial;
	}
	.wrapper {
		overflow: initial;
	}
	.sticky {
		background-color: #333a3f;
		position: sticky;
		top: 70px;
		z-index: 1010;
	}
</style>
@endsection

@section('content')
	<div class="wrapper">
		<div class="content">

			<div class="row">
				<div class="col-xl-9 col-lg-7 col-md-12">

					<form id="new-course-form" action="courses/store" method="POST" enctype="multipart/form-data" autocomplete="off">
						
						@csrf
						@method('PATCH')

						<div class="form-group">
							<label for="title">Τίτλος</label>
							<input id="title" type="text" 
								class="form-control @error('title') is-invalid @enderror" 
								id="title" name="title" 
								value="{{ old('title') }}" 
								placeholder="Εισάγετε τίτλο...">
							@error('title')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>

						<div class="form-group">
							<label for="subtitle">Υπότιτλος</label>
							<input id="subtitle" type="text" 
								class="form-control @error('subtitle') is-invalid @enderror" 
								name="subtitle" 
								value="{{ old('subtitle') }}" 
								placeholder="Εισάγετε υπότιτλο...">
							@error('subtitle')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>

						<div class="form-group">
							<label for="summary">Σύνοψη</label>
							<textarea class="form-control @error('summary') is-invalid @enderror" id="summary" name="summary" rows="4" placeholder="Εισάγετε σύνοψη...">{{ old('summary') }}</textarea>
							@error('summary')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>

						<div class="form-group">
							<label for="description">Περιγραφή</label>
							<textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Εισάγετε περιγραφή...">{{ old('description') }}</textarea>
							@error('description')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>
					</form>

				</div>
				<div class="col-xl-3 col-lg-5 col-md-12">

					<div class="sticky pb-3 px-2">
						<button form="edit-course-form" type="submit" id="update-btn" class="btn btn-primary btn-block">Αποθήκευση</button>
					</div>

					<div class="card">
						<div class="card-body">
							<div class="form-group">
								<label for="topic">Topic</label>
								<select form="edit-course-form" class="select2 form-control select2-multiple" name="topics[]" data-toggle="select2" multiple="multiple" data-placeholder="Επιλέξτε Topics...">
										
									@foreach ($topics as $topic)
										<option value="{{ $topic->id }}">{{ $topic->title }}</option>
									@endforeach

								</select>
							</div>
							<hr>
							<label for="curator">Κύριος Εισηγητής</label>
							<select id="curator" form="edit-course-form" class="select2 form-control" name="curator" data-toggle="select2" data-placeholder="Επιλέξτε Εισηγητή...">
										
								@foreach ($instructors as $instructor)
									<option value="{{ $instructor->id }}">{{ $instructor->first_name }} {{ $instructor->last_name }}</option>
								@endforeach

							</select>
							<hr>
							<div class="form-group">
								<div class="row">
									<div class="col-8">
										<p><strong>Δημοσίευση απο:</strong></p>
									</div>
									<div class="col-4 text-right">
										<input id="enable-publish-select" type="checkbox" data-switch="bool" checked autocomplete="off"/>
										<label class="mb-0" for="enable-publish-select" data-on-label="On" data-off-label="Off"></label>
									</div>
								</div>
								<input form="edit-course-form" type="text" class="form-control" id="publish-date-select" name="publishDate" placeholder="Εισάγετε ημερομηνία..." data-toggle="input-mask" data-mask-format="00-00-0000 00:00:00" autocomplete="off">
							</div>
							<hr>
						</div>
					</div>
				
					<!-- Dropzone -->
					<div class="card">
						<div class="card-body">

							<form id="cover-dropzone" action="/" method="post" class="image-dropzone" enctype="multipart/form-data">
								<div class="fallback">
									<input name="file" type="file" multiple />
								</div>

								<div class="dz-message needsclick">
									<i class="h1 text-muted dripicons-cloud-upload"></i>
									<h3>Drop files here or click to upload.</h3>
									<span class="text-muted font-13">(This is just a demo dropzone. Selected files are
										<strong>not</strong> actually uploaded.)</span>
								</div>
							</form>

							<!-- Preview -->
							<div class="dropzone-previews mt-3" id="file-previews"></div>  
						
							<div class="d-none" id="uploadPreviewTemplate">
								<div class="card mt-1 mb-0 shadow-none border">
									<div class="p-2">
										<div class="row align-items-center">
											<div class="col-auto">
												<img data-dz-thumbnail src="#" class="avatar-sm rounded bg-light" alt="">
											</div>
											<div class="col pl-0">
												<a href="javascript:void(0);" class="text-muted font-weight-bold" data-dz-name></a>
												<p class="mb-0" data-dz-size></p>
											</div>
											<div class="col-auto">
												<!-- Button -->
												<a href="" class="btn btn-link btn-lg text-muted" data-dz-remove>
													<i class="dripicons-cross"></i>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div> <!-- end card-body -->
					</div> <!-- end course info card -->

				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>
<script src="/assets/js/vendor/dataTables.buttons.min.js"></script>


<script src="{{ mix('js/dashboard/courses/coursesCreate.js') }}"></script>

@endsection