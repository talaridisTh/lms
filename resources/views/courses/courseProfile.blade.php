@extends("layouts.app")

@section("style")




    <style>
        .left-side-menu {
            display: none;
        }

        .box-material-down {
            background: linear-gradient(315deg, #ff4e00 0%, #ec8505 74%);
            border-top: 1px solid white;
            border-bottom-right-radius: 15px;
            border-bottom-left-radius: 15px;

        }

        .box-material-up {
            background: #E0A228;
            border-top-right-radius: 15px;
            border-top-left-radius: 15px;
            background-image: linear-gradient(315deg, #ff4e00 0%, #ec8505 74%)

        }

        .material-count {
            padding: 8px 14px;
            background: #e7e7e7;
            border-radius: 100%;
        }

        .list-material:hover {

            cursor: pointer;
            background: rgba(231, 231, 231, 0.51);
        }

        .list-material {
            border-radius: 5px;
            background: rgba(231, 231, 231, 0.2);
            margin-bottom: 10px;
        }

        .material-count:hover {
            color: rgba(231, 231, 231, 0.2);
            background: rgba(231, 231, 231, 0.2)

        }

        .ribbon-edit:hover {
            text-decoration: underline;
        }


    </style>
@endsection
@php($count=0)
@section("content")

    <div class="content-page">
        @role("admin")

        <div class="card ribbon-box" style="background-color: #FAFBFE">
            <div class="card-body py-0">
                <div class="ribbon ribbon-secondary float-right"><i class="mdi mdi-access-point mr-1"></i>
                    <a class="text-white ribbon-edit" href="{{route('course.show',$course->slug)}}">
                        <spant class="ribbon-edit">Edit this page</spant>
                    </a>
                </div>
            </div> <!-- end card-body -->
        </div>
        @endrole
        <div class="container-xl my-3" style="max-width: 1650px">
            <div class="row box-material-up px-5 pt-4 pb-2">
                <div class="col-md-12">
                    <div class="row align-items-center">
                        <div class="col-md-3 mb-2">
                            <img height="300" width="300" class="  rounded-circle"
                                 src="{{$course->cover=="empty"? "http://lorempixel.com/300/300":url($course->cover)}}"
                                 alt="course-logo"
                            >
                        </div>


                        <div class="col-md-6">
                            <h2 class="display-4 text-light">{{$course->title}}</h2>
                            <p class="text-light my-4">{{$course->subtitle}}</p>
                            <div class="button-course-fav">
                                @if(count($allMaterial))
                                    <a href="{{route('index.material.show',[$course->slug,$allMaterial->first()->slug])}}"
                                       class=" mr-2 px-4  btn-begin btn bghover btn" style="background:white">Έναρξη
                                    </a>
                                @endif
                                <button
                                    data-model="course" data-model-id="{{$course->id}}" data-user-id="{{auth()->id()}}"
                                    class="add-watchlist box-watchlist px-3 box-title btn bghover btn-secontary font-weight-bold">
                                    <i class="font-16
                                     {{!count(auth()->user()->watchlistCourse->whereIn("title",$course->title))?"mdi mdi-heart-outline":"mdi mdi-cards-heart"}}
                                        ">


                                    </i> <span>Προσθήκη στα αγαπημένα</span>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="box-last-material p-2 ">
                                <p class="box-num-material display-4"><span>{{$allMaterial->count()}}</span></p>
                                <div class="last-material font-12 text-light d-flex text-center flex-column mb-4">
                                    <span>Η τελευταία προσθήκη</span>
                                    @if(count($allMaterial))
                                        <span>{{\Carbon\Carbon::parse($lastMaterial->last()->created_at)->diffForHumans()}}</span>

                                </div>
                                <div class="box-button-subtitle text-light text-center">
                                    <p class="font-16">{{$lastMaterial->last()->title}}</p>
                                    <p class="font-12">{{$lastMaterial->last()->subtitle}}</p>

                                    <button class="bghover  border font-weight-bold btn btn-secontary ">
                                        <a class="text-white bghover"
                                           href="{{route('index.material.show',[$course->slug,$lastMaterial->last()->slug])}}">
                                            Δες το μάθημα</a>
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row p-2 box-material-down">
                <div class="col-md-4  d-flex justify-content-between text-light">
                    {{--                    <span>metrio</span>--}}

                    <span><i class="mdi mdi-book-open-page-variant"></i> {{$allMaterial->where("type","mdi mdi-file-document-outline")->count()}} Μαθήματα  </span>
                    <span><i class="mdi mdi-book-open-page-variant"></i> {{$allMaterial->where("type","!=","mdi mdi-file-document-outline")->count()}} Extra  </span>
                    @foreach($topics as $topic)
                        <span class="topic-title font-weight-bold border px-2">{{$topic}}</span>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="container" style="max-width: 1250px">
            <div class="row background-material">
                <div class="col-md-12">
                    <div class="row justify-content-between px-3 py-2">
                        <div class="col-md-6"><span class="font-weight-bold text-black">Εισηγητής </span>|
                            {{$course->curator->first_name}}
                        </div>
                        <div class="col-md-6 text-right">
                            <i class="mdi cursor-pointer h3 mdi-facebook"></i>
                            <i class="mdi cursor-pointer h3 mdi-instagram"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 ">
                    <div class="row mb-1">
                        <div class="col-md-2 pt-2 text-center">
                            <img height="80" width="80" class="img-fluid img-thumbnail rounded-circle"
                                 src="  {{$course->curator->cover}}"
                                 alt=""></div>
                        <div class="col-md-10 text-black d-flex flex-column justify-content-center ">
                            <div class="row">
                                <div class="col-md-9">
                                    <h4>Πληροφορίες </h4>
                                    <p> {{$course->curator->profil}}
                                    </p>
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="container-fluid my-3" style="max-width: 1250px">
            <div class="row ">

                <div class="col-md-8 {{empty($course->description)?"d-none":""}}">
                    {!! $course->description !!}
                </div>
                <div class=" {{!empty($course->description)?"col-md-4":"offset-2 col-md-8 offset-2  text-left" }}">
                    <ul class="m-0 p-0">
                        @foreach($allMaterial as $materials)
                            <li class="list-group-item list-material border   ">
                                <a class="d-flex align-items-center m"
                                   href="{{route('index.material.show',[$course->slug,$materials->slug])}}">
                                    <div class="col-md-2 ">
                                        <span class="material-count">{{++$count}}</span>
                                    </div>
                                    <div class="col-md-8 d-flex flex-column  ">
                                        <h3
                                            class=" font-18 text-dark font-weight-bold">   {{$materials->title}}</h3>
                                        <span style="word-break: break-all"
                                              class=" font-14 text-dark">    {{$materials->subtitle}}</span>
{{--                                        @empty($course->description)--}}
{{--                                            <div class="mt-3">--}}
{{--                                            <h3--}}
{{--                                                class=" font-16 text-dark font-weight-bold">   {{$materials->title}}</h3>--}}
{{--                                            <span style="word-break: break-all"--}}
{{--                                                  class="  font-14 text-dark">{{Str::limit($materials->description,200)}}</span>--}}
{{--                                            </div>--}}
{{--                                        @endempty--}}
                                    </div>
                                    <div class="col-md-2 ">
                                        <span class="badge badge-primary-lighten">
                                            <i class=" font-24 text-black {{$materials->type}}"></i>
                                        </span>
                                    </div>
                                </a>
                            </li>
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

