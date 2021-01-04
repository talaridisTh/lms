<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>ΥΔΡΟΓΕΙΟΣ EDUCATION</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<meta name="description" content="ΥΔΡΟΓΕΙΟΣ EDUCATION">

		<!-- App css -->
		<link rel="stylesheet" href="{{ mix("css/index/logIn.css") }}">
    </head>

    <body class="pb-0">

        <div class="auth-column">
            <!--Auth fluid left content -->
            <div class="form-cnt">
                <div class="align-items-center d-flex h-100">
                    <div class="card-body pb-5">

                        <!-- Logo -->
                        <div class="log-in-logo text-center text-lg-left">
                            <a href="/">
								<span><img src="{{ asset("images/logo.png") }}" alt="" height="100"></span>
							</a>
                        </div>

                        <!-- title-->
                        <h4 class="mt-0">Sign In</h4>
                        <p class="text-muted mb-4">Enter your email address and password to access account.</p>

                        <!-- form -->
						<form method="POST" action="{{ route('login') }}">

							@csrf

                            <div class="form-group">
                                <label for="email">Email address</label>
								<input class="form-control @error('email') is-invalid @enderror"
									type="email" id="email" name="email" value="{{ old('email') }}" required="" placeholder="Enter your email">
							</div>

                            <div class="form-group">
								@if (Route::has('password.request'))
                                    <a class="custom-link-muted float-right" href="{{ route('password.request') }}" tabindex="-1">
                                        <small>{{ __('Forgot Your Password?') }}</small>
                                    </a>
                                @endif
                                <label for="password">Password</label>
								<input class="form-control @error('password') is-invalid @enderror"
									type="password" name="password" required="" id="password" placeholder="Enter your password">
							</div>

                            <div class="form-group mb-3">
                                <div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input"
										id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="remember">Remember me</label>
                                </div>
							</div>

                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-block btn-info " type="submit"><i class="mdi mdi-login"></i> Log In </button>
                            </div>
                        </form>
                        <!-- end form-->
                    </div> <!-- end .card-body -->
                </div>
				<footer class="footer footer-alt text-center">
					<a target="_blank" href="http://darkpony.com" title="Visit Darkpony" class="text-dark custom-font-small">
						With <i class="mdi mdi-heart"></i> by DARKPONY
					</a>
				</footer>
			</div>
			<div class="fade-out"></div>
		</div>

		<div class="centered-form-cnt">
			<div class="fade-out d-flex justify-content-center align-items-center">
				<div class="log-in-logo text-center text-lg-left">
					<a href="/">
						<span><img src="{{ asset("images/logo.png") }}" alt="" height="100"></span>
					</a>
				</div>
				<div class="card">
					<div class="card-body">
						 <!-- title-->
						 <h4 class="mt-0">Sign In</h4>
						 <p class="text-muted mb-4">Enter your email address and password to access account.</p>

						 <form method="POST" action="{{ route('login') }}">

							@csrf

                            <div class="form-group">
                                <label for="sm-email">Email address</label>
								<input class="form-control @error('email') is-invalid @enderror"
									type="email" id="sm-email" name="email" value="{{ old('email') }}" required="" placeholder="Enter your email">
							</div>

                            <div class="form-group">
								@if (Route::has('password.request'))
                                    <a class="custom-link-muted float-right" href="{{ route('password.request') }}" tabindex="-1">
                                        <small>{{ __('Forgot Your Password?') }}</small>
                                    </a>
                                @endif
                                <label for="sm-password">Password</label>
								<input class="form-control @error('password') is-invalid @enderror"
									type="password" name="password" required="" id="sm-password" placeholder="Enter your password">
							</div>

                            <div class="form-group mb-3">
                                <div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input"
										id="sm-remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="sm-remember">Remember me</label>
                                </div>
							</div>

                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-block btn-info " type="submit"><i class="mdi mdi-login"></i> Log In </button>
                            </div>
                        </form>
                        <!-- end form-->
					</div>
				</div>
			</div>
		</div>


{{--		<script src="{{ mix("js/index/app.js") }}"></script>--}}
    </body>

</html>
