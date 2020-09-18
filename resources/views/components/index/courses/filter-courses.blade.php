<div class="d-flex filter-data flex-wrap w-100">
    @foreach($allCourses as $course)
        @php
            $allMaterial = $course->materials()->orderBy("priority")->wherePivotIn("status",[1])->get()
        @endphp



        <div class="col-md-4 mb-4 ">
            <div class="row mr-3" style="background: white;">
                <div class="col-md-5  p-1">
                    <div class="defalt-color-topic course-box p-1 d-flex flex-column justify-content-between align-items-center"
                         style="background:{{$course->topics->first()->color}}">
                        @foreach($course->topics as $topic)
                            <h4 style="background:{{$topic->color}}" class="defalt-color-topic font-12 box-title">{{$topic->title}}</h4>
                        @endforeach
                        <a href="{{route('index.userCourse',$course->slug)}}">
                            <img height="100" width="100" class="rounded-circle my-3"
                                 src="{{$course->cover=="empty"? "http://lorempixel.com/300/300" : url($course->cover)}}"
                                 alt="courses">
                        </a>
                        {{--                    <p>metrio</p>--}}
                    </div>
                </div>

                <div class="col-md-7 d-flex flex-column justify-content-between align-items-center p-2">
                    <h3 class="font-16 font-weight-bold"><a
                            href="{{route('index.userCourse',[$course->slug,auth()->user()])}}">{{$course->title}}</a>
                    </h3>
                    <p class="font-12 text-center">{{$course->subtitle}}</p>
                    <div class="material-box d-flex justify-content-between font-10">
                        <span class="mr-3">Lessons : {{$allMaterial->where("type","Lesson")->count()}}</span>
                        <span>Extras :{{$allMaterial->where("type","!=","Lesson")->count()}}</span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach</div>
