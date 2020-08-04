@extends('layouts.dashboard')

@section('css')

@endsection

@section('content')
{{-- <div class="container"> --}}
	<div class="row">
		<div class="col-xl-3 col-lg-5">

			<div class="card">

				<div class="card-body">
					<h5 class="text-uppercase"><i class="mdi mdi-briefcase mr-1"></i>Μαθήματα</h5>
					<div class="timeline-alt pb-0">

						@foreach ($materials as $material)
							<div class="timeline-item">
								<i class="mdi mdi-circle bg-primary-lighten text-primary timeline-icon"></i>
								<div class="timeline-item-info">
								<h5 class="mt-0 mb-1">{{ $material['name'] }}</h5>
									<p class="font-14">
										Τελευταία Ανανέωση
										<span class="ml-2 font-12">
											{{ $material['updated_at'] }}
										</span>
									</p>
									<p class="text-muted mt-2 mb-0 pb-3">
										{{ $material['small_description'] }}
									</p>
								</div>
							</div>
							<div class="timeline-item pb-4">
								<i class="mdi mdi-circle bg-info-lighten text-info timeline-icon"></i>
								<div class="timeline-item-info">
									<h5 class="mt-0 mb-1">Προσθήκη Υλικού</h5>
								</div>
							</div>
						@endforeach

					</div><!-- end timeline -->
				</div><!-- /.card-body ends -->
			</div><!-- /.card ends -->

		</div> <!-- end col-->

		<div class="col-xl-9 col-lg-7">
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
							<div class="row">
								<div class="col-xl-2 d-flex mb-4">
									<img src="https://via.placeholder.com/300x250" class="card-img m-auto" style="max-width: 500px" alt="...">
								</div>
								<div class="col-xl-5 pl-4 mb-4">
									<h5 class="card-title">{{ $course['name'] }}</h5>
									<p class="card-text">{{ $course['description'] }}</p>
									<p class="card-text"><small class="text-muted">Τελευταία Ενημέρωση: {{ $course['updated_at'] }}</small></p>
									<p class="card-text"><small class="text-muted">Δημιουργήθηκε: {{ $course['created_at'] }}</small></p>
								</div>
								<div class="col-xl-5 pl-4">
									<h5 class="card-title">Εισηγητές μαθημάτων</h5>
									<ul id="authors-list">
										@foreach ($authors as $key => $author)
												<li class="js-authors">{{$author['first_name']}} {{$author['last_name']}}</li>
										@endforeach
										<li id="more-authors" data-shown="false" class="d-none mt-1 list-unstyled font-weight-bold">Περρισότερα...</li>
									</ul>
								</div>
							</div>
						</div><!-- end tab-pane -->
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
