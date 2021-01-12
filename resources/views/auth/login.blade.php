<!DOCTYPE html>

<html lang="en" class="light">
<!-- BEGIN: Head -->
<head>
    <meta charset="utf-8"/>
    <title>ΥΔΡΟΓΕΙΟΣ EDUCATION</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="ΥΔΡΟΓΕΙΟΣ EDUCATION">

    <link rel="shortcut icon" href="http://s2.googleusercontent.com/s2/favicons?domain_url=https://idrogios.com">

    <title>ΥΔΡΟΓΕΙΟΣ EDUCATION</title>
    <!-- BEGIN: CSS Assets-->
    <link href="{{ mix('css/index/theme.css') }}" rel="stylesheet">
    <!-- END: CSS Assets-->

    <style>
        .login:before {
            background-image: url("{{asset('theme/images/wave5.svg')}}");
        }
    </style>
</head>
<!-- END: Head -->
<body class="login">
<div class="container mx-auto sm:px-10">
    <div class="block xl:grid grid-cols-2 gap-4">
        <!-- BEGIN: Login Info -->

        <div class="hidden xl:flex flex-col min-h-screen">
            <a href="" class="-intro-x flex items-center pt-5">
                <img class="logo" src="{{ $options->logo }}" alt="{{ $options->title }}" height="80">
            </a>
            <div class="my-auto z-10">
                <img alt="idrogios-cover" class="-intro-x w-1/2 -mt-16 "
                     src="{{asset("theme/images/illustration.svg")}}">
                <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                    Υδρόγειος Education
                    <br>
                    {{--                    Συνδεθείτε στο λογαριασμό σας.--}}
                </div>
                <div class="-intro-x mt-5 text-lg text-white dark:text-gray-500">
                    Συνδεθείτε στο λογαριασμό σας.

                </div>
            </div>
        </div>
        <!-- END: Login Info -->
        <!-- BEGIN: Login Form -->
        <form method="POST" class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0" action="{{ route('login') }}">

            @csrf

            <div
                class="my-auto  mx-auto xl:ml-20 bg-white xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                <div class="flex flex-col items-center">
                    <img class="intro-x" src="{{asset("theme/images/avatar.svg")}}" alt="">
                    <h2 class="intro-x mt-8 font-bold text-2xl xl:text-3xl text-center xl:text-left">
                        Συνδεθείτε
                    </h2>
                </div>
                <div class="intro-x mt-2 text-gray-500 xl:hidden text-center"> Υδρόγειος Education <br> Συνδεθείτε στο
                    λογαριασμό σας.
                </div>
                <div class="intro-x mt-8">
                    <input class="intro-x focus:border-theme-11 login__input input input--lg border border-gray-300 block @error("email") border-red-400 @enderror"
                           type="email" id="email" name="email" value="{{ old('email') }}" required=""
                           placeholder="Eισάγετε email">

                    <input
                        class="intro-x focus:border-theme-11  login__input input input--lg border border-gray-300 block mt-4 @error("password") border-red-400 @enderror"
                        type="password" name="password" required="" id="password" placeholder="Eισάγετε password">
                </div>
                @if (Route::has('password.request'))
                    <div class="intro-x flex text-gray-700 dark:text-gray-600 text-xs sm:text-sm mt-4">
                        <div class="flex items-center mr-auto">
                            <input type="checkbox" class="border mr-2" id="remember"
                                   name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="cursor-pointer select-none" for="remember">Μείνε συνδεδεμένος</label>
                        </div>
                        <a href="{{ route('password.request') }}">Ξεχάσατε τον κωδικό
                        </a>
                    </div>
                @endif
                <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                    <button class="button button--lg w-full xl:w-32 text-white bg-theme-6 xl:mr-3 align-top zoom-in">Σύνδεση
                    </button>
                    <button
                        class="button button--lg w-full zoom-in xl:w-32 text-gray-700 border border-gray-300 dark:border-dark-5 dark:text-gray-300 mt-3 xl:mt-0 align-top">
                        Eγγραφή
                    </button>
                </div>
                <div class="intro-x mt-10 xl:mt-24 text-gray-700 dark:text-gray-600 text-center xl:text-left">
                    Με την εγγραφή, αποδέχεστε μας

                    <br>
                    <a class="text-theme-1 dark:text-theme-10" href="">Όροι και προϋποθέσεις </a> & <a
                        class="text-theme-1 dark:text-theme-10" href="">Πολιτική απορρήτου</a>
                </div>
            </div>

        </form>

        <!-- END: Login Form -->
    </div>
</div>

<!-- BEGIN: JS Assets-->
<!-- bundle -->
<script src="/assets/js/vendor.min.js"></script>
<script src="/assets/js/app.min.js"></script>
<script src="{{ mix('js/index/theme.js') }}"></script>
<!-- END: JS Assets-->
</body>
</html>
