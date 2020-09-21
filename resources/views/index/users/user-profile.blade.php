@extends("layouts.app")

@section("style")

@endsection

@section("content")
    <x-alertMsg :msg="'update'"></x-alertMsg>
    @php($user = auth()->user())

        @include("components.index.users.user-menu")



    <div class="container-fluid p-5 my-3">
        <form action="{{route('index.profile.update',$user->slug)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="row">
                <div class="col-md-4 ">
                    <h4>Πληροφορίες</h4>

                    <div class="form-group my-3">
                        <label for="first_name">Όνομα</label>
                        <input name="first_name" type="text"
                               class="form-control @error('first_name') is-invalid @enderror"
                               id="first_name"
                               placeholder="Εισάγετε όνομα"
                               value="{{ old('first_name') != "" ? old('first_name') : ( isset($user) ? $user['first_name'] : "" ) }}">
                        @error('first_name')
                        <span class="text-danger h6" role="alert"><strong>{{ $message }}</strong>	</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="last_name">Επίθετο</label>
                        <input name="last_name" type="text"
                               class="form-control @error('last_name') is-invalid @enderror"
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
                        <input name="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                               id="phone"
                               placeholder="Εισάγετε τηλέφωνο"
                               value="{{ old('phone') != "" ? old('phone') : ( isset($user) ? $user['phone'] : "" ) }}">
                        @error('phone')
                        <span class="text-danger h6" role="alert"><strong>{{ $message }}</strong>	</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="profil">Προφίλ</label>
                        <textarea name="profil" id="summary" class="form-control @error('profil') is-invalid @enderror" id="profil"
                                  placeholder="Εισάγετε πληροφορίες"
                                  rows="5"
                        >{{isset($user) ? $user['profil'] : ""}}</textarea>
                        @error('profil')
                        <span class="text-danger h6 h6" role="alert"><strong>{{ $message }}</strong>	</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 ">
                    <div class="col-md-12 ">
                        <h4>Security</h4>

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

                    <div class="col-md-12 ">
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
                <div class="w-100 text-right">
                    <button class="buton-create-material btn btn-lg btn-sm btn-primary mr-2"
                            type="submit"> {{isset($user)? "Ενημέρωση":"Δημιουργια"}}</button>
                </div>
            </div>

        </form>
    </div>

@endsection


@section("script")


    <script>


    </script>

@endsection
