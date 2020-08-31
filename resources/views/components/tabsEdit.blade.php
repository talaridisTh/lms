<form id="buttonUser" class="px-4" action="{{route('user.update',$user->slug)}}" method="POST"
      enctype="multipart/form-data">
    @method("patch")
    @csrf
    <div class="row">
        <div class="col-md-4 border-material">
            <h4>Πληροφορίες</h4>
            <div class="form-group my-3">
                <label for="first_name">Όνομα</label>
                <input name="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror"
                       id="first_name"
                       placeholder="Εισάγετε όνομα"
                       value="{{old('user', $user->first_name)}}">
                @error('first_name')
                <span class="text-danger h6" role="alert"><strong>{{ $message }}</strong>	</span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="last_name">Επίθετο</label>
                <input name="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror"
                       id="last_name"
                       placeholder="Εισάγετε επίθετο"
                       value="{{old('user', $user->last_name)}}">
                @error('last_name')
                <span class="text-danger h6" role="alert"><strong>{{ $message }}</strong>	</span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="email">E-mail</label>
                <div class="input-group ">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                    </div>
                    <input name="email" type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                           placeholder="Εισάγετε e-mail" value="{{old('user', $user->email)}}"
                           aria-describedby="inputGroupPrepend"
                    >

                </div>
                @error('email')
                <span class="text-danger h6" role="alert"><strong>{{ $message }}</strong>	</span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="phone">Τηλέφωνο</label>
                <input name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                       placeholder="Εισάγετε τηλέφωνο"
                       value="{{old('user', $user->phone)}}">
                @error('phone')
                <span class="text-danger h6" role="alert"><strong>{{ $message }}</strong>	</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="profil">Προφίλ</label>
                <textarea name="profil" class="form-control @error('profil') is-invalid @enderror" id="profil"
                          placeholder="Εισάγετε πληροφορίες"
                          rows="5">{{ $user->profil}}"</textarea>
                @error('profil')
                <span class="text-danger h6 h6" role="alert"><strong>{{ $message }}</strong>	</span>
                @enderror
            </div>
        </div>

        <div class="col-md-4">
            <div class="col-md-12 border-material">
                <h4>Photo</h4>
            </div>
            <div class="col-md-12 border-material">
                <h4>Security</h4>
                <div class="form-group">
                    <select name="roles" id="roles" class="form-control  select2" data-toggle="select2">
                        <option value="{{$user->roles[0]->id}}">{{$user->roles[0]->name}}</option>
                        @foreach($rolesName as $role)
                            <option
                                value="{{$role->id}} {{$role->id==$user->roles[0]->id? "selected":""}}">{{$role->name }}</option>
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


            </div>
        </div>
        <div class="col-md-4">
            <div class="sticky" style="margin-top:-60px;margin-bottom: 54px">
                <button class="buton-create-material btn btn-sm btn-primary mr-2">Ενημέρωση</button>
{{--                <form method="POST" id="alertSumbit"--}}
{{--                      action="{{route('user.destroy',$user->id)}}">--}}
{{--                    @csrf--}}
{{--                    @method('DELETE')--}}
{{--                    <button--}}
{{--                        data-id="{{ $user->id }}"--}}
{{--                        data-slug="{{ $user->slug }}"--}}

{{--                        class=" js-delete btn btn-danger ">--}}
{{--                        Διαγραφη {{$user->fullName}}--}}
{{--                    </button>--}}
{{--                </form>--}}
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
                                           {{$user->status? "checked":""}}
                                           data-switch="bool"/>
                                    <label for="activeMaterial" data-on-label="On" data-off-label="Off"></label>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <label>Αvatar</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="avatar" type="file" class="custom-file-input"
                                           id="inputGroupFile04">
                                    <label class="custom-file-label" for="inputGroupFile04">Εισάγετε
                                        φωτογραφία</label>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="sendMail" class="custom-control-input" id="sendMail">
                                <label class="custom-control-label" for="sendMail">Ενημέρωση χρήστη με e-mail</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="my-2"><img height="60" class="rounded-circle"
                                               src="https://recap-project.eu/wp-content/uploads/2017/02/default-user.jpg"
                                               alt=""></div>
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
                               placeholder="facebook address" value="{{old('user', $user->facebook_link)}}"
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
                               placeholder="instagram address" value="{{old('user', $user->instagram_link)}}"
                               aria-describedby="inputGroupPrepend">
                    </div>
                </div>
                <div class="form-group ">
                    <div class="input-group">
                        <div class="input-group-prepend">
                                <span class="input-group-text" id="linkedinAddress"><i
                                        class=" mdi mdi-linkedin"></i></span>
                        </div>
                        <input name="linkedin_link" type="text" class="form-control" id="linkedinLink"
                               placeholder="linkedin address" value="{{old('user', $user->linkedin_link)}}"
                               aria-describedby="inputGroupPrepend">
                    </div>
                </div>
                <div class="form-group ">
                    <div class="input-group">
                        <div class="input-group-prepend">
                                <span class="input-group-text" id="youtubeAddress"><i
                                        class=" mdi mdi-youtube"></i></span>
                        </div>
                        <input name="youtube_link" type="text" class="form-control" id="youtubeLink"
                               placeholder="youtube address" value="{{old('user', $user->youtube_link)}}"
                               aria-describedby="inputGroupPrepend">
                    </div>
                </div>

            </div>

        </div>


    </div>

</form>
