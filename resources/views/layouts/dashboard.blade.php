<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="noindex, nofollow">
	
    <link rel="icon" size="32x32" type="image/png" href="{{ asset("images/favicon-32x32.png") }}"/>
    <link rel="stylesheet" href="{{ mix('css/dashboard/app.css') }}">
	
    <title>DarkponyLMS</title>
    <style>
        .results-cnt {
            min-width: 315px;
            max-width: 640px;
            z-index: 1100 !important;
        }

        .results-cnt .dropdown-item {
            width: 290px;
        }

        .search-text-ellipsis {
            max-width: 210px;
            display: block;
            text-overflow: ellipsis;
            overflow: hidden;
        }

    </style>
    @yield('css')

</head>

<body class="loading right-bar-enabled" draggable="false"
      data-layout-config='{"leftSideBarTheme":"default","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":true, "showRightSidebarOnStart": true }'>
<!-- Begin page -->
<div class="wrapper">
    <!-- ========== Left Sidebar Start ========== -->
    <div class="left-side-menu">
        <!-- LOGO -->
        <a href="{{route('home')}}" class="logo text-center logo-light" draggable="false">
					<span class="logo-lg">
						<img src="/assets/images/preview-lightbox-logo.png" alt="" draggable="false">
					</span>
            <span class="logo-sm">
						<img src="/assets/images/preview-lightbox-logo.png" alt="" height="16" draggable="false">
					</span>
        </a>

        <!-- LOGO -->
        <a href="{{route('home')}}" class="logo text-center logo-dark" draggable="false">
					<span class="logo-lg">
						<img src="/assets/images/preview-lightbox-logo.png" alt="">
					</span>
            <span class="logo-sm">
						<img src="/assets/images/preview-lightbox-logo.png" alt="" height="16">
					</span>
        </a>

        <div class="h-100" id="left-side-menu-container" data-simplebar>

            <!--- Sidemenu -->
            <ul class="metismenu side-nav">

                <li class="side-nav-title side-nav-item">Menu</li>

				@hasanyrole("admin|super-admin")
					<li class="side-nav-item">
						<a href="/dashboard" class="side-nav-link" draggable="false">
							<i class="mdi mdi-speedometer"></i>
							<span>Overview</span>
						</a>
					</li>
					<li class="side-nav-item">
						<a href="/dashboard/users" class="side-nav-link" draggable="false">
							<i class="mdi mdi-account-multiple"></i>
							<span>Χρήστες</span>
						</a>
					</li>
				@endhasanyrole

				<li class="side-nav-item">
					<a href="/dashboard/courses" class="side-nav-link" draggable="false">
						<i class="uil uil-books"></i>
						<span>Courses</span>
					</a>
				</li>
				<li class="side-nav-item">
					<a href="/dashboard/materials" class="side-nav-link" draggable="false">
						<i class="mdi mdi-book-open-page-variant"></i>
						<span>Υλικό</span>
					</a>
				</li>
				<li class="side-nav-item">
                    <a href="/dashboard/homeworks" class="side-nav-link" draggable="false">
                        <i class="mdi mdi-facebook-workplace"></i>
                        <span>Εργασίες</span>
                    </a>
                </li>

				@hasanyrole("admin|super-admin")
					<li class="side-nav-item">
						<a href="/dashboard/topics" class="side-nav-link" draggable="false">
							<i class="mdi mdi-tag"></i>
							<span>Topics</span>
						</a>
					</li>
				@endhasanyrole

                <li class="side-nav-item">
                    <a href="{{route('media.index')}}" class="side-nav-link" draggable="false">
                        <i class="mdi mdi-cloud-upload-outline"></i>
                        <span>Media</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/dashboard/email" class="side-nav-link" draggable="false">
                        <i class="mdi mdi-email-outline"></i>
                        <span>E-Mail</span>
                    </a>
				</li>
				
				@hasanyrole("admin|super-admin")
                	<li class="side-nav-item">
                	    <a href="javascript: void(0);" class="side-nav-link" draggable="false">
                	        <i class="mdi mdi-cog"></i>
                	        <span> Settings </span>
                	        <span class="menu-arrow"></span>
                	    </a>
                	    <ul class="side-nav-second-level" aria-expanded="false">
                	        <li>
                	            <a href="/dashboard/general-settings" draggable="false">
                	                <i class="font-16 mdi mdi-progress-wrench"></i>
                	                General
                	            </a>
                	        </li>
                	        <li>
                	            <a href="/dashboard/home-carousels" draggable="false">
                	                <i class="font-16 mdi mdi-view-carousel-outline"></i>
                	                Carousels
                	            </a>
                	        </li>
                	        <li class="side-nav-item">
                	            <a href="javascript: void(0);" draggable="false" aria-expanded="false">
                	                <i class="font-16 mdi mdi-cookie"></i>
                	                <span>Policies</span>
                	                <span class="menu-arrow"></span>
                	            </a>
                	            <ul class="side-nav-third-level" aria-expanded="false">
                	                <li>
                	                    <a href="/dashboard/options/terms-of-use" draggable="false">Terms of Use</a>
                	                </li>
                	                <li>
                	                    <a href="/dashboard/options/privacy-policy" draggable="false">Privacy Policy</a>
                	                </li>
                	                <li>
                	                    <a href="/dashboard/options/cookie-policy" draggable="false">Cookie Policy</a>
                	                </li>
                	            </ul>
                	        </li>
                	    </ul>
					</li>
				@endhasanyrole

				@hasrole("super-admin")
                    <li class="side-nav-item">
                        <a href="javascript: void(0);" class="side-nav-link" draggable="false">
                            <i class="mdi mdi-hammer-wrench"></i>
                            <span>Dev Tools</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="side-nav-second-level" aria-expanded="false">
                            <li>
                                <a href="/dashboard/options" draggable="false">
                                    Options
                                </a>
                            </li>
                        </ul>
                    </li>
				@endhasrole
            </ul>
            <!-- End Sidebar -->

        </div>
        <!-- Sidebar -left -->

    </div>
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">
            <!-- Topbar Start -->
            <div class="navbar-custom">
                <ul class="list-unstyled topbar-right-menu float-right mb-0">
                    <li class="dropdown notification-list d-lg-none">
                        <a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="#" role="button"
                           aria-haspopup="false" aria-expanded="false">
                            <i class="dripicons-search noti-icon"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-lg p-0">
                            <form class="p-3" action="/dashboard/search" method="GET">
                                @csrf
                                <input type="text" class="form-control js-global-search"
                                       name="search" placeholder="Search ..." autocomplete="off"
                                       aria-label="Recipient's username">
                            </form>
                        </div>
                    </li>

                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle nav-user arrow-none mr-0" data-toggle="dropdown" href="#"
                           role="button" aria-haspopup="false"
                           aria-expanded="false" draggable="false">
									<span class="account-user-avatar">
										<img src="{{ Auth::user()->thumbnailUrl("avatar") }}" alt="user-image"
                                             class="rounded-circle" draggable="false">
									</span>
                            <span>
										<span
                                            class="account-user-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
										<span class="account-position">{{ Auth::user()->email }}</span>
									</span>
                        </a>
                        <div
                            class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                            <!-- item-->
                            <div class=" dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome !</h6>
                            </div>

                            <!-- item-->
							<a href="{{ auth()->user()->hasRole("instructor") 
								? "/home/account/". Auth::user()->slug 
								: "/dashboard/users/". Auth::user()->slug }}"
								class="dropdown-item notify-item"
                               draggable="false">
                                <i class="mdi mdi-account-circle mr-1"></i>
                                <span>My Account</span>
                            </a>

                            <!-- item-->
                            <a id="logout-btn" href="#" class="dropdown-item notify-item" draggable="false">
                                <i class="mdi mdi-logout mr-1"></i>
                                <span>Logout</span>
                            </a>

                        </div>
                    </li>

				</ul>
				@hasanyrole("super-admin|admin")
					<button class="button-menu-mobile open-left disable-btn">
						<i class="mdi mdi-menu"></i>
					</button>
					<div class="app-search dropdown d-none d-lg-block">
						<form action="/dashboard/search" method="GET">
							@csrf
							<div class="input-group">
								<input id="top-search" class="js-global-search form-control dropdown-toggle"
									name="search" type="text" placeholder="Search..." autocomplete="off">
								<span class="mdi mdi-magnify search-icon"></span>
								<div class="input-group-append">
									<button class="btn btn-primary" type="submit" draggable="false">Search</button>
								</div>
							</div>
						</form>

						<div id="search-dropdown" class="results-cnt dropdown-menu dropdown-menu-animated">

							<div class="row mx-0">
								<span class="py-2 d-block text-center mx-auto font-16">
									<i class="mdi mdi-magnify mr-1"></i>
									<u>3 Characters or more</u>
								</span>
							</div>

						</div>

					</div>
				@endhasanyrole
            </div>
            <!-- end Topbar -->

            <!-- Start Content-->
            <div class="container-fluid">

                @yield('content')

            </div>
            <!-- container -->

        </div>
        <!-- content -->

        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        DarkponyLMS
                    </div>
                    <div class="col-md-6">
                        <div class="text-md-right footer-links d-none d-md-block">
                            <a href="javascript: void(0);" draggable="false">About</a>
                            <a href="javascript: void(0);" draggable="false">Support</a>
                            <a href="javascript: void(0);" draggable="false">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>
<!-- END wrapper -->

<form id="logout-form" action="{{ route('logout') }}" method="POST">
    @csrf
</form>


<!-- /Right-bar -->
<!-- bundle -->
<script src="/assets/js/vendor.min.js"></script>
{{-- <script src="/assets/js/app.min.js"></script>--}}
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ mix('js/dashboard/dashboard.js') }}"></script>

<script>
    $('#logout-btn').click(function () {
        event.preventDefault();

        $('#logout-form').submit();
    })
</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-179237450-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', 'UA-179237450-1');
</script>


@yield('scripts')
</body>
</html>
