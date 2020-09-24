@extends("layouts.app")

@section("style")
    <style>
        body{
            box-sizing: border-box;
        }
    </style>

@endsection

@section("content")


    <section class=" d-flex wrapper flex-column">
        <!-- start page title -->
        <div class=" ml-5 content-width">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-left">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" class="custom-link-primary">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{route('index.courses',Auth::user()->slug)}}" class="custom-link-primary">Courses</a></li>
                                <li class="breadcrumb-item"><a href="{{route('index.userCourse',$course->slug)}}" class="custom-link-primary">{{$course->title}}</a></li>
                                <li class="breadcrumb-item  text-black">{{$materials->title}}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        @role("admin")

        <div class="card ribbon-box" style="background-color: transparent">
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
        <div class="p-0 m-0 defalt-color-topic d-flex justify-content-center" style=";border-radius: 0; background:{{$course->topics->first()->color}}"  >
                <div class="col-md-12   p-0  " style="max-width: 1847px">
                    <div class="row align-items-center p-2" >
                        <div class="col-md-2 m-0 d-flex justify-content-end" style="padding-right: 3.5rem;">
                            <div class="d-flex justify-content-start"></div>
                        @if(!empty($prevMaterial->slug))
                            <div class="  col-md-1 d-flex justify-content-center align-items-center">
                                <a {{--data-toggle="tooltip"--}}{{-- rel="tooltip" data-placement="left"--}}
                                   title="Προηγούμενο {{!empty($prevMaterial->slug)? $prevMaterial->slug : $materials->slug}} "
                                   href="{{route('index.material.show',[$course->slug,!empty($prevMaterial->slug)? $prevMaterial->slug : $materials->slug])}}">
                                    <i class=" p-3 text-light cursor-pointer mdi h2 mdi-chevron-left"></i>
                                </a>
                            </div>
                        @endif
                        </div>
                        <div class="col-md-4">
                            <div class="row ">
                                <div  class="col-md-12 text-white d-flex align-items-center justify-content-start">
                                    <h4 >{{$materials->title}}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" >
                            <div class="watchlist  d-flex justify-content-end align-items-center ml-2 " style=" margin-right: -2rem;">
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
                                    </i>
                                    <span >{{!count(auth()->user()->watchlistMaterial->whereIn("title",$materials->title))?"  Προσθήκη στα αγαπημένα":"Αφαίρεση απο τα αγαπημένα"}}</span>
                                </button>
                            </div>

                        </div>
                        <div class="col-md-2 d-flex justify-content-start">
                            <div class="d-flex justify-content-end pr-1">
                            @if(!empty($nextMaterial->slug))
                                <div class="p-2 col-md-1 d-flex justify-content-center align-items-center">

                                    <a {{--data-toggle="tooltip" rel="tooltip" data-placement="right"--}}
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
        <div class="container  w-100 p my-3" style="max-width: 1280px">
            <div class="row ">
                <div class="col-md-8 ">
                    @include("components.index.user-info")
                    <div class="row  ">
                        <div class="col-md-12   background-material ">
                            <div class="  p-2 "><span class="font-weight-bold text-black ">Σχετικά με το μάθημα</span>
                            </div>
                        </div>
                        <div class="col-md-12  mb-3">
                            <div class="row">
                                <div class="col-md-12 d-flex align-items-center  text-black  pl-3  "  >
                                    {!! $course->content !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row  ">
                        <div class="col-md-12  mb-3  background-material px-2">
                            <div class=" p-2"><span class="font-weight-bold text-black   " >Περίληψη </span>
                            </div>
                        </div>
                        <div class="col-md-12  mb-3 ">
                            <div class="row">
                                <div class="col-md-12 d-flex align-items-center  pl-3  text-black"   >
                                    {!! $course->summary !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row  ">
                        <div class="col-md-12   background-material px-2">
                            <div class=" p-2"><span class="font-weight-bold text-black   ">Περιγραφή</span>
                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="row">
                                <div class="col-md-12 d-flex align-items-center mt-3 pl-3 text-black" >
                                    {!! $course->description !!}
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-md-4 pl-3">
                    <div class="row hover-yellow p-2">
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

                    @if(count($materials->media)>0)
                    <div class="col-md-12 my-1">
                        <div class="cursor-pointer  custom-link-primary row justify-content-center align-items-center">
                            <i class=" mr-2 font-18 mdi mdi-image-filter"></i>
                            <a type="button" class="my-1 font-18" data-toggle="modal" data-target="#bs-example-modal-lg">Gallery</a>
                            <div class="modal fade" id="bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myLargeModalLabel">Gallery</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body">

                                            <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
                                                <div class="carousel-inner">
                                                    @foreach($materials->media as $media)
                                                    <div class="carousel-item {{$loop->first?"active":""}}">
                                                        <img class="d-block img-fluid" src="{{url($media->rel_path)}}" alt="First slide">
                                                    </div>
                                                    @endforeach
                                                </div>
                                                <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </div>

                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                        </div>
                    </div>
                    @endempty


                    <ul class="my-2 p-0">
                        @foreach($MaterialsOrderByPriority as $material)
                            <li class="list-group-item list-material  my-2 {{$material->title==$materials->title? "list-material-select border-orange":"border"}}  ">
                                <a class="d-flex align-items-center m"
                                   href="{{route('index.material.show',[$course->slug,$material->slug])}}">

                                    <div class="col-md-2 ">
                                        @if($material->title==$materials->title)
                                            <i style="margin:-8px;" class="  now-play rounded-circle mdi h1 mdi-play-circle-outline"></i>
                                        @else
                                            <div class="col-md-2 mt-1 mr-2 ">
                                                <span style="margin:-20px;" class="material-count"> <span>{{$material->priority}}</span> </span>
                                            </div>

                                        @endif
                                    </div>

                                    <div class="col-md-8 d-flex flex-column  ">
                                        <h3 style="border-radius: 5px"
                                            class="font-18 mt-1 text-black font-weight-bold">   {{$material->title}}</h3>
                                        <span style="word-break: break-all" class="
                                        {{$material->title==$materials->title? "":"custom-link-primary"}}
                                             font-14 text-dark">    {{$material->subtitle}}</span>
                                    </div>

                                    <div class="col-md-2 ">
                                        <span class="">
                                            <i class=" font-24 text-black {{App\Material::find($material->material_id)->type}}"></i>
                                        </span>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>

                </div>
            </div>

        </div>

    </section>

@endsection

@section("script")
    <script src="{{ mix('js/index/materials/indexMaterials.js') }}"></script>



@endsection
