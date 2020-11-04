<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>DarkponyLMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description"/>
    <meta content="Coderthemes" name="author"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link rel="stylesheet" href="{{ mix("css/index/app.css") }}">

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
      data-layout-config='{"leftSidebarCondensed":false,"darkMode":true, "showRightSidebarOnStart": true}'>

<!-- Topbar Start -->

<div id="wrapper-custom">
    <div id="header-custom" class="sticky-front p-0">
        <nav class="navbar navbar-expand-lg navbar-light bg-light ">

            @if(Auth::check())
                <a href="{{auth()->user()->getRoleNames()[0]=="guest"? "#": route('home')}}" class="topnav-logo">
                	<span class=" stop nav-logo-lg">
                	 <img class="m-2" height="60"
                          src="{{$option['logo']}}"
                          alt="">
                	</span>
                </a>
            @else
                <a href="{{route('home')}}" class="topnav-logo">
                	<span class=" sto pnav-logo-lg">
                	<img class="m-2" height="60"
                         src="https://lms.idrogios.com/uploads/logos/D4k5iDz1HGejDZqYPydztYdzxXUK9BYgRNaHYwGF.png"
                         alt="">
                	</span>
                </a>

            @endif

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                <ul class="navbar-nav text-right font-16 font-weight-bold">
                    @if( !Auth::check() )
                        <div>
                            <a class="nav-link" href="/login" role="button" aria-haspopup="true" aria-expanded="false">
                                Log In
                            </a>
                        </div>
                        <div>
                            <a class="nav-link" href="/register" role="button" aria-haspopup="true"
                               aria-expanded="false">
                                Register
                            </a>
                        </div>
                    @else
                        @unlessrole('guest')
                        @role("admin")

                        <div>
                            <a class="nav-link" href="/dashboard" role="button" aria-haspopup="true"
                               aria-expanded="false">
                                Dashboard
                            </a>
                        </div>
                        @endrole

                        <div>
                            @if(auth()->user()->courses()->count()>1 )
                                <a href="/courses/{{ Auth::user()->slug }}" class="nav-link">
                                    <span>Μαθήματα</span>
                                </a>
                            @elseif(auth()->user()->courses()->count()==1 )
                                <a
                                    href="{{route('index.userCourse',[auth()->user()->courses()->first()->slug])}}"
                                    class="nav-link">
                                    <span>Μαθήματα</span>
                                </a>
                            @else

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
                                    <a href="{{route('index.profile.history',auth()->user()->slug)}}"
                                       class="side-nav-link dropdown-item">
                                        <span>Ιστορικό </span>
                                    </a>
                                    <a href="{{route('index.profile.announcements',auth()->user()->slug)}}"
                                       class="side-nav-link dropdown-item">
                                        <span>Ανακοινώσεις</span>
                                    </a>
                                    <a href="/message" class="side-nav-link dropdown-item">
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

                                <span class="d-lg-none">Έξοδος</span>
                                <i class=" font-18 mdi mdi-logout"></i>
                            </a>
                        </div>
                    @endif

                </ul>
            </div>

        </nav>
        <!-- end Topbar -->
    </div>


    <!-- Begin page -->
    <div id="content-custom" style="min-height: 73vh;">
        @yield('content')
    </div>


    <footer class="footer-alt border-top bg-light pb-0" style="    margin-bottom: -19px;">
        <div class="container" style="max-width: 1440px;">
            <div class="row align-items-center mt-2">
                <div class="col-md-6">
                    <div class="row align-items-center">
                        <div class="col-md-4" style="width: 147px; height: 79px;">
                           	<span class=" stop nav-logo-lg">
                                 <img class="m-2" height="60"
                                      src="{{$option['logo']}}"
                                      alt="">
                	        </span>
                        </div>
                        <div class=" col-md-8">
                            <h4 class="text-left font-weight-bold font-18 mb-0" style="color: #585d63">

                                {{$option["contactInfo"]["city"]!=null?$option["contactInfo"]["city"]:""}}
                            </h4>
                            <p class="text-left d-flex flex-column font-14" style="color: #585d63">
                                <span>
                                    {{$option["contactInfo"]["address"]!=null?$option["contactInfo"]["address"].",":""}}
                                    {{$option["contactInfo"]["zipCode"]!=null?$option["contactInfo"]["zipCode"].",":""}},
                                </span>
                                <span>
                                    {{$option["contactInfo"]["email"]!=null?$option["contactInfo"]["email"]:""}}
                                    {{$option["contactInfo"]["phone"]!=null?$option["contactInfo"]["phone"]:""}} -
                                    {{$option["contactInfo"]["fax"]!=null?$option["contactInfo"]["fax"]:""}}
                                </span>
                            </p>
                        </div>

                    </div>
                </div>

                <div class="col-md-6 d-flex justify-content-end  ">
{{--                    <img class="pr-2" src="{{$option["social"]?$option["facebook"]:""}}" alt="logo">--}}
{{--                    <img class="pr-2" src="{{$option["social"]?$option["instagram"]:""}}" alt="logo">--}}
{{--                    <img class="pr-2" src="{{$option["social"]?$option["twitter"]:""}}" alt="logo">--}}
{{--                    <img class="pr-2" src="{{$option["social"]?$option["youtube"]:""}}" alt="logo">--}}
{{--                    <img class="pr-2" src="{{$option["social"]?$option["linkedIn"]:""}}" alt="logo">--}}
                </div>

            </div>
        </div>
        <hr class="border mt-2" style="opacity: 0.4;">
        <div class="container-fluid  pb-2" style="max-width: 1705px;">
            <div class="row align-items-center">
                <div class="col-sm-6  col-md-4">{{$option["copyright"]}}</div>
                <div class="col-sm-6 col-md-4">Πολιτική Απορρήτου</div>


                <div class="col-sm-12 col-md-4 text-center">
                    <a class="footer-link  text-secondary" target="_blank" href="https://www.darkpony.com">
                        <span class="mr-1">With</span>
                        <div class="heart"></div>
                        <span class="ml-1">by DARKPONY</span>
                    </a>
                </div>
            </div>
        </div>
    </footer>

</div>

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
