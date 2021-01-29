@extends("layouts.app")

@section("content")


    <article class="mdc:container lg:container mx-auto flex-col flex flex-wrap mt-7">
        <h1 class="font-semibold text-4xl text-gray-600 mb-8 ">{{$material->title}}</h1>
        @if($material->video_link)
            <div class="embed-responsive aspect-ratio-16/9">
                <iframe class="embed-responsive-item"
                        src="https://player.vimeo.com/video/{{$material->video_link}}">
                </iframe>
            </div>

        @elseif($material->type=="PDF")
            @php
                $pdf = $material->media()->wherePivot("usage", 4)->with("mediaDetails")->first();

            @endphp
            @isset($pdf->rel_path)
                <embed id="pdf-embed"
                       src="{{ $pdf->rel_path }}"
                       type="application/pdf"
                       width="100%"
                       height="100%"
                       style="height: 100vh"/>
            @else
                <p>Δεν υπάρχει PDF</p>
            @endisset
        @else
        @endif


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
