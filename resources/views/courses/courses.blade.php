@extends("layouts.app")

@section("style")

@endsection

@section("content")

    <div class="content-page pt-3 mt-1" style="background:#F7F8FC;">

        <div class="content">
            <div class="container-xl " style="width: 1450px">
                <div class="row">
                    <h3 class="m-2">Μαθήματα</h3>
                    @if(empty(!$arrayTopics))
                        <div class="col-md-12 ">
                            <div id="topic-filter" class="p-2 rounded text-dark"
                            >
                                <div class="container">
                                    <ul data-user-slug="{{auth()->user()->slug}}"
                                        class="d-flex topic-link justify-content-around">
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

                <div class="row my-5 d-flex justify-content-center content-filter">
                    @include("components.index.courses.filter-courses")
                </div>
            </div>
        </div>
    </div>



@endsection


@section("script")
    <x-routes></x-routes>
    <script src="{{ mix('js/index/courses/indexCourses.js') }}"></script>


@endsection


