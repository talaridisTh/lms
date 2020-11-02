@extends("layouts.app")
@php
    $bgColor = $course->topics->count() > 0 ? $course->topics->first()->color : "";


    $countMaterial= $MaterialsOrderByPriority->where("type","Lesson")->count()+
    $MaterialsOrderByPriority->where("type","Section")->map(function ($chapter){
    return count($chapter->chapters->where("type","Lesson"));
    })->first();
    $textMaterial = $countMaterial>1? $countMaterial.' Μαθήματα':$countMaterial.' Μάθημα';


    //count extra
    $countExtra= $MaterialsOrderByPriority->where("type","!=","Lesson")->where("type","!=","Announcement")->where("type","!=","Section")->count()+
    $MaterialsOrderByPriority->where("type","Section")->map(function ($chapter){
    return count($chapter->chapters->where("type","!=","Lesson")->where("type","!=","Announcement"));
    })->first();
    $textExtra = $countExtra>1? $countExtra.' Βοηθητικά Αρχεία':$countExtra.' Βοηθητικό Αρχείο';


@endphp

@section("style")
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    <style>
        .content-page {
            overflow: initial;
        }

        .wrapper {
            overflow: initial;
        }

        .sticky-front {

            position: -webkit-sticky;
            position: sticky;
            top: 0px;
            z-index: 1999;
        }

    </style>
@endsection

@section("content")


    <section class=" d-flex wrapper flex-column">
        <!-- start page title -->
        @unlessrole('guest')
        <div class=" ml-5 content-width">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-left">
                            <ol class="breadcrumb p-1 m-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}"
                                                               class="text-secondary">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{route('index.courses',Auth::user()->slug)}}"
                                                               class="text-secondary">Courses</a></li>
                                <li class="breadcrumb-item"><a href="{{route('index.userCourse',$course->slug)}}"
                                                               class="text-secondary">{{$course->title}}</a></li>
                                <li class="breadcrumb-item  text-black">{{$materials->title}}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endunlessrole
        <!-- end page title -->
        @role("admin")

        <div class="card d-lg-none d-xl-block ribbon-box" style="background-color: transparent">
            <div class="card-body py-0">
                <div class="p-1 bg-secondary " style="border-radius: 20px"><i class="mdi mdi-access-point mr-1"></i>
                    <a class="text-white " href="{{route('material.show',$materials->slug)}}">
                        <span class="">Edit this page</span>
                    </a>
                </div>
            </div> <!-- end card-body -->
        </div>
        @endrole
        <div>

            <div class="row p-0" style="background-color: black">
                <div class="w-100 p-0  d-flex justify-content-center">
                    <div class="col-md-12 position-relative p-0" style="max-width: 150vh;">
                        @if($materials->video_link)
                            <div class="embed-responsive embed-responsive-4by3" style="padding-top:27px ">
                                <iframe class="embed-responsive-item "
                                        src="https://player.vimeo.com/video/{{$materials->video_link}}"
                                        allowfullscreen></iframe>

                            </div>
                        @else

                            <div class="custom-background" style="background-image: url('{{$materials->cover}}')">">
                            </div>

                        @endif

                    </div>
                </div>
            </div>


            <div class="p-0 m-0 defalt-color-topic d-flex justify-content-center"
                 style=";border-radius: 0; background:{{$bgColor}}">
                <div class="container" style="max-width: 1424px">
                    <div class="col-md-12   p-0  ">
                        <div class="row align-items-center p-2 justify-content-between">
                            <div class="col-md-4 ">
                                <div class="row ">
                                    <div
                                        class="ml-2 fixed col-md-12 text-white d-flex align-items-center justify-content-center justify-content-md-start">
                                        <h4>{{$materials->title}}</h4>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-8 ">
                                @php
                                    $active =  auth()->user()->witchlist() ->where('material_id',$materials->id)->where('course_id',$course->id)->first();
                                    $text=  isset($active)?"Δεν το έχω δει":"Το έχω δει";
                                    $hover=  isset($active)? "bg-white" :""
                                @endphp

                                @unlessrole('guest')
                                <div
                                    class="watchlist  d-flex justify-content-center justify-content-md-end align-items-center ml-2 "
                                    style=" margin-right: -0.7rem;">
                                    <button
                                        data-course-id="{{$course->id}}"
                                        data-material-id="{{$materials->id}}"
                                        class="js-watchlist-btn px-3 py-1 color-topic-second mr-2 {{$hover}}  bghover text-white border btn-outline-secondary">
                                        <span class="{{$active?"text-dark":""}} font-16">{{$text}}</span>
                                    </button>
                                    <button
                                        data-model="material" data-model-id="{{$materials->id}}"
                                        data-user-id="{{auth()->id()}}"
                                        class="px-3 py-1 color-topic-second add-watchlist   bghover text-white border btn-outline-secondary">
                                        <i class="font-16
                                     {{!count(auth()->user()->watchlistMaterial->whereIn("title",$materials->title))?"mdi mdi-heart-outline":"mdi mdi-cards-heart"}}
                                            ">
                                        </i>
                                        <span
                                            class="font-16">{{!count(auth()->user()->watchlistMaterial->whereIn("title",$materials->title))?"  Προσθήκη στα αγαπημένα":"Αφαίρεση απο τα αγαπημένα"}}</span>
                                    </button>
                                </div>
                                @endunlessrole

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container  w-100  p-sm-3 p-lg-2 my-3" style="max-width: 1423px">
            <div class="row ">
                <div class="col-lg-8 ">


                    {{--                    @include("components.index.user-info")--}}

                    @include("components.index.announcements")


                    @include("components.index.collapse-menu",
                            ["idAccordion"=>$materials->slug."-accordion-summary" ,
                            "idHeader"=>$materials->slug."-header-summary",
                            "href"=>$materials->slug."-href-summary",
                            "title"=>"Σχετικά με το μάθημα",
                            "body"=>isset($materials->summary)?$materials->summary:"",
                             "fields"=>isset($materials->fields)?json_decode($materials->fields)->summary:""
                            ])
                    @include("components.index.collapse-menu",
                            ["idAccordion"=>$materials->slug."-accordion-description" ,
                            "idHeader"=>$materials->slug."-header-description",
                            "href"=>$materials->slug."-href-description",
                            "title"=>"Περίληψη",
                                  "body"=>isset($materials->description)?$materials->description:"",
                             "fields"=>isset($materials->fields)?json_decode($materials->fields)->description:""
                            ])
                    @include("components.index.collapse-menu",
                            ["idAccordion"=>$materials->slug."-accordion-content" ,
                            "idHeader"=>$materials->slug."-header-content",
                            "href"=>$materials->slug."-href-content",
                            "title"=>"Περιγραφή",
                               "body"=>isset($materials->content)?$materials->content:"",
                             "fields"=>isset($materials->fields)?json_decode($materials->fields)->content:""

                            ])


                </div>
                <div class="col-lg-4 pl-3">
                    <div class="row hover-yellow px-2">
                        <div class="col-md-12   border d-flex justify-content-between"
                             style="border-radius: 8px; padding: 9px;background-color: #E9EAEB ;">
                            <div class="col-md-2 d-flex align-items-center">
                                @if($course->cover)
                                    <img height="40" width="40" class="rounded-circle"
                                         src="{{$course->cover}}"
                                         alt="">
                                @endif
                            </div>
                            <div class="col-md-10 ">
                                <a class="d-flex  justify-content-center flex-column"
                                   href="{{route('index.userCourse',$course->slug)}}">
                                    <span
                                        class="font-18  text-center text-black font-weight-bold">{{$course->title}}</span>
                                    <div class="d-flex justify-content-around">
                                        {{--                                        <span class="font-12 text-primary">Μέτριο</span>--}}
                                        <span
                                            class="font-14 text-black">{{$textMaterial}}</span>

                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>

                    @if(count($materials->media->where("type","!=",1))>0)

                        <div class="col-md-12 my-1">
                            <div
                                class="cursor-pointer  custom-link-primary row justify-content-center align-items-center">
                                <i class=" mr-2 font-18 mdi mdi-image-filter"></i>
                                <a type="button" class="js-gallery my-1 font-18" data-toggle="modal"
                                   data-target="#bs-example-modal-lg">Εικόνες</a>
                                <div class="modal fade" id="bs-example-modal-lg" tabindex="-1" role="dialog"
                                     aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="swiper-container">
                                                    <!-- Additional required wrapper -->
                                                    <div class="swiper-wrapper">
                                                        <!-- Slides -->

                                                        @foreach($materials->media->where("type","!=",1) as $media)
                                                            <div class="swiper-slide">
                                                                <img class="d-block img-fluid"
                                                                     src="{{url($media->rel_path)}}"
                                                                     alt="First slide">
                                                            </div>
                                                        @endforeach


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
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                            </div>
                        </div>

                    @endif
                    @if(count($materials->media->where("type","!=",0))>0)
                        <div class="accordion custom-accordion my-2" id="extra-content">
                            <div class="card mb-0">
                                <div class="card-header p-2" id="head-extra-content">
                                    <h5 class="m-0 pl-2">
                                        <a class="custom-accordion-title d-block py-1"
                                           data-toggle="collapse" href="#collapse-extra-content"
                                           aria-expanded="true" aria-controls="collapse-extra-content">
                                            Βοηθητικά Αρχεία<i
                                                class="mdi mdi-chevron-down accordion-arrow"></i>
                                        </a>
                                    </h5>
                                </div>

                                <div id="collapse-extra-content" class="collapse show"
                                     aria-labelledby="head-extra-content"
                                     data-parent="#extra-content">
                                    <div class="card-body" style="padding: 30px">
                                        @foreach($materials->media->where("type","!=",0) as $media)
                                            @if($media->ext=="mp3")

                                                <i class="js-audio-btn my-1 h3 mdi mdi-play-circle-outline custom-link-primary cursor-pointer"
                                                   data-audio-status="paused"></i>
                                                <audio class="js-audio">
                                                    <source src="{{ $media->rel_path }}"
                                                            type="{{ $media->file_info }}">
                                                </audio>
                                                <span class=" ml-3">{{$media->original_name}}.{{$media->ext}}</span>
                                            @else

                                                <div class="d-flex flex-column">

                                                    <a target="_blank" href="{{url($media->rel_path)}}">
                                                        <i class="h3 mdi {{$materials->getIcon($media->ext)}}"></i>
                                                        <span
                                                            class=" ml-3">{{$media->original_name}}.{{$media->ext}}</span>
                                                    </a>
                                                </div>
                                            @endif
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <ul data-course-id="{{$course->id}}" class="w-600 my-2 p-0 single-section-material">
                        @php
                            $count = 0;
                        @endphp
                        @foreach($MaterialsOrderByPriority as $key=> $material)
                            @if($material->pivot->course_id==$course->id)
                                @php
                                    $active =  auth()->user()->witchlist()->where('material_id',$material->id)->where('course_id',$course->id)->first();
                                    $activeClass=  isset($active)?"<i class='text-danger h4 mdi mdi-check-bold'></i>":++$count;
                                    $hover=  isset($active)? "data-hover='hover'" :'';
                                    $link = route('index.material.show',[$course->slug,$material->slug]);
                                    if ($material->type=="link"){
                                        $link = $material->video_link;
                                    }elseif ($material->type=="Section"){
                                        $link ="";

                                    }
                                @endphp
                                @if($material->type==="Section")
                                    @php --$count; @endphp
                                    <div class="accordion section mt-2" id="{{$material->slug}}">
                                        <div class="card mb-0 bg-transparent">
                                            <a class="custom-accordion-title d-block "
                                               data-toggle="collapse" href="#{{$material->slug}}-collapse"
                                               aria-expanded="true" aria-controls="{{$material->slug}}-collapse">
                                                <div class="card-header d-flex align-center head-section "
                                                     id="{{$material->slug}}-head">
                                                    <h5 class="w-100 m-0 d-flex align-center">
                                                        <span class="mr-2 d-flex align-items-center">Ενότητα {{$key -$count+1 }} :</span>
                                                        <span
                                                            class="d-flex align-items-center">        {{$material->title}}</span>


                                                    </h5>
                                                    <i class="font-14 mdi mdi-chevron-down"></i>
                                                </div>
                                            </a>
                                            <div id="{{$material->slug}}-collapse" class="collapse "
                                                 aria-labelledby="{{$material->slug}}-head"
                                                 data-parent="#{{$material->slug}}">
                                                <div class="p-0 card-body">
                                                    <ul data-course-id="{{$course->id}}" style="max-height: 800px"
                                                        class="my-2 p-0 section-list ">
                                                        @php $countChapter = 0 @endphp
                                                        @foreach($material->chapters->where("type", "!=", "Announcement")  as   $chapter)
                                                            @if($chapter->getOriginal('pivot_status')==1)  {{--emganizei ta chapter me status 1 --}}

                                                            @php
                                                                $active =  auth()->user()->witchlist()->where('material_id',$chapter->id)->where('course_id',$course->id)->first();
                                                                 $link = route('index.material.show',[$course->slug,$chapter->slug]);
                                                                 $hover=  isset($active)? "data-hover='hover'" :'';
                                                                 $activeClassMaterial=  isset($active)?"<i class='text-danger h4 mdi mdi-check-bold'></i>":++$countChapter;
                                                            @endphp

                                                            <li data-material-id="{{$chapter->id}}"
                                                                data-material-priority="{{$countChapter}}"
                                                                class="list-group-item list-material border-r-0  m-0 {{$chapter->title==$materials->title? "list-material-select border-orange":""}}  ">
                                                                <a class="d-flex align-items-center {{ $chapter->type=="Link"?"js-link-material":""}}"
                                                                   href="{{$link}}">
                                                                    <div class="col-lg-2 col-1 ml-1  ">
                                                                        @if($chapter->title==$materials->title)
                                                                            <i style="margin:-8px;"
                                                                               class="  now-play rounded-circle mdi h1 mdi-play-circle-outline"></i>
                                                                        @else
                                                                            <div class="col-md-2 mt-1 mr-2 ">
                                                <span {{$hover}} style="margin:-20px;"
                                                      class="material-count">
                                                    {{--edw tha mpei to active class--}}
                                                    {!! $activeClassMaterial!!}
                                                </span>
                                                                            </div>

                                                                        @endif
                                                                    </div>
                                                                    <div class="col-lg-8 col-10 js-alert d-flex flex-column  align-items-center">
                                                                        <h3 style="border-radius: 5px"
                                                                            class="font-16 mt-1 text-black font-weight-bold">   {!! $chapter->title !!}
                                                                        </h3>
                                                                        <span style="word-break: break-all" class="
                                                                    font-12 text-dark">    {!! $chapter->subtitle !!}</span>
                                                                    </div>

                                                                    <div class="col-lg-2 col-1 js-alert">
                                                        <span class="">
                                                            <i class=" font-24 text-black {{App\Material::getType($chapter->type)}}"></i>
                                                        </span>
                                                                    </div>
                                                                </a>
                                                            </li>

                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @else

                                    <li data-material-id="{{$material->id}}"
                                        data-material-priority="{{++$countChapter}}"
                                        class="list-group-item list-material  my-2 {{$material->title==$materials->title? "list-material-select border-orange":"border"}}  ">
                                        <a class="d-flex align-items-center {{
                            $material->type=="Link"?"js-link-material":""}}"
                                           href="{{$link}}">
                                            <div class="col-lg-2 mr-2 col-1  ">
                                                @if($material->title==$materials->title)
                                                    <i style="margin:-8px;"

                                                       class="  now-play rounded-circle mdi h1 mdi-play-circle-outline"></i>
                                                @else
                                                    <div class="col-lg-2 mr-2 col-1 ">
                                                <span {{$hover}} style="margin:-20px;"
                                                      class="material-count">
                                                       {!! $activeClass !!}
                                                </span>
                                                    </div>

                                                @endif
                                            </div>
                                            <div class="col-lg-8 align-items-center col-10 d-flex flex-column ">
                                                <h3 style="border-radius: 5px"
                                                    class="font-16 mt-1 text-black font-weight-bold">   {!! $material->title !!}
                                                </h3>
                                                <span style="word-break: break-all" class="
{{--                                        {{$material->title==$materials->title? "":""}}--}}
                                                    font-12 text-dark">    {!! $material->subtitle !!}</span>
                                            </div>
                                            <div class="col-lg-2 col-1 p-0 js-alert">
                                        <span class="">
                                            <i class=" font-24 text-black {{App\Material::getType($material->type)}}"></i>
                                        </span>
                                            </div>
                                        </a>
                                    </li>
                                @endif

                            @endif
                        @endforeach
                    </ul>

                </div>
            </div>

        </div>

    </section>

@endsection

@section("script")



    <script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <script src="{{ mix('js/index/materials/indexMaterials.js') }}"></script>

    <script>


    </script>


@endsection
