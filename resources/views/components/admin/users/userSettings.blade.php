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

                        <div id="gallery-content" data-model="App\Models\User" data-id="{{ $user->id }}" data-type="avatar">
                            @include('components.admin.imageGallery', ['media' => $media])
                        </div>
                    </div>
                    <div id="upload" class="tab-pane">
                        <input id="file-pond"  type="file[]"/>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Έξοδος</button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-9 col-lg-8 col-md-12"><!-- col @s -->
		<form id="edit-user-form" action="/dashboard/users/{{ $user->slug }}"
			method="POST" enctype="multipart/form-data">

			<div class="card"><!-- card @s -->
				<h4 class="card-header">Στοιχεία</h4>
				<div class="card-body"><!-- card-body @s -->

					@csrf
					@method('PATCH')

					<div class="form-row"><!-- form-row @s -->
            			<div class="form-group col-md-6">
            			    <label for="first_name">Όνομα</label>
            			    <input name="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror"
            			           id="first_name" placeholder="Εισάγετε όνομα"
            			           value="{{ old('first_name', $user->first_name) }}">
            			    @error('first_name')
            			    <span class="text-danger h6" role="alert"><strong>{{ $message }}</strong>	</span>
            			    @enderror
            			</div>
            			<div class="form-group col-md-6">
            			    <label for="last_name">Επίθετο</label>
            			    <input name="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror"
            			           id="last_name" placeholder="Εισάγετε επίθετο" value="{{ old('last_name', $user->last_name) }}">
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
            			               id="email"
            			               placeholder="Εισάγετε e-mail"
            			               value="{{ old('email', $user->email) }}">
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
								placeholder="Εισάγετε τηλέφωνο" value="{{ old('phone', $user->phone) }}">
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
            		        placeholder="Εισάγετε πληροφορίες" rows="5" >{{ old("profil", $user->profil) }}</textarea>
            		    @error('profil')
            		    	<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
            		    @enderror
					</div>
				</div><!-- ./card-body @e -->
			</div>

			<div class="card"><!-- card @e -->
				<h4 class="card-header">Social</h4>
				<div class="card-body"><!-- card-body @s -->
					<div class="form-row"><!-- form-row @s -->
						<div class="form-group col-md-6">
							<label for="facebook">Facebook</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<i class="bg-primary input-icon font-24 input-group-text mdi mdi-facebook"></i>
								</div>
								<input id="facebook" type="text" class="form-control" name="facebook_link" value="{{ old("facebook_link", $user->facebook_link) }}" placeholder="Εισάσετε link...">
							</div>
						</div>
						<div class="form-group col-md-6">
							<label for="instagram">Instagram</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<i class="bg-primary input-icon font-24 input-group-text mdi mdi-instagram"></i>
								</div>
								<input id="instagram" type="text" class="form-control" name="instagram_link" value="{{ old("instagram_link", $user->instagram_link) }}" placeholder="Εισάγετε link...">
							</div>
						</div>
					</div><!-- ./form-row @e -->

					<div class="form-row"><!-- form-row @s -->
						<div class="form-group col-md-6 mb-md-0">
							<label for="youtube">Youtube</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<i class="bg-primary input-icon font-24 input-group-text mdi mdi-youtube"></i>
								</div>
								<input id="youtube" type="text" class="form-control" name="youtube_link" value="{{ old("youtube_link", $user->youtube_link) }}" placeholder="Εισάγετε link...">
							</div>
						</div>
						
						<div class="form-group col-md-6 mb-md-0">
							<label for="linked-in">LinkedIn</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<i class="bg-primary input-icon font-24 input-group-text mdi mdi-linkedin"></i>
								</div>
								<input id="linked-in" type="text" class="form-control" name="linkedin_link" value="{{ old("linkedin_link", $user->linkedin_link) }}" placeholder="Εισάγετε link...">
							</div>
						</div>
					</div><!-- ./form-row @e -->
				</div><!-- ./card-body @e -->
			</div><!-- ./card @e -->

		</form>
    </div><!-- ./col @e -->

    <div class="col-xl-3 col-lg-4 col-md-12">
		<div class="sticky pb-3"><!-- sticky @s -->
			<div class="form-row"><!-- form-row @s -->
				<div class="col-6">
					<button form="edit-user-form" class="btn btn-info btn-block" type="submit">
						Update
					</button>
				</div>
				<div class="col-6"><!-- col-6 @s -->
					<div class="btn-group w-100"><!-- btn-group @s -->
						<button type="button" class="btn btn-warning btn-block dropdown-toggle"
							data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Επιλογές
						</button>

						<div class="dropdown-menu py-0">
							<div class="btn-group dropleft dropleft-hover w-100">
								<button type="button" id="status-dropdown" class="dropdown-item dropdown-toggle py-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Αλλαγή Avatar
								</button>
								<div class="dropdown-menu py-0" aria-labelledby="status-dropdown">
									<a id="change-cover-btn"
										class="dropdown-item cursor-pointer py-2">Επιλογή</a>
									<div class="dropdown-divider my-0"></div>
									<a id="reset-avatar"
										class="dropdown-item cursor-pointer py-2">Ορισμός προεπιλογής</a>
								</div>
							</div>

							<div class="btn-group dropleft dropleft-hover w-100">
								<button type="button" id="status-dropdown" class="dropdown-item dropdown-toggle py-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Κωδικός
								</button>
								<div class="dropdown-menu py-0" aria-labelledby="status-dropdown">
									<a class="js-send-message dropdown-item cursor-pointer py-2">Αποστολη</a>
									<div class="dropdown-divider my-0"></div>
									<a id="show-password" class="dropdown-item cursor-pointer py-2">Εμφάνιση</a>
								</div>
							</div>
						</div>

					</div><!-- ./btn-group @e -->
				</div><!-- ./col-6 @e -->
			</div><!-- ./form-row @e -->
		</div><!-- ./sticky @e -->

		<div class="card"><!-- avatar-card @s -->
			<div class="card-body"><!-- card-body @s -->
				<div class="row justify-content-center mb-3">
					<img id="cover-image" src="{{ $user->thumbnailUrl("avatar") }}" style="height: 120px;" alt="Cover Image" class="rounded-circle img-thumbnail">
				</div>

				<div class="form-row justify-content-between align-items-center">
					<div class="col-7">
						<label for="user-status">Κατάσταση</label>
					</div>
					<div class="col-5 text-right">
						<input type="checkbox" id="user-status" data-user-id="{{ $user->id }}" data-switch="success">
						<label for="user-status" data-on-label="On" data-off-label="Off"></label>
					</div>
				</div>

				<hr class="mt-1">

				<div class="form-group">
					<label for="role-selection">Ιδιότητα</label>
					<select form="edit-user-form" id="role-selection" name="role"
						class="select2 form-control" data-toggle="select2" data-width="100%">
						@if ($userRole === "super-admin")
							<option value="super-admin" {{ old("roles", $userRole ) === "super-admin" ? "selected" : ""}}>Super Admin</option>
						@endif
						<option value="admin" {{ old("roles", $userRole ) === "admin" ? "selected" : ""}}>Admin</option>
						<option value="instructor" {{ old("roles", $userRole ) === "instructor" ? "selected" : ""}}>Εισηγητής</option>
						<option value="student" {{ old("roles", $userRole ) === "student" ? "selected" : ""}}>Μαθητής</option>
						<option value="partner" {{ old("roles", $userRole ) === "partner" ? "selected" : ""}}>Partner</option>
					</select>
				</div>

				<hr>

				<button id="delete-user-btn" class="btn btn-outline-danger btn-block btn-sm">Διαγραφή λογαριασμού</button>
			</div><!-- ./card-body @e -->
		</div><!-- ./avatar-card @e -->

		<div class="card"><!-- recent-activity-card @s -->
			<h4 class="card-header">Recent Activity</h4>
			<div class="card-body">
				<div class="timeline-alt py-0">

					@foreach ($activities as $activity)
						<div class="timeline-item">
							<i class="mdi
								@if($activity->log_name === "login")
									mdi-location-enter bg-success-lighten text-success
								@else
									mdi-location-exit bg-primary-lighten text-primary
								@endif timeline-icon"></i>
							<div class="timeline-item-info">
								<span href="#" class="{{ $activity->log_name === "login" ? "text-success" : "text-primary"}} font-weight-bold mb-1 d-block">{{ ucfirst($activity->log_name) }}</span>
								<p class="mb-0 pb-2">
									<small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
								</p>
							</div>
						</div>
						
					@endforeach

				</div>
			</div><!-- ./card-body @e -->
		</div><!-- ./recent-activity-card @e -->
    </div>
</div>


