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
                        <div id="gallery-content" data-model="App\User" data-id={{ $user->id }}>
                            @include('components.admin.imageGallery', ['media' => $media])
                        </div>
                    </div>

                    <div id="upload" class="tab-pane">
                        <form id="cover-dropzone" action="/" method="post" class="image-dropzone" enctype="multipart/form-data">
                            <div class="fallback">
                                <input name="file" type="file" multiple />
                            </div>

                            <div class="dz-message needsclick text-center">
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
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Έξοδος</button>
            </div>
        </div>
    </div>
</div>

<form id="buttonUser" class="px-4"
          action="{{ request()->route()->getName() == 'user.create'  ? route('user.store') : route('user.update',$user->slug) }}"
      method="POST"
      enctype="multipart/form-data" class='dropzone'>
    @csrf
    @if(isset($user))
        @method('PATCH')
    @endif
    <div class="row">
        <div class="col-md-4 border-material">
            <h4>Πληροφορίες</h4>

            <div class="form-group my-3">
                <label for="first_name">Όνομα</label>
                <input name="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror"
                       id="first_name"
                       placeholder="Εισάγετε όνομα"
                       value="{{ old('first_name') != "" ? old('first_name') : ( isset($user) ? $user['first_name'] : "" ) }}">
                @error('first_name')
                <span class="text-danger h6" role="alert"><strong>{{ $message }}</strong>	</span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="last_name">Επίθετο</label>
                <input name="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror"
                       id="last_name"
                       placeholder="Εισάγετε επίθετο"
                       value="{{ old('last_name') != "" ? old('last_name') : ( isset($user) ? $user['last_name'] : "" ) }}">
                @error('last_name')
                <span class=" text-danger h6" role="alert"><strong>{{ $message }}</strong>    </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="email">E-mail</label>
                <div class="input-group ">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                    </div>
                    <input name="email" type="text" class="form-control @error('email') is-invalid @enderror"
                           id="email"
                           placeholder="Εισάγετε e-mail"
                           value="{{ old('email') != "" ? old('email') : ( isset($user) ? $user['email'] : "" ) }}">
                </div>
                @error('email')
                <span class="text-danger h6" role="alert"><strong>{{ $message }}</strong>	</span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="phone">Τηλέφωνο</label>
                <input name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                       placeholder="Εισάγετε τηλέφωνο"
                       value="{{ old('phone') != "" ? old('phone') : ( isset($user) ? $user['phone'] : "" ) }}">
                @error('phone')
                <span class="text-danger h6" role="alert"><strong>{{ $message }}</strong>	</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="profil">Προφίλ</label>
                <textarea name="profil" class="form-control @error('profil') is-invalid @enderror" id="profil"
                          placeholder="Εισάγετε πληροφορίες"
                          rows="5"
                >{{isset($user) ? $user['profil'] : ""}}</textarea>
                @error('profil')
                <span class="text-danger h6 h6" role="alert"><strong>{{ $message }}</strong>	</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12 border-material">
                <h4>Security</h4>
                <div class="form-group">
                    <select name="roles" id="roles" class="form-control  select2" data-toggle="select2">
                        @foreach ($rolesName as $role)
                            <option value="{{$role->name}}"
                            @if(isset($user))
                                {{$user->getRoleNames()->first() == $role->name? "selected":""}}
                                @endif
                            >{{$role->name}}
                            </option>
                        @endforeach
                    </select>
                    @error('roles')
                    <span class="text-danger h6" role="alert"><strong>{{ $message }}</strong>	</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Κωδικός</label>
                    <div class="input-group input-group-merge">
                        <input type="password" id="password"
                               class="form-control @error('password') is-invalid @enderror" name="password"
                               placeholder="Εισάγετε κωδικό ">

                        <div class="input-group-append" data-password="false">
                            <div class="input-group-text">
                                <span class="password-eye"></span>
                            </div>
                        </div>

                    </div>
                    @error('password')
                    <span class="text-danger h6" role="alert"><strong>{{ $message }}</strong>	</span>
                    @enderror
                </div>

                <div class="form-group ">
                    <label for="confirm-password">Επιβεβαίωση Κωδικού</label>
                    <div class="input-group input-group-merge">
                        <input type="password" id="confirm-password" class="form-control"
                               name="password_confirmation" placeholder="Εισάγετε κωδικό ">
                        @error('confirm-password')
                        <span class="text-danger h6" role="alert"><strong>{{ $message }}</strong>	</span>
                        @enderror
                        <div class="input-group-append" data-password="false">
                            <div class="input-group-text">
                                <span class="password-eye"></span>
                            </div>
                        </div>
                    </div>
                </div>

                @isset($user )

                <h5 class="js-link-passwordShow -4 cursor-pointer custom-link-primary">Eμφάνιση password</h5>
                <div class="form-group mt-4 passwordShow d-none">
                    <h5>Username: <span class="font-weight-normal">{{$user->email}}</span></h5>
                    <h5>Password: <span class="font-weight-normal">{{\Crypt::decryptString($user->password_encrypt)}}</span></h5>
                </div>
                @endisset


            </div>
        </div>
        <div class="col-md-4">
            <div class="sticky" style=" margin-top: -32px;">
                <button class="buton-create-material btn btn-sm btn-primary mr-2"
                        type="submit"> {{isset($user)? "Ενημέρωση":"Δημιουργια"}}</button>
            </div>
            <div class="col-md-12 border-material d-d">
                <h4>Προσωπικές πληροφορίες</h4>

                <div class="row">

                    <div class="col-md-12">
                        <hr>
                        <div class="form-group">
                            <div class="form-row justify-content-between">
                                <div class="col-7">
                                    <label for="createAtMaterial">Κατάσταση</label>
                                </div>
                                <div class="col-5 text-right">
                                    <input name="status" type="checkbox" id="activeMaterial"
                                           data-switch="bool"
                                    @if(isset($user))
                                        {{$user->status==1? 'checked':""}}
                                        @endif
                                    />
                                    <label for="activeMaterial" data-on-label="On" data-off-label="Off"></label>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>

                    <div class="col-md-12">
                    @isset($user)
                        <!-- Cover Preview -->
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Cover</h4>

                                </div>
                                <div class="card-body">
                                    <img id="cover-image" src="{{ url($user->cover) }}" class="img-fluid"
                                         alt="Cover Image">

                                    <a id="change-cover-btn" class="btn btn-primary btn-block mt-3">Αλλαγή Cover</a>

                                </div> <!-- end card-body -->
                            </div> <!-- end course info card -->
                        @endisset


{{--              @include("components.dropzone",["model"=>$user,"type"=>"Cover","dropzone"=>"cover-dropzone"] )--}}

                        <hr>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="sendMail" class="custom-control-input" id="sendMail">
                                <label class="custom-control-label" for="sendMail">Ενημέρωση χρήστη με
                                    e-mail</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 border-material">
                <h4>Social media links</h4>
                <div class="form-group ">
                    <div class="input-group">
                        <div class="input-group-prepend">
                                <span class="input-group-text" id="facebookAddress"><i
                                        class=" mdi mdi-twitter"></i></span>
                        </div>
                        <input name="facebook_link" type="text" class="form-control" id="facebookLink"
                               placeholder="facebook address"
                               value="{{ old('facebook_link') != "" ? old('facebook_link') : ( isset($user) ? $user['facebook_link'] : "" ) }}"
                               aria-describedby="inputGroupPrepend">
                    </div>
                </div>
                <div class="form-group ">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="instagramAddress"><i
                                    class=" mdi mdi-instagram"></i></span>
                        </div>
                        <input name="instagram_link" type="text" class="form-control" id="instagramLink"
                               placeholder="instagram address"
                               value="{{ old('instagram_link') != "" ? old('instagram_link') : ( isset($user) ? $user['instagram_link'] : "" ) }}"
                               aria-describedby="inputGroupPrepend">
                    </div>
                </div>
                <div class="form-group ">
                    <div class="input-group">
                        <div class="input-group-prepend">
                                <span class="input-group-text" id="linkedinAddress"><i
                                        class=" mdi mdi-linkedin"></i></span>
                        </div>
                        <input name="linkedin_link"
                               value="{{ old('linkedin') != "" ? old('linkedin') : ( isset($user) ? $user['linkedin'] : "" ) }}"
                               type="text"
                               class="form-control" id="linkedinLink"
                               placeholder="linkedin address" aria-describedby="inputGroupPrepend">
                    </div>
                </div>
                <div class="form-group ">
                    <div class="input-group">
                        <div class="input-group-prepend">
                                <span class="input-group-text" id="youtubeAddress"><i
                                        class=" mdi mdi-youtube"></i></span>
                        </div>
                        <input name="youtube_link"
                               value="{{ old('youtube_link') != "" ? old('youtube_link') : ( isset($user) ? $user['youtube_link'] : "" ) }}"
                               type="text" class="form-control"
                               id="youtubeLink"
                               placeholder="youtube address" aria-describedby="inputGroupPrepend">
                    </div>
                </div>

            </div>

        </div>

    </div>

</form>
