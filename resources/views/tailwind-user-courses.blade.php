@extends("layouts.app")

{{--@section("content")--}}

{{--    <article class="container mx-auto flex flex-wrap ">--}}
{{--        @forelse($courses as $course)--}}
{{--            <section class="overflow-hidden my-2 rounded-lg shadow-lg w-1/3  flex">--}}

{{--                <section class="flex flex-col w-3/12 justify-between h-full rounded-xl   py-5 space-y-10"--}}
{{--                         style="background:linear-gradient(315deg, rgb(255, 78, 0) 0%, rgb(236, 133, 5) 75%)">--}}
{{--                    <header class="flex items-center justify-center leading-tight pt-0 px-2 md:px-4">--}}
{{--                        --}}{{--                                                <h1 class="text-lg bg-gray-200 px-4 py-1 rounded-full">--}}
{{--                        --}}{{--                                                    {{count($course->topics)?$course->topics->first()->title:"Γενικά"}}--}}
{{--                        --}}{{--                                                </h1>--}}
{{--                    </header>--}}

{{--                    <figure class="flex justify-center">--}}
{{--                        <a href="#">--}}
{{--                            <img alt="Placeholder" class="block h-32 p-2 rounded-full"--}}
{{--                                 src="{{$course->roundedMediumCoverUrl("cover")}}">--}}
{{--                        </a>--}}

{{--                    </figure>--}}


{{--                </section>--}}

{{--                <section class="flex flex-col w-9/12  h-full p-5 justify-around">--}}

{{--                    <header class="flex items-center justify-start leading-tight  ">--}}
{{--                        <a href="{{route('index.showCourse',$course->slug)}}">--}}
{{--                            <h1 class="text-lg ">--}}
{{--                                {{$course->title}}--}}
{{--                            </h1>--}}
{{--                        </a>--}}
{{--                    </header>--}}

{{--                    <div class="text-sm">--}}
{{--                        <p>{!!\Str::limit($course->summary,100,"...")!!}</p>--}}
{{--                    </div>--}}


{{--                </section>--}}
{{--            </section>--}}
{{--        @empty--}}

{{--        @endforelse--}}

{{--    </article>--}}
{{--@endsection--}}


<style>
    .card {
        border: 1px solid rgba(36, 37, 38, .08);
        width: 345px;
        max-width: 100%;
        border-radius: .9rem;
        --bg-opacity: 1;
        background-color: #fff;
        background-color: rgba(255, 255, 255, var(--bg-opacity));
        --text-opacity: 1;
        color: #22292f;
        color: rgba(34, 41, 47, var(--text-opacity));
        margin-left: auto;
        margin-right: auto;
        overflow: hidden;
        position: relative;
    }

    .expanded-card {
        background: linear-gradient(
            180deg, #f44881, #ec454f);
    }
</style>

@section("content")

    {{--    <article class="container mx-auto grid gap-10"--}}
    {{--             style="grid-template-columns: repeat(auto-fill, minmax(330px, 1fr));">--}}
    {{--        @foreach($courses as $course)--}}
    {{--            <div class="card expanded-card border-none  flex pr-4"--}}
    {{--                 style="box-shadow: rgba(36, 37, 38, 0.04) 4px 4px 15px 0px;">--}}
    {{--                <div--}}
    {{--                    class=" mr-4 rounded-xl flex flex-col justify-between items-center py-5 px-4 flex-shrink-0"--}}
    {{--                    style="box-shadow: rgba(0, 0, 0, 0.17) 0px 4px 9px 0px;">--}}
    {{--                    <a href=""--}}
    {{--                       class="w-full bg-black-transparent-10--}}
    {{--                   hover:bg-white hover:text-grey-darkest rounded-full py-2--}}
    {{--                   leading-none px-4 text-white uppercase text-2xs text-center">--}}
    {{--                        Frameworks--}}
    {{--                    </a>--}}
    {{--                    <a href=""--}}
    {{--                       class="relative  block my-4 md:my-0 w-full h-auto">--}}
    {{--                        <svg viewBox="0 0 33.83098862 33.83098862" xmlns="http://www.w3.org/2000/svg"--}}
    {{--                             class="circle-chart "--}}
    {{--                             style="margin: -7px;">--}}
    {{--                            <circle stroke="rgba(0, 0, 0, .2)" stroke-width="1" fill="none" cx="16.91549431"--}}
    {{--                                    cy="16.91549431"--}}
    {{--                                    r="15.91549431" class="circle-chart__background"></circle>--}}
    {{--                            <circle stroke="white" stroke-width="1" stroke-dasharray="17,100" stroke-linecap="round"--}}
    {{--                                    fill="none"--}}
    {{--                                    cx="16.91549431" cy="16.91549431" r="15.91549431"--}}
    {{--                                    class="circle-chart__circle no-animation"></circle>--}}
    {{--                        </svg>--}}
    {{--                        <img width="98" height="98"--}}
    {{--                             data-src="{{$course->roundedMediumCoverUrl("cover")}}"--}}
    {{--                             alt=""--}}
    {{--                             class="absolute top-0 left-0 w-full"--}}
    {{--                             src="https://laracasts.s3.amazonaws.com/series/thumbnails/whats-new-in-laravel-8.png?v=8"></a>--}}
    {{--                    <div class="w-full text-center">--}}
    {{--                        <div class="font-semibold text-white text-3xs mb-2">Beginner Difficulty</div>--}}
    {{--                        <div class="flex justify-center x-4 space-x-1"><span--}}
    {{--                                class="rounded inline-block h-1 flex-1"></span> <span--}}
    {{--                                class="rounded inline-block h-1 flex-1"></span> <span--}}
    {{--                                class="inline-block rounded h-1 flex-1"></span></div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <div class=" relative flex flex-col justify-around py-5"><h3--}}
    {{--                        class=" inline-flex items-start lg:items-center lg:h-12 text-base  link">--}}
    {{--                        <a href="/series/whats-new-in-laravel-8">--}}
    {{--                            What's New in Laravel 8--}}
    {{--                        </a></h3>--}}
    {{--                    <div--}}
    {{--                        class=" text-xs text-black-transparent-60  lg:mb-auto mt-5">--}}
    {{--                        <p class="">Laravel 8 is here! This release includes brand new application </p></div>--}}
    {{--                    <div class="hidden lg:flex expanded-card-meta text-grey-dark text-2xs">--}}
    {{--                        <div class=" flex items-center mr-4">--}}
    {{--                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="14" viewBox="0 0 13 14"--}}
    {{--                                 class="inherits-color mr-2">--}}
    {{--                                <path fill-rule="nonzero"--}}
    {{--                                      d="M4.129 6.44v4.873c0 .217-.159.41-.395.481a4.098 4.098 0 0 1-1.167.155c-1.236 0-2.564-.437-2.564-1.398V4.317c-.028-.429.145-1.185.976-1.595.386-.19 2.412-1.314 3.43-1.882A.674.674 0 0 1 5.01.82c.19.09.309.262.309.448v.739c0 .281-.265.51-.591.51-.254 0-.47-.139-.554-.333-.92.51-2.273 1.258-2.61 1.423a.683.683 0 0 0-.38.573c0 .167.041.299.117.37.21.198.909.075 1.671-.32.733-.38 4.346-2.455 4.382-2.476a.67.67 0 0 1 .606-.025.505.505 0 0 1 .313.45v.058c0 .17-.099.329-.263.424 0 0-2.508 1.444-2.73 1.567-.85.472-1.152 1.051-1.152 2.213zM13 3.98V10.6a.498.498 0 0 1-.276.431s-3.445 2.308-4.144 2.675c-.367.193-.835.295-1.352.295-1.228 0-2.499-.574-2.499-1.532V6.14l.002-.006c.012-.373.113-.906.917-1.418C6.13 4.41 9 2.721 9.123 2.65a.674.674 0 0 1 .608-.03.505.505 0 0 1 .315.452v.738c0 .281-.264.51-.59.51a.598.598 0 0 1-.544-.31c-.917.54-2.262 1.337-2.563 1.528-.38.243-.431.403-.438.609.001.152.05.268.146.345.301.238 1.113.138 1.912-.276.592-.307 3.143-2.007 4.076-2.636a.673.673 0 0 1 .623-.056c.203.085.332.262.332.458zm-1.182 2.272L8.865 8.23v1.02l2.953-1.978v-1.02z"--}}
    {{--                                      opacity=".5" class="fill-current"></path>--}}
    {{--                            </svg>--}}
    {{--                            <a href="/series/whats-new-in-laravel-8" class="inherits-color link no-transition">12--}}
    {{--                                Lessons</a>--}}
    {{--                        </div>--}}
    {{--                        <div class="hidden  expanded-card-meta-length items-center">--}}
    {{--                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13"--}}
    {{--                                 class="inherits-color mr-2 relative" style="top: 1px;">--}}
    {{--                                <path fill-rule="evenodd"--}}
    {{--                                      d="M6.5 0C2.925 0 0 2.925 0 6.5S2.925 13 6.5 13 13 10.075 13 6.5 10.075 0 6.5 0zm2.967 9L6 6.913V3h1v3.391l3 1.761L9.467 9z"--}}
    {{--                                      opacity=".5" class="fill-current"></path>--}}
    {{--                            </svg>--}}
    {{--                            <span>59m</span></div>--}}
    {{--                    </div>--}}

    {{--                </div>--}}
    {{--            </div>--}}
    {{--        @endforeach--}}
    {{--    </article>--}}

    <div id="lessons-slide" class="splide  container mx-auto">
        <div class="splide__track mx-4


">
            <ul class="splide__list">
                @foreach($courses as $course)
                    <li class="splide__slide mx-4">
                        <article class="container mb-5"
                                 style="grid-template-columns: repeat(auto-fill, minmax(330px, 1fr));">
                                <div class="card \expanded-card border-none  flex pr-4"

                                     style="box-shadow: rgba(36, 37, 38, 0.04) 4px 4px 15px 0px;">
                                    <div
                                        class="expanded-card space-y-4 w-3/6 h-64 mr-4 rounded-xl flex flex-col justify-between items-center py-5 px-4 flex-shrink-0"
                                        style="box-shadow: rgba(0, 0, 0, 0.17) 0px 4px 9px 0px;">
                                        <a href="{{route('index.showCourse',$course->slug)}}"
                                           class="w-full bg-black-transparent-10  hover:text-grey-darkest rounded-full  leading-none px-4 text-white uppercase text-2xs text-center">
                                            {{count($course->topics)?$course->topics->first()->title:"Γενικά"}}
                                        </a>
                                        <a href="{{route('index.showCourse',$course->slug)}}"
                                           class="relative  block my-4 md:my-0 w-full h-auto">
                                            <svg viewBox="0 0 33.83098862 33.83098862"
                                                 xmlns="http://www.w3.org/2000/svg"
                                                 class="circle-chart "
                                                 style="margin: -7px;">
                                                <circle stroke="rgba(0, 0, 0, .2)" stroke-width="1" fill="none"
                                                        cx="16.91549431"
                                                        cy="16.91549431"
                                                        r="15.91549431" class="circle-chart__background"></circle>
                                                <circle stroke="white" stroke-width="1" stroke-dasharray="17,100"
                                                        stroke-linecap="round"
                                                        fill="none"
                                                        cx="16.91549431" cy="16.91549431" r="15.91549431"
                                                        class="circle-chart__circle no-animation"></circle>
                                            </svg>
                                            <img width="98" height="98"
                                                 alt=""
                                                 class="absolute top-0 left-0 w-full rounded-full"
                                                 src="{{$course->roundedMediumCoverUrl("cover")}}
                                                     "></a>
                                    </div>
                                    <div class=" relative flex flex-col justify-around my-5">
                                        <h3 class=" inline-flex items-start lg:items-center lg:h-12 text-base  link">
                                            <a href="{{route('index.showCourse',$course->slug)}}">
                                                {!! \Str::limit($course->title,20 , "...")!!}
                                            </a></h3>
                                        <div
                                            class=" text-xs text-black-transparent-60  lg:mb-auto mt-5">
                                            <p class="">{!! \Str::limit($course->summary,100 , "...")!!} </p>
                                        </div>
                                        <div class="hidden lg:flex expanded-card-meta text-grey-dark text-2xs">
                                            <div class=" flex items-center mr-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="14"
                                                     viewBox="0 0 13 14"
                                                     class="inherits-color mr-2">
                                                    <path fill-rule="nonzero"
                                                          d="M4.129 6.44v4.873c0 .217-.159.41-.395.481a4.098 4.098 0 0 1-1.167.155c-1.236 0-2.564-.437-2.564-1.398V4.317c-.028-.429.145-1.185.976-1.595.386-.19 2.412-1.314 3.43-1.882A.674.674 0 0 1 5.01.82c.19.09.309.262.309.448v.739c0 .281-.265.51-.591.51-.254 0-.47-.139-.554-.333-.92.51-2.273 1.258-2.61 1.423a.683.683 0 0 0-.38.573c0 .167.041.299.117.37.21.198.909.075 1.671-.32.733-.38 4.346-2.455 4.382-2.476a.67.67 0 0 1 .606-.025.505.505 0 0 1 .313.45v.058c0 .17-.099.329-.263.424 0 0-2.508 1.444-2.73 1.567-.85.472-1.152 1.051-1.152 2.213zM13 3.98V10.6a.498.498 0 0 1-.276.431s-3.445 2.308-4.144 2.675c-.367.193-.835.295-1.352.295-1.228 0-2.499-.574-2.499-1.532V6.14l.002-.006c.012-.373.113-.906.917-1.418C6.13 4.41 9 2.721 9.123 2.65a.674.674 0 0 1 .608-.03.505.505 0 0 1 .315.452v.738c0 .281-.264.51-.59.51a.598.598 0 0 1-.544-.31c-.917.54-2.262 1.337-2.563 1.528-.38.243-.431.403-.438.609.001.152.05.268.146.345.301.238 1.113.138 1.912-.276.592-.307 3.143-2.007 4.076-2.636a.673.673 0 0 1 .623-.056c.203.085.332.262.332.458zm-1.182 2.272L8.865 8.23v1.02l2.953-1.978v-1.02z"
                                                          opacity=".5" class="fill-current"></path>
                                                </svg>
                                                <a href="{{route('index.showCourse',$course->slug)}}"
                                                   class="inherits-color link no-transition">12
                                                    Lessons</a>
                                            </div>
                                            <div class="hidden  expanded-card-meta-length items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                                     viewBox="0 0 13 13"
                                                     class="inherits-color mr-2 relative" style="top: 1px;">
                                                    <path fill-rule="evenodd"
                                                          d="M6.5 0C2.925 0 0 2.925 0 6.5S2.925 13 6.5 13 13 10.075 13 6.5 10.075 0 6.5 0zm2.967 9L6 6.913V3h1v3.391l3 1.761L9.467 9z"
                                                          opacity=".5" class="fill-current"></path>
                                                </svg>
                                                <span>59m</span></div>
                                        </div>

                                    </div>
                                </div>


                        </article>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
@section("script")
    <script src="{{ mix('js/index/index.js') }}"></script>
    <script>
    </script>
@endsection


