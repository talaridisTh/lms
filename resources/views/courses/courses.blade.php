@extends("layouts.app")

@section("style")

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
                                <ul data-user-slug="{{auth()->user()->slug}}" class="d-flex topic-link justify-content-around">
                                    <li class="filter-topic"  data-topic-id="reset" >
                                        <a href="#"> <span class="text-light">Ολα</span></a>
                                    </li>

                                    @foreach($arrayTopics as $key => $topic)
                                    <li class="filter-topic "  data-topic-id="{{$key}}">
                                        <a href="#">
                                            <span>{{$topic}}</span>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row my-5 d-flex justify-content-center content-filter">
                    @include("components.index.courses.filter-courses")
                </div>
            </div>
        </div>



@endsection


@section("script")
            <x-routes></x-routes>
            <script src="{{ asset('js/index/courses/indexCourses.js') }}"></script>

            <script>

            </script>

@endsection


