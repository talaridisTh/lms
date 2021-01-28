<div
        class="modal-custom opacity-0 pointer-events-none absolute w-full h-full top-0 left-0 flex items-start justify-center"
        style="z-index: 99999">
    <div class="modal-overlay-custom absolute w-full h-full bg-black opacity-25 top-0 left-0 cursor-pointer"></div>
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
                                    class=" my-7  space-y-7 bg-white rounded-b lg:rounded-b-none lg:rounded-r  flex flex-col justify-between leading-normal">
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

