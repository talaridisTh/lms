@extends("layouts.app")

@section("content")
    <article class="mdc:container mx-auto flex flex-col spa-cnt-material">

        <section class="flex justify-between mb-7 items-center">
            <h2 class="text-4xl ">{{$material->title}}</h2>
            <div class="flex space-x-2">
                <i class="mdi text-xl  mdi-window-maximize js-open-fullscreen cursor-pointer"></i>
                <i class="mdi text-xl  mdi-close-box-multiple js-close-fullscreen cursor-pointer"></i>
            </div>
        </section>

        <figure>
            @if($material->video_link)
                <div class="relative block h-0 p-0 overflow-hidden" style="padding-top:56.25%;">
                    <iframe class="absolute top-0 left-0 bottom-0 w-full h-full"
                            src="https://player.vimeo.com/video/{{$material->video_link}}"
                            frameborder="0"
                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                </div>

            @elseif($material->type=="PDF")
                @php
                    $pdf = $material->media()->wherePivot("usage", 4)->with("mediaDetails")->first();

                @endphp
                <embed id="pdf-embed" src="{{ $pdf->rel_path }}" type="application/pdf" width="100%"
                       height="100%" style="height: 100vh"/>
            @else
            @endif
        </figure>

        <x-index.section-tabs
            :curator=$curator
            :fields="$fields"
            :model="$material"
        >
        </x-index.section-tabs>

    </article>
@endsection
@section("script")
    <script src="{{ mix('js/index/courses/indexCourses.js') }}"></script>



@endsection
