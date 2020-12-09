@extends("layouts.app")

@section("style")


@endsection
@php
    //background

        $bgColor = $course->topics->count() > 0 ? $course->topics->first()->color : "";

    //count Material
        $countMaterial= $allMaterial->where("type","Lesson")->count()+
        $allMaterial->where("type","Section")->map(function ($chapter){
           $countSingleChapter =  $chapter->chapters->map(function($singleChapter){
                  if($singleChapter->getOriginal('pivot_status')==1){
                        return $singleChapter;
                  }
            })->reject(function ($name) {
                return empty($name);
            });
            return count($countSingleChapter->where("type","Lesson"));
        })->first();
        $textMaterial = $countMaterial>1? $countMaterial.' Μαθήματα':$countMaterial.' Μάθημα';


    //count extra
        $countExtra= $allMaterial->where("type","!=","Lesson")->where("type","!=","Announcement")->where("type","!=","Section")->count()+
        $allMaterial->where("type","Section")->map(function ($chapter){
              $countSingleExtraChapter =  $chapter->chapters->map(function($singleExtraChapter){
                  if($singleExtraChapter->getOriginal('pivot_status')==1){
                        return $singleExtraChapter;
                  }
            })->reject(function ($name) {
                return empty($name);
            });
            return count($countSingleExtraChapter->where("type","!=","Lesson")->where("type","!=","Announcement"));
        })->first();
        $textExtra = $countExtra>1? $countExtra.' Βοηθητικά Αρχεία':$countExtra.' Βοηθητικό Αρχείο';


if (json_decode($course->fields)->summary){
    $activeTabsOne ="active";
    $activeContentOne="show active";

}else if (json_decode($course->fields)->description) {
       $activeTabsTwo ="active";
       $activeContentTwo="show active";
}
else if(count($course->media->where("type","!=",0))>0) {
       $activeTabsThree ="active";
       $activeContentThree="show active";
}
else if(count($course->media->where("type","!=",1))>0) {
       $activeTabsFour ="active";
       $activeContentFour="show active";
}
else if ($course->script) {
       $activeTabsFive ="active";
       $activeContentFive="show active";
}
else{
    $activeTabsSix ="active";
       $activeContentSix="show active";
}

@endphp
@section("content")


    <div class="content-page mt-1"><!-- breadcrumb -->
        <div class="container-xl mb-3" style="max-width: 1705px"> <!-- container banner -->

            <div class="row defalt-color-topic box-material-up px-5 pt-4 pb-2 px-lg-2 px-xl-5"
                 style="background:{{$bgColor}}"> <!-- row top banner -->
                <div class="col-md-12">
                    <div class="row align-items-center text-center  ">


                        <div class="col-md-6 col-lg-4 col-xl-3 mb-2">
                            @if($course->cover)
                                <img class="rounded-circle" src="{{($course->roundedMediumCoverUrl())}}"
                                     alt="course-logo">
                            @endif
                        </div>


                        <div class="col-md-6 mb-md-4 col-lg-4 col-xl-6">
                            <h2 data-course-slug="{{$course->slug}}" class="display-4 text-light course-slug">{{$course->title}}</h2>
                            <p class="text-light my-4 text-left">{{$course->subtitle}}</p>
                            <div class="button-course-fav my-sm-2 ">
                                @if(count($allMaterial))
                                    <a href="{{route('index.material.show',[$course->slug,$allMaterial->first()->slug])}}"
                                       class=" mr-2 px-4 mb-xl-0 mb-md-2 btn-begin btn bghover btn"
                                       style="background:white">Έναρξη
                                    </a>
                                @endif
                                @unlessrole("guest")
                                <button
                                    data-model="course" data-model-id="{{$course->id}}" data-user-id="{{auth()->id()}}"
                                    class=" my-2 my-sm-0 color-topic-second add-watchlist box-watchlist px-3 box-title btn bghover btn-secontary ">
                                    <i class="font-16
                                        {{!count(auth()->user()->watchlistCourse->whereIn("title",$course->title))?"mdi mdi-heart-outline":"mdi mdi-cards-heart"}}">
                                    </i>
                                    <span>{{!count(auth()->user()->watchlistCourse->whereIn("title",$course->title))?"  Προσθήκη στα αγαπημένα":"Αφαίρεση απο τα αγαπημένα"}}</span>
                                </button>
                                @endunlessrole
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end row top banner -->

            <div class="row p-2 box-material-down  color-topic-second" style="background:{{$bgColor}}">
                <div
                    class="col-md-12 col-xl-5  px-md-5 d-flex  {{count($course->topics)>0? "justify-content-between":"justify-content-around"}} text-light">
                    <span><i class="mdi mdi-book-open-page-variant"></i> {{$textMaterial}}  </span>
                    <span><i class="mdi mdi-book-open-page-variant"></i> {{$textExtra}}  </span>
                    @foreach($topics as $topic)
                        <span class="topic-title d-none d-sm-block  border px-2">{{$topic}}</span>
                    @endforeach
                </div>
            </div>

        </div> <!-- end container banner -->

        <div class="container-fluid my-3 position-relative" style="max-width: 1423px"> <!--  container info -->

            <div class="row template-cnt">
                <div class="col-lg-8  {{empty($course->description)?"d-none":""}}">
                    @include("components.index.user-info")
                    <div class="row ">
                        <div class="col-lg-12 template-col-12">
                            {{--//min svisti to thelw gia na allazei to single page--}}
                            <style>
                                .nav-pills .nav-link.active, .nav-pills .show > .nav-link {
                                    color: #fff;
                                    background: linear-gradient(
                                        315deg, rgb(255, 78, 0) 0%, rgb(236, 133, 5) 75%);
                                }
                            </style>
                            <ul class="nav nav-tabs mb-3">
                                @if($course->summary && json_decode($course->fields)->summary)
                                    <li class="nav-item ">
                                        <a href="#tabs-summary" data-toggle="tab" aria-expanded="false"
                                           class="nav-link rounded-0 {{isset($activeTabsOne)?$activeTabsOne:""}}">
                                            <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                            <span class="d-none d-md-block">Πληροφορίες</span>
                                        </a>
                                    </li>
                                @endif
                                @if($course->description && json_decode($course->fields)->description)
                                    <li class="nav-item">
                                        <a href="#tabs-description" data-toggle="tab" aria-expanded="true"
                                           class="nav-link rounded-0 {{isset($activeTabsTwo)?$activeTabsTwo:""}}">
                                            <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                            <span class="d-none d-md-block">Περίληψη</span>
                                        </a>
                                    </li>
                                @endif

                                @if(count($course->media->where("type","!=",0))>0)
                                    <li class="nav-item">
                                        <a href="#tabs-files" data-toggle="tab" aria-expanded="false"
                                           class="nav-link rounded-0 {{isset($activeTabsThree)?$activeTabsThree:""}}">
                                            <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                                            <span class="d-none d-md-block">Αρχεία</span>
                                        </a>
                                    </li>
                                @endif

                                @if(count($course->media->where("type","!=",1))>0)
                                    <li class="nav-item">
                                        <a href="#tabs-media" data-toggle="tab" aria-expanded="false"
                                           class="nav-link rounded-0 {{isset($activeTabsFour)?$activeTabsFour:""}}">
                                            <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                                            <span class="d-none d-md-block">Media</span>
                                        </a>
                                    </li>
                                @endif
                                @if($course->script)
                                    <li class="nav-item">
                                        <a href="#tabs-quiz" data-toggle="tab" aria-expanded="false"
                                           class="nav-link rounded-0 {{isset($activeTabsFive)?$activeTabsFive:""}}">
                                            <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                                            <span class="d-none d-md-block">Quiz</span>
                                        </a>
                                    </li>
                                @endif

                                <li class="nav-item">
                                    <a href="#tabs-disscus" data-toggle="tab" aria-expanded="false"
                                       class="nav-link rounded-0 {{isset($activeTabsSix)?$activeTabsSix:""}}">
                                        <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                                        <span class="d-none d-md-block">Συζήτηση</span>
                                    </a>
                                </li>
                            </ul>


                            <div class="tab-content">
                                <div class="tab-pane {{isset($activeContentOne)?$activeContentOne:""}}"
                                     id="tabs-summary">
                                    <div class="p-2"> {!! $course->summary !!}</div>
                                </div>

                                <div class="tab-pane {{isset($activeContentTwo)?$activeContentTwo:""}}"
                                     id="tabs-description">
                                    <div class="p-2"> {!! $course->description !!}</div>
                                </div>

                                <div class="tab-pane {{isset($activeContentThree)?$activeContentThree:""}}"
                                     id="tabs-files">
                                    <div class="tab-pane show active" id="profile">
                                        <div class="accordion custom-accordion my-2" id="extra-content">
                                            <div class="card mb-0">

                                                <div id="collapse-extra-content" class="collapse show"
                                                     aria-labelledby="head-extra-content" data-parent="#extra-content">
                                                    <div class="card-body" style="padding: 30px">
                                                        @foreach($course->media->where("type","!=",0) as $media)

                                                            @if($media->ext=="mp3")

                                                                <i class="js-audio-btn my-1 h3 mdi mdi-play-circle-outline custom-link-primary cursor-pointer"
                                                                   data-audio-status="paused"></i>
                                                                <audio class="js-audio">
                                                                    <source src="{{ $media->rel_path }}"
                                                                            type="{{ $media->file_info }}">
                                                                </audio>
                                                                <span
                                                                    class=" ml-3">{{$media->original_name}}.{{$media->ext}}</span>
                                                            @else

                                                                <div class="d-flex flex-column">

                                                                    <a target="_blank" href="{{url($media->rel_path)}}">
                                                                        <i class="h3 mdi {{$course->getIcon($media->ext)}}"></i>
                                                                        <span
                                                                            class=" ml-3">
                                                             {{isset($media->mediaDetails)? $media->mediaDetails->title:$media->original_name}}.{{$media->ext}}
                                                        </span>
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="tab-pane {{isset($activeContentFour)?$activeContentFour:""}}"
                                     id="tabs-media">
                                    <div class="col-md-12 my-1">
                                        <div class="d-flex flex-wrap ">
                                            @foreach($course->media->where("type","!=",1) as $media)

                                                <a href="{{$media->rel_path}} " data-lightbox="image-1">
                                                    <img class="d-block m-1"
                                                         src="{{$media->roundedMediumCoverUrl("rel_path")}}"
                                                         alt="First slide">
                                                </a>

                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane {{isset($activeContentFive)?$activeContentFive:""}}"
                                     id="tabs-quiz">
                                    {!! $course->script !!}
                                </div>

                                <div class="tab-pane {{isset($activeContentSix)?$activeContentSix:""}}"
                                     id="tabs-disscus">
                                    @include("components.index.comments.comments-main",["model"=>$course,"namespace"=>"App\Models\Course"])
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="{{!empty($course->description)?"col-lg-4 pl-3 d-flex justify-content-center d-lg-block ":"offset-2 col-md-8 offset-2 text-left" }}">

                    @if((count($announcements = $course->materials->where("type","Announcement"))>0))
                        <div class="accordion" id="courses-announcement">
                            <div class="card mb-0">
                                <div class="card-header alert-danger" id="heading-announcement">
                                    <h5 class="m-0">
                                        <a class="custom-accordion-title d-block pt-2 pb-2"
                                           data-toggle="collapse" href="#collapseOne"
                                           aria-expanded="true" aria-controls="collapseOne">
                                            Ανακοινώσεις
                                        </a>
                                    </h5>
                                </div>

                                <div id="collapseOne" class="collapse show"
                                     aria-labelledby="heading-announcement" data-parent="#courses-announcement">
                                    <div class="card-body py-1" data-simplebar style="max-height: 200px;">
                                        @foreach($announcements  as $key => $announcement)
                                            <div class="single-announcement  mb-3" id="announcement-{{$key}}">

                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h3>{{$announcement->title}}</h3>
                                                    <span class="font-12 text-muted">{{$announcement->created_at->diffForHumans()}}</span>
                                                </div>

                                                {{$announcement->description}}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(count($course->media->where("type","!=",0))>0)
                        <div class="accordion custom-accordion my-2" id="extra-content">
                            <div class="card mb-0">

                                <div class="card-header p-1" id="head-extra-content">
                                    <h5 class="m-0 pl-2">
                                        <a class="custom-accordion-title d-block py-1"
                                           data-toggle="collapse" href="#collapse-extra-content"
                                           aria-expanded="true" aria-controls="collapse-extra-content">
                                            Βοηθητικά Αρχεία
                                            <i class="mdi mdi-chevron-down accordion-arrow"></i>
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
                                                    <source src="{{ $media->rel_path }}" type="{{ $media->file_info }}">
                                                </audio>
                                                <span class=" ml-3">{{$media->original_name}}.{{$media->ext}}</span>
                                            @else
                                                <div class="d-flex flex-column">
                                                    <a target="_blank" href="{{url($media->rel_path)}}">
                                                        <i class="h3 mdi {{$course->getIcon($media->ext)}}"></i>
                                                        <span
                                                            class=" ml-3">
                                                              {{isset($media->mediaDetails)? $media->mediaDetails->title:$media->original_name}}.{{$media->ext}}
                                                        </span>
                                                    </a>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif

                    <ul data-course-id="{{$course->id}}" class="w-600 m-0 p-0 single-section-material"> <!-- list material -->

                        @php
                            $count = 0;  //count material
                            $countIfNotSection = 0
                        @endphp

                        @foreach($allMaterial as $key => $materials)

                            @php
                                $materials->type==="Section"?"":++$countIfNotSection;
                                $active =  auth()->user()->witchlist() ->where('material_id',$materials->id)->where('course_id',$course->id)->first(); //blepei an o xristis exei dei to mathima
                                $activeClass = isset($active)?"<i class='text-danger h4 mdi mdi-check-bold'></i>":$countIfNotSection; //ean to exei dei bazi tik allis arithmo
                                $hover = isset($active)? "data-hover='hover'" :''; //bazei dataset hover ean to exei dei
                            @endphp


                            @if($materials->type==="Section"  ) {{--elenxi an to mathima einai section--}}

                            @php
                                --$count;//den metraei count an einai section
                            @endphp



                            <div class="accordion section mb-2" id="{{$materials->slug}}"> <!-- list section -->
                                <div class="card mb-0 bg-transparent">
                                    <a class="custom-accordion-title d-block "
                                       data-toggle="collapse" href="#{{$materials->slug}}-collapse"
                                       aria-expanded="true" aria-controls="{{$materials->slug}}-collapse">
                                        <div class="card-header d-flex align-center mt-2  head-section"
                                             id="{{$materials->slug}}-head">
                                            <h5 class="w-100 m-0 d-flex align-center">
                                                <span class="section-name d-flex align-items-center"
                                                      class="mr-2">Ενότητα {{$key -$count+1 }} :</span>
                                                <span class="d-flex align-items-center"> {{$materials->title}}</span>
                                            </h5>
                                            <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                        </div>
                                    </a>

                                    <div id="{{$materials->slug}}-collapse" class="collapse "
                                         aria-labelledby="{{$materials->slug}}-head"
                                         data-parent="#{{$materials->slug}}">
                                        <div class="p-0 card-body">
                                            <ul class="section-list p-0" data-course-id="{{$course->id}}"
                                                class="my-2 p-0"><!-- list chapter -->
                                                @php $countChapter = 0;  @endphp
                                                @foreach($materials->chapters->where("type", "!=", "Announcement") as $key => $chapter)  {{--foreach gia na bri ta chapter--}}

                                                @if($chapter->getOriginal('pivot_status')==1)  {{--emganizei ta chapter me status 1 --}}

                                                @php

                                                    $active =  auth()->user()->witchlist()->where('material_id',$chapter->id)->where('course_id',$course->id)->first(); //blepei an o xristis exei dei to mathima
                                                    $link = route('index.material.show',[$course->slug,$chapter->slug]); //orizi route
                                                    $hover=  isset($active)? "data-hover='hover'" :''; //bazei dataset hover ean to exei dei
                                                    $activeClassMaterial=  isset($active)?"<i class='text-danger h4 mdi mdi-check-bold'></i>":++$countChapter; //ean to exei dei bazi tik allis arithmo
                                                @endphp

                                                <li data-material-id="{{$chapter->id}}"
                                                    data-material-priority="{{$key+1}}"
                                                    class="list-group-item border-r-0 list-material m-0 {{$chapter->title==$materials->title? "list-material-select border-orange":""}}  ">
                                                    <a data-material-slug="{{$chapter->slug}}" data-material-title="{!! $chapter->title !!}" class="d-flex align-items-center {{ $chapter->type=="Link"?"js-link-material":""}}"
                                                       href="{{$link}}">
                                                        <div class="col-lg-2 col-1 ml-1 ">

                                                            @if($chapter->title==$materials->title) {{--blepw to current chapter --}}
                                                            <i style="margin:-8px;"
                                                               class="  now-play rounded-circle mdi h1 mdi-play-circle-outline"></i>
                                                            @else
                                                                <div class="col-sm-2 col-1 mt-1 mr-2 ">
                                                                    <span {{$hover}} style="margin:-20px;"
                                                                          class="material-count ">
                                                                     {!! $activeClassMaterial!!}
                                                                    </span>
                                                                </div>
                                                            @endif

                                                        </div>
                                                        <div class="col-lg-8 col-10 js-alert d-flex flex-column  align-items-center">
                                                            <h3 style="border-radius: 5px"
                                                                class="font-16 mt-1 text-black font-weight-bold">   {!! $chapter->title !!}
                                                            </h3>
                                                            <span style="word-break: break-all"
                                                                  class="font-12 text-dark">{!! $chapter->subtitle !!}</span>
                                                        </div>
                                                        <div class="col-lg-2 col-1 js-alert">
                                                        <span class="">
                                                            <i class=" font-24 text-black {{App\Models\Material::getType($chapter->type)}}"></i> {{--bazei to icon anti gia to type--}}
                                                        </span>
                                                        </div>
                                                    </a>
                                                </li>

                                                @endif

                                                @endforeach
                                            </ul><!--END list chapter -->
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- END list section -->

                            @else

                                <li data-material-id="{{$materials->id}}"
                                    data-material-priority="{{$countIfNotSection}}"
                                    class="list-group-item list-material border ">
                                    <a data-material-slug="{{$materials->slug}}" data-material-title="{!! $materials->title!!}" class=" d-flex align-items-center {{ $materials->type=="Link"?"js-link-material":""}}"
                                       href="{{$materials->type=="Link"?"$materials->link":route('index.material.show',[$course->slug,$materials->slug])}}">
                                        @unlessrole("guest")
                                        <div class="col-lg-2 mr-2 col-1 ">
                                            <div>
                                            <span {{$hover}} class="material-count ">
                                                <span>{!! $activeClass!!}</span>
                                            </span>
                                            </div>
                                        </div>
                                        @endunlessrole

                                        <div class="col-lg-8 align-items-center col-10 d-flex flex-column">
                                            <h3 style="border-radius: 5px"
                                                class="font-16 text-left text-md-center text-lg-left  text-black font-weight-bold"> {!! $materials->title!!}</h3>
                                            <span style="word-break: break-all"
                                                  class="font-12 text-dark d-none d-lg-block">    {!! $materials->subtitle !!}</span>
                                        </div>
                                        <div class="col-lg-2 col-1 p-0  js-alert">
                                            <i class=" font-24 text-black {{App\Models\Material::getType($materials->type)}}"></i>
                                        </div>
                                    </a>
                                </li>
                            @endif

                        @endforeach
                    </ul>  <!-- end list material -->

                </div>

{{--                <p class="template-fullscreen">test</p>--}}

            </div>


        </div> <!--  container info -->

    </div>

    @include("components.index.comments.comments-form")
@endsection


@section("script")


    <script src="{{ mix('js/index/courses/indexCourses.js') }}"></script>



@endsection

