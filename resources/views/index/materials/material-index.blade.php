@extends("layouts.app")

@section("style")

@endsection

@section("content")


    <section class=" d-flex wrapper flex-column">
        <!-- start page title -->
        <div class="container content-width">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-left">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" class="custom-link-primary">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{route('index.courses',Auth::user()->slug)}}" class="custom-link-primary">Courses</a></li>
                                <li class="breadcrumb-item"><a href="{{route('index.userCourse',$course->slug)}}" class="custom-link-primary">{{$course->title}}</a></li>
                                <li class="breadcrumb-item active">{{$materials->title}}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        @role("admin")

        <div class="card ribbon-box" style="background-color: #FAFBFE">
            <div class="card-body py-0">
                <div class="p-1 bg-secondary "style="border-radius: 20px"><i class="mdi mdi-access-point mr-1"></i>
                    <a class="text-white " href="{{route('material.show',$materials->slug)}}">
                        <spant class="">Edit this page</spant>
                    </a>
                </div>
            </div> <!-- end card-body -->
        </div>
        @endrole
        @if($materials->video_link)
            <div class=" mb-1 ">
                @if(strlen($materials->video_link)<12 )
                    <iframe  src="https://player.vimeo.com/video/{{$materials->video_link}}" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:100vh;"></iframe>

                @else
                    <iframe src="{{$materials->video_link}}" width="1024" height="768" frameborder="0"
                            allow="autoplay; fullscreen" allowfullscreen></iframe>

                @endif
            </div>
        @else
            <img class="img-fluid"   src="{{url($materials->cover)}}" alt="">
        @endif
        <div class="container-fluid w-100 p-0 m-0" style="max-width: 100%;border-radius: 0"  >
                <div class="col-md-12   p-0 defalt-color-topic " style="background:{{$course->topics->first()->color}}">
                    <div class="row align-items-center p-2" >
                        <div class="col-md-2 m-0">
                            <div class="d-flex justify-content-start"></div>
                        @if(!empty($prevMaterial->slug))
                            <div class="  col-md-1 d-flex justify-content-center align-items-center">
                                <a data-toggle="tooltip" rel="tooltip" data-placement="left"
                                   title="Προηγούμενο {{!empty($prevMaterial->slug)? $prevMaterial->slug : $materials->slug}} "
                                   href="{{route('index.material.show',[$course->slug,!empty($prevMaterial->slug)? $prevMaterial->slug : $materials->slug])}}">
                                    <i class=" p-3 text-light cursor-pointer mdi h2 mdi-chevron-left"></i>
                                </a>
                            </div>
                        @endif
                        </div>
                        <div class="col-md-4">
                            <div class="row ">
                                <div style="margin-left: 5.4rem" class="col-md-12 text-white d-flex align-items-center justify-content-start">
                                    <h4 >{{$materials->title}}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="watchlist  d-flex justify-content-end align-items-center ml-2  ">
                                <button class=" px-3 py-1 color-topic-second mr-2   bghover text-white border btn-outline-secondary">
                                    <span class="font-16">Το έχω δει</span>
                                </button>
                                <button
                                    data-model="material" data-model-id="{{$materials->id}}"
                                    data-user-id="{{auth()->id()}}"
                                    class="px-3 py-1 color-topic-second add-watchlist   bghover text-white border btn-outline-secondary">
                                    <i class="font-16
                                     {{!count(auth()->user()->watchlistMaterial->whereIn("title",$materials->title))?"mdi mdi-heart-outline":"mdi mdi-cards-heart"}}
                                        ">
                                    </i> <span >Προσθήκη στα αγαπημένα</span>
                                </button>
                            </div>

                        </div>
                        <div class="col-md-2">
                            <div class="d-flex justify-content-end pr-1">
                            @if(!empty($nextMaterial->slug))
                                <div class="p-2 col-md-1 d-flex justify-content-center align-items-center">

                                    <a data-toggle="tooltip" rel="tooltip" data-placement="right"
                                       title="Επόμενο {{!empty($nextMaterial->slug)? $nextMaterial->slug : $materials->slug}} "
                                       href="{{route('index.material.show',[$course->slug,!empty($nextMaterial->slug)? $nextMaterial->slug : $materials->slug])}}">
                                        <i class=" text-light cursor-pointer mdi h2 mdi-chevron-right"></i>
                                    </a>
                                </div>
                            @endif
                            </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container  w-100 p my-3" style="max-width: 65%">
            <div class="row ">
                <div class="col-md-8 ">
                    <div class="row background-material">
                        <div class="col-md-12">
                            <div class="row justify-content-between py-3 " style="padding-left:4.5rem!important ">
                                <div class="col-md-6"><span class="font-weight-bold text-black">Εισηγητής </span>|
                                    {{$course->curator->first_name}}
                                </div>
                                <div class="col-md-6 text-right">
                                    <i class="{{$course->curator->facebook_link?"mdi cursor-pointer h3 mdi-facebook":""}}"></i>
                                    <i class="{{$course->curator->instagram_link?"mdi cursor-pointer h3 mdi-instagram":""}}"></i>
                                    <i class="{{$course->curator->youtube_link?"mdi cursor-pointer h3 mdi-youtube":""}}"></i>
                                    <i class="{{$course->curator->linkedin_link?"mdi cursor-pointer h3 mdi-linkedin":""}}"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 pl-3">
                            <div class="row mb-1 pl-4">
                                <div class="col-md-2 pt-2 text-center">
                                    <img height="80" width="80" class="img-fluid img-thumbnail rounded-circle"
                                         src="  {{$course->curator->cover}}"
                                         alt=""></div>
                                <div class="col-md-10 text-black d-flex flex-column justify-content-center ">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h4> </h4>
                                            <p> {!! $course->curator->profil !!}
                                            </p>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row  mt-3">
                        <div class="col-md-12   background-material text-center">
                            <div class=" p-2"><span class="font-weight-bold text-black ">Σχετικά με το μάθημα</span>
                            </div>
                        </div>
                        <div class="col-md-12  px-3 py-1">
                            <div class="row">
                                <div class="col-md-12 d-flex align-items-center pl-4 text-black">
                                    {!! $course->content !!}
                                </div>
                                <p class="d-flex align-items-center pl-4 mt-2 ">
                                    Δημοσιεύθηκε {{$materials->created_at->format("d-m-y")}}.</p>
                            </div>
                        </div>
                    </div>

                    <div class="row  mt-3">
                        <div class="col-md-12   background-material text-center">
                            <div class=" p-2"><span class="font-weight-bold text-black ">Περίληψη </span>
                            </div>
                        </div>
                        <div class="col-md-12  px-3 py-1">
                            <div class="row">
                                <div class="col-md-12 d-flex align-items-center pl-4 text-black">
                                    {!! $course->summary !!}
                                </div>
                                <p class="d-flex align-items-center pl-4 mt-2 ">
                                    Δημοσιεύθηκε {{$materials->created_at->format("d-m-y")}}.</p>
                            </div>
                        </div>
                    </div>

                    <div class="row  mt-3">
                        <div class="col-md-12   background-material text-center">
                            <div class=" p-2"><span class="font-weight-bold text-black ">Περιγραφή</span>
                            </div>
                        </div>
                        <div class="col-md-12  px-3 py-1">
                            <div class="row">
                                <div class="col-md-12 d-flex align-items-center pl-4 text-black">
                                    {!! $course->description !!}
                                </div>
                                <p class="d-flex align-items-center pl-4 mt-2 ">
                                    Δημοσιεύθηκε {{$materials->created_at->format("d-m-y")}}.</p>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-md-4 pl-3">
                    <div class="row hover-yellow">
                        <div class="col-md-12  border d-flex justify-content-between"
                             style="border-radius: 8px; padding: 9px">
                            <div class="col-md-2 d-flex align-items-center">
                                <img height="40" width="40" class="rounded-circle"
                                     src="{{$course->cover=="empty"? "http://lorempixel.com/300/300":url($course->cover)}}"
                                     alt="">
                            </div>
                            <div class="col-md-10 ">
                                <a class="d-flex justify-content-center flex-column"
                                   href="{{route('index.userCourse',$course->slug)}}">
                                    <span
                                        class="font-18  text-center text-black font-weight-bold">{{$course->title}}</span>
                                    <div class="d-flex justify-content-around">
                                        {{--                                        <span class="font-12 text-primary">Μέτριο</span>--}}
                                        <span class="font-14 text-black">{{$MaterialsOrderByPriority->count()}} Μάθηματα</span>

                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>
                    <hr class="text-blac">

                    @foreach($MaterialsOrderByPriority as $material)
                        <div
                            class="row my-2 material-title @if($material->title==$materials->title)   @endif">
                            <div class="col-md-12 list-material cursor-pointer  border d-flex justify-content-between align-items-center"
                                 style="border-radius: 5px;padding: 20px;">
                                <div class="col-md-2 ">
                                    @if($material->title==$materials->title)
                                        <i class=" ml-2 now-play rounded-circle mdi h1 mdi-play-circle-outline"></i>
                                    @else
                                        <div class="col-md-2 mt-1 ">
                                            <span class="material-count">  {{$material->priority}}</span>
                                        </div>

                                    @endif
                                </div>
                                <div class="col-md-8 ">
                                    <a class="d-flex justify-content-center flex-column"
                                       href="{{route('index.material.show',[$course->slug,$material->slug])}}">
                                <span  class="font-18 text-left text-black font-weight-bold">{{$material->title}}</span>
                                    </a>
                                </div>
                                    <div class="col-md-2 ">
                                        <span class="badge badge-primary-lighten">
                                      <i  class=" font-24 text-black {{App\Material::find($material->material_id)->type}}"></i>
                                        </span>
                                    </div>

                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>

    </section>

@endsection

@section("script")
    <script src="{{ mix('js/index/materials/indexMaterials.js') }}"></script>


    <script>

        $(".hover-yellow").mouseover(function () {

            $(this).css("background", "{{$course->topics->first()->color}}");
        })
        $(".hover-yellow").mouseout(function () {

            $(this).css("background", "");
        })

    </script>

@endsection
