<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <title>Lock Screen | Hyper - Responsive Bootstrap 4 Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description"/>
    <meta content="Coderthemes" name="author"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/css/app-modern.min.css" rel="stylesheet" type="text/css" id="light-style"/>
    <link href="/assets/css/app-modern-dark.min.css" rel="stylesheet" type="text/css" id="dark-style"/>

</head>

<body class="loading" data-layout="detached" data-layout-config='{"leftSidebarCondensed":false,"darkMode":false, "showRightSidebarOnStart": true}'>

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
                    @role("admin")
                    <div>
                        <a class="nav-link" href="/dashboard" role="button" aria-haspopup="true" aria-expanded="false">
                            Dashboard
                        </a>
                    </div>
                @endrole
                    <div>
                        <div class="dropdown">
                            <a class="nav-link  dropdown-toggle" type="button" id="dropdownMenuButton"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Guest links
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{route('user.showLinks')}}">All links</a>
                                <a class="dropdown-item" href="{{route('user.link')}}">create link</a>
                            </div>
                        </div>


                    </div>
                    <div>
                        <a id="logout-btn" class="nav-link" href="#" role="button" aria-haspopup="true"
                           aria-expanded="false">
                            Log Out
                        </a>
                    </div>
                @endif

            </div>
        </div>

    </div>
</div>
<!-- end Topbar -->

<!-- Start Content-->
<div class="container-fluid">
    <!-- Begin page -->
    <div class="wrapper">

		<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu left-side-menu-detached">

	@auth
		
		<div class="leftbar-user">
		    <a href="javascript: void(0);">
		        <img src="https://robohash.org/{{ Auth::user()->first_name }}.png?set=set5" alt="user-image" height="42" class="rounded-circle shadow-sm">
				<span class="leftbar-user-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
		    </a>
		</div>

	@endauth


	<!--- Sidemenu -->
    <ul class="metismenu side-nav">

        <li class="side-nav-title side-nav-item">Navigation</li>

		<li class="side-nav-item">
		    <a href="javascript: void(0);" class="side-nav-link">
		        <i class="uil-home-alt"></i>
		        <span class="badge badge-info badge-pill float-right">4</span>
		        <span> Dashboards </span>
		    </a>
		    <ul class="side-nav-second-level" aria-expanded="false">
		        <li>
		            <a href="dashboard-analytics.html">Analytics</a>
		        </li>
		        <li>
		            <a href="dashboard-crm.html">CRM</a>
		        </li>
		        <li>
		            <a href="index.html">Ecommerce</a>
		        </li>
		        <li>
		            <a href="dashboard-projects.html">Projects</a>
		        </li>
		    </ul>
		</li>

        <li class="side-nav-title side-nav-item">Apps</li>

		@auth
			
			<li class="side-nav-item">
				<a href="/courses/{{ Auth::user()->id }}" class="side-nav-link">
					<i class="uil-calender"></i>
					<span>Courses</span>
				</a>
			</li>

		@endauth

        <li class="side-nav-item">
            <a href="apps-chat.html" class="side-nav-link">
                <i class="uil-comments-alt"></i>
                <span> Chat </span>
            </a>
        </li>

		<li class="side-nav-item">
		    <a href="javascript: void(0);" class="side-nav-link">
		        <i class="uil-envelope"></i>
		        <span> Email </span>
		        <span class="menu-arrow"></span>
		    </a>
		    <ul class="side-nav-second-level" aria-expanded="false">
		        <li>
		            <a href="apps-email-inbox.html">Inbox</a>
		        </li>
		        <li>
		            <a href="apps-email-read.html">Read Email</a>
		        </li>
		    </ul>
		</li>

        <li class="side-nav-item">
            <a href="apps-social-feed.html" class="side-nav-link">
                <i class="uil-rss"></i>
                <span> Social Feed </span>
            </a>
        </li>

    </ul>

</div>
<!-- Left Sidebar End -->

		@yield('content')
	
    </div>
</div>
<!-- end page -->

<footer class="footer footer-alt">
    2018 - 2020 © Hyper - Coderthemes.com
</footer>

<form id="logout-form" action="{{ route('logout') }}" method="POST">
    @csrf
</form>

<!-- bundle -->
<script src="/assets/js/vendor.min.js"></script>
<script src="/assets/js/app.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script>
    $('#logout-btn').click(function () {
        event.preventDefault();
        $('#logout-form').submit();
    })
</script>

@yield("script")

</body>
</html>
