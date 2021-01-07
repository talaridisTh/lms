@extends("layouts.app")

@section("content")


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
                        <li class="text-black font-medium flex ">
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
                    <p class="font-light text-sm modal-button cursor-pointer" >Όλες οι ανακοινώσεις <i
                            class="ml-2 dripicons-chevron-right "></i></p>
                </div>
            </aside>
        </section>
        <section class="flex lg:px-16 px-9 text-white py-4 justify-between lg:justify-start  lg:space-x-10
         bg-opacity-20 bg-black w-full rounded-b-xl">
            <p><i class="mdi mdi-book-open-page-variant mr-1"></i>{{$sumMaterial}} Μαθήματα</p>
            <p><i class="mdi mdi-book-open-page-variant mr-1"></i>{{count($course->media->where("type",1))}} Βοηθητικά αρχεία</p>
        </section>
    </article>

    <article class="mdc:container lg:container mx-auto flex flex-wrap mt-7">
        <x-index.section-tabs
            :curator=$curator
            :fields="$fields"
            :model="$course"
        >
        </x-index.section-tabs>

        <x-index.section-materials
            :course="$course"
            :lessons="$lessons"
            :isSectionExist="$isSectionExist"
            :sections="$sections"
            :countSection="$countSection"
        ></x-index.section-materials>


    </article>


    <div
        class="modal opacity-0 pointer-events-none absolute w-full h-full top-0 left-0 flex items-start justify-center"
        style="z-index: 99999">
        <div class="modal-overlay absolute w-full h-full bg-black opacity-25 top-0 left-0 cursor-pointer"></div>
        <div
            class="absolute rounded overflow-hidden mt-10 w-1/2 bg-white h-auto h rounded-sm shadow-lg flex flex-col  text-2xl">
            <div class="swiper-container-announcements">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    @foreach($announcements  as $key => $announcement)
                        <div class="swiper-slide w-full">
                            <div class=" w-full lg:flex">

                                <div
                                    class=" my-7  space-y-7  bg-white rounded-b lg:rounded-b-none lg:rounded-r  flex flex-col justify-between leading-normal">
                                    <div class=" px-16">
                                        <div class="text-black font-bold text-xl ">{{$announcement->title}}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="px-16 w-11/12 break-words">
                                        <p class="text-grey-darker text-base  ">{!!$announcement->content!!}</p>
                                    </div>
                                    <hr>
                                    <div class="px-16 ">
                                        <p class="text-sm text-grey-dark">Aug 18</p>
                                    </div>
                                </div>
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


@endsection
