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

                        <div id="gallery-content" data-model="App\User" {{ isset($user)? "data-id=$user->id" : "" }} data-type="avatar">
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
                <textarea name="profil"  id="summary" class="form-control @error('profil') is-invalid @enderror" id="profil"
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
                <h4>ROLES</h4>
                <div class="form-group">
                    <select name="roles" id="roles" class="form-control  select2" data-toggle="select2">
                        @foreach ($rolesName as $role)
                            @if(isset($user))
                                <option  value="{{$role->name}}"
                                {{$user->getRoleNames()->first() == $role->name? "selected":""}}
                            @else
                                <option {{$role->name==="student"?"selected":""}} value="{{$role->name}}"
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

                @isset($user)

                <h5 class="js-link-passwordShow -4 cursor-pointer custom-link-primary">Eμφάνιση password</h5>
                <div class="form-group mt-4 passwordShow d-none">
                    <h5>Username: <span class="font-weight-normal">{{$user->email}}</span></h5>
                    <h5>Password: <span class="font-weight-normal">{{\Crypt::decryptString($user->password_encrypt)}}</span></h5>
                </div>
                @endisset
                <hr>
                @isset($user)
                <div class="form-group">
                    <div>
                        <label class="mr-2" >Aποστολή κωδικού στο χρήστη με email</label>
                        <button type="button" class="js-send-message font-12 btn btn-warning btn-sm">Send</button>
                    </div>
                </div>
                @else
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="sendMail" class="custom-control-input" id="sendMail">
                            <label class="custom-control-label" for="sendMail">Aποστολή κωδικού στο χρήστη με email</label>
                        </div>
                    </div>
                @endif


            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12 sticky  py-3 px-2 pl-3    mr-5" style="margin-top: -85px;">
                <button id="button-createMaterial-form  " type="submit"

                        class="btn btn-primary ">
                    {{isset($user)? "Ενημέρωση":"Δημιουργία"}}
                </button>
                @isset($user)
                <a target="_blank" href="{{route('index.profile',$user->slug)}}" id="preview-btn" class="under-development btn btn-warning"><i
                        class="mdi mdi-eye"></i>
                </a>
                @endisset
{{--                <button id="bundle-delete-btn" class="btn btn-danger float-right">Διαγραφή</button>--}}
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

                        <!-- Cover Preview -->

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Cover</h4>

                                </div>
                                <div class="card-body text-center">

									<img id="cover-image" src="{{ isset($user)? $user->avatar:""  }}"
										class="img-fluid{{ !isset($user) || is_null($user->avatar) ? " d-none" : "" }}"
                                         alt="Cover Image">


                                    <input hidden id="custom-file" name="avatar">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a id="change-cover-btn" class="text-white btn btn-primary btn-block mt-3">
												{{ isset($user) && !is_null($user->avatar) ? "Αλλαγή" : "Προσθηκη" }}
											</a>
                                        </div>
                                        <div class="{{ isset($user) && !is_null($user->avatar) ? "d-flex " : "d-none " }}col-md-6 justify-content-center">
                                            <a id="remove-cover-btn" class="text-white btn btn-danger btn-block mt-3">
                                                Αφαίρεση
                                            </a>
                                        </div>

                                    </div>

                                </div> <!-- end card-body -->
                            </div> <!-- end course info card -->

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

