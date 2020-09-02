@extends("layouts.app")

@section("style")
    <style>
        .left-side-menu {
            display: none;
        }

        .box-material-down {
            background: #E0A228;
            border-bottom-right-radius: 15px;
            border-bottom-left-radius: 15px;

        }

        .box-material-up {
            background: #E0A228;
            border-top-right-radius: 15px;
            border-top-left-radius: 15px;
            background: linear-gradient(0deg, #f19a1a, #ffc73c)
        }
        .material-count{
            padding: 8px 14px;
            background: #e7e7e7;
            border-radius: 100%;
        }
        .list-material:hover{

            cursor: pointer;
            background:#E7E7E7;
        }


    </style>
@endsection
@php($count=0)
@section("content")

    <div class="content-page">
        <div class="container-xl my-3" style="width: 1450px">
            <div class="row box-material-up px-5 pt-4 pb-2">
                <div class="col-md-12">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <img height="250"
                                 src="https://laracasts.s3.amazonaws.com/series/thumbnails/svg/html5-video-and-videojs.svg"
                                 alt="">
                        </div>
                        <div class="col-md-6">
                            <h2 class="display-4 text-light">{{$course->title}}</h2>
                            <p class="my-4">{{$course->subtitle}}</p>
                            <div class="button-course-fav">
                                <button class=" mr-2 px-4  btn-begin btn bghover btn" style="background:white">begin
                                </button>
                                <button class="px-4 box-title btn bghover btn-secontary font-weight-bold">add watch
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="box-last-material p-4">
                                <p class="box-num-material display-4">{{$allMaterial->count()}}</p>
                                <div class="last-material font-12 text-light d-flex text-center flex-column mb-4">
                                    <span>Η τελευταία προσθήκη</span>
                                    <span>{{\Carbon\Carbon::parse($lastMaterial->last()->created_at)->diffForHumans()}}</span>
                                </div>
                                <div class="box-button-subtitle text-light text-center">
                                    <p class="font-16">{{$lastMaterial->last()->title}}</p>
                                    <p class="font-12">{{$lastMaterial->last()->subtitle}}</p>
                                    <button class="bghover border font-weight-bold btn btn-secontary">
                                        <a href="{{route('index.material.show',[$course->id,$lastMaterial->last()->slug])}}">Δες το μαθημα</a>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row p-2 box-material-down">
                <div class="col-md-5  d-flex justify-content-between text-light">
                    <span>metrio</span>
                    <span><i class="mdi mdi-book-open-page-variant"></i> {{$allMaterial->where("type","Lesson")->count()}} Μαθήματα  </span>
                    <span><i class="mdi mdi-book-open-page-variant"></i> {{$allMaterial->where("type","!=","Lesson")->count()}} Extra  </span>
                    @foreach($topics as $topic)
                        <span class="bghover font-weight-bold border px-2">{{$topic}}</span>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row background-material">
                <div class="col-md-12">
                    <div class="row justify-content-between p-3">
                        <div class="col-md-6"><span class="font-weight-bold text-black">Εισηγητής </span>|
                            {{$course->curator->first_name}}
                        </div>
                        <div class="col-md-6 text-right">
                            <i class="mdi cursor-pointer h3 mdi-facebook"></i>
                            <i class="mdi cursor-pointer h3 mdi-instagram"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-12  p-2">
                    <div class="row">
                        <div class="col-md-2"><img height="80" width="80" class="rounded-circle"
                                                   src="  {{$course->curator->avatar}}"
                                                   alt=""></div>
                        <div class="col-md-10 text-black d-flex flex-column justify-content-center ">
                            <h4>Πληροφορίες </h4>
                            <p> {{$course->curator->profil}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="container my-3">
            <div class="row ">
                <div class="col-md-12 px-5">
                    <ul>
                    @foreach($allMaterial as $materials)
                        <li class="list-group-item list-material border py-4 ">
                            <a class="d-flex" href="{{route('index.material.show',[$course->id,$materials->slug])}}">
                            <div class="col-md-2">
                                <span class="material-count">{{++$count}}</span>
                            </div>
                            <div class="col-md-10 d-flex flex-column">
                                <span class="mb-2 font-18 text-dark font-weight-bold">   {{$materials->title}}</span>
                                <span class="mb-2 font-14 text-dark">   {{$materials->subtitle}}</span>
                                <span class="mb-2 font-14 text-dark">   {{$materials->type}}</span>
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

    <script>


    </script>
@endsection
