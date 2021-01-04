@extends("layouts.app")
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
    .custom-container {
        max-width: 1642px;!important;
    }
</style>

@section("content")


    <div id="lessons-slide" class="custom-container splide mx-auto" >
        <div class="splide__track mx-4">
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
                                    <div class=" flex items-center mr-4 text-xs	 space-x-3 text-gray-500">
{{--                                            {{dd($countLessons,$course->slug)}}--}}
                                            <p class="inherits-color link no-transition">{{$countLessons[$course->slug]["lesson"]}} Μαθήματα</p>
                                            <p class="inherits-color link no-transition flex space-x-1">
                                                {{$countLessons[$course->slug]["extra-file"]}} Extra</p>
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

@endsection


