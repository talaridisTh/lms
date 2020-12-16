@extends('layouts.dashboard')

@section('css')

	<style>
		.input-icon {
			padding: 0 0.6rem;
			border: solid #536de6;
			border-width: 1px 1px 0;
		}
	</style>

@endsection

@section('content')
<div class="wrapper"><!-- wrapper @s -->
	<div class="content"><!-- content @s -->

		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="/" class="custom-link-primary">Home</a></li>
							<li class="breadcrumb-item"><a href="/dashboard" class="custom-link-primary">Dashboard</a></li>
							<li class="breadcrumb-item"><a href="/dashboard/users" class="custom-link-primary">Χρήστες</a></li>
							<li class="breadcrumb-item active">Νέος χρήστης</li>
						</ol>
					</div>

					<h4 class="page-title">Νέος χρήστης</h4>

				</div>
			</div>
		</div>

        <div class="row"><!-- row @s -->
            <div class="col-md-12"><!-- col @s -->

                <ul class="nav nav-tabs nav-bordered mb-3">
                    <li class="nav-item">
                        <a href="#settings" data-toggle="tab" aria-expanded="false"
                           class="nav-link active">
                            Επεξεργασία
                        </a>
                    </li>
                    <li class="nav-item">
						<a href="#courses" data-toggle="tab" aria-expanded="false"
							class="nav-link tab-link text-muted">
                            Courses
                        </a>
                    </li>
                    <li class="nav-item">
						<a href="#timeline" data-toggle="tab" aria-expanded="false"
							class="nav-link tab-link text-muted">
                            Timeline
                        </a>
                    </li>
                </ul>

                <div class="tab-content"><!-- tab-content @s -->
                    <div class="tab-pane active" id="settings">

						<div class="row"><!-- row @s -->
						    <div class="col-xl-9 col-lg-8 col-md-12"><!-- col @s -->
								<form id="create-user-form" action="/dashboard/users" method="POST" autocomplete="off">
								
									<div class="card"><!-- card @s -->
										<h4 class="card-header">Στοιχεία</h4>
										<div class="card-body"><!-- card-body @s -->
										
											@csrf
										
											<div class="form-row"><!-- form-row @s -->
						            			<div class="form-group col-md-6">
						            			    <label for="first_name">Όνομα</label>
						            			    <input name="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror"
						            			           id="first_name" placeholder="Εισάγετε όνομα"
						            			           value="{{ old('first_name') }}">
						            			    @error('first_name')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
						            			    @enderror
						            			</div>
						            			<div class="form-group col-md-6">
						            			    <label for="last_name">Επίθετο</label>
						            			    <input name="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror"
						            			           id="last_name" placeholder="Εισάγετε επίθετο" value="{{ old('last_name') }}">
						            			    @error('last_name')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
						            			    @enderror
												</div>
											</div><!-- ./form-row @e -->
										
											<div class="form-row"><!-- form-row @s-->
						            			<div class="form-group col-md-6">
						            			    <label for="email">E-mail</label>
						            			    <div class="input-group">
						            			        <div class="input-group-prepend">
						            			            <i class="bg-primary font-24 input-icon d-inline input-group-text mdi mdi-at"></i>
						            			        </div>
						            			        <input name="email" type="text" class="form-control @error('email') is-invalid @enderror"
						            			            id="email" placeholder="Εισάγετε e-mail" value="{{ old('email') }}">
						            			    </div>
						            			    @error('email')
						            			    	<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
						            			    @enderror
						            			</div>
						            			<div class="form-group col-md-6">
													<label for="phone">Τηλέφωνο</label>
													<div class="input-group">
														<div class="input-group-prepend">
															<i class="bg-primary input-icon font-24 input-group-text mdi mdi-phone"></i>
														</div>
														<input name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
														placeholder="Εισάγετε τηλέφωνο" value="{{ old('phone') }}">
														@error('phone')
						            			    	<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
														@enderror
													</div>
												</div>
											</div><!-- ./form-row @e -->
										
											<div class="form-row"><!-- form-row @s-->
												<div class="form-group col-md-6">
													<label for="password">Κωδικός</label>
													<div class="input-group input-group-merge">
														<input type="password" id="password"
															   class="form-control @error('password') is-invalid @enderror" name="password"
															   placeholder="Εισάγετε κωδικό">
														<div class="input-group-append" data-password="false">
															<div class="input-group-text" style="border-bottom: 0;">
																<span class="password-eye"></span>
															</div>
														</div>
													</div>
													@error('password')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
												<div class="form-group col-md-6">
													<label for="confirm-password">Επιβεβαίωση Κωδικού</label>
													<div class="input-group input-group-merge">
														<input type="password" id="confirm-password" class="form-control"
															   name="password_confirmation" placeholder="Εισάγετε κωδικό">
														<div class="input-group-append" data-password="false">
															<div class="input-group-text" style="border-bottom: 0;">
																<span class="password-eye"></span>
															</div>
														</div>
													</div>
												</div>
											</div><!-- ./form-row @e -->
										
						            		<div class="form-group mb-0">
						            		    <label for="profil">Προφίλ</label>
						            		    <textarea name="profil" class="form-control @error('profil') is-invalid @enderror" id="profil"
						            		        placeholder="Εισάγετε πληροφορίες" rows="5" >{{ old("profil") }}</textarea>
											</div>
										</div><!-- ./card-body @e -->
									</div><!-- ./card @e -->
								
								</form>
						    </div><!-- ./col @e -->
						
						    <div class="col-xl-3 col-lg-4 col-md-12"><!-- col @s -->
								<div class="sticky pb-3">
						            <button form="create-user-form" class="btn btn-primary btn-block" type="submit">
						                Save
						            </button>
								</div>
							
								<div class="card"><!-- card @s -->
									<div class="card-body"><!-- card-body @s -->
										<div class="form-row justify-content-between align-items-center">
											<div class="col-7">
												<label for="user-status">Κατάσταση</label>
											</div>
											<div class="col-5 text-right">
												<input form="create-user-form" type="checkbox" id="user-status" name="status" data-switch="success">
												<label for="user-status" data-on-label="On" data-off-label="Off"></label>
											</div>
										</div>
									
										<hr class="mt-1">
									
										<div class="form-group mb-0">
											<label for="role-selection">Ιδιότητα</label>
											<select form="create-user-form" id="role-selection" name="role"
											class="select2 form-control" data-toggle="select2" data-width="100%">
												<option value="student" {{ old("roles") === "student" ? "selected" : ""}}>Μαθητής</option>
												@if (Auth::user()->roles()->first()->name === "super-admin")
													<option value="super-admin" {{ old("roles" ) === "super-admin" ? "selected" : ""}}>Super Admin</option>
												@endif
												<option value="admin" {{ old("roles") === "admin" ? "selected" : ""}}>Admin</option>
												<option value="instructor" {{ old("roles") === "instructor" ? "selected" : ""}}>Εισηγητής</option>
												<option value="partner" {{ old("roles") === "partner" ? "selected" : ""}}>Partner</option>
											</select>
										</div>
									</div><!-- ./card-body @e -->
								</div><!-- ./card @e -->
							
								<div class="card"><!-- card @e -->
									<h4 class="card-header">Social</h4>
									<div class="card-body"><!-- card-body @s -->
									
										<div class="form-group">
											<label for="facebook">Facebook</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<i class="bg-primary input-icon font-24 input-group-text mdi mdi-facebook"></i>
												</div>
												<input form="create-user-form" id="facebook" type="text" class="form-control" name="facebook_link" value="{{ old("facebook_link") }}" placeholder="Εισάσετε link...">
											</div>
										</div>
									
										<div class="form-group">
											<label for="instagram">Instagram</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<i class="bg-primary input-icon font-24 input-group-text mdi mdi-instagram"></i>
												</div>
												<input form="create-user-form" id="instagram" type="text" class="form-control" name="instagram_link" value="{{ old("instagram_link") }}" placeholder="Εισάγετε link...">
											</div>
										</div>
									
										<div class="form-group">
											<label for="youtube">Youtube</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<i class="bg-primary input-icon font-24 input-group-text mdi mdi-youtube"></i>
												</div>
												<input form="create-user-form" id="youtube" type="text" class="form-control" name="youtube_link" value="{{ old("youtube_link") }}" placeholder="Εισάγετε link...">
											</div>
										</div>

										<div class="form-group mb-0">
											<label for="linked-in">LinkedIn</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<i class="bg-primary input-icon font-24 input-group-text mdi mdi-linkedin"></i>
												</div>
												<input form="create-user-form" id="linked-in" type="text" class="form-control" name="linkedin_link" value="{{ old("linkedin_link") }}" placeholder="Εισάγετε link...">
											</div>
										</div>

									</div><!-- ./card-body @e -->
								</div><!-- ./card @e -->
							
						    </div><!-- ./col @e -->
						</div><!-- ./row @e -->

                    </div>
                </div><!-- ./tab-content @e -->

            </div><!-- ./col @e -->
        </div><!-- ./row @e -->

    </div><!-- ./content @e -->
</div><!-- ./wrapper @e -->

@endsection


@section('scripts')
    
<script src="{{ mix("js/dashboard/users/userCreate.js") }}"></script>
@endsection
