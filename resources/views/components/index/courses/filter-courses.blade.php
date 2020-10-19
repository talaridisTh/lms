<div class="d-flex filter-data flex-wrap w-100">
    @foreach($allCourses as $course)
        @php
            $allMaterial = $course->materials()->orderBy("priority")->wherePivotIn("status",[1])->get();
            $bgColor = !empty($course->topics)>0? $course->topics->first()->color:"";;
        @endphp



        <div class="col-md-4 mb-4 ">
            <div class="row mr-3" style="background: white;">
                <div class="col-md-4  p-1">
                    <div class="defalt-color-topic course-box p-1 d-flex flex-column justify-content-between align-items-center"
                         style="background:{{$bgColor}}">
                        @foreach($course->topics as $topic)
                            <h4 style="background:{{$topic->color}} " class="color-topic-second  font-12 box-title">{{$topic->title}}</h4>
                        @endforeach
                        <a href="{{route('index.userCourse',$course->slug)}}">
                            @if($course->cover)
                            <img style=" object-fit: cover;" height="100" width="100" class="rounded-circle my-3"
                                 src="{{$course->cover}}"
                                 alt="courses">
                            @endif
                        </a>
                    </div>
                </div>

                <div class="col-md-8 d-flex flex-column justify-content-between align-items-center p-2">
                    <h3 class="font-16 font-weight-bold"><a
                            href="{{route('index.userCourse',[$course->slug])}}">{!!$course->title  !!}</a>
                    </h3>
                    <p class="font-12 text-center">{!! $course->subtitle !!}</p>
                    <div class="material-box d-flex justify-content-between font-10">
{{--                        <span class="mr-3">Μαθήματα : {{$allMaterial->where("type","Lesson")->count()}}</span>--}}
{{--                        <span>Βοηθητικά Αρχεία :{{$allMaterial->where("type","!=","Lesson")->count()}}</span>--}}
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
