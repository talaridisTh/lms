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
                <li class="px-4 text-gray-80 bg-gray-200 font-semibold py-2 rounded-t {{$material->type!="PDF"? $fields->script==0?"hidden":"":""}}">
                    <a href="#quiz">Quiz</a>
                </li>
                <li class="px-4 text-gray-80 bg-gray-200 font-semibold py-2 rounded-t "><a
                        href="#disscussion">Συζήτηση</a>
                </li>
            </ul>

            <!-- Tab Contents -->
            <div id="tab-contents" class="ml-1 border-1 border-gray-200  px-10 pb-5">
                <div id="first" class=" hidden py-7 px-4">
                    <ul class="list-disc mb-2 list-inside">
                        <li class="font-bold">Πληροφορίες</li>
                    </ul>
                    {!! $material->description !!}
                </div>
                <div id="second" class="hidden py-7 px-4">
                    <ul class="list-disc mb-2 list-inside">
                        <li class="font-bold">Περίληψη</li>
                    </ul>
                    {!! $material->summary !!}
                </div>
                <div id="third" class="hidden py-7 px-4">
                    <ul class="list-disc mb-2 list-inside">
                        <li class="font-bold">Αρχεία</li>
                    </ul>
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
                </div>
                <figure id="fourth" class="hidden py-7 px-4 flex flex-wrap space-x-4">
                    <ul class="list-disc mb-2 list-inside w-full">
                        <li class="font-bold">Media</li>
                    </ul>
                    @foreach($material->media->where("type",0) as $file)
                        <a href="{{$file->rel_path}} " data-lightbox="image-1">
                            <img class="rounded-lg" src="{{$file->roundedMediumCoverUrl("rel_path")}}"
                                 alt="{{$file->name}}">
                        </a>
                    @endforeach
                </figure>
                <div id="quiz" class="hidden py-7 px-4">
                    <ul class="list-disc mb-2 list-inside ">
                        <li class="font-bold">Quiz</li>
                    </ul>
                    {!! $material->script !!}
                </div>
                <div id="disscussion" class="hidden py-7 px-4">
                    <ul class="list-disc mb-2 list-inside">
                        <li class="font-bold">Συζήτηση</li>
                    </ul>
                    Συζήτηση
                </div>
            </div>
        </section>

    </article>
@endsection
@section("script")
    <script src="{{ mix('js/index/courses/indexCourses.js') }}"></script>
    {{--    <script>--}}
    {{--        let tabsContainer = document.querySelector("#tabs");--}}

    {{--        let tabTogglers = tabsContainer.querySelectorAll("a");--}}

    {{--        tabTogglers.forEach(function (toggler) {--}}
    {{--            toggler.addEventListener("click", function (e) {--}}
    {{--                e.preventDefault();--}}

    {{--                let tabName = this.getAttribute("href");--}}

    {{--                let tabContents = document.querySelector("#tab-contents");--}}

    {{--                for (let i = 0; i < tabContents.children.length; i++) {--}}
    {{--                    tabTogglers[i].parentElement.classList.add("bg-gray-200");--}}
    {{--                    tabTogglers[i].parentElement.classList.remove("border-t", "border-r", "border-l", "-mb-px");--}}
    {{--                    tabContents.children[i].classList.remove("hidden");--}}
    {{--                    if ("#" + tabContents.children[i].id === tabName) {--}}
    {{--                        tabTogglers[i].parentElement.classList.add("bg-white");--}}
    {{--                        tabTogglers[i].parentElement.classList.remove("bg-gray-200");--}}
    {{--                        continue;--}}
    {{--                    }--}}
    {{--                    tabContents.children[i].classList.add("hidden");--}}

    {{--                }--}}
    {{--                e.target.parentElement.classList.add("border-t", "border-r", "border-l", "-mb-px", "bg-white");--}}
    {{--            });--}}
    {{--        });--}}

    {{--        $("#tabs").children().not(".hidden").first().children().first().attr("id", "default-tab")--}}

    {{--        document.getElementById("default-tab").click();--}}


    {{--        const button = document.querySelector('.modal-button')--}}
    {{--        button.addEventListener('click', toggleModal)--}}

    {{--        const overlay = document.querySelector('.modal-overlay')--}}
    {{--        overlay.addEventListener('click', toggleModal)--}}


    {{--    </script>--}}

@endsection
