@extends('layouts.dashboard')

@section('css')

@endsection

@section('content')
{{-- <div class="container"> --}}
	<div class="row">
		<div class="col-xl-4 col-lg-5">
			<div class="card text-center">
			    <div class="card-body">
			        <img src="https://via.placeholder.com/300x250" class="img-fluid"
			        alt="profile-image">

			        <h4 class="mb-0 mt-2">{{ $course['name'] }}</h4>
			        <p class="text-muted font-14">Course</p>

					{{-- <button type="button" class="btn btn-success btn-sm mb-2">Follow</button> --}}
					{{-- <button type="button" class="btn btn-danger btn-sm mb-2">Message</button> --}}

			        <div class="text-left mt-3">
			            <h4 class="font-13 text-uppercase">Περιγραφή</h4>
						<p class="text-muted font-13 mb-3">{{ $course['description'] }}</p>
						<p class="text-muted font-13"><strong>Σύνολο μαθημάτων :</strong> <span class="ml-2">{{ $lessons->count() }}</span></p>
						<p class="text-muted mb-4 font-13"><strong>Σύνολο επιπλέον υλικού :</strong><span class="ml-2">{{ $additions->count() }}</span></p>

						<h4 class="font-13 text-uppercase">Εισηγητές μαθημάτων</h4>

						<ul id="authors-list">
							@foreach ($authors as $key => $author)
									<li class="js-authors">{{$author['first_name']}} {{$author['last_name']}}</li>
							@endforeach
							<li id="more-authors" data-shown="false" class="text-hover-underline cursor-pointer d-none mt-1 list-unstyled font-weight-bold">Περρισότερα...</li>
						</ul>

			        </div>

			        <ul class="social-list list-inline mt-3 mb-0">
			            <li class="list-inline-item">
			                <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i
			                        class="mdi mdi-facebook"></i></a>
			            </li>
			            <li class="list-inline-item">
			                <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i
			                        class="mdi mdi-google"></i></a>
			            </li>
			            <li class="list-inline-item">
			                <a href="javascript: void(0);" class="social-list-item border-info text-info"><i
			                        class="mdi mdi-twitter"></i></a>
			            </li>
			            <li class="list-inline-item">
			                <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i
			                        class="mdi mdi-github-circle"></i></a>
			            </li>
			        </ul>
			    </div> <!-- end card-body -->
            </div> <!-- end card -->
		</div> <!-- end col-->

		<div class="col-xl-8 col-lg-7">
			<div class="card">
            	<div class="card-body">
					<ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
						<li class="nav-item">
						    <a href="#time-line" data-toggle="tab" aria-expanded="ture" class="nav-link rounded-0 active">
						        Timeline
						    </a>
						</li>
						<li class="nav-item">
						    <a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
						        Επεξεργασία
						    </a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane show active" id="time-line">

							<h5 class="text-uppercase"><i class="mdi mdi-briefcase mr-1"></i>Περιεχόμενα</h5>

							<div class="timeline-alt pb-0">
								<div class="timeline-item">
									<i class="mdi mdi-circle bg-info-lighten text-info timeline-icon"></i>
									<div class="timeline-item-info">
										<h5 class="mt-0 mb-1">Lead designer / Developer</h5>
										<p class="font-14">websitename.com <span class="ml-2 font-12">Year: 2015 - 18</span></p>
										<p class="text-muted mt-2 mb-0 pb-3">Everyone realizes why a new common language
										    would be desirable: one could refuse to pay expensive translators.
										    To achieve this, it would be necessary to have uniform grammar,
										    pronunciation and more common words.</p>
									</div>
								</div>

								<div class="timeline-item">
										<i class="mdi mdi-circle bg-primary-lighten text-primary timeline-icon"></i>
										<div class="timeline-item-info">
											<h5 class="mt-0 mb-1">Senior Graphic Designer</h5>
											<p class="font-14">Software Inc. <span class="ml-2 font-12">Year: 2012 - 15</span></p>
											<p class="text-muted mt-2 mb-0 pb-3">If several languages coalesce, the grammar
												of the resulting language is more simple and regular than that of
												the individual languages. The new common language will be more
												simple and regular than the existing European languages.</p>

										</div>
								</div>

								<div class="timeline-item">
										<i class="mdi mdi-circle bg-info-lighten text-info timeline-icon"></i>
										<div class="timeline-item-info">
											<h5 class="mt-0 mb-1">Graphic Designer</h5>
											<p class="font-14">Coderthemes Design LLP <span class="ml-2 font-12">Year: 2010 - 12</span></p>
											<p class="text-muted mt-2 mb-0 pb-2">The European languages are members of
												the same family. Their separate existence is a myth. For science
												music sport etc, Europe uses the same vocabulary. The languages
												only differ in their grammar their pronunciation.</p>
										</div>
								</div>
							</div>
							<!-- end timeline -->

						</div> <!-- end tab-pane -->
						<!-- end about me section content -->

						<div class="tab-pane" id="settings">
							<form>
							    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i>Στοιχεία Course</h5>
							    <div class="row">
							        <div class="col-xl-6">
							            <div class="form-group">
							                <label for="name">Όνομα Course</label>
											<input type="text" class="form-control" id="name" name="name" value="{{ $course['name'] }}" placeholder="Δώστε όνομα">
							            </div>
							        </div>
							        <div class="col-xl-6">
							            <div class="form-group">
							                <label for="course-cover">Cover Εικόνα</label>
											<div class="input-group">
											    <div class="custom-file">
											        <input type="file" class="custom-file-input" name="cover" value="{{ $course['cover'] }}" id="course-cover">
											        <label class="custom-file-label" for="course-cover">"{{ $course['cover'] }}"</label>
											    </div>
											</div>
							            </div>
							        </div> <!-- end col -->
							    </div> <!-- end row -->

							    <div class="row">
							        <div class="col-12">
							            <div class="form-group">
							                <label for="description">Περιγραφή</label>
										<textarea class="form-control" id="description" name="description" rows="4" placeholder="Write something...">{{ $course['description'] }}</textarea>
							            </div>
							        </div> <!-- end col -->
							    </div> <!-- end row -->

							    <div class="row">
							        <div class="col-xl-6">
							            <div class="form-group">
							                <label for="example-select">Κατάσταση</label>
											<select class="form-control" id="active">
											    <option value="1">Ενεργό</option>
											    <option value="0">Ανενεργό</option>
											</select>
							            </div>
							        </div>
							        <div class="col-xl-6">
									</div> <!-- end col -->
							    </div> <!-- end row -->

							    <div class="text-right">
							        <button type="submit" class="btn btn-primary mt-2"><i class="mdi mdi-content-save mr-1"></i>Αποθήκευση</button>
							    </div>
							</form>
						</div>
						<!-- end settings content-->

					</div> <!-- end tab-content -->
            	</div> <!-- end card body -->
			</div> <!-- end card -->
		</div> <!-- end col -->

	</div>

{{-- </div> --}}

@endsection

@section('scripts')
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
		})
	</script>
@endsection
