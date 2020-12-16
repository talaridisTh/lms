<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>{{$option["title"]}}</title>
    <meta name="route" content="{{\Request::route()->getName()}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{$option["description"]}}" name="description"/>
    <meta content="Coderthemes" name="author"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link rel="stylesheet" href="{{ mix("css/index/app.css") }}">

    {{--//pretty-checkbox/--}}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
    {{--    <link href="node_modules/lightbox2/dist/css/lightbox.css" rel="stylesheet" />--}}

    <link rel="stylesheet" href="node_modules/@splidejs/splide/dist/css/splide.min.css">

    <!--Plugin CSS file with desired skin-->


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

    <div id="header-custom" class="sticky-front p-0 navbar-light " >

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container" style="max-width: 1440px;">
                @if(Auth::check())
                    <a href="{{auth()->user()->getRoleNames()[0]=="guest"? "#": route('home')}}" class="topnav-logo">
                	<span class=" stop nav-logo-lg">
                            @isset($option['logo'])
                            <img class="m-2" height="60"
                                 src="{{$option['logo']}}"
                                 alt="">
                        @endisset
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
                                <a class="nav-link" href="/login" role="button" aria-haspopup="true"
                                   aria-expanded="false">
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

                            @hasanyrole("admin|super-admin")


                            @if(\Request::route()->getName()== "index.userCourse")
                                <div>
                                    <a class="nav-link edit-preview-page-course" href="" role="button"
                                       aria-haspopup="true"
                                       aria-expanded="false">
                                        Edit this course
                                    </a>
                                </div>


                                <div>
                                    <a class="nav-link edit-preview-page-material d-none" href="" role="button"
                                       aria-haspopup="true"
                                       aria-expanded="false">
                                        Edit this Material
                                    </a>
                                </div>
                            @endif


                            <div>
                                <a class="nav-link" href="/dashboard" role="button" aria-haspopup="true"
                                   aria-expanded="false">
                                    Dashboard
                                </a>
                            </div>

                            @endhasanyrole



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
                                @hasanyrole('super-admin|admin')
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
                                @endhasanyrole
                            </div>


                            <div>
                                <a class="nav-link" href="{{route('discussion.index')}}" role="button"
                                   aria-haspopup="true"
                                   aria-expanded="false">
                                    Discussions
                                </a>
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
                                           class="side-nav-link dropdown-item template d-none">
                                            <span>Αγαπημένα</span>
                                        </a>
                                        <a href="{{route('index.profile.history',auth()->user()->slug)}}"
                                           class="side-nav-link dropdown-item template d-none">
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

            </div>
        </nav>

            <!-- end Topbar -->
    </div>


    <!-- Begin page -->
    <div id="content-custom" style="min-height: 73vh;">
        @yield('content')
    </div>

    @php
        $contactInfo = json_decode( $option["contactInfo"]);
        $socialMedia = json_decode( $option["social"]);
        $socials = ["facebook","instagram","twitter","youtube","linkedIn"];
    @endphp

    <footer class="footer-alt border-top bg-light pb-0" style="    margin-bottom: -19px;">
        <div class="container" style="max-width: 1440px;">
            <div class="row align-items-center mt-2">
                <div class="col-md-12">
                    <div class="row align-items-center">
                        <div class="col-md-10 col-sm-12 d-flex justify-content-center justify-content-md-start">
                           	<span class=" stop nav-logo-lg">
                                @isset($option['logo'])
                                    <img class="m-2" height="60"
                                         src="{{$option['logo']}}"
                                         alt="">
                                @endisset
                	        </span>
                            <h4 class="text-left font-weight-bold font-19 mb-0" style="color: #585d63">
                                {{isset($contactInfo->city)?$contactInfo->city:""}}
                                <p class="text-left d-flex flex-column font-14" style="color: #585d63">
                                        <span>
                                            {{isset($contactInfo->address)?$contactInfo->address.",":""}}
                                            {{isset($contactInfo->zipCode)?$contactInfo->zipCode.",":""}}
                                        </span>
                                    <span>
                                            {{isset($contactInfo->email)?$contactInfo->email:""}}
                                        </span>
                                    <span>{{isset($contactInfo->phone)?$contactInfo->phone:""}}
                                        {{isset($contactInfo->fax)?$contactInfo->fax:""}}</span>
                                </p>
                            </h4>
                        </div>
                        <div class=" col-md-2 col-sm-12">
                            <div class="d-flex justify-content-between px-3 ">

                                @foreach($socials as $social)
                                    @isset($socialMedia->$social)
                                        <a href="{{$socialMedia->$social}}">
                                            <img src="{{asset("images/$social.png")}}" alt="">
                                        </a>
                                    @endisset
                                @endforeach


                            </div>
                        </div>
                    </div>
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


    $(".edit-preview-page-course").on("click", function () {
        this.href = window.PREVIEW_PAGE_COURSE
    })
</script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css"/>


<!--Plugin JavaScript file-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>
{{--<script src="node_modules/lightbox2/dist/js/lightbox.js"></script>--}}


@yield("script")

</body>
</html>
