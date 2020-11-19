<div class="d-flex filter-data flex-wrap w-100">
    @foreach($allCourses as $course)
        @php

        //countMaterial
            $allMaterial = $course->materials()->where("type","Section")->wherePivot("status",1)->get()->map(function ($material){
                return  $material->chapters->where("type","Lesson")->map(function ($chapter){
                        if($chapter->getOriginal('pivot_status')==1){
                            return $chapter;
                        }
                })->reject(function ($name) {
                return empty($name);
            });
            })->flatten()->count()+$course->materials()
            ->where("type","Lesson")
            ->wherePivot("status",1)->count();

            //extraMaterial
            $extraMaterial = $course->materials()->where("type","Section")->wherePivot("status",1)->get()->map(function ($material){
                return  $material->chapters->where("type","!=","Lesson")->where("type","!=","Announcement")->map(function ($chapter){
                        if($chapter->getOriginal('pivot_status')==1){
                            return $chapter;
                        }
                })->reject(function ($name) {
                return empty($name);
            });
            })->flatten()->count()+$course->materials()
            ->where("type","!=","Lesson")
            ->where("type","!=","Announcement")
            ->where("type","!=","Section")
            ->wherePivot("status",1)->count();




        $bgColor = $course->topics->count() > 0 ? $course->topics->first()->color : "";
        @endphp


        <div class="col-md-4 mb-4 card-cnt ">
            <div class="row mr-3" style="background: white;">
                <div class="col-md-3  p-1">
                    <div
                        class="defalt-color-topic course-box p-1 d-flex flex-column justify-content-between align-items-center"
                        style="background:{{$bgColor}} ; height: 220px">
                        @forelse($course->topics as $topic)
                            <h4 style="background:{{$topic->color}} "
                                class="color-topic-second  font-12 box-title">{{$topic->title}}</h4>
                        @empty
                            <div></div>
                        @endforelse
                        <a href="{{route('index.userCourse',$course->slug)}}">
                            @if($course->cover)
                                <img  class="rounded-circle my-3"
                                     src="{{$course->roundedSmallCoverUrl()}}"
                                     alt="courses">
                            @endif
                        </a>
                    </div>
                </div>

                <div class="col-md-9 d-flex flex-column justify-content-between align-items-center p-2 ">
                    <h3 class="font-16 font-weight-bold mb-0"><a
                            href="{{route('index.userCourse',[$course->slug])}}">{!!$course->title  !!}</a>
                    </h3>
                    <p class="font-12 text-left w-75">{{\Str::limit($course->subtitle,150,"...")}}</p>
                    <div class="material-box d-flex justify-content-between font-10 card-info">
                        <span class="mr-3 all-material">Μαθήματα : {{$allMaterial}}</span>
                        <span class="all-extra-material">Βοηθητικά Αρχεία :{{$extraMaterial}}</span>
                    </div>
                    <button class="btn  w-75  btn-outline-custom-info card-play"><i class="mr-1 font-18 mdi mdi-play-circle-outline">

                        </i><span class=" font-18">play</span>
                    </button>
                </div>

            </div>
        </div>
    @endforeach
</div>
