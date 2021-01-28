@extends("layouts.app")

@section("content")


    <article class="mdc:container lg:container mx-auto flex-col flex flex-wrap mt-7">


        <div class="embed-responsive aspect-ratio-16/9">
            <iframe class="embed-responsive-item"
                    src="https://www.youtube.com/embed/uOUXDipWeN8"></iframe>
        </div>


        {{--        <div id="responsiveVideoWrapper" class="   ">--}}
        {{--            <iframe--}}
        {{--                class=" top-0 left-0 w-full h-full"--}}
        {{--                src="https://www.youtube.com/embed/zihoyz0u_cs"--}}
        {{--                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"--}}
        {{--                allowFullScreen--}}
        {{--            ></iframe>--}}
        {{--        </div>--}}


        <div class="flex flex-wrap mt-7 ">


            <x-index.courses.section-tabs
                    :curator=$curator
                    :fields="$fields"
                    :model="$material"
            >
            </x-index.courses.section-tabs>

            <x-index.courses.section-materials
                    :course="$course"
                    :lessons="$lessons"
                    :isSectionExist="$isSectionExist"
                    :sections="$sections"
                    :countSection="$countSection"
            ></x-index.courses.section-materials>

        </div>
    </article>
@endsection


@section("script")
    <script src="{{ mix('js/index/materials/indexMaterials.js') }}"></script>
@endsection
