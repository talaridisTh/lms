<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>DarkponyLMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description"/>
    <meta content="Coderthemes" name="author"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/css/app-modern.min.css" rel="stylesheet" type="text/css" id="light-style"/>
    <link href="/assets/css/app-modern-dark.min.css" rel="stylesheet" type="text/css" id="dark-style"/>
    {{--//pretty-checkbox/--}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">


    <link rel="stylesheet" href="{{ mix('css/index/app.css') }}">
    @yield("style")

    <style>

        .sticky-front {

            position: -webkit-sticky;
            position: sticky;
            top: 0px;
            z-index: 999;


        }

        .tesst {
            animation: tesst 5s ease infinite;
            color: red;
            font-size: 25px;
        }

        @keyframes tesst {
            0% {
                transform: scale(1);
            }
            5% {
                transform: scale(1.25);
            }
            20% {
                transform: scale(1);
            }
            30% {
                transform: scale(1);
            }
            35% {
                transform: scale(1.25);
            }
            50% {
                transform: scale(1);
            }
            55% {
                transform: scale(1.25);
            }
            70% {
                transform: scale(1);
            }
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


                @if(Auth::check())
                <a  href="{{auth()->user()->getRoleNames()[0]=="guest"? "#": route('home')}}" class="topnav-logo">
                		    <span class=" stopnav-logo-lg">

                		        <img class="m-2" height="60"
                                     src="https://lms.idrogios.com/uploads/logos/D4k5iDz1HGejDZqYPydztYdzxXUK9BYgRNaHYwGF.png"
                                     alt="">
                		    </span>
                </a>
                @else
                    <a  href="{{route('home')}}" class="topnav-logo">
                		    <span class=" stopnav-logo-lg">

                		        <img class="m-2" height="60"
                                     src="https://lms.idrogios.com/uploads/logos/D4k5iDz1HGejDZqYPydztYdzxXUK9BYgRNaHYwGF.png"
                                     alt="">
                		    </span>
                    </a>
                @endif
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
                    @unlessrole('guest')
                    @role("admin")

                    <div>
                        <a class="nav-link" href="/dashboard" role="button" aria-haspopup="true" aria-expanded="false">
                            Dashboard
                        </a>
                    </div>
                    @endrole

                    <div>
                        @if(auth()->user()->courses()->count()>1)
                            <a href="/courses/{{ Auth::user()->slug }}" class="nav-link">
                                <span>Μαθήματα</span>
                            </a>
                        @else
                            <a
                                href="{{route('index.userCourse',[auth()->user()->courses()->first()->slug])}}"
                                class="nav-link">
                                <span>Μαθήματα</span>
                            </a>
                        @endif
                    </div>


                    <div>
                        @role("admin")
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
                        @endrole
                    </div>

                    <div>
                        <div class="dropdown">
                            <a class="nav-link  dropdown-toggle" type="button" id="my-acount"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Λογαριασμός μου
                            </a>

                            <div class="dropdown-menu" aria-labelledby="my-acount">
                                <a href="{{route('index.profile',auth()->user()->slug)}}"
                                   class="dropdown-item side-nav-link">
                                    <span>Προφίλ </span>
                                </a>
                                <a href="{{route('index.profile.watchlist',auth()->user()->slug)}}"
                                   class="side-nav-link dropdown-item">
                                    <span>Αγαπημένα</span>
                                </a>
                                <a href="#" class="side-nav-link dropdown-item">
                                    <span>Ιστορικό </span>
                                </a>
                                <a href="{{route('index.profile.announcements',auth()->user()->slug)}}"
                                   class="side-nav-link dropdown-item">
                                    <span>Ανακοινώσεις</span>
                                </a>
                                <a href="{{route('index.message')}}" class="side-nav-link dropdown-item">
                                    <span>Μηνύματα</span>
                                </a>
                                <a href="#" class="side-nav-link dropdown-item">
                                    <span>Logout</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endunlessrole
                    <div>
                        <a id="logout-btn" class="nav-link" href="#" role="button" aria-haspopup="true"
                           aria-expanded="false" data-toggle="tooltip" data-original-title="Έξοδος">
                            <i class=" h4 mdi mdi-logout"></i>
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

    @yield('content')

</div>


<footer class=" footer-alt border-top bg-light">
    <div class="container" style="max-width: 1440px;">
        <div class="row align-items-center mt-2">
            <div class="col-md-6">
                <div class="row align-items-center">
                    <div class="col-md-4" style="width: 147px; height: 79px;">
                        <img src="/images/logo.png" alt="logo">
                    </div>
                    <div class=" col-md-8">
                        <h4 class="text-left font-weight-bold font-18 mb-0" style="color: #585d63">
                            Θεσσαλονίκη
                        </h4>
                        <p class="text-left d-flex flex-column font-14" style="color: #585d63">
                            <span>Παπαναστασίου 150, 54249,</span>
                            <span>Χαριλάου Τηλ. 2310 328797 - Fax 2310 328898</span>
                        </p>
                    </div>

                </div>
            </div>
            <div class="col-md-6 d-flex justify-content-end  ">
                <img class="pr-2" src="/images/facebook.png" alt="logo">
                <img class="pr-2" src="/images/instagram.png" alt="logo">
                <img class="pr-2" src="/images/twitter.png" alt="logo">
                <img class="pr-2" src="/images/youtube.png" alt="logo">
                <img class="pr-2" src="/images/linked-in.png" alt="logo">
            </div>

        </div>
    </div>
    <hr class="border mt-2" style="opacity: 0.4;">
    <div class="container-fluid  mb-2" style="max-width: 1705px;">
        <div class="row align-items-center">
            <div class="col-md-4 text-left">COPYRIGHT © {{ now()->year }} IDROGIOS EDUCATION</div>
            <div class="col-md-4 ">Πολιτική Απορρήτου</div>


            <div class="col-md-4 text-right">
                <a class="footer-link nav-link text-secondary" target="_blank"  href="https://www.darkpony.com">
                    <span class="mr-1">With</span>
                    <div class="heart"></div>
                    <span class="ml-1">by DARKPONY</span>
                </a>
            </div>
        </div>
    </div>
</footer>

<form id="logout-form" action="{{ route('logout') }}" method="POST">
    @csrf
</form>

<!-- bundle -->
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
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
