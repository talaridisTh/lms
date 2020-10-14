@extends("layouts.app")

@section("style")


@endsection
@php
//background
    $bgColor = !empty($course->topics)>0? $course->topics->first()->color:"";



//count Material
    $countMaterial= $allMaterial->where("type","Lesson")->count()+
    $allMaterial->where("type","Section")->map(function ($chapter){
        return count($chapter->chapters->where("type","Lesson"));
    })->first();
    $textMaterial = $countMaterial>1? $countMaterial.' Μαθήματα':$countMaterial.' Μάθημα';


//count extra
    $countExtra= $allMaterial->where("type","!=","Lesson")->where("type","!=","Announcement")->where("type","!=","Section")->count()+
    $allMaterial->where("type","Section")->map(function ($chapter){
        return count($chapter->chapters->where("type","!=","Lesson")->where("type","!=","Announcement"));
    })->first();
    $textExtra = $countExtra>1? $countExtra.' Βοηθητικά Αρχεία':$countExtra.' Βοηθητικό Αρχείο';







@endphp
@section("content")

    <div class="content-page">
        <div class=" ml-5 content-width">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box ">
                        <div class="page-title-left">
                            <ol class="breadcrumb p-1 m-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}"
                                                               class="text-secondary">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{route('index.courses',Auth::user()->slug)}}"
                                                               class="text-secondary">Courses</a></li>
                                <li class="breadcrumb-item"><a href="{{route('index.userCourse',$course->slug)}}"
                                                               class="text-black">{{$course->title}}</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @role("admin")


        <div class="card ribbon-box" style="background-color: transparent">
            <div class="card-body py-0">
                <div class="p-1 bg-secondary " style="border-radius: 20px"><i class="mdi mdi-access-point mr-1"></i>
                    <a class="text-white ribbon-edit" href="{{route('course.show',$course->slug)}}">
                        <spant class="">Edit this page</spant>
                    </a>
                </div>
            </div> <!-- end card-body -->
        </div>
        @endrole

        <div class="container-xl mb-3" style="max-width: 1705px">
            <div class="row defalt-color-topic box-material-up px-5 pt-4 pb-2 px-lg-2 px-xl-5"
                 style="background:{{$bgColor}}">
                <div class="col-md-12">
                    <div class="row align-items-center text-center ">
                        <div class="col-md-6 col-lg-4 col-xl-3 mb-2">
                            <img  class=" avatar-image rounded-circle"
                                 src="{{$course->cover=="empty"? "http://lorempixel.com/300/300":url($course->cover)}}"
                                 alt="course-logo"
                            >
                        </div>
                        <div class="col-md-6 mb-md-4 col-lg-4 col-xl-6">
                            <h2 class="display-4 text-light">{{$course->title}}</h2>
                            <p class="text-light my-4">{{$course->subtitle}}</p>
                            <div class="button-course-fav my-sm-2">
                                @if(count($allMaterial))
                                    <a href="{{route('index.material.show',[$course->slug,$allMaterial->first()->slug])}}"
                                       class=" mr-2 px-4 mb-xl-0 mb-md-2     btn-begin btn bghover btn"
                                       style="background:white">Έναρξη
                                    </a>
                                @endif
                                <button
                                    data-model="course" data-model-id="{{$course->id}}" data-user-id="{{auth()->id()}}"
                                    class=" my-2 my-sm-0 color-topic-second add-watchlist box-watchlist px-3 box-title btn bghover btn-secontary ">
                                    <i class="font-16
                                     {{!count(auth()->user()->watchlistCourse->whereIn("title",$course->title))?"mdi mdi-heart-outline":"mdi mdi-cards-heart"}}
                                        ">


                                    </i>
                                    <span>{{!count(auth()->user()->watchlistCourse->whereIn("title",$course->title))?"  Προσθήκη στα αγαπημένα":"Αφαίρεση απο τα αγαπημένα"}}</span>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-12 mt-md-2 col-lg-4 col-xl-3">
                            <div class="box-last-material p-2 color-topic-second ">
                                <p class="box-num-material display-4"><span>{{$allMaterial->count()}}</span></p>
                                <div class="last-material font-12 text-light d-flex text-center flex-column mb-4">
                                    <span>Η τελευταία προσθήκη</span>
                                    @if(count($allMaterial))
                                        <span>{{\Carbon\Carbon::parse($lastMaterial->last()->created_at)->diffForHumans()}}</span>

                                </div>
                                <div class="box-button-subtitle text-light text-center">
                                    <p class="font-16">{{$lastMaterial->last()->title}}</p>
                                    <p class="font-12">{{$lastMaterial->last()->subtitle}}</p>
                                    <a class="text-white "
                                       href="{{route('index.material.show',[$course->slug,$lastMaterial->last()->slug])}}">
                                        <button class="bghover  color-topic-second  border  btn btn-secontary ">
                                            Δες το μάθημα
                                        </button>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row p-2 box-material-down  color-topic-second"
                 style="background:{{$bgColor}}">
                <div class="col-md-12 col-xl-4 px-md-5 d-flex  {{count($course->topics)>0? "justify-content-between":"justify-content-around"}} text-light">
                    {{--                    <span>metrio</span>--}}

                    <span><i class="mdi mdi-book-open-page-variant"></i> {{$textMaterial}}  </span>
                    <span><i class="mdi mdi-book-open-page-variant"></i> {{$textExtra}}  </span>
                    @foreach($topics as $topic)
                        <span class="topic-title  border px-2">{{$topic}}</span>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="container-fluid my-3" style="max-width: 1423px">
            <div class="row ">

                <div class="col-md-8 {{empty($course->description)?"d-none":""}}">
                    @include("components.index.user-info")


                    <div class="row ">
                        <div class="col-md-12 px-2">
                            @include("components.index.announcements")
                        </div>

                        <div class="col-md-12 px-2">
                            @include("components.index.collapse-menu",
                                ["idAccordion"=>$course->slug."-accordion-summary" ,
                                "idHeader"=>$course->slug."-header-summary",
                                "href"=>$course->slug."-href-summary",
                                "title"=>"Σχετικά με το μάθημα",
                                "body"=>$course->summary,
                                "fields"=>json_decode($course->fields)->summary

                                ])
                        </div>


                        <div class="col-md-12 px-2">
                            @include("components.index.collapse-menu",
                                ["idAccordion"=>$course->slug."-accordion-description" ,
                                "idHeader"=>$course->slug."-header-description",
                                "href"=>$course->slug."-href-description",
                                "title"=>"Μάθημα",
                                "body"=>$course->description,
                                 "fields"=>json_decode($course->fields)->description

                                ])
                        </div>


                    </div>
                </div>

                <div class=" {{!empty($course->description)?"col-md-4 pl-3":"offset-2 col-md-8 offset-2  text-left" }}">
                    @if(count($course->media->where("type","!=",0))>0)
                        <div class="accordion custom-accordion my-2" id="extra-content">
                            <div class="card mb-0">
                                <div class="card-header p-1" id="head-extra-content">
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
                                        @foreach($course->media->where("type","!=",0) as $media)
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

                                                    <a target="_blank"  href="{{url($media->rel_path)}}">
                                                        <i class="h3 mdi {{$course->getIcon($media->ext)}}"></i>
                                                        <span class=" ml-3">{{$media->original_name}}.{{$media->ext}}</span>
                                                    </a>
                                                </div>
                                            @endif
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <ul data-course-id="{{$course->id}}" style="max-height: 800px" class="m-0 p-0">
                        @php
                            $count = 0;
                        @endphp
                        @foreach($allMaterial as $key => $materials)

                            @php

                                $active =  auth()->user()->witchlist() ->where('material_id',$materials->id)->where('course_id',$course->id)->first();
                                  $activeClass=  isset($active)?"<i class='text-danger h4 mdi mdi-check-bold'></i>":++$count;
                                $hover=  isset($active)? "data-hover='hover'" :'';
                            @endphp
                            @if($materials->type==="Section")
                                @php
                                    --$count;
                                @endphp
                                <div class="accordion" id="{{$materials->slug}}">
                                    <div class="card mb-0">
                                        <a class="custom-accordion-title d-block "
                                           data-toggle="collapse" href="#{{$materials->slug}}-collapse"
                                           aria-expanded="true" aria-controls="{{$materials->slug}}-collapse">
                                        <div class="card-header d-flex align-center mb-2 head-section" id="{{$materials->slug}}-head">
                                            <h5 class="w-100 m-0 d-flex align-center">
                                                <span class="mr-2">Ενότητα {{$key -$count+1 }} :</span>

                                                    {{$materials->title}}

                                            </h5>
                                            <i
                                                class="mdi mdi-chevron-down accordion-arrow"></i>
                                        </div>
                                        </a>

                                        <div id="{{$materials->slug}}-collapse" class="collapse "
                                             aria-labelledby="{{$materials->slug}}-head"
                                             data-parent="#{{$materials->slug}}">
                                            <div class="p-0 card-body">


                                                @foreach($materials->chapters->where("type", "!=", "Announcement") as $chapter)



                                                    @php
                                                           $active =  auth()->user()->witchlist()->where('material_id',$chapter->id)->where('course_id',$course->id)->first();
                                                            $link = route('index.material.show',[$course->slug,$chapter->slug]);
                                                               $hover=  isset($active)? "data-hover='hover'" :'';
                                                            $activeClass=  isset($active)?"<i class='text-danger h4 mdi mdi-check-bold'></i>":$chapter->pivot->priority;
                                                    @endphp
                                                    <ul data-course-id="{{$course->id}}" style="max-height: 800px"
                                                        class="my-2 p-0">
                                                        <li data-material-id="{{$chapter->id}}"
                                                            data-material-priority="{{$chapter->pivot->priority}}"
                                                            class="list-group-item list-material  my-2 {{$chapter->title==$materials->title? "list-material-select border-orange":"border"}}  ">
                                                            <a class="d-flex align-items-center {{ $chapter->type=="Link"?"js-link-material":""}}"
                                                               href="{{$link}}">
                                                                <div class="col-md-2 ">
                                                                    @if($chapter->title==$materials->title)
                                                                        <i style="margin:-8px;"
                                                                           class="  now-play rounded-circle mdi h1 mdi-play-circle-outline"></i>
                                                                    @else
                                                                        <div class="col-md-2 mt-1 mr-2 ">

                                                                <span {{$hover}} style="margin:-20px;"
                                                                      class="material-count">
                                                                    {!! $activeClass!!}
                                                                </span>
                                                                        </div>

                                                                    @endif
                                                                </div>
                                                                <div class="col-md-8 js-alert d-flex flex-column  ">
                                                                    <h3 style="border-radius: 5px"
                                                                        class="font-16 mt-1 text-black font-weight-bold">   {!! $chapter->title !!}
                                                                    </h3>
                                                                    <span style="word-break: break-all" class="
                                                                    font-12 text-dark">    {!! $chapter->subtitle !!}</span>
                                                                </div>

                                                                <div class="col-md-2 js-alert">
                                                        <span class="">
                                                            <i class=" font-24 text-black {{App\Material::getType($chapter->type)}}"></i>
                                                        </span>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @else
                                <li data-material-id="{{$materials->id}}"
                                    data-material-priority="{{$count+1}}"
                                    class="list-group-item list-material border ">
                                    <a class="d-flex align-items-center {{
                            $materials->type=="Link"?"js-link-material":""}}"
                                       href="{{$materials->type=="Link"?"$materials->link":route('index.material.show',[$course->slug,$materials->slug])}}">
                                        <div class="col-md-2 mr-2 ">

                                            <div>
                                            <span
                                                {{$hover}} class="material-count">
                                                <span>{!! $activeClass !!}</span>
                                            </span>
                                            </div>
                                        </div>
                                        <div class="col-md-8 d-flex flex-column">
                                            <h3 style="border-radius: 5px"
                                                class="font-16 text-left text-md-center text-lg-left  text-black font-weight-bold">   {!! $materials->title!!}</h3>
                                            <span style="word-break: break-all"
                                                  class="font-12 text-dark d-none d-lg-block">    {!! $materials->subtitle !!}</span>
                                        </div>
                                        <div class="col-md-2 p-0">

                                            <i class=" font-24 text-black {{App\Material::getType($materials->type)}}"></i>

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

@endsection


@section("script")


    <script src="{{ mix('js/index/courses/indexCourses.js') }}"></script>



@endsection

