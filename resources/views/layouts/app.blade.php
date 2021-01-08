<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="route" content="{{\Request::route()->getName()}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ $options->description }}" name="description">


    <title>{{ $options->title }}</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{$options->logo}}">

    <link href="{{ mix('css/index/theme.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="node_modules/@splidejs/splide/dist/css/splide.min.css">

    <style>
        @font-face {
            font-family: Helvetica;
            src: url('{{asset('/fonts/Helvetica.tff')}}');
        }
    </style>

    @yield("style")

</head>
<body class="h-full  antialiased"
      style="font-family: 'Helvetica', sans-serif;">

<div id="app" class=" flex flex-col h-screen relative" style="">


    <header id="header" class="lg:px-16 z-50 sticky top-0 px-8 bg-white py-4 shadow-md relative " style="">

        <div class="container mx-auto max-w-1xl flex flex-wrap items-center px-1 intro-x">
            <div class="flex-1 flex justify-between items-center">
                <a href="/tailwind" class="text-xl">
                    <img class="logo" src="{{ $options->logo }}" alt="{{ $options->title }}" height="80">
                </a>
            </div>

            <div class="hidden md:flex md:items-center md:w-auto w-full" id="menu">
                <!-- BEGIN: Top Menu -->
                <nav class="top-nav">
                    <ul class="p-0">
                        @hasanyrole("admin|super-admin")
                        <li class="orange-line intro-x">
                            <a href="{{route('dashboard')}}" class="top-menu">
                                <div class="top-menu__icon"><i data-feather="tool"></i></div>
                                <div class="top-menu__title ">Dashboard</div>
                            </a>
                        </li>
                    @if(\Request::route()->getName()== "index.userCourse")
                            <li>
                                <a href="#" class="top-menu">
                                    <div class="top-menu__icon"><i data-feather="home"></i></div>
                                    <div class="top-menu__title"> edit this course</div>
                                </a>
                            </li>
                            <li class="orange-line">>
                                <a href="#" class="top-menu">
                                    <div class="top-menu__icon"><i data-feather="home"></i></div>
                                    <div class="top-menu__title"> Edit this material</div>
                                </a>
                            </li>
                        @endif
                        @endhasanyrole
                        <li class="orange-line intro-x">
                            <a href="{{route('index.userCourses',auth()->id())}}" class="top-menu">
                                <div class="top-menu__icon"><i data-feather="home"></i></div>
                                <div class="top-menu__title"> Μαθήματα</div>
                            </a>
                        </li>

                        <li class=" orange-line intro-x">
                            <a href="{{route('discussion.index')}}" class="top-menu">
                                <div class="top-menu__icon"><i data-feather="home"></i></div>
                                <div class="top-menu__title"> Discussions</div>
                            </a>
                        </li>

                        <li class="bg-login rounded-xl intro-x">
                            <a href="javascript:;" class="top-menu" style="color: white!important;">
                                <div class="top-menu__icon"><i data-feather="hard-drive"></i></div>
                                <div class="top-menu__title"> Ο λογαριασμος μου <i data-feather="chevron-down"
                                                                                   class="top-menu__sub-icon"></i></div>
                            </a>
                            <ul class="py-2 mt-6">
                                <li class="orange-line">
                                    <a href="{{route('index.account',auth()->user()->slug)}}" class="top-menu">
                                        <div class="top-menu__icon"><i data-feather="user"></i></div>
                                        <div class="top-menu__title"> My account</div>
                                    </a>
                                </li>
                                {{--                                <li  class="orange-line">--}}
                                {{--                                    <a href="top-menu-light-slider.html" class="top-menu">--}}
                                {{--                                        <div class="top-menu__icon"> <i data-feather="activity"></i> </div>--}}
                                {{--                                        <div class="top-menu__title"> Slider </div>--}}
                                {{--                                    </a>--}}
                                {{--                                </li>--}}
                                <li id="logout-btn" class="orange-line">
                                    <a href="top-menu-light-image-zoom.html" class="top-menu">
                                        <div class="top-menu__icon"><i data-feather="log-out"></i></div>
                                        <div class="top-menu__title"> Έξοδος</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- END: Top Menu -->
            </div>
        </div>
        <!-- BEGIN: Mobile Menu -->
        <div class="mobile-menu md:hidden">
            <div class="mobile-menu-bar">
                <a href="" class="flex mr-auto"></a>
                <a href="#" id="mobile-menu-toggler" class="absolute right-8 top-12">
                    <i data-feather="bar-chart-2"
                       class="w-8 h-8 text-black transform -rotate-90"></i>
                </a>
            </div>
            <ul class="burger-menu py-5 hidden">
                @hasanyrole("admin|super-admin")
                <li>
                    <a href="{{route('dashboard')}}" class="menu">
                        <div class="menu__icon"><i data-feather="home"></i></div>
                        <div class="menu__title"> Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href="{{route('dashboard')}}" class="menu">
                        <div class="menu__icon"><i data-feather="home"></i></div>
                        <div class="menu__title"> edit this course</div>
                    </a>
                </li>
                <li>
                    <a href="{{route('dashboard')}}" class="menu">
                        <div class="menu__icon"><i data-feather="home"></i></div>
                        <div class="menu__title"> Edit this material</div>
                    </a>
                </li>
                @endhasanyrole

                <li>
                    <a href="{{route('dashboard')}}" class="menu">
                        <div class="menu__icon"><i data-feather="home"></i></div>
                        <div class="menu__title"> Discussions</div>
                    </a>
                </li>

                <li>
                    <a href="javascript:;" class="menu">
                        <div class="menu__icon"><i data-feather="box"></i></div>
                        <div class="menu__title"> Ο λογαριασμος μου <i data-feather="chevron-down"
                                                                       class="menu__sub-icon"></i></div>
                    </a>
                    <ul class="">
                        <li>
                            <a href="index.html" class="menu">
                                <div class="menu__icon"><i data-feather="activity"></i></div>
                                <div class="menu__title"> Side Menu</div>
                            </a>
                        </li>
                        <li>
                            <a href="simple-menu-light-dashboard.html" class="menu">
                                <div class="menu__icon"><i data-feather="activity"></i></div>
                                <div class="menu__title"> Simple Menu</div>
                            </a>
                        </li>
                        <li id="logout-btn">
                            <a href="top-menu-light-dashboard.html" class="menu">
                                <div class="menu__icon"><i data-feather="activity"></i></div>
                                <div class="menu__title"> Έξοδος</div>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
        <!-- END: Mobile Menu -->
    </header>


    <main class="my-7 mb-20 flex-grow mx-5 xl:mx-0">

        @yield("content")

    </main>


    <footer class="bg-white py-4 lg:px-16  px-8"
            style=";  box-shadow: -1px 1px 6px 0px rgba(0,0,0,0.75);">

        <div class="container mx-auto max-w-1xl flex items-center flex-wrap justify-between">
            <div class="mr-7">
                <a href="#" class="text-xl">
                    <img class="" src="{{ $options->logo }}" alt="{{ $options->title }}" height="80">
                </a>
            </div>
            <div class="flex-1">
                <p class="text-base font-semibold">{{ $options->contactInfo->city }}</p>
                <p>{{ $options->contactInfo->address }}, {{ $options->contactInfo->zipCode }}</p>
                <p>{{ $options->contactInfo->email }}</p>
                <p>{{ $options->contactInfo->phone }}, {{ $options->contactInfo->fax }}</p>
            </div>
            <div class="w-full my-3 sm:my-0 sm:w-auto">
                <ul class="flex space-x-3">
                    @foreach($options->social as $social => $link)
                        <li>
                            <a href="{{ $link }}">
                                <img src="{{ asset("images/$social.png" )}}" alt="{{ $social}}" height="30">
                            </a>
                        </li>
                    @endforeach
                </ul>
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
{{--<script src="{{ mix('js/app.js') }}"></script>--}}
<script src="{{ mix('js/index/theme.js') }}"></script>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>


@yield("script")

</body>
</html>
