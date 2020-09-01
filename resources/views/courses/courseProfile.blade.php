
@extends("layouts.app")

@section("style")
    <style>
        .left-side-menu {
            display: none;
        }
        .box-material-down{
            background:#E0A228;
            border-bottom-right-radius: 15px;
            border-bottom-left-radius: 15px;

        }
        .box-material-up{
            background:#E0A228;
            border-top-right-radius: 15px;
            border-top-left-radius: 15px;
            background: linear-gradient(0deg, #f19a1a, #ffc73c)
        }


    </style>
@endsection

@section("content")

<div class="content-page">
    <div class="container-xl my-3" style="width: 1450px">
        <div class="row box-material-up px-5 pt-4 pb-2">
            <div class="col-md-12">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <img  height="250" src="https://laracasts.s3.amazonaws.com/series/thumbnails/svg/html5-video-and-videojs.svg" alt="">
                    </div>
                    <div class="col-md-6">
                        <h2 class="display-4 text-light">{{$course->title}}</h2>
                        <p class="my-4">{{$course->subtitle}}</p>
                        <div class="button-course-fav">
                            <button class=" mr-2 px-4  btn-begin btn bghover btn"style="background:white">begin</button>
                            <button class="px-4 box-title btn bghover btn-secontary font-weight-bold">add watch</button>
                        </div>
                    </div>
                    <div class="col-md-3" >
                        <div class="box-last-material p-4">
                            <p class="box-num-material display-4" >{{$course->materials->where("status",1)->count()}}</p>
                            <div class="last-material font-12 text-light d-flex text-center flex-column mb-4">
                                <span>Η τελευταία προσθήκη</span>
                                <span>{{\Carbon\Carbon::parse($lastMaterial->created_at)->diffForHumans()}}</span>
                            </div>
                            <div class="box-button-subtitle text-light text-center">
                                <p class="font-16">{{$lastMaterial->title}}</p>
                                <p class="font-12">{{$lastMaterial->subtitle}}</p>
                                <button class="bghover border font-weight-bold btn btn-secontary">Δες το μαθημα</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-2 box-material-down">
            <div class="col-md-4  d-flex justify-content-between" >
                <span>metrio</span>
                <span><i class="mdi mdi-book-open-page-variant"></i> {{$course->materials->where("status",1)->count()}} Μαθήματα  </span>
                @foreach($topics as $topic)
                <span class="bghover font-weight-bold border px-2">{{$topic}}</span>
                @endforeach
            </div>

        </div>

    </div>
</div>

@endsection


@section("script")

<script>


</script>
@endsection
