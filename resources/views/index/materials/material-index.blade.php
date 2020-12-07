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


if (json_decode($materials->fields)->summary){
    $activeTabsOne ="active";
    $activeContentOne="show active";

}else if(json_decode($materials->fields)->summary){
       $activeTabsTwo ="active";
       $activeContentTwo="show active";
}
else{
     $activeTabsThree ="active";
     $activeContentThree="show active";
}


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


    <section class=" d-flex wrapper flex-column mt-2">

        <div class="material-cnt">
            <div class="d-flex justify-content-between align-items-center template-cnt-title">
                <h2 data-material-slug="{{$materials->slug}}" class="template-title"></h2>
                <div>
                    <i class="uil-window-maximize"></i>
                    <i class="uil-times-circle"></i>
                </div>
            </div>
            <div class="row p-0" style="background-color: black">
                <div class="w-100 p-0  d-flex justify-content-center">
                    <div class="col-md-12 position-relative p-0" style="max-width: 150vh;">
                        @if($materials->video_link)
                            <div class="embed-responsive embed-responsive-4by3" style="padding-top:27px ">
                                <iframe class="embed-responsive-item "
                                        src="https://player.vimeo.com/video/{{$materials->video_link}}"
                                        allowfullscreen></iframe>

                            </div>
                        @elseif($materials->type=="PDF")
                            @php
                                $pdf = $materials->media()->wherePivot("usage", 4)->with("mediaDetails")->first()
                            @endphp
                            <embed id="pdf-embed" src="{{ $pdf->rel_path }}" type="application/pdf" width="100%"
                                   height="100%" style="height: 100vh"/>

                        @else

                            <div class="custom-background" style="background-image: url('{{$materials->cover}}')">
                            </div>

                        @endif

                    </div>
                </div>
            </div>


            <div class="p-0 m-0 defalt-color-topic d-flex justify-content-center"
                 style=";border-radius: 0; background:{{$bgColor}}">
                <div class="container" style="max-width: 1424px">
                    <div class="col-md-12 p-0">
                        <div class="row align-items-center p-2 justify-content-between template-hidden">
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
                                    $active = auth()->user()->witchlist() ->where('material_id',$materials->id)->where('course_id',$course->id)->first();
                                    $text= isset($active)?"Δεν το έχω δει":"Το έχω δει";
                                    $hover= isset($active)? "bg-white" :""
                                @endphp

                                @unlessrole('guest')
                                <div
                                    class="watchlist  d-flex justify-content-center justify-content-md-end align-items-center ml-2 "
                                    style=" margin-right: -0.7rem;">
                                    <button data-course-id="{{$course->id}}" data-material-id="{{$materials->id}}"
                                            class="js-watchlist-btn px-3 py-1 color-topic-second mr-2 {{$hover}}  bghover text-white border btn-outline-secondary">
                                        <span class="{{$active?"text-dark":""}} font-16">{{$text}}</span>
                                    </button>
                                    <button data-model="material" data-model-id="{{$materials->id}}"
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
                <div class="col-lg-8 template-col-12">


                    {{--//min svisti to thelw gia na allazei to single page--}}
                    <style>
                        .nav-pills .nav-link.active, .nav-pills .show > .nav-link {
                            color: #fff;
                            background: linear-gradient(
                                315deg, rgb(255, 78, 0) 0%, rgb(236, 133, 5) 75%);
                        }
                    </style>


                    <ul class="nav nav-tabs mb-3">
                        @if($materials->summary && json_decode($materials->fields)->summary)
                            <li class="nav-item ">
                                <a href="#tabs-summary" data-toggle="tab" aria-expanded="false"
                                   class="nav-link rounded-0 {{$activeTabsOne?$activeTabsOne:""}}">
                                    <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Πληροφορίες</span>
                                </a>
                            </li>
                        @endif
                        @if($materials->description && json_decode($materials->fields)->description)
                            <li class="nav-item">
                                <a href="#tabs-description" data-toggle="tab" aria-expanded="true"
                                   class="nav-link rounded-0 ">
                                    <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Περίληψη</span>
                                </a>
                            </li>
                        @endif

                        @if($materials->content && json_decode($materials->fields)->content)
                            <li class="nav-item">
                                <a href="#tabs-content" data-toggle="tab" aria-expanded="false"
                                   class="nav-link rounded-0">
                                    <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Συζήτηση</span>
                                </a>
                            </li>
                        @endif

                        @if(count($materials->media->where("type","!=",0))>0)
                            <li class="nav-item">
                                <a href="#tabs-files" data-toggle="tab" aria-expanded="false"
                                   class="nav-link rounded-0">
                                    <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Αρχεία</span>
                                </a>
                            </li>
                        @endif

                        @if(count($materials->media->where("type","!=",1))>0)
                            <li class="nav-item">
                                <a href="#tabs-media" data-toggle="tab" aria-expanded="false"
                                   class="nav-link rounded-0">
                                    <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Media</span>
                                </a>
                            </li>
                        @endif

                        <li class="nav-item">
                            <a href="#tabs-quiz" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                                <span class="d-none d-md-block">Quiz</span>
                            </a>
                        </li>

                    </ul>


                    <div class="tab-content">

                        <div class="tab-pane " id="tabs-summary">
                            <div class="p-2"> {!! $materials->summary !!}</div>
                        </div>

                        <div class="tab-pane " id="tabs-description">
                            <div class="p-2"> {!! $materials->description !!}</div>
                        </div>

                        <div class="tab-pane" id="tabs-content">
                            <div class="p-2"> {!! $materials->content !!}</div>
                        </div>

                        <div class="tab-pane" id="tabs-files">
                            <div class="tab-pane show active" id="profile">
                                <div class="accordion custom-accordion my-2" id="extra-content">
                                    <div class="card mb-0">

                                        <div id="collapse-extra-content" class="collapse show"
                                             aria-labelledby="head-extra-content" data-parent="#extra-content">
                                            <div class="card-body" style="padding: 30px">
                                                @foreach($materials->media->where("type","!=",0) as $media)

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
                                                                <i class="h3 mdi {{$materials->getIcon($media->ext)}}"></i>
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

                        <div class="tab-pane" id="tabs-media">
                            <div class="col-md-12 my-1">
                                <div class="d-flex flex-wrap ">
                                    @foreach($materials->media->where("type","!=",1) as $media)

                                        <a href="{{$media->rel_path}} " data-lightbox="image-1">
                                            <img class="d-block m-1"
                                                 src="{{$media->roundedMediumCoverUrl("rel_path")}}"
                                                 alt="First slide">
                                        </a>

                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    @include("components.index.comments.comments-main",["model"=>$materials,"namespace"=>"App\Material"])
                </div>
                <div class="col-lg-4 pl-3 template-hidden">
                    <div class="row hover-yellow px-2">
                        <div class="col-md-12   border d-flex justify-content-between"
                             style="border-radius: 8px; padding: 9px;background-color: #E9EAEB ;">
                            <div class="col-md-2 d-flex align-items-center">
                                @if($course->cover)
                                    <img height="40" width="40" class="rounded-circle" src="{{$course->cover}}" alt="">
                                @endif
                            </div>
                            <div class="col-md-10 ">
                                <a class="d-flex  justify-content-center flex-column"
                                   href="{{route('index.userCourse',$course->slug)}}">
                                    <span
                                        class="font-18  text-center text-black font-weight-bold">{{$course->title}}</span>
                                    <div class="d-flex justify-content-around">
                                        {{-- <span class="font-12 text-primary">Μέτριο</span>--}}
                                        <span class="font-14 text-black">{{$textMaterial}}</span>

                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>

                    <ul data-course-id="{{$course->id}}" class="w-600 my-2 p-0 single-section-material">
                        @php
                            $count = 0;
                            $countIfNotSection = 0
                        @endphp
                        @foreach($MaterialsOrderByPriority as $key=> $material)
                            @if($material->pivot->course_id==$course->id)
                                @php
                                    $material->type==="Section"?"":++$countIfNotSection;
                                    $active = auth()->user()->witchlist()->where('material_id',$material->id)->where('course_id',$course->id)->first();
                                    $activeClass= isset($active)?"<i class='text-danger h4 mdi mdi-check-bold'></i>":$countIfNotSection;
                                    $hover= isset($active)? "data-hover='hover'" :'';
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
                                            <a class="custom-accordion-title d-block " data-toggle="collapse"
                                               href="#{{$material->slug}}-collapse" aria-expanded="true"
                                               aria-controls="{{$material->slug}}-collapse">
                                                <div class="card-header d-flex align-center head-section "
                                                     id="{{$material->slug}}-head">
                                                    <h5 class="w-100 m-0 d-flex align-center">
                                                        <span class="mr-2 d-flex align-items-center">Ενότητα {{$key -$count+1 }} :</span>
                                                        <span
                                                            class="d-flex align-items-center"> {{$material->title}}</span>


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
                                                        @foreach($material->chapters->where("type", "!=", "Announcement") as $key=> $chapter)
                                                            @if($chapter->getOriginal('pivot_status')==1) {{--emganizei ta chapter me status 1 --}}

                                                            @php
                                                                $active = auth()->user()->witchlist()->where('material_id',$chapter->id)->where('course_id',$course->id)->first();
                                                                $link = route('index.material.show',[$course->slug,$chapter->slug]);
                                                                $hover= isset($active)? "data-hover='hover'" :'';
                                                                $activeClassMaterial= isset($active)?"<i class='text-danger h4 mdi mdi-check-bold'></i>":++$countChapter;
                                                            @endphp

                                                            <li data-material-id="{{$chapter->id}}"
                                                                data-material-priority="{{$key+1}}"
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
                                                                    <div
                                                                        class="col-lg-8 col-10 js-alert d-flex flex-column  align-items-center">
                                                                        <h3 style="border-radius: 5px"
                                                                            class="font-16 mt-1 text-black font-weight-bold"> {!! $chapter->title !!}
                                                                        </h3>
                                                                        <span style="word-break: break-all" class="
                                                                    font-12 text-dark"> {!! $chapter->subtitle !!}</span>
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
                                        data-material-priority="{{$countIfNotSection}}"
                                        class="list-group-item list-material  my-2 {{$material->title==$materials->title? "list-material-select border-orange":"border"}}  ">
                                        <a class="d-flex align-items-center {{
                                             $material->type=="Link"?"js-link-material":""}}" href="{{$link}}">
                                            <div class="col-lg-2 mr-2 col-1  ">
                                                @if($material->title==$materials->title)
                                                    <i style="margin:-8px;"
                                                       class="  now-play rounded-circle mdi h1 mdi-play-circle-outline"></i>
                                                @else
                                                    <div class="col-lg-2 mr-2 col-1 ">
                                    <span {{$hover}} style="margin:-20px;" class="material-count">
                                        {!! $activeClass !!}
                                    </span>
                                                    </div>

                                                @endif
                                            </div>
                                            <div class="col-lg-8 align-items-center col-10 d-flex flex-column ">
                                                <h3 style="border-radius: 5px"
                                                    class="font-16 mt-1 text-black font-weight-bold"> {!! $material->title !!}
                                                </h3>
                                                <span style="word-break: break-all" class="
{{--                                        {{$material->title==$materials->title? "":""}}--}}
                                                    font-12 text-dark"> {!! $material->subtitle !!}</span>
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

    @include("components.index.comments.comments-form")
@endsection

@section("script")



    <script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <script src="{{ mix('js/index/materials/indexMaterials.js') }}"></script>

    <script>


    </script>


@endsection
