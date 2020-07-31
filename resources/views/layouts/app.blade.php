<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <title>Lock Screen | Hyper - Responsive Bootstrap 4 Admin Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app-modern.min.css" rel="stylesheet" type="text/css" id="light-style" />
        <link href="assets/css/app-modern-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" />

    </head>

    <body class="loading authentication-bg" data-layout-config='{"darkMode":true}'>

		<!-- Topbar Start -->
        <div class="navbar-custom topnav-navbar topnav-navbar-dark">
            <div class="container-fluid">

				<div class="row">
					<div class="col-3">
						<a href="index.html" class="topnav-logo">
                		    <span class="topnav-logo-lg">
                		        <img src="assets/images/logo-light.png" alt="" height="16">
                		    </span>
                		    <span class="topnav-logo-sm">
                		        <img src="assets/images/logo_sm.png" alt="" height="16">
                		    </span>
                		</a>
					</div>
					<div class="topbar-right-menu col-9 d-flex align-items-center justify-content-end h5">
						
						@if( !Auth::check() )
							<div>
								<a class="nav-link" href="/login" role="button" aria-haspopup="true" aria-expanded="false">
									Log In
                        		</a>
							</div>
							<div>
								<a class="nav-link" href="/register" role="button" aria-haspopup="true" aria-expanded="false">
									Register
                        		</a>
							</div>
						@else
							<div>
								<a class="nav-link" href="/dashboard" role="button" aria-haspopup="true" aria-expanded="false">
									Dashboard
								</a>
							</div>
							<div>
								<a id="logout-btn" class="nav-link" href="#" role="button" aria-haspopup="true" aria-expanded="false">
									Log Out
								</a>
							</div>
						@endif

					</div>
				</div>
				
            </div>
        </div>
		<!-- end Topbar -->
		
        <div class="row mt-5">

				@yield('content')

        </div>
        <!-- end page -->

        <footer class="footer footer-alt">
            2018 - 2020 © Hyper - Coderthemes.com
		</footer>
		
		<form id="logout-form" action="{{ route('logout') }}" method="POST">
			@csrf
		</form>

        <!-- bundle -->
        <script src="assets/js/vendor.min.js"></script>
		<script src="assets/js/app.min.js"></script>
		<script>
			$('#logout-btn').click( function() {
				event.preventDefault();
				$('#logout-form').submit();
			})
		</script>
        
    </body>
</html>
