@extends('layouts.app')
<style>

    .count-number {
        font-weight: bold;
        line-height: 80px;
        text-align: center;
        font-size: 60px;
        font-weight: 700;
    }

    .line {
        border-bottom: chocolate 3px solid;
        margin: auto;
    }

    .splide__slide img {
        width: 100%;
        height: auto;
    }


</style>


@section('content')
    <div class="container-fluid mb-5" style="max-width: 1400px">
        {{--row 1 --}}
        <div class="row ">
            <div class="col-lg-5 col-md-7 d-flex flex-column text-center text-sm-left justify-content-center">
                <h2 class="h2-custom">Βάλτε τωρα τη Ρομποτική στο σχολείο σας</h2>
                <div class="d-flex flex-column span-custom mb-3">
                    <span class="mb-1">Ολοκληρωμένα μαθήματα Ρομποτικής, STEM και προγραμματισμού για παιδιά.</span>
                    <span>Μπες στο δίκτυο συνεργατών. Δες τι προσφέρουμε και πως μπορείς να ξεκινήσεις.</span>

                </div>
                <button class="btn-custom btn btn-info btn-lg text-light  ">
                    <span>ΑΙΤΗΜΑ ΓΙΑ DEMO</span>
                </button>
            </div>

            <div class="col-lg-7 col-md-5  d-none d-md-block">
                <div class="container text-center">
                    <img
                        style=" background: url('{{asset('images/group-33.png')}}'); background-position: right; height: 650px "
                        class="img-custom-index img-fluid" src="{{asset('images/vector-smart-object.png')}}"
                        alt="vector-smart-object">
                </div>
            </div>

        </div>

        @if($chart["courses"] >0 && $chart["material"]>0 && $chart["user"]>0 )
            {{--row 2 --}}
{{--            <div class="row justify-content-center  mt-3">--}}
{{--                <div class="col-md-3 text-center mr-5">--}}
{{--                    <div class="count-number-1 count-number" data-start="0" data-end="{{$chart["courses"]}}"></div>--}}
{{--                    <div class="line w-50 text-center"></div>--}}
{{--                    <h3>Courses</h3>--}}
{{--                </div>--}}
{{--                <div class="col-md-3 text-center mr-5">--}}
{{--                    <div class="count-number-2 count-number" data-start="0" data-end="{{$chart["material"]}}"></div>--}}
{{--                    <div class="line w-50 text-center"></div>--}}
{{--                    <h3>Μαθήματα</h3>--}}
{{--                </div>--}}
{{--                <div class="col-md-3 text-center">--}}
{{--                    <div class="count-number-3 count-number" data-start="0" data-end="{{$chart["user"]}}"></div>--}}
{{--                    <div class="line w-50 text-center"></div>--}}
{{--                    <h3>Καθηγητές </h3>--}}
{{--                </div>--}}


{{--            </div>--}}
        @endif
        {{--row 3 --}}
        <div class="row my-5 ">

            <div class="col-lg-5 col-md-12 mt-4">
                <h3 class="h3-custom">Θέλεις να βάλεις τη Ρομποτική στο σχολείο σου και δεν ξέρεις από που να
                    ξεκινήσεις;</h3>
                <p class="p-custom">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas varius tortor nibh, sit amet
                    tempor
                    nibh finibus et. Aenean eu enim justo. Vestibulum aliquam hendrerit molestie.
                </p>
            </div>

            <div class="col-lg-7 col-md-12  ">
                <div class="container text-center">
                    <img
                        class="img-custom-index img-fluid" src="{{asset('images/group-5.png')}}"
                        alt="vector-5">
                </div>
            </div>

        </div>
        {{--row 4 --}}
        <div class="row mt-9">

            <div class="col-lg-5 mt-5">
                <h4 style="" class="h4-custom">Εξατομικευμένη πλατφόρμα μαθημάτων ρομποτικής</h4>
                <p class="p-custom">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas varius tortor nibh,
                    sit amet tempor nibh finibus et. Aenean eu enim justo. Vestibulum aliquam hendrerit molestie.
                </p>
                <ul class="ul-custom">
                    <li class="li-custom"> HD Videos στα Ελληνικά</li>
                    <li class="li-custom">Πίστες για τα ρομπότ, αρχεία κατασκευής</li>
                    <li class="li-custom">Kώδικα προγραμματισμού των ρομπότ</li>
                    <li class="li-custom"> Αρχεία κατασκευής για τους μαθητές μέσα από την πλατφόρμα.</li>
                </ul>
            </div>

            <div class="offset-2 col-lg-5  d-none d-lg-block">
                <div class="container  text-center  d-flex justify-content-center"
                     style=" background: url('{{asset('images/group-32.png')}}'); background-position: right;background-repeat: no-repeat; ">
                    <div class="container-oval   position-relative">
                        <div class="oval "></div>
                        <div class="oval-1 position-absolute"></div>
                        <div class="oval-2 position-absolute"></div>
                        <div class="oval-3 position-absolute"></div>
                    </div>
                </div>
            </div>

        </div>
        {{--row 5 --}}
        <div class="row mt-9">

            <div class="col-lg-5 d-none d-lg-block ">
                <div class="container  text-center  d-flex justify-content-center"
                     style=" background: url('{{asset('images/group-32.png')}}'); background-position: right;background-repeat: no-repeat; ">
                    <div class="container-oval-2 position-relative">
                        <div class="oval "></div>
                        <div class="oval-2 position-absolute"></div>
                        <div class="oval-3 position-absolute"></div>
                    </div>
                </div>
            </div>

            <div class="offset-lg-2  col-lg-5 d-flex flex-column justify-content-center">
                <h4 style="" class="h4-custom">Εκπαίδευση προσωπικού</h4>
                <p class="p-custom">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas varius tortor nibh,
                    sit amet tempor nibh finibus et. Aenean eu enim justo. Vestibulum aliquam hendrerit molestie.
                </p>
                <ul class="ul-custom">
                    <li class="li-custom">Hands on Μαθήματα (και με φυσική παρουσία και εξ αποστάσεως)</li>
                    <li class="li-custom"> Εκπαιδευτικό υλικό</li>
                    <li class="li-custom"> Απόκτηση πιστοποίησης</li>
                    <li class="li-custom"> Εκπαιδευτή ρομποτικής</li>
                </ul>
            </div>


        </div>
        {{--row 6 --}}
        <div class="row  mt-9">

            <div class="col-lg-5  mt d-flex flex-column justify-content-center">
                <h4 style="" class="h4-custom">Υποστήριξη των συνεργαζόμενων κέντρων κατά τη διάρκεια της χρονιάς</h4>
                <p class="p-custom">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas varius tortor nibh,
                    sit amet tempor nibh finibus et. Aenean eu enim justo. Vestibulum aliquam hendrerit molestie.
                </p>
            </div>

            <div class="offset-2 col-lg-5   d-none d-lg-block ">
                <div class="container  text-center  d-flex justify-content-center"
                     style=" background: url('{{asset('images/group-32.png')}}'); background-position: right;background-repeat: no-repeat; ">
                    <div class="container-oval-3   position-relative">
                        <div class="oval "></div>
                        <div class="oval-2 position-absolute"></div>
                    </div>
                </div>
            </div>

        </div>

        {{--       AUTA EDW THA ALLAKSOUN -}}
                {{--row 7 --}}
{{--        <div>--}}
{{--            @if($arrayBanners["primary"]->status==1)--}}
{{--                <div id="card-slider-primary" class="splide">--}}
{{--                    <div class="splide__track">--}}
{{--                        <ul class="splide__list">--}}
{{--                            @foreach($bannersPrimary as $key => $banner)--}}
{{--                                @php--}}
{{--                                    $bannerArray = (array) $banner;--}}
{{--                                    $bannerValue = key ( $bannerArray);--}}
{{--                                    $bannerKey =array_values ($bannerArray);--}}
{{--                                    $model =   $bannerValue::findOrFail($bannerKey)->first();--}}
{{--                                    $bannerClass = $model->cover ==null?' d-flex flex-column justify-content-center': ''--}}
{{--                                @endphp--}}
{{--                                <li class="splide__slide p-2">--}}
{{--                                    <img class="" src="{{$model->cardMediumUrl() }}" alt="Card image cap">--}}
{{--                                    <h2 class="p-3 pb-0 mb-0">{{$model->title}}</h2>--}}
{{--                                    <p class="p-3"> {{$model->subtitle}}</p>--}}
{{--                                </li>--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--            --}}{{--row 7 --}}
{{--        </div>--}}
{{--        <div>--}}
{{--            @if($arrayBanners["secondary"]->status==1)--}}
{{--                <div id="card-slider-secondary" class="splide">--}}
{{--                    <div class="splide__track">--}}
{{--                        <ul class="splide__list">--}}
{{--                            @foreach($bannersSecondary as $key => $banner)--}}
{{--                                @php--}}
{{--                                    $bannerArray = (array) $banner;--}}
{{--                                    $bannerValue = key ( $bannerArray);--}}
{{--                                    $bannerKey =array_values ($bannerArray);--}}
{{--                                    $model =   $bannerValue::findOrFail($bannerKey)->first();--}}
{{--                                    $bannerClass = $model->cover ==null?' d-flex flex-column justify-content-center': ''--}}
{{--                                @endphp--}}
{{--                                <li class="splide__slide p-2">--}}
{{--                                    <img class="" src="{{$model->cardMediumUrl() }}" alt="Card image cap">--}}
{{--                                    <h2 class="p-3 pb-0 mb-0">{{$model->title}}</h2>--}}
{{--                                    <p class="p-3"> {{$model->subtitle}}</p>--}}
{{--                                </li>--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--            --}}{{--row 7 --}}
{{--        </div>--}}

    </div>
@endsection

@section("script")

    <script src="{{ mix('js/index/index.js') }}"></script>
@endsection
