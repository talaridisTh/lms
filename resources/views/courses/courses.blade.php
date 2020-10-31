@extends("layouts.app")

@section("style")

@endsection
@php
    $allMaterial = 0;
    $extraMaterial = 0;
@endphp
@foreach($allCourses as $course)
    @php
        //countMaterial
            $allMaterial += $course->materials()->where("type","Section")->wherePivot("status",1)->get()->map(function ($material){
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
            $extraMaterial += $course->materials()->where("type","Section")->wherePivot("status",1)->get()->map(function ($material){
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
    @endphp
@endforeach

@section("content")
    <div class="container-xl mb-3 mt-2" style="max-width: 1600px"> <!-- container banner -->

        <div class="row defalt-color-topic box-material-up  pt-4 pb-2" style="background:linear-gradient(315deg, rgb(255, 78, 0) 0%, rgb(236, 133, 5) 75%)"> <!-- row top banner -->
            <div class="col-md-12">
                <div class="row align-items-center text-center justify-content-center ">
                    <div class="col-md-6 mb-md-4 col-lg-4 col-xl-6">
                        <h2 class="display-4 text-light">Title of Course 2</h2>
                        <p class="text-light my-4 text-left">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda doloremque dolorum explicabo ipsa maxime tenetur voluptatem? Blanditiis cupiditate doloremque, excepturi inventore magni pariatur quibusdam quidem suscipit. Aliquid incidunt ipsum sunt?</p>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-xl-12 border-top  px-md-5 d-flex bg-opacity  justify-content-between text-light">
                @if(empty(!$arrayTopics))
                    <div class="col-md-12 ">
                        <div id="topic-filter" class=" rounded text-dark">
                            <div class="container">
                                <ul data-user-slug="{{auth()->user()->slug}}"
                                    class="d-flex topic-link justify-content-around p-2 my-auto">
                                    <li class="filter-topic" data-topic-id="reset">
                                        <a href="#"> <span class="text-dark">Όλα </span></a>
                                    </li>

                                    @foreach($arrayTopics as $key => $topic)
                                        <li class="filter-topic " data-topic-id="{{$key}}">
                                            <a href="#">
                                                <span>{{$topic}}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>
                    </div>
                @else
                    <h2>
                        Δεν υπάρχουν Courses
                    </h2>
                @endif
            </div>
        </div> <!-- end row top banner -->




    </div>
    <div class="container-xl " style="width: 1450px ; ">
        <div class="row cnt-count-material "></div>

        <div class="row my-5 d-flex justify-content-center content-filter">
            @include("components.index.courses.filter-courses")
        </div>
    </div>





@endsection


@section("script")
    <x-routes></x-routes>
    <script src="{{ mix('js/index/courses/indexCourses.js') }}"></script>


@endsection


