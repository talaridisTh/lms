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
			z-index: 1000;
		}

		.input-icon {
			padding: 0 0.6rem;
			border: 1px solid #536de6;
		}
	</style>
@endsection

@section('content')

	<!-- Gallery Modal -->
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
								class="nav-link active">
								Media Library
							</a>
						</li>
						<li class="nav-item">
							<a href="#upload" id="upload-tab-btn"
								data-toggle="tab" aria-expanded="true"
								class="nav-link">
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
							<div id="gallery-content" data-model="App\Option" data-type="logo">
								@include('components.admin.imageGallery', ['media' => $media])
							</div>
						</div>

						<div id="upload" class="tab-pane">

							<input id="file-pond" class="js-filepond-file-dragging mb-0" type="file[]"/>
							<p class="text-right mb-2">
								<small>
									<strong>
										Το πεδίο δέχεται αρχεία: .jpg, .png.
									</strong>
								</small>
							</p>

						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">Έξοδος</button>
				</div>
			</div>
		</div>
	</div><!-- ./Gallery Modal -->

	<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box">
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="/" class="custom-link-primary">Home</a></li>
						<li class="breadcrumb-item"><a href="/dashboard" class="custom-link-primary">Dashboard</a></li>
						<li class="breadcrumb-item active">General Settings</li>
					</ol>
				</div>
				<h4 class="page-title">General Settings</h4>
			</div>
		</div>
	</div>
	<!-- end page title -->

	<div class="wrapper">
		<div class="content">

			<div class="row">
				<div class="col-xl-9 col-lg-7 col-md-12">
					<form id="edit-settings-form" action="/dashboard/general-settings/update" method="POST" autocomplete="off">

						@csrf

						<div class="card">
							<h4 class="card-header">Site settings</h4>
							<div class="card-body">
								<div class="form-row">
									<div class="form-group col-md-6">
										<label for="title">Τίτλος</label>
										<input type="text" class="form-control" id="title" name="title" value="{{ $title->value }}" placeholder="Εισάσετε τίτλο...">
									</div>
									<div class="form-group col-md-6">
										<label for="copyright">Copyright</label>
										<input type="Copyright" class="form-control" id="copyright" name="copyright" value="{{ $copyright->value }}" placeholder="Εισάγετε Copyright...">
									</div>
								</div>
								<div class="form-group">
									<label for="description">Περιγραφή</label>
									<textarea type="text" class="form-control" id="description" name="description" rows="3" placeholder="Εισάγετε περιγραφή...">{{ $description->value }}</textarea>
								</div>
							</div>
						</div>
						@php
							$contact = json_decode($contactInfo->value)
						@endphp
						<div class="card">
							<h4 class="card-header">Contact Info</h4>
							<div class="card-body">
								<div class="form-group">
									<label for="city">Πόλη</label>
									<input type="text" class="form-control" id="city" name="city" value="{{ !is_null($contactInfo->value) ? $contact->city : "" }}" placeholder="Εισάγετε πόλη...">
								</div>
								<div class="form-row">
									<div class="form-group col-md-9">
										<label for="address">Διεύθυνση</label>
										<input type="text" class="form-control" id="address" name="address" value="{{ !is_null($contactInfo->value) ? $contact->address : "" }}" placeholder="Εισάγετε διεύθυνση...">
									</div>
									<div class="form-group col-md-3">
										<label for="zip-code">Τ.Κ.</label>
										<input type="text" class="form-control" id="zip-code" name="zipCode" value="{{ !is_null($contactInfo->value) ?  $contact->zipCode : "" }}" placeholder="Τ.Κ.">
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-md-6">
										<label for="phone">Τηλέφωνο</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<i class="bg-primary input-icon font-24 input-group-text mdi mdi-phone"></i>
											</div>
											<input type="text" class="form-control" id="phone" name="phone" value="{{ !is_null($contactInfo->value) ?  $contact->phone : "" }}" placeholder="Εισάγετε τηλέφωνο...">
										</div>
									</div>
									<div class="form-group col-md-6">
										<label for="fax">Fax</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<i class="bg-primary input-icon font-24 input-group-text mdi mdi-fax"></i>
											</div>
											<input type="text" class="form-control" id="fax" name="fax" value="{{ !is_null($contactInfo->value) ?  $contact->fax : "" }}" placeholder="Εισάγετε Fax...">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="fax">Email</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<i class="bg-primary font-24 input-icon d-inline input-group-text mdi mdi-at"></i>
										</div>
										<input type="text" class="form-control" id="email" name="email" value="{{ !is_null($contactInfo->value) ? $contact->email : "" }}" placeholder="Εισάγετε email...">
									</div>
								</div>

							</div>
						</div>

					</form>
				</div><!-- ./col -->

				<div class="col-xl-3 col-lg-5 col-md-12">
					<div class="sticky pb-3">
						<button form="edit-settings-form" class="btn btn-primary btn-block" type="submit">
							Save
						</button>
					</div>

					<!-- Logo Preview -->
					<div class="card">
						<div class="card-header">
							<h4 class="card-title mb-0">Logo</h4>
						</div>
						<div class="card-body text-center">
							<img id="cover-image" src="{{ $logo->value }}"
								class="img-fluid" alt="Logo Image" />

							<div class="form-row mt-2">
								<button id="change-cover-btn" class="btn btn-primary btn-block text-nowrap"
									data-toggle="modal" data-target="#gallery-modal">
									Αλλαγή
								</button>
							</div>

						</div> <!-- end card-body -->
					</div> <!-- end course info card -->

					@php
						$socialLinks = json_decode($social->value);
					@endphp
					<div class="card">
						<div class="card-header">
							<h4 class="card-title mb-0">Social Links</h4>
						</div>
						<div class="card-body">
							<div class="form-group">
								<label for="facebook">Facebook</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<i class="bg-primary input-icon font-24 input-group-text mdi mdi-facebook"></i>
									</div>
									<input form="edit-settings-form" type="text" class="form-control" id="facebook" name="facebook" value="{{ !is_null($social->value) ? $socialLinks->facebook : "" }}" placeholder="Εισάσετε link..." />
								</div>
							</div>

							<div class="form-group">
								<label for="instagram">Instagram</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<i class="bg-primary input-icon font-24 input-group-text mdi mdi-instagram"></i>
									</div>
									<input form="edit-settings-form" type="text" class="form-control" id="instagram" name="instagram" value="{{ !is_null($social->value) ? $socialLinks->instagram : "" }}" placeholder="Εισάγετε link...">
								</div>
							</div>

							<div class="form-group">
								<label for="twitter">Twitter</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<i class="bg-primary input-icon font-24 input-group-text mdi mdi-twitter"></i>
									</div>
									<input form="edit-settings-form" type="text" class="form-control" id="twitter" name="twitter" value="{{ !is_null($social->value) ? $socialLinks->twitter : "" }}" placeholder="Εισάγετε link...">
								</div>
							</div>

							<div class="form-group">
								<label for="youtube">Youtube</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<i class="bg-primary input-icon font-24 input-group-text mdi mdi-youtube"></i>
									</div>
									<input form="edit-settings-form" type="text" class="form-control" id="youtube" name="youtube" value="{{ !is_null($social->value) ? $socialLinks->youtube : "" }}" placeholder="Εισάγετε link...">
								</div>
							</div>

							<div class="form-group mb-0">
								<label for="linked-in">LinkedIn</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<i class="bg-primary input-icon font-24 input-group-text mdi mdi-linkedin"></i>
									</div>
									<input form="edit-settings-form" type="text" class="form-control" id="linked-in" name="linkedIn" value="{{ !is_null($social->value) ? $socialLinks->linkedIn : "" }}" placeholder="Εισάγετε link...">
								</div>
							</div>

						</div>
					</div><!-- ./card -->
				</div>
			</div>

		</div>
	</div>

@endsection

@section('scripts')
	<script src="{{ mix("js/dashboard/settings/general-settings.js") }}"></script>
	
@endsection