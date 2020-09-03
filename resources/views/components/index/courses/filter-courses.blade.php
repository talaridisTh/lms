<div class="d-flex filter-data flex-wrap w-100">
    @foreach($allCourses as $course)
        @php($allMaterial = $course->materials()->orderBy("priority")->wherePivotIn("status",[1])->get())
        @if($allMaterial->where("type","Lesson")->count()  && $allMaterial->where("type","Lesson")->count())
            <div class="col-md-4 mb-3">
                <div class="row" style="background: white;">
                    <div class="col-md-5  p-1">
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
                        <h3 class="font-16 font-weight-bold"><a
                                href="{{route('index.userCourse',$course->id)}}">{{$course->title}}</a></h3>
                        <p class="font-12 text-center">{{$course->subtitle}}</p>
                        <div class="material-box d-flex justify-content-between font-10">
                            <span class="mr-3">Lessons : {{$allMaterial->where("type","Lesson")->count()}}</span>
                            <span>Extrass :{{$allMaterial->where("type","!=","Lesson")->count()}}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach</div>
