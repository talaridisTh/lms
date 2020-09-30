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
						Ρυθμίσεις
					</a>
				</li>
				<li class="nav-item">
					<a href="#courses" data-toggle="tab"
						aria-expanded="true" class="nav-link tab-link text-muted"
					>
						Courses
					</a>
				</li>
				<li class="nav-item">
					<a href="#users" data-toggle="tab" 
						aria-expanded="true" class="nav-link tab-link text-muted" }}"
					>
						Χρήστες
					</a>
				</li>
			</ul> <!-- end nav-->

			<div class="tab-content">

				<div id="settings" class="tab-pane show active">
					<div class="row">
						<div class="col-xl-9 col-lg-7 col-md-12">
							<form id="bundle-edit-form" action="/dashboard/bundle/store" 
								method="POST" enctype="multipart/form-data" autocomplete="off"
							>
								@csrf

								<div class="row">
							        <div class="col-xl-6">
							            <div class="form-group">
							                <label for="name">Τίτλος</label>
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
							        </div>
							        <div class="col-xl-6">
							            <div class="form-group">
							                <label for="subtitle-input">Υπότιτλος</label>
											<div class="input-group">
											    <div class="custom-file">
													<input class="form-control @error('subtitle') is-invalid @enderror"
														name="subtitle" id="subtitle-input" type="text" placeholder="Εισάγετε υπότιτλο..."
														value="{{ old('subtitle') != "" ? old('subtitle') : "" }}"
													/>
												</div>
												@error('subtitle')
													<span class="invalid-feedback d-block" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
							            </div>
							        </div> <!-- end col -->
							    </div> <!-- end row -->

							</form>
						</div>
						<div class="col-xl-3 col-lg-5 col-md-12 pt-1">
							<div class="sticky py-3">
								
								
								<button form="bundle-edit-form" type="submit" class="btn btn-primary">
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
	<script>
		$(".tab-link").on("show.bs.tab", function(event) {
			
			event.preventDefault();
			Swal.fire(
				'Προσοχή',
				'<p>Θα πρέπει να αποθηκεύσετε το Bundle</p>για να συνεχίσετε!',
				'info'
				);
		});

		let publishDate = $("#publish-date-select").daterangepicker({
			singleDatePicker: true,
			drops: "auto",
		    opens: "center",
			timePicker: true,
			autoUpdateInput: false,
			timePicker24Hour: true,
			cancelButtonClasses: "btn-secondary",
			locale: {
		        format: "DD-MM-YYYY H:mm",
		    },
		});

		publishDate.on( "apply.daterangepicker", function(event, picker) {
		
			let startDate = picker.startDate.format('DD-MM-YYYY H:mm');
			this.value = startDate;
		
		});

		publishDate.on( 'cancel.daterangepicker', function(event, picker) {
			this.value = "";
		});
	</script>

@endsection