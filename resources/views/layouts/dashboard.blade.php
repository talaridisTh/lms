<!DOCTYPE html>
	<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

	<head>
		<meta charset="utf-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<title>DarkponyLMS</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
		<meta content="Coderthemes" name="author" />
		<!-- App favicon -->
		<link rel="shortcut icon" href="/assets/images/favicon.ico">
		<!-- App css -->
		<link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
		<link href="/assets/css/app-modern.min.css" rel="stylesheet" type="text/css" id="light-style" />
		<link href="/assets/css/app-modern-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" />

		<link rel="stylesheet" href="{{ mix('css/app.css') }}">
		@yield('css')

	</head>

	<body class="loading right-bar-enabled" data-layout-config='{"leftSideBarTheme":"default","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":true, "showRightSidebarOnStart": true }'>
		<!-- Begin page -->
		<div class="wrapper">
			<!-- ========== Left Sidebar Start ========== -->
			<div class="left-side-menu">
				<!-- LOGO -->
				<a href="{{route('home')}}" class="logo text-center logo-light">
					<span class="logo-lg">
						<img src="/assets/images/preview-lightbox-logo.png" alt="">
					</span>
					<span class="logo-sm">
						<img src="/assets/images/preview-lightbox-logo.png" alt="" height="16">
					</span>
				</a>

				<!-- LOGO -->
				<a href="{{route('home')}}" class="logo text-center logo-dark">
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

						<li class="side-nav-item">
							<a href="/dashboard" class="side-nav-link">
								<i class="mdi mdi-speedometer"></i>
								<span>Overview</span>
							</a>
						</li>
						<li class="side-nav-item">
							<a href="{{route('user.index')}}" class="side-nav-link">
								<i class="mdi mdi-account-multiple"></i>
								<span>Χρήστες</span>
							</a>
						</li>
						<li class="side-nav-item">
							<a href="/dashboard/materials" class="side-nav-link">
								<i class="mdi mdi-book-open-page-variant"></i>
								<span>Μαθήματα</span>
							</a>
						</li>
						<li class="side-nav-item">
							<a href="/dashboard/courses" class="side-nav-link">
								<i class="mdi mdi-label-multiple"></i>
								<span>Courses</span>
							</a>
						</li>
						<li class="side-nav-item">
							<a href="/dashboard/bundles" class="side-nav-link">
								<i class="mdi mdi-package-variant"></i>
								<span>Bundles</span>
							</a>
						</li>

						<li class="side-nav-item">
							<a href="/dashboard/topics" class="side-nav-link">
								<i class="mdi mdi-chart-bubble"></i>
								<span>Topics</span>
							</a>
						</li>

                        <li class="side-nav-item">
                            <a href="{{route('media.index')}}" class="side-nav-link">
                                <i class="mdi mdi-chart-bubble"></i>
                                <span>Content</span>
                            </a>
                        </li>

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
								<a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
									<i class="dripicons-search noti-icon"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
									<form class="p-3">
										<input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
									</form>
								</div>
							</li>
                            <li class="notification-list">
                                <a class="nav-link right-bar-toggle" href="javascript: void(0);">
                                    <i class="dripicons-gear noti-icon"></i>
                                </a>
                            </li>

							<li class="dropdown notification-list">
								<a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
									<i class="dripicons-bell noti-icon"></i>
									<span class="noti-icon-badge"></span>
								</a>
								<div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-lg">

									<!-- item-->
									<div class="dropdown-item noti-title">
										<h5 class="m-0">
											<span class="float-right">
												<a href="javascript: void(0);" class="text-dark">
													<small>Clear All</small>
												</a>
											</span>Notification
										</h5>
									</div>

									<div style="max-height: 230px;" data-simplebar>
										<!-- item-->
										<a href="javascript:void(0);" class="dropdown-item notify-item">
											<div class="notify-icon bg-primary">
												<i class="mdi mdi-comment-account-outline"></i>
											</div>
											<p class="notify-details">Caleb Flakelar commented on Admin
												<small class="text-muted">1 min ago</small>
											</p>
										</a>

										<!-- item-->
										<a href="javascript:void(0);" class="dropdown-item notify-item">
											<div class="notify-icon bg-info">
												<i class="mdi mdi-account-plus"></i>
											</div>
											<p class="notify-details">New user registered.
												<small class="text-muted">5 hours ago</small>
											</p>
										</a>

										<!-- item-->
										<a href="javascript:void(0);" class="dropdown-item notify-item">
											<div class="notify-icon">
												<img src="/assets/images/users/avatar-2.jpg" class="img-fluid rounded-circle" alt="" /> </div>
											<p class="notify-details">Cristina Pride</p>
											<p class="text-muted mb-0 user-msg">
												<small>Hi, How are you? What about our next meeting</small>
											</p>
										</a>

										<!-- item-->
										<a href="javascript:void(0);" class="dropdown-item notify-item">
											<div class="notify-icon bg-primary">
												<i class="mdi mdi-comment-account-outline"></i>
											</div>
											<p class="notify-details">Caleb Flakelar commented on Admin
												<small class="text-muted">4 days ago</small>
											</p>
										</a>

										<!-- item-->
										<a href="javascript:void(0);" class="dropdown-item notify-item">
											<div class="notify-icon">
												<img src="/assets/images/users/avatar-4.jpg" class="img-fluid rounded-circle" alt="" /> </div>
											<p class="notify-details">Karen Robinson</p>
											<p class="text-muted mb-0 user-msg">
												<small>Wow ! this admin looks good and awesome design</small>
											</p>
										</a>

										<!-- item-->
										<a href="javascript:void(0);" class="dropdown-item notify-item">
											<div class="notify-icon bg-info">
												<i class="mdi mdi-heart"></i>
											</div>
											<p class="notify-details">Carlos Crouch liked
												<b>Admin</b>
												<small class="text-muted">13 days ago</small>
											</p>
										</a>
									</div>

									<!-- All-->
									<a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
										View All
									</a>

								</div>
							</li>

							<li class="dropdown notification-list d-none d-sm-inline-block">
								<a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
									<i class="dripicons-view-apps noti-icon"></i>
								</a>
							</li>

							<li class="dropdown notification-list">
								<a class="nav-link dropdown-toggle nav-user arrow-none mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
									aria-expanded="false">
									<span class="account-user-avatar">
										<img src="https://robohash.org/{{ Auth::user()->first_name }}.png?set=set5" alt="user-image" class="rounded-circle">
									</span>
									<span>
										<span class="account-user-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
										<span class="account-position">{{ Auth::user()->email }}</span>
									</span>
								</a>
								<div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
									<!-- item-->
									<div class=" dropdown-header noti-title">
										<h6 class="text-overflow m-0">Welcome !</h6>
									</div>

									<!-- item-->
									<a href="javascript:void(0);" class="dropdown-item notify-item">
										<i class="mdi mdi-account-circle mr-1"></i>
										<span>My Account</span>
									</a>

									<!-- item-->
									<a href="javascript:void(0);" class="dropdown-item notify-item">
										<i class="mdi mdi-account-edit mr-1"></i>
										<span>Settings</span>
									</a>

									<!-- item-->
									<a id="logout-btn" href="#" class="dropdown-item notify-item">
										<i class="mdi mdi-logout mr-1"></i>
										<span>Logout</span>
									</a>

								</div>
							</li>

						</ul>
						<button class="button-menu-mobile open-left disable-btn">
							<i class="mdi mdi-menu"></i>
						</button>
						<div class="app-search dropdown d-none d-lg-block">
							<form>
								<div class="input-group">
									<input type="text" class="form-control dropdown-toggle" placeholder="Search..." id="top-search">
									<span class="mdi mdi-magnify search-icon"></span>
									<div class="input-group-append">
										<button class="btn btn-primary" type="submit">Search</button>
									</div>
								</div>

							</form>

						</div>
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
									<a href="javascript: void(0);">About</a>
									<a href="javascript: void(0);">Support</a>
									<a href="javascript: void(0);">Contact Us</a>
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
		<script src="/assets/js/app.min.js"></script>
		<script src="{{ mix('js/app.js') }}"></script>

		<script>
			$('#logout-btn').click( function() {
				event.preventDefault();

				$('#logout-form').submit();
			})
		</script>

		@yield('scripts')
	</body>
</html>
