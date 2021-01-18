<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="route" content="{{\Request::route()->getName()}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="noindex, nofollow">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">

    <link rel="stylesheet"
          href="node_modules/@splidejs/splide/dist/css/splide.min.css">

    <link rel="stylesheet"
          href="{{ mix('css/index/temp.css') }}">
    {{--    <link href="{{ mix('css/index/theme.css') }}"--}}
    {{--          rel="stylesheet">--}}


    @yield("style")


</head>

<body class="loading"
      data-layout="detached"
      data-layout-config='{"leftSidebarCondensed":false,"darkMode":true, "showRightSidebarOnStart": true}'>

<!-- Topbar Start -->

<div id="wrapper-custom">

@include("components.index.header",['logo'=>""])

<!-- Begin page -->
    <div id="content-custom"
         style="min-height: 73vh;">
        @yield('content')
    </div>


</div>
<form id="logout-form"
      action="{{ route('logout') }}"
      method="POST">
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

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css"/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>


@yield("script")


</body>
</html>
