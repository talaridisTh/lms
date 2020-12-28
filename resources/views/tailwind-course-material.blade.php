@extends("tailwind")

@section("content")
    <article class="container mx-auto flex flex-col spa-cnt-material">

        <figure>
            <h2 class="text-4xl mb-7">{{$material->title}}</h2>
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
                    $pdf = $material->media()->wherePivot("usage", 4)->with("mediaDetails")->first()
                @endphp
                <embed id="pdf-embed" src="{{ $pdf->rel_path }}" type="application/pdf" width="100%"
                       height="100%" style="height: 100vh"/>

            @else



            @endif

        </figure>
        <section class="rounded  mt-7">
            <!-- Tabs -->
            <ul id="tabs" class="inline-flex w-full border-b space-x-1">
                <li class="bg-white px-4 text-gray-80 bg-gray-200 font-semibold py-2 rounded-t border-t border-r border-l -mb-px {{$fields->description==0?"hidden":""}}">
                    <a href="#first">Πληροφορίες</a></li>
                <li class="px-4 text-gray-80 bg-gray-100 font-semibold py-2 rounded-t {{$fields->summary==0?"hidden":""}}">
                    <a
                        href="#second">Περίληψη</a></li>
                <li class="px-4 text-gray-80 bg-gray-200 font-semibold py-2 rounded-t {{$fields->file==0?"hidden":""}}">
                    <a href="#third">Αρχεία</a>
                </li>
                <li class="px-4 text-gray-80 bg-gray-200 font-semibold py-2 rounded-t {{$fields->media==0?"hidden":""}}">
                    <a href="#fourth">Media</a>
                </li>
                <li class="px-4 text-gray-80 bg-gray-200 font-semibold py-2 rounded-t {{$fields->script==0?"hidden":""}}">
                    <a href="#quiz">Quiz</a></li>
                <li class="px-4 text-gray-80 bg-gray-200 font-semibold py-2 rounded-t "><a href="#disscussion">Συζήτηση</a>
                </li>
            </ul>

            <!-- Tab Contents -->
            <div id="tab-contents" class="ml-1 border-1 border-gray-200">
                <div id="first" class=" hidden p-4">
                    {!! $material->description !!}
                </div>
                <div id="second" class="hidden p-4">
                    {!! $material->summary !!}
                </div>
                <div id="third" class="hidden p-4">
                    @foreach($material->media->where("type",1) as $file)
                        <div
                            class="text-gray-600 ml-2 flex w-1/2 items-center justify-between hover:bg-gray-400 rounded-lg hover:text-white cursor-pointer">
                            <a class=" p-2" href="{{$file->rel_path}}" target="_blank">
                                <span>{{$file->original_name}}.{{$file->ext}}</span>
                            </a>
                            <a href="{{$file->rel_path}}" download>
                                <i class="mdi-24px mdi mdi-cloud-download-outline mr-2"></i>
                            </a>
                        </div>
                    @endforeach
                    {{--                    {!! $material->media->where("type",1) !!}--}}
                </div>
                <div id="fourth" class="hidden p-4">
                    {!! $material->summary !!}
                </div>
                <div id="quiz" class="hidden p-4">
                    {!! $material->script !!}
                </div>
                <div id="disscussion" class="hidden p-4">
                    Συζήτηση
                </div>
            </div>
        </section>

    </article>
@endsection
