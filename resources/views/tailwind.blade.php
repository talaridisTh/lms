<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    {{--    <title>{{$option["title"]}}</title>--}}
    <meta name="route" content="{{\Request::route()->getName()}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{--    <meta content="{{$option["description"]}}" name="description"/>--}}
<!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />

    {{--    <link rel="stylesheet" href="{{ mix('css/index/app.css') }}">--}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
    <link rel="stylesheet" href="node_modules/@splidejs/splide/dist/css/splide.min.css">

    @yield("style")

</head>
<body class="bg-gray-100 antialiased font-sans">

<div id="app">
    <header class="lg:px-16  px-8 bg-white py-4 shadow-md 	">
        <div class="container mx-auto flex flex-wrap items-center">
            <div class="flex-1 flex justify-between items-center">
                <a href="#" class="text-xl">demo</a>
            </div>

            <label for="menu-toggle" class="pointer-cursor md:hidden block">
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
                            <a class="md:p-4 py-3 px-0 block text-sm font-medium uppercase " href="#">edit this
                                course</a>
                            <a class="md:p-4 py-3 px-0 block text-sm font-medium uppercase " href="#">edit this
                                material</a>
                        @endif
                        <a class="md:p-4 py-3 px-0 block text-sm font-medium uppercase " href="{{route('dashboard')}}">dashboard</a>
                        @endrole
                        <a class="md:p-4 py-3 px-0 block text-sm font-medium uppercase " href="">μαθηματα</a>
                        <a class="md:p-4 py-3 px-0 block md:mb-0 mb-2 bg-  bg font-medium uppercase " href="#">discussions</a>
                        <a class="bg-login transition duration-500 ease-in-out text-white rounded-full hover:bg-color-theme  md:p-4 py-3 px-0 block md:mb-0 mb-2 text-sm font-medium uppercase "
                           href="#">ο λογαριασμος μου</a>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <main class="my-10 space-y-20">


        <div class="sm:container xs:container-lg mx-auto flex justify-between space-x-10 p-8">
            <div class="flex-1  space-y-6 mt-16">
                <h2 class="md:text-6xl xs:text-4xl sm:text-left xs:text-center font-semibold sm:text-left xs:text-center ">
                    Βάλτε τωρα τη ρομποτική στο σχολείο σας</h2>
                <p class="md:text-2xl xs:text-xl sm:text-left xs:text-center">Ολοκληρωμένα μαθήματα Ρομποτικής, STEM και
                    προγραμματισμού για παιδιά. Μπες στο δίκτυο συνεργατών.
                    Δες τι προσφέρουμε και πως μπορείς να ξεκινήσεις.</p>
                <div class="flex sm:justify-start xs:justify-center">
                    <button
                        class="inline-block uppercase w-50 px-8 py-2 text-xs font-medium leading-6 text-center text-white uppercase
                     transition bg-login rounded-xl shadow ripple hover:shadow-lg hover:bg-blue-800 focus:outline-none">
                        ΑΙΤΗΜΑ ΓΙΑ DEMO
                    </button>
                </div>
            </div>
            <div class="flex-1 lg:flex xs:hidden  justify-center">
                <img
                    style=" background: url('{{asset('images/group-33.png')}}'); background-position: right; height: 650px "
                    class="img-custom-index img-fluid" src="{{asset('images/vector-smart-object.png')}}"
                    alt="vector-smart-object"></div>
        </div>

        <div class="sm:container xs:container-lg mx-auto flex justify-between  space-x-10 p-8">
            <div class="flex-1  space-y-6 mt-3">
                <h2 class="md:text-4xl xs:text-4xl sm:text-left xs:text-center font-semibold sm:text-left xs:text-center ">
                    Θέλεις να βάλεις τη Ρομποτική στο σχολείο σου και δεν ξέρεις από που να ξεκινήσεις;</h2>
                <p class="md:text-2xl xs:text-xl sm:text-left xs:text-center">Θέλεις να βάλεις τη Ρομποτική στο σχολείο
                    σου και δεν ξέρεις από που να ξεκινήσεις;</p>

            </div>
            <div class="flex-1 lg:flex xs:hidden  justify-center">
                <img
                    class="img-custom-index img-fluid" src="{{asset('images/group-5.png')}}"
                    alt="vector-5">
            </div>
        </div>

        <div class="sm:container xs:container-lg mx-auto flex justify-between items-center  space-x-10 p-8">
            <div class="flex-1  space-y-6 mt-3">
                <h2 class="md:text-4xl xs:text-4xl sm:text-left xs:text-center font-semibold sm:text-left xs:text-center ">
                    Εξατομικευμένη πλατφόρμα μαθημάτων ρομποτικής</h2>
                <p class="md:text-2xl xs:text-xl sm:text-left xs:text-center">Lorem ipsum dolor sit amet, consectetur
                    adipiscing elit. Maecenas varius tortor nibh, sit amet tempor nibh finibus et. Aenean eu enim justo.
                    Vestibulum aliquam hendrerit molestie</p>

                <ul class="list-inside list-disc space-y-2 ">
                    <li>HD Videos στα Ελληνικά</li>
                    <li>Πίστες για τα ρομπότ, αρχεία κατασκευής</li>
                    <li>Πίστες για τα ρομπότ, αρχεία κατασκευής</li>
                    <li>Πίστες για τα ρομπότ, αρχεία κατασκευής</li>
                </ul>
            </div>
            <div class="flex-1 lg:flex xs:hidden  justify-center"
                 style=" background: url('{{asset('images/group-32.png')}}'); background-position: center;background-repeat: no-repeat; ">
                <div class="container-oval   relative">
                    <div class="oval "></div>
                    <div class="oval-1 absolute"></div>
                    <div class="oval-2 absolute"></div>
                    <div class="oval-3 absolute"></div>
                </div>
            </div>
        </div>

        <div class="sm:container xs:container-lg mx-auto flex justify-between  items-center space-x-10 p-8">
            <div class="flex-1 lg:flex xs:hidden  justify-center"
                 style=" background: url('{{asset('images/group-32.png')}}'); background-position: center;background-repeat: no-repeat; ">
                <div class="container-oval mr-16  relative">
                    <div class="oval "></div>
                    <div class="oval-1 absolute"></div>
                    <div class="oval-2 absolute"></div>
                    <div class="oval-3 absolute"></div>
                </div>
            </div>

            <div class="flex-1  space-y-6 mt-3">
                <h2 class="md:text-4xl xs:text-4xl sm:text-left xs:text-center font-semibold sm:text-left xs:text-center ">
                    Εκπαίδευση προσωπικού
                </h2>
                <p class="md:text-2xl xs:text-xl sm:text-left xs:text-center">Lorem ipsum dolor sit amet, consectetur
                    adipiscing elit. Maecenas varius tortor nibh, sit amet tempor nibh finibus et. Aenean eu enim justo.
                    Vestibulum aliquam hendrerit molestie.</p>

                <ul class="list-inside list-disc space-y-2 ">
                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas varius tortor nibh, sit amet
                        tempor nibh finibus et. Aenean eu enim justo. Vestibulum aliquam hendrerit molestie.
                    </li>
                    <li>Εκπαιδευτικό υλικό</li>
                    <li>Εκπαιδευτικό υλικό</li>
                    <li>Εκπαιδευτή ρομποτικής</li>
                </ul>
            </div>
        </div>

        <div class="sm:container xs:container-lg mx-auto flex justify-between  items-center space-x-10 p-8">
            <div class="flex-1  space-y-6 mt-3">
                <h2 class="md:text-4xl xs:text-4xl sm:text-left xs:text-center font-semibold sm:text-left xs:text-center ">
                    Υποστήριξη των συνεργαζόμενων κέντρων κατά τη διάρκεια της χρονιάς
                </h2>
                <p class="md:text-2xl xs:text-xl sm:text-left xs:text-center">Υποστήριξη των συνεργαζόμενων κέντρων κατά τη διάρκεια της χρονιάς
                </p>
            </div>
            <div class="flex-1 lg:flex xs:hidden  justify-center"
                 style=" background: url('{{asset('images/group-32.png')}}'); background-position: center;background-repeat: no-repeat; ">
                <div class="container-oval   relative">
                    <div class="oval "></div>
                    <div class="oval-1 absolute"></div>
                    <div class="oval-2 absolute"></div>
                    <div class="oval-3 absolute"></div>
                </div>
            </div>
        </div>

{{--        <div class="sm:container xs:container-lg mx-auto  p-8">--}}

{{--            @foreach( $arrayBanners as  $key=>  $banners)--}}
{{--                <div id="card-slider-{{$key}}" class="splide">--}}
{{--                    @if($banners->status==1)--}}
{{--                        <div class="splide__track">--}}
{{--                            <ul class="splide__list">--}}
{{--                                @foreach($banners->models as $banner)--}}
{{--                                    @php--}}
{{--                                        $bannerValue = key ( $banner);--}}
{{--                                        $model =   $bannerValue::findOrFail($banner->$bannerValue);--}}
{{--                                    @endphp--}}
{{--                                    <li class="splide__slide p-2">--}}
{{--                                        <img class="" src="{{$model->cardMediumUrl() }}" alt="Card image cap">--}}
{{--                                        <h2 class="p-3 pb-0 mb-0">{{$model->title}}</h2>--}}
{{--                                        <p class="p-3"> {{$model->subtitle}}</p>--}}
{{--                                    </li>--}}
{{--                                @endforeach--}}
{{--                            </ul>--}}

{{--                        </div>--}}
{{--                    @endif--}}
{{--                </div>--}}

{{--            @endforeach--}}
{{--        </div>--}}


    </main>

    {{--    <footer class="absolute right-0 bottom-0 left-0 p-4  bg-white py-4 ">--}}
    {{--        <div class="container mx-auto flex items-center justify-between">--}}
    {{--            <div>dfsd</div>--}}
    {{--            <div>dfsd</div>--}}
    {{--        </div>--}}
    {{--    </footer>--}}

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
        console.log(this.href)
    })
</script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>


@yield("script")

</body>
</html>
