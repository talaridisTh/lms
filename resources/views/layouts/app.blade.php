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


    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/index/_icon.css') }}" rel="stylesheet">


    {{--    <link rel="stylesheet" href="{{ mix('css/index/app.css') }}">--}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
    <link rel="stylesheet" href="node_modules/@splidejs/splide/dist/css/splide.min.css">

{{--    <link rel="preconnect" href="https://fonts.gstatic.com">--}}
{{--    <link--}}
{{--        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400&display=swap"--}}
{{--        rel="stylesheet">--}}

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

<div id="app" class="flex flex-col min-h-screen" style="height: auto !important;">

    <header id="header" class="lg:px-16 z-50 sticky top-0 px-8 bg-white py-4 shadow-md" style="min-height: 50px">

        <div class="container mx-auto flex flex-wrap items-center px-1">
            <div class="flex-1 flex justify-between items-center">
                <a href="/tailwind" class="text-xl">
                    <img class="logo" src="{{ $options->logo }}" alt="{{ $options->title }}" height="80">
                </a>
            </div>
            <label for="menu-toggle" class="pointer-cursor md:hidden block menu-toggle">
                <svg class="fill-current text-gray-900"
                     xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                    <title>menu</title>
                    <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                </svg>
            </label>
            <input class="hidden" type="checkbox" id="menu-toggle"/>
            <div class="hidden md:flex md:items-center md:w-auto w-full" id="menu">
                <nav>
                    <div
                        class="md:flex items-center justify-between text-base text-gray-700 pt-4 md:pt-0 relative green borderXwidth">
                        @hasanyrole("admin|super-admin")
                        @if(\Request::route()->getName()== "index.userCourse")
                            <a class="md:p-4 py-3 px-0 block text-sm font-bold uppercase " href="#">edit this
                                course</a>
                            <a class="md:p-4 py-3 px-0 block text-sm font-bold uppercase " href="#">edit this
                                material</a>
                        @endif
                        <a class="md:p-4 py-3 px-0 block text-sm font-bold uppercase " href="{{route('dashboard')}}">dashboard</a>
                        @endrole
                        <a class="md:p-4 py-3 px-0 block text-sm font-bold uppercase "
                           href="{{route('index.userCourses',auth()->user()->id)}}">μαθηματα</a>
                        <a class="md:p-4 py-3 px-0 block md:mb-0 mb-2 text-sm  font-bold uppercase hidden " href="#">discussions</a>
                        <div class="login-cnt relative">
                            <a class="bg-login  transition duration-500 ease-in-out text-white rounded-full hover:bg-color-theme
                         md:p-4 py-3 px-0 block md:mb-0 mb-2 text-sm font-bold uppercase "
                               href="#">ο λογαριασμος μου
                            </a>
                            <div class="login-dropdown absolute left-2/4 hidden opacity-0 mt-2">
                                <ul class="absolute left-0 top-0  p-2 rounded-lg shadow-lg bg-white z-10 border  group-hover:block">
                                    {{--                                    <li class="hover:bg-gray-200 py-2 px-10">eisodos</li>--}}
                                    <li id="logout-btn" class="cursor-pointer hover:bg-gray-200 py-2 px-10 flex ">Έξοδος
                                        <i class=" ml-2 mdi mdi-logout"></i></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <div class="container mx-auto mt-5  hidden toggle-cnt-menu">
            <ul class="uppercase space-y-3 sm:hidden">
                <li class="hover:bg-gray-300 rounded-lg p-2">dashboard</li>
                <li class="hover:bg-gray-300 rounded-lg p-2">μαθηματα</li>
                <li class="hover:bg-gray-300 rounded-lg p-2">discussions</li>
                <li class="hover:bg-gray-300 rounded-lg p-2">ο λογαριασμος μου</li>
            </ul>
        </div>
    </header>

    <main class="my-7 mb-20 flex-grow">

        @yield("content")

    </main>



    <footer class="bg-white py-4 lg:px-16  px-8"
            style="min-height: 50px;  box-shadow: -1px 1px 6px 0px rgba(0,0,0,0.75);">

        <div class="container mx-auto flex items-center flex-wrap justify-between">
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
<script src="{{ mix('js/app.js') }}"></script>
<script>
    $('#logout-btn').click(function () {
        event.preventDefault();
        $('#logout-form').submit();
    })


    $(".edit-preview-page-course").on("click", function () {
        this.href = window.PREVIEW_PAGE_COURSE
    })

    window.onscroll = function () {
        scrollFunction()
    };

    function scrollFunction() {
        const $header = document.getElementById('header');
        if (!$header) {
            return;
        }
        if (document.body.scrollTop > 0 || document.documentElement.scrollTop > 0) {
            $('header').addClass('h-16 flex items-center').removeClass("py-4");
            $('.logo').addClass('h-11');
            $('.bg-login').first().addClass('md:p-3').removeClass("md:p-4");
            $(".login-dropdown").addClass("opacity-0 hidden")
        } else {
            $('header').removeClass('h-16 flex items-center').addClass("py-4");
            $('.logo').removeClass('h-11');
            $('.bg-login').first().removeClass('md:p-3').addClass("md:p-4");
        }
    }

    $(document).on('click', function (event) {
        if (!$(event.target).is('.bg-login')) {
            $(".login-dropdown").addClass("opacity-0 hidden")
        }
    });

    $(".login-cnt").on("click", function () {
        $(".login-dropdown").toggleClass("transition-all opacity-100").toggleClass("opacity-0 hidden")
    })

    $(".menu-toggle").on("click", function () {
        if ($(".toggle-cnt-menu").hasClass("hidden")) {
            $(".toggle-cnt-menu").removeClass("hidden");
        } else {
            $(".toggle-cnt-menu").addClass("hidden");
        }
    })
</script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>


@yield("script")

</body>
</html>
