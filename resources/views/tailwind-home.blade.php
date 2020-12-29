@extends("tailwind")

@section("content")


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
            <p class="md:text-2xl xs:text-xl sm:text-left xs:text-center">Υποστήριξη των συνεργαζόμενων κέντρων κατά τη
                διάρκεια της χρονιάς
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

    <div class="sm:container xs:container-lg mx-auto space-y-20 p-8">

        @foreach( $arrayBanners as  $key=>  $banners)
            <div id="card-slider-{{$key}}" class="splide">
                @if($banners->status==1)
                    <div class="splide__track mx-3">
                        <ul class="splide__list">
                            @foreach($banners->models as $banner)
                                @php
                                    $bannerValue = key ( $banner);
                                    $model =   $bannerValue::findOrFail($banner->$bannerValue);
                                @endphp
                                <li class="splide__slide p-5 space-y-4  bg-gray-200 shadow-inner shadow-2xl">
                                    <img class="" src="{{$model->cardMediumUrl() }}" alt="Card image cap">
                                    <div class="space-y-4">
                                    <h2 class="text-lg font-semibold">{{$model->title}}</h2>
                                        <p class="font-normal text-base"> {{$model->subtitle}}</p>

                                    </div>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                @endif
            </div>

        @endforeach
    </div>


@endsection
@section("script")

    <script src="{{ mix('js/index/index.js') }}"></script>
@endsection
