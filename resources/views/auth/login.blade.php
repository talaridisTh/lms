{{--@extends('layouts.app')--}}

{{--@section('content')--}}
{{--<div class="container">--}}
{{--    <div class="row justify-content-center">--}}
{{--        <div class="col-md-8">--}}
{{--            <div class="card">--}}
{{--                <h4 class="card-header bg-primary text-white">{{ __('Login') }}</h4>--}}

{{--                <div class="card-body">--}}
{{--                    <form method="POST" action="{{ route('login') }}">--}}
{{--                        @csrf--}}

{{--                        <div class="form-group row">--}}
{{--                            <label for="email" class="col-md-4 col-form-label text-md-right text-white">{{ __('E-Mail Address') }}</label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>--}}

{{--                                @error('email')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row">--}}
{{--                            <label for="password" class="col-md-4 col-form-label text-md-right text-white">{{ __('Password') }}</label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">--}}

{{--                                @error('password')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row">--}}
{{--                            <div class="col-md-6 offset-md-4">--}}
{{--                                <div class="form-check">--}}
{{--                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>--}}

{{--                                    <label class="form-check-label" for="remember">--}}
{{--                                        {{ __('Remember Me') }}--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row mb-0">--}}
{{--                            <div class="col-md-8 offset-md-4">--}}
{{--                                <button type="submit" class="btn btn-primary">--}}
{{--                                    {{ __('Login') }}--}}
{{--                                </button>--}}

{{--                                @if (Route::has('password.request'))--}}
{{--                                    <a class="btn btn-link" href="{{ route('password.request') }}">--}}
{{--                                        {{ __('Forgot Your Password?') }}--}}
{{--                                    </a>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--@endsection--}}

@extends('layouts.app')
<style>
    .background-image{
        background-image: url('images/login-backgound.png') ;
        background-repeat: no-repeat;
        /*background-size: 100% 100%;*/
        background-position: center ;

        margin: 3px auto 0;

    }

</style>
@section('content')


    <div class="container-fluid " style=" position: fixed ;max-width: 100%; height: 100%">
        <div class="row" style="height: 100%">
            <div class="col-md-12  col-lg-4 p-4 d-flex flex-column justify-content-around">
                <div class="row" style="height: 90%">
{{--                    <div class="col-md-12 mb-5">--}}
{{--                        <img height="100" src="https://lms.idrogios.com/uploads/logos/D4k5iDz1HGejDZqYPydztYdzxXUK9BYgRNaHYwGF.png"--}}
{{--                             alt="">--}}
{{--                    </div>--}}
                    <div class="col-md-12 my-5">
                        <h4>Sign In</h4>
                        <p class="text-muted">Enter your email address and password to access account.</p>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group ">
                                <div class="row">
                                <label for="email"
                                       class="col-md-6 col-form-label text-md-left ">{{ __('E-Mail Address') }}</label>


                                <div class="col-md-12">
                                        <input id="email" type="email"
                                               class="form-control @error('email') is-invalid @enderror" name="email"
                                               value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group ">
                                <div class="row">
                                    <label for="password"
                                           class="col-md-6  text-md-left ">{{ __('Password') }}</label>

                                    <div class="col-md-12">
                                        <input id="password" type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               name="password"
                                               required autocomplete="current-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 ">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember"
                                               id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                                @if (Route::has('password.request'))
                                    <a class=" text-muted col-md-6 btn btn-link  font-12 text-md-right"
                                       href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class=" form-control btn btn-info">
                                      <i class="mdi mdi-login"></i>  {{ __('Login') }}
                                    </button>


                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12 text-center d-flex justify-content-center align-items-end" style="margin-top: 180px">
                        <a href="https://www.darkpony.com/" class="text-black">
                            With <i class="mdi mdi-heart"></i> by DARKPONY
                        </a>
                    </div>

                </div>
            </div>
            <div class="col-lg-8  d-md-none d-lg-block background-image"></div>
        </div>
    </div>

@endsection




