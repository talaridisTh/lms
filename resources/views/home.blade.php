@extends('layouts.app')

<style>
    .crop-height {
        /* max-width: 1200px; /* native or declared width of img src (if known) */
        max-height: 250px;
        overflow: hidden;
    }

    img.scale {
        /* corrects small inline gap at bottom of containing div */
        display: block;
        width: 100%; /* corrects obscure Firefox bug */
        max-width: 100%;
        /* just in case, to force correct aspect ratio */
        height: auto !important;
        display: block; /* corrects small inline gap at bottom of containing div */
        width: 100%;
        max-width: 100%;

        height: auto !important;

        -ms-interpolation-mode: bicubic;
    }

</style>
@section('content')
    <div class="container-fluid mb-5" style="max-width: 1400px">
        {{--row 1 --}}
        <div class="row mt-5">

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
                        style=" background: url('{{asset('images/group-33.png')}}'); background-position: right; "
                        class="img-custom-index img-fluid" src="{{asset('images/vector-smart-object.png')}}"
                        alt="vector-smart-object">
                </div>
            </div>

        </div>
        {{--row 2 --}}
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
        {{--row 3 --}}
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
        {{--row 4 --}}
        <div class="row mt-9">

            <div class="col-lg-5 d-none d-lg-block ">
                <div class="container  text-center  d-flex justify-content-center"
                     style=" background: url('{{asset('images/group-32.png')}}'); background-position: right;background-repeat: no-repeat; ">
                    <div class="container-oval-2 position-relative">
                        <div class="oval "></div>
                        <div class="oval-2 position-absolute"></div>
                        <div class="oval-3 position-absolute"></div>
                    </div>
                    |


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
        {{--row 5 --}}
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
                {{--row 6 --}}
        @isset($arrayBanners)
        @if($arrayBanners["primary"]->status==1)
            <div class="row" style="margin-top: 9rem">
                <h5 class="h5-custom w-100 text-center">Lorem ipsum dolor sit amet, consectetur</h5>
                <div class="d-flex flex-wrap mt-3">

                    @foreach($bannersPrimary as $key => $banner)

                        @php
                            $bannerArray = (array) $banner;
                            $bannerValue = key ( $bannerArray);
                            $bannerKey =array_values ($bannerArray);
                            $model =   $bannerValue::findOrFail($bannerKey)->first();
                        @endphp

                        <div class="col-md-6 col-lg-4">
                            <!-- Simple card -->
                            <div class="card card-shadow d-block" style="height: 50vh">
                                <div class="crop-height">
                                    <img class="card-img-top  scale"  src="{{$model->cover}}"
                                         alt="Card image cap">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title blue-title d-flex flex-column"><span>{{$model->title}}</span>
                                        Το πρώτο μου Ρομπότ</h5>
                                    <p class="card-text span-custom ">
                                        {!! Str::limit( $model->description , 300, ' (...)')!!}

                                    </p>

                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div>

                    @endforeach


                </div>

            </div>
        @endif
        {{--row 7 --}}

        @if($arrayBanners["secondary"]->status==1)
            <div class="row" style="margin-top: 9rem">
                <h5 class="h5-custom w-100 text-center">Lorem ipsum dolor sit amet, consectetur</h5>
                <div class="d-flex flex-wrap mt-3">
                    @foreach($bannersSecondary as $key => $banner)

                        @php
                            $bannerArray = (array) $banner;
                            $bannerValue = key ( $bannerArray);
                            $bannerKey =array_values ($bannerArray);
                            $model =   $bannerValue::findOrFail($bannerKey)->first();
                        @endphp

                        <div class="col-md-6 col-lg-4">
                            <!-- Simple card -->
                            <div class="card card-shadow d-block" style="height: 50vh">
                                <div class="crop-height">
                                    <img class="card-img-top  scale"  src="{{$model->cover}}"
                                         alt="Card image cap">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title blue-title d-flex flex-column">
                                        <span>{{$model->title}}</span> Το
                                        πρώτο μου Ρομπότ</h5>
                                    <p class="card-text span-custom">
                                        {!! Str::limit( $model->description , 300, ' (...)')!!}

                                    </p>

                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div>

                    @endforeach

                </div>

            </div>
        @endif
        @endisset

    </div>
@endsection
