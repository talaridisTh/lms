@extends("layouts.app")

@section("style")
    <style>
        .left-side-menu {
            display: none;
        }



    </style>
@endsection

@section("content")

    <div class="content-page pt-3 mt-1" style="background:#F7F8FC;">
        <div class="content">
            <div class="container-xl " style="width: 1450px">
                <div class="row">
                    <div class="col-md-12 ">
                        <div id="topic-filter" class="p-2 rounded text-light"
                             style="background-image: linear-gradient(to right, rgb(91, 121, 162) 0%, rgb(46, 68, 105) 100%);">
                            <div class="container">
                                <ul class="d-flex topic-link justify-content-around">
                                    <li><a href="#">Ολα</a></li>
                                    @foreach($arrayTopics as $topic)
                                    <li><a href="#">{{$topic}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row my-5 d-flex justify-content-center">
                    @foreach(auth()->user()->courses as $course)
                        @php($allMaterial = $course->materials()->orderBy("priority")->wherePivotIn("status",[1])->get())
                    @if($allMaterial->where("type","Lesson")->count()  && $allMaterial->where("type","Lesson")->count())
                        <div class="col-md-3">
                            <div class="row" style="background: white;">
                                <div class="col-md-5">
                                    <div
                                        class="course-box p-1 d-flex flex-column justify-content-between align-items-center"
                                        style="background: linear-gradient(0deg,#f19a1a,#ffc73c);">
                                        @foreach($course->topics as $topic)
                                        <h4 class="bghover font-12 box-title">{{$topic->title}}</h4>
                                        @endforeach
                                            <a href="{{route('index.userCourse',$course->id)}}">
                                                <img height="100"
                                                     class="my-2"
                                                     src="https://laracasts.s3.amazonaws.com/series/thumbnails/javascript-techniques-for-server-side-developers.png?v=8"
                                                     alt="courses">
                                            </a>
                                        <p>metrio</p></div>
                                </div>
                                <div class="col-md-7 d-flex flex-column justify-content-between align-items-center p-2">
                                    <h3 class="font-16 font-weight-bold"><a href="{{route('index.userCourse',$course->id)}}">{{$course->title}}</a></h3>
                                    <p class="font-12 text-center">{{$course->description}}</p>
                                    <div class="material-box d-flex justify-content-between font-10">
                                        <span class="mr-3">Lessons : {{$allMaterial->where("type","Lesson")->count()}}</span>
                                        <span>Extrass :{{$allMaterial->where("type","!=","Lesson")->count()}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>


            </div>
        </div>



@endsection


@section("script")
@endsection


