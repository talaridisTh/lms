<article class="mdc:container max-w-1xl lg:container mx-auto flex flex-col   rounded-xl "
         style="{{$course->topics->isEmpty()? "background:linear-gradient(315deg, rgb(255, 78, 0) 0%, rgb(236, 133, 5) 75%)":"background:".$course->topics->first()->color}} ">
    <section class="flex xl:justify-between justify-around flex-wrap items-center px-8">
        <figure class="w-64 h-64  my-8 relative lg:mr-16">
            <div
                    class="group avatar w-full h-full rounded-full overflow-hidden shadow-inner text-center bg-purple table cursor-pointer border">
                <img src="{{isset($course->cover)?$course->cover:asset("theme/images/no-course.png") }}"
                     class="p-3 rounded-full object-cover object-center w-full h-full visible group-hover:hidden"
                     alt="{{$course->title}}">
            </div>
        </figure>
        <section
                class="flex ml-0  xl:order-none w-full lg:order-last order-none xl:flex-1  space-y-8 p-4 pt-0 flex-col items-center lg:items-start text-white">
            @if(count($course->topics)>0)
                <h3 class="px-6 py-2 text-center border-1 border-white rounded-full">{{$course->topics->first()->title}}</h3>
            @endif
            <section class="flex flex-col w-full space-y-4">
                <h2 class="sm:text-4xl text-center lg:text-left font-weight-semibold xl:w-4/5 text-2xl course-slug"
                    data-course-slug="{{$course->slug}}">{{$course->title}}</h2>
                <p class="text-md xs:text-center lg:text-left font-weight-normal xl:w-3/5">{{\Str::limit($course->subtitle,150,"...")}}</p>
            </section>
        </section>
        <aside
                class="bg-opacity-10 w-full xl:w-3/10 lg:w-1/2  bg-black rounded-xl mb-4 lg:mb-0 flex flex-col items-start">
            <ul class="bg-white px-4 mx-4 mt-6 mb-0 py-2 rounded-full ">
                <li class="text-black font-semibold  ">Τελευταίες Ανακοινώσεις</li>
            </ul>
            <ul class="my-6 h-full px-4 w-full space-y-4 announcement">

                @forelse($announcements as $key =>$announcement)
                    <li class="text-black font-medium flex test-an cursor-pointer"
                        data-swiper-count="{{$loop->index}}">
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
            @if($announcements->isNotEmpty())
                <div class="flex px-4 text-white py-3 justify-end bg-opacity-20 bg-black w-full rounded-b-xl">
                    <p class="font-light text-sm modal-button-custom cursor-pointer">Όλες οι ανακοινώσεις <i
                                class="ml-2 dripicons-chevron-right "></i></p>
                </div>
            @endif
        </aside>
    </section>
    <section class="flex lg:px-16 px-9 text-white py-4 justify-between lg:justify-start  lg:space-x-10
         bg-opacity-20 bg-black w-full rounded-b-xl">
        <p><i class="mdi mdi-book-open-page-variant mr-1"></i>{{$sumMaterial}} Μαθήματα</p>
        <p><i class="mdi mdi-book-open-page-variant mr-1"></i>{{count($course->media->where("type",1))}} Βοηθητικά
            αρχεία</p>

    </section>
</article>