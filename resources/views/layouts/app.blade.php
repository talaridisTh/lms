<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="csrf-token"
          content="{{ csrf_token() }}"/>
    <meta name="route"
          content="{{\Request::route()->getName()}}">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <meta name="robots"
          content="noindex, nofollow">
    <meta content="{{ $options->description }}"
          name="description">


    <title>{{ $options->title }}</title>
    <!-- App favicon -->
    <link rel="shortcut icon"
          href="http://s2.googleusercontent.com/s2/favicons?domain_url=https://idrogios.com">

    <link href="{{ mix('css/index/theme.css') }}"
          rel="stylesheet">
    <link rel="stylesheet"
          href="node_modules/@splidejs/splide/dist/css/splide.min.css">


    @yield("style")

</head>
<body class="h-full  antialiased">

<div id="app"
     class=" flex flex-col h-screen relative"
     style="">

    @include("components.index.header",['logo'=>"logo"])

    <main class="my-7 mb-20 flex-grow mx-5">

        @yield("content")

    </main>


    <footer class="bg-white py-4 lg:px-16  px-8"
            style=";  box-shadow: -1px 1px 6px 0px rgba(0,0,0,0.75);">

        <div class="container mx-auto max-w-1xl flex items-center flex-wrap justify-between">
            <div class="flex">
                <div class="flex items-center mr-5">
                    <a href="#"
                       class="text-xl">
                        <img class=""
                             src="{{ $options->logo }}"
                             alt="{{ $options->title }}"
                             height="80">
                    </a>
                </div>
                <div class="flex-1">
                    <p class="text-base font-semibold">{{ $options->contactInfo->city }}</p>
                    <p>{{ $options->contactInfo->address }}, {{ $options->contactInfo->zipCode }}</p>
                    <p>{{ $options->contactInfo->email }}</p>
                    <p>{{ $options->contactInfo->phone }}, {{ $options->contactInfo->fax }}</p>
                </div>
            </div>
            <div class="w-full my-3 sm:my-0 sm:w-auto">
                <ul class="flex justify-center space-x-3">
                    @foreach($options->social as $social => $link)
                        <li>
                            <a href="{{ $link }}">
                                <img src="{{ asset("images/$social.png" )}}"
                                     alt="{{ $social}}"
                                     height="30">
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </footer>

</div>


<form id="logout-form"
      action="{{ route('logout') }}"
      method="POST">
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


<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>
@auth
    <script>

        @if($options->seen->seen_message>0)
        iziToast.show({
            class: "rounded-lg",
            timeout: 4000,
            zindex: 99999,
            title: '{{auth()->user()->first_name}}',
            position: 'topRight',
            theme: "dark",
            iconUrl: "/theme/images/message.png",
            message: 'Έχετε νέο μήνυμα'
        });
        @endif

        @if($options->seen->seen_message>0)
        iziToast.show({
            class: "rounded-lg",
            timeout: 4000,
            zindex: 99999,
            title: '{{auth()->user()->first_name}}',
            position: 'topRight',
            theme: "dark",
            iconUrl: "/theme/images/task.png",
            message: 'Έχετε νέα εργασία'
        });
        @endif


    </script>

@endauth

@yield("script")

</body>
</html>
