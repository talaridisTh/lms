<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <title>DarkponyLMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description"/>
    <meta content="Coderthemes" name="author"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/css/app-modern.min.css" rel="stylesheet" type="text/css" id="light-style"/>
    <link href="/assets/css/app-modern-dark.min.css" rel="stylesheet" type="text/css" id="dark-style"/>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @yield("style")

    <style>
        Route::get('/', [PageController::class, 'home']);
        .sticky-front{

            position: -webkit-sticky;
            position: sticky;
            top: 0px;
            z-index: 999;
        }



    </style>
</head>

<body style=" font-family: 'Open Sans' " class="loading" data-layout="detached"
      data-layout-config='{"leftSidebarCondensed":false,"darkMode":false, "showRightSidebarOnStart": true}'>

<!-- Topbar Start -->
<div class="navbar-custom   sticky-front topnav-navbar topnav-navbar-white">
    <div class="container-fluid">

        <div class="row">
            <div class="col-3">
                <a href="{{route('home')}}" class="topnav-logo">
                		    <span class=" stopnav-logo-lg">
                		        <img class="m-2" height="100" src="https://lms.idrogios.com/uploads/logos/D4k5iDz1HGejDZqYPydztYdzxXUK9BYgRNaHYwGF.png" alt="">
                		    </span>
                    <span class="topnav-logo-sm">
{{--                		        <img class="m-2" height="100" src="https://lms.idrogios.com/uploads/logos/D4k5iDz1HGejDZqYPydztYdzxXUK9BYgRNaHYwGF.png" alt="" height="33">--}}
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


<!-- Begin page -->
<div class="wrapper">


    <!-- ========== Left Sidebar Start ========== -->

    @if(Route::currentRouteName() =='home')
        <div class="">

                @include("components.index.users.user-menu")

        </div>
        <!-- Left Sidebar End -->
    @endif


    @yield('content')

</div>


{{--<footer class="footer footer-alt ">--}}
{{--    2018 - 2020 © Hyper - Coderthemes.com--}}
{{--</footer>--}}

<form id="logout-form" action="{{ route('logout') }}" method="POST">
    @csrf
</form>

<!-- bundle -->
<script src="/assets/js/vendor.min.js"></script>
<script src="/assets/js/app.min.js"></script>
<script src="{{ mix('js/app.js') }}"></script>
<script>
    $('#logout-btn').click(function () {
        event.preventDefault();
        $('#logout-form').submit();
    })
</script>

@yield("script")

</body>
</html>
