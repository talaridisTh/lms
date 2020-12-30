@extends("layouts.app")

@section("content")

    <style>
        .avatar {
            border: solid 4px #00000017;
            border-left-color: transparent;
            padding: 2px;
            display: inline-block;
            border-radius: 50%;
            position: relative;


            transform: rotate(-88deg);
            -ms-transform: rotate(-88deg);
            -webkit-transform: rotate(-88deg);
        }

        .avatar img {
            display: block;
            border-radius: 50%;

            transform: rotate(+88deg);
            -ms-transform: rotate(+88deg);
            -webkit-transform: rotate(+88deg);
        }

        .avatar:before, .avatar:after {
            content: '';
            /*position:absolute;*/
            background: #fff;
            z-index: -1;

            transform: rotate(-45deg);
            -ms-transform: rotate(-45deg);
            -webkit-transform: rotate(-45deg);
        }

        .avatar:before {
            height: 4px;
            top: 50%;
            left: 2px;
            right: -5px;
            margin-top: -2px;
        }

        .avatar:after {
            width: 4px;
            left: 50%;
            top: 2px;
            bottom: -5px;
            margin-left: -2px;
        }

        .announcement li::before {
            content: "\2022"; /* Add content: \2022 is the CSS Code/unicode for a bullet */
            color: #ffffff94; /* Change the color */
            font-weight: bold; /* If you want it to be bold */
            display: inline-block; /* Needed to add space between the bullet and the text */
            width: 1em; /* Also needed for space (tweak if needed) */
        }

        .bullet:before {
            content: "\2022"; /* Add content: \2022 is the CSS Code/unicode for a bullet */
            color: black; /* Change the color */
            font-weight: bold; /* If you want it to be bold */
            display: inline-block; /* Needed to add space between the bullet and the text */
            width: 1em; /* Also needed for space (tweak if needed) */
            margin-left: -1em; /* Also needed for space (tweak if needed) */
        }

        .em-padding {
            padding-bottom: 0.2em;
            padding-top: 0.2em;
        }

        .modal {
            transition: opacity .7s ease;
        }
    </style>
    <article class="mdc:container lg:container mx-auto flex flex-col  pt-5 rounded-xl "
             style="background:linear-gradient(315deg, rgb(255, 78, 0) 0%, rgb(236, 133, 5) 75%)">
        <section class="flex xl:justify-between justify-around flex-wrap  px-8">
            <figure class="w-64 h-64  my-8 relative lg:mr-16">
                <div
                    class="group avatar w-full h-full rounded-full overflow-hidden shadow-inner text-center bg-purple table cursor-pointer border">
                    <img src="{{$course->cover}}"
                         class="p-3 rounded-full object-cover object-center w-full h-full visible group-hover:hidden"
                         alt="{{$course->title}}">
                </div>
            </figure>
            <section
                class="flex ml-0 lg:ml-10 xl:order-none w-full lg:order-last order-none xl:flex-1 my-8 space-y-8 p-4 pt-0 flex-col items-center lg:items-start text-white">
                {{--                {{dd($course->topics)}}--}}
                @if(count($course->topics)>0)
                    <h3 class="px-6 py-2 text-center border-1 border-white rounded-full">{{$course->topics->first()->title}}</h3>
                @endif
                <section class="flex flex-col w-full space-y-4">
                    <h2 class="sm:text-4xl text-center lg:text-left font-weight-semibold xl:w-4/5 text-2xl">{{$course->title}}</h2>
                    <p class="text-md sm:text-center lg:text-left font-weight-normal xl:w-3/5">{{\Str::limit($course->subtitle,150,"...")}}</p>
                </section>
            </section>
            <aside
                class="bg-opacity-10 w-full xl:w-1/4 lg:w-1/2 mt-1 bg-black rounded-xl mb-7 flex flex-col items-start">
                <ul class="bg-white px-4 mx-4 mt-6 mb-0 py-2 rounded-full ">
                    <li class="text-black font-semibold list-disc list-inside ">Τελευταίες Ανακοινώσεις</li>
                </ul>
                <ul class="my-6 h-full px-4 w-full space-y-4 announcement">
                    @forelse($announcements as $key =>$announcement)
                        <li class="text-black font-medium flex  ">
                            <span class="text-white font-medium flex-1 ">{{$announcement->title}}</span>
                            <span class="font-normal text-white">{{$announcement->created_at->format("d/m/Y")}}</span>
                        </li>

                        @if($loop->index ==3)
                            @break;
                        @endif

                    @empty
                        <li class="text-black font-medium flex  ">
                            <span class="text-white font-medium flex-1 ">Δεν υπάρχουν ανακοινώσεις</span>
                        </li>
                    @endforelse
                </ul>
                <div class="flex px-4 text-white py-3 justify-end bg-opacity-20 bg-black w-full rounded-b-xl">
                    <p class="font-light text-sm modal-button cursor-pointer">Όλες οι ανακοινώσεις <i
                            class="ml-2 dripicons-chevron-right "></i></p>
                </div>
            </aside>
        </section>
        <section class="flex lg:px-16 px-9 text-white py-4 justify-between lg:justify-start  lg:space-x-10
         bg-opacity-20 bg-black w-full rounded-b-xl">
            <p><i class="mdi mdi-book-open-page-variant mr-1"></i>{{$sumMaterial}} Μαθήματα</p>
            <p><i class="mdi mdi-book-open-page-variant mr-1"></i>{{count($course->media)}} Βοηθητικά αρχεία</p>
        </section>
    </article>

    <article class="mdc:container lg:container mx-auto flex flex-wrap mt-7">
        <div id="scrollTo"></div>
        <section class="w-full lg:w-7/10 spa-cnt">
            <section class="bg-gray-200 rounded-xl flex  space-x-6 p-8">
                <figure
                    class="group hidden  md:table w-32 h-32 rounded-full overflow-hidden text-center bg-purple table cursor-pointer ">
                    <img src="{{$curator->avatar}}"
                         class=" rounded-full object-cover object-center w-full h-full visible group-hover:hidden"
                         alt="avatar-curator">
                </figure>
                <section class="space-y-4">
                    <section class="flex justify-between">
                        <h5 class="ml-1"><span class="text-lg font-bold">Εισηγητής</span> <span
                                class="font-semibold">- {{$curator->fullname}}</span>
                        </h5>
                        <figure class="text-xl items-center space-x-3 flex hidden">
                            @if($curator->facebook_link)
                                <img src="{{asset("images/facebook-1.png")}}" alt="">
                            @endif
                            @if($curator->instagram_link)
                                <img src="{{asset("images/linked-in.png")}}" alt="">
                            @endif
                            @if($curator->linkedin_link)
                                <img src="{{asset("images/twitter-1.png")}}" alt="">
                            @endif
                            @if($curator->youtube_link)
                                <img src="{{asset("images/twitter-1.png")}}" alt="">
                            @endif
                        </figure>

                    </section>
                    <p class="w-11/12 ml-1">{!!$curator->profil!!} </p>
                </section>
            </section>
            <div class="rounded mx-auto mt-7">
                <!-- Tabs -->
                <ul id="tabs" class="inline-flex px-1 w-full border-b space-x-1">
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
                    <li class="px-4 text-gray-80 bg-gray-200 font-semibold py-2 rounded-t "><a
                            href="#disscussion">Συζήτηση</a>
                    </li>
                </ul>

                <!-- Tab Contents -->
                <div id="tab-contents" class="ml-1 border-1 border-gray-200 py-3 px-10">
                    <div id="first" class=" hidden py-7 px-4">
                        <ul class="list-disc mb-2 list-inside">
                            <li class="font-bold">Πληροφορίες</li>
                        </ul>
                        {!! $course->description !!}
                    </div>
                    <div id="second" class="hidden py-7 px-4 list-inside">
                        <ul class="list-disc mb-2 list-inside">
                            <li class="font-bold">Περίληψη</li>
                        </ul>
                        {!! $course->summary !!}
                    </div>
                    <div id="third" class="hidden py-7 px-4">
                        <ul class="list-disc mb-2 list-inside">
                            <li class="font-bold">Αρχεία</li>
                        </ul>
                        @foreach($course->media->where("type",1) as $file)
                            <div
                                class="text-gray-600 px-2 flex w-1/2 items-center justify-between hover:bg-gray-400 rounded-lg hover:text-white cursor-pointer">
                                <a class=" p-2" href="{{$file->rel_path}}" target="_blank">
                                    <span>{{$file->original_name}}.{{$file->ext}}</span>
                                </a>
                                <a href="{{$file->rel_path}}" download>
                                    <i class="mdi-24px mdi mdi-cloud-download-outline mr-1"></i>
                                </a>
                            </div>
                        @endforeach
                        {{--                    {!! $course->media->where("type",1) !!}--}}
                    </div>
                    <figure id="fourth" class="hidden py-7 px-4 flex flex-wrap space-x-4">
                        <ul class="list-disc mb-2 list-inside w-full">
                            <li class="font-bold">Media</li>
                        </ul>
                        @foreach($course->media->where("type",0) as $file)
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
                        {!! $course->script !!}
                    </div>
                    <div id="disscussion" class="py-7 px-4">
                        <ul class="list-disc mb-2 list-inside">
                            <li class="font-bold">Συζήτηση</li>
                        </ul>
                        Συζήτηση
                    </div>
                </div>
            </div>
        </section>
        <aside class="space-y-5 mt-5 lg:mt-0 w-full lg:w-3/10 spa-list-material lg:pl-10">
            @if($course->media->where("type",1)->count())
                <div class="row">
                    <div class="col">
                        <div class="tabs">
                            <div class="tab bg-gray-200 px-4 em-padding">
                                <input type="checkbox" id="extra-file">
                                <label class="tab-label text-black list-disc text-lg p-4" for="extra-file"><span
                                        class="bullet">Βοηθητικά αρχεία</span></label>
                                @foreach($course->media->where("type",1) as $file)
                                    <div
                                        class="tab-content text-gray-600 flex justify-between hover:bg-gray-400 rounded-lg hover:text-white cursor-pointer">
                                        <a class="mt-2" href="{{$file->rel_path}}" target="_blank">
                                            <span>{{$file->original_name}}.{{$file->ext}}</span>
                                        </a>
                                        <a href="{{$file->rel_path}}" download>
                                            <i class="mdi-24px mdi mdi-cloud-download-outline mr-1"></i>
                                        </a>

                                    </div>
                                    @if($loop->last)
                                        <div></div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($lessons->count())
                <div class="row">
                    <div class="col">
                        <div class="tabs">
                            <div class="tab bg-gray-200 px-4 em-padding">
                                <input type="checkbox" id="material-file">
                                <label class="tab-label text-black list-disc text-lg p-4" for="material-file"><span
                                        class="bullet">Μαθήματα</span></label>
                                @foreach($lessons as $lesson)
                                    <div
                                        class="tab-content text-gray-600  flex  justify-between hover:bg-gray-400 rounded-lg hover:text-white cursor-pointer spa-click"
                                        data-href="{{$lesson->type=="Link"?$lesson->link:route('index.showMaterial',[$course->slug,$lesson->slug])}}"
                                        data-type="{{$lesson->type}}"
                                    >
                                        <span style="flex-basis: 10%;"
                                              class="mt-1 font-semibold">{{$loop->index+1}}</span>
                                        <a class="mt-1  flex-1" href="">
                                            <span class="">{{$lesson->title}}</span>
                                        </a>
                                        <i style="flex-basis: 10%;"
                                           class="mt-1 mr-1 text-right  {{$lesson->getType($lesson->type)}}"></i>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($isSectionExist->isNotEmpty())
                <div class="row">
                    <div class="col">
                        <div class="tabs ">
                            <div class="tab bg-gray-200 px-4 ">
                                <input type="checkbox" id="sections">
                                <label class="tab-label text-black list-disc text-lg p-4" for="sections"><span
                                        class="bullet">Ενότητες</span></label>
                                <div class="tab-content text-gray-600 p-0 m-0 space-y-1" style="padding:0!important;">
                                    @foreach($sections as $key=> $section)
                                        @if(count($section->activeChapters))
                                            <div class="tabs " style="box-shadow: none!important;">
                                                <div class="tab bg-gray-200 p-0 mb-3">
                                                    <input type="checkbox" id="section-{{$section->slug}}">
                                                    <label
                                                        class="tab-label mb-2 text-black list-disc text-sm {{$section->pivot->highlight? "bg-blue-300" :"bg-white"}}  pr-5 items-center rounded-lg"
                                                        for="section-{{$section->slug}}">
                                                <span
                                                    class="border-r-1 border-gray-400 px-5 py-4">Ενότητες {{++$countSection}}</span>
                                                        <span
                                                            class="px-5 py-2 flex-1">{{\Str::limit($section->title,50,"...")}}</span>
                                                    </label>
                                                    @foreach($section->activeChapters()->where("type","!=","Announcement")->get() as $chapter)
                                                        <div
                                                            class="tab-content text-gray-600 flex justify-between hover:bg-gray-400 rounded-lg hover:text-white cursor-pointer spa-click"
                                                            style="padding-left: 15px;padding-right: 15px;"
                                                            data-href="{{$chapter->type=="Link"?$chapter->link:route('index.showMaterial',[$course->slug,$chapter->slug])}}"
                                                            data-type="{{$chapter->type}}"
                                                        >
                                                            <span style="flex-basis: 10%;"
                                                                  class="mt-1 font-semibold">{{$loop->index+1}}</span>
                                                            <a class="mt-1 flex-1 px-1" href="">
                                                                <span class="">{{$chapter->title}}</span>
                                                            </a>
                                                            <span class="mt-1">
                                                                <i style="flex-basis: 10%;"
                                                                   class="text-right mr-1 {{$chapter->getType($chapter->type)}}"></i></span>
                                                        </div>
                                                    @endforeach

                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </aside>

    </article>


    <div
        class="modal opacity-0 pointer-events-none absolute w-full h-full top-0 left-0 flex items-start justify-center"
        style="z-index: 99999">
        <div class="modal-overlay absolute w-full h-full bg-black opacity-25 top-0 left-0 cursor-pointer"></div>
        <div
            class="absolute rounded overflow-hidden mt-10 w-1/2 bg-white h-auto h rounded-sm shadow-lg flex flex-col p-10 text-2xl">
            <div class="swiper-container-announcements">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    @foreach($announcements  as $key => $announcement)
                        <div class="swiper-slide w-full">
                            <div
                                class="px-10 space-y-4 flex flex-col justify-center break-words w-5/6">
                                <h3 class="mb-3 text-2xl font-bold">{{$announcement->title}}  </h3>
                                <p class="text-base">{!! $announcement->content !!}</p>
                                <span class="text-base font-semibold">
                                            ({{$announcement->created_at->format('d/m/Y')}})
                                        </span>
                            </div>
                        </div>
                @endforeach
                <!-- Slides -->
                </div>
                <!-- If we need pagination -->
                <div class="swiper-pagination"></div>

                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>

                <!-- If we need scrollbar -->
                <div class="swiper-scrollbar"></div>
            </div>
        </div>
    </div>


@endsection

@section("script")
    <script src="{{ mix('js/index/courses/indexCourses.js') }}"></script>
    <script>
        let tabsContainer = document.querySelector("#tabs");

        let tabTogglers = tabsContainer.querySelectorAll("a");

        tabTogglers.forEach(function (toggler) {
            toggler.addEventListener("click", function (e) {
                e.preventDefault();

                let tabName = this.getAttribute("href");

                let tabContents = document.querySelector("#tab-contents");

                for (let i = 0; i < tabContents.children.length; i++) {
                    tabTogglers[i].parentElement.classList.add("bg-gray-200");
                    tabTogglers[i].parentElement.classList.remove("border-t", "border-r", "border-l", "-mb-px");
                    tabContents.children[i].classList.remove("hidden");
                    if ("#" + tabContents.children[i].id === tabName) {
                        tabTogglers[i].parentElement.classList.add("bg-white");
                        tabTogglers[i].parentElement.classList.remove("bg-gray-200");
                        continue;
                    }
                    tabContents.children[i].classList.add("hidden");

                }
                e.target.parentElement.classList.add("border-t", "border-r", "border-l", "-mb-px", "bg-white");
            });
        });

        $("#tabs").children().not(".hidden").first().children().first().attr("id", "default-tab")

        document.getElementById("default-tab").click();


    </script>

@endsection
