{{-- Meta tags --}}
<meta name="viewport"
      content="width=device-width, initial-scale=1">
<meta name="route"
      content="{{ $route }}">
<meta name="csrf-token"
      content="{{ csrf_token() }}">
<meta name="url"
      content="{{ url('').'/'.config('chatify.path') }}"
      data-user="{{ Auth::user()->id }}">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>{{-- scripts --}}
<script src="{{ asset('js/chatify/font.awesome.min.js') }}"></script>
<script src="{{ asset('js/chatify/autosize.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src='https://unpkg.com/nprogress@0.2.0/nprogress.js'></script>

{{-- styles --}}
<link rel='stylesheet'
      href='https://unpkg.com/nprogress@0.2.0/nprogress.css'/>
<link href="{{ asset('css/chatify/style.css') }}"
      rel="stylesheet"/>
<link href="{{ asset('css/chatify/'.$dark_mode.'.mode.css') }}"
      rel="stylesheet"/>
<link href="{{ asset('css/app.css') }}"
      rel="stylesheet"/>
<link rel="preconnect"
      href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap"
      rel="stylesheet">

{{-- Messenger Color Style--}}
@include('Chatify::layouts.messengerColor')
